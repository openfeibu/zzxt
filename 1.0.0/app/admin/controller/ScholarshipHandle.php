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

class ScholarshipHandle extends Base
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
        $this->time = date('Y', time());
        $this->multiple = new MultipleScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
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
        $array['name'] = '';
        $array['time'] = time();
        $update_app_data['group_opinion'] = json_encode($array);
        //状态表的id
        $status_id = $data['status_id'];
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type')->find();

        // //更新
        // $res = $this->multiple->updateClassOpinion($app_status_data['application_id'], $status_data, date('Y',time()));
        // if (!$res) {
        //     return [
        //         'code' => '201',
        //         'msg' => '操作失败，请联系技术人员'
        //     ];
        //}
        return $this->multipleFill($app_status_data,$update_app_data);
    }
    public function MultipleCounselorFill(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $update_app_data['check_status'] = $status = 7;
        } else {
            $update_app_data['check_status'] = $status = 3;
        }
        //构造评语
        $array['text'] = $data['group_opinion']['text'];
        //$array['name'] = $data['group_opinion']['name'];
        $array['name'] = '';
        $array['time'] = time();
        $update_app_data['group_opinion'] = json_encode($array);

        //状态表的id
        $status_id = $data['status_id'];
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type')->find();

        return $this->multipleFill($app_status_data,$update_app_data);
    }
    public function MultipleFacultyFill(Request $request)
    {
        $data = $request->post();
        if (isset($data['fail']) and !empty($data['fail'])) {
            $update_app_data['check_status'] = $status = 8;
        } else {
            $update_app_data['check_status'] = $status = 4;
        }
        //状态表id
        $status_id = $data['status_id'];
        //获取multiple_id
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type')->find();
        //构造json
        if(isset($data['faculty_opinion']))
        {
            $array['text'] = $data['faculty_opinion']['text'];
            //$array['name'] = $data['faculty_opinion']['name'];
            $array['name'] = '';
            $array['time'] = time();
            $update_app_data['faculty_opinion'] = json_encode($array);
        }

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
        } else {
            $update_app_data['check_status'] = $status = 5;
        }
        $status_id = $data['status_id'];
        $app_status_data = Db::name('apply_scholarships_status')->where('status_id',$status_id)->field('application_id,fund_type')->find();
        //构造json
        if(isset($data['faculty_opinion']))
        {
            $array['text'] = $data['faculty_opinion']['text'];
            //$array['name'] = $data['faculty_opinion']['name'];
            $array['name'] = '';
            $array['time'] = time();
        }

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
        $ids = input('n_id/a');
        if(empty($ids)){
            $this -> error("请选择数据",url('admin/StudentOffice/showapplicantlist',array('p'=>$p)));
        }
        if(is_array($ids)){//判断获取文章ID的形式是否数组
            $where = 'status_id in('.implode(',',$ids).')';
        }else{
            $where = 'status_id='.$ids;
        }
        $data = Db::name('apply_scholarships_status')->where($where)->select();
        if (input('fail') !== null and !empty(input('fail'))) {
            $update_app_data['check_status'] = $status = 9;
        } else {
            $update_app_data['check_status'] = $status = 5;
        }
        foreach($data as $key => $val)
        {
            if ($status == 5) {
                $update_app_data['office_begin'] = time();
                $update_app_data['office_end'] = time() + 60*60*24*5;
            }
            $this->multipleFill($val,$update_app_data);
        }
        $this->success("操作成功",url('admin/StudentOffice/showapplicantlist',array('p'=>$p)));
    }
    public function multipleFill($app_status_data,$update_app_data)
    {
        //更新申请状态
        $res = Db::name('apply_scholarships_status')
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->where('application_id', $app_status_data['application_id'])
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
}
