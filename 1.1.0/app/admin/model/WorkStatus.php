<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/8/1
 * Time: 13:53
 */

namespace app\admin\model;

use think\Model;
class WorkStatus extends Model
{
    /**
     * 可能需要设定个时间点
     * @param $user_id
     * @return bool
     */
    public function check($user_id)
    {
        $boole = $this->where('user_id', $user_id)
            ->where('status',3)
            ->select();
        if (count($boole) >= 1) {
            return false;
        }
        return true;
    }

    public function checkNum($id)
    {
        return $this->where('work_apply_id',$id)
            ->where('status',3)
            ->count();
    }

}