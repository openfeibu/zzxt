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
use app\admin\model\ClassCode as ClassCodeModel;
use app\admin\model\User as UserModel;
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
        $this->applyStatus = new ScholarshipsApplyStatus();
        $this->time = date("Y",time());
        $this->faculty = session('admin_auth.faculty_number');
        $this->classCode = new ClassCodeModel();
		$admin_professiones = session('admin_professiones');
		$classes = $this->classCode->getCounselorClasses($admin_professiones);
		$this->class_number = array_column($classes, 'class_number');
		$this->assign('classes', $classes);
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
            $where .= " AND u.class_number in (".implode(',',$this->class_number).") ";
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
        $where .= " AND check_status in(1,2,3,4,5,6,7,8)";
        if($id == 1)
        {
            $data = NationalScholarship::getNationalList($where,$order);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = MultipleScholarship::getMultipleList($where,$order);
        }
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
        $data_arr = $data->all();
        foreach($data_arr as $key => $value)
        {
            $data_arr[$key] = handleApply($value);
        }
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
		if ($id == 3) {
            $name = "国家助学金";
        } elseif($id == 2) {
            $name = "国家励志奖学金";
        }
        $this->assign('type_id', $id);
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty_name', '院系');
        $this->assign('faculty', $faculty_profession);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        if(request()->isAjax()){
			return $this->fetch('scholarship_team/counselor_ajax_review');
		}else{
			return $this->fetch('scholarship_team/counselor_review');
		}
    }
    /**
     * 获取申请学生列表(国家奖学金)
     */
    public function showNationalList() {
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            $where .= " AND u.class_number in (".implode(',',$this->class_number).") ";
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
        $data = NationalScholarship::getNationalList($where);
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
		$faculty_pass = 0;
		$faculty_not_pass = 0;
		$this->assign('faculty_pass', $faculty_pass);
		$this->assign('faculty_not_pass', $faculty_not_pass);
        $this->assign('user', $data);
        $this->assign('page', $show);
        if(request()->isAjax()){
			return $this->fetch('scholarship_team/counselor_ajax_review');
		}else{
			return $this->fetch('scholarship_team/counselor_review');
		}
    }

    /**
     * 查看学生申请资料
     */
    public function showMaterial($id,$type_id) {
        $apply_id = $id;
        $data = Db::table('yf_apply_scholarships_status')
            ->where('fund_type', $type_id)
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
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id";
            $id = $data['multiple_id'];
        }
        $user_model = new UserModel();
        $user_fields = UserModel::getUserFields('u');
        $user_fields = implode(',',$user_fields);
        $apply = Db::table($type)
            ->alias('w')
            ->join('yf_member_list m', 'm.member_list_id = w.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where($field,$id)
            ->field('w.*,m.member_list_nickname,m.member_list_headpic,'.$user_fields)
            ->find();

        if (!empty($apply['awards'])) {
            $apply['awards'] = json_decode($apply['awards'], true);
        }
		if(!isset($apply['awards']) || !is_array($apply['awards'])){
			$apply['awards'] = [];
            $apply['awards'][0]['date'] = '';
            $apply['awards'][0]['name'] = '';
            $apply['awards'][0]['unit'] = '';
        }
        $apply = handleApply($apply);
		$this->assign('type_id', $type_id);
        $this->assign('id', $id);
        $this->assign('user', $apply);
        return $this->view->fetch('scholarship_team/counselor_add_review');
    }

    /**
     * 填写辅导员意见（通过）与不通过
     */
    public function fillOpinion(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 5;
                unset($data['fail']);
            } else {
                $status = 2;
                unset($data['pass']);
            }
            //学号
            $uid = $data['user_id'];
            //构造评语
            $array['text'] = $data['group_opinion']['text'];
            $array['name'] = $data['group_opinion']['name'];
            $array['time'] = strtotime($data['group_opinion']['year']."-".$data['group_opinion']['month']."-".$data['group_opinion']['day']);
            $data['group_opinion'] = json_encode($array);

            //状态表的id
            $id = $data['status_id'];
            //删除没用的
            unset($data['user_id'],$data['status_id']);
            //更新
            $res = $this->national->updateClassOpinion($uid, $data, date('Y',time()));
            if (!$res) {
                return $this->error("提交失败");
            }
            //更新申请状态
            $res = Db::table('yf_apply_scholarships_status')
                ->where('fund_type', 1)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('user_id', $uid)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                return $this->error('插入状态失败');
            }
            return $this->success("提交成功",url('admin/Counselor/showMaterial',['id'=>$id]));
        }
    }

    /**
     * 获取申请学生列表(评估系统)
     */
    public function showEvaluationList() {
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            $where .= " AND u.class_number in (".implode(',',$this->class_number).") ";
        }
        if($status)
        {
            $where .= " AND status = '".$status."'";
        }
        if($studentname)
        {
            $where .= " AND (m.member_list_username LIKE '%".$studentname."%' OR m.member_list_nickname LIKE '%".$studentname."%')" ;
        }
    //    $order = "ORDER BY CHARINDEX(',' + CONVERT(VARCHAR(10), ass.status) + ',' + '1,2,3,4,5,6,7,8')";
        $order = "charindex(','+convert(varchar,status)+',',',1,2,3,4,5,6,7,8,')";
        $where .= " AND ass.status in(1,2,3,4,5,6,7,8)";
        $data = Evaluation::getEvaluationList($where,$order);
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $data_arr = $data->all();
        $data_arr = Evaluation::handleEvaluationList($data_arr);

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
            ->where("u.class_number",'in',$this->class_number)
            ->where(function($query){
                $query->where('ass.status',1);
            })
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where("u.class_number",'in',$this->class_number)
            ->count();
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty', $this->faculty);
        $this->assign('profession', $faculty_profession);
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
        $apply = Db::table('yf_evaluation_application')
            ->alias('app')
            ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('evaluation_id',$data['evaluation_id'])
            ->field('u.*,app.*')
            ->find();
        $apply = handleApply($apply);

        $this->assign('status_id', $id);
        $this->assign('user', $apply);
		$apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app',$apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);
        $material = \app\admin\model\Evaluation::getEvaluationMaterial($apply['evaluation_id']);
        $this->assign('material', $material);
        return $this->view->fetch('evaluation/counselor_add_review');
    }

    /**
     * 查看学生佐证材料
     */
    public function showEvaluationEvidence($id) {
        // $data = Db::table('yf_evaluation_status')
        //     ->where('status_id', $id)
        //     ->find();
        // if (!$data) {
        //     return $this->error("该学生没有填写申请表");
        // }
        $apply = Db::table('yf_evaluation_application')
            ->alias('app')
            ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('evaluation_id',$id)
            ->field('u.*,app.*')
            ->find();
        $this->assign('status_id', $id);
        $this->assign('user', $apply);
        $material = \app\admin\model\Evaluation::getEvaluationMaterial($id);
        $this->assign('material', $material);
        return $this->view->fetch('evaluation/manage_check_proof');
    }

    /**
     * 辅导员初审（通过不通过）(评估系统列表页)
     */
    public function evaluationPassing(Request $request) {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 6;
                unset($data['fail']);
            } else {
                $status = 2;
                unset($data['pass']);
            }
            //更新申请状态
            $res = Db::table('yf_evaluation_status')
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('status_id', $data['status_id'])
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                $this->error('插入状态失败');
            }
            $this->redirect('admin/Counselor/showEvaluationList');
//            $this->success("提交成功",url('admin/Counselor/showEvaluationList'));
        }
    }
    /**
     * 辅导员初审（通过不通过）(评估系统内容页)
     */
    public function evaluationPassingContent(Request $request) {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 6;
                $data['status_id'] = $data['fail'];
                unset($data['fail']);
            } else {
                $status = 2;
                $data['status_id'] = $data['pass'];
                unset($data['pass']);
            }
            //更新申请状态
            $res = Db::table('yf_evaluation_status')
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('status_id', $data['status_id'])
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                $this->error('插入状态失败');
            }
            $this->redirect('admin/Counselor/showEvaluationMaterial',['id'=>$data['status_id']]);
//            $this->success("提交成功",url('admin/Counselor/showEvaluationList'));
        }
    }

    /**
     * 下一页（评估系统内容页）
     */
    public function evaluationNext($id){
        $data = Db::name('evaluation_status')
            ->alias('ass')
            ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id')
            ->where("ass.status_id",$id)
            ->field('app.score')
            ->find();

            $next = Db::name('evaluation_status')
                ->alias('ass')
                ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id')
                ->where('app.score','=',$data['score'])
                ->where('ass.status_id','>',$id)
                ->field('ass.status_id,app.score')
                ->order('score desc')
                ->order('status_id asc')
                ->select();

            if (empty($next)) {
                $next = Db::name('evaluation_status')
                    ->alias('ass')
                    ->join('yf_evaluation_application app', 'ass.evaluation_id = app.evaluation_id')
                    ->where('app.score', '<', $data['score'])
                    ->field('ass.status_id,app.score')
                    ->order('score desc')
                    ->select();
            }

        $this->redirect('admin/Counselor/showEvaluationMaterial',['id'=>$next[0]['status_id']]);
    }
}
