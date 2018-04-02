<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\File;
use app\home\model\Survey;
use app\home\model\Identify;
use app\home\model\Poor;
use app\admin\model\Evaluation as EvaluationModle;
use app\home\model\ScholarshipsApplyStatus;
use app\home\model\NationalScholarship;
use app\home\model\MultipleScholarship;
use app\home\model\User;


class Student extends Base
{
    private $identify;
    private $applyStatus;
//    private $user;
    private $status = 1;
    protected $time;

    public function __construct()
    {
        parent::__construct();
        $this->applyStatus = new ScholarshipsApplyStatus();
        //$this->user = new User();
        $this->time = date('Y', time());
    }

    /**
     * 选择学生资助的类型
     * @param Request $request
     * @return \think\response\Redirect|void
     */
    public function chooseType()
    {
        $type = input('choose_type');
        $grade = getGrade($this->user['current_grade']);

		if($grade > 3) {
			 $this->error("抱歉，你不是在校生");
		}

        switch ($type) {
            //国家奖学金
            case 1 :
                //判断是否大二
                if($grade == 2 || $grade == 3) {
                    //判断是否申请过励志奖学金
                    if (MultipleScholarship::isHaveApply($this->user['member_list_id'], $type)) {
                        $res = ScholarshipsApplyStatus::where('user_id', $this->user_id)
                            ->where('fund_type', $type)
                            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                            ->find();
                        if ($res) {
                            $this->error("抱歉，你已申请励志奖学金，不能申请奖学金");
                        }
                        //跳转申请界面
                        $this->success('成功',url('/home/nationalScholarship'));
                    }
                    $this->success('成功',url('/home/nationalScholarship'));
                }
                $this->error("抱歉，大二或大三生才能申请奖学金");
                break;

            //励志奖学金
            case 2 :
                $grade = Db::table('yf_user')
                    ->where('studentid', $this->user_id)
                    ->field('grade')
                    ->find();
                //判断是否大二
                if($grade == 2) {
                    //判断是否贫困生
                    //判断是否申请过国家奖学金
                    if ($this->applyStatus->isHaveApply($this->user_id, $type)) {
                        $res = ScholarshipsApplyStatus::where('user_id', $this->user_id)
                            ->where('fund_type', $type)
                            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                            ->find();
                        if ($res) {
                            $this->error("抱歉，你已申请奖学金，不能申请励志奖学金");
                        }
                        $this->success('成功',url('/home/inspirational'));
                    }
                }
                $this->error("抱歉，大二学生才能申请励志奖学金");
                break;

            //助学金
            case 3 :
                $is_eval_app_pass = EvaluationModle::isExistMemberEvaluationPass($this->user['member_list_id']);
                if(!$is_eval_app_pass)
                {
                    $this->error('抱歉，通过家庭困难认定后才能申请');
                }
                //跳转申请页面
                $this->success('成功',url('/home/grants'));
                break;
            default :$this->error("发生未知错误，请联系管理员。");
        }
    }

    /**
     * 获取助学金申请书
     * @param Request $request
     * @return mixed|void 返回视图或者相关信息
     */
    public function getGrants(Request $request)
    {
        $type_id = 3;
        $user_model = new User();
        $user_info = $user_model->get_user($this->user['id_number']);
        //政治面貌
        $user_info['political'] = substr($user_info['political'],-6,6);
        $this->assign('user_info', $user_info);
        $is_eval_app_pass = EvaluationModle::isExistMemberEvaluationPass($this->user['member_list_id']);
        $this->assign('is_eval_app_pass', $is_eval_app_pass);
        //是否post提交
        if ($request->isPost()) {
            $this->applyStatus->storeByChooseType($this->user_id, $type_id, $this->time);
            $data = $request->post();

            $data['user_id'] = $this->user['member_list_username'];
            $data['member_list_id'] = $this->user['member_list_id'];
            //助学金
            $data['application_type'] = $type_id;
            $data['members'] = json_encode($data['members']);

            //删除不必要的数据
            unset($data['studentname'],$data['gender'],$data['birthday']);

            //检查本年是否已经提交过
            $bool = MultipleScholarship::where('user_id', $this->user_id)
                ->where('application_type',$type_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->find();
            if ($bool) {
                //提交过的话。做更新处理
                $data['update_at'] = time();
                $apply = MultipleScholarship::where('multiple_id', $bool['multiple_id'])
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                    ->update($data);
                if (!$apply) {
                    return $this->error("更新失败");
                }
                return $this->success("更新成功");
            }
            //按新增处理
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];

            $insert = MultipleScholarship::create($data);
            if (!$insert) {
                return $this->error("提交失败");
            }
            //获取插入的id，放入总的状态表中
            $type_id = $insert->getLastInsID();
            $this->applyStatus->checkStatus($this->user_id, $this->time, $type_id, "multiple_id",3);
            //更新申请状态
            $res = $this->applyStatus->updateOperateStatus($this->user_id, $this->status);
            if (!$res) {
                return $this->error("插入状态失败");
            }
            return $this->success("提交成功");
        }
        //get请求访问，显示相关的数据
        $data = Db::table('yf_multiple_scholarship')
            ->where('member_list_id', $this->user['member_list_id'])
            ->where('application_type',$type_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();

        $is_data = $data ? true : false;
        $this->assign('is_data', $is_data);
        $data['time'] = $data ? $data['create_at'] : time();
        if (isset($data['members'])) {
            $data['members'] = json_decode($data['members'], true);
        }
        $data['reason'] = isset($data['reason']) ? $data['reason'] : '';
        $this->assign('list', $data);
        return $this->view->fetch('scholarship/scho_grants');
    }

    /**
     * 获取励志奖学金申请书
     * @param Request $request
     * @return mixed|void 返回视图或者相关信息
     */
    public function getInspirational(Request $request)
    {
        $type_id = 2;
        $user_model = new User();
        $user_info = $user_model->get_user($this->user['id_number']);
        //政治面貌
        $user_info['political'] = substr($user_info['political'],-6,6);
        $this->assign('user_info', $user_info);

        //是否post提交
        if ($request->isPost()) {
            $this->applyStatus->storeByChooseType($this->user_id, $type_id, $this->time);
            $data = $request->post();
            $file = $request->file('photo');

            //励志奖学金
            $data['member_list_id'] = $this->user['member_list_id'];
            $data['application_type'] = $type_id;
            $data['members'] = json_encode($data['members']);

            //删除不必要的数据
            unset($data['studentname'],$data['gender'],$data['birthday']);

            //检查本年是否已经提交过
            $bool = MultipleScholarship::where('user_id', $this->user_id)
                ->where('application_type',$type_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->find();
            if ($bool) {
                //提交过的话。做更新处理
                $data['update_at'] = time();
                $apply = MultipleScholarship::where('multiple_id', $bool['multiple_id'])
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                    ->update($data);
                if (!$apply) {
                    return $this->error("更新失败，请联系管理员");
                }
                return $this->success("更新成功");
            }
            //按新增处理
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $insert = MultipleScholarship::create($data);
            if (!$insert) {
                return $this->error("提交失败，请重新提交");
            }
            //获取插入的id，放入总的状态表中
            $multiple_id = $insert->getLastInsID();
            //更新申请状态
            $res = $this->applyStatus->updateOperateStatus($this->user_id, $this->status);
            if (!$res) {
                return $this->error("插入状态失败");
            }
            $this->applyStatus->checkStatus($this->user_id, $this->time, $multiple_id, "national_id" , $type_id);
            return $this->success("提交成功");
        }
        //get请求访问，显示相关的数据
        $data = Db::table('yf_multiple_scholarship')
            ->where('user_id', $this->user_id)
            ->where('application_type',$type_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();

        $data['time'] = time();
        $this->assign('list', $data);
        return $this->view->fetch('scholarship/scho_motiv');
    }

    /**
     * 获取国家奖学金申请书
     * @param Request $request
     * @return mixed|void 返回视图或者相关信息
     */
    public function getNationalScholarship(Request $request)
    {
        $type_id = 1;
        //获取学生信息
        $user_info = Db::table('yf_user')
            ->where('studentid', $this->user_id)
            ->field('studentname,id_number,gender,birthday,political,nation,profession,class,department_name,grade,admission_date')
            ->find();
        $user_info['school_system'] = '3年';
        //出生年月
        $user_info['birthday'] = substr($user_info['birthday'],0,6);
        //政治面貌
        $user_info['political'] = substr($user_info['political'],-6,6);
        $user_info['college'] = "广东农工商职业技术学院";
        $this->assign('user_info', $user_info);
        //是否post提交
        if ($request->isPost()) {
            $this->applyStatus->storeByChooseType($this->user_id, 1, $this->time);
            $data = $request->post();
            $data['user_id'] = $this->user_id;
            $data['member_list_id'] = $this->user['member_list_id'];
            $data['awards'] = json_encode($data['awards']);

            //删除不必要的数据
//            unset($data['studentname'],$data['gender'],$data['birthday'],$data['birthday']);
            //检查本年是否已经提交过
            $bool = NationalScholarship::where('member_list_id', $this->user['member_list_id'])
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->find();
            if ($bool) {
                //提交过，做更新处理
                $data['update_at'] = time();
                $apply = NationalScholarship::where('member_list_id', $this->user['member_list_id'])
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                    ->update($data);
                if (!$apply) {
                    return $this->error("更新失败");
                }
                return $this->success("更新成功");
            }
            //没提交过，按新增处理
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $bool = NationalScholarship::create($data);
            if (!$bool) {
                return $this->error("提交失败");
            }
            //获取插入的id，放入总的状态表中
            $national_id = $bool->getLastInsID();

            // //更新申请状态
            $res = $this->applyStatus->updateOperateStatus($this->user_id, $this->status);
            if (!$res) {
                return $this->error("插入状态失败");
            }
            $this->applyStatus->checkStatus($this->user_id, $this->time, $national_id, "national_id",$type_id);
            return $this->success("提交成功");
        }
        //get请求访问，显示相关的数据
        $data = Db::table('yf_national_scholarship')
            ->where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        $data['time'] = time();
        $this->assign('list', $data);
        return $this->view->fetch('scholarship/scho_scholar');
    }

    /**
     * 查看自己的申请状态
     * @return mixed 视图
     */
    public function examineStatus() {
        $this_time = date('Y', time());

        //家庭经济困难评定状态
        $evaluation_status = Db::table('yf_evaluation_status')
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this_time")
            ->where('member_list_id', $this->user['member_list_id'])
            ->field('status')
            ->find();
        $e_status = $evaluation_status['status'];
        if (empty($evaluation_status['status'])) {
            $e_status = '未申请';
            $e_class = 'review-error';
        } elseif (0 < $evaluation_status['status'] && $evaluation_status['status'] < 5) {
            $e_class = 'reviewing';
        } elseif ($evaluation_status['status'] == 5) {
            $e_class = 'review-success';
        } elseif (5 < $evaluation_status['status'] && $evaluation_status['status'] < 9) {
            $e_class = 'review-error';
        }

        //勤工助学状态
        $work_status = Db::table('yf_work_status')
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this_time")
            ->where('user_id', $this->user_id)
            ->field('status')
            ->find();
        $w_status = $work_status['status'];
        if (empty($work_status['status'])) {
            $w_status = '未申请';
            $w_class = 'review-error';
        } elseif ($work_status['status'] == 0){
            $w_class = 'review-error';
        } elseif (1 <= $work_status['status'] && $work_status['status'] <= 2) {
            $w_class = 'reviewing';
        } elseif ($work_status['status'] == 3) {
            $w_class = 'review-success';
        } elseif ($work_status['status'] == 4) {
            $w_class = 'review-error';
        }

        //三金审核状态
//        $user_status = ScholarshipsApplyStatus::where('user_id', $this->user_id)
//            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this_time")
//            ->field('status,fund_type')
//            ->select();
//        if (empty($user_status['fund_type'])) {
//            $n_status = '未申请';
//            $n_class = 'review-error';
//            $m_status = '未申请';
//            $m_class = 'review-error';
//            $u_status = '未申请';
//            $u_class = 'review-error';
//        }
//        foreach ($user_status as $key => $val) {
//            if ($val['fund_type'] == 1) {
//                $n_status = $val['status'];
//                if(0 < $val['status'] && $val['status'] < 4) {
//                    $n_class = 'reviewing';
//                } elseif(5 <= $val['status'] && $val['status'] <= 7) {
//                    $n_class = 'review-error';
//                } elseif($val['status'] == 4) {
//                    $n_class = 'review-success';
//                }
//            } elseif ($val['fund_type'] == 2) {
//                $m_status = $val['status'];
//                if(0 < $val['status'] && $val['status'] < 4) {
//                    $m_class = 'reviewing';
//                } elseif(5 <= $val['status'] && $val['status'] <= 7) {
//                    $m_class = 'review-error';
//                } elseif($val['status'] == 4) {
//                    $m_class = 'review-success';
//                }
//            } elseif ($val['fund_type'] == 3) {
//                $u_status = $val['status'];
//                if(0 <= $val['status'] && $val['status'] < 4) {
//                    $u_class = 'reviewing';
//                } elseif(5 <= $val['status'] && $val['status'] <= 7) {
//                    $u_class = 'review-error';
//                } elseif($val['status'] == 4) {
//                    $u_class = 'review-success';
//                }
//            }
//        }

        //判断是否大二
        $grade = getGrade($this->user['current_grade']);
        if($grade == 2) {
            //判断是否申请过励志奖学金
            if ($this->applyStatus->isHaveApply($this->user_id, 1)) {
                $user_status = ScholarshipsApplyStatus::where('user_id', $this->user_id)
                    ->where('fund_type', 1)
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                    ->find();
                if ($user_status) {
                    $n_status = $user_status['status'];
                    if(0 < $user_status['status'] && $user_status['status'] < 4) {
                        $n_class = 'reviewing';
                    } elseif(5 <= $user_status['status'] && $user_status['status'] <= 7) {
                        $n_class = 'review-error';
                    } elseif($user_status['status'] == 4) {
                        $n_class = 'review-success';
                    }
                } else {
                    $n_status = '未申请';
                    $n_class = 'review-error';
                }
            } else {
                $n_status = '你已经申请励志奖学金，根据规定无法申请国家奖学金';
                $n_class = 'review-error';
            }

            if ($this->applyStatus->isHaveApply($this->user_id, 2)) {
                $user_status = ScholarshipsApplyStatus::where('user_id', $this->user_id)
                    ->where('fund_type', 2)
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                    ->find();
                if ($user_status) {
                    $m_status = $user_status['status'];
                    if(0 < $user_status['status'] && $user_status['status'] < 4) {
                        $m_class = 'reviewing';
                    } elseif(5 <= $user_status['status'] && $user_status['status'] <= 7) {
                        $m_class = 'review-error';
                    } elseif($user_status['status'] == 4) {
                        $m_class = 'review-success';
                    }
                } else {
                    $m_status = '未申请';
                    $m_class = 'review-error';
                }
            } else {
                $m_status = '你已经申请国家奖学金，根据规定无法申请励志奖学金';
                $m_class = 'review-error';
            }

        } else {
            $n_status = "你不是二年级学生,根据规定只有大二以上才可申请";
            $n_class = 'review-error';
            $m_status = "你不是二年级学生,根据规定只有大二以上才可申请";
            $m_class = 'review-error';
        }

        $user_status = ScholarshipsApplyStatus::where('user_id', $this->user_id)
            ->where('fund_type', 3)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        if ($user_status) {
            $u_status = $user_status['status'];
            if (0 < $user_status['status'] && $user_status['status'] < 4) {
                $u_class = 'reviewing';
            } elseif (5 <= $user_status['status'] && $user_status['status'] <= 7) {
                $u_class = 'review-error';
            } elseif ($user_status['status'] == 4) {
                $u_class = 'review-success';
            }
        } else {
            $u_status = '未申请';
            $u_class = 'review-error';
        }

        $this->assign('e_status',$e_status);
        $this->assign('e_class',$e_class);
        $this->assign('w_status',$w_status);
        $this->assign('w_class',$w_class);
        $this->assign('u_status',$u_status);
        $this->assign('u_class',$u_class);
        $this->assign('n_status',$n_status);
        $this->assign('n_class',$n_class);
        $this->assign('m_status',$m_status);
        $this->assign('m_class',$m_class);
        return $this->view->fetch('student_personal_front/personal_status');
    }

    /**
     * 家庭经济认证
     * @return mixed 视图
     */
    public function submitIdentify(Request $request)
    {
        if ($request->isPost()) {
            $data = $request->post();
            $this->identify = new Identify();
            //删除不必要的数据
            unset($data['ide-reg-oer-res']);
            //转化为可存储的
            if (!empty($data['members'])){
                $data['members'] = serialize($data['members']);
            }
            //检察是否存在
            if ($this->identify->existPopulation($this->user_id, time())) {
                $data['update_at'] = time();
                //更新
                Identify::where('user_id', $this->user_id)
                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")   //只更新今年申请的。
                    ->update($data);
                return redirect('/index');
                //不存在就插入新的记录
            } else {
                $data['user_id'] = $this->user_id;                  //测试数据
                $data['create_at'] = time();
                $data['update_at'] = $data['create_at'];
                $re = Identify::create($data);
                $type_id = $re->getLastInsID();
                $this->status->checkStatus($this->user_id, $this->time, $type_id, "identify_id");
                return redirect('../index');
            }
            //如果是ajax访问的话
        } else if ($request->isAjax()){
            //所有需要的字段
            $field = "establish_card, special_person, mini_living, poor_children,
            low_income, orphan, single_parent, martyrs_children, disability, suffering,
            disability_type, housing_situation, car_situation, is_rural_student, disability_grade";
            $data = Db::table('identify')
                ->alias('i')
                ->join('user u', 'u.studentid = i.user_id', 'right')
                ->field($field)
                ->where('user_id', $this->user_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->find();
            //删除没用的row字段
            unset($data['ROW_NUMBER']);
            return $data;
        }
        //获取所有字段
        $field = Db::getTableInfo('identify', 'fields');
        //去掉id，因为id冲突
        unset($field[0]);
        //将数组转化为字符串
        $field = implode(',', $field);
        //查询学生信息
        //先查询他有没有填写过认证
        $bool = Db::table('identify')
            ->where('user_id',$this->user_id)
            ->find();
        if (!$bool) {
            $data = Db::table('User')
                ->alias('u')
                ->join('identify i', 'u.studentid = i.user_id', 'left')
                ->field('u.*,'.$field)
                ->where('u.studentid', $this->user_id)
                ->find();
        } else {
            $data = Db::table('User')
                ->alias('u')
                ->join('identify i', 'u.studentid = i.user_id', 'left')
                ->field('u.*,'.$field)
                ->where('u.studentid', $this->user_id)
                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
                ->find();
        }
        $this->assign('list', $data);
        return $this->fetch('./index/Ide-app-form');
    }

    //显示界面，测试前端
    public function index(Request $request)
    {
        return $this->fetch('./index/Ide-app-form');
    }

    /**
     * 提交贫困证明
     * @param Request $request
     */
    public function submitPoor(Request $request)
    {
        //查看是否已经提交过
        $bool = Poor::where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        if ($bool) {
            return $this->error("你已经上传过了");
        }
        $file = $request->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'Poor');
        if($info){
            //文件的位置信息20170714\4add59834eda69e7c77a5c96377b5a4c.xls
//            dump($info->getSaveName());
            $data['img'] = $info->getSaveName();
            $data['user_id'] = $this->user_id;
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $re = Poor::create($data);
            $type_id = $re->getLastInsID();
            $this->status->checkStatus($this->user_id, $this->time, $type_id, "poor_id");
            return $this->success("上传成功");
        }else{
            // 上传失败获取错误信息
            return $this->error($file->getError());
        }
    }

    /**
     * 提交家庭信息调查表
     * @param Request $request
     */
    public function submitSurvey(Request $request)
    {
        //查看是否已经提交过
        $bool = Survey::where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        if ($bool) {
            return $this->error("你已经上传过了");
        }
        $file = $request->file('file');
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads'.DS.'Survey');
        if($info){
            //文件的位置信息20170714\4add59834eda69e7c77a5c96377b5a4c.xls
//            dump($info->getSaveName());
            $data['img'] = $info->getSaveName();
            $data['user_id'] = $this->user_id;
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
            $re = Survey::create($data);
            $type_id = $re->getLastInsID();
            $this->status->checkStatus($this->user_id, $this->time, $type_id, "survey_id");
            return $this->success("上传成功");
        }else{
            // 上传失败获取错误信息
            return $this->error($file->getError());
        }
    }

    /**
     * 获取所有不可思议的家庭成员
     * @return array
     */
    public function getAllFamily()
    {
        $data = Db::table('identify')
            ->field("members")
            ->where('user_id', $this->user_id)
            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
            ->find();
        unset($data['ROW_NUMBER']);
        //解码。转化为数组
        $data['members'] = unserialize($data['members']);
        //返回json格式的数据
        return $data;
    }

//    /**
//     * 获取手写申请书
//     * @param Request $request
//     * @return mixed|void 返回视图或者相关信息
//     */
//    public function getApplication(Request $request)
//    {
//        //是否post提交
//        if ($request->isPost()) {
//            $data = $request->post();
//            $data['user_id'] = $this->user_id;
//            //检查本年是否已经提交过
//            $bool = Application::where('user_id', $this->user_id)
//                ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
//                ->find();
//            if ($bool) {
//                //提交过的话。做更新处理
//                $data['update_at'] = time();
//                $apply = Application::where('user_id', $this->user_id)
//                    ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
//                    ->update($data);
//                if (!$apply) {
//                    return $this->error("更新失败");
//                }
//                return $this->success("更新成功");
//            }
//            //按新增处理
//            $data['create_at'] = time();
//            $data['update_at'] = $data['create_at'];
//            $bool = Application::create($data);
//            if (!$bool) {
//                return $this->error("提交失败");
//            }
//            //获取插入的id，放入总的状态表中
//            $type_id = $bool->getLastInsID();
//            $this->applyStatus->checkStatus($this->user_id, $this->time, $type_id, "application_id");
//            return $this->success("提交成功");
//        }
//        //get请求访问，显示相关的数据
//        $data = Db::table('yf_application')
//            ->where('user_id', $this->user_id)
//            ->where("CONVERT(VARCHAR(4),DATEADD(S,create_at + 8 * 3600,'1970-01-01 00:00:00'),20) = $this->time")
//            ->find();
//        $this->assign('list', $data);
//        return $this->fetch('./index/apply');
//    }
}
