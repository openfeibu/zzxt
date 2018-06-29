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
        $this->multiple = new MultipleScholarship();
        $this->national = new NationalScholarship();
		$this->evaluation = new Evaluation();
        $this->applyStatus = new ScholarshipsApplyStatus();
        $this->classCode = new ClassCodeModel();
		
		$class_number = $this->admin['class_number'];	
		$this->faculty_number = $this->admin['faculty_number'];
		switch($this->admin['group_id'])
		{
			//班级辅导员
			case '20':	
				$classes = $this->classCode->getCounselorClasses($class_number);
				$class_number = $class_number ? explode(',',$class_number) : [];
				$this->assign('classes', $classes);
				$this->folder = 'counselors';
				break;
			//班级经济评议小组
			case '21':
				$this->class_number = $class_number; 
				$this->folder = 'class';
				break;
			//学院综合评议小组
			case '22':
				$classes = $this->classCode->getFacultyClasses($this->faculty_number);
				$this->assign('classes', $classes);
				$this->folder = 'faculty';
				break;
			//学生资助管理中心	
			case '23':
				$faculties = $this->classCode->getFaculties();
				$this->assign('faculties', $faculties);
				$this->folder = 'studentoffice';
				break;
			//班级三金评议小组
			case '25':
				$this->class_number = $class_number; 
				$this->folder = 'class';
				break;
			//班级综合评议小组
			case '26':
				$this->class_number = $class_number; 
				$this->folder = 'class';
				break;
			
		}
		$p_faculty_number = input('faculty_number',0);
        $p_class_number = input('class_number',0);
        $this->common_where = ' 1 = 1';
        if($p_class_number)
        {
            $this->common_where .= " AND u.class_number = '".$p_class_number."'";
        }else if($p_faculty_number){
			$this->common_where .= " AND u.faculty_number = '".$p_faculty_number."'";
        }else if(isset($this->class_number) && $this->class_number){
			$this->common_where .= " AND u.class_number in (".implode(',',$this->class_number).") ";
		}
		$this->public_type = input('public_type','ypublic');
		if($this->public_type == 'ypublic')
		{
			$this->common_where .= " AND ass.status in (4,5)";
		}else{
			$this->common_where .= " AND ass.status in (4,5)";
		}
		$this->assign('public_type',$this->public_type);
    }

    /**
     * 助学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function grantsPublicity() {
		$type_id = 3;
		$where = $this->common_where;
        $where .= " AND ms.application_type = '".$type_id."'";
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
			$data = $this->multiple->getMultipleList($type_id,$where);
			$show=$data->render();
			$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
			$this->assign('list', $data);
			$this->assign('page', $show);
        }
        if(request()->isAjax()){
			return $this->view->fetch(':publicity/common');
		}else{
			return $this->view->fetch(':publicity/grants');
		}
    }

    /**
     * 国家励志奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function motivPublicity() {
        $type_id = 2;
		$where = $this->common_where;
        $where .= " AND ms.application_type = '".$type_id."'";
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
			$data = $this->multiple->getMultipleList($type_id,$where);
			$show=$data->render();
			$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
			$this->assign('list', $data);
			$this->assign('page', $show);
        }
        if(request()->isAjax()){
			return $this->view->fetch(':publicity/common');
		}else{
			return $this->view->fetch(':publicity/motiv');
		}
    }

    /**
     * 国家奖学金公示
     * @param $id
     * @param $type_id
     * @return mixed
     */
    public function scholarPublicity() {
       
		$type_id = 1;
		$where = $this->common_where;
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
			$data = $this->national->getNationalList($where);
			$show=$data->render();
			$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
			$this->assign('list', $data);
			$this->assign('page', $show);
        }
        if(request()->isAjax()){
			return $this->view->fetch(':publicity/common');
		}else{
			return $this->view->fetch(':publicity/scholar');
		}
    }

    /**
     * 家庭经济困难认定公示
     * @return string
     */
    public function evaluPublicity() {
		$where = $this->common_where;

		$where .= ' AND ((app.faculty_poor_grade <4 AND app.group_poor_grade is null)  OR ( app.faculty_poor_grade <4 AND app.group_poor_grade <4)) ';
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
			$data = $this->evaluation->getEvaluationList($where);
			$show=$data->render();
            $show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);

            $data_arr = $data->all();
            $data_arr = Evaluation::handleEvaluationList($data_arr);
            $this->assign('page', $show);
            $this->assign('list', $data_arr);
        }
        if(request()->isAjax()){
			return $this->view->fetch(':publicity/evaluation_ajax');
		}else{
			return $this->view->fetch(':publicity/evaluation');
		}
    }
}
