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

class Show extends Base
{
	protected function _initialize()
    {
		parent::_initialize();
		$this->check_login();
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
		$user_model = new User();
		$user_info = $user_model->get_user($this->user['member_list_username']);
		$this->assign('user',$this->user);
		$this->assign('user_info',$user_info);
		$eval_app = DB::name('evaluation_application')->where('user_id',$this->user['member_list_username'])->find();
		if(!$eval_app)
		{
			$eval_app = [
				'population' =>  0,
				'school_population' => 0,
				'account' => 0,
				'establish_card' => 0,
				'special_person' => 0,
				'mini_living' => 0,
				'poor_children' => 0,
				'low_income' => 0,
				'orphan' =>0,
				'single_parent' => 0,
				'martyrs_children' => 0,
				'disability' => 0,
				'disability_type' => 0,
				'disability_type_other' => '',
				'disability_grade' => 0,
				'disability_other' =>'',
				'suffering' => 0,
				'residence_address' => '',
				'residence_address_situation' => 0,
				'zip_code' => '',
				'number' => '',
				'annual_income' => '',
				'housing_situation' => 0,
				'housing_situation_other' => '',
				'car_situation' => '',
				'income_source' => '',
				'funded' => '',
				'natural_disasters' =>  '',
				'natural_disasters_type' => 0,
				'unexpected_events' => '',
				'debt' => '',
				'other' => '',
				'housing_other' => '',
			];
			$this->assign('is_eval_app',0);
		}
		else{
			$this->assign('is_eval_app',1);
			$eval_app['members'] = unserialize($eval_app['members']);
		}
		$this->assign('eval_app',$eval_app);
		$eval_form = Config::get('evaluation_form');
		$this->assign('eval_form',$eval_form);
        return $this->view->fetch(':evaluation/personal_front');
    }
	public function evaluation_application()
	{
		$user_model = new User();
		$user_info = $user_model->get_user($this->user['member_list_username']);
		$eval_app = DB::name('evaluation_application')->where('user_id',$this->user['member_list_username'])->find();
		if($eval_app)
		{
			return [
				'code' => 201,
				'message' => '请勿重复申请',
 			];
		}
		$post=input('post.');
		$data = [
			'population' => isset($post['population']) ? intval($post['population']) : 0,
			'school_population' => isset($post['school_population']) ? intval($post['school_population']) : 0,
			'account' => isset($post['account']) ? intval($post['account']) : 1,
			'establish_card' => isset($post['establish_card']) ? intval($post['establish_card']) : 0,
			'special_person' => isset($post['special_person']) ? intval($post['special_person']) : 0,
			'mini_living' => isset($post['mini_living']) ? intval($post['mini_living']) : 0,
			'poor_children' => isset($post['poor_children']) ? intval($post['poor_children']) : 0,
			'low_income' => isset($post['low_income']) ? intval($post['low_income']) : 0,
			'orphan' => isset($post['orphan']) ? intval($post['orphan']) : 0,
			'single_parent' => isset($post['single_parent']) ? intval($post['single_parent']) : 0,
			'martyrs_children' => isset($post['martyrs_children']) ? intval($post['martyrs_children']) : 0,
			'disability' => isset($post['disability']) ? intval($post['disability']) : 0,
			'disability_type' => isset($post['disability_type']) ? intval($post['disability_type']) : 0,
			'disability_type_other' => isset($post['disability_type_other']) ? $post['disability_type_other'] : '',
			'disability_grade' => isset($post['disability_grade']) ? intval($post['disability_grade']) : 0,
			'disability_other' => isset($post['disability_other']) ? $post['disability_other'] : '',
			'suffering' => isset($post['suffering']) ? intval($post['suffering']) : 0,
			'residence_address' => isset($post['residence_address']) ? $post['residence_address'] : '',
			'residence_address_situation' => isset($post['residence_address_situation']) ? intval($post['residence_address_situation']) : 0,
			'zip_code' => isset($post['zip_code']) ? $post['zip_code'] : '',
			'number' => isset($post['number']) ? $post['number'] : '',
			'annual_income' => isset($post['annual_income']) ? $post['annual_income'] : '',
			'housing_situation' => isset($post['housing_situation']) ? intval($post['housing_situation']) : 0,
			'housing_situation_other' => isset($post['housing_situation_other']) ? $post['housing_situation_other'] : '',
			'car_situation' => isset($post['car_situation']) ? $post['car_situation'] : '',
			'income_source' => isset($post['income_source']) ? $post['income_source'] : '',
			'funded' => isset($post['funded']) ? $post['funded'] : '',
			'natural_disasters' => isset($post['natural_disasters']) ? $post['natural_disasters'] : '',
			'natural_disasters_type' => isset($post['natural_disasters_type']) ? $post['natural_disasters_type'] : 0,
			'unexpected_events' => isset($post['unexpected_events']) ? $post['unexpected_events'] : '',
			'unexpected_events_type' => isset($post['unexpected_events_type']) ? $post['unexpected_events_type'] : 0,
			'debt' => isset($post['debt']) ? $post['debt'] : '',
			'other' => isset($post['other']) ? $post['other']  : '',
			'housing_other' => isset($post['housing_other']) ? $post['housing_other'] : '',
		];
		$data['user_id'] = $this->user['member_list_username'];
		$data['members'] = serialize($post['members']);
		$eval_fraction = get_score($data);
		$data['assess_fraction'] = $data['score'] = $eval_fraction;
 		$eva_app = DB::name('evaluation_application')->insert($data);
		$evaluation_id = Db::name('evaluation_application')->getLastInsID();
		DB::name('evaluation_status')->insert([
			'evaluation_id' => $evaluation_id,
			'status'=> 1,
			'user_id' => $this->user['member_list_username'],
			'create_at' => time(),
			'update_at' => time(),
		]);

		return [
			'code' => 200,
			'message' => '提交成功', 
		];
	}
    public function material()
    {
		$eval_app = DB::name('evaluation_application')->where('user_id',$this->user['member_list_username'])->find();
		$this->assign('eval_app',$eval_app);
		$material = DB::name('evaluation_material')->where('evaluation_id',$eval_app['evaluation_id'])->find();
		$this->assign('material',$material);
        return $this->view->fetch(':evaluation/material_front');
    }
	public function material_upload()
	{
		if(request()->file('uploadfile') !== null )
		{
			$file = request()->file('uploadfile');
			$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');		
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
		$eval_app = DB::name('evaluation_application')->where('user_id',$this->user['member_list_username'])->find();
		$post = input('post.');
		$data = [
			'evaluation_id' => $eval_app['evaluation_id'],
			'user_id' => $this->user['member_list_username'],
			'account_book' => !empty($post['account_book_url']) ? $post['account_book_url'] : '',
			'protection_certificate' => !empty($post['protection_certificate_url']) ? $post['protection_certificate_url'] : '',
			'low_certificate' => !empty($post['low_certificate_url']) ? $post['low_certificate_url'] : '',
			'orphan' => !empty($post['orphan_url']) ? $post['orphan_url'] : '',
			'rescue_card' => !empty($post['rescue_card_url']) ? $post['rescue_card_url'] : '',
			'help_certificate' => !empty($post['help_certificate_url']) ? $post['help_certificate_url'] : '',
			'low_income_card' => !empty($post['low_income_card_url']) ? $post['low_income_card_url'] : '',
			'disability_certificate' => !empty($post['disability_certificate_url']) ? $post['disability_certificate_url'] : '',
			'child_welfare_certificate' => !empty($post['child_welfare_certificate_url']) ? $post['child_welfare_certificate_url'] : '',
			'poor_workers' => !empty($post['poor_workers_url']) ? $post['poor_workers_url'] : '',
			'privilege_card' => !empty($post['privilege_card_url']) ? $post['privilege_card_url'] : '',
			'sacrifice_card' => !empty($post['sacrifice_card_url']) ? $post['sacrifice_card_url'] : '',
			'civil_affairs_department' => !empty($post['civil_affairs_department_url']) ? $post['civil_affairs_department_url'] : '',
			'other' => !empty($post['other_url']) ? $post['other_url'] : '',
		];
		DB::name('evaluation_material')->insert($data);
		header('Location:/material.html');
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