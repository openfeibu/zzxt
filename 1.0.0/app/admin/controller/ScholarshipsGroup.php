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
use app\admin\model\User as UserModel;
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
		$this->class_number = $this->admin['class_number'];
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
    public function showReviewList()
    {
        return $this->showReviewListHandle(3);
    }
    public function showReviewList2()
    {
        return $this->showReviewListHandle(2);
    }
    public function showReviewList3()
    {
        return $this->showReviewListHandle(1);
    }
    public function showReviewListHandle($id)
    {
        $where = " 1 = 1 ";
        $status = input('status','');
        $studentname = input('studentname','');
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
            $data = NationalScholarship::getNationalList($where);
        }else{
            $where .= " AND ms.application_type = '".$id."'";
            $data = MultipleScholarship::getMultipleList($where);
        }
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
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
        $this->assign('user', $data);
        $this->assign('list', $data);
        $this->assign('page', $show);
        if(request()->isAjax()){
			return $this->fetch('ajax_showReviewList');
		}else{
			return $this->fetch('showReviewList');
		}
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
        $this->assign('type_id', $type_id);
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

        $data = NationalScholarship::getNationalList();
        $show=$data->render();
        $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

        $this->assign('user', $data);
        $this->assign('page', $show);
        return $this->view->fetch('showNationalList');
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
