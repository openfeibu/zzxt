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
use app\admin\model\Data;
/**
 * 配置模型
 * @package app\admin\model
 */
class DataHandle extends Model
{
	public function __construct()
	{
		$this->dataClass = new Data();
	}
	public function getProfessiones($where)
	{
		$result = $this->dataClass->getProfessiones($where);
		return $result;
	}
	//获取班级列表
	public function getClasses($where)
	{
		$result = $this->dataClass->getClasses($where);
		return $result;
	}
	public function getStudents($where,$fields)
	{
		$result = $this->dataClass->getStudents($where,$fields);
		return $result;
	}
	//获取系的班级列表
	// public function getFacultyClasses($where,$fields)
	// {
		// $result = $this->dataClass->getFacultyClasses($where,$fields);
		// return $result;
	// }
}
