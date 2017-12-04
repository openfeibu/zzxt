<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/8/2
 * Time: 13:37
 */

namespace app\admin\controller;


use function GuzzleHttp\uri_template;

class Show extends Base
{
    //问卷
    public function edit_ques()
    {
        return $this->view->fetch(':student_office/edit_ques');
    }
    //勤工助学考核表
    public function checklist()
    {
        return $this->view->fetch(':student_office/checklist');
    }
    //问卷数据统计
    public function ques_stati()
    {
        return $this->view->fetch(':student_office/ques_stati');
    }
    //勤工助学岗位申报
    public function job_appli()
    {
        return $this->view->fetch(':student_office/job_appli');
    }
    //津贴报表
    public function payroll()
    {
        return $this->view->fetch(':student_office/payroll');
    }
    //班级查看申请人
    public function class_show()
    {
        return $this->view->fetch(':national_awards/class_show');
    }
}
