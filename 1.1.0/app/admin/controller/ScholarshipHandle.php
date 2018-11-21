<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/18
 * Time: 15:01
 */

namespace app\admin\controller;
use think\Db;
use think\Config;
use think\Request;
use app\admin\model\User as UserModel;
use app\admin\model\Evaluation;
use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;

class ScholarshipHandle extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->time = date('Y', time());
        $this->multiple = new MultipleScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->national = new NationalScholarship();
    }
    public function MultipleGroupFill(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $update_app_data['check_status'] = $status = 6;
        } else {
            $update_app_data['check_status'] = $status = 2;
        }
        //构造评语什么的
        $array['text'] = $data['group_opinion']['text'];
        //$array['name'] = $data['group_opinion']['name'];
        $array['name'] = session('admin_auth.admin_realname');
        $array['time'] = time();
        $update_app_data['group_opinion'] = json_encode($array);
        //状态表的id
        $status_id = $data['status_id'];
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type,status_id')->find();

        return $this->multipleFill($app_status_data,$update_app_data);
    }
    public function MultipleCounselorAllFill()
    {
        $ids = input('n_ids/a');
        $group_opinions = input('opinions/a');
        $update_app_data = [];
        if (input('fail') !== null and !empty(input('fail'))) {
            $update_app_data['check_status'] = $status = 7;
			$text = "不同意";
        } else {
            $update_app_data['check_status'] = $status = 3;
			$text = "同意";
        }
        if(empty($ids)){
            $this -> error("请选择数据");
        }
        if(is_array($ids)){//判断获取文章ID的形式是否数组
            $where = 'status_id in('.implode(',',$ids).')';
        }else{
            $where = 'status_id='.$ids;
        }
        $data = Db::name('apply_scholarships_status')->where($where)->select();
        foreach($data as $key => $val)
        {
            $k = array_search($val['application_id'], $ids);
            $array['text'] = isset($group_opinions[$k]) ? $group_opinions[$k] : $text;
            $array['name'] = session('admin_auth.admin_realname');
            $array['time'] = time();
            $update_app_data['group_opinion'] = json_encode($array);
            $this->multipleFill($val,$update_app_data);
        }
        $this->success("操作成功");

    }
    public function MultipleCounselorFill(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $update_app_data['check_status'] = $status = 7;
			$text = "不同意";
        } else {
            $update_app_data['check_status'] = $status = 3;
			$text = "同意";
        }
        //构造评语
        $array['text'] = isset($data['group_opinion']['text']) ? $data['group_opinion']['text'] : $text;
        //$array['name'] = $data['group_opinion']['name'];
        $array['name'] = session('admin_auth.admin_realname');
        $array['time'] = time();
        $update_app_data['group_opinion'] = json_encode($array);

        //状态表的id
        $status_id = $data['status_id'];
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type,status_id')->find();

        return $this->multipleFill($app_status_data,$update_app_data);
    }
    public function MultipleFacultyAllFill()
    {
        $ids = input('n_ids/a');
        $faculty_opinions = input('opinions/a');
        $update_app_data = [];
        if (input('fail') !== null and !empty(input('fail'))) {
            $update_app_data['check_status'] = $status = 8;
			$text = "不同意";
        } else {
            $update_app_data['check_status'] = $status = 4;
			$text = "同意";
        }
        if(empty($ids)){
            $this -> error("请选择数据");
        }
        if(is_array($ids)){//判断获取文章ID的形式是否数组
            $where = 'status_id in('.implode(',',$ids).')';
        }else{
            $where = 'status_id='.$ids;
        }
        $data = Db::name('apply_scholarships_status')->where($where)->select();
        foreach($data as $key => $val)
        {
            //设置公示时间
            if ($status == 4) {
                $update_app_data['publicity_begin'] = time();
                //5天
                $update_app_data['publicity_end'] = time() + 60*60*24*5;
            }
            $k = array_search($val['application_id'], $ids);
            $array['text'] = isset($faculty_opinions[$k]) ? $faculty_opinions[$k] : $text;
            $array['name'] = session('admin_auth.admin_realname');
            $array['time'] = time();
            $update_app_data['faculty_opinion'] = json_encode($array);
            $this->multipleFill($val,$update_app_data);
        }
        $this->success("操作成功");

    }
    public function MultipleFacultyFill(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $update_app_data['check_status'] = $status = 8;
			$text = "不同意";
        } else {
            $update_app_data['check_status'] = $status = 4;
			$text = "同意";
        }
        //状态表id
        $status_id = $data['status_id'];
        //获取multiple_id
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type,status_id')->find();
        //构造json
 
		$array['text'] = isset($data['faculty_opinion']['text']) ? $data['faculty_opinion']['text'] : $text;
		//$array['name'] = $data['faculty_opinion']['name'];
		$array['name'] = session('admin_auth.admin_realname');
		$array['time'] = time();
		$update_app_data['faculty_opinion'] = json_encode($array);

        $update_app_data['update_at'] = time();

        //设置公示时间
        if ($status == 4) {
            $update_app_data['publicity_begin'] = time();
            //5天
            $update_app_data['publicity_end'] = time() + 60*60*24*5;
        }
        return $this->multipleFill($app_status_data,$update_app_data);
    }
    public function MultipleStudentOfficeFill(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $update_app_data['check_status'] = $status = 9;
			$text = "不同意";
        } else {
            $update_app_data['check_status'] = $status = 5;
			$text = "同意";
        }
		$array['text'] = isset($data['school_opinion']['text']) ? $data['school_opinion']['text'] : $text;
		//$array['name'] = $data['faculty_opinion']['name'];
		$array['name'] = session('admin_auth.admin_realname');
		$array['time'] = time();
		$update_app_data['school_opinion'] = json_encode($array);
        $status_id = $data['status_id'];
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type,status_id')->find();
        $update_app_data['update_at'] = time();
        //设置公示时间
        if ($status == 5) {
            $data['office_begin'] = time();
            //5天
            $data['office_end'] = time() + 60*60*24*5;
        }
        return $this->multipleFill($app_status_data,$update_app_data);
    }
    public function MultipleStudentOfficeFillAll()
    {
        $p = input('p');
        $ids = input('n_ids/a');
		$school_opinions = input('opinions/a');
        if(empty($ids)){
            $this -> error("请选择数据");
        }
        if(is_array($ids)){//判断获取文章ID的形式是否数组
            $where = 'status_id in('.implode(',',$ids).')';
        }else{
            $where = 'status_id='.$ids;
        }
        $data = Db::name('apply_scholarships_status')->where($where)->select();
        if (input('fail') !== null and !empty(input('fail'))) {
            $update_app_data['check_status'] = $status = 9;
			$text = "不同意";
        } else {
            $update_app_data['check_status'] = $status = 5;
			$text = "同意";
        }
        foreach($data as $key => $val)
        {
            if ($status == 5) {
                $update_app_data['office_begin'] = time();
                $update_app_data['office_end'] = time() + 60*60*24*5;
				
            }
			$k = array_search($val['application_id'], $ids);
			$array['text'] = isset($school_opinions[$k]) ? $school_opinions[$k] : $text;
			$array['name'] = session('admin_auth.admin_realname');
			$array['time'] = time();
			$update_app_data['school_opinion'] = json_encode($array);
            $this->multipleFill($val,$update_app_data);
        }
        $this->success("操作成功");
    }
    public function multipleFill($app_status_data,$update_app_data)
    {
        //更新申请状态
        $res = Db::name('apply_scholarships_status')
            ->where('status_id', $app_status_data['status_id'])
            ->update([
                'update_at' => time(),
                'status' => $update_app_data['check_status']
            ]);

        if($app_status_data['fund_type'] == 1)
        {
            $res = Db::name("national_scholarship")
                ->where('national_id',$app_status_data['application_id'] )
                ->update($update_app_data);
        }else{
            $res = Db::name("multiple_scholarship")
                ->where('multiple_id',$app_status_data['application_id'] )
                ->update($update_app_data);
        }

        return [
            'code' => '200',
            'msg' => '操作成功',
        ];
    }
	public function callback()
	{
		$status_id = input('status_id');
		$apply_status = $this->applyStatus->get($status_id);
		if(!$apply_status)
		{
			$this->error("数据不存在");
		}
		if($apply_status['fund_type'] == 3 || $apply_status['fund_type'] == 2)
		{
			$app = $this->multiple->get($apply_status['application_id']);
		}else{
			$app = $this->national->get($apply_status['application_id']);
		}
		if(!$app)
		{
			$this->error("数据不存在");
		}
		
		if($apply_status['status'] > 2)
		{
			$this->error("已审核，不能打回");
		}
		if($apply_status['fund_type'] == 3 || $apply_status['fund_type'] == 2)
		{	
			$this->multiple->where('multiple_id',$apply_status['application_id'])->update(['check_status' => 0]);
		}else{
			$this->national->where('national_id',$apply_status['application_id'])->update(['check_status' => 0]);
		}
		$apply_status->where('status_id',$status_id)->update(['status' => 0]);
		$this->success("操作成功");
	}
}
