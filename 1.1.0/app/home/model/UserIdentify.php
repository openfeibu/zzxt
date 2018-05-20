<?php

namespace app\home\model;

use think\Model;

class UserIdentify extends Model
{
    public function check($uid)
    {
        $time = date('Y', time());
        $bool = $this->where('user_id', $uid)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        return $bool;
    }
}
