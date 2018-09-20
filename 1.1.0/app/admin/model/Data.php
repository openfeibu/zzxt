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
 * 配置模型
 * @package app\admin\model
 */
class Data extends Model
{
	public function __call($method, $args) {
		$args = $this->handleArgs($args);
        return call_user_func_array([$this, $method], $args);
    }
	
	public function __construct()
	{
		$this->conn= odbc_connect("DRIVER={SQL Server};SERVER=".config('database.db2')['hostname'].";DATABASE=".config('database.db2')['database'],config('database.db2')['username'],config('database.db2')['password']);
	}
	protected function getStudent($where,$fields='学号 as studentid,班级代码 as class_number,班级名称 as class_name,当前所在级 as current_grade,系所代码 as faculty_number,系所名称 as department_name,专业名称 as  profession_name,专业名称 as  profession,身份证号 as id_number')
	{
		$sql="SELECT top 1 ".$fields." FROM V学生信息表 ".$where." AND 当前所在级  IS NOT NULL ";
		$rs = odbc_exec($this->conn,$sql);
		return $this->getSafeArr(odbc_fetch_array($rs));
	}
	public function getUserByIdCard($id_card)
	{
		$sql="SELECT top 1 * FROM V学生信息表 where 身份证号 = '".$id_card."' AND 当前所在级  IS NOT NULL ";
	    $rs = odbc_exec($this->conn,$sql);
		return $this->getSafeArr(odbc_fetch_array($rs));
	}
	protected function getProfessiones($where = '')
	{
		$sql="SELECT distinct 系所代码 as faculty_number, 专业代码 as profession_number,专业名称 as  profession_name,当前所在级 as current_grade FROM V班级代码表 ".$where ." ORDER BY 当前所在级 ASC";
	    $rs = odbc_exec($this->conn,$sql);
		$result = $this->handleFetchRow($rs);
		return $result;
	}

	protected function getClasses($where = '')
	{
		$sql="SELECT 班级代码 as class_number,班级名称 as class_name,当前所在级 as current_grade FROM V班级代码表 ".$where ." ORDER BY 班级代码 ASC ";
	    $rs = odbc_exec($this->conn,$sql);
		$result = $this->handleFetchRow($rs);
		return $result;
	}
	protected function getClass($where)
	{
		$sql="SELECT 班级代码 as class_number,班级名称 as class_name,当前所在级 as current_grade FROM V班级代码表 ".$where ." ORDER BY 班级代码 ASC ";
	    $rs = odbc_exec($this->conn,$sql);
		return $this->getSafeArr(odbc_fetch_array($rs));
	}
	// protected function getFacultyClasses($where = '',$fields)
	// {
			
	// }
	protected function getStudents($where,$fields)
	{
		$sql="SELECT ".$fields." FROM V学生信息表 ".$where;
		$rs = odbc_exec($this->conn,$sql);
		return $this->handleFetchRow($rs);
	}
	protected function getAdmins($where,$fields)
	{
		$sql="SELECT ".$fields." FROM 学院教职工基本情况表 ".$where;
		$rs = odbc_exec($this->conn,$sql);
		return $this->handleFetchRow($rs);
	}
	
	public function test($id_card)
	{
		$sql="SELECT top 1 * FROM 学生信息表 where 身份证号 = '".$id_card."'";
	    $rs = odbc_exec($this->conn,$sql);
		return $this->getSafeArr(odbc_fetch_array($rs));
	}
	public function handleFetchRow($rs)
	{
		$arr = $arr1 = array();
		while(odbc_fetch_row($rs))
		{
			for ($i = 1; $i <= odbc_num_fields($rs); $i++) 
			{
				$name = $this->getSafe(odbc_field_name($rs, $i));
				$value = $this->getSafe(odbc_result($rs, $i));
				$arr1[$name] = $value;
			}
			$arr[] = $arr1;
		}
		return $arr;
	}
	function getSafe($data)
	{
		if(is_array($data))
		{
			return $this->getSafeArr($data);
		}else{
			return $this->getSafeStr($data);
		}
	}
	//function 
	function getSafeArr($data){
		$arr = array();
		if(!empty($data))
		{
			foreach($data as $key => $str)
			{
				$k1 = iconv('gbk','utf-8//IGNORE',$key);
				$k0 = iconv('utf-8','gbk//IGNORE',$k1);
				$s1 = iconv('gbk','utf-8//IGNORE',$str);
				$s0 = iconv('utf-8','gbk//IGNORE',$s1);
				if($s0 == $str){
					$arr[$k1] = $s1;
				}else{
					$arr[$k0] = $str;
				}
			}
		}
		
		return $arr;
	}
	function getSafeStr($str)
	{
		$s1 = iconv('gbk','utf-8//IGNORE',$str);
		$s0 = iconv('utf-8','gbk//IGNORE',$s1);
		if($s0 == $str){
			return $s1;
		}else{
			return $str;
		}
	}
	function getUnSafeStr($str)
	{
		$s1 = iconv('utf-8','gbk//IGNORE',$str);
		$s0 = iconv('gbk','utf-8//IGNORE',$s1);
		if($s0 == $str){
			return $s1;
		}else{
			return $str;
		}
	}
	public function handleArgs($args)
	{
		$arr = array();
		foreach($args as $key => $val)
		{
			if(is_array($val)){
				$arr[$key] = $this->handleArgs($val);
			}else{
				$arr[$key] =  $this->getUnSafeStr($val);
			}
		}
		return $arr;
	}
}