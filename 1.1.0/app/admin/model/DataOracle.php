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

class Dataoracle extends Model
{
	/*
	public function __call($method, $args) {
		$args = $this->handleArgs($args);
        return call_user_func_array([$this, $method], $args);
    }
	*/
	public function __construct()
	{
		$this->conn= oci_pconnect(config('database.db3')['username'],config('database.db3')['password'],config('database.db3')['hostname'],"AL32UTF8");
		if (!$this->conn) {
			$e = oci_error();
			trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
		}
	}
	public function getStudent($where,$fields='XH as studentid,BH as class_number,DWH ,DWMC as department_name ,ZY as profession ,BJ as class_name,SFZH as id_number')
	{
		$data = $this->query("SELECT ".$fields." FROM LY_YKT_XS_DMT ".$where." AND ROWNUM = 1");
		return $data;
	}
	public function getStudents($where,$fields,$number=10)
	{
		$sql = "SELECT ROWNUM, ".$fields." FROM LY_YKT_XS_DMT ".$where." AND ROWNUM <= ".$number."  ORDER BY SFZH ASC ";
		$rs = $this->queryReturn2DArr($sql);
		return $rs;
	}
	public function getClass($where)
	{
		$sql="SELECT BJH as class_number,BJMC as class_name,NJ as current_grade FROM LY_XXZX_BJ_DMT ".$where ." AND ROWNUM = 1 ORDER BY BJH ASC ";
		$rs = $this->query($sql);
		return $rs;
	}
	public function getClasses($where)
	{
		$sql="SELECT BJH as class_number,BJMC as class_name,NJ as current_grade FROM LY_XXZX_BJ_DMT ".$where ." ORDER BY BJH ASC ";
		$rs = $this->queryReturn2DArr($sql);
		return $rs;
	}
	public function query($sql) {
        $query = oci_parse($this->conn,$sql);
        oci_execute($query);
        $rs = $this->fetch_array($query);
        return $rs;
    }
	public function queryReturn2DArr($sql)
	{
		$query = oci_parse($this->conn,$sql);
        oci_execute($query);
		$rs = $this->handleFetchRow($query);
        return $rs;
	}
	public function handleFetchRow($query,$strtolower = true)
	{
		$arr = $arr1 = array();
		while(oci_fetch_row($query))
		{
			for ($i = 1; $i <= oci_num_fields($query); $i++) 
			{
				$name = oci_field_name($query, $i);
				$value = oci_result($query, $i);
				if($strtolower)
				{
					$name = strtolower($name);
				}
				$arr1[$name] = $value;
			}
			$arr[] = $arr1;
		}
		return $arr;
	}
	
    public function fetch_array($query,$strtolower = true) {
		$arr = $arr1 = array();
		while(oci_fetch_row($query))
		{
			for ($i = 1; $i <= oci_num_fields($query); $i++) 
			{
				$name = oci_field_name($query, $i);
				$value = oci_result($query, $i);
				if($strtolower)
				{
					$name = strtolower($name);
				}
				$arr1[$name] = $value;
			}
			$arr[] = $arr1;
		}
		if(count($arr) == 1)
		{
			$arr = $arr[0];
		}
		return $arr;
    }
		
}