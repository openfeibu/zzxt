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
use app\admin\model\ClassCode as ClassCodeModel;
use app\admin\model\Evaluation;
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
        $this->classCode = new ClassCodeModel();
        $faculties = $this->classCode->getFaculties();
        $this->assign('faculties',$faculties);
    }
    public function showApplicantList()
    {
        return $this->showApplicantListHandle(3);
    }
    public function showApplicantList2()
    {
        return $this->showApplicantListHandle(2);
    }
    public function showApplicantList3()
    {
        return $this->showApplicantListHandle(1);
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
        if($id == 1)
        {
            $data = NationalScholarship::getNationalList($where);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = MultipleScholarship::getMultipleList($where);
        }
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
        $faculty_profession = $this->classCode->getFaculties();
        //绝笔要撕逼(未通过的)
        $faculty_count = Db::table('yf_apply_scholarships_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('ass.fund_type', $id)
            ->where('ass.status !=4')
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_apply_scholarships_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('ass.fund_type', $id)
            ->count();
        $this->assign('type_id', $id);
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty_name', '院系');
        $this->assign('faculty', $faculty_profession);
        $this->assign('user', $data);
        $this->assign('page', $show);
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
            $data = NationalScholarship::getAllNationalList($where);
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
    /**
     * 查看学生申请资料
     */
    public function showMaterial($id,$type_id)
    {
        $apply_id = $id;
        $data = Db::table('yf_apply_scholarships_status')
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生没有填写申请表");
        }
        //判断类型
        if ($data['fund_type'] == 1) {
            $type = "yf_national_scholarship";
            $field = "national_id";
            $id = $data['national_id'];
            $apply = Db::table($type)
                ->alias('w')
                ->join('yf_user u', 'u.studentid = w.user_id', 'left')
                ->where($field,$id)
                ->find();
            if (!empty($apply['awards'])) {
                $apply['awards'] = json_decode($apply['awards'], true);
            } else {
                $apply['awards'][0]['date'] = '';
                $apply['awards'][0]['name'] = '';
                $apply['awards'][0]['unit'] = '';
            }
            if (empty($apply['group_opinion'])) {
                return $this->error("小组未审核该同学");
            } else {
                $apply['group_opinion'] = json_decode($apply['group_opinion'], true);
            }
            if (!empty($apply['faculty_opinion'])) {
                $apply['faculty_opinion'] = json_decode($apply['faculty_opinion'], true);
            } else {
                return $this->error("院系小组未审核该同学");
            }
            if (!empty($apply['schoole_opinion'])) {
                $apply['schoole_opinion'] = json_decode($apply['schoole_opinion'], true);
            } else {
                $apply['schoole_opinion']['time'] = time();
                $apply['schoole_opinion']['text'] = '';
                $apply['schoole_opinion']['name'] = '';
            }
            $this->assign('type_id', $type_id);
            $this->assign('id', $apply_id);
            $this->assign('user', $apply);
            return $this->view->fetch('scholarship_team/manage_add_review');
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id";
            $id = $data['multiple_id'];
            $apply = Db::table($type)
                ->alias('w')
                ->join('yf_user u', 'u.studentid = w.user_id', 'left')
                ->where($field,$id)
                ->find();
            if (!empty($apply['members'])) {
                $apply['members'] = json_decode($apply['members'], true);
            } else {
                $apply['members'][0]['name'] = '';
                $apply['members'][0]['age'] = '';
                $apply['members'][0]['relation'] = '';
                $apply['members'][0]['unit'] = '';
            }
            if (empty($apply['group_opinion'])) {
                return $this->error("小组未审核该同学");
            } else {
                $apply['group_opinion'] = json_decode($apply['group_opinion'], true);
            }
            if (!empty($apply['faculty_opinion'])) {
                $apply['faculty_opinion'] = json_decode($apply['faculty_opinion'], true);
            } else {
                return $this->error("院系小组未审核该同学");
            }
            if (!empty($apply['schoole_opinion'])) {
                $apply['schoole_opinion'] = json_decode($apply['schoole_opinion'], true);
            } else {
                $apply['schoole_opinion']['time'] = time();
                $apply['schoole_opinion']['text'] = '';
                $apply['schoole_opinion']['name'] = '';
            }
            $this->assign('type_id', $type_id);
            $this->assign('id', $apply_id);
            $this->assign('user', $apply);
            return $this->view->fetch();
        }
    }

    /**
    * 填写学生处意见（助学金，励志奖学金）
    */
    public function fillMultipleOpinion(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 7;
                unset($data['fail']);
            } else {
                $status = 4;
                unset($data['pass']);
            }
            //状态表id
            $id = $data['status_id'];
            //获取multiple_id
            $ssid = Db::table('yf_apply_scholarships_status')
                ->where('status_id', $id)
                ->field('multiple_id')
                ->find();
            //学号
            $uid = $data['user_id'];
            $type_id = $data['type_id'];
            //构造json
            $array['text'] = $data['schoole_opinion']['text'];
            $array['name'] = $data['schoole_opinion']['name'];
            $array['time'] = strtotime($data['schoole_opinion']['year']."-".$data['schoole_opinion']['month']."-".$data['schoole_opinion']['day']);
            $data['schoole_opinion'] = json_encode($array);
            $data['update_at'] = time();
            //删除没用的
            unset($data['user_id'],$data['status_id'],$data['type_id']);
            //设置公示时间
            if ($status ==4) {
                $data['office_begin'] = time();
                //5天
                $data['office_end'] = time() + 60*60*24*5;
            }
            //更新评语。
            $res = Db::table("yf_multiple_scholarship")
                ->where('user_id', $uid)
                ->where('multiple_id', $ssid['multiple_id'])
                ->update($data);
            if (!$res) {
                return $this->error("提交失败");
            }
            $this->applyStatus =  new ScholarshipsApplyStatus();
            //更新申请状态
            $res = Db::table('yf_apply_scholarships_status')
                ->where('fund_type', $type_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = ".date('Y',time()))
                ->where('user_id', $uid)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                return $this->error('插入状态失败');
            }
            return $this->success("提交成功",url('admin/StudentOffice/showMaterial',['id'=>$id,'type_id'=>$type_id]));
        }
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
     * 填写学生处意见（奖学金）
     * @param Request $request
     * @return mixed
     */
    public function fillNationalOpinion(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 7;
                unset($data['fail']);
            } else {
                $status = 4;
                unset($data['pass']);
            }
            //状态表id
            $id = $data['status_id'];
            //获取national_id
            $ssid = Db::table('yf_apply_scholarships_status')
                ->where('status_id', $id)
                ->field('national_id')
                ->find();
            //学号
            $uid = $data['user_id'];
            $type_id = $data['type_id'];
            //构造json
            $array['text'] = $data['schoole_opinion']['text'];
            $array['name'] = $data['schoole_opinion']['name'];
            $array['time'] = strtotime($data['schoole_opinion']['year']."-".$data['schoole_opinion']['month']."-".$data['schoole_opinion']['day']);
            $data['schoole_opinion'] = json_encode($array);
            $data['update_at'] = time();
            //删除没用的
            unset($data['user_id'],$data['status_id'],$data['type_id']);
            //设置公示时间
            if ($status ==4) {
                $data['office_begin'] = time();
                //5天
                $data['office_end'] = time() + 60*60*24*5;
            }
            //更新评语。
            $res = Db::table("yf_national_scholarship")
                ->where('user_id', $uid)
                ->where('national_id', $ssid['national_id'])
                ->update($data);
            if (!$res) {
                return $this->error("提交失败");
            }
            $this->applyStatus =  new ScholarshipsApplyStatus();
            //更新申请状态
            $res = Db::table('yf_apply_scholarships_status')
                ->where('fund_type', $type_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = ".date('Y',time()))
                ->where('user_id', $uid)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                return $this->error('插入状态失败');
            }
            return $this->success("提交成功",url('admin/StudentOffice/showMaterial',['id'=>$id,'type_id'=>$type_id]));
        }
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
        $data = Evaluation::getEvaluationList($where);
        $show=$data->render();
		$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $data_arr = $data->all();
        foreach ($data as $key => $val) {
            $data_arr[$key]['material_score'] = Evaluation::getMaterilaScore($val['evaluation_id']);
            $data_arr[$key]['rank'] = Evaluation::getGrade($val['score']);
        }

        //查院
        $faculty_profession = Db::table('yf_user')
            ->field("DISTINCT profession ,profession_number")
            ->where('faculty_number', $this->faculty)
            ->select();
        //未通过的
        $faculty_count = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('u.faculty_number', $this->faculty)
            ->where(function($query){
                $query->where('ass.status !=5');
            })
            ->where($where)
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('u.faculty_number', $this->faculty)
            ->where($where)
            ->count();
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty', $this->faculty);
        $this->assign('profession', $faculty_profession);
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
        $data = Evaluation::getAllEvaluationList($where);
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

    /**
     * 修改分数、填写评定结果
     */
    public function fillEvaluationOpinion(Request $request) {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $data['evaluation_status'] = $status = 9;
                unset($data['fail']);
            } else {
                $data['evaluation_status'] = $status = 5;
                unset($data['pass']);
            }
            //状态表id
            if (!empty($data['user_name'])) {
                $user_name = $data['user_name'];
            }

            $status_id = $data['status_id'];
            $ssid = Db::table('yf_evaluation_status')
                ->where('status_id', $status_id)
                ->field('evaluation_id')
                ->find();
            //学号
            $status_id = $data['status_id'];
            //构造json
            if (empty($data['school_opinion']['text'])) {
                $array['text'] = '经过院系小组讨论，该同学情况属实';
            } else {
                $array['text'] = $data['school_opinion']['text'];
            }
            if (empty($data['school_opinion']['name'])) {
                $array['name'] = $user_name;
            } else {
                $array['name'] = $data['school_opinion']['name'];
            }
            if (empty($data['school_opinion']['year'])) {
                $array['time'] = time();
            } else {
                $array['time'] = strtotime($data['school_opinion']['year']."-".$data['school_opinion']['month']."-".$data['school_opinion']['day']);
            }

            $data['school_opinion'] = json_encode($array);
            $data['update_at'] = time();
            $evaluation_model = new Evaluation();
			$eval_app = $evaluation_model->getEvaluation($data['evaluation_id']);
            $data['score'] = intval($eval_app['assess_fraction']) + intval($data['change_fraction']) ;
            //删除没用的
            unset($data['status_id'],$data['user_name'], $data['evaluation_id']);
            //设置公示时间
            if ($status == 4) {
                $data['publicity_begin'] = time();
                //5天
                $data['publicity_end'] = time() + 60*60*24*5;
            }
            //更新评语。
            $res = Db::table("yf_evaluation_application")
                ->where('evaluation_id', $ssid['evaluation_id'])
                ->update($data);
            if (!$res) {
                return $this->error("提交失败");
            }
            //更新申请状态
            $res = Db::table('yf_evaluation_status')
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('status_id', $status_id)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                return $this->error('插入状态失败');
            }
            $this->redirect('admin/StudentOffice/showEvaluationList');
        }
    }
}
