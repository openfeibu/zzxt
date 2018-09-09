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
use app\admin\model\DataOracle;
/**
 * 配置模型
 * @package app\admin\model
 */
class DataHandle extends Model
{
	public function __construct()
	{
		$this->dataClass = new Data();
		$this->dataOracleClass = new DataOracle();
	}
	public function getProfessiones($where)
	{
		$result = $this->dataClass->getProfessiones($where);
		return $result;
	}
	//获取班级信息
	public function getClass($where,$type='oracle')
	{
		switch($type)
		{
			case 'oracle':
				$result = $this->dataOracleClass->getClass($where);
			break;
			case 'sqlserver':
				$result = $this->dataClass->getClass($where);
			break;
		}
		return $result;
	}
	//获取班级列表
	public function getClasses($where,$type='oracle')
	{
		switch($type)
		{
			case 'oracle':
				$result = $this->dataOracleClass->getClasses($where);
			break;
			case 'sqlserver':
				$result = $this->dataClass->getClasses($where);
			break;
		}
		return $result;
	}
	public function getStudents($where,$fields,$type='oracle')
	{
		switch($type)
		{
			case 'oracle':
				$result = $this->dataOracleClass->getStudents($where,$fields);
			break;
			case 'sqlserver':
				$result = $this->dataClass->getStudents($where,$fields);
			break;
		}
		return $result;
	}
	/*获取教师工号*/
	public function getAdmins($where,$fields)
	{
		$result = $this->dataClass->getAdmins($where,$fields);
		return $result;
	}
	public function getStudent($where)
	{
		$DataOracle = new DataOracle();
		$student = $DataOracle->getStudent($where);
		return $student;
	}
	//获取系的班级列表
	// public function getFacultyClasses($where,$fields)
	// {
		// $result = $this->dataClass->getFacultyClasses($where,$fields);
		// return $result;
	// }
}
