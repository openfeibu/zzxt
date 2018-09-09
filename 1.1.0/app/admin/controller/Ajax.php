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
use app\admin\model\ClassCode;
use app\admin\model\DataHandle;

class Ajax
{
	/*
     * 返回行政区域json字符串
     */
	public function getRegion()
	{
		$map['pid']=input('pid');
		$map['type']=input('type');
		$list=Db::name("region")->where($map)->select();
		return json($list);
	}
	/*
     * 返回模块下控制器json字符串
     */
	public function getController()
	{
		$module=input('request_module','admin');
		$list=\ReadClass::readDir(APP_PATH . $module. DS .'controller');
		return json($list);
	}

	public function getStudents()
	{
		$value = input('value');
		$class_number = input('class_number');
		$years = getYears();
		$where = " where (姓名 = '".$value."' OR 学号 LIKE '".$value."%' OR 身份证号 LIKE '%".$value."%') AND 当前所在级 in ($years) AND 班级代码 = '".$class_number."'";
		$fields = " top 10 身份证号 as id_number , 学号 as studentid, 姓名 as name,班级代码 as class_number";
		$dataHandleClass = new DataHandle();
		$data = $dataHandleClass->getStudents($where,$fields);
		return json($data);
	}
	public function getAdmins()
	{
		$value = input('value');
		$years = getYears();
		$where = " where (姓名 = '".$value."' OR 工作编号 LIKE '".$value."%') ";
		$fields = " top 10 工作编号 as admin_username , 姓名 as name ,密码 as password";
		$dataHandleClass = new DataHandle();
		$data = $dataHandleClass->getAdmins($where,$fields);
		foreach($data as $key => $val)
		{
			$admin = DB::name('admin')->where('admin_username','like',$val['admin_username'].'-%')->order('admin_id','DESC')->field('admin_username,admin_id')->find();
			if($admin)
			{
				$admin_username_explode = explode('-',$admin['admin_username']);
				$number = intval($admin_username_explode[1]) + 1;
				$data[$key]['admin_username'] = $val['admin_username'].'-'.$number;
			}else{
				$admin = DB::name('admin')->where('admin_username',$val['admin_username'])->order('admin_id','DESC')->field('admin_username,admin_id')->find();
				if($admin)
				{
					$data[$key]['admin_username'] = $val['admin_username'].'-1';
				}
			}
		}
		
		return json($data);
	}
}