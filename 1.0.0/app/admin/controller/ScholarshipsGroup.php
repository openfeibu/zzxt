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
use think\Db;
use think\Request;

class ScholarshipsGroup extends Base
{
    private $multiple;
    private $applyStatus;
    private $user;
    private $time;
    private $user_id = '20155535201';

    public function __construct()
    {
        parent::__construct();
        //根据学号来取。登陆人的班级。限制
        //$this->user = '201555352';
		$this->class_number = session('admin_auth.class_number');
        //限制只显示今年申请的
        $this->time = date("Y",time());
        $this->multiple = new MultipleScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();

    }

    /**
     * 获取申请学生列表(助学金)/奖学金
     * @return mixed
     */
    public function showApplicantList($id)
    {
        if ($id != 3 and $id !=2) {
            return $this->error('该操作有误。请联系管理员解决');
        }
        $data = Db::table('yf_apply_scholarships_status')
			->alias('a')->join('yf_user u','u.studentid = a.user_id')
			->where("u.class_number = '".$this->class_number."'")
            ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
            ->where('fund_type', $id)
            ->select();
        //获取学生信息
        foreach ($data as $k => $vo) {
            $user = Db::table('yf_user')
                ->where('studentid', $vo['user_id'])
                ->find();
            $data[$k]['user_name'] = $user;
        }
        if ($id == 3) {
            $name = "国家助学金";
        } elseif($id == 2) {
            $name = "国家励志奖学金";
        }
        $this->assign('id', $id);
        $this->assign('name', $name);
        $this->assign('user', $data);
        return $this->view->fetch();
    }

    /**
     * 助学金审核列表/励志奖学金
     */
    public function showReviewList($id)
    {
        if ($id != 3 and $id !=2) {
            return $this->error('该操作有误。请联系管理员解决');
        }
        if(request()->isPost()) {
            $data = request()->post();
            if (!empty($data['studentname'])) {
                //学号或名字查询
                if (strlen($data['studentname']) == 11) {
                    $studentname = "studentid = '".$data['studentname']."'";
                } else {
                    $studentname = "studentname = '".$data['studentname']."'";
                }
            } else {
                $studentname = '';
            }

            //选择状态
            if (!empty($data['assess'])) {
                if ($data['assess'] == 1) {
                    $status = "status <> '".$data['assess']."'";
                }
                elseif ($data['assess'] == 2) {
                    $status = "status = '1'";
                }
                elseif ($data['assess'] == 3) {
                    $status = "status = '".$data['assess']."'";
                }
                elseif ($data['assess'] == 4) {
                    $status = "status = '".$data['assess']."'";
                } else {
                    $status = '';
                }
            } else {
                $status = '';
            }

            //查询未审核人数
            $no_count = Db::table('yf_apply_scholarships_status')
			->alias('a')->join('yf_user u','u.studentid = a.user_id')
			->where("u.class_number = '".$this->class_number."'")
                ->where('a.fund_type',$id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->where('status',1)
                ->count();
            if (empty($no_count)) {
                $no_count = 0;
            }
            $yes_count = Db::table('yf_apply_scholarships_status')
				->alias('a')->join('yf_user u','u.studentid = a.user_id')
				->where("u.class_number = '".$this->class_number."'")
                ->where('a.fund_type',$id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->where('status','<>',1)
                ->count();
            if (empty($yes_count)) {
                $yes_count = 0;
            }


            $data_students = Db::table('yf_apply_scholarships_status')
                ->alias('a')//asshold
                ->join('yf_user u', 'a.user_id = u.studentid', 'left')
				->where("u.class_number = '".$this->class_number."'")
                ->where('a.fund_type' ,$id)
                ->where($studentname)
                ->where($status)
                ->paginate(20);

            $data_data = Db::table('yf_apply_scholarships_status')
				->alias('a')//asshold
                ->join('yf_user u', 'a.user_id = u.studentid', 'left')
				->where("u.class_number = '".$this->class_number."'")
                ->where('a.fund_type',$id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
                ->paginate(20);

            $this->assign('no_count',$no_count);
            $this->assign('yes_count',$yes_count);
            $this->assign('user',$data_students);
            $this->assign('id', $id);
            $this->assign('list', $data_data);
            return $this->view->fetch();
        }

        //班级申请学生列表
        $data = Db::table('yf_apply_scholarships_status')
			->alias('a')->join('yf_user u','u.studentid = a.user_id')
			->where("u.class_number = '".$this->class_number."'")
            ->where('a.fund_type',$id)    
            ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
            ->paginate(20);

        if (!$data) {
            return $this->error("班级未有人申请");
        } else {
            foreach ($data->getCollection() as $k => $vo) {
                $user = Db::table('yf_user')
                    ->where('studentid', $vo['user_id'])
                    ->find();
                $data->data[$k] = array_merge($data->items()[$k], $user);
            }
        }
        //查询未审核人数
        $no_count = Db::table('yf_apply_scholarships_status')
		->alias('a')->join('yf_user u','u.studentid = a.user_id')
			->where("u.class_number = '".$this->class_number."'")
            ->where('a.fund_type',$id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
            ->where('status',1)
            ->count();
        if (empty($no_count)) {
            $no_count = 0;
        }
        $yes_count = Db::table('yf_apply_scholarships_status')
		->alias('a')->join('yf_user u','u.studentid = a.user_id')
			->where("u.class_number = '".$this->class_number."'")
            ->where('a.fund_type',$id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,a.create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
            ->where('status','<>',1)
            ->count();
        if (empty($yes_count)) {
            $yes_count = 0;
        }
        $this->assign('no_count',$no_count);
        $this->assign('yes_count',$yes_count);
        $this->assign('id', $id);
        $this->assign('user', $data->data);
        $this->assign('list', $data);
        return $this->view->fetch();

    }

    /**
     * 小组查看学生申请资料(助学金+励志)
     */
    public function showMaterial($id,$type_id)
    {
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
            $id = $data['nation'];
        } else {
            $type = "yf_multiple_scholarship";
            $field = "multiple_id";
            $id = $data['multiple_id'];
        }
        $apply = Db::table($type)
            ->alias('w')
            ->join('yf_user u', 'u.studentid = w.user_id', 'left')
            ->where($field,$id)
            ->find();
//        $apply['photo'] =
        if (!empty($apply['members'])) {
            $apply['members'] = json_decode($apply['members'], true);
        } else {
            $apply['members'][0]['name'] = '';
            $apply['members'][0]['age'] = '';
            $apply['members'][0]['relation'] = '';
            $apply['members'][0]['unit'] = '';
        }
        if (!empty($apply['group_opinion'])) {
            $apply['group_opinion'] = json_decode($apply['group_opinion'], true);
        } else {
            $apply['group_opinion']['text'] = '';
            $apply['group_opinion']['name'] = '';
            $apply['group_opinion']['time'] = time();
        }
        $this->assign('type', $type_id);
        $this->assign('id', $apply_id);
        $this->assign('user', $apply);
        return $this->view->fetch();
    }

    /**
     * 填写小组意见（通过）与不通过
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
            //申请的类型。例如助学金。奖学金
            $type_id = $data['type_id'];
            //学号
            $uid = $data['user_id'];
            //构造评语什么的
            $array['text'] = $data['group_opinion']['text'];
            $array['name'] = $data['group_opinion']['name'];
            $array['time'] = strtotime($data['group_opinion']['year']."-".$data['group_opinion']['month']."-".$data['group_opinion']['day']);
            $data['group_opinion'] = json_encode($array);
            //状态表的id
            $id = $data['status_id'];
            //删除没用的
            unset($data['user_id'],$data['status_id'],$data['type_id']);
            //更新
            $res = $this->multiple->updateClassOpinion($uid, $data, date('Y',time()),$type_id);
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
            return $this->success("提交成功",url('admin/ScholarshipsGroup/showMaterial',['id'=>$id,'type_id'=>$type_id]));
        }
    }

    /**
     * 获取申请学生列表(国家奖学金)
     */
    public function showNationalList() {
        //获取前9位学号班级代码
        $uid = substr($this->user_id,0,9);
        $data = ScholarshipsApplyStatus::where('fund_type', 1)
            ->where("substring(user_id,1,9) = $uid")
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20)=$this->time")
//            ->where('status', 1)
            ->select();
        //获取学生信息
        foreach ($data as $k => $vo) {
            $user = Db::table('yf_user')
                ->where('studentid', $vo['user_id'])
                ->find();
            $data[$k]['user_name'] = $user;
        }
        $this->assign('user', $data);
        return $this->view->fetch('scholarship_team/class_review');
    }

    /**
     * 国家奖学金审核列表
     * @return string
     */
    public function showNationalReviewList() {
        $data = Db::table('yf_apply_scholarships_status')
            ->where('fund_type',1)
//            ->where('status', 1)
            ->paginate(20);
        foreach ($data->getCollection() as $k => $vo) {
            $user = Db::table('yf_user')
                ->where('studentid', $vo['user_id'])
                ->find();
            $data->data[$k] = array_merge($data->items()[$k],$user);
        }
        $this->assign('user', $data->data);
        $this->assign('list', $data);
        return $this->view->fetch();
    }
}