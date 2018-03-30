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
 * ����ģ��
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
	public function getUserByIdCard($id_card)
	{
		$sql="SELECT top 1 * FROM Vѧ����Ϣ�� where ���֤�� = '".$id_card."'";
	    $rs = odbc_exec($this->conn,$sql);
		return $this->getSafeArr(odbc_fetch_array($rs));
	}
	protected function getProfessiones($where = '')
	{
		$sql="SELECT distinct ϵ������ as faculty_number, רҵ���� as profession_number,רҵ���� as  profession_name,��ǰ���ڼ� as current_grade FROM V�༶����� ".$where ." ORDER BY ��ǰ���ڼ� ASC";
	    $rs = odbc_exec($this->conn,$sql);
		$result = $this->handleFetchRow($rs);
		return $result;
	}
	protected function getClassNumbers($where = '')
	{
		$sql="SELECT �༶���� as class_number ".$where ;
	    $rs = odbc_exec($this->conn,$sql);
		$result = $this->handleFetchRow($rs);
		return $result;
	}
	protected function getClasses($where = '')
	{
		$sql="SELECT �༶���� as class_number,�༶���� as class_name,��ǰ���ڼ� as current_grade FROM V�༶����� ".$where ." ORDER BY �༶���� ASC ";
	    $rs = odbc_exec($this->conn,$sql);
		$result = $this->handleFetchRow($rs);
		return $result;
	}
	// protected function getFacultyClasses($where = '',$fields)
	// {
			
	// }
	protected function getStudents($where,$fields)
	{
		$sql="SELECT ".$fields." FROM Vѧ����Ϣ�� ".$where;
		$rs = odbc_exec($this->conn,$sql);
		return $this->handleFetchRow($rs);
	}
	public function test($id_card)
	{
		$sql="SELECT top 1 * FROM ѧ����Ϣ�� where ���֤�� = '".$id_card."'";
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