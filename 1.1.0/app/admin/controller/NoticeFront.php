<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/8/15
 * Time: 14:54
 */

namespace app\admin\controller;


class NoticeFront extends Base
{
    //后台系统公告
    public function system_notice()
    {
        return $this->view->fetch(':notice_front/system_notice');
    }
    //后台评估系统公告
    public function evaluation_notice()
    {
        return $this->view->fetch(':notice_front/evaluation_notice');
    }
    //后台助学金公告
    public function grants_notice()
    {
        return $this->view->fetch(':notice_front/grants_notice');
    }
    //后台助学金公告
    public function motivational_notice()
    {
        return $this->view->fetch(':notice_front/motivational_notice');
    }
    //后台助学金公告
    public function scholarship_notice()
    {
        return $this->view->fetch(':notice_front/scholarship_notice');
    }
}