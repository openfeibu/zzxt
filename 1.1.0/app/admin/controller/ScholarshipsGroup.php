<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/2
 * Time: 11:05
 */

namespace app\admin\controller;
use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use app\home\model\Scholarships;
use app\admin\model\User as UserModel;
use app\admin\model\Evaluation;
use think\Db;
use think\Request;

class ScholarshipsGroup extends Base
{
    private $multiple;
    private $applyStatus;
    private $user;
    private $time;

    public function __construct()
    {
        parent::__construct();
        //根据学号来取。登陆人的班级。限制
		$this->class_number = $this->admin['class_number'];
        //限制只显示今年申请的
        $this->time = date("Y",time());
        $this->multiple = new MultipleScholarship();
		$this->national = new NationalScholarship();
		$this->scholarships = new Scholarships();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->evaluation = new Evaluation();

    }

    public function showReviewList()
    {
        return $this->showReviewListHandle(1);
    }
    public function showReviewList2()
    {
        return $this->showReviewListHandle(2);
    }
    public function showReviewList3()
    {
        return $this->showReviewListHandle(3);
    }
    public function showReviewListHandle($id)
    {
        $where = " u.class_number =  ".$this->class_number;
        $status = input('status','');
        $studentname = input('studentname','');
		$count_where = ' u.class_number = '.$this->class_number;
        if($status)
        {
            $where .= " AND ass.status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        if($id == 1)
        {
            $data = $this->national->getNationalList($where);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = $this->multiple->getMultipleList($id,$where);
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
		$doingcount = $this->scholarships->getCount($id,$count_where.' and check_status in (1)');
		//总得人数
		$allcount = $this->scholarships->getCount($id,$count_where);
        $this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('type_id', $id);
        $this->assign('user', $data_arr);
        $this->assign('list', $data_arr);
        $this->assign('page', $show);
        $detail_url = url('admin/ScholarshipsGroup/showMaterial'.$id,['type_id'=>$id]);
        $this->assign('detail_url',$detail_url);
        if(request()->isAjax()){
			return $this->fetch('ajax_showApplicantList');
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
		
		$where = " u.class_number =  ".$this->class_number;
		$where .= " AND check_status in(1,2,3,4,5,6,7,8,9) ";
		$previous_url = $this->scholarships->getScholarshipPreviousUrl($type_id,$apply_id,'StudentOffice/showMaterial'.$type_id,$where);
		$next_url = $this->scholarships->getScholarshipNextUrl($type_id,$apply_id,'Scholarships_group/showMaterial'.$type_id,$where);

		$this->assign('previous_url', $previous_url);
		$this->assign('next_url', $next_url);
		
        return $this->view->fetch('showMaterial');
    }
}
