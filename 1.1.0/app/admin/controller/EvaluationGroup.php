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
use app\admin\model\ClassCode as ClassCodeModel;

class EvaluationGroup extends Base
{
    private $user;
    private $time;

    public function __construct(Request $request = null)
    {
        parent::__construct($request);
		$this->class_number = $this->admin['class_number'];
        $this->classCode = new ClassCodeModel();
		$this->evaluation = new Evaluation();
        $this->time = date("Y",time());
		
    }

    /**
     * 获取申请学生列表(评估系统)
     */
    public function showEvaluationList() {
        $studentname = input('studentname','');
        $status = input('status','');

        $where = ' 1 = 1 ';
		$count_where = " u.class_number = '".$this->class_number."' ";
        if($studentname)
        {
            $where = " (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }

        //查找呃
        $where .= " AND u.class_number = '".$this->class_number."' ";

        $order = "charindex(','+convert(varchar,status)+',',',1,2,3,4,5,6,7,8,9,')";
        $where .= " AND ass.status in(1,2,3,4,5,6,7,8,9)";
        $data = $this->evaluation->getEvaluationList($where,$order);
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $data_arr = $data->all();
        $data_arr = Evaluation::handleEvaluationList($data_arr);

        $doingcount = $this->evaluation->getCount($count_where.' and evaluation_status in (1,2)');
		//总得人数
		$allcount = $this->evaluation->getCount($count_where);
		
		$this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        $this->assign('evaluation_status', config::get('evaluation_status'));
        if(request()->isAjax()){
			return $this->fetch('evaluation/class_ajax_review');
		}else{
			return $this->fetch('evaluation/class_review');
		}
    }

    /**
     * 查看学生资料(评估系统)
     */
    public function showEvaluationMaterial($id) {
        $data = Db::table('yf_evaluation_status')
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生没有填写申请表");
        }
		$evaluation_model = new Evaluation();
        $apply = $evaluation_model->getEvaluation($data['evaluation_id']);

        $apply = handleApply($apply);

        $this->assign('status_id', $id);
        $this->assign('user', $apply);
        $this->assign('user_info', $apply);
		$apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app',$apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);
        $material = \app\admin\model\Evaluation::getEvaluationMaterial($apply['evaluation_id']);
        $this->assign('material', $material);

        return $this->view->fetch('evaluation/class_add_review');
    }

}
