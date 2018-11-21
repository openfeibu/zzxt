<?php

namespace app\home\controller;

use think\Cache;
use think\Db;
use think\captcha\Captcha;
use app\admin\model\Data;
use app\admin\model\DataHandle;
use app\admin\model\DataOracle;
use app\admin\model\Evaluation as EvaluationModel;
use app\admin\model\MemberList as MemberListModel;

class Schedule extends Base
{
	public function __construct()
	{
		parent::__construct();
		$this->evaluation = new EvaluationModel();
	}
	public function updateStudentInfo()
	{
		set_time_limit(0);      //执行时间无限
		ini_set('memory_limit', '-1');    //内存无限
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
		$data_oracle_class = new DataOracle();
		$data_class = new Data();
		$years = getYearArr();
		
		$count = Db::name("member_list")->alias('m')->join('yf_user u', 'u.id_number = m.id_number')->count();
		
		$local_students = Db::name("member_list")->alias('m')
			->join('yf_user u', 'u.id_number = m.id_number')
			//->where(" u.id in (11846,11848)")
			//->where(" u.current_grade = '"."' OR u.current_grade in (".implode(',',$years).") ")
			->field('u.current_grade,m.id_number,u.studentid,m.member_list_id,u.id')
			->order('member_list_id','desc')
			->select();

		foreach($local_students as $key=> $local_student)
		{
			(new MemberListModel())->updateStudent($local_student['id_number'],$local_student['studentid']);
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
		$facultys = DB::name('faculty')->select();
		$subsidy = DB::name('set_subsidy')->where('id',5)->find();
		$grade_1_all_count = $grade_2_all_count = $grade_3_all_count = $grade_all_count = $student_count = 0;
		$data = [];
		foreach($facultys as $faculty_key => $faculty)
		{
			/*特殊困难*/
			$years = getYearArr();
			
			$faculty_grade_1_all_count = $faculty_grade_2_all_count = $faculty_grade_3_all_count = $faculty_grade_all_count = $faculty_student_count = 0;
			foreach($years as $year_key => $year)
			{
				$where = "(school_poor_grade = 1 OR (faculty_poor_grade = 1 AND school_poor_grade is NULL)) AND u.faculty_number = '".$faculty['faculty_number']."'";
				$faculty_year_grade_1_count = $this->evaluation->evaluation_year_count($year,$where);
				$data[] = [
					'name' => 'faculty_year_poor_grade_1',
					'attr' => 'faculty_number',
					'attr_value' => $faculty['faculty_number'],
					'times' => $subsidy['begin_time'],
					'year' => $year,
					'value' => $faculty_year_grade_1_count
				];
				
				$where = "(school_poor_grade = 2 OR (faculty_poor_grade = 2 AND school_poor_grade is NULL)) AND u.faculty_number = '".$faculty['faculty_number']."'";
				$faculty_year_grade_2_count = $this->evaluation->evaluation_year_count($year,$where);
				$data[] = [
					'name' => 'faculty_year_poor_grade_2',
					'attr' => 'faculty_number',
					'attr_value' => $faculty['faculty_number'],
					'times' => $subsidy['begin_time'],
					'year' => $year,
					'value' => $faculty_year_grade_2_count
				];
				
				$where = "(school_poor_grade = 3 OR (faculty_poor_grade = 3 AND school_poor_grade is NULL)) AND u.faculty_number = '".$faculty['faculty_number']."'";
				$faculty_year_grade_3_count = $this->evaluation->evaluation_year_count($year,$where);
				$data[] = [
					'name' => 'faculty_year_poor_grade_3',
					'attr' => 'faculty_number',
					'attr_value' => $faculty['faculty_number'],
					'times' => $subsidy['begin_time'],
					'year' => $year,
					'value' => $faculty_year_grade_3_count
				];
				/*
				$where = " u.faculty_number = '".$faculty['faculty_number']."'";
				$faculty_year_grade_count = $this->evaluation->evaluation_year_count($year,$where);*/
				$faculty_year_grade_count = $faculty_year_grade_1_count + $faculty_year_grade_2_count + $faculty_year_grade_3_count;
				$data[] = [
					'name' => 'faculty_year_poor_grade',
					'attr' => 'faculty_number',
					'attr_value' => $faculty['faculty_number'],
					'times' => $subsidy['begin_time'],
					'year' => $year,
					'value' => $faculty_year_grade_count
				];
				
				$where = " u.faculty_number = '".$faculty['faculty_number']."'";
				$faculty_year_student_count = $this->evaluation->evaluation_year_count($year,$where);
				$data[] = [
					'name' => 'faculty_year_student_count',
					'attr' => 'faculty_number',
					'attr_value' => $faculty['faculty_number'],
					'times' => $subsidy['begin_time'],
					'year' => $year,
					'value' => $faculty_year_student_count
				];
				
				$faculty_grade_1_all_count += $faculty_year_grade_1_count;
				$faculty_grade_2_all_count += $faculty_year_grade_2_count;
				$faculty_grade_3_all_count += $faculty_year_grade_3_count;
				$faculty_grade_all_count += $faculty_year_grade_count;
				$faculty_student_count += $faculty_year_student_count;
				
			}
			$data[] = [
				'name' => 'faculty_poor_grade_1',
				'attr' => 'faculty_number',
				'attr_value' => $faculty['faculty_number'],
				'times' => $subsidy['begin_time'],
				'year' => 'all',
				'value' => $faculty_grade_1_all_count
			];
			$data[] = [
				'name' => 'faculty_poor_grade_2',
				'attr' => 'faculty_number',
				'attr_value' => $faculty['faculty_number'],
				'times' => $subsidy['begin_time'],
				'year' => 'all',
				'value' => $faculty_grade_2_all_count
			];
			$data[] = [
				'name' => 'faculty_poor_grade_3',
				'attr' => 'faculty_number',
				'attr_value' => $faculty['faculty_number'],
				'times' => $subsidy['begin_time'],
				'year' => 'all',
				'value' => $faculty_grade_3_all_count
			];
			$data[] = [
				'name' => 'faculty_poor_grade',
				'attr' => 'faculty_number',
				'attr_value' => $faculty['faculty_number'],
				'times' => $subsidy['begin_time'],
				'year' => 'all',
				'value' => $faculty_grade_all_count
			];
			$data[] = [
				'name' => 'faculty_student_count',
				'attr' => 'faculty_number',
				'attr_value' => $faculty['faculty_number'],
				'times' => $subsidy['begin_time'],
				'year' => 'all',
				'value' => $faculty_student_count
			];
			$grade_1_all_count += $faculty_grade_1_all_count;
			$grade_2_all_count += $faculty_grade_2_all_count;
			$grade_3_all_count += $faculty_grade_3_all_count;
			$grade_all_count += $faculty_grade_all_count;
			$student_count += $faculty_student_count;
		}
		$data[] = [
			'name' => 'poor_grade_1',
			'attr' => 'all',
			'attr_value' => '',
			'times' => $subsidy['begin_time'],
			'year' => 'all',
			'value' => $grade_1_all_count
		];
		$data[] = [
			'name' => 'poor_grade_2',
			'attr' => 'all',
			'attr_value' => '',
			'times' => $subsidy['begin_time'],
			'year' => 'all',
			'value' => $grade_2_all_count
		];
		$data[] = [
			'name' => 'poor_grade_3',
			'attr' => 'all',
			'attr_value' => '',
			'times' => $subsidy['begin_time'],
			'year' => 'all',
			'value' => $grade_3_all_count
		];
		$data[] = [
			'name' => 'poor_grade',
			'attr' => 'all',
			'attr_value' => '',
			'times' => $subsidy['begin_time'],
			'year' => 'all',
			'value' => $grade_all_count
		];
		$data[] = [
			'name' => 'student_count',
			'attr' => 'all',
			'attr_value' => '',
			'times' => $subsidy['begin_time'],
			'year' => 'all',
			'value' => $student_count
		];
		//print_r($data);exit;
		DB::name('evaluation_statistics')->where('times',$subsidy['begin_time'])->delete();
		foreach($data as $key => $value)
		{
			DB::name('evaluation_statistics')->insert($value);
		}
		return "success";
	}
	
}