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
use app\admin\model\DataOracle;
use app\admin\model\MemberList as MemberListModel;

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
		
		$dataclass = new Data();
		$data_oracle = new DataOracle();
		if(!$member)
		{
			$result = $dataclass->getUserByIdCard($member_list_username);
			if(empty($result))
			{
				$this->error('账号不存在');//账号密码不正确
			}else{
				$school_user = MemberListModel::handleSourceUser($result);
				
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
					'user_status'=> 0,
					'id_number' => $member_list_username,
				);
				
				$xh = $school_user['studentid'];
				$xh_unfulll = substr($xh,-9);
				$where = " WHERE XH = '".$xh."' OR LOWER(SFZH) = LOWER('".$member_list_username."') OR XH = '".$xh_unfulll."' ";
				$data_oracle = new DataOracle();
				$new_student = $data_oracle->getStudent($where);
				if(!$new_student)	
				{
					$this->error('账号不存在');
				}
				$member_model=Db::name("member_list");
				$rst=$member_model->insertGetId($sl_data);
				if($rst!==false){
					//更新字段
					$data = array(
						'last_login_time' => time(),
						'last_login_ip' => request()->ip(),
					);
					$sl_data['last_login_time']=$data['last_login_time'];
					$sl_data['last_login_ip']=$data['last_login_ip'];
					$member_model->where(array('member_list_id'=>$rst))->update($data);
					
					session('hid',$rst);
					session('user',$sl_data);

					$school_user['profession'] = $new_student['profession'] ;
					$school_user['department_name'] = $new_student['department_name'] ;
					$school_user['class_name'] = $new_student['class_name'] ;
					$school_user['class_number'] = $new_student['class_number'] ;
					$school_user['faculty_number'] = get_faculty_number_by_dwh($new_student['dwh']);
					$rst1 = Db::name('user')->insert($school_user);
					$this->success('登录成功',url('home/Index/index'));
					
				}else{
					$this->error('登录失败，请联系管理员');
				}
			}
		}
		if (!$member||(encrypt_password(strtolower($member_list_pwd),$member['member_list_salt'])!==$member['member_list_pwd'] && encrypt_password(strtoupper($member_list_pwd),$member['member_list_salt'])!==$member['member_list_pwd'])){
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
			$user = DB::name('user')->where('id_number',$member['id_number'])->find();
			$result = $dataclass->getUserByIdCard($member_list_username);
			if(!$user)
			{
				$school_user = MemberListModel::handleSourceUser($result);
				$xh = $school_user['studentid'];
				$xh_unfulll = substr($xh,-9);
				$where = " WHERE XH = '".$xh."' OR LOWER(SFZH) = LOWER('".$member_list_username."') OR XH = '".$xh_unfulll."' ";
				$data_oracle = new DataOracle();
				$new_student = $data_oracle->getStudent($where);
				if($new_student)
				{
					$school_user['profession'] = $new_student['profession'] ;
					$school_user['department_name'] = $new_student['department_name'] ;
					$school_user['class_name'] = $new_student['class_name'] ;
					$school_user['class_number'] = $new_student['class_number'] ;
					$school_user['faculty_number'] = get_faculty_number_by_dwh($new_student['dwh']);
				}
				$rst1 = Db::name('user')->insert($school_user);
			}
			if($remember && $member['user_status']){
				//更新cookie
				cookie('yf_logged_user', jiami("{$member['member_list_id']}.{$data['last_login_time']}"));
			}
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
		$email = input('email','');
		$rule = [
				['email','require|email','{%email empty}|{%email format incorrect}'],
		];
		$validate = new Validate($rule);
		$rst   = $validate->check(array(
			'email' => $email,
		));
	
		if(true !==$rst){
			$this->error($validate->getError());
		}
		$users_model=Db::name("member_list");

		// $verify =new Captcha ();
		// if (!$verify->check(input('verify'), 'forgot')) {
			// $this->error(lang('verifiy incorrect'));
		// }
		$member_list_email = $email;
		$find_user=Db::name("member_list")->where(array("member_list_email"=>$member_list_email))->find();
		if($find_user){
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
			$content = str_replace(array('http://#link#','#username#'), array($url,$find_user['member_list_nickname']),$template);
			$send_result=sendMail($member_list_email, lang('pwd reset'), $content);
			if($send_result['error']){
				$this->error(lang('send pwd reset email failed'));
			}else{
				$this->success(lang('send pwd reset email success'),url('home/Index/index'));
			}
			
		}else {
			$this->error(lang('member not exist'));
		}
		
	}
    public function pwd_reset()
    {
	    $hash=trim(input("hash"));
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
			// $verify =new Captcha();
			// if (!$verify->check(input('verify'), 'pwd_reset')) {
				// $this->error(lang('verifiy incorrect'));
			// }
			$rule = [
				['password','require|length:5,20','{%pwd empty}|{%pwd length}'],
				['repassword','require|confirm:password','{%repassword empty}|{%repassword incorrect}'],
				['hash','require','{%pwd reset hash empty}'],
			];
			$validate = new Validate($rule);
			$rst= $validate->check(array('password'=>input('password'),'hash'=>input('hash'),'repassword'=>input('repassword')));
			if(true !==$rst){
				$this->error($validate->getError());
			}else{
				$password=input('password');
				$hash=input('hash');
				$member_list_salt=random(10);
				$member_list_pwd=encrypt_password($password,$member_list_salt);
				$result=Db::name("member_list")->where(array("user_activation_key"=>$hash))->update(array('member_list_pwd'=>$member_list_pwd,'user_activation_key'=>'','member_list_salt'=>$member_list_salt));
				if($result){
					$this->success(lang('pwd reset success'),url("home/Index/index"));
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
		//}else{
			//判断是否激活
			//return $this->view->fetch('user:active');
		//}
	}
	public function resend()
	{
		$this->check_login();
		$current_user=$this->user;
		//$email = $this->user['member_list_email'];
		$email = input('email','');
		$rule = [
				['email','require|email','{%email empty}|{%email format incorrect}'],
		];
		$validate = new Validate($rule);
		$rst   = $validate->check(array(
			'email' => $email,
		));
	
		if(true !==$rst){
			$this->error($validate->getError());
		}
		$users_model=Db::name("member_list");
		$is_email = $users_model->where(array('member_list_email' => $email,'user_status' =>1))->find();
		if($is_email)
		{
			$this->error('该邮箱已被验证，请换个邮箱激活或联系管理员');
		}
		$users_model->where(array('member_list_id'=>$this->user['member_list_id']))->update(['member_list_email' => $email]);
		if($current_user['user_status']==0){
			$active_options=get_active_options();
			$activekey=md5($current_user['member_list_id'].time().uniqid());//激活码
			$result=Db::name('member_list')->where(array("member_list_id"=>$current_user['member_list_id']))->update(array("user_activation_key"=>$activekey));
			if(!$result){
				$this->error(lang('activation code generation failed'));
			}
			//生成激活链接
			$url = url('home/Register/active',array("hash"=>$activekey), "", true);
			$template = $active_options['email_tpl'];
			$content = str_replace(array('http://#link#','#username#'), array($url,$current_user['member_list_nickname']),$template);
			$send_result=sendMail($email, $active_options['email_title'], $content);
			if($send_result['error']){
				$this->error(lang('send active email failed'));
			}else{
				$this->success(lang('send active email success'),url('home/Login/index'));
			}
		}else{
		    $this->error(lang('activated'),url('home/Index/index'));
		}
	}
	/*
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
	*/
}
