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
        $this->faculty = 5;
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
        $this->applyStatus = new ScholarshipsApplyStatus();
    }

    /**
     * 助学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function grantsPublicity($id,$type_id) {
        $faculty = input('faculty',1);
        $data = [];
        $where = ' 1 = 1';
        if($faculty)
        {
            $where .= " AND u.faculty_number = '".$this->faculty."'";
            $where .= " AND ass.status = 4";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
        }else{
            $where .= " AND ass.status = 5";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 7)
                ->find();
            $this->assign('open_time',$open_time);
        }
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = MultipleScholarship::getMultipleList($where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
            $this->assign('list',$data);
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
        $faculty = input('faculty',1);
        $data = [];
        $where = ' 1 = 1';
        if($faculty)
        {
            $where .= " AND u.faculty_number = '".$this->faculty."'";
            $where .= " AND ass.status = 4";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
        }else{
            $where .= " AND ass.status = 5";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 7)
                ->find();
            $this->assign('open_time',$open_time);
        }
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = MultipleScholarship::getMultipleList($where);
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
        $faculty = input('faculty',1);
        $data = [];
        $where = ' 1 = 1';
        if($faculty)
        {
            $where .= " AND u.faculty_number = '".$this->faculty."'";
            $where .= " AND ass.status = 4";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
        }else{
            $where .= " AND ass.status = 5";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 7)
                ->find();
            $this->assign('open_time',$open_time);
        }
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = NationalScholarship::getNationalList($where);
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
        $faculty = input('faculty',1);
        $data = [];
        $where = ' 1 = 1';
        if($faculty)
        {
            $where .= " AND u.faculty_number = '".$this->faculty."'";
            $where .= " AND ass.status in (4,5)";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 6)
                ->find();
            $this->assign('open_time',$open_time);
        }else{
            $where .= " AND ass.status = 5";
            $open_time = Db::table('yf_set_subsidy')
                ->where('id', 7)
                ->find();
            $this->assign('open_time',$open_time);
        }
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = EvaluationModel::getEvaluationList($where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

            $data_arr = $data->all();
            $data_arr = EvaluationModel::handleEvaluationList($data_arr);
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
