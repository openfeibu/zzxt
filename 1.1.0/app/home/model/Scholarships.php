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
	public function getScholarshipPrevious($fund_type,$id,$type,$where="",$order="")
	{
		//判断类型
        if ($fund_type == 1) {
            $type = "yf_national_scholarship";
            $field = "national_id";
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id"; 
        }
        $apply = Db::table($type)
            ->alias('w')
			->join('yf_apply_scholarships_status ass','ass.application_id = w.'.$field)
            ->join('yf_member_list m', 'm.member_list_id = w.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
			->where('status_id','>',$id)
			->where('fund_type',$fund_type)
			->where($where)
			->order($field.' asc')
            ->field('ass.status_id,'.$field)
            ->find();
		return 	$apply ? $apply['status_id'] : '';
	}
	public function getScholarshipPreviousUrl($fund_type,$id,$type,$where="",$order="")
	{
		$previous_url = "";
		$previous_apply_id = $this->getScholarshipPrevious($fund_type,$id,$where,$order);
		if($previous_apply_id){
			$previous_url = url('admin/'.$type,['type_id' => $fund_type,'id' => $previous_apply_id]);
		}
		return $previous_url;
	}
	public function getScholarshipNext($fund_type,$id,$type,$where="",$order="")
	{
		//判断类型
        if ($fund_type == 1) {
            $type = "yf_national_scholarship";
            $field = "national_id";
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id"; 
        }
        $apply = Db::table($type)
            ->alias('w')
			->join('yf_apply_scholarships_status ass','ass.application_id = w.'.$field)
            ->join('yf_member_list m', 'm.member_list_id = w.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
			->where('status_id','<',$id)
			->where('fund_type',$fund_type)
			->where($where)
			->order($field.' desc')
            ->field('ass.status_id,'.$field)
            ->find();
		return 	$apply ? $apply['status_id'] : '';
	}
	public function getScholarshipNextUrl($fund_type,$id,$type,$where="",$order="")
	{
		$next_url = "";
		$next_apply_id = $this->getScholarshipNext($fund_type,$id,$where,$order);
		if($next_apply_id){
			$next_url = url('admin/'.$type,['type_id' => $fund_type,'id' => $next_apply_id]);
		}
		return $next_url;
	}
}