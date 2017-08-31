<?php

namespace app\home\controller;
//--废除。
use think\Controller;
use think\Request;
use think\Db;
use app\index\controller\OperateLog;
class Automatic extends Controller
{
    private $level;

    /**
     * 自动评分评等级
     */
    public function automaticRating($uid)
    {
////        $uid = '20155533301';
//        $user = Db::table('user_identify')
//            ->where('user_id', $uid)
//            ->find();
//        $grade = Db::table('identify_model')
//            ->field('field,score')
//            ->select();
//        $this->level = Db::table('evaluation')
//            ->field('evaluation_level,evaluation_instructions')
//            ->select();
//        //json转array
//        foreach ($grade as $key => $val) {
//            $grade[$key]['score'] = json_decode($val['score'], true);
//        }
//        $array = [];
//        $arr = [];
//        //将两个数组合并
//        foreach ($grade as $key => $val) {
//            $val['score']['score'] = $user[$val['field']];
//            $array[$val['field']] = $val['score'];
//            foreach ($array[$val['field']] as $k => $v) {
//                if ($k == 'score'){
//                    continue;
//                }
//                if ($array[$val['field']][$k]['option_score'] == $array[$val['field']]['score']){
//                    $arr[$val['field']] = $v['level'];
//                }
//            }
//        }
//        //排序，将等级数字最小的排在最前面，只要判断第一个就可以判断是什么类型的例如
//        //第一个为1.那就直接为经济特困，毕竟文档有说是这样
//        array_multisort($arr);
//        //为数组添加标识
//        $finally['user_id'] = $uid;
//        foreach ($arr as $k => $v) {
//            foreach ($this->level as $vv) {
//                if ($v == $vv['evaluation_level']){
//                    $finally['grade'] = $vv['evaluation_instructions'];
//                    break;
//                }
//                if (isset($finally['grade'])) break;
//            }
//        }
//        $time = date('Y', time());
//        //找到status的id
//        $status_id = Db::table('status')
//            ->where('user_id', $finally['user_id'])
//            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
//            ->field('id')
//            ->find();
//        $group = Db::table('group_operate')
//            ->where('status_id', $status_id['id'])
//            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $time")
//            ->update([
//                'group_grade' => $finally['grade'],
//                'update_at' => time()
//            ]);
//        $log = new OperateLog();
//        $log->addLog($uid, "系统自动评等级");

    }


}
