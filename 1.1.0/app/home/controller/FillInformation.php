<?php

namespace app\home\controller;

use app\home\model\UserIdentify;
use think\Request;
use think\Db;
use think\Validate;
use app\home\controller\OperateLog;
use app\home\controller\Automatic;
use app\home\model\Status;
class FillInformation extends Base
{
    /**
     * 提交经济认定单
     * @param Request $request
     */
    public function submitInformation(Request $request)
    {
        $data = $request->post();
        //查询出所有的字段
        $field = Db::table('identify_model')->select();
        //自定义验证规则
        foreach ($field as $row) {
            $v_d[$row['field']."|".$row['name']] = 'require';
        }
        //载入自定义验证规则
        $v = new Validate($v_d);
        //检察是否为空。为空就返回
        if (!$v->check($data)) {
            return $this->error($v->getError());
        }
        //查找到总状态表的id
        $id = Db::table('status')
            ->field('id')
            ->where('user_id', $this->user_id)
            ->find();
        //实例化
        $model = new UserIdentify();
        $log = new OperateLog();
        $auto = new Automatic();
        //检察数据库中是否已经有这个学生的记录
        if ($model->check($this->user_id)) {
            //有的情况下，更新
            $data['update_at'] = time();
            $bool = $model->where('user_id', $this->user_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->update($data);
            $log->addLog($this->user_id, "用户修改经济困难认定表");
            if (!$bool) {
                return $this->error('更新失败');
            }
            return $this->success("更新成功");
        }
        //计算提交上来的总的分值
        $score = array_sum($data);
        $data['update_at'] = time();
        $data['create_at'] = time();
        $data['user_id'] = $this->user_id;
        $bool = UserIdentify::create($data);
        $sqlid = $bool->getLastInsID();
        $model = new Status();
        $model->checkStatus($this->user_id, date('Y', time()), $sqlid, 'user_identify_id');
        //查找到总状态表的id
        $id = Db::table('status')
            ->field('id')
            ->where('user_id', $this->user_id)
            ->find();
        //更新到小组操作表中的分数
        Db::table('group_operate')
            ->where('status_id', $id['id'])
            ->update([
                'group_score' => $score
            ]);
        //更新操作记录表
        $log->addLog($this->user_id, "系统自动评分");
        $auto->automaticRating($this->user_id);
        return $this->success("提交成功");
    }

    /**
     * 学生端显示认定表
     * @param Request $request
     * @return mixed|void
     */
    public function showForm(Request $request)
    {
        //如果是post请求上来的。
        if ($request->isPost()) {
            return $this->submitInformation($request);
        }
        //显示
        $data = Db::table('identify_model')
            ->select();
        foreach ($data as $key =>$val) {
            $data[$key]['score'] = json_decode($val['score'], true);
        }
        $this->assign('list', $data);
        return $this->fetch('./index/identify_bbb');
    }

    /**
     * 用户打开家庭认定信息啥的。ajax返回所填写的
     * @param Request $request
     * @return array|false|mixed|\PDOStatement|string|\think\Model|void
     */
    public function ajaxForStudent(Request $request)
    {
        $data = Db::table('user_identify')
            ->where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        //如果不存在的话，就返回空白
        if (empty($data)){
            return;
        }
        array_pop($data);
        array_shift($data);
        unset($data['user_id'], $data['update_at'], $data['create_at']);
        return $data;
    }

}
