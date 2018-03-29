<?php

namespace app\home\model;

use think\Model;
use think\Db;
class NationalScholarship extends Model
{
    protected $table = 'yf_national_scholarship';
    /**
     * 获取学生的国家奖学金所填写的信息
     * @param $uid
     * @param $time
     * @return mixed
     */
    public function getStudentScholarship($uid, $time)
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
            ->where("CONVERT(VARCHAR(4),DATEADD(S,ns.create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        return $result->getData();
    }
    public static function getNationalList($where = [],$order = '')
    {
        $data = Db::name('national_scholarship')
                    ->alias('ns')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ns.national_id')
                    ->join('yf_member_list m', 'm.member_list_id = ns.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
                    ->order($order)
                    ->field('u.*,ass.status_id,ns.check_status,ns.national_id,m.member_list_username,m.member_list_nickname,ns.group_opinion,ns.faculty_opinion')
                    ->paginate(20);
        return $data;
    }
    public static function getAllNationalList($where = [])
    {
        $data = Db::name('national_scholarship')
                    ->alias('ns')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ns.national_id')
                    ->join('yf_member_list m', 'm.member_list_id = ns.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
                    ->field('u.*,ass.status_id,ass.status,ns.check_status,ns.national_id,m.member_list_username,m.member_list_nickname,ns.group_opinion,ns.faculty_opinion')
                    ->select();
        return $data;
    }
    /**
     * 检察是否存在
     * @param $uid
     * @param $time
     * @return bool
     */
    public function check($uid, $time)
    {
        $res = $this->where('user_id', $uid)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,ns.create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
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
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update($data);
        return $bool;
    }
}
