<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//调用extend的路由类
$Route = new \Route;
$Route->route_rule();
return [
	//也可以这里添加路由规则
    //    前端
    'index_front'=>'home/show/index_front',//学生端首页
    'notice'=>'home/Listn/showlist',//通告页
    'news'=>'home/Listn/showlist',//新闻页
    'policy'=>'home/Listn/showlist',//政策页
    'notice_details'=>'home/show/notice_details',//通告内容页
    'news_details'=>'home/show/news_details',//新闻内容页
    'policy_details'=>'home/show/policy_details',//政策内容页
    'personal'=>'home/show/personal',//个人中心认定表页
    'material'=>'home/show/material',//提交资料页
    'evalu_status'=>'home/show/evalu_status',//评估审核状态页
    'changePassword'=>'home/show/change_pd',//修改密码页
    'questionnaire'=>'home/Survey/showSurvey',//调查问卷页
    'work'=>'home/show/work',//勤工助学简历页
    'job_declar'=>'home/show/job_declar',//勤工助学岗位申报
    'job_status'=>'home/show/job_status',//勤工助学岗位状态
    'grants'=>'home/show/grants',//国家助学金页
    'motivational'=>'home/show/motivational',//国家励志奖学金页
    'scholarship'=>'home/show/scholarship',//国家奖学金页
    'scho_status'=>'home/Student/examineStatus',//奖助学金状态页
    'personal_status'=>'home/Show/personal_status',//个人中心页审核状态
    'index_notice'=>'home/Show/index_notice',

    //-----------------------小组处理------------------------------
    'OperateTable/checkField/field/:id' => 'admin/OperateTable/checkField',
    'OperateTable/delete/field/:field' => 'admin/OperateTable/delete',
    'uploads/upload' => 'home/UploadByAjax/uploads',
    'show' => 'home/UploadByAjax/show',
    //-----------------------勤工助学-----------------------
    //-----------------前台----------------------------------
    'home/workstudy/resume' => 'home/WorkStudy/index', //简历
    'home/WorkStudy/applyJob/:id' => 'home/WorkStudy/applyJob', //申请岗位页面
    'home/workstudy/list' => 'home/WorkStudy/workStudyList',//工作岗位列表
    'home/workstudy/ajaxforresume' => 'home/WorkStudy/ajaxForExp',//ajax
    'home/workstudy/showStatusList' => 'home/WorkStudy/showStatusList',//显示状态
    //-----------------------后台-------------------------------
    'admin/workstudy/showApplyStudents/:id' => 'admin/WorkStudy/showApplyStudents',//显示报名某个岗位的所有同学
    'admin/workstudy/showNotAcount/:id' => 'admin/WorkStudy/showNotAcount',//显示学生处查看未审核的人
    'admin/workstudy/showStudentResume/:id/:job_id' => 'admin/WorkStudy/showStudentResume',//显示学生的简历
    'admin/workstudy/list' => 'admin/WorkStudy/showJob',//显示岗位列表
    'admin/workstudy/entryExcel/:id' => 'admin/WorkStudy/entryExcel',//导入某个岗位人
//    'admin/workstudy/ordinaryJobList' => 'admin/WorkStudy/ordinaryJobList',
    'admin/workstudy/showCheckList' => 'admin/WorkStudy/showCheckList',//填写考核表、自动显示这个部门已经有的人
    'admin/workstudy/complete/:id' => 'admin/WorkStudy/complete',//完善某个岗位内容页面
    'admin/workstudy/deletejob/:id' => 'admin/WorkStudy/deleteJob',//删除某个岗位
    'admin/workstudy/hiringById/:id/:job_id' => 'admin/WorkStudy/hiringById',//录取。单人
    'admin/workstudy/nothiring/:id/:job_id' => 'admin/WorkStudy/hiringById',//不录取
    'admin/workstudy/showpayroll/:id' => 'admin/WorkStudy/showPayRoll',//显示某个岗位的工资条
    'admin/workstudy/showallstudents/:id' => 'admin/WorkStudy/showPassStudents',//学生处查看通过的学生,按岗位
    'admin/workstudy/addjob' => 'admin/WorkStudy/addJob',//添加岗位
    //----------------------调查----------------------------------
    'admin/Survey/showSurvey' => 'admin/Survey/showSurvey',//显示调查问卷的设置界面
    'admin/Survey/setOpen' => 'admin/Survey/setOpen',//显示设置调查问卷开关界面
    //---------------------------------------学生端三金申请-----------------------------
    'home/text'=> 'home/Student/text',
    'home/student/chooseType'                          => 'home/Student/chooseType',//选择申请类型,后缀加id.(id = 1为国家奖学金，2为励志奖学金，3为助学金)
    'home/stuedent/grants'                                          => 'home/Student/getGrants',//助学金
    'home/stuedent/inspirational'                                   => 'home/Student/getInspirational',//励志奖学金
    'home/stuedent/nationalScholarship'                             => 'home/Student/getNationalScholarship',//国家奖学金
    'home/examineStatus'                                   => 'home/Student/examineStatus',//查看申请状态
    //----------------------------------------修改的三金-------------------
    'admin/ScholarshipsGroup/showApplicantList'            => 'admin/ScholarshipsGroup/showApplicantList',//显示小组的本班学生申请
    'admin/ScholarshipsGroup/showMaterial/:id/:type_id'    => 'admin/ScholarshipsGroup/showMaterial',//显示添加评语
    'admin/FacultyGroup/ajaxForFaculty'                    => 'admin/FacultyGroup/ajaxForFaculty',//院系
//    'admin/FacultyGroup/showMaterial/:id'                  => 'admin/FacultyGroup/showMaterial',//院系
    'admin/StudentOffice/showMaterial/:id'                 => 'admin/StudentOffice/showMaterial',//学生处
    //----------------------------------------国家奖学金申请------------------------------------------------
    'admin/ScholarshipsGroup/showNationalList'             => 'admin/ScholarshipsGroup/showNationalList',//显示班级小组的本班学生申请列表
    'admin/Counselor/showNationalList'                     => 'admin/Counselor/showNationalList',//显示辅导员所在班级学生申请列表
    'admin/Counselor/showMaterial/:id'                     => 'admin/Counselor/showMaterial',//辅导员显示学生信息及添加评语
    'admin/FacultyGroup/showNationalList'                  => 'admin/FacultyGroup/showNationalList',//院系小组所在系学生申请列表
    'admin/FacultyGroup/showMaterial/:id'                  => 'admin/FacultyGroup/showMaterial',//院系小组显示学生信息及添加评语
    //------------------------------------------公告----------------------------------
    'home/Listn/showList/:id'                              => 'home/Listn/showList',
    'home/Student/examineStatus'                           => 'home/Student/examineStatus',//个人中心状态
    'admin/Notice/showList/:id'                             => 'admin/Notice/showList',//后台公告
    //----------------------------------评估系统(后台)--------------------------------------------------------------
    'admin/Counselor/showEvaluationList'                   => 'admin/Counselor/showEvaluationList',//辅导员审核列表
    'admin/Counselor/showEvaluationMaterial/:id'           => 'admin/Counselor/showEvaluationMaterial',//辅导员查看学生信息
    'admin/Counselor/showEvaluationEvidence/:id'           => 'admin/Counselor/showEvaluationEvidence',//辅导员查看佐证材料
    'admin/EvaluationGroup/showEvaluationList'             => 'admin/EvaluationGroup/showEvaluationList',//班级小组审核列表
    'admin/EvaluationGroup/showEvaluationMaterial/:id'               => 'admin/EvaluationGroup/showEvaluationMaterial',//班级小组查看学生信息
    'admin/EvaluationGroup/showEvaluationEvidence/:id'            => 'admin/EvaluationGroup/showEvaluationEvidence',//班级小组查看佐证材料
    'admin/FacultyGroup/showEvaluationList'                   => 'admin/FacultyGroup/showEvaluationList',//院系小组审核列表
    'admin/FacultyGroup/showEvaluationMaterial/:id'               => 'admin/FacultyGroup/showEvaluationMaterial',//院系小组查看学生信息
    'admin/FacultyGroup/showEvaluationEvidence/:id'            => 'admin/FacultyGroup/showEvaluationEvidence',//院系小组查看佐证材料
    'admin/StudentOffice/showEvaluationList'                   => 'admin/StudentOffice/showEvaluationList',//学生处审核列表
    'admin/StudentOffice/showEvaluationMaterial/:id'               => 'admin/StudentOffice/showEvaluationMaterial',//学生处查看学生信息
    'admin/StudentOffice/showEvaluationEvidence/:id'            => 'admin/StudentOffice/showEvaluationEvidence',//学生处查看佐证材料
    //----------------------------------学生端公示---------------------------------------------------------
    'home/Publicity/grantsPublicity/:id/:type_id'          => 'home/Publicity/grantsPublicity',
    'home/Publicity/motivPublicity/:id/:type_id'           => 'home/Publicity/motivPublicity',
    'home/Publicity/scholarPublicity/:id/:type_id'         => 'home/Publicity/scholarPublicity',
    'home/Publicity/evaluPublicity'                        => 'home/Publicity/evaluPublicity',


];
