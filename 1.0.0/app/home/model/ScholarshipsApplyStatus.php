<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/1
 * Time: 16:33
 */

namespace app\home\model;


use think\Model;
use app\home\model\GroupOpreate;

class ScholarshipsApplyStatus extends Model
{
    protected $table = 'yf_apply_scholarships_status';

    /**
     * 查看状态表中是否有记录
     * @param $id 学号
     * @param $time 今年
     * @param $type_id 5个表中的id
     * @param $type 哪种表
     * @return $this|bool|false|int
     */
    public function checkStatus($user_id, $time, $multiple_id, $multiple_name,$type_id)
    {
        $bool = ScholarshipsApplyStatus::where('user_id', $user_id)
            ->where('fund_type', $type_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        if (!$bool) {
            $status_id = $this->store($user_id, $multiple_name, $multiple_id, $type_id);
            $bool =  $this->checkGroupOperate($status_id);
            $boole =  $this->checkOperate($status_id);
            //不存在的时候。就插入
            if (!$bool and !$boole) {
                $this->storeOperate($status_id);
                $this->storeGroupOperate($status_id);
                return true;
            }
        }
        return $this->updateStatus($user_id, $multiple_name, $multiple_id, $time, $type_id);
    }



    /**
     * 插入记录到状态表中
     * @param $id 学号
     * @param $type 类型
     * @param $type_id 表的id
     * @return bool|false|int
     */
    protected function store($user_id, $multiple_name, $multiple_id, $fund_type)
    {
        $data['user_id'] = $user_id;
        $data['create_at'] = time();
        $data['update_at'] = $data['create_at'];
        $data['application_id'] = $data[$multiple_name] = $multiple_id;
        $bool = ScholarshipsApplyStatus::where('user_id', $user_id)
            ->where('fund_type', $fund_type)
            ->update($data);
        if (!$bool) {
            return false;
        }
        return $bool->getLastInsID();
    }

    /**
     * 更新表的id
     * @param $id
     * @param $type
     * @param $type_id
     * @param $time
     * @return $this
     */
    protected function updateStatus($user_id, $multiple_name, $multiple_id, $time, $fund_type)
    {
        $bool = $this->where('user_id', $user_id)
            ->where('fund_type', $fund_type)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update([
                $multiple_name => $multiple_id,
                'application_id' => $multiple_id
            ]);
        return $bool;
    }

    /**
     * 提交的时候就创建相应的状态记录表
     * @param $id
     * @param $type
     * @param $time
     * @return bool
     */
    public function storeByChooseType($user_id, $type, $time)
    {
        $bool = ScholarshipsApplyStatus::where('user_id', $user_id)
            ->where('fund_type', $type)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        if (!$bool) {
            $data['fund_type'] = $type;
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $data['user_id'] = $user_id;
            $res = $this->save($data);
            if (!$res) {
                return false;
            }
            return true;
        }
    }

    /**
     * 判断是否申请过奖学金
     * @param $uid
     * @param $type
     * @return bool
     */
    public function isHaveApply ($uid,$type) {
        $time = date('Y', time());
        if($type == 1) {
            $bool = ScholarshipsApplyStatus::where('user_id', $uid)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
                ->where('fund_type', '2')
                ->find();
            if ($bool) {
                return false;
            }
        } else if ($type == 2) {
            $bool = ScholarshipsApplyStatus::where('user_id', $uid)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
                ->where('fund_type', '1')
                ->find();
            if ($bool) {
                return false;
            }
        }
        return true;
    }



    /**
     * 检察是否已经存在小组表
     * @param $status_id
     * @return bool
     */
    public function checkGroupOperate($status_id)
    {
        $bool = $this->table('yf_group_operate')
            ->where('status_id', $status_id)
            ->find();
        //不存在的时候
        if (!$bool) {
            return false;
        }
        return true;
    }

    /**
     * 保存
     * @param $status_id
     * @return bool
     */
    public function storeGroupOperate($status_id)
    {
        $data['status_id'] = $status_id;
        $data['create_at'] = time();
        $data['update_at'] = $data['create_at'];
        $bool = $this->table('yf_group_operate')
            ->insert($data);
        if (!$bool) {
            return false;
        }
        return true;
    }

    /**
     * 利用状态表的id查询是否已经存在
     * @param $status_id
     * @return bool
     */
    public function checkOperate($status_id)
    {
        $bool = $this->table('yf_operation')
            ->where('status_id', $status_id)
            ->find();
        //不存在的时候
        if (!$bool) {
            return false;
        }
        return true;
    }

    /**
     * 保存操作表记录
     * @param $status_id
     * @return bool
     */
    public function storeOperate($status_id)
    {
        $data['status_id'] = $status_id;
        $data['create_at'] = time();
        $data['update_at'] = $data['create_at'];
        $bool = $this->table('yf_operation')
            ->insert($data);
        //插入失败
        if (!$bool) {
            return false;
        }
        return true;
    }

    /**
     * 更新操作状态
     * @param $user_id
     * @param $status
     * @return bool
     */
    public function updateOperateStatus($user_id, $status)
    {
        $data['status'] = $status;
        $time = date('Y', time());
        $bool = ScholarshipsApplyStatus::where('user_id', $user_id)
//            ->where('fund_type',$fund_type)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update($data);
        //插入失败
        if (!$bool) {
            return false;
        }
        return true;
    }
}
