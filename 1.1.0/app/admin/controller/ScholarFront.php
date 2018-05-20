<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/8/4
 * Time: 16:00
 */

namespace app\admin\controller;


class ScholarFront extends Base
{
    //奖学金班级查看
    public function S_class_show()
    {
        return $this->view->fetch(':scholarship/S_class_show');
    }
    //奖学金班级审核
    public function S_class_review()
    {
        return $this->view->fetch(':scholarship/S_class_review');
    }
    //奖学金班级添加评语
    public function S_class_add_reviews()
    {
        return $this->view->fetch(':scholarship/S_class_add_reviews');
    }
    //奖学金班级查看系统公告
    public function S_class_notice()
    {
        return $this->view->fetch(':scholarship/S_class_notice');
    }
    //辅导员审核
    public function S_counselor_review()
    {
        return $this->view->fetch(':scholarship/S_counselor_review');
    }
    //辅导员添加推荐理由
    public function S_counselor_add_review()
    {
        return $this->view->fetch(':scholarship/S_counselor_add_review');
    }
    //奖学金院系审核
    public function S_faculty_review()
    {
        return $this->view->fetch(':scholarship/S_faculty_review');
    }
    //奖学金院系添加评语
    public function S_faculty_add_review()
    {
        return $this->view->fetch(':scholarship/S_faculty_add_review');
    }
    //奖学金院系毕业生信息录入
    public function S_faculty_graduate()
    {
        return $this->view->fetch(':scholarship/S_faculty_graduate');
    }
    //奖学金学生处审核
    public function S_manage_review()
    {
        return $this->view->fetch(':scholarship/S_manage_review');
    }
    //奖学金学生处添加评语
    public function S_manage_add_review()
    {
        return $this->view->fetch(':scholarship/S_manage_add_review');
    }
    //奖学金学生处打印信息
    public function S_manage_print()
    {
        return $this->view->fetch(':scholarship/S_manage_print');
    }
    //奖学金院系公示结果
    public function S_faculty_notice()
    {
        return $this->view->fetch(':scholarship/S_faculty_notice');
    }
    //奖学金学生处公示结果
    public function S_manage_notice()
    {
        return $this->view->fetch(':scholarship/S_manage_notice');
    }
    //奖学金系统公告
    public function S_system_notice()
    {
        return $this->view->fetch(':scholarship/S_system_notice');
    }
    //奖学金系统公告详情
    public function S_sys_notice_det()
    {
        return $this->view->fetch(':scholarship/S_sys_notice_det');
    }
}
