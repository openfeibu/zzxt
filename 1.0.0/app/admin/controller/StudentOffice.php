<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/3
 * Time: 15:40
 */

namespace app\admin\controller;

use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use app\home\service\Scholarships;
use app\admin\model\ClassCode as ClassCodeModel;
use app\admin\model\Evaluation;
use app\admin\model\User as UserModel;
use think\Db;
use think\Config;
use think\Request;

class StudentOffice extends Base
{
    private $applyStatus;
    private $multiple;
    private $national;
    private $time;
    private $faculty;

    public function __construct()
    {
        parent::__construct();
        $this->time = date('Y', time());
        $this->faculty = 5;
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->scholarships = new Scholarships();
		$this->evaluation = new Evaluation();
        $this->classCode = new ClassCodeModel();
        $faculties = $this->classCode->getFaculties();
        $this->assign('faculties',$faculties);
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
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        $order = "charindex(','+convert(varchar,check_status)+',',',1,2,3,4,5,6,7,8,')";
        $where .= " AND check_status in(3,2,1,4,5,6,7,8)";
        if($id == 1)
        {
            $data = $this->national->getNationalList($where,$order);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = $this->multiple->getMultipleList($id,$where,$order);
        }
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
       //待操作
		$doingcount = $this->scholarships->getCount($id,' check_status in (4) ');
		//总得人数
		$allcount = $this->scholarships->getCount($id);
        $this->assign('type_id', $id);
        $this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('user', $data);
        $this->assign('page', $show);
        $detail_url = url('admin/StudentOffice/showMaterial'.$id,['type_id'=>$id]);
        $this->assign('detail_url',$detail_url);
        if(request()->isAjax()){
			return $this->fetch('ajax_showApplicationList');
		}else{
			return $this->fetch('showApplicantList');
		}
    }
    public function applicantListExport($id)
    {
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        if($id == 1)
        {
            $data = $this->national->getAllNationalList($where);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = MultipleScholarship::getAllMultipleList($where);
        }
        foreach ($data as $key => $val) {
            $data[$key]['status'] = config('check_status.'.$val['status']);
        }
        $field_titles = ['姓名','学号','院系','专业','班级','状态'];
        $fields = ['studentname','studentid','department_name','profession','class','status'];
        $table = config('application_type.'.$id).date('YmdHis');
        export_excel($data,$table,$field_titles,$fields);
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
            return $this->error("该学生没有填写申请表");
        }
		$user_model = new UserModel();
        $user_fields = UserModel::getUserFields('u');
        $user_fields = implode(',',$user_fields);
        //判断类型
        if ($data['fund_type'] == 1) {
            $type = "yf_national_scholarship";
            $field = "national_id";
            $id = $data['application_id'];
            $apply = Db::table($type)
               ->alias('w')
				->join('yf_member_list m', 'm.member_list_id = w.member_list_id')
				->join('yf_user u', 'u.id_number = m.id_number', 'left')
				->where($field,$id)
				->field('w.*,m.member_list_nickname,m.member_list_headpic,'.$user_fields)
				->find();
            if (!empty($apply['awards'])) {
                $apply['awards'] = json_decode($apply['awards'], true);
            } else {
                $apply['awards'][0]['date'] = '';
                $apply['awards'][0]['name'] = '';
                $apply['awards'][0]['unit'] = '';
            }
            if (!empty($apply['schoole_opinion'])) {
                $apply['schoole_opinion'] = json_decode($apply['schoole_opinion'], true);
            } else {
                $apply['schoole_opinion']['time'] = time();
                $apply['schoole_opinion']['text'] = '';
                $apply['schoole_opinion']['name'] = '';
            }
            $apply = handleApply($apply);
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id";
            $id = $data['application_id'];
            $apply = Db::table($type)
                ->alias('w')
				->join('yf_member_list m', 'm.member_list_id = w.member_list_id')
				->join('yf_user u', 'u.id_number = m.id_number', 'left')
				->where($field,$id)
				->field('w.*,m.member_list_nickname,m.member_list_headpic,'.$user_fields)
				->find();
            if (!empty($apply['members'])) {
                $apply['members'] = json_decode($apply['members'], true);
            } else {
                $apply['members'][0]['name'] = '';
                $apply['members'][0]['age'] = '';
                $apply['members'][0]['relation'] = '';
                $apply['members'][0]['unit'] = '';
            }

            if (!empty($apply['schoole_opinion'])) {
                $apply['schoole_opinion'] = json_decode($apply['schoole_opinion'], true);
            } else {
                $apply['schoole_opinion']['time'] = time();
                $apply['schoole_opinion']['text'] = '';
                $apply['schoole_opinion']['name'] = '';
            }
            $apply = handleApply($apply);

        }
	
        $this->assign('type_id', $type_id);
        $this->assign('id', $apply_id);
        $this->assign('user', $apply);
        return $this->view->fetch('showMaterial');
    }

    /**
     * 公示5天
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function showPublicity($id,$type_id)
    {
        if ($type_id == 3 and $type_id == 2) {
            //助学金
            $data = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->join('yf_multiple_scholarship ms', 'ms.multiple_id = ass.multiple_id', 'left')
                ->field('ms.*,u.*')
                ->where('ass.fund_type', $id)
                ->where('ass.status',4)
                ->where('ms.office_begin < '.time())
                ->where('ms.office_end >'.time())
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
                ->where('ass.status',4)
                ->where('ms.office_begin < '.time())
                ->where('ms.office_end >'.time())
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
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        $order = "charindex(','+convert(varchar,status)+',',',4,3,1,2,5,6,7,8,')";
        $where .= " AND ass.status in(1,2,3,4,5,6,7,8)";
        $data = $this->evaluation->getEvaluationList($where,$order);
        $show=$data->render();
		$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $data_arr = $data->all();
        foreach ($data as $key => $val) {
            $data_arr[$key]['material_score'] = Evaluation::getMaterilaScore($val['evaluation_id']);
            $data_arr[$key]['rank'] = Evaluation::getGrade($val['score']);
        }
		$doingcount = $this->evaluation->getCount(' evaluation_status in (4)');
		//总得人数
		$allcount = $this->evaluation->getCount();
		
		$this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('faculty', $this->faculty);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        $this->assign('status', [4,5,9]);
        if(request()->isAjax()){
			return $this->fetch('evaluation/manage_ajax_review');
		}else{
			return $this->fetch('evaluation/manage_review');
		}
    }
    public function showEvaluationListExport()
    {
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        $data = $this->evaluation->getAllEvaluationList($where);
        foreach ($data as $key => $val) {
            $data[$key]['rank'] = Evaluation::getGrade($val['score']);
            $data[$key]['status'] = config('evaluation_status.'.$val['status']);
        }
        $field_titles = ['姓名','学号','专业','系统分','评议分','总分','评定等级','状态'];
        $fields = ['studentname','studentid','profession','assess_fraction','change_fraction','score','rank','status'];
        $table = '学生家庭经济困难认定'.date('YmdHis');
        export_excel($data,$table,$field_titles,$fields);
    }
    public function showEvaluationMaterialConfigs() {
        $material_configs = \app\admin\model\EvaluationMaterialConfig::getConfigs();
        $this->assign('material_configs', $material_configs);
        return $this->view->fetch('evaluation/material_configs');
    }
    public function material_config_runedit()
    {
        $cid = input('cid');
        $score = input('score');
        if(!$cid){
            $this->error('参数错误！');
        }
        $data = [
            'score' => $score
        ];
        $rst = Db::name('evaluation_material_config')->where('cid',$cid)->update($data);
        if($rst!==false){
            $this->success('提交成功');
        }else{
            $this->error('提交失败');
        }
    }
    public function evaluation_grade()
    {
        $grade_configs = \app\admin\model\Evaluation::getGradeConfigs();
        $this->assign('grade_configs', $grade_configs);
        return $this->view->fetch('evaluation/evaluation_grades');
    }
    public function grade_config_runedit()
    {
        $id = input('id');
        if(!$id){
            $this->error('参数错误！');
        }
        if(input('min') !== null)
        {
            $data = [
                'min' => input('min')
            ];
        }
        else {
            $data = [
                'max' => input('max')
            ];
        }

        $rst = Db::name('evaluation_grade')->where('id',$id)->update($data);
        if($rst!==false){
            $this->success('提交成功');
        }else{
            $this->error('提交失败');
        }
    }
    public function numberConfig()
    {

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
        $apply = Db::table('yf_evaluation_application')
            ->alias('app')
            ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->field('u.*,app.*')
            ->where('evaluation_id',$data['evaluation_id'])
            ->find();
        $apply = handleApply($apply);
        $apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app', $apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);
        $this->assign('status_id', $id);
        $this->assign('user', $apply);
        $material = \app\admin\model\Evaluation::getEvaluationMaterial($apply['evaluation_id']);
        $this->assign('material', $material);
        return $this->view->fetch('evaluation/manage_add_review');
    }
}
