<?php

namespace app\home\model;

use think\Model;

class Identify extends Model
{
    protected $field = [];
    /**
     * 验证是否有记录存在
     * @param $value 学号
     * @return bool
     */
    public function existPopulation($value, $time)
    {
        $time = date('Y', $time);
        $result = $this->where('user_id', $value)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20)  = $time")
            ->value('population');
        if (is_null($result)) {
            return false;
        }
        return true;
    }
}
