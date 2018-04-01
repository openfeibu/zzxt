<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use app\admin\model\DataHandle;
use think\Model;
use think\Db;

/**
 * 后台用户模型
 * @package app\admin\model
 */
class ClassCode extends Model
{

    public function getFaculties()
    {
		$faculties = DB::name('faculty')->field('*')->order('faculty_number asc')->select();
		return $faculties;
	}
	public function getFaculty($faculty_number)
    {
		$faculty = DB::name('faculty')->field('*')->where('faculty_number',$faculty_number)->find();
		return $faculty;
	}

	public function getClass($faculty_number)
	{
		$class = DB::name('class_code')->field('系所代码 as faculty_number,系所名称 as faculty_name,班级代码 as class_number, 班级名称 as class_name,当前所在级 as current_grade')->order('faculty_number asc')->where('系所代码',$faculty_number)->select();

		return $class;
	}
    public function getFacultyClasses($faculty_number)
    {
        $years = getYears();
		$dataHandleClass = new DataHandle();
		$where = " WHERE 系所代码 = '".$faculty_number."' AND 当前所在级 in(".$years.")";
		$classes = $dataHandleClass->getClasses($where);
		return $classes;
    }

	public function getProfessiones($faculty_number)
	{

		$years = getYears();
		$dataHandleClass = new DataHandle();
		$where = " WHERE 系所代码 = '".$faculty_number."' AND 当前所在级 in(".$years.")";
		$professiones = $dataHandleClass->getProfessiones($where);
		return $professiones;
	}

	public function getClassByNumbers($numbers)
	{
		$map['班级代码'] = array('in',$numbers);
		$class = DB::name('class_code')->field('系所代码 as faculty_number,系所名称 as faculty_name,班级代码 as class_number, 班级名称 as class_name,当前所在级 as current_grade')->order('faculty_number asc')->where($map)->select();

		return $class;
	}
	// public function getCounselorClasses($admin_professiones)
	// {
		// $dataHandleClass = new DataHandle();
		// $arr = array();
		// foreach($admin_professiones as $key => $val)
		// {
			// $where = " WHERE 专业代码 = '".$val['profession_number']."' AND 当前所在级 = '".$val['current_grade']."'";
			// $classes = $dataHandleClass->getClasses($where);
			// $arr = array_merge($arr,$classes);
		// }
		// return $arr;
	// }
	public function getCounselorClasses($class_number)
	{
		$dataHandleClass = new DataHandle();
		$classes = array();
		if($class_number)
		{
			$where = " WHERE 班级代码 in (".$class_number.") ";
			$classes = $dataHandleClass->getClasses($where);
		}
		return $classes;
	}
	public function handleAdminProfessiones($admin_professiones)
	{
		$arr = array();
		if(is_array($admin_professiones) && count($admin_professiones))
		{
			foreach($admin_professiones as $key => $val)
			{
				$arr[] = $val['current_grade'].'_'.$val['profession_number'];
			}
		}
		return $arr;
	}
}
