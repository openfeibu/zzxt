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
		set_time_limit(0);      //执行时间无限
		ini_set('memory_limit', '-1');    //内存无限
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$data_oracle_class = new DataOracle();
		$data_class = new Data();
		$years = getYearArr();
		$local_students = Db::name("member_list")->alias('m')
			->join('yf_user u', 'u.id_number = m.id_number')
			//->where(" u.current_grade = '"."' OR u.current_grade in (".implode(',',$years).") ")
			->field('u.current_grade,m.id_number,u.studentid,m.member_list_id,u.id')
			->order('member_list_id','desc')
			->select();
		foreach($local_students as $key=> $local_student)
		{
			$where = " WHERE LOWER(SFZH) = LOWER('".$local_student['id_number']."')";
			$where_jwxt = " WHERE 身份证号 = '".$local_student['id_number']."' ";
			if($local_student['studentid'])
			{
				$xh = $local_student['studentid'];
				$xh_unfulll = substr($xh,-9);
				$where .= " OR XH = '".$xh."' OR XH = '".$xh_unfulll."' ";
				$where_jwxt .= " OR 学号 = '".$xh."' OR 学号 = '".$xh_unfulll."' ";
			}
			
			$new_student = $data_oracle_class->getStudent($where);
			if($new_student)
			{
				$data = [
					'profession' => $new_student['profession'],
					'department_name' => $new_student['department_name'],
					'class_name' => $new_student['class_name'],
					'class_number' => $new_student['class_number'],
					'faculty_number' => get_faculty_number_by_dwh($new_student['dwh']),
				];
				
			}
			
			$new_student_jwxt = $data_class->getStudent($where_jwxt);
			
			if($new_student_jwxt)
			{
				$data['current_grade'] = $new_student_jwxt['current_grade'];
			}

			if(isset($data) && $data)
			{
				Db::name('user')->where('id',$local_student['id'])->update($data);
			}
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
	public function evaluationStatistics()
	{
		
	}
}