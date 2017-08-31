<?php

namespace app\home\model;

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
    public function updateClassOpinion($uid, $data, $time, $type_id)
    {
        $bool = $this->where('user_id', $uid)
            ->where('application_type', $type_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update($data);
        return $bool;
    }
}
