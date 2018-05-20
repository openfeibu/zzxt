<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/25
 * Time: 17:35
 */

namespace app\home\controller;

use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use app\admin\model\Evaluation as EvaluationModel;
use tests\thinkphp\library\think\hookTest;
use think\Db;
class Publicity extends Base
{
    private $multiple;
    private $national;
    private $applyStatus;
    private $faculty;

    public function __construct()
    {
        parent::__construct();
        $this->faculty = $this->user['faculty_number'];
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
		$this->evaluation = new EvaluationModel();
        $this->applyStatus = new ScholarshipsApplyStatus();
		$this->public_type = input('public_type','ypublic');
		if($this->public_type == 'ypublic')
		{
			$where = " u.faculty_number = '".$this->faculty."'";
            $where .= " AND ass.status in (4)";
		}else{
            $where = " ass.status in (5)";
		}
		$this->common_where = $where;
		$this->assign('public_type',$this->public_type);
    }

    /**
     * 助学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function grantsPublicity($id,$type_id) {
		$type_id = 1;
        $subsidy = Db::table('yf_set_subsidy')
            ->where('id', $type_id)
            ->find();
        $this->assign('subsidy',$subsidy);
		
		$begin_time = $subsidy[$this->public_type.'_begin_time'];
		$end_time = $subsidy[$this->public_type.'_end_time'];
		$this->assign('begin_time',$begin_time);
		$this->assign('end_time',$end_time);
		
		
		if($begin_time <= time() && $end_time >= time())
		{
            $data = $this->multiple->getMultipleList($type_id,$this->common_where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
			
            $data_arr = $data->all();
            $this->assign('page', $show);
            $this->assign('list', $data_arr);
        }
        if(request()->isAjax()){
			return $this->fetch('student_notice/grants_ajax_notice');
		}else{
			return $this->fetch(':student_notice/grants_notice');
		}
    }

    /**
     * 国家励志奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function motivPublicity($id,$type_id) {
        $type_id = 2;
        $subsidy = Db::table('yf_set_subsidy')
            ->where('id', $type_id)
            ->find();
        $this->assign('subsidy',$subsidy);
		
		$begin_time = $subsidy[$this->public_type.'_begin_time'];
		$end_time = $subsidy[$this->public_type.'_end_time'];
		$this->assign('begin_time',$begin_time);
		$this->assign('end_time',$end_time);
		
		
		if($begin_time <= time() && $end_time >= time())
		{
            $data = $this->multiple->getMultipleList($type_id,$this->common_where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
            $this->assign('list',$data);
            $data_arr = $data->all();
            $this->assign('page', $show);
            $this->assign('list', $data_arr);
        }
        if(request()->isAjax()){
			return $this->fetch('student_notice/motiv_ajax_notice');
		}else{
			return $this->fetch(':student_notice/motiv_notice');
		}
    }

    /**
     * 国家奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function scholarPublicity($id,$type_id) {
        $type_id = 3;
        $subsidy = Db::table('yf_set_subsidy')
            ->where('id', $type_id)
            ->find();
        $this->assign('subsidy',$subsidy);
		
		$begin_time = $subsidy[$this->public_type.'_begin_time'];
		$end_time = $subsidy[$this->public_type.'_end_time'];
		$this->assign('begin_time',$begin_time);
		$this->assign('end_time',$end_time);
		
		
		if($begin_time <= time() && $end_time >= time())
		{
            $data = $this->national->getNationalList($this->common_where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
            $this->assign('list',$data);
            $data_arr = $data->all();
            $this->assign('page', $show);
            $this->assign('list', $data_arr);
        }
        if(request()->isAjax()){
			return $this->fetch('student_notice/scholar_ajax_notice');
		}else{
			return $this->fetch(':student_notice/scholar_notice');
		}
    }

    public function evaluPublicity() {
		$subsidy = Db::table('yf_set_subsidy')
            ->where('id', 5)
            ->find();
        $this->assign('subsidy',$subsidy);
		
		$begin_time = $subsidy[$this->public_type.'_begin_time'];
		$end_time = $subsidy[$this->public_type.'_end_time'];
		$this->assign('begin_time',$begin_time);
		$this->assign('end_time',$end_time);
		
		
		if($begin_time <= time() && $end_time >= time())
		{
			$data = $this->evaluation->getEvaluationList($this->common_where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

            $data_arr = $data->all();
            $data_arr = $this->evaluation->handleEvaluationList($data_arr);
            $this->assign('page', $show);
            $this->assign('list', $data_arr);
        }
        if(request()->isAjax()){
			return $this->fetch('student_notice/evalu_ajax_notice');
		}else{
			return $this->fetch(':student_notice/evalu_notice');
		}     
		
		
    }
}
