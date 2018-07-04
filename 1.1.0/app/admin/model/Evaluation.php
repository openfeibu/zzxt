<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------

namespace app\admin\model;

use think\Model;
use think\Db;
use app\admin\model\MemberList;
use app\admin\model\EvaluationMaterialConfig;

class Evaluation extends Model
{
	public function __construct()
	{
		parent::__construct();
		$this->subsidy = Db::name('set_subsidy')
                ->where('id', 5)
                ->find();
	}
    public function getEvaluation($id)
    {
		return Db::name('evaluation_application')
				->alias('app')
                ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
				->join('yf_user u', 'u.id_number = m.id_number', 'left')
                ->field('u.*,app.*')
				->where('evaluation_id',$id)
				->find();
	}
    public static function getEvaluationMaterial($evaluation_id)
    {
        return Db::name('evaluation_material')
            ->alias('em')
            ->join('yf_evaluation_material_config emc ','em.cid = emc.cid')
            ->field('em.evaluation_id,em.member_list_id,em.images,emc.*')->where('em.evaluation_id',$evaluation_id)
            ->select();
    }
	public static function handleEvaluation($data)
	{
		$data['material_score'] = self::getMaterilaScore($data['evaluation_id']);
		$grade = self::getGrade($data['score']);
		$data['system_poor_grade_name'] = $grade['poor_grade_name'];
		$data['system_poor_grade'] = $grade['poor_grade'];
		$data['group_poor_grade_name'] = self::getGradeData($data['group_poor_grade'],'name');
		$data['faculty_poor_grade_name'] = self::getGradeData($data['faculty_poor_grade'],'name');
		$data['poor_grade_name'] = self::getGradeData($data['school_poor_grade'],'name');
		$data = handleApply($data);
		return $data;
	}
    public static function getMaterilaScore($evaluation_id)
    {
        $material = Db::name('evaluation_material')
            ->alias('em')
            ->join('yf_evaluation_application ea ','ea.evaluation_id = em.evaluation_id')
            ->join('yf_evaluation_material_config emc ','em.cid = emc.cid')
            ->field('sum(emc.score) as material_score,em.member_list_id')
            ->where('em.evaluation_id',$evaluation_id)
            ->group('em.member_list_id')
            ->find();
        $material_score = $material['material_score'] ? $material['material_score'] : 0;
        $member = MemberList :: getMember($material['member_list_id']);
        $material_config_40 = EvaluationMaterialConfig::getConfig(40);
        if($material_config_40 && $member['nation'] != '汉族')
        {
            $material_score += $material_config_40['score'];
        }
        $material_config_37 = EvaluationMaterialConfig::getConfig(37);
        if($material_config_37 && $member['is_rural_student'] == '是')
        {
            $material_score += $material_config_37['score'];
        }
        return $material_score;
    }
    public static function getGradeConfigs()
    {
        return Db::name('evaluation_grade')->order('id asc')->select();
    }
    public static function getGrade($value)
    {
        $poor_grade_name = '不困难';
		$poor_grade = 4;
        $grade_config = Db::name('evaluation_grade')
                   ->where("max <= '$value'")
                   ->order("max desc")
                   ->find();
        if($grade_config){
			$poor_grade_name = $grade_config['name'];
			$poor_grade = $grade_config['id'];
        }else{
            $grade_config = Db::name('evaluation_grade')
                       ->where("min <= '$value' AND max >= '$value'")
                       ->find();
			if($grade_config){
				$poor_grade_name = $grade_config['name'];
				$poor_grade = $grade_config['id'];
			}
        }
		$data = [
			'rank' => $poor_grade_name,
			'poor_grade_name' =>$poor_grade_name,
			'poor_grade' => $poor_grade
		];
        return $data;
    }
	
    public function getEvaluationList($where,$order = '')
    {
        return Db::name('evaluation_status')
                    ->alias('ass')
                    ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id')
                    ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
                    ->where($where)
					->where('app.times',$this->subsidy['begin_time'])
                    ->order($order)
					->order('evaluation_id desc')
                    ->field('ass.*,m.member_list_username,m.member_list_nickname,app.assess_fraction,app.score,app.change_fraction,app.evaluation_status,app.group_opinion,app.faculty_opinion,app.school_opinion,app.group_poor_grade,app.faculty_poor_grade,app.school_poor_grade, u.*')
                    ->paginate(40);
    }
    public function getAllEvaluationList($where)
    {
        return Db::name('evaluation_status')
                    ->alias('ass')
                    ->join('yf_evaluation_application app','ass.evaluation_id = app.evaluation_id')
                    ->join('yf_member_list m', 'm.member_list_id = ass.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
        			->order('score desc')
        			->where($where)
					->where('app.times',$this->subsidy['begin_time'])
                    ->field('ass.*,m.member_list_username,m.member_list_nickname,app.assess_fraction,app.score,app.change_fraction,app.evaluation_status,app.group_opinion,app.faculty_opinion,app.school_opinion,app.group_poor_grade,app.faculty_poor_grade,app.school_poor_grade,u.*')
                    ->select();
    }
    public static function handleEvaluationList($data)
    {
        foreach ($data as $key => $val) {
			$data[$key] = self::handleEvaluation($val);
        }
        return $data;
    }
    public function isExistMemberEvaluation($member_list_id)
    {
        $eval_app = Db::name('evaluation_application')
				->where('member_list_id',$member_list_id)
				->where('times',$this->subsidy['begin_time'])
                ->field('evaluation_id')
				->find();
        return $eval_app ? $eval_app['evaluation_id'] : 0;
    }
    public function isExistMemberEvaluationPass($member_list_id)
    {
        $eval_app = Db::name('evaluation_application')
				->where('member_list_id',$member_list_id)
                ->where(['evaluation_status' => ['in','5']])
				->where(['school_poor_grade' => ['in','1,2,3']])
				->where('times',$this->subsidy['begin_time'])
                ->field('evaluation_id')
				->find();
        return $eval_app ? $eval_app['evaluation_id'] : 0;
    }
	public function getMemberEvaluation($member_list_id)
	{
		$eval_app = DB::name('evaluation_application')->where('member_list_id',$member_list_id)->where('times',$this->subsidy['begin_time'])->find();
		return $eval_app;
	}
	public function getCount($where = '')
    {
        $count = Db::name('evaluation_application')
                    ->alias('app')
                    ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
                    ->join('yf_user u', 'u.id_number = m.id_number', 'left')
					->where('times',$this->subsidy['begin_time']);
		if($where)		
		{
			$count = $count->where($where);
		}
                    
        $count = $count->count();
		return $count;
    }
	public static function getGradeData($id,$value = 'name')
	{
		return Db::name('evaluation_grade')->where('id',$id)->value($value);
	}
	public static function getGradesHtml($grade = 1,$name="grade")
	{
		$grade = $grade ? $grade : 1;
		$grades = self::getGradeConfigs();
		$html = '<select name="'.$name.'">';
		foreach($grades as $key => $value)
		{
			if($value['id'] == $grade)
			{
				$html .= '<option value="'.$value['id'].'" selected>'.$value['name'].'</option>';
			}else{
				$html .= '<option value="'.$value['id'].'">'.$value['name'].'</option>';
			}
			
		}
		$html .= '</select>';
		return $html;
	}
	public function getMemberEvaluationGradeName($member_list_id)
	{
		$school_poor_grade = Db::name('evaluation_application')
				->where('member_list_id',$member_list_id)
                ->where(['evaluation_status' => ['in','4,5']])
				->where(['school_poor_grade' => ['in','1,2,3']])
				->where('times',$this->subsidy['begin_time'])
                ->field('evaluation_id')
				->value('school_poor_grade');
        $school_poor_grade =  $school_poor_grade ? $school_poor_grade : 0;
		return self::getGradeData($school_poor_grade);
	}
	public function getEvaluationNext($evaluation_id,$where = "",$order)
	{
		$next_apply = Db::table('yf_evaluation_application')
            ->alias('app')
			->join('yf_evaluation_status ass', 'ass.evaluation_id = app.evaluation_id')
            ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('app.evaluation_id','<',$evaluation_id)
			->where($where)
			->order($order)
			->order('evaluation_id desc')
			->field('ass.status_id,app.evaluation_id,app.evaluation_status')
			->find();
		return $next_apply;
	}
	public function getEvaluationNextUrl($evaluation_id,$type,$where="",$order="")
	{
		$next_url = "";
		$next_apply = $this->getEvaluationNext($evaluation_id,$where,$order);
		if($next_apply){
			$next_url = url('admin/'.$type.'/showEvaluationMaterial',['id' => $next_apply['status_id']]);
		}
		return $next_url;
	}
	public function getEvaluationPrevious($evaluation_id,$where="",$order="")
	{
		$previous_apply = Db::table('yf_evaluation_application')
            ->alias('app')
			->join('yf_evaluation_status ass', 'ass.evaluation_id = app.evaluation_id')
            ->join('yf_member_list m', 'm.member_list_id = app.member_list_id')
            ->join('yf_user u', 'u.id_number = m.id_number', 'left')
            ->where('app.evaluation_id','>',$evaluation_id)
			->where($where)
			->order($order)
			->order('evaluation_id asc')
			->field('ass.status_id,app.evaluation_id,app.evaluation_status')
			->find();
		return $previous_apply;
	}
	public function getEvaluationPreviousUrl($evaluation_id,$type,$where="",$order="")
	{
		$previous_url = "";
		$previous_apply = $this->getEvaluationPrevious($evaluation_id,$where,$order);
		if($previous_apply){
			$previous_url = url('admin/'.$type.'/showEvaluationMaterial',['id' => $previous_apply['status_id']]);
		}
		return $previous_url;
	}
	
}
