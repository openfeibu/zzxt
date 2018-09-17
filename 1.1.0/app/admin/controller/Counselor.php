<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/2
 * Time: 20:14
 */

namespace app\admin\controller;

use app\home\model\ScholarshipsApplyStatus;
use app\home\model\NationalScholarship;
use app\admin\model\Evaluation;
use app\home\model\MultipleScholarship;
use app\home\model\Scholarships;
use app\admin\model\ClassCode as ClassCodeModel;
use think\Db;
use think\Config;
use think\Request;

class Counselor extends Base
{

    private $applyStatus;
    private $national;
    private $time;
    private $faculty;

    public function __construct()
    {
        parent::__construct();
        $this->national = new NationalScholarship();
		$this->multiple = new MultipleScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->scholarships = new Scholarships();
		$this->evaluation = new Evaluation();
        $this->time = date("Y",time());
        $this->faculty = $this->admin['faculty_number'];
        $this->classCode = new ClassCodeModel();
		$class_number = $this->admin['class_number'];
		$this->class_number = $class_number ? explode(',',$class_number) : [];
		$classes = $this->classCode->getCounselorClasses($class_number);
		$this->assign('classes', $classes);
    }
    public function showApplicantList()
    {
        return $this->showApplicantListHandle(1);
    }
    public function showApplicantList2()
    {
        return $this->showApplicantListHandle(2);
    }
    public function showApplicantList3()
    {
        return $this->showApplicantListHandle(3);
    }
    public function showApplicantListHandle($id)
    {
        $faculty_number = input('faculty_number',0);$this->assign('faculty_number', $faculty_number);
        $class_number = input('class_number',0);$this->assign('class_number',$class_number );
        $studentname = input('studentname',''); $this->assign('studentname',$studentname );
        $status = input('status','');$this->assign('status',$status );
        $where = " u.class_number in (".implode(',',$this->class_number).") ";
		$count_where = " u.class_number in (".implode(',',$this->class_number).") ";
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }
        if($status !== "")
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%' OR m.id_number LIKE '%".$studentname."%' )" ;
        }
        $order = "charindex(','+convert(varchar,check_status)+',',',1,2,3,4,5,6,7,8,9,')";
		
        $where .= " AND check_status in(1,2,3,4,5,6,7,8,9)";
        if($id == 1)
        {
            $data = $this->national->getNationalList($where,$order);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = $this->multiple->getMultipleList($id,$where,$order);		
        }
		
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
        $data_arr = $data->all();
        foreach($data_arr as $key => $value)
        {
            $data_arr[$key] = handleApply($value);
			$data_arr[$key]['poor_grade_name'] = $this->evaluation->getMemberEvaluationGradeName($value['member_list_id']);
        }

		//待操作
		$doingcount = $this->scholarships->getCount($id,$count_where.' and check_status in (1,2)');
		//总得人数
		$allcount = $this->scholarships->getCount($id,$count_where);

        $this->assign('type_id', $id);
        $this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        $detail_url = url('admin/Counselor/showMaterial'.$id,['type_id'=>$id]);
        $this->assign('detail_url',$detail_url);
        if(request()->isAjax()){
			return $this->fetch('ajax_showApplicationList');
		}else{
			return $this->fetch('showApplicantList');
		}
    }
    public function showMaterial1($type_id)
    {
        return $this->showMaterialHandle($type_id);
    }
    public function showMaterial2($type_id)
    {
        return $this->showMaterialHandle($type_id);
    }
    public function showMaterial3($type_id)
    {

        return $this->showMaterialHandle($type_id);
    }
    /**
     * 查看学生申请资料
     */
    public function showMaterialHandle($type_id)
    {
        $id = input('id');
        $apply_id = $id;
        $data = Db::table('yf_apply_scholarships_status')
            ->where('fund_type', $type_id)
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生没有填写申请表");
        }
        
		$id = $data['application_id'];
		$apply = $this->scholarships->getScholarship($data['fund_type'],$id);

		$this->assign('type_id', $type_id);
        $this->assign('id', $apply_id);
        $this->assign('user', $apply);
		
		$where = " u.class_number in (".implode(',',$this->class_number).") ";
		$where .= " AND check_status in(1,2,3,4,5,6,7,8,9) ";
		$previous_url = $this->scholarships->getScholarshipPreviousUrl($type_id,$apply_id,'Counselor/showMaterial'.$type_id,$where);
		$next_url = $this->scholarships->getScholarshipNextUrl($type_id,$apply_id,'Counselor/showMaterial'.$type_id,$where);

		$this->assign('previous_url', $previous_url);
		$this->assign('next_url', $next_url);
		
        return $this->view->fetch('showMaterial');
    }

    /**
     * 获取申请学生列表(评估系统)
     */
    public function showEvaluationList() {
        $class_number = input('class_number',0);$this->assign('class_number',$class_number );
        $studentname = input('studentname',''); $this->assign('studentname',$studentname );
        $status = input('status','');$this->assign('status',$status );
        $where = " u.class_number in (".implode(',',$this->class_number).") ";
		$count_where = " u.class_number in (".implode(',',$this->class_number).") ";
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }
        if($status !== "")
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%' OR m.id_number LIKE '%".$studentname."%' )" ;
        }
        $order = "charindex(','+convert(varchar,evaluation_status)+',',',0,1,2,3,4,5,6,7,8,9,')";
        $where .= " AND evaluation_status in(0,1,2,3,4,5,6,7,8,9)";
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
        if(request()->isAjax()){
			return $this->fetch('evaluation/counselor_ajax_review');
		}else{
			return $this->fetch('evaluation/counselor_review');
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
            $this->error("该学生没有填写申请表");
        }
		$evaluation_model = new Evaluation();
        $apply = $evaluation_model->getEvaluation($data['evaluation_id']);
        $apply = Evaluation::handleEvaluation($apply);

        $this->assign('status_id', $id);
        $this->assign('user', $apply);
		//$apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app',$apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);
        $material = \app\admin\model\Evaluation::getEvaluationMaterial($apply['evaluation_id']);
        $this->assign('material', $material);
		
		$where = " u.class_number in (".implode(',',$this->class_number).") ";
		$where .= " AND evaluation_status in(1,2,3,4,5,6,7,8,9) ";
		$previous_url = $this->evaluation->getEvaluationPreviousUrl($apply['evaluation_id'],'Counselor',$where);
		$next_url = $this->evaluation->getEvaluationNextUrl($apply['evaluation_id'],'Counselor',$where);

		$this->assign('previous_url', $previous_url);
		$this->assign('next_url', $next_url);
		
        return $this->view->fetch('evaluation/counselor_add_review');
    }
}
