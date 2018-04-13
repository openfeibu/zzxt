<?php

namespace app\home\service;

use think\Model;
use think\Db;
use app\home\model\NationalScholarship;
use app\home\model\MultipleScholarship;

class Scholarships extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->national = new NationalScholarship();
		$this->multiple = new MultipleScholarship();
	}
	public function getCount($type,$where = '')
	{
		if($type == 1)
		{
			$count = $this->national->getCount($where);
		}else{
			$count = $this->multiple->getCount($type,$where);
		}
		return $count;
	}
	
}