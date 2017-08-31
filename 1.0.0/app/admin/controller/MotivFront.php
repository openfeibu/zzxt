<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/8/4
 * Time: 16:00
 */

namespace app\admin\controller;


class MotivFront extends Base
{
    //励志奖学金班级查看
    public function M_class_show()
    {
        return $this->view->fetch(':motivational/M_class_show');
    }
    //励志奖学金班级审核
    public function M_class_review()
    {
        return $this->view->fetch(':motivational/M_class_review');
    }
    //励志奖学金班级添加评语
    public function M_class_add_reviews()
    {
        return $this->view->fetch(':motivational/M_class_add_reviews');
    }
    //励志奖学金院系审核
    public function M_faculty_review()
    {
        return $this->view->fetch(':motivational/M_faculty_review');
    }
    //励志奖学金院系添加评语
    public function M_faculty_add_review()
    {
        return $this->view->fetch(':motivational/M_faculty_add_review');
    }
    //励志奖学金院系毕业生信息录入
    public function M_faculty_graduate()
    {
        return $this->view->fetch(':motivational/M_faculty_graduate');
    }
    //励志奖学金学生处审核
    public function M_manage_review()
    {
        return $this->view->fetch(':motivational/M_manage_review');
    }
    //励志奖学金学生处添加评语
    public function M_manage_add_review()
    {
        return $this->view->fetch(':motivational/M_manage_add_review');
    }
    //励志奖学金学生处打印信息
    public function M_manage_print()
    {
        return $this->view->fetch(':motivational/M_manage_print');
    }
    //励志奖学金院系公示结果
    public function M_faculty_notice()
    {
        return $this->view->fetch(':motivational/M_faculty_notice');
    }
    //励志奖学金学生处公示结果
    public function M_manage_notice()
    {
        return $this->view->fetch(':motivational/M_manage_notice');
    }
    //励志奖学金系统公告
    public function M_system_notice()
    {
        return $this->view->fetch(':motivational/M_system_notice');
    }
    //励志奖学金系统公告详情
    public function M_sys_notice_det()
    {
        return $this->view->fetch(':motivational/M_sys_notice_det');
    }
}