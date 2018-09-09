<?php
/**
 * Created by PhpStorm.
 * User: 13046
 * Date: 2017/7/28
 * Time: 17:26
 */

namespace app\home\controller;

use think\DB;
use think\Config;
use app\home\model\User;
use app\admin\model\EvaluationMaterialConfig;
use app\admin\model\Evaluation as EvaluationModel;
use app\admin\model\MemberList as MemberListModel;

class Show extends Base
{
	protected function _initialize()
    {
		parent::_initialize();
		$this->check_login();
		$this->evaluation = new EvaluationModel();
	}
//    首页方法
    public function index_front()
    {
        return $this->view->fetch(':home_page/index_front');
    }
    public function fund_news()
    {
        return $this->view->fetch(':home_page/fund_news');
    }
    public function fund_policy()
    {
        return $this->view->fetch(':home_page/fund_policy');
    }
    public function notice_details()
    {
        return $this->view->fetch(':home_page/notice_details');
    }
    public function news_details()
    {
        return $this->view->fetch(':home_page/news_details');
    }
    public function policy_details()
    {
        return $this->view->fetch(':home_page/policy_details');
    }
    public function index_notice()
    {
        return $this->view->fetch(':home_page/index_notice');
    }
    //个人中心
//    public function questionnaire()
//    {
//        return $this->view->fetch(':student_personal_front/questionnaire');
//    }
    public function change_pd()
    {
        return $this->view->fetch(':student_personal_front/change_pd');
    }
    //综合状态
    public function personal_status()
    {
        return $this->view->fetch(':student_personal_front/personal_status');
    }
//    评估页方法
    public function personal()
    {
		$is_eval_group = MemberListModel::isEvalGroup($this->user['id_number']);
		$this->assign('is_eval_group',$is_eval_group);

		if($is_eval_group){
			return $this->view->fetch(':evaluation/personal_front');
		}
		$is_open = $this->evaluation->is_open();
		$this->assign('is_close',false);
		$eval_app = $this->evaluation->getMemberEvaluation($this->user['member_list_id']);
		if(!$is_open && !$eval_app)
		{
			$this->assign('is_close',true);
			$this->assign('subsidy',$this->evaluation->subsidy);
			return $this->view->fetch(':evaluation/personal_front');
		}
		$user_model = new User();
		$user_info = $user_model->get_user($this->user['id_number']);
		$this->assign('user',$this->user);
		$this->assign('user_info',$user_info);
		$this->assign('user_info',$user_info);
		
		$pass_status = DB::name('evaluation_status')->where('evaluation_id',$eval_app['evaluation_id'])->find();
        $this->assign('pass_status',$pass_status['status']);
		if(!$eval_app)
		{
			$eval_app = [
				'number' => '',
				'annual_income' => '',
				'reason' => '',
				'update_at' => time(),
			];
			$is_eval_app = 0;
			$this->assign('is_eval_app',0);
		}
		else{
			$is_eval_app = 1;
			$this->assign('is_eval_app',1);
		}
		$eval_app['time'] = $is_eval_app ? $eval_app['create_at'] : time();
		$this->assign('eval_app',$eval_app);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);
        return $this->view->fetch(':evaluation/personal_front');
    }
	public function evaluation_application()
	{
		$user_model = new User();
		$user_info = $user_model->get_user($this->user['id_number']);
		$subsidy = Db::table('yf_set_subsidy')
                ->where('id', 5)
                ->find();
		$begintime = $subsidy['begin_time'];
		$eval_app = $this->evaluation->getMemberEvaluation($this->user['member_list_id']);
        $pass_status = DB::name('evaluation_status')->where('evaluation_id',$eval_app['evaluation_id'])->find();
//		if($eval_app)
//		{
//			return [
//				'code' => 201,
//				'message' => $pass_status['evaluation_id'],
// 			];
//		}
		$post=input('post.');
		$data = [
			//'number' => isset($post['number']) ? $post['number'] : '',
			'annual_income' => isset($post['annual_income']) ? $post['annual_income'] : '',
			'reason' => isset($post['reason']) ? $post['reason'] : '',
			'update_at' => time(),
		];
		$user_data = [
			'phone' => isset($post['phone']) ? $post['phone'] : '',
		];
		DB::name('user')->where('id_number',$this->user['id_number'])->update($user_data);
		$data['member_list_id'] = $this->user['member_list_id'];
		//$eval_fraction = get_score($data);
		
        if (isset($eval_app)) {
			/*
			if($pass_status['status'] != 9)
			{
				return [
					'code' => 201,
					'message' => '此状态下不允许修改',
				];
			}
			*/
			return [
				'code' => 201,
				'message' => '不允许修改',
			];
            $eva_app = DB::name('evaluation_application')->where('evaluation_id',$pass_status['evaluation_id'])->update($data);
            DB::name('evaluation_status') ->where('status_id',$pass_status['status_id'])->update([
                'status'=> 1,
                'member_list_id' => $this->user['member_list_id'],
                'create_at' => time(),
                'update_at' => time(),
            ]);
        } else {
			$data['create_at'] = time();
			$data['times'] = $begintime;
			$data['assess_fraction'] = $data['score'] = 0;
            $eva_app = DB::name('evaluation_application')->insert($data);
            $evaluation_id = Db::name('evaluation_application')->getLastInsID();
            DB::name('evaluation_status')->insert([
                'evaluation_id' => $evaluation_id,
                'status'=> 1,
                'member_list_id' => $this->user['member_list_id'],
                'create_at' => time(),
                'update_at' => time(),
            ]);
        }

		return [
			'code' => 200,
			'message' => '提交成功',
		];
	}
    public function material()
    {
		$eval_app = $this->evaluation->getMemberEvaluation($this->user['member_list_id']);
		$this->assign('eval_app',$eval_app);
		$material = DB::name('evaluation_material')->alias('em')->join('yf_evaluation_material_config emc ','em.cid = emc.cid')->field('em.evaluation_id,em.member_list_id,em.images,emc.*')->where('em.evaluation_id',$eval_app['evaluation_id'])->select();
		$this->assign('material',$material);
		$material_configs = EvaluationMaterialConfig::getConfigs(1);
		$this->assign('material_configs',$material_configs);
		$this->assign('m',1);
        return $this->view->fetch(':evaluation/material_front');
    }
	public function material_upload()
	{
		
		if(request()->file('uploadfile') !== null )
		{
			$file = request()->file('uploadfile');

			$info = $file->validate(['ext'=>'jpg,png,gif,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
		}
		if($info){
			return [
				'code' => 200,
				'url' => '/public/uploads/'.$info->getSaveName(),
				'message' => '上传成功',
			];
		}else{
			return [
				'code' => 201,
				'message' => $file->getError(),
			]; 
		}
	}
	public function material_post()
	{
		$eval_app = $this->evaluation->getMemberEvaluation($this->user['member_list_id']);
		if(!$eval_app){
			return [
				'code' => 201,
				'message' => '请先提交家庭经济困难学生认定申请',
			]; 
		}
		$member_list_headpic = $_POST['member_list_headpic_url'];
		$rst=Db::name('member_list')->where(array('member_list_id'=>$this->user['member_list_id']))->update(['member_list_headpic' => $member_list_headpic]);
		$cids = $_POST['cids'];
		$images = $_POST['images'];
		$data = [];
		foreach($cids as $key => $val)
		{
			if($images[$key])
			{
				$data[] = [
					'evaluation_id' => $eval_app['evaluation_id'],
					'cid' => $val,
					'images' => $images[$key],
					'member_list_id' => $this->user['member_list_id'],
				];
				
			}
		}
		DB::name('evaluation_material')->insertAll($data);
		$assess_fraction = EvaluationModel::getMaterilaScore($eval_app['evaluation_id']);
		DB::name('evaluation_application')->where('evaluation_id',$eval_app['evaluation_id'])->update(['assess_fraction' => $assess_fraction,'score' => $assess_fraction]);
		return [
			'code' => 200,
			'message' => '提交成功',
		];
	}
    public function evalu_status()
    {
        return $this->view->fetch(':evaluation/evalu_status');
    }
//    勤工助学页方法
    public function work()
    {
        return $this->view->fetch(':work/work_personal');
    }
    public function job_declar()
    {
        return $this->view->fetch(':work/job_declar');
    }
    public function job_status()
    {
        return $this->view->fetch(':work/job_status');
    }
//    奖助学金页方法
    public function grants()
    {
        return $this->view->fetch(':scholarship/scho_grants');
    }
    public function motivational()
    {
        return $this->view->fetch(':scholarship/scho_motiv');
    }
    public function scholarship()
    {
        return $this->view->fetch(':scholarship/scho_scholar');
    }
    public function scho_status()
    {
        return $this->view->fetch(':scholarship/scho_status');
    }
    //评估系统公示
    public function evalu_notice()
    {
        return $this->view->fetch(':student_notice/evalu_notice');
    }
    //助学金公示
    public function grants_notice()
    {
        return $this->view->fetch(':student_notice/grants_notice');
    }
    //奖学金公示
    public function scholar_notice()
    {
        return $this->view->fetch(':student_notice/scholar_notice');
    }
    //励志奖学金公示
    public function motiv_notice()
    {
        return $this->view->fetch(':student_notice/motiv_notice');
    }
    //前台系统公告
    public function system_notice()
    {
        return $this->view->fetch(':student_notice/system_notice');
    }
}
