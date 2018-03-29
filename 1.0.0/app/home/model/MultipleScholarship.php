<?php

namespace app\home\model;

use think\Db;
use think\Model;

class MultipleScholarship extends Model
{
    protected $table = 'yf_multiple_scholarship';

    public function check($type, $uid, $time)
    {
        $bool = $this->where('user_id', $uid)
//            ->where('application_type', $type)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        if (!$bool) {
            $this->store($type, $uid);
            return false;
        }
        return true;
    }

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

    /**
     * 更新记录
     * @param $uid
     * @param $type
     * @param $time
     * @param $data
     * @return $this
     */
    public function updateData($uid, $type, $time, $data)
    {
        $bool = $this->where('user_id', $uid)
            ->where('application_type', $type)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update($data);
        return $bool;
    }

    /**
     * 插入小组意见
     * @param $uid
     * @param $data
     * @param $time
     * @return int|string
     */
    public function updateClassOpinion($application_id, $data, $time)
    {
        $bool = $this->where('multiple_id', $application_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update($data);
        return $bool;
    }
    public static function getMultipleList($where = [],$order = '')
    {
        $data = Db::name('multiple_scholarship')
                    ->alias('ms')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ms.multiple_id')
                    ->join('yf_member_list m', 'm.member_list_id = ms.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
                    ->order($order)
                    ->field('u.*,ass.status_id,ms.check_status,ms.multiple_id,m.member_list_username,m.member_list_nickname,ms.group_opinion,ms.faculty_opinion')
                    ->paginate(20);
        return $data;
    }
    public static function getAllMultipleList($where = [])
    {
        $data = Db::name('multiple_scholarship')
                    ->alias('ms')
                    ->join('yf_apply_scholarships_status ass','ass.application_id = ms.multiple_id')
                    ->join('yf_member_list m', 'm.member_list_id = ms.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
                    ->field('u.*,ass.status_id,ass.status,ms.check_status,ms.multiple_id,m.member_list_username,m.member_list_nickname,ms.group_opinion,ms.faculty_opinion')
                    ->select();
        return $data;
    }
    public static function isHaveApply($member_list_id,$type)
    {
        // $time = date('Y', time());
        // if($type == 1) {
        //     $bool = Db::name('multiple_scholarship')->where('member_list_id', $member_list_id)
        //         ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
        //         ->where('application_type', '2')
        //         ->find();
        //     if ($bool) {
        //         return true;
        //     }
        // } else if ($type == 2) {
        //     $bool = ScholarshipsApplyStatus::where('member_list_id', $member_list_id)
        //         ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
        //         ->where('application_type', '1')
        //         ->find();
        //     if ($bool) {
        //         return true;
        //     }
        // }
        return false;
    }
}
