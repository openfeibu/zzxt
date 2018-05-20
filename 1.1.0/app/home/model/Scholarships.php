<?php

namespace app\home\model;

use think\Model;
use think\Db;
use app\home\model\NationalScholarship;
use app\home\model\MultipleScholarship;
use app\admin\model\User as UserModel;

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
	public function getScholarship($fund_type,$id)
	{
		//判断类型
        if ($fund_type == 1) {
            $type = "yf_national_scholarship";
            $field = "national_id";
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id"; 
        }
		$user_model = new UserModel();
        $user_fields = UserModel::getUserFields('u');
        $user_fields = implode(',',$user_fields);
        $apply = Db::table($type)
            ->alias('w')
            ->join('yf_member_list m', 'm.member_list_id = w.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where($field,$id)
            ->field('w.*,m.member_list_nickname,m.member_list_headpic,'.$user_fields)
            ->find();
		$apply = handleApply($apply);
		$apply = handleScholarshipApply($apply);
		return $apply;
	}
}