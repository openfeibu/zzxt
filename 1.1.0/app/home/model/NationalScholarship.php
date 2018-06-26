<?php

namespace app\home\model;

use think\Model;
use think\Db;
class NationalScholarship extends Model
{
    protected $table = 'yf_national_scholarship';
	
	public function __construct()
	{
		parent::__construct();
		$subsidy = Db::table('yf_set_subsidy')
                ->where('id', 1)
                ->find();
		$this->subsidy = $subsidy;
	}
    /**
     * 获取学生的国家奖学金所填写的信息
     * @param $uid
     * @param $time
     * @return mixed
     */
    public function getStudentScholarship($uid)
    {
        $field = Db::getTableInfo('yf_national_scholarship', 'fields');
        //去掉id，因为id冲突
        unset($field[0]);
        //将数组转化为字符串
        $field = implode(',', $field);
        $result = $this->alias('ns')
            ->join('user u', 'u.studentid = ns.user_id', 'right')
            ->field('u.*,'.$field)
            ->where('ns.user_id', $uid)
            ->where('times',$this->subsidy['begin_time'])
            ->find();
        return $result->getData();
    }
    public function getNationalList($where = [],$order = '')
    {
        $data = Db::name('national_scholarship')
                    ->alias('ns')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ns.national_id')
                    ->join('yf_member_list m', 'm.member_list_id = ns.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
					->where('ns.times',$this->subsidy['begin_time'])
                    ->order($order)
                    ->field('u.*,ass.status_id,ns.check_status,ns.national_id,m.member_list_id,m.member_list_username,m.member_list_nickname,ns.group_opinion,ns.faculty_opinion,ns.school_opinion,ns.reason')
                    ->paginate(40);
        return $data;
    }
    public function getAllNationalList($where = [])
    {
        $data = Db::name('national_scholarship')
                    ->alias('ns')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ns.national_id')
                    ->join('yf_member_list m', 'm.member_list_id = ns.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
					->where('ns.times',$this->subsidy['begin_time'])
                    ->field('u.*,ass.status_id,ass.status,ns.check_status,ns.national_id,m.member_list_id,m.member_list_username,m.member_list_nickname,ns.group_opinion,ns.faculty_opinion,ns.school_opinion,ns.reason')
                    ->select();
        return $data;
    }
    /**
     * 检察是否存在
     * @param $uid
     * @param $time
     * @return bool
     */
    public function check($uid)
    {
        $res = $this->where('user_id', $uid)
            ->where('times',$this->subsidy['begin_time'])
            ->find();
        if (!$res) {
            return false;
        }
        return true;
    }

    /**
     * 插入辅导员意见
     * @param $uid
     * @param $data
     * @param $time
     * @return int|string
     */
    public function updateClassOpinion($uid, $data, $time)
    {
        $bool = $this->where('user_id', $uid)
            ->where('times',$this->subsidy['begin_time'])
            ->update($data);
        return $bool;
    }
	public function isHaveApply($member_list_id)
    {
		$bool = Db::name('national_scholarship')->where('member_list_id', $member_list_id)
                ->where('times',$this->subsidy['begin_time'])
                ->find();
		return $bool;
    }
	public function getCount($where = '')
	{
		$count = Db::name('national_scholarship')
				->alias('ns')
				->join('yf_member_list m', 'm.member_list_id = ns.member_list_id')
				->join('yf_user u', 'u.id_number = m.id_number', 'left')
				->where('ns.times',$this->subsidy['begin_time']);
        if($where)
		{
			$count = $count->where($where);
		}
		$count = $count->count();
		return $count;
	}
}
