<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use think\Cache;
use think\helper\Time;
use app\admin\model\News as NewsModel;
use app\admin\model\DataOracle as DataOracleModel;
use app\admin\model\Admin as AdminModel;
use app\admin\model\MemberList;

class Index extends Base
{
    /**
     * 后台首页
     */
	public function index()
	{
		$news_model=new NewsModel;
		$member_model=new MemberList;
		$years = getYearArr();
		$eval_subsidy = DB::name('set_subsidy')->where('id',5)->find();
		$this->assign('years',$years);
		$this->assign('eval_subsidy',$eval_subsidy);
		
		//渲染模板
        return $this->fetch();
	}
    /**
     * 后台多语言切换
     */
	public function lang()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确');
		}else{
			$lang=input('lang_s');
			session('login_http_referer',$_SERVER["HTTP_REFERER"]);
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
			$this->success('切换成功',session('login_http_referer'));
		}
	}
	/*
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
	*/
	public function callback()
	{
		$class_number = "20170609,20170610,2016281801,2016281802";
		$evals = Db::name('evaluation_application')
				->alias('app')
                ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
				->join('yf_user u', 'u.id_number = m.id_number', 'left')
                ->field('u.*,app.*')
				->where("class_number in (".$class_number.")")
				->select();
		foreach($evals as $key => $val)
		{
			DB::name('evaluation_application')->where('evaluation_id',$val['evaluation_id'])
				->update([
					'evaluation_status' => 1,
					'group_opinion' => NULL,
					'group_poor_grade' => NULL,
				]);
			DB::name('evaluation_status')->where('evaluation_id',$val['evaluation_id'])
				->update([
					'status' => 1
				]);
		}			
		return "success";
	}
	public function updateAdminInfo()
	{
		$admins = DB::name('admin')->select();
		$data_oracle_model = new DataOracleModel();
		foreach($admins as $key => $val)
		{
			$where = " WHERE XH = '".$val['admin_username']."'";
			$student = $data_oracle_model->getStudent($where);
			if($student)
			{
				AdminModel::edit([
					'admin_id' => $val['admin_id'],
					'admin_pwd' => substr($student['id_number'],-6),
					'admin_username' => $student['id_number']
				]);
			}
		}
		return "success";
	}
}