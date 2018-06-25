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
        //构造评语什么的
        $array['text'] = $data['group_opinion']['text'];
        $array['name'] = '';
        $array['time'] = time();
        $evdata['group_opinion'] = json_encode($array);
		$evdata['group_poor_grade'] = $data['poor_grade'];
        $id = $data['status_id'];
        $evaluation_id = $data['evaluation_id'];
        //更新
        $evaluation_model = new Evaluation();
        $eval_app = $evaluation_model->getEvaluation($evaluation_id);
		$data['change_fraction'] = isset($data['change_fraction']) ? $data['change_fraction'] : 0;
        $evdata['score'] = intval($eval_app['assess_fraction']) + intval($data['change_fraction']) ;
        $evdata['change_fraction'] = intval($data['change_fraction']);
		
        return $this->fill($data,$evdata,$status);
    }
    public function counselorAll()
    {
        $p = input('p');
        $ids = input('n_ids/a');
        //$change_fractions = input('change_fractions/a');
        $group_opinions = input('opinions/a');
		$group_poor_grades = input('poor_grades/a');
        if(empty($ids)){
            $this -> error("请选择数据");
        }
        if(is_array($ids)){//判断获取文章ID的形式是否数组
            $where = 'evaluation_id in('.implode(',',$ids).')';
        }else{
            $where = 'evaluation_id='.$ids;
        }
        $esdata = Db::name('evaluation_status')->where($where)->select();
        if (input('fail') !== null and !empty(input('fail'))) {
            $evdata['evaluation_status'] = $status = 7;
        } else {
            $evdata['evaluation_status'] = $status = 3;
        }
		$evaluation_model = new Evaluation();
        foreach($esdata as $key => $val)
        {
			$eval_app = $evaluation_model->getEvaluation($val['evaluation_id']);
            $k = array_search($val['evaluation_id'], $ids);
            $data['status_id'] = $val['status_id'];
            //构造评语什么的
            $array['text'] = $group_opinions[$k];
            $array['name'] = '';
            $array['time'] = time();
            $evdata['group_opinion'] = json_encode($array);
			$evdata['group_poor_grade'] = $group_poor_grades[$k];
           // $evdata['score'] = intval($eval_app['assess_fraction']) + intval($change_fractions[$k]) ;
           // $evdata['change_fraction'] = intval($change_fractions[$k]);
            $this->fill($data,$evdata,$status);
        }
        $this->success("操作成功");
    }
    public function faculty(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $evdata['evaluation_status'] = $status = 8;
        } else {
            $evdata['evaluation_status'] = $status = 4;
        }
        //构造评语什么的
        $array['text'] = $data['faculty_opinion']['text'];
        $array['name'] = '';
        $array['time'] = time();
        $evdata['faculty_opinion'] = json_encode($array);
		$evdata['faculty_poor_grade'] = $data['poor_grade'];
        //var_dump($evdata);exit;
        $data['publicity_begin'] = time();
        //5天
        $data['publicity_end'] = time() + 60*60*24*5;
        return $this->fill($data,$evdata,$status);
    }

    public function facultyAll()
    {
        $p = input('p');
        $ids = input('n_ids/a');
        $faculty_opinions = input('opinions/a');
		$faculty_poor_grades = input('poor_grades/a');
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
            $evdata['evaluation_status'] = $status = 8;
        } else {
            $evdata['evaluation_status'] = $status = 4;
        }
        foreach($esdata as $key => $val)
        {
            $k = array_search($val['evaluation_id'], $ids);
            $data['status_id'] = $val['status_id'];
            //构造评语什么的
            $array['text'] = $faculty_opinions[$k];
            $array['name'] = '';
            $array['time'] = time();
            $evdata['faculty_opinion'] = json_encode($array);
			$evdata['faculty_poor_grade'] = $faculty_poor_grades[$k];
            $data['publicity_begin'] = time();
            //5天
            $data['publicity_end'] = time() + 60*60*24*5;
            $this->fill($data,$evdata,$status);
        }
        $this->success("操作成功");
    }
    public function studentOffice(Request $request)
    {
        $data = $request->post();
		$array['text'] = $data['school_opinion']['text'];
        $array['name'] = '';
        $array['time'] = time();
        $evdata['school_opinion'] = json_encode($array);
		$evdata['school_poor_grade'] = $data['poor_grade'];
        if (isset($data['fail']) and !empty($data['fail'])) {
            $evdata['evaluation_status'] = $status = 9;
        } else {
            $evdata['evaluation_status'] = $status = 5;
        }
		$evdata['school_poor_grade'] = $data['poor_grade'];
		$this->fill($data,$evdata,$status);
        $this->success("操作成功",url('admin/StudentOffice/showEvaluationList'));
    }
    public function studentOfficeAll()
    {
        $p = input('p');
        $ids = input('n_ids/a');
		$school_opinions = input('opinions/a');
		$school_poor_grades = input('poor_grades/a');
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
        foreach($esdata as $k => $val)
        {
            $data['status_id'] = $val['status_id'];
			
			//构造评语什么的
            $array['text'] = $school_opinions[$k];
            $array['name'] = '';
            $array['time'] = time();
            $evdata['school_opinion'] = json_encode($array);
			$evdata['school_poor_grade'] = $school_poor_grades[$k];
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
            'score' => isset($evdata['score']) ? $evdata['score'] : '',
            'status' => config('evaluation_status.'.$evdata['evaluation_status']),
            'rank' => isset($evdata['score']) ? Evaluation::getGrade($evdata['score']) : '',
        ];
    }
}
