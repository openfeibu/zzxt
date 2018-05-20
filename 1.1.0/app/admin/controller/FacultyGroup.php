<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/3
 * Time: 15:38
 */

namespace app\admin\controller;

use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use app\home\model\Scholarships;
use app\admin\model\Evaluation;
use app\admin\model\ClassCode as ClassCodeModel;
use think\Config;
use think\Db;
use think\Request;

class FacultyGroup extends Base
{
    private $multiple;
    private $national;
    private $applyStatus;
    private $time;
    private $faculty;

    public function __construct()
    {
        parent::__construct();
        $this->time = date('Y', time());
        $this->faculty = $this->admin['faculty_number'];
        $this->classCode = new ClassCodeModel();
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->scholarships = new Scholarships();
		$this->evaluation = new Evaluation();
        $classes = $this->classCode->getFacultyClasses($this->faculty);
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
        $studentname = input('studentname','');
        $status = input('status','');
        $class_number = input('class_number',0);
        $where = ' 1 = 1 ';
		$count_where = " u.faculty_number = ".$this->faculty." ";
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        if($status)
        {
            $where .= " AND ass.status = '".$status."'";
        }
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            $where .= " AND u.faculty_number = ".$this->faculty." ";
        }
        $order = "charindex(','+convert(varchar,check_status)+',',',3,2,1,4,5,6,7,8,9,')";
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
        }

        //待操作
		$doingcount = $this->scholarships->getCount($id,$count_where.' and check_status in (3)');
		//总得人数
		$allcount = $this->scholarships->getCount($id,$count_where);
		
        $this->assign('type_id', $id);
        $this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('faculty', $this->faculty);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);

        $detail_url = url('admin/FacultyGroup/showMaterial'.$id,['type_id'=>$id]);
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
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            $this->error("该学生没有填写申请表");
        }
		$id = $data['application_id'];
		$apply = $this->scholarships->getScholarship($data['fund_type'],$id);
        $this->assign('type_id', $type_id);
        $this->assign('id', $apply_id);
        $this->assign('user', $apply);
        return $this->view->fetch('showMaterial');
    }
   
    /**
     * 公示5天
     */
    public function showPublicity($id,$type_id) 
    {
        if ($type_id == 3 and $type_id == 2) {
            //助学金和励志奖学金
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $id)
                ->where('ass.status',3)
                ->where('ms.publicity_begin < '.time())
                ->where('ms.publicity_end >'.time())
                ->where('u.faculty_number', $this->faculty)
                ->paginate(20);
        } else {
            //奖学金
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_national_scholarship ms', 'ms.national_id = ass.national_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $id)
                ->where('ass.status',3)
                ->where('ms.publicity_begin < '.time())
                ->where('ms.publicity_end >'.time())
                ->where('u.faculty_number', $this->faculty)
                ->paginate(20);
        }
        $this->assign('list', $data);
        return $this->fetch(':notice_front/grants_notice');
    }

    /**
     * 查看学生列表（评估系统）
     */
    public function showEvaluationList() {
        $studentname = input('studentname','');
        $status = input('status','');
        $class_number = input('class_number',0);
        $where = ' 1 = 1 ';
		$count_where = " u.faculty_number = ".$this->faculty." ";
        if($studentname)
        {
            $where = " (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        if($status)
        {
            $where .= " AND ass.status = '".$status."'";
        }
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            $where .= " AND u.faculty_number = ".$this->faculty." ";
        }
        $order = "charindex(','+convert(varchar,status)+',',',3,1,2,4,5,6,7,8,9,')";
        $where .= " AND ass.status in(1,2,3,4,5,6,7,8,9)";
        $data = $this->evaluation->getEvaluationList($where,$order);
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $data_arr = $data->all();
        $data_arr = Evaluation::handleEvaluationList($data_arr);
		
		$doingcount = $this->evaluation->getCount($count_where.' and evaluation_status in (3)');
		//总得人数
		$allcount = $this->evaluation->getCount($count_where);
		
		$this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('faculty', $this->faculty);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        if(request()->isAjax()){
			return $this->fetch('evaluation/faculty_ajax_review');
		}else{
			return $this->fetch('evaluation/faculty_review');
		}
    }

    /**
     * 查看学生信息（评估系统）
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

        $apply = handleApply($apply);

        $apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app',$apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);

        $this->assign('status_id', $id);
        $this->assign('user', $apply);

        $material = \app\admin\model\Evaluation::getEvaluationMaterial($apply['evaluation_id']);
        $this->assign('material', $material);

        return $this->view->fetch('evaluation/faculty_add_review');
    }

    /**
     * 公示5天
     */
    public function showEvaluationPublicity($id) {
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $id)
                ->where('ass.status',3)
                ->where('ms.publicity_begin < '.time())
                ->where('ms.publicity_end >'.time())
                ->where('u.faculty_number', $this->faculty)
                ->paginate(20);
        $this->assign('list', $data);
        return $this->fetch();
    }
}
