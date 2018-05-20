<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/8/8
 * Time: 17:29
 */

namespace app\admin\controller;


class EvaluFront extends Base
{
    //评估系统班级审核
    public function E_class_review()
    {
        return $this->view->fetch(':evaluation/E_class_review');
    }
    //评估系统班级添加评语
    public function E_class_add_review()
    {
        return $this->view->fetch(':evaluation/E_class_add_review');
    }
    //评估系统辅导员审核
    public function E_counselor_review()
    {
        return $this->view->fetch(':evaluation/E_counselor_review');
    }
    //评估系统辅导员通过
    public function E_counselor_add_review()
    {
        return $this->view->fetch(':evaluation/E_counselor_add_review');
    }
    //评估系统院系小组审核
    public function E_faculty_review()
    {
        return $this->view->fetch(':evaluation/E_faculty_review');
    }
    //评估系统院系小组添加评语
    public function E_faculty_add_review()
    {
        return $this->view->fetch(':evaluation/E_faculty_add_review');
    }
    //评估系统学生处审核
    public function E_manage_review()
    {
        return $this->view->fetch(':evaluation/E_manage_review');
    }
    //评估系统学生处添加评语
    public function E_manage_add_review()
    {
        return $this->view->fetch(':evaluation/E_manage_add_review');
    }
    //评估系统学生处导入、导出、打印学生基本信息或受助情况
    public function E_manage_print()
    {
        return $this->view->fetch(':evaluation/E_manage_print');
    }
    //评估系统学生处导出审核通过的学生名单和资料（表格）
    public function E_manage_export()
    {
        return $this->view->fetch(':evaluation/E_manage_export');
    }
    //评估系统学生处导出审核通过的学生名单和资料（表格）(详情)
    public function E_manage_export_det()
    {
        return $this->view->fetch(':evaluation/E_manage_export_det');
    }
    //评估系统查看相关证明
    public function E_manage_check_proof()
    {
        return $this->view->fetch(':evaluation/E_manage_check_proof');
    }

    //评估系统院系公示结果
    public function E_faculty_notice()
    {
        return $this->view->fetch(':evaluation/E_faculty_notice');
    }
    //全部公示结果
    public function E_notice_all()
    {
        return $this->view->fetch(':evaluation/E_notice_all');
    }
}