<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/8/2
 * Time: 13:34
 */

namespace app\home\controller;

use think\Db;
class Survey extends Base
{
    /**
     * 显示调查问卷的界面
     */
    public function showSurvey()
    {

        //接收问卷调查信息
        if (request()->isPost()) {
            $data = request()->post();
            $arr['reply_profession'] = $data['profession'];
            $arr['reply_gender'] = $data['gender'];
            $arr['reply_grade'] = $data['grade'];
            unset($data['profession'],$data['grade'],$data['gender']);
            $arr['reply'] = json_encode($data,JSON_FORCE_OBJECT);
            $arr['create_at'] = time();
            $arr['update_at'] = $arr['create_at'];
            $arr['user_id'] = $this->user_id;
            $bool = Db::table('yf_reply')
                ->insert($arr);
            if (!$bool) {
                return $this->error("提交有误，请重新提交");
            }
            return redirect('/evalu_status');
        }

        //显示问卷调查
        $is_reply = Db::table('yf_reply')
            ->where('user_id', $this->user_id)
            ->find();


        $is_open = DB::table('yf_question_switch')
            ->where('is_open',1)
            ->find();
        if ($is_open) {
            //判断问卷调查是否打开
            //判断问卷调查是否更新
            if ($is_reply) {
                //判断是否提交过问卷调查
                return redirect('/evalu_status');
            } else {
                $user = Db::table('yf_user')
                    ->where('studentid', $this->user_id)
                    ->find();
                $data = Db::table('yf_question_title')
                    ->alias('qt')
                    ->join('yf_questions q', 'qt.classification_id = q.question_title_id', 'left')
                    ->field('q.*,qt.classification_id,qt.title')
                    ->select();
                $list = Db::table('yf_question_title')
                    ->select();
                foreach ($data as $key => $val) {
                    $data[$key]['question_options'] = json_decode($val['question_options'], true);
                }
                $this->assign('user_info', $user);
                $this->assign('title', $list);
                $this->assign('list', $data);
                return $this->view->fetch('student_personal_front/questionnaire');
            }
        } else {
            return redirect('/evalu_status');
        }



    }
}