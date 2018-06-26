<?php

namespace app\home\model;

use think\Db;
use think\Model;
use app\admin\model\Evaluation as EvaluationModel;

class MultipleScholarship extends Model
{
    protected $table = 'yf_multiple_scholarship';
    /**
     * 创建新记录
     * @param $type
     * @param $uid
     * @return $this
     */
    public function store($type, $uid)
    {
        $data['create_at'] = time();
        $data['update_at'] = $data['create_at'];
        $data['user_id'] = $uid;
        $data['application_type'] = $type;
		
        $boole = $this->create($data);
        return $boole;
    }

    public function getMultipleList($type,$where = [],$order = '')
    {
		$subsidy = Db::name('set_subsidy')
                ->where('id', $type)
                ->find();
        $data = Db::name('multiple_scholarship')
                    ->alias('ms')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ms.multiple_id')
                    ->join('yf_member_list m', 'm.member_list_id = ms.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
					->where('ms.times',$subsidy['begin_time'])
                    ->order($order)
					->order('multiple_id desc')
                    ->field('u.*,ass.status_id,ms.check_status,ms.multiple_id,m.member_list_id,m.member_list_username,m.member_list_nickname,ms.group_opinion,ms.faculty_opinion,ms.school_opinion,ms.reason')
                    ->paginate(40);
        return $data;
    }
    public function getAllMultipleList($type,$where = [])
    {
		$subsidy = Db::name('set_subsidy')
                ->where('id', $type)
                ->find();
        $data = Db::name('multiple_scholarship')
                    ->alias('ms')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ms.multiple_id')
                    ->join('yf_member_list m', 'm.member_list_id = ms.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
					->where('ms.times',$subsidy['begin_time'])
					->order('multiple_id desc')
                    ->field('u.*,ass.status_id,ass.status,ms.check_status,ms.multiple_id,m.member_list_id,m.member_list_username,m.member_list_nickname,ms.group_opinion,ms.faculty_opinion,ms.school_opinion,ms.reason')
                    ->select();
        return $data;
    }
    public function isHaveApply($member_list_id,$type)
    {
		$subsidy = Db::name('set_subsidy')
                ->where('id', $type)
                ->find();
		$bool = Db::name('multiple_scholarship')->where('member_list_id', $member_list_id)
                ->where('times',$subsidy['begin_time'])
                ->where('application_type', $type)
                ->find();
		return $bool;
    }
	public function getCount($type,$where = '')
	{
		$subsidy = Db::name('set_subsidy')
                ->where('id', $type)
                ->find();
		$count = Db::name('multiple_scholarship')
				->alias('ms')
				->join('yf_member_list m', 'm.member_list_id = ms.member_list_id')
				->join('yf_user u', 'u.id_number = m.id_number', 'left')
				->where('ms.application_type',$type)
                ->where('ms.times',$subsidy['begin_time']);
        if($where)
		{
			$count = $count->where($where);
		}
		$count = $count->count();
		return $count;
	}
}
