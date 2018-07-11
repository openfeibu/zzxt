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
	public function getStudent($id_number)
	{
		$data = $this->query("SELECT * FROM LY_MH_XSZXJBXX_DMT WHERE EDUPERSONCARDID = '".$id_number."'");
		var_dump($data);
		exit;
	}
	public function query($sql) {
        $this->query = oci_parse($this->conn,$sql);
        oci_execute($this->query);
        $rs = $this->fetch_array();
        return $rs;
    }
	
	public function handleFetchRow($rs)
	{
		$arr = $arr1 = array();
		while(oci_fetch_row($rs))
		{
			for ($i = 1; $i <= oci_num_fields($rs); $i++) 
			{
				$name = oci_field_name($rs, $i);
				$value = oci_result($rs, $i);
				$arr1[$name] = $value;
			}
			$arr[] = $arr1;
		}
		return $arr;
	}
	
    public function fetch_array($type=OCI_ASSOC) {
		
        while( $row = oci_fetch_array($this->query,$type) ){
            $rs[] = $row;
        }
        if(1==count($rs)){
            $rs = $rs[0];
        }
        return $rs;
    }
	
}