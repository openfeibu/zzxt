<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/8/2
 * Time: 11:07
 */

namespace app\admin\controller;

use think\Db;
use think\Request;

class Survey extends Base
{
    /**
     * 显示调查问卷的界面
     */
    public function setting()
    {
        $data = Db::table('yf_question_title')
            ->select();
        $row = Db::table('yf_questions')
            ->select();
        foreach ($row as $key => $val) {
            $row[$key]['question_options'] = json_decode($val['question_options'], true);
        }

        $this->assign('list', $row);
        $this->assign('title', $data);
        return $this->fetch();
    }

    /**
     * 后端显示设置是否需要填写界面
     */
    public function setOpen()
    {
        if (request()->isAjax()) {
             Db::table('yf_question_switch')
                ->where('switch_id', 1)
                ->update(['is_open'=>request()->post('open')]);
            return [
                'code' => 200
            ];
        }
        $data = Db::table('yf_question_switch')
            ->find();
        $this->assign('list', $data);
        return $this->fetch();
    }

    /**
     * 添加选项
     */
    public function add(Request $request)
    {
        $data = $request->post();
        //添加分类
        if (isset($data['first_title']) and !empty($data['first_title'])) {
            if (empty($data['first_title'])) return false;
            $arr['title'] = $data['first_title'];
            $arr['create_at'] = time();
            $arr['update_at'] = $arr['create_at'];
            $bool = Db::table('yf_question_title')
                ->insert($arr);
            return $bool;
        }
        //添加标题子类
        if (isset($data['title']) and !empty($data['title'])) {
            if (empty($data['value'])){
                return false;
            }
//            echo 1;
            $arr['question_name'] = $data['value'];
            $arr['question_title_id'] = $data['title'];
            $arr['create_at'] = time();
            $arr['update_at'] = time();
            $bool = Db::table('yf_questions')
                ->insert($arr);
            return $bool;
        }
        //添加选项
        if (isset($data['option_id']) and !empty($data['option_id'])) {
            if (empty($data['option_value'])) {
                return false;
            }
            $r = Db::table('yf_questions')
                ->where('question_id', $data['option_id'])
                ->field('question_options')
                ->find();
            //空。新添加的
            if (empty($r['question_options'])) {
                $option = json_encode([
                    0 =>[
                        'type'=>$data['option_type'],
                        'text'=>$data['option_value']
                    ]
                ], JSON_FORCE_OBJECT);
//                $array['question_title_id'] = $data['option_id'];
                $array['question_options'] = $option;
                $array['create_at'] = time();
                $array['update_at'] = $array['create_at'];
                //入库
                $boole = Db::table('yf_questions')
                    ->where('question_id', $data['option_id'])
                    ->update($array);
                return $boole;
            } else {
                //转array
                $temp = json_decode($r['question_options'], true);
                //将新增的入站。保持顺序性
                array_push($temp,['type'=>$data['option_type'],'text'=>$data['option_value']]);
                //转化为带数字0、的json
                $array['question_options'] = json_encode($temp,JSON_FORCE_OBJECT);
                $array['update_at'] = time();
                //更新
                $bool = Db::table('yf_questions')
                    ->where('question_id', $data['option_id'])
                    ->update($array);
                return $bool;
            }
        }
    }
    /**
     * 修改
     */
    public function edit(Request $request)
    {
        $data = $request->post();
        //题目名称
        if (isset($data['title_id']) and !empty($data['title_id'])){
            if (empty($data['title_value'])) {
                return false;
            }
            $arr['question_name'] = $data['title_value'];
            $arr['update_at'] = time();
            $boole = Db::table('yf_questions')
                ->where('question_id', $data['title_id'])
                ->update($arr);
            return $boole;
        }
        //选项
        if (isset($data['title_name']) and !empty($data['title_name'])) {
            if (empty($data['option_val']) or empty($data['option_id']) or empty($data['select_type'])) {
                return false;
            }
            $arr = Db::table('yf_questions')
                ->where("question_id", $data['title_name'])
                ->field("question_options")
                ->find();
            $arr['question_options'] = json_decode($arr['question_options'], true);
            $arr['question_options'][$data['option_id']] = [
                'type' => $data['select_type'],
                'text' => $data['option_val']
            ];
            //修改内容。定位
            $bool = Db::table('yf_questions')
                ->where('question_id', $data['title_name'])
                ->update([
                    'question_options' => json_encode($arr['question_options'], JSON_FORCE_OBJECT),
                    'update_at' => time()
                ]);
            return $bool;
        }
        //差点漏了大标题
        if (isset($data['first_title']) and !empty($data['first_title'])) {
            if (empty($data['first_val'])) {
                return false;
            }
            $bool = Db::table('yf_question_title')
                ->where('classification_id', $data['first_title'])
                ->update([
                    'title' => $data['first_val'],
                    'update_at' => time()
                ]);
            return $bool;
        }
    }

    /**
     * 删除
     */
    public function delete(Request $request)
    {
        $data = $request->post();
        //删除大的
        if (isset($data['title_id'])) {
            $bool = Db::table("yf_question_title")
                ->where("classification_id", $data['title_id'])
                ->delete();
            return $bool;
        }
        //题目
        if (isset($data['topic_id'])) {
            $bool = Db::table("yf_questions")
                ->where("question_id", $data['topic_id'])
                ->delete();
            return $bool;
        }
        //选项
        if (isset($data['option_id']) and isset($data['topic'])) {
            $arr = Db::table('yf_questions')
                ->where('question_id',$data['topic'])
                ->field('question_options')
                ->find();
            $arr['question_options'] = json_decode($arr['question_options'], true);
            unset($arr['question_options'][$data['option_id']]);
            $arr['question_options'] = array_merge($arr['question_options']);
            $bool = Db::table('yf_questions')
                ->where('question_id', $data['topic'])
                ->update([
                    'question_options' => json_encode($arr['question_options'], JSON_FORCE_OBJECT),
                    'update_at' => time()
                ]);
            return $bool;
        }
    }

    /**
     * 统计报表
     */
    public function table()
    {
        $data = Db::table('yf_reply')
            ->select();
        //将json转array（学生的回答）
        foreach ($data as $key => $val) {
            $data[$key]['reply'] = json_decode($val['reply'], true);
        }
        $options = Db::table('yf_questions')
            ->select();
        //问题。每一个选项转化为array
        foreach ($options as $key => $val) {
            $options[$key]['question_options'] = json_decode($val['question_options'], true);
        }
        //循环每一个问题
        foreach ($options as $key => $val) {
            //将每一个选项格式化为0，用来记录次数
            foreach ($options[$key]['question_options'] as $kk => $s) {
                $options[$key]['question_options'][$kk]['count'] = 0;
            }
            //循环学生
            foreach ($data as $k => $v) {
                //学生的回答
                foreach($v['reply'] as $kkk => $vvv) {
                    //如果学生的回答的id是等于问题的回答
                    if ($kkk == $val['question_id']) {
                        //如果是一个数组。数组代表其他。其他就是意味着储存了id还有文字说明
                        if (is_array($vvv)) {
                            //计数+1
                            if(isset($vvv)) {
                                continue;
                            } else {
                                $options[$key]['question_options'][$vvv[0]]['count']++;
                                continue;
                            }
                        }
                        //计数+1
                        $options[$key]['question_options'][$vvv]['count']++;
                    }
                }
            }
        }
//        dump($options);
//        $options = array_slice($options,0,3);
        $this->assign('list', $options);
        return $this->view->fetch();
    }
}