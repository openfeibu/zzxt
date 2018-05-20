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
     * 提交的时候就创建相应的状态记录表
     */
    public function store($application_id, $type)
    {
        $bool = ScholarshipsApplyStatus::where('application_id', $application_id)
					->find();
        if (!$bool) {
			$time = time();
            $data['fund_type'] = $type;
            $data['create_at'] = $time;
			$data['update_at'] = $time;
			$data['application_id'] = $application_id;
			$data['status'] = 1;
            $res = $this->save($data);
            if (!$res) {
                return false;
            }
            return true;
        }
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
    public function updateStatus($application_id,$type_id , $status)
    {
        $data['status'] = $status;
        $bool = ScholarshipsApplyStatus::where('application_id', $application_id)
					->where('fund_type',$type_id)
					->update($data);
        //插入失败
        if (!$bool) {
            return false;
        }
        return true;
    }
}
