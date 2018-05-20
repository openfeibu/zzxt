<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use think\Db;
class OperateLog extends Controller
{
    public function addLog($uid, $msg)
    {
        //查找到总状态表的id
        $id = Db::table('status')
            ->field('id')
            ->where('user_id', $uid)
            ->find();
        $message = Db::table('operation')
            ->field('instructions')
            ->where('status_id', $id['id'])
            ->find();
        $msg = $message['instructions'].date('Y-m-d H:i:s', time()).$msg.',';
        Db::table('operation')
            ->where('status_id', $id['id'])
            ->update([
                'instructions' => $msg
            ]);
    }

    public function passScholarship($uid, $status)
    {
        $time = date("Y", time());
        if ($status == 'pass') {
            $val = 1;
            $status_val = 1;
            $msg = "小组审核通过";
        } else {
            $val = 0;
            $status_val = 3;
            $msg = "小组审核未通过";
        }
        //获取status_id
        $status_id = Db::table('status')
            ->where('user_id', $uid)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->field('id')
            ->find();
        //设置group_operate表中为通过状态
        Db::table('group_operate')
            ->where('status_id', $status_id['id'])
            ->update([
                'group_operation' => $val,
                'update_at' => time()
            ]);
        //修改总表的状态
        Db::table('status')
            ->where('user_id', $uid)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
            ->update([
                'status' => $status_val,
                'update_at' => time()
            ]);
        //找到操作表的信息
        $message = Db::table('operation')
            ->field('instructions')
            ->where('status_id', $status_id['id'])
            ->find();
        //拼接信息
        $msg = $message['instructions'].date('Y-m-d H:i:s', time()).$msg.',';
        //插入信息
        Db::table('operation')
            ->where('status_id', $status_id['id'])
            ->update([
                'instructions' => $msg
            ]);
    }

}
