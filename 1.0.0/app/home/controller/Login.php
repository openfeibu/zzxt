<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\home\controller;

use think\Db;
use think\captcha\Captcha;
use think\Validate;
use app\admin\model\Data;

class Login extends Base
{
    public function index()
    {
	    if(session('hid')){
			if($this->user['user_status']){
				$this->redirect(__ROOT__."/");
			}else{
				return $this->view->fetch('user:active');
			}
	    }else{
			return $this->view->fetch('user:login');
	    }
	}
	//验证码
	public function verify()
    {
        if (session('hid')) {
            $this->redirect(__ROOT__."/");
        }
		ob_end_clean();
		$verify = new Captcha (config('verify'));
		return $verify->entry('hid');
    }
	/*
     * 退出登录
     */
	public function logout()
    {
		session('hid',null);
		session('user',null);
		cookie('yf_logged_user',null);
		$this->redirect(__ROOT__."/");
	}

    //登录验证
    public function runlogin()
    {
		$member_list_username=input('member_list_username');
		$member_list_pwd=input('member_list_pwd');
		if (empty($member_list_username) || empty($member_list_pwd)) {
		    $this->error('账号密码不能为空');
        }
		$remember=input('remember',0,'intval');
		//验证码注释
//		$verify =new Captcha ();
//		if (!$verify->check(input('verify'), 'hid')) {
//			$this->error(lang('verifiy incorrect'));
//		}
		$rule = [
			['member_list_username','require','{%username empty}'],
			['member_list_pwd','require','{%pwd empty}'],
		];
		$validate = new Validate($rule);
		$rst   = $validate->check(array('member_list_username'=>$member_list_username,'member_list_pwd'=>$member_list_pwd));
		if(true !==$rst){
			$this->error(join('|',$validate->getError()));
		}
		if(strpos($member_list_username,"@")>0){//邮箱登陆
            $where['member_list_email']=$member_list_username;
        }else{
            $where['id_number']=$member_list_username;
        }
		$member=Db::name("member_list")->where($where)->find();
		if(!$member)
		{
			$dataclass = new Data();
			$result = $dataclass->getUserByIdCard($member_list_username);
			if(empty($result))
			{
				$this->error(lang('username or pwd incorrect'));//账号密码不正确
			}else{
				$user_fields = config('user_fields'); 
				$school_user = array();
				foreach($user_fields as $key => $val)
				{
					$school_user[$key] = isset($result[$val]) ? rtrim($result[$val]) : '' ;
				}
				if(isset($school_user['birthday']) && !empty($school_user['birthday'])){
					$school_user['birthday'] = date('Ymd',strtotime($school_user['birthday']));
				}
				if(isset($school_user['admission_date']) && !empty($school_user['admission_date'])){
					$school_user['admission_date'] = date('Ymd',strtotime($school_user['admission_date']));
				}
				
				$password = substr($member_list_username,-6);
				$member_list_salt=random(10);
				
				$sl_data=array(
					'member_list_username' => $school_user['studentid'],
					'member_list_nickname' => $school_user['studentname'],
					'member_list_salt' => $member_list_salt,
					'member_list_pwd'=>encrypt_password($password,$member_list_salt),
					'member_list_groupid'=>1,
					'member_list_open'=>1,
					'member_list_addtime'=>time(),
					'user_status'=>1,
					'id_number' => $member_list_username,
				);
	
				$users_model=Db::name("member_list");
				$rst=$users_model->insertGetId($sl_data);
				if($rst!==false){
					//更新字段
					$data = array(
						'last_login_time' => time(),
						'last_login_ip' => request()->ip(),
					);
					$sl_data['last_login_time']=$data['last_login_time'];
					$sl_data['last_login_ip']=$data['last_login_ip'];
					$users_model->where(array('member_list_id'=>$rst))->update($data);
					
					session('hid',$rst);
					session('user',$sl_data);
					$rst1 = Db::name('user')->insert($school_user);
					$this->success('登录成功',url('home/Index/index'));
					
				}else{
					$this->error('登录失败，请联系管理员');
				}
			}
		}
		if (!$member||encrypt_password($member_list_pwd,$member['member_list_salt'])!==$member['member_list_pwd']){
            $this->error(lang('username or pwd incorrect'));//账号密码不正确
		}else{
			
			//更新字段
			$data = array(
				'last_login_time' => time(),
				'last_login_ip' => request()->ip(),
			);
			Db::name("member_list")->where(array('member_list_id'=>$member["member_list_id"]))->update($data);
			session('hid',$member['member_list_id']);
			session('user',$member);
			if($remember && $member['user_status']){
				//更新cookie
				cookie('yf_logged_user', jiami("{$member['member_list_id']}.{$data['last_login_time']}"));
			}
			/*
			//根据需要决定是否同步后台登录状态
			$admin=Db::name('admin')->where('member_id',$member['member_list_id'])->find();
			if($admin){
                // 记录登录
                $auth = array(
                    'aid'             			 => $admin['admin_id'],
                    'admin_avatar'    			 => $admin['admin_avatar'],
                    'admin_last_change_pwd_time' => $admin['admin_changepwd'],
                    'admin_realname'       		 => $admin['admin_realname'],
                    'admin_username'          	 => $admin['admin_username'],
                    'member_id'        			 => $admin['member_id'],
                    'admin_last_ip' 			 => $admin['admin_last_ip'],
                    'admin_last_time'   		 => $admin['admin_last_time']
                );
                session('admin_auth', $auth);
                session('admin_auth_sign', data_signature($auth));
			}
			*/
			$this->success('登录成功',url('home/Login/check_active'));
		}
    }
    public function forgot_pwd()
    {
		return $this->view->fetch('user:forgot_pwd');
	}
	//验证码
	public function verify_forgot()
    {
        if (session('hid')) {
            $this->redirect(__ROOT__."/");
        }
		ob_end_clean();
		$verify = new Captcha (config('verify'));
		return $verify->entry('forgot');
    }
    public function runforgot_pwd()
    {
		if(request()->isPost()){
			$member_list_email=input('member_list_email');
			$member_list_username=input('member_list_username');
			$verify =new Captcha ();
			if (!$verify->check(input('verify'), 'forgot')) {
				$this->error(lang('verifiy incorrect'));
			}
			$rule = [
				['member_list_email','require|email','{%email empty}|{%email format incorrect}'],
				['member_list_username','require','{%username empty}'],
			];
			$validate = new Validate($rule);
			$rst   = $validate->check(array('member_list_email'=>$member_list_email,'member_list_username'=>$member_list_username));
			if(true !==$rst){
				$this->error(join('|',$validate->getError()));
			}
			$find_user=Db::name("member_list")->where(array("member_list_username"=>$member_list_username))->find();
			if($find_user){
				if(empty($find_user['member_list_email'])){
					//先更新字段邮箱
					Db::name("member_list")->where(array("member_list_username"=>$member_list_username))->setField('member_list_email',$member_list_email);
					$find_user['member_list_email']=$member_list_email;
				}
				if($find_user['member_list_email']==$member_list_email){
					//发送重置密码邮件
					$activekey=md5($find_user['member_list_id'].time().uniqid());//激活码
					$result=Db::name("member_list")->where(array("member_list_id"=>$find_user['member_list_id']))->update(array("user_activation_key"=>$activekey));
					if(!$result){
						$this->error(lang('activation code generation failed'));
					}
					//生成重置链接
					$url = url('home/Login/pwd_reset',array("hash"=>$activekey), "", true);
					$template = lang('emal text').
								<<<hello
								<a href="http://#link#">http://#link#</a>
hello;
					$content = str_replace(array('http://#link#','#username#'), array($url,$member_list_username),$template);
					$send_result=sendMail($member_list_email, 'YFCMF '.lang('pwd reset'), $content);
					if($send_result['error']){
						$this->error(lang('send pwd reset email failed'));
					}else{
						$this->success(lang('send pwd reset email success'),url('home/Index/index'));
					}
				}else{
					$this->error(lang('email not the same as registered email'));
				}
			}else {
				$this->error(lang('member not exist'));
			}
		}
	}
    public function pwd_reset()
    {
	    $hash=input("get.hash");
	    $find_user=Db::name("member_list")->where(array("user_activation_key"=>$hash))->find();
	    if (empty($find_user)){
	        $this->error(lang('pwd reset hash incorrect'),url('home/Index/index'));
	    }else{
			$this->assign("hash",$hash);
			return $this->view->fetch('user:pwd_reset');
	    }
	}
	//验证码
	public function verify_reset()
    {
        if (session('hid')) {
            $this->redirect(__ROOT__."/");
        }
		ob_end_clean();
		$verify = new Captcha (config('verify'));
		return $verify->entry('pwd_reset');
    }
    public function runpwd_reset()
    {
		if(request()->isPost()){
			$verify =new Captcha();
			if (!$verify->check(input('verify'), 'pwd_reset')) {
				$this->error(lang('verifiy incorrect'));
			}
			$rule = [
				['password','require|length:5,20','{%pwd empty}|{%pwd length}'],
				['repassword','require|confirm:password','{%repassword empty}|{%repassword incorrect}'],
				['hash','require','{%pwd reset hash empty}'],
			];
			$validate = new Validate($rule);
			$rst= $validate->check(array('password'=>input('password'),'hash'=>input('hash'),'repassword'=>input('repassword')));
			if(true !==$rst){
				$this->error(join('|',$validate->getError()));
			}else{
				$password=input('password');
				$hash=input('hash');
				$member_list_salt=random(10);
				$member_list_pwd=encrypt_password($password,$member_list_salt);
				$result=Db::name("member_list")->where(array("user_activation_key"=>$hash))->update(array('member_list_pwd'=>$member_list_pwd,'user_activation_key'=>'','member_list_salt'=>$member_list_salt));
				if($result){
					$this->success(lang('pwd reset success'),url("home/Login/index"));
				}else {
					$this->error(lang('pwd reset failed'));
				}
			}
		}
	}
    public function check_active()
    {
		$this->check_login();
		//if($this->user['user_status']){
			$this->redirect("/home/student/examinestatus");
		// }else{
		// 	//判断是否激活
		// 	return $this->view->fetch('user:active');
		// }
	}
	//重发激活邮件
    public function resend()
    {
		$this->check_login();
		$current_user=$this->user;
		if($current_user['user_status']==0){
			if($current_user['member_list_email']){
				$active_options=get_active_options();
				$activekey=md5($current_user['member_list_id'].time().uniqid());//激活码
				$result=Db::name('member_list')->where(array("member_list_id"=>$current_user['member_list_id']))->update(array("user_activation_key"=>$activekey));
				if(!$result){
					$this->error(lang('activation code generation failed'));
				}
				//生成激活链接
				$url = url('home/Register/active',array("hash"=>$activekey), "", true);
				$template = $active_options['email_tpl'];
				$content = str_replace(array('http://#link#','#username#'), array($url,$current_user['member_list_username']),$template);
				$send_result=sendMail($current_user['member_list_email'], $active_options['email_title'], $content);
				if($send_result['error']){
					$this->error(lang('send active email failed'));
				}else{
					$this->success(lang('send active email success'),url('home/Login/index'));
				}
			}else{
				$this->error(lang('no registered email'),url('home/Login/index'));
			}
		}else{
		    $this->error(lang('activated'),url('home/Index/index'));
		}
	}

}
