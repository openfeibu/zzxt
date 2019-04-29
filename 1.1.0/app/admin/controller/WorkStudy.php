<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/7/31
 * Time: 17:08
 */

namespace app\admin\controller;

use app\portal\service\PostService;
use think\Db;
use think\Request;
use app\admin\model\WorkStatus;
use PHPExcel;
use app\admin\model\ClassCode as ClassCodeModel;

class WorkStudy extends Base
{
    public function index()
    {
        return $this->view->fetch();
    }

    /**
     * 显示本部们开设的岗位
     */
    public function showJob()
    {
        //测试部门
        $id = 11;
        $field = Db::getTableInfo('yf_work_apply_table', 'fields');
        foreach ($field as $key => $row) {
            $field[$key] = 'w.' . $row;
        }
        $field = implode(',', $field);
        $sql = "SELECT w.*, count(ws.id) AS apply_count,(select count(*) from yf_work_status where work_apply_id = w.work_id and status=3) as count,(select count(*) from yf_work_status where work_apply_id = w.work_id and status is null) as not_count FROM yf_work_status AS ws RIGHT JOIN yf_work_apply_table AS w ON w.work_id = ws.work_apply_id
 WHERE w.department = '".$id."' GROUP BY ";
        $sql .= $field;
        $data = Db::query($sql);
        //查询出本人所开的岗位。并且附带了有多少人申请。搞定。到时候可能需要修改成为部门，按部门来归类
        $this->assign("list", $data);
        return $this->view->fetch();
    }

    /**
     * 显示报名某个岗位的所有同学(做少一个优先选择贫困的。)
     */
    public function showApplyStudents($id)
    {
        if (request()->isPost()) {
            $arr = request()->post();
//            是否贫困生 1是。0不是
            if ($arr['is_poor'] == 1) {

            }
//            院系
            if ($arr['faculty'] != 0) {
                $faculty = $arr['faculty'];
            } else {
                $faculty = '';
            }
//            是男是女 0是不限。1是男。2是女
            if ($arr['gender'] == 0) {
                $gender = "";
            } elseif($arr['gender'] == 1) {
                $gender = "男";
            } else {
                $gender = "女";
            }
            $sql = '';
            if (!empty($faculty) and !empty($gender)){
                $sql = "u.faculty_number = ".$faculty."and u.gender='".$gender."'";
            } elseif (!empty($gender) and empty($faculty)) {
                $sql = " u.gender='".$gender."'";
            } elseif (empty($gender) and !empty($faculty)) {
                $sql = "u.faculty_number = ".$faculty;
            } else {
                $sql ='';
            }
            $data = Db::table('yf_work_status')
                ->alias('ws')
                ->join('yf_user u', 'ws.user_id = u.studentid', 'left')
                ->field('ws.*,u.studentname,u.profession+u.class as class')
                ->where('work_apply_id', $id)
                ->where("ws.status is null")
                ->where($sql)
                ->paginate(20,false,['query'=>get_query()]);
			$classCode = new ClassCOde();
            $faculty_list = $classCode->getFaculties();
            $this->assign("faculty_list", $faculty_list);
            $this->assign('dir', '岗位申请人列表');
            $this->assign('id', $id);
            $this->assign('list', $data);
            return $this->view->fetch();
        }
        $data = Db::table('yf_work_status')
            ->alias('ws')
            ->join('yf_user u', 'ws.user_id = u.studentid', 'left')
            ->field('ws.*,u.studentname,u.profession+u.class as class')
            ->where('work_apply_id', $id)
            ->where("ws.status is null")
            ->paginate(20,false,['query'=>get_query()]);
		$classCode = new ClassCOde();
        $faculty_list = $classCode->getFaculties();
        $this->assign("faculty_list", $faculty_list);
        $this->assign('dir', '岗位申请人列表');
        $this->assign('id', $id);
        $this->assign('list', $data);
        return $this->view->fetch();
    }

    /**
     * 查看某个学生的简历
     */
    public function showStudentResume($id, $job_id)
    {
        $data = Db::table('yf_resume')
            ->alias('r')
            ->join("yf_user u", 'u.studentid = r.user_id', 'left')
            ->where('r.user_id', $id)
            ->find();
        if (!$data) {
            return $this->error("该学生还没有填写简历");
        }
        $data['experience'] = json_decode($data['experience'], true);
        $this->assign('id',$job_id);
        $this->assign('list', $data);
        return $this->view->fetch();
    }

    /**
     * 设置某个学生是否通过这次网上报名（用人部门）将status设置为1，2为学生处。3的话就直接过了。0就不通过,4就是这个人已经有职位了
     */
    /*
    public function passOrFail(Request $request)
    {
        $user_id = $request->post('id');
        $job_id = $request->post('work_id');
        //通过或不通过
        $bool = $request->post('status') == 'pass' ? true : false;
        //1为用人部门2为学生处
//        $department = $request->post('department') == '1' ? 1 : 2;
        //默认学生处通过
        $department =2;
        if ($bool) {
            //通过
            $bool = $department;
        } else {
            //不通过
            $bool = 0;
        }
        //检察是否这位同学是否已经录取过了。若已经被某个部门录取。则不得重新录取
        $model = new WorkStatus();
        if (!$model->check($user_id)) {
            Db::table('yf_work_status')
                ->where('user_id', $user_id)
                ->where('work_id', $job_id)
                ->update([
                    'status' => 4,
                    'update_at' => time()
                ]);
            return $this->error("该同学已被其他部门录用");
        }
        if ($request->isAjax()) {
            //批量处理
            $num = $this->batchPassOrFail($user_id, $job_id, $bool);
            return $this->success("更新了" . $num . "位学生");
        }
        $boole = Db::table('yf_work_status')
            ->where('user_id', $user_id)
            ->where('work_id', $job_id)
            ->update([
                'status' => $bool,
                'update_at' => time()
            ]);
        //少一个返回的视图
    }
*/
    /**
     * 批量通过,学号用逗号隔开例如(20155533219,20155533220)
     */
//    public function batchPassOrFail($user_id, $job_id, $bool)
//    {
//        $student = explode(',', $user_id);
//        $num = 0;
//        foreach ($student as $row) {
//            Db::table('yf_work_status')
//                ->where('user_id', $row)
//                ->where('work_id', $job_id)
//                ->update([
//                    'status' => $bool,
//                    'update_at' => time()
//                ]);
//            $num++;
//        }
//        return $num;
//    }

    /**
     * 学生处显示需要审核的普通岗位 type 1为特殊0为普通
     */
    public function ordinaryJobList()
    {
        $type = 1;
        //只有当报名结束之后的岗位才可以审核
        $data = Db::table('yf_work_apply_table')
            ->where('is_special', $type)
            ->where('end_time <= '.time())
            ->paginate(20,false,['query'=>get_query()]);
        halt($data);
    }


    /**
     * 显示学生处审核通过的列表
     */
    public function hiringList($id)
    {
        $job_id = $id;
        $data = Db::table('yf_work_status')
            ->where('work_id', $job_id)
            ->where('status', 2)
            ->paginate(20,false,['query'=>get_query()]);
    }

    /**
     * 用人部门审核，直接给3.然后学生处就不用审核。直接录取
     * @param Request $request
     * @return string
     */
    public function hiring(Request $request)
    {
        $data = request()->post();
        $c = Db::table("yf_work_apply_table")
            ->where('work_id', $data['job_id'])
            ->field('number')
            ->find();
        if (isset($data['data_list'])) {
            //批处理
            if (empty($data['data_list'])) {
                return false;
            }
//            $array = explode(',', $data['user_id']);
            if ($data['type'] == "hiring") {
                $type = 3;
            } else {
                $type = 0;
            }
            $model = new WorkStatus();
            foreach ($data['data_list'] as $key => $row) {
                if ($model->checkNum($data['job_id']) >= $c['number']) {
                    return [
                        'code' => 400
                    ];
                }
                if (!$model->check($row)) {
                    Db::table('yf_work_status')
                        ->where('user_id', $row)
                        ->where('work_apply_id', $data['job_id'])
                        ->update([
                            'status' => 4,
                            'update_at' => time()
                        ]);
                    continue;
                }
                Db::table('yf_work_status')
                    ->where('user_id', $row)
                    ->where('work_apply_id', $data['job_id'])
                    ->update([
                        'status' => $type,
                        'update_at' => time()
                    ]);

            }
            //批处理完成，
            return json_encode([
                'code' =>200
            ]);
        }
    }

    /**
     * 单人录取
     * @param $id
     * @param $job_id
     */
    public function hiringById($id,$job_id)
    {
        $c = Db::table("yf_work_apply_table")
            ->where('work_id', $job_id)
            ->field('number')
            ->find();
        $model = new WorkStatus();
        if ($model->checkNum($job_id) >= $c['number']) {
            return $this->error("达到报名上限人数");
        }
        if (!$model->check($id)) {
             Db::table('yf_work_status')
                ->where('user_id', $id)
                ->where('work_apply_id', $job_id)
                ->update([
                    'status' => 4,
                    'update_at' => time()
                ]);
             return $this->error("该学生已经有其他岗位，录取失败");
        }
        Db::table('yf_work_status')
            ->where('user_id', $id)
            ->where('work_apply_id', $job_id)
            ->update([
                'status' => 3,
                'update_at' => time()
            ]);
        return $this->redirect(url('/admin/WorkStudy/showApplyStudents/'.$job_id));
    }

    /**
     * 单人排除
     */
    public function notHiring($id,$job_id)
    {
        Db::table('yf_work_status')
            ->where('user_id', $id)
            ->where('work_apply_id', $job_id)
            ->update([
                'status' => 0,
                'update_at' => time()
            ]);
        return $this->redirect(url('/admin/WorkStudy/showApplyStudents/'.$job_id));
    }

    /**
     * 学生处录入用人部门的岗位
     * 只录入用人岗位名称，
     * 岗位所属部门
     * 岗位人的数量
     */
    public function entry(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $bool = Db::table('yf_work_apply_table')
                ->insert($data);
            return $this->view->fetch();
        }
        return $this->view->fetch();
    }

    /**
     * 用人部门完善岗位资料
     */
    public function complete($id)
    {
        if (request()->isPost()) {
            $data = request()->post();
            unset($data['job_id']);
            $bool = Db::table('yf_work_apply_table')
                ->where('work_id', $id)
                ->update($data);
        }
        $array = Db::table('yf_work_apply_table')
            ->where('work_id', $id)
            ->find();
        $this->assign('list', $array);
        return $this->view->fetch();
    }

    /**
     * 用人部门的特殊部门导入
     */
    public function entryExcel($id)
    {
        $model = new WorkStatus();
        $c = Db::table('yf_work_apply_table')
            ->where('work_id', $id)
            ->field('number')
            ->find();
        //文件上传
        if (request()->isPost()) {
            if (!empty(request()->file('excel'))) {
                $file = request()->file('excel');
                //设置部门编号
                $count_num = 0;
                $count_success = 0;
                $id = request()->post('work_id');
//                $id = $request->post('job_id');
                // 移动到框架应用根目录/public/uploads/ 目录下
                $info = $file->Validate(['ext'=>'xlsx,xls'])->move(ROOT_PATH . 'public' . DS . 'uploads'.DS."excel");
                if($info){
                    if ($info->getExtension() == 'xlsx'){
                        $type = 'Excel2007';
                    } elseif ($info->getExtension() == 'xlsx') {
                        $type = 'Excel5';
                    } elseif ($info->getExtension() == 'cvs') {
                        $type = 'cvs';
                    }
                    $array = read(ROOT_PATH . 'public' . DS . 'uploads'.DS."excel".DS.$info->getSaveName(),'Excel2007');
                    $preg = "/^20{9}$/";
                    foreach ($array as $key => $row) {
                        if (strlen($row[0]) != 11) {
                            continue;
                        }
                        if (preg_match($preg, $row[0])) {
                            continue;
                        }
                        if ($model->checkNum($id) >= $c['number']) {
                            return json([
                                'code' => 400,
                                'msg' => "超过人数。录入人数:".$count_success."已有职位人数:".$count_num
                            ]);
                        }
                        if (!$model->check($row[0])) {
                            Db::table('yf_work_status')
                                ->insert([
                                    'user_id' => $row[0],
                                    'create_at' => time(),
                                    'update_at' => time(),
                                    'status' => 4,
                                    'work_apply_id' => $id
                                ]);
                            $count_num++;
                            continue;
                        }
                        Db::table('yf_work_status')
                            ->insert([
                                'user_id' => $row[0],
                                'create_at' => time(),
                                'update_at' => time(),
                                'status' => 3,
                                'work_apply_id' => $id
                            ]);
                        $count_success++;
                    }
                    return [
                        'code' => 200,
                         'msg' => "录入人数:".$count_success."已有职位人数:".$count_num
                    ];
                }else{
                    // 上传失败获取错误信息
                    return [
                        'code' => 401,
                        'msg' => '上传失败，失败原因：'.$info->getError()
                    ];
                }
            } else {
                $data = request()->post();
                if ($model->checkNum($data['work_apply_id']) >= $c['number']) {
                    return $this->error('该岗位人数已满',url('admin/workstudy/entryExcel',['id'=>$data['work_apply_id']]));
                }
                if (!$model->check($data['user_id'])) {
                    Db::table('yf_work_status')
                        ->insert([
                            'user_id' => $data['user_id'],
                            'status' => 4,
                            'update_at' => time(),
                            'create_at' => time(),
                            'work_apply_id' => $data['work_apply_id']
                        ]);
                    return $this->error("该学生已经有其他岗位，录取失败",url('admin/workstudy/entryExcel',['id'=>$data['work_apply_id']]));
                }
                Db::table('yf_work_status')
                    ->insert([
                        'user_id' => $data['user_id'],
                        'status' => 3,
                        'update_at' => time(),
                        'create_at' => time(),
                        'work_apply_id' => $data['work_apply_id']
                    ]);
            }
            $this->assign('dir',ROOT_PATH.'public'.DS.'导入模版.xlsx');
            $this->assign('id', $id);
            return $this->view->fetch();

        }
        //循环输出已经有的特殊部门
//        $list = Db::table('yf_work_apply_table')
//            ->where('is_special', 1)
//            ->select();
//        $this->assign("list", $list);
        $this->assign('dir','/public/uploads/moban.xlsx');
        $this->assign('id', $id);
        return $this->view->fetch();
    }

    /**
     * 填写考核表、自动显示这个部门已经有的人
     */
    public function showCheckList($id)
    {
        //查看是否已经填写过，本月
        $time = date("Y-m",time());
        $bool = Db::table('yf_checklist')
            ->where('department', $id)
            ->where("CONVERT(VARCHAR(7),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = '".$time."'")
            ->find();
        if (request()->isPost()) {
            $data = request()->post();
            if ($bool) {
                $data['students'] = json_encode($data['students']);
                $data['update_at'] = time();
                $department = $data['department'];
                $department_job_id = $data['department_job_id'];
                unset($data['department'],$data['department_job_id']);
                $bool = Db::table('yf_checklist')
                    ->where('department', $department)
                    ->where('department_job_id', $department_job_id)
                    ->update($data);
                if ($bool) {
                    return $this->success("更新成功");
                }
                return $this->error("更新失败");
            } else {
                $data['students'] = json_encode($data['students']);
                $data['create_at'] = time();
                $data['update_at'] = $data['create_at'];
                $bool = Db::table('yf_checklist')
                    ->insert($data);
                if ($bool) {
                    return $this->success("提交成功");
                }
                return $this->error("提交失败");
            }

        }
        //首先。获取这个部门的id
//        $id = 1;
        if ($bool) {
            //已经有填写过了。那么。。。。不知道呃
            $bool['students'] = json_decode($bool['students'], true);
            $this->assign('time', $bool['create_at']);
            $this->assign('list',$bool);
            return $this->view->fetch();
        } else {
            //没有填写过。那么就给出填写的
            //获取所有这个部门的学生
            $students = Db::query("select studentid,studentname,profession+class as class from yf_user where studentid in (SELECT user_id FROM [dbo].[yf_work_status] where work_apply_id= $id and status =3)");
            $department_name = Db::table("yf_work_apply_table")
                ->where('work_id', $id)
                ->find();
            $today = time();
            $arr['students'] = $students;
            $arr['department'] = $department_name['department'];
            foreach($arr['students'] as $key => $row) {
                $arr['students'][$key]['standard'] = '';
                $arr['students'][$key]['time'] = '';
                $arr['students'][$key]['status'] = '';
                $arr['students'][$key]['money'] = '';
            }
            $arr['department_opinion'] = '';
            $arr['principal'] = '';
            $arr['total_money'] = '';
            $arr['department_job_id'] = $id;
            $this->assign('time',$today);
            $this->assign("list", $arr);
            return $this->view->fetch();
        }
    }

    /**
     * 删除岗位
     */
    public function deleteJob($id)
    {
        if (is_numeric($id)) {
            $boole = Db::table("yf_work_apply_table")
                ->where('work_id',$id)
                ->delete();
            if ($boole) {
                return $this->success("删除成功");
            }
            return $this->error("删除失败");
        }
    }

    /**
     * 显示工资条
     */
    public function showPayRoll($id)
    {
        $data = Db::table('yf_checklist')
            ->where('department_job_id', $id)
            ->find();
        if (!$data) {
            return $this->error("请先填写考核表");
        }
        $data['students'] = json_decode($data['students'], true);
        $arr = array_chunk($data['students'],8);
        $this->assign('chunk', $arr);
        $this->assign("list", $data);
        return $this->view->fetch();
    }

    /**
     * 学生处显示所有的岗位
     */
    public function showAllJob()
    {
        $field = Db::getTableInfo('yf_work_apply_table', 'fields');
        foreach ($field as $key => $row) {
            $field[$key] = 'w.' . $row;
        }
        $field = implode(',', $field);
        $sql = "SELECT w.*, count(ws.id) AS apply_count,(select count(*) from yf_work_status where work_apply_id = w.work_id and status=3) as count,(select count(*) from yf_work_status where work_apply_id = w.work_id and status =1) as not_count FROM yf_work_status AS ws RIGHT JOIN yf_work_apply_table AS w ON w.work_id = ws.work_apply_id
  GROUP BY ";
        $sql .= $field;
        $data = Db::query($sql);
        //查询出本人所开的岗位。并且附带了有多少人申请。搞定。到时候可能需要修改成为部门，按部门来归类
        $this->assign("list", $data);
        return $this->view->fetch();
    }

    /**
     * 学生处查看通过的学生,按岗位
     */
    public function showPassStudents($id)
    {
        $data = Db::table('yf_work_status')
            ->alias('ws')
            ->join("yf_user u", 'u.studentid = ws.user_id', 'left')
            ->where('work_apply_id', $id)
            ->field('ws.*,u.studentname,u.profession+u.class as class')
            ->where('status', 3)
            ->paginate(20,false,['query'=>get_query()]);
        if (empty($data->count())) {
            return $this->error("该岗位没有聘用学生");
        }
		$classCode = new ClassCOde();
        $facult = $classCode->getFaculties();
        $this->assign('faculty_list', $facult);
        $this->assign('dir',"上岗人员");
        $this->assign('id', $id);
        $this->assign('list', $data);
        return $this->view->fetch('showapplystudents');
    }

    /**
     * 学生处设置岗位
     */
    public function addJob()
    {
        if (request()->isPost()) {
            $data = request()->post();
            if (!isset($data['is_special'])) {
                $data['is_special'] = 0;
            }
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $bool = Db::table('yf_work_apply_table')
                ->insert($data);
            if ($bool) {
                return $this->success("岗位添加成功");
            }
            return $this->error("添加失败");
        }
        return $this->view->fetch();
    }

    /**
     * 学生处查看未审核的人
     */
    public function showNotAcount($id)
    {
        if (request()->isPost()) {
            $arr = request()->post();
//            是否贫困生 1是。0不是
            if ($arr['is_poor'] == 1) {

            }
//            院系
            if ($arr['faculty'] != 0) {
                $faculty = $arr['faculty'];
            } else {
                $faculty = '';
            }
//            是男是女 0是不限。1是男。2是女
            if ($arr['gender'] == 0) {
                $gender = "";
            } elseif($arr['gender'] == 1) {
                $gender = "男";
            } else {
                $gender = "女";
            }
            $sql = '';
            if (!empty($faculty) and !empty($gender)){
                $sql = "u.faculty_number = ".$faculty."and u.gender='".$gender."'";
            } elseif (!empty($gender) and empty($faculty)) {
                $sql = " u.gender='".$gender."'";
            } elseif (empty($gender) and !empty($faculty)) {
                $sql = "u.faculty_number = ".$faculty;
            } else {
                $sql ='';
            }
            $data = Db::table('yf_work_status')
                ->alias('ws')
                ->join('yf_user u', 'ws.user_id = u.studentid', 'left')
                ->field('ws.*,u.studentname,u.profession+u.class as class')
                ->where('work_apply_id', $id)
                ->where("ws.status = 1")
                ->where($sql)
                ->paginate(20,false,['query'=>get_query()]);
			$classCode = new ClassCOde();
            $faculty_list =  $classCode->getFaculties();
            $this->assign("faculty_list", $faculty_list);
            $this->assign('dir', '未审核名单');
            $this->assign('id', $id);
            $this->assign('list', $data);
            return $this->view->fetch();
        }
        $data = Db::table('yf_work_status')
            ->alias('ws')
            ->join('yf_user u', 'ws.user_id = u.studentid', 'left')
            ->field('ws.*,u.studentname,u.profession+u.class as class')
            ->where('work_apply_id', $id)
            ->where("ws.status = 1")
            ->paginate(20,false,['query'=>get_query()]);
		$classCode = new ClassCOde();
        $faculty_list =  $classCode->getFaculties();
        $this->assign("faculty_list", $faculty_list);
        $this->assign('dir', '未审核名单');
        $this->assign('id', $id);
        $this->assign('list', $data);
        return $this->view->fetch();
    }
}
