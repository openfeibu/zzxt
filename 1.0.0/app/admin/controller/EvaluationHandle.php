<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/18
 * Time: 15:01
 */

namespace app\admin\controller;
use think\Db;
use think\Config;
use think\Request;
use app\admin\model\Evaluation;

class EvaluationHandle extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->time = date('Y', time());
    }
    public function counselor(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $evdata['evaluation_status'] = $status = 7;
        } else {
            $evdata['evaluation_status'] = $status = 3;
        }
        return $this->fill($data,$evdata,$status);
    }
    public function faculty(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $evdata['evaluation_status'] = $status = 8;
        } else {
            $evdata['evaluation_status'] = $status = 4;
        }
        $data['publicity_begin'] = time();
        //5天
        $data['publicity_end'] = time() + 60*60*24*5;
        return $this->fill($data,$evdata,$status);
    }
    public function studentOffice(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $evdata['evaluation_status'] = $status = 9;
        } else {
            $evdata['evaluation_status'] = $status = 5;
        }
        return $this->fill($data,$evdata,$status);
    }
    public function studentOfficeAll()
    {
        $p = input('p');
        $ids = input('n_id/a');
        if(empty($ids)){
            $this -> error("请选择数据",url('admin/StudentOffice/showEvaluationList',array('p'=>$p)));
        }
        if(is_array($ids)){//判断获取文章ID的形式是否数组
            $where = 'evaluation_id in('.implode(',',$ids).')';
        }else{
            $where = 'evaluation_id='.$ids;
        }
        $esdata = Db::name('evaluation_status')->where($where)->select();
        if (input('fail') !== null and !empty(input('fail'))) {
            $evdata['evaluation_status'] = $status = 9;
        } else {
            $evdata['evaluation_status'] = $status = 5;
        }
        foreach($esdata as $key => $val)
        {
            $data['status_id'] = $val['status_id'];
            $this->fill($data,$evdata,$status);
        }
        $this->success("操作成功",url('admin/StudentOffice/showEvaluationList',array('p'=>$p)));
    }
    public function studentOfficeFailAll()
    {

    }
    public function evaluationGroup(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $evdata['evaluation_status'] = $status = 6;
        } else {
            $evdata['evaluation_status'] = $status = 2;
        }
        //构造评语什么的
        $array['text'] = $data['group_opinion']['text'];
        $array['name'] = $data['group_opinion']['name'];
        $array['time'] = strtotime($data['group_opinion']['year']."-".$data['group_opinion']['month']."-".$data['group_opinion']['day']);
        $evdata['group_opinion'] = json_encode($array);
        //状态表的id
        $id = $data['status_id'];
        $evaluation_id = $data['evaluation_id'];
        //更新
        $evaluation_model = new Evaluation();
        $eval_app = $evaluation_model->getEvaluation($evaluation_id);

        $evdata['score'] = intval($eval_app['assess_fraction']) + intval($data['change_fraction']) ;
        return $this->fill($data,$evdata,$status);
    }
    public function fill($data,$evdata,$status)
    {
        $status_id = $data['status_id'];
        $ssid = Db::table('yf_evaluation_status')
            ->where('status_id', $status_id)
            ->field('evaluation_id')
            ->find();
        $res = Db::table("yf_evaluation_application")
            ->where('evaluation_id', $ssid['evaluation_id'])
            ->update($evdata);
        //更新申请状态
        $res = Db::table('yf_evaluation_status')
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->where('status_id', $status_id)
            ->update([
                'update_at' => time(),
                'status' => $status
            ]);

        if (!$res) {
            return [
                'code' => '201',
                'msg' => '操作失败，请联系技术人员'
            ];
        }
        return [
            'code' => '200',
            'msg' => '操作成功',
        ];
    }
}
