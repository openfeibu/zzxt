<?php

namespace app\home\controller;

use think\Cache;
use think\Db;
use think\captcha\Captcha;
use app\admin\model\Data;
use app\admin\model\DataHandle;
use app\admin\model\DataOracle;

class Schedule extends Base
{
	public function updateStudentInfo()
	{
		ini_set('memory_limit','3072M');
		set_time_limit(0);
		$data_oracle_class = new DataOracle();
		$data_class = new Data();
		$years = getYearArr();
		$local_students = Db::name("member_list")->alias('m')
			->join('yf_user u', 'u.id_number = m.id_number')
			->where(function($query) use ($years){
				$query->where('u.current_grade','in',$years)
					->whereOr('u.current_grade','')
					->whereNull('u.current_grade');
			})
			->field('u.current_grade,m.id_number,u.studentid,m.member_list_id,u.id')
			->select();
		foreach($local_students as $key=> $local_student)
		{
			$xh = $local_student['studentid'];
			$xh_unfulll = substr($xh,-9);
			$where = " WHERE XH = '".$xh."' OR SFZH = '".$local_student['id_number']."' OR XH = '".$xh_unfulll."' ";
			$new_student = $data_oracle_class->getStudent($where);
			if($new_student)
			{
				$data = ['profession' => $new_student['profession'],'department_name' => $new_student['department_name'],'class_name' => $new_student['class_name'],'class_number' => $new_student['class_number']];
				
			}
			
			$where_jwxt = " WHERE 学号 = '".$xh."' OR 身份证号 = '".$local_student['id_number']."' ";
			$new_student_jwxt = $data_class->getStudent($where_jwxt);
			
			if($new_student_jwxt)
			{
				$data['current_grade'] = $new_student_jwxt['current_grade'];
			}
			if(isset($data) && $data)
			{
				Db::name('user')->where('id',$local_student['id'])->update($data);
			}
			sleep(2);
		}
		return "success";
	}
	public function updateAdmin()
	{
		$data_oracle = new DataOracle();
		$admins = Db::name("admin")->where("class_number is NOT NULL AND class_number <> ''")->field('class_number,admin_id')->field('admin_id,class_number,admin_username')->select();
		foreach($admins as $key=> $admin)
		{
			$class_number = $admin['class_number'];
			$where = " WHERE  SFZH = '".$admin['admin_username']."' ";
			$new_student = $data_oracle->getStudent($where);
			if($new_student)
			{
				Db::name('admin')->where('admin_id',$admin['admin_id'])->update(['class_number' => $new_student['class_number'] ]);
			}	
		}
		return "success";
	}
}