<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

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
		$faculties = DB::name('class_code')->distinct(true)->field('系所代码 as faculty_number,系所名称 as faculty_name')->order('faculty_number asc')->select();
		return $faculties;
	}
	public function getFaculty($faculty_number)
    {
		$faculty = DB::name('class_code')->field('系所代码 as faculty_number,系所名称 as faculty_name')->order('faculty_number asc')->where('faculty_number',$faculty_number)->find();
		return $faculty;
	}
	public function getClass($faculty_number)
	{
		$class = DB::name('class_code')->field('系所代码 as faculty_number,系所名称 as faculty_name,班级代码 as class_number, 班级名称 as class_name,当前所在级 as current_grade')->order('faculty_number asc')->where('系所代码',$faculty_number)->select();

		return $class;
	}
	public function getClassByNumbers($numbers)
	{
		$map['班级代码'] = array('in',$numbers);
		$class = DB::name('class_code')->field('系所代码 as faculty_number,系所名称 as faculty_name,班级代码 as class_number, 班级名称 as class_name,当前所在级 as current_grade')->order('faculty_number asc')->where($map)->select();

		return $class;
	}
}
