<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/7/31
 * Time: 19:08
 */

namespace app\home\controller;

use think\Controller;
use think\Request;
use think\Db;
use app\home\model\Resume;
class WorkStudy extends Base
{
//    private $user_id = '29155533219';

    /**
     * 显示界面
     * @param Request $request
     * @return string
     */
    public function index(Request $request)
    {
        $user_info = Db::table('yf_user')
            ->where('studentid', $this->user_id)
            ->field('studentname,gender,profession,class,department_name,birthday,nation,political,id_number')
            ->find();
        $this->assign('user_info', $user_info);
        if ($request->isPost()){
            $data = $request->post();
            $data['user_id'] = $data['studentid'];
            unset($data['studentname'],$data['studentid'],$data['gender'],$data['class'],$data['birthday'],$data['id_number'],$data['nation'],$data['political']);
            $user = Db::table('yf_resume')
                ->where('user_id', $this->user_id)
                ->find();
            if ($user) {
                $data['experience'] = json_encode($data['experience']);
                $data['update_at'] = time();
                $user = Db::table('yf_resume')
                    ->where('user_id', $this->user_id)
                    ->update($data);
                $data = Db::table('yf_resume')
                    ->alias('r')
                    ->join('yf_user u', 'u.studentid = r.user_id', 'right')
                    ->where('u.studentid', $this->user_id)
                    ->find();
                $this->assign('list', $data);
                return $this->view->fetch();
            }
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $data['user_id'] = $this->user_id;
            $data['experience'] = json_encode($data['experience']);
            $boole = Resume::create($data);
        }
        $data = Db::table('yf_resume')
            ->alias('r')
            ->join('yf_user u', 'u.studentid = r.user_id', 'right')
            ->where('u.studentid', $this->user_id)
            ->find();
        $this->assign('list', $data);
        return $this->view->fetch();
    }

    /**
     * 申请job
     */
    public function applyJob($id)
    {
//        $time = Db::table("yf_set_subsidy")
//            ->where('subsidy_name', '勤工助学')
//            ->find();
//        $now = time();
//        if ($now > $time['end_time'] or $now < $time['begin_time']) {
//            return $this->error('现在不是申请时间');
//        }
        $resume = Db::table('yf_resume')
            ->where('user_id', $this->user_id)
            ->find();
        if (!$resume) {
            return $this->error('你的简历还没有填写。请先填写您的简历',url('/admin/home/resume'));
        }
        $b = Db::table("yf_work_status")
            ->where('user_id', $this->user_id)
            ->where('work_apply_id', $id)
            ->find();
        if ($b) {
            return $this->error("你已经申请过该岗位了");
        }
        $insert = Db::table(config('database.prefix').'work_status')
            ->insert([
                'user_id' => $this->user_id,
                'work_apply_id' => $id,
                'create_at' => time(),
                'update_at' => time(),
            ]);
        if (!$insert) {
            return $this->error("申请失败");
        }
        return $this->success("申请成功");
    }

    /**
     * 显示所有工作岗位
     */
    public function workStudyList()
    {
        $data = Db::table('yf_work_apply_table')
            ->alias('w')
//            ->where('begin_time <= '.time())
//            ->where("end_time >=".time())
                ->field("*,(select count(*) from yf_work_status where work_apply_id = w.work_id ) as count")
            ->paginate(20);
        $this->assign('list', $data);
        return $this->view->fetch();
    }

    /**
     * 查看自己所有申请的列表
     */
    public function showStatusList()
    {
        $data = Db::table('yf_work_status')
            ->alias('ws')
            ->join('yf_work_apply_table wat', 'ws.work_apply_id = wat.work_id', 'left')
            ->field('wat.*,ws.work_apply_id,ws.status')
            ->where('user_id', $this->user_id)
            ->paginate(20);
//        halt($data->getCollection());
        $this->assign('list',$data);
        return $this->view->fetch();
    }

    /**
     * ajax显示简历的工作啥的
     */
    public function ajaxForExp(Request $request)
    {
        $user = $this->user_id;
        $data = Db::table('yf_resume')
            ->where("user_id", $user)
            ->find();
        return $data['experience'];
    }

}