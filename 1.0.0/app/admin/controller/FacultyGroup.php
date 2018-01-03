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
        $this->faculty = session('admin_auth.faculty_number');
        $this->classCode = new ClassCodeModel();
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
        $classes = $this->classCode->getClass($this->faculty);
        $this->assign('classes', $classes);
    }

    /**
     * 获取申请学生列表
     * @return mixed
     */
     /*
    public function showApplicantList($id)
    {
        if ($id !=3 and $id !=2 and $id != 1) {
            return $this->error('该操作有误。请联系管理员解决');
        }
        if (request()->isPost()) {
            $data = request()->post();
            //学号
            if (!empty($data['studentname'])) {
                //学号
                if (strlen($data['studentname']) == 11) {
                    $studentname = "studentid = '".$data['studentname']."'";
                } else {
                    $studentname = "studentname = '".$data['studentname']."'";
                }
            } else {
                $studentname = '';
            }
            //年级
            if ($data['grade'] != 0) {
                $grade = "current_grade = '".$data['grade']."'";
            } else {
                $grade = '';
            }
            //专业
            if ($data['faculty'] != 0) {
                $faculty_profession_sql = "profession_number = '".$data['faculty']."'";
            } else {
                //系别
                $faculty_profession_sql = 'faculty_number = 5';
            }
            //找人
            $data_students = Db::table('yf_apply_scholarships_status')
                ->alias('ass')//asshold
                ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
                ->where('ass.fund_type' ,$id)
                ->where($studentname)
                ->where($grade)
                ->where($faculty_profession_sql)
                ->paginate(20);
            //查院系的
            $faculty_profession = Db::table('yf_user')
                ->field("DISTINCT profession ,profession_number")
                ->where('faculty_number', $this->faculty)
                ->select();
            //这里比较麻烦。先找出提交上来的那个专业。

            $faculty_name = Db::table('yf_user')
                ->where('profession_number', $data['faculty'])
                ->field("DISTINCT profession")
                ->find();
            if ($data['faculty'] != 0 and $data['grade'] != 0) {
                $faculty_name = $data['grade'].$faculty_name['profession'];
            } elseif ($data['faculty'] != 0 and $data['grade'] == 0) {
                $faculty_name = $faculty_name['profession'];
            } elseif ($data['faculty'] == 0 and $data['grade'] != 0) {
                $faculty_name = $data['grade']."全系";
            } else {
                $faculty_name = "全系";
            }
            //再来找那些人
            //绝笔要撕逼(未通过的)
            $faculty_count = Db::table('yf_apply_scholarships_status')
                ->alias('ass')//asshold
                ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
                ->where('ass.fund_type', $id)
                ->where('u.faculty_number', $this->faculty)
                ->where($grade)
                ->where($faculty_profession_sql)
                ->where(function($query){
                    $query->where('ass.status !=3')->where('ass.status !=4');
                })
                ->count();
            //总得人数
            $faculty_all_count = Db::table('yf_apply_scholarships_status')
                ->alias('ass')//asshold
                ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
                ->where('ass.fund_type', $id)
                ->where('u.faculty_number', $this->faculty)
                ->where($faculty_profession_sql)
                ->where($grade)
                ->count();
            $this->assign('type_id', $id);
            $this->assign('faculty_name', $faculty_name);
            $this->assign('faculty_not_pass', $faculty_count);
            $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
            $this->assign('faculty', $this->faculty);
            $this->assign('profession', $faculty_profession);
            $this->assign('user', $data_students);
            return $this->fetch();
        }
        //get请求

        //查找呃
        $data = MultipleScholarship::getMultipleList();
        //查院
        $faculty_profession = Db::table('yf_user')
            ->field("DISTINCT profession ,profession_number")
            ->where('faculty_number', $this->faculty)
            ->select();
        //绝笔要撕逼(未通过的)
        $faculty_count = Db::table('yf_apply_scholarships_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('ass.fund_type', $id)
            ->where('u.faculty_number', $this->faculty)
            ->where(function($query){
                $query->where('ass.status !=3')->where('ass.status !=4');
            })
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_apply_scholarships_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('ass.fund_type', $id)
            ->where('u.faculty_number', $this->faculty)
            ->count();
        $this->assign('type_id', $id);
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty_name', '院系');
        $this->assign('faculty', $this->faculty);
        $this->assign('profession', $faculty_profession);
        $this->assign('user', $data);
        return $this->fetch();
    }
    */
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
        $studentname = input('studentname','');
        $status = input('status','');
        $class_number = input('class_number',0);
        $where = ' 1 = 1 ';
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
        $order = "charindex(','+convert(varchar,check_status)+',',',1,2,3,4,5,6,7,8,')";
        $where .= " AND check_status in(2,1,3,4,5,6,7,8)";
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
        //查院
        $faculty_profession = Db::table('yf_user')
            ->field("DISTINCT profession ,profession_number")
            ->where('faculty_number', $this->faculty)
            ->select();
        //绝笔要撕逼(未通过的)
        $faculty_count = Db::table('yf_apply_scholarships_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('ass.fund_type', $id)
            ->where('u.faculty_number', $this->faculty)
            ->where(function($query){
                $query->where('ass.status !=3')->where('ass.status !=4');
            })
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_apply_scholarships_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('ass.fund_type', $id)
            ->where('u.faculty_number', $this->faculty)
            ->count();
        $this->assign('type_id', $id);
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty_name', '院系');
        $this->assign('faculty', $this->faculty);
        $this->assign('profession', $faculty_profession);
        $this->assign('user', $data_arr);
        $this->assign('page', $show);
        if(request()->isAjax()){
			return $this->fetch('ajax_showApplicationList');
		}else{
			return $this->fetch('showApplicantList');
		}
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
            $this->error("该学生没有填写申请表");
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
            }
			if(!is_array($apply['awards']))
			{
				$apply['awards'] = [];
				$apply['awards'][0]['date'] = '';
                $apply['awards'][0]['name'] = '';
                $apply['awards'][0]['unit'] = '';
            }

            $apply = handleApply($apply);
            $this->assign('type_id', $type_id);
            $this->assign('id', $apply_id);
            $this->assign('user', $apply);
            return $this->view->fetch();
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

            $apply = handleApply($apply);
            $this->assign('type_id', $type_id);
            $this->assign('id', $apply_id);
            $this->assign('user', $apply);
            return $this->view->fetch();
        }
    }

    /**
     * 填写院系小组意见（助学金，励志奖学金）
     */
    public function fillMultipleOpinion(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $type_id = $data['type_id'];
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 6;
                unset($data['fail']);
            } else {
                $status = 3;
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
            //构造json
            $array['text'] = $data['faculty_opinion']['text'];
            $array['name'] = $data['faculty_opinion']['name'];
            $array['time'] = strtotime($data['faculty_opinion']['year']."-".$data['faculty_opinion']['month']."-".$data['faculty_opinion']['day']);
            $data['faculty_opinion'] = json_encode($array);
            $data['update_at'] = time();
            //删除没用的
            unset($data['user_id'],$data['status_id'],$data['type_id']);
            //设置公示时间
            if ($status ==3) {
                $data['publicity_begin'] = time();
                //5天
                $data['publicity_end'] = time() + 60*60*24*5;
            }
            //更新评语。
            $res = Db::table("yf_multiple_scholarship")
                ->where('user_id', $uid)
                ->where('multiple_id', $ssid['multiple_id'])
                ->update($data);
            if (!$res) {
                return $this->error("提交失败");
            }
            //更新申请状态
            $res = Db::table('yf_apply_scholarships_status')
                ->where('fund_type', $type_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('user_id', $uid)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                return $this->error('插入状态失败');
            }
            return $this->success("提交成功",url('admin/FacultyGroup/showMaterial',['id'=>$id,'type_id'=>$type_id]));
        }
    }

    /**
     * 填写院系小组意见（奖学金）
     * @param Request $request
     * @return mixed
     */
    public function fillNationalOpinion(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $type_id = $data['type_id'];
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 6;
                unset($data['fail']);
            } else {
                $status = 3;
                unset($data['pass']);
            }
            //状态表id
            $id = $data['status_id'];
            //获取multiple_id
            $ssid = Db::table('yf_apply_scholarships_status')
                ->where('status_id', $id)
                ->field('national_id')
                ->find();
            //学号
            $uid = $data['user_id'];
            //构造json
            $array['text'] = $data['faculty_opinion']['text'];
            $array['name'] = $data['faculty_opinion']['name'];
            $array['time'] = strtotime($data['faculty_opinion']['year']."-".$data['faculty_opinion']['month']."-".$data['faculty_opinion']['day']);
            $data['faculty_opinion'] = json_encode($array);
            $data['update_at'] = time();
            //删除没用的
            unset($data['user_id'],$data['status_id'],$data['type_id']);
            //设置公示时间
            if ($status ==3) {
                $data['publicity_begin'] = time();
                //5天
                $data['publicity_end'] = time() + 60*60*24*5;
            }
            //更新评语。
            $res = Db::table("yf_national_scholarship")
                ->where('user_id', $uid)
                ->where('national_id', $ssid['national_id'])
                ->update($data);
            if (!$res) {
                return $this->error("提交失败");
            }
            //更新申请状态
            $res = Db::table('yf_apply_scholarships_status')
                ->where('fund_type', $type_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->where('user_id', $uid)
                ->update([
                    'update_at' => time(),
                    'status' => $status
                ]);
            if (!$res) {
                return $this->error('插入状态失败');
            }
            return $this->success("提交成功",url('admin/FacultyGroup/showMaterial',['id'=>$id,'type_id'=>$type_id]));
        }
    }

    /**
     * 查看院系。或者全院的人数。通过人数。不通过人数
     * ------废除。已经整合在了首页那里
     */
    public function ajaxForFaculty(Request $request)
    {
        if ($request->isAjax()) {
            $data = $request->post();
//            获取系别 faculty_number
//        $data['grade'] = 0;
//        $data['profession'] = 533;
//        $data['type'] = 1;
//        $data['faculty'] = 5;
            //所有年级
            if ($data['grade'] == 0) {
                $grade = '';
            } else {
                $grade = '';
            }
            //所有专业
            if ($data['profession'] == 0) {
                $profession = '';
            } else {
                $profession = "u.profession_number = '".$data['profession']."'";
            }
            //部门
            if ($data['type'] == 2) {
                $profession  = "u.faculty_number=".$data['faculty'];
                $status = 4;
            } elseif ($data['profession'] !=0 and $data['type'] == 1) {
                $profession  .= " and u.faculty_number=".$data['faculty'];
                $status = 3;
            }
            $arr = Db::table('yf_apply_scholarships_status')
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->where($profession)
                ->where('ass.fund_type', 3)
                ->where($grade)
                ->count();
            $pass = Db::table("yf_apply_scholarships_status")
                ->alias('ass')
                ->join('yf_user u', 'u.studentid = ass.user_id', 'left')
                ->where($profession)
                ->where('status', $status)
                ->where('ass.fund_type', 3)
                ->count();
            return json_encode([
                'all_pass' => $pass,
                'not_pass' => $arr-$pass
            ]);
        }
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
        $data = Evaluation::getEvaluationList($where);
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
            ->where('u.faculty_number', $this->faculty)
            ->where(function($query){
                $query->where('ass.status !=4')->where('ass.status !=5');
            })
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('u.faculty_number', $this->faculty)
            ->count();
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty', $this->faculty);
        $this->assign('profession', $faculty_profession);
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

    public function evaluationPassing(Request $request) {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $status = 8;
                unset($data['fail']);
            } else {
                $status = 4;
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
            $this->redirect('admin/FacultyGroup/showEvaluationList');
//            $this->success("提交成功",url('admin/Counselor/showEvaluationList'));
        }
    }

    /**
     * 修改分数、填写评定结果
     */
    public function fillEvaluationOpinion(Request $request) {
        if ($request->isPost()) {
            $data = $request->post();
            if (isset($data['fail']) and !empty($data['fail'])) {
                $data['evaluation_status'] = $status = 8;
                unset($data['fail']);
            } else {
                $data['evaluation_status'] = $status = 4;
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
            //构造json
            if (empty($data['faculty_opinion']['text'])) {
                $array['text'] = '经过院系小组讨论，该同学情况属实';
            } else {
                $array['text'] = $data['faculty_opinion']['text'];
            }
            if (empty($data['faculty_opinion']['name'])) {
                $array['name'] = $user_name;
            } else {
                $array['name'] = $data['faculty_opinion']['name'];
            }
            if (empty($data['faculty_opinion']['year'])) {
                $array['time'] = time();
            } else {
                $array['time'] = strtotime($data['faculty_opinion']['year']."-".$data['faculty_opinion']['month']."-".$data['faculty_opinion']['day']);
            }

            $data['faculty_opinion'] = json_encode($array);
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
            $this->redirect('admin/FacultyGroup/showEvaluationList');
        }
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
