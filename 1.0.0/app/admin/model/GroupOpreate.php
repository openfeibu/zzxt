<?php

namespace app\admin\model;

use think\Model;
class GroupOpreate extends Model
{
    protected $table = "group_operate";
    public function setScore($uid, $data)
    {
        $time = date('Y', time());
        $status_id = $this->table('status')
                    ->where('user_id', $uid)
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
                    ->field('id')
                    ->find();
         self::where('status_id', $status_id->getData('id'))->update($data);
    }

    public function checkPass($uid, $data)
    {
        $time = date('Y', time());
        $status_id = $this->table('yf_apply_scholarships_status')
                    ->where('user_id', $uid)
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
                    ->field('id')
                    ->find();
        self::where('status_id', $status_id->getData('id'))->update($data);
    }

}
