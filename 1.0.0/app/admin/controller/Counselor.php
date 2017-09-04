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
        $this->faculty = 5;
		$this->user_id = '201555332';
    }

    /**
     * 获取申请学生列表(国家奖学金)
     */
    public function showNationalList() {
        //获取前9位学号班级代码
        $uid = substr($this->user_id,0,9);
        $data = Db::table('yf_apply_scholarships_status')
            ->where('fund_type', 1)
            ->where("substring(user_id,1,9) = $uid")
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
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
        $this->assign('user', $data->data);
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
        } else {
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
            $data_students = Db::table('yf_evaluation_status')
                ->alias('ass')//asshold
                ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
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
            //未通过的
            $faculty_count = Db::table('yf_evaluation_status')
                ->alias('ass')//asshold
                ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
                ->where('u.faculty_number', $this->faculty)
                ->where($grade)
                ->where($faculty_profession_sql)
                ->where(function($query){
                    $query->where('ass.status !=3')->where('ass.status !=4');
                })
                ->count();
            //总得人数
            $faculty_all_count = Db::table('yf_evaluation_status')
                ->alias('ass')//asshold
                ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
                ->where('u.faculty_number', $this->faculty)
                ->where($faculty_profession_sql)
                ->where($grade)
                ->count();
            $this->assign('faculty_name', $faculty_name);
            $this->assign('faculty_not_pass', $faculty_count);
            $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
            $this->assign('faculty', $this->faculty);
            $this->assign('profession', $faculty_profession);
            $this->assign('user', $data_students);
            return $this->fetch();
        }
        //查找呃
        $data = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id')
            ->where('u.faculty_number', $this->faculty)
            ->field('ass.*,u.*,app.assess_fraction,app.score,app.change_fraction')
            ->paginate(20);
        //查院
        $faculty_profession = Db::table('yf_user')
            ->field("DISTINCT profession ,profession_number")
            ->where('faculty_number', $this->faculty)
            ->select();
        //未通过的
        $faculty_count = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('u.faculty_number', $this->faculty)
            ->where(function($query){
                $query->where('ass.status !=3')->where('ass.status !=4');
            })
            ->count();
        //总得人数
        $faculty_all_count = Db::table('yf_evaluation_status')
            ->alias('ass')//asshold
            ->join('yf_user u', 'ass.user_id = u.studentid', 'left')
            ->where('u.faculty_number', $this->faculty)
            ->count();
        $this->assign('faculty_not_pass', $faculty_count);
        $this->assign('faculty_pass', $faculty_all_count-$faculty_count);
        $this->assign('faculty', $this->faculty);
        $this->assign('profession', $faculty_profession);
        $this->assign('user', $data);

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
            ->join('yf_user u', 'u.studentid = app.user_id', 'left')
            ->where('evaluation_id',$data['evaluation_id'])
            ->find();

//        if (!empty($apply['awards'])) {
//            $apply['awards'] = json_decode($apply['awards'], true);
//        } else {
//            $apply['awards'][0]['date'] = '';
//            $apply['awards'][0]['name'] = '';
//            $apply['awards'][0]['unit'] = '';
//        }
//        if (!empty($apply['group_opinion'])) {
//            $apply['group_opinion'] = json_decode($apply['group_opinion'], true);
//        } else {
//            $apply['group_opinion']['text'] = '';
//            $apply['group_opinion']['name'] = '';
//            $apply['group_opinion']['time'] = time();
//        }

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
        $data = Db::table('yf_evaluation_status')
            ->where('status_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生没有填写申请表");
        }
        $apply = Db::table('yf_evaluation_application')
            ->alias('app')
            ->join('yf_user u', 'u.studentid = app.user_id', 'left')
            ->where('evaluation_id',$data['evaluation_id'])
            ->find();
        $this->assign('status_id', $id);
        $this->assign('user', $apply);
        return $this->view->fetch('evaluation/manage_check_proof');
    }

    /**
     * 辅导员初审（通过不通过）(评估系统)
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
}