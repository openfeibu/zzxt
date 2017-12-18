<?php
/**
 * Created by PhpStorm.
 * User: BC
 * Date: 2017/8/25
 * Time: 17:35
 */

namespace app\admin\controller;

use app\home\model\ScholarshipsApplyStatus;
use app\home\model\MultipleScholarship;
use app\home\model\NationalScholarship;
use app\admin\model\Evaluation;
use app\admin\model\ClassCode as ClassCodeModel;
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
        $this->classCode = new ClassCodeModel();
        $faculties = $this->classCode->getFaculties();
        $this->assign('faculties',$faculties);
    }

    /**
     * 助学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function grantsPublicity($id,$type_id) {
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $where = ' 1 = 1';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        $where .= " AND ms.application_type = '".$type_id."'";
        $where .= " AND ass.status = 4";
        $open_time = Db::table('yf_set_subsidy')
            ->where('id', 6)
            ->find();
        $this->assign('open_time',$open_time);
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = MultipleScholarship::getMultipleList($where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
            $this->assign('list', $data);
            $this->assign('page', $show);
        }
        if(request()->isAjax()){
			return $this->fetch(':notice_front/grants_ajax_notice');
		}else{
			return $this->fetch(':notice_front/grants_notice');
		}
        return $this->view->fetch(':notice_front/grants_notice');
    }

    /**
     * 国家励志奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function motivPublicity($id,$type_id) {
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $where = ' 1 = 1';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        $where .= " AND ms.application_type = '".$type_id."'";
        $where .= " AND ass.status = 4";
        $open_time = Db::table('yf_set_subsidy')
            ->where('id', 6)
            ->find();
        $this->assign('open_time',$open_time);
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = MultipleScholarship::getMultipleList($where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
            $this->assign('list', $data);
            $this->assign('page', $show);
        }
        if(request()->isAjax()){
			return $this->fetch(':notice_front/motivational_ajax_notice');
		}else{
			return $this->fetch(':notice_front/motivational_notice');
		}
    }

    /**
     * 国家奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function scholarPublicity($id,$type_id) {
        //全系
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $where = '1 = 1';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        $where .= " AND ass.fund_type = '".$type_id."'";
        $where .= " AND ass.status = 4";
        $open_time = Db::table('yf_set_subsidy')
            ->where('id', 6)
            ->find();
        $this->assign('open_time',$open_time);
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = NationalScholarship::getNationalList($where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
            $this->assign('list', $data);
            $this->assign('page', $show);
        }
        if(request()->isAjax()){
			return $this->fetch(':notice_front/scholarship_ajax_notice');
		}else{
			return $this->fetch(':notice_front/scholarship_notice');
		}
        return $this->view->fetch(':notice_front/scholarship_notice');
    }

    /**
     * 家庭经济困难认定公示
     * @return string
     */
    public function evaluPublicity() {
        $faculty_number = input('faculty_number',0);
        $class_number = input('class_number',0);
        $where = ' 1 = 1 ';
        if($class_number)
        {
            $where .= " AND u.class_number = '".$class_number."'";
        }else{
            if($faculty_number)
            {
                $where .= " AND u.faculty_number = '".$faculty_number."'";
            }
        }
        $where .= " AND ass.status = 4";
        $open_time = Db::table('yf_set_subsidy')
            ->where('id', 6)
            ->find();
        $this->assign('open_time',$open_time);
        if ($open_time['begin_time'] < time() && $open_time['end_time'] > time()) {
            $data = Evaluation::getEvaluationList($where);
            $show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

            $data_arr = $data->all();
            $data_arr = Evaluation::handleEvaluationList($data_arr);
            $this->assign('page', $show);
            $this->assign('list', $data_arr);
        }
        if(request()->isAjax()){
			return $this->fetch('notice_front/evaluation_ajax_notice');
		}else{
			return $this->fetch(':notice_front/evaluation_notice');
		}

    }
}
