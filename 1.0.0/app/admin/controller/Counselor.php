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
use app\home\service\Scholarships;
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
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
		$count_where = " u.class_number in (".implode(',',$this->class_number).") ";
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
			return $this->fetch('counselor_ajax_review');
		}else{
			return $this->fetch('counselor_review');
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
        //判断类型
        if ($data['fund_type'] == 1) {
            $type = "yf_national_scholarship";
            $field = "national_id";
            $id = $data['application_id'];
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id";
            $id = $data['application_id'];
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
		if (!empty($apply['members'])) {
			$apply['members'] = json_decode($apply['members'], true);
		} else {
			$apply['members'][0]['name'] = '';
			$apply['members'][0]['age'] = '';
			$apply['members'][0]['relation'] = '';
			$apply['members'][0]['unit'] = '';
		}
        $apply = handleApply($apply);
		$this->assign('type_id', $type_id);
        $this->assign('id', $id);
        $this->assign('user', $apply);
        return $this->view->fetch('counselor_add_review');
    }

    /**
     * 获取申请学生列表(评估系统)
     */
    public function showEvaluationList() {
        $class_number = input('class_number',0);
        $studentname = input('studentname','');
        $status = input('status','');
        $where = ' 1 = 1 ';
		$count_where = " u.class_number in (".implode(',',$this->class_number).") ";
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
        $order = "charindex(','+convert(varchar,status)+',',',1,2,3,4,5,6,7,8,')";
        $where .= " AND ass.status in(1,2,3,4,5,6,7,8)";
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
		//$where = " u.class_number in (".implode(',',$this->class_number).") ";
        $this->redirect('admin/Counselor/showEvaluationMaterial',['id'=>$next[0]['status_id']]);
    }
}
