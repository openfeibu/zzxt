<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/8/4
 * Time: 15:57
 */

namespace app\admin\controller;


use function GuzzleHttp\uri_template;

class GrantsFront extends Base
{
    //助学金班级查看
    public function G_class_show()
    {
        return $this->view->fetch(':grants/G_class_show');
    }
    //助学金班级查看
    public function G_class_review()
    {
        return $this->view->fetch(':grants/G_class_review');
    }
    //助学金班级添加评语
    public function G_class_add_reviews()
    {
        return $this->view->fetch(':grants/G_class_add_reviews');
    }
    //助学金班级查看系统公告
    public function G_class_notice()
    {
        return $this->view->fetch(':grants/G_class_notice');
    }
    //助学金院系查看
    public function G_faculty_show()
    {
        return $this->view->fetch(':grants/G_faculty_show');
    }
    //助学金院系审核
    public function G_faculty_review()
    {
        return $this->view->fetch(':grants/G_faculty_review');
    }
    //助学金院系添加评语
    public function G_faculty_add_review()
    {
        return $this->view->fetch(':grants/G_faculty_add_review');
    }
    //助学金院系毕业生信息录入
    public function G_faculty_graduate()
    {
        return $this->view->fetch(':grants/G_faculty_graduate');
    }
    //助学金学生处查看
    public function G_manage_show()
    {
        return $this->view->fetch(':grants/G_manage_show');
    }
    //助学金学生处审核
    public function G_manage_review()
    {
        return $this->view->fetch(':grants/G_manage_review');
    }
    //助学金学生处添加评语
    public function G_manage_add_review()
    {
        return $this->view->fetch(':grants/G_manage_add_review');
    }
    //助学金学生处打印评语
    public function G_manage_print()
    {
        return $this->view->fetch(':grants/G_manage_print');
    }
}