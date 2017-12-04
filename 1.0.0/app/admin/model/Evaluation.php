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

    public function getEvaluation($id)
    {
		return Db::table('yf_evaluation_application')
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
    public static function getMaterilaScore($evaluation_id)
    {
        $material = Db::name('evaluation_material')
            ->alias('em')
            ->join('yf_evaluation_application ea ','ea.evaluation_id = em.evaluation_id')
            ->join('yf_evaluation_material_config emc ','em.cid = emc.cid')
            ->field('max(emc.score) as material_score,em.member_list_id')
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
        $material_config_37 = EvaluationMaterialConfig::getConfig(40);
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
        $grade = '不困难';
        $grade_config = Db::name('evaluation_grade')
                   ->where("min <= '$value' AND max >= '$value'")
                   ->find();
        return $grade_config ? $grade_config['name'] : $grade;
    }
}
