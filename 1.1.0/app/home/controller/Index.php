<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\home\controller;

use think\Cache;
use think\Db;
use think\captcha\Captcha;
use app\admin\model\DataHandle;

class Index extends Base
{
	public function index()
    {
		return $this->view->fetch(':index');
	}
	public function visit()
    {
		$user=Db::name("member_list")->where(array("member_list_id"=>input('id',0,'intval')))->find();
		if(empty($user)){
			$this->error(lang('member not exist'));
		}
		$this->assign($user);
		return $this->view->fetch('user:index');
	}
	public function verify_msg()
	{
		ob_end_clean();
		$verify = new Captcha (config('verify'));
		return $verify->entry('msg');
	}
	public function lang()
	{
		if (!request()->isAjax()){
			$this->error(lang('submission mode incorrect'));
		}else{
			$lang=input('lang_s');
			switch ($lang) {
				case 'cn':
					cookie('think_var', 'zh-cn');
				break;
				case 'en':
					cookie('think_var', 'en-us');
				break;
				//其它语言
				default:
					cookie('think_var', 'zh-cn');
			}
			Cache::clear();
			$this->success(lang('success'),url('home/Index/index'));
		}
	}
	public function addmsg()
    {
		if (!request()->isAjax()){
			$this->error(lang('submission mode incorrect'));
		}else{
			$verify =new Captcha ();
			if (!$verify->check(input('verify'), 'msg')) {
				$this->error(lang('verifiy incorrect'));
			}
			$data=array(
				'plug_sug_name'=>input('plug_sug_name'),
				'plug_sug_email'=>input('plug_sug_email'),
				'plug_sug_content'=>input('plug_sug_content'),
				'plug_sug_addtime'=>time(),
				'plug_sug_open'=>0,
				'plug_sug_ip'=>request()->ip(),
			);
			$rst=Db::name('plug_sug')->insert($data);
			if($rst!==false){
				$this->success(lang('message success'));
			}else{
				$this->error(lang('message failed'));
			}
		}
	}
	
	public function test()
	{
		$active_options=get_active_options();
		$activekey = '1234';
		$member_list_email = '1270864834@qq.com';
		//生成激活链接
		$url = url('home/Register/active',array("hash"=>$activekey), "", true);
		$template = $active_options['email_tpl'];
		$content = str_replace(array('http://#link#','#username#'), array($url,'123'),$template);
		$send_result=sendMail($member_list_email, $active_options['email_title'], $content);
		var_dump($send_result);exit;
	}
	public function updateAdminClass()
	{
		$admins = DB::name('admin')->where("class_number is NOT NULL AND class_number <> ''")->select();
		foreach($admins as $key => $admin)
		{
			$class_number = $admin['class_number'];
			$class_number_arr = explode(',',$class_number);
			$data = [];
			foreach($class_number_arr as $k => $v)
			{
				$data[$k] = [
					'admin_id' => $admin['admin_id'],
					'class_number' => $v
				];
			}
			DB::name('admin_class')->insertAll($data);	
		}
		return "success";
	}
	public function updateAdminClass2()
	{
		$admins = DB::name('admin')->select();
		foreach($admins as $key => $val)
		{
			$class_number_data = DB::name('admin_class')->where('admin_id',$val['admin_id'])->column('class_number');
			$class_number = array_keys($class_number_data);
			DB::name('admin')->where('admin_id',$val['admin_id'])->update(['class_number' => $class_number]);
			
		}
		return "success";
	}
}