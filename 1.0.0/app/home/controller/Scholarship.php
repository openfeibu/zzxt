<?php

namespace app\home\controller;

use think\Request;
use think\Db;
use app\home\model\NationalScholarship;
use app\home\model\MultipleScholarship;
class Scholarship extends Base
{

    /**
     * 提交国家奖学金
     * @param Request $request
     */
    public function submitNation(Request $request)
    {
        $model = new NationalScholarship();
        if ($request->isPost()) {
            $data = $request->post();
            //检查学生是否已经提交过了
            $bool = $model->check($this->user_id, $this->time);
            //不存在则创建
            if (!$bool) {
                $data['create_at'] = time();
                $data['update_at'] = $data['create_at'];
                $data['user_id'] = $this->user_id;
				$subsidy = Db::table('yf_set_subsidy')
                ->where('id', 1)
                ->find();
				$begintime = $subsidy['begin_time'];
				$data['times'] = $begintime;
                $bool = NationalScholarship::create($data);
                return $this->redirect();
            }
            //存在的时候，则更新。
            $data['update_at'] = time();
            $bool = NationalScholarship::where('user_id', $this->user_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->update($data);
            if (!$bool) {
                return $this->error("更新失败");
            }
            return $this->success('更新成功');
        }
        //获取学生的奖学金和学生信息
        $res = $model->getStudentScholarship($this->user_id, $this->time);
        $this->assign('list', $res);
//        return $this->fetch('./index/nation');
    }

    /**
     * 励志奖学金和助学金
     * @param Request $request
     * @return mixed|void
     */
    public function doubleScholarship(Request $request)
    {
        if ($request->isPost()){
            $data = $request->post();
            $type = $data['type'];
            $type = 1;
            $model = new MultipleScholarship();
            if ($model->check($type, $this->user_id, $this->time)) {
				$subsidy = Db::table('yf_set_subsidy')
                ->where('id', $type)
                ->find();
				$begintime = $subsidy['begin_time'];
				$data['times'] = $begintime;
                $bool = $model->updateData($this->user_id, $type, $this->time, $data);
                if (!$bool) {
                    return $this->error("更新失败");
                }
                return $this->success("更新成功");
            }
            return $this->success("提交成功");
        }
        $data = Db::table('multiple_scholarship')
            ->where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        $this->assign("list", $data);
        return $this->fetch('');
    }
}
