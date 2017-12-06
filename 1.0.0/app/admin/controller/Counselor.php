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
		$this->class_number = explode(',',$this->admin['class_number']);
    }

    /**
     * 获取申请学生列表(国家奖学金)
     */
    public function showNationalList() {
        //获取前9位学号班级代码
        $data = Db::table('yf_apply_scholarships_status')
			->alias('a')->join('yf_user u','u.studentid = a.user_id')
			->where("u.class_number",'in',$this->class_number)
            ->where('a.fund_type', 1)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
//            ->where('status', 1)
            ->paginate(20);
        //获取学生信息

        foreach ($data->getCollection() as $k => $vo) {
            $user = Db::table('yf_user')
                ->where('studentid', $vo['user_id'])
                ->find();
            if (!is_array($data->items()[$k])){halt($data->items()[$k]);}
            $data->data[$k] = array_merge($data->items()[$k],$user);
        }
		$faculty_pass = 0;
		$faculty_not_pass = 0;
		$this->assign('faculty_pass', $faculty_pass);
		 $this->assign('faculty_not_pass', $faculty_not_pass);
		$user = isset($data->data) ? $data->data : [];
        $this->assign('user', $user);
        $this->assign('list', $data);
        return $this->view->fetch('scholarship_team/counselor_review');
    }

    /**
     * 查看学生申请资料
     */
    public function showMaterial($id) {
        $data = Db::table('yf_apply_scholarships_status')
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生没有填写申请表");
        }

        $type = "yf_national_scholarship";
        $field = "national_id";
        $national_id = $data['national_id'];

        $apply = Db::table($type)
            ->alias('w')
            ->join('yf_user u', 'u.studentid = w.user_id', 'left')
            ->where($field,$national_id)
            ->find();
        if (!empty($apply['awards'])) {
            $apply['awards'] = json_decode($apply['awards'], true);
        }
		if(!is_array($apply['awards'])){
			$apply['awards'] = [];
            $apply['awards'][0]['date'] = '';
            $apply['awards'][0]['name'] = '';
            $apply['awards'][0]['unit'] = '';
        }
        if (!empty($apply['group_opinion'])) {
            $apply['group_opinion'] = json_decode($apply['group_opinion'], true);
        } else {
            $apply['group_opinion']['text'] = '';
            $apply['group_opinion']['name'] = '';
            $apply['group_opinion']['time'] = time();
        }

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

            $data_students = Db::table('yf_evaluation_status')
                ->alias('ass')//asshold
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id')
                ->order('score desc')
                ->where($studentname)
            ->where("u.class_number",'in',$this->class_number)
                ->field('ass.*,u.*,app.assess_fraction,app.score,app.change_fraction')
                ->paginate(20);

            //未通过的
            $faculty_count = Db::table('yf_evaluation_status')
                ->alias('ass')//asshold
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                ->where("u.class_number",'in',$this->class_number)
//                ->where($grade)
//                ->where($faculty_profession_sql)
                ->where(function($query){
                    $query->where('ass.status ==1');
                })
                ->count();
            //总得人数
            $faculty_all_count = Db::table('yf_evaluation_status')
                ->alias('ass')//asshold
                ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                ->where("u.class_number",'in',$this->class_number)
//                ->where($faculty_profession_sql)
//                ->where($grade)
                ->count();
//            $this->assign('faculty_name', $faculty_name);
            $this->assign('faculty_not_pass', $faculty_count);
            $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
            $this->assign('faculty', $this->faculty);
//            $this->assign('profession', $faculty_profession);
            $this->assign('user', $data_students);
            return $this->fetch('evaluation/counselor_review');
        }

        $where["u.class_number"] = ['in' , $this->class_number];
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
        return $this->view->fetch('evaluation/counselor_review');
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


        $this->assign('status_id', $id);
        $this->assign('user', $apply);
		$apply['members'] = unserialize($apply['members']);
		$this->assign('eval_app',$apply);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);

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
