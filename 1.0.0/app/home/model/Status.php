<?php

namespace app\home\model;

use think\Model;
use app\home\model\GroupOpreate;
class Status extends Model
{
    protected $table = 'yf_status';
    /**
     * 查看状态表中是否有记录
     * @param $id 学号
     * @param $time 今年
     * @param $type_id 5个表中的id
     * @param $type 哪种表
     * @return $this|bool|false|int
     */
    public function checkStatus($id, $time, $type_id, $type)
    {
        $bool = Status::where('user_id', $id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        if (!$bool) {
            $status_id = $this->store($id, $type, $type_id);
            $bool =  $this->checkGroupOperate($status_id);
            $boole =  $this->checkOperate($status_id);
            //不存在的时候。就插入
            if (!$bool and !$boole) {
                $this->storeOperate($status_id);
                $this->storeGroupOperate($status_id);
                return true;
            }
        }
        return $this->updateStatus($id, $type, $type_id, $time);
    }

    /**
     * 插入记录到状态表中
     * @param $id 学号
     * @param $type 类型
     * @param $type_id 表的id
     * @return bool|false|int
     */
    protected function store($id, $type, $type_id)
    {
        $data['user_id'] = $id;
        $data['create_at'] = time();
        $data['update_at'] = $data['create_at'];
        $data[$type] = $type_id;
        $bool = Status::create($data);
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
    protected function updateStatus($id, $type, $type_id, $time)
    {
        $bool = $this->where('user_id', $id)
                     ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
                     ->update([
                          $type => $type_id
                      ]);
        return $bool;
    }

    /**
     * 选择类型的时候就创建相应的状态记录表
     * @param $id
     * @param $type
     * @param $time
     * @return bool
     */
    public function storeByChooseType($id, $type, $time)
    {
        $bool = Status::where('user_id', $id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->find();
        if (!$bool) {
            $data['fund_type'] = $type;
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $data['user_id'] = $id;
            $res = $this->save($data);
            if (!$res) {
                return false;
            }
        }
    }



    /**
     * 检察是否已经存在小组表
     * @param $status_id
     * @return bool
     */
    public function checkGroupOperate($status_id)
    {
        $bool = $this->table('group_operate')
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
        $bool = $this->table('group_operate')
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
        $bool = $this->table('operation')
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
        $bool = $this->table('operation')
            ->insert($data);
        if (!$bool) {
            return false;
        }
        return true;
    }

}
