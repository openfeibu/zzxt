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
use app\home\service\Scholarships;
use app\admin\model\User as UserModel;
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
		//待操作
		$doingcount = $this->scholarships->getCount($id,$count_where.' and check_status in (1)');
		//总得人数
		$allcount = $this->scholarships->getCount($id,$count_where);
        $this->assign('doingcount', $doingcount);
        $this->assign('allcount', $allcount);
        $this->assign('type_id', $id);
        $this->assign('user', $data);
        $this->assign('list', $data);
        $this->assign('page', $show);
        $detail_url = url('admin/ScholarshipsGroup/showMaterial'.$id,['type_id'=>$id]);
        $this->assign('detail_url',$detail_url);
        if(request()->isAjax()){
			return $this->fetch('ajax_showReviewList');
		}else{
			return $this->fetch('showReviewList');
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
            ->where($field,$data['application_id'])
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
        return $this->view->fetch('showMaterial');
    }
}
