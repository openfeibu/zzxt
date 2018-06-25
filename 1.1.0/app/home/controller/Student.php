<?php

namespace app\home\controller;

use think\Controller;
use think\Request;
use think\Db;
use think\File;
use app\home\model\Survey;
use app\home\model\Identify;
use app\home\model\Poor;
use app\admin\model\Evaluation as EvaluationModel;
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
		$this->check_active();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->NationalScholarship = new NationalScholarship();
		$this->MultipleScholarship = new MultipleScholarship();
        $this->evaluation = new EvaluationModel();
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
                    if ($this->MultipleScholarship->isHaveApply($this->user['member_list_id'], 2)) {
                        $this->error("抱歉，你已申请励志奖学金，不能申请奖学金");
                    }
                    $this->success('成功',url('/home/nationalScholarship'));
                }
                $this->error("抱歉，大二或大三生才能申请奖学金");
                break;

            //励志奖学金
            case 2 :
				$is_eval_app_pass = $this->evaluation->isExistMemberEvaluationPass($this->user['member_list_id']);
                if(!$is_eval_app_pass)
                {
                    $this->error('抱歉，通过家庭困难认定后才能申请');
                }

                //判断是否大二
                if($grade == 2) {
                    //判断是否申请过国家奖学金
                    if ($this->NationalScholarship->isHaveApply($this->user['member_list_id'], 1)) {
						$this->error("抱歉，你已申请奖学金，不能申请励志奖学金");
                    }		
					$this->success('成功',url('/home/inspirational'));	
                }
                $this->error("抱歉，大二学生才能申请励志奖学金");
                break;

            //助学金
            case 3 :
                $is_eval_app_pass = $this->evaluation->isExistMemberEvaluationPass($this->user['member_list_id']);
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
        $is_eval_app_pass = $this->evaluation->isExistMemberEvaluationPass($this->user['member_list_id']);
        $this->assign('is_eval_app_pass', $is_eval_app_pass);
		
		//检查本年是否已经提交过
        $application = $this->MultipleScholarship->isHaveApply($this->user['member_list_id'],$type_id);
        //是否post提交
        if ($request->isPost()) {
            $data = $request->post();
            $data['user_id'] = $this->user['member_list_username'];
            $data['member_list_id'] = $this->user['member_list_id'];
            //助学金
            $data['application_type'] = $type_id;
            $data['members'] = json_encode($data['members']);
			
			$user_data = [
				'phone' => isset($data['phone']) ? $data['phone'] : '',
			];
			DB::name('user')->where('id_number',$this->user['id_number'])->update($user_data);
            //删除不必要的数据
            unset($data['studentname'],$data['gender'],$data['birthday'],$data['phone']);

            if ($application) {
                //提交过的话。做更新处理
                $data['update_at'] = time();
                $apply = MultipleScholarship::where('multiple_id', $application['multiple_id'])->update($data);
                if (!$apply) {
                    return $this->error("更新失败");
                }
				//更新申请状态
				$res = $this->applyStatus->updateStatus($bool['multiple_id'], $type_id ,$this->status);
                return $this->success("更新成功");
            }
            //按新增处理
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
			$subsidy = Db::table('yf_set_subsidy')
                ->where('id', $type_id)
                ->find();
				$begintime = $subsidy['begin_time'];
				$data['times'] = $begintime;
            $insert = MultipleScholarship::create($data);
            if (!$insert) {
                return $this->error("提交失败");
            }
            //获取插入的id，放入总的状态表中
            $multiple_id = $insert->getLastInsID();
            $this->applyStatus->store($multiple_id, $type_id);
            return $this->success("提交成功");
        }
      
		$data = $application;
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
		$user_info['birthday'] = substr($user_info['birthday'],0,6);
        $this->assign('user_info', $user_info);

		//检查本年是否已经提交过
        $application = $this->MultipleScholarship->isHaveApply($this->user['member_list_id'],$type_id);
        //是否post提交
        if ($request->isPost()) {
            $data = $request->post();
            //励志奖学金
            $data['member_list_id'] = $this->user['member_list_id'];
            $data['application_type'] = $type_id;
            $data['members'] = json_encode($data['members']);
			
			$user_data = [
				'phone' => isset($data['phone']) ? $data['phone'] : '',
			];
			DB::name('user')->where('id_number',$this->user['id_number'])->update($user_data);
            //删除不必要的数据
            unset($data['studentname'],$data['gender'],$data['birthday'],$data['phone']);

            if ($application) {
                //提交过的话。做更新处理
                $data['update_at'] = time();
                $apply = MultipleScholarship::where('multiple_id', $application['multiple_id'])
                    ->update($data);
                if (!$apply) {
                    return $this->error("更新失败，请联系管理员");
                }
				$res = $this->applyStatus->updateStatus($application['multiple_id'], $type_id ,$this->status);
                return $this->success("更新成功");
            }
            //按新增处理
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
			$subsidy = Db::table('yf_set_subsidy')
                ->where('id', $type_id)
                ->find();
				$begintime = $subsidy['begin_time'];
				$data['times'] = $begintime;
            $insert = MultipleScholarship::create($data);
            if (!$insert) {
                return $this->error("提交失败，请重新提交");
            }
            //获取插入的id，放入总的状态表中
            $multiple_id = $insert->getLastInsID();
            $this->applyStatus->store($multiple_id, $type_id);
            return $this->success("提交成功");
        }
        //get请求访问，显示相关的数据
        $data = $application;
        $is_data = $data ? true : false;
        $this->assign('is_data', $is_data);
        $data['time'] = $data ? $data['create_at'] : time();
		if (isset($data['members'])) {
            $data['members'] = json_decode($data['members'], true);
        }
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
        $user_model = new User();
        $user_info = $user_model->get_user($this->user['id_number']);
        $user_info['school_system'] = '3年';
        //出生年月
        $user_info['birthday'] = substr($user_info['birthday'],0,6);
        //政治面貌
        $user_info['political'] = substr($user_info['political'],-6,6);
        $user_info['college'] = "广东农工商职业技术学院";
        $this->assign('user_info', $user_info);
		$application = $this->NationalScholarship->isHaveApply($this->user['member_list_id']);
        //是否post提交
        if ($request->isPost()) {
            $data = $request->post();
            $data['user_id'] = $this->user_id;
            $data['member_list_id'] = $this->user['member_list_id'];
            $data['awards'] = json_encode($data['awards']);
			
			$user_data = [
				'phone' => isset($data['phone']) ? $data['phone'] : '',
			];
			DB::name('user')->where('id_number',$this->user['id_number'])->update($user_data);
            //删除不必要的数据
            unset($data['studentname'],$data['gender'],$data['birthday'],$data['birthday'],$data['phone']);
            //检查本年是否已经提交过
            
            if ($application) {
                //提交过，做更新处理
                $data['update_at'] = time();
                $apply = NationalScholarship::where('national_id', $application['national_id'])
						->update($data);
                if (!$apply) {
                    return $this->error("更新失败");
                }
				$res = $this->applyStatus->updateStatus($application['national_id'],$type_id ,$this->status);
                return $this->success("更新成功");
            }
            //没提交过，按新增处理
            $data['create_at'] = time();
            $data['update_at'] = $data['create_at'];
			$subsidy = Db::table('yf_set_subsidy')
                ->where('id', $type_id)
                ->find();
				$begintime = $subsidy['begin_time'];
				$data['times'] = $begintime;

            $bool = Db::name('national_scholarship')->insert($data);
            if (!$bool) {
                return $this->error("提交失败");
            }
            //获取插入的id，放入总的状态表中
            $national_id = Db::name('national_scholarship')->getLastInsID();
            $this->applyStatus->store($national_id, $type_id);
            return $this->success("提交成功");
        }
        //get请求访问，显示相关的数据
		$data = $application;
        $is_data = $data ? true : false;
        $this->assign('is_data', $is_data);
        $data['time'] = $data ? $data['create_at'] : time();
		if (isset($data['awards'])) {
            $data['awards'] = json_decode($data['awards'], true);
        }
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
  
		$eval_app = $this->evaluation->getMemberEvaluation($this->user['member_list_id']);
        $e_status = $eval_app['evaluation_status'];
        if (empty($eval_app['evaluation_status'])) {
            $e_status = '未申请';
            $e_class = 'review-error';
        } elseif (0 < $eval_app['evaluation_status'] && $eval_app['evaluation_status'] < 5) {
            $e_class = 'reviewing';
        } elseif ($eval_app['evaluation_status'] == 5) {
            $e_class = 'review-success';
        } elseif (5 < $eval_app['evaluation_status'] && $eval_app['evaluation_status'] < 9) {
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

        //判断是否大二
        $grade = getGrade($this->user['current_grade']);
        if($grade == 2 || $grade == 3) {
			$nApplication = $this->NationalScholarship->isHaveApply($this->user['member_list_id']);
			$mApplication = $this->MultipleScholarship->isHaveApply($this->user['member_list_id'],2);
            //判断是否申请过励志奖学金
            if (!$mApplication) {
                if ($nApplication) {
					$n_status = $ncheck_status = $nApplication['check_status'];
                    if(0 < $ncheck_status && $ncheck_status < 4) {
                        $n_class = 'reviewing';
                    } elseif(5 <= $ncheck_status && $ncheck_status <= 7) {
                        $n_class = 'review-error';
                    } elseif($ncheck_status == 4) {
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
			
            if (!$nApplication) {
                if ($mApplication) {
					$m_status = $mcheck_status = $mApplication['check_status'];
                    if(0 < $mcheck_status && $mcheck_status < 4) {
                        $m_class = 'reviewing';
                    } elseif(5 <= $mcheck_status && $mcheck_status <= 7) {
                        $m_class = 'review-error';
                    } elseif($mcheck_status == 4) {
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
		$uApplication = $this->MultipleScholarship->isHaveApply($this->user['member_list_id'],3);

		
        if ($uApplication) {
			$u_status = $ucheck_status = $uApplication['check_status'];
            if (0 < $ucheck_status && $ucheck_status < 4) {
                $u_class = 'reviewing';
            } elseif (5 <= $ucheck_status && $ucheck_status <= 7) {
                $u_class = 'review-error';
            } elseif ($ucheck_status == 4) {
                $u_class = 'review-success';
            }
        } else {
            $u_status = '未申请';
            $u_class = 'review-error';
        }
		
		$e_status_name = isset(config('status_stu')[$e_status]) ? config('status_stu')[$e_status] : $e_status;
		$u_status_name = isset(config('status_stu')[$u_status]) ? config('status_stu')[$u_status] : $u_status;
		$m_status_name = isset(config('status_stu')[$m_status]) ? config('status_stu')[$m_status] : $m_status;
		$n_status_name = isset(config('status_stu')[$n_status]) ? config('status_stu')[$n_status] : $n_status;
		$this->assign('e_status_name',$e_status_name);
		$this->assign('u_status_name',$u_status_name);
		$this->assign('m_status_name',$m_status_name);
		$this->assign('n_status_name',$n_status_name);
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


}
