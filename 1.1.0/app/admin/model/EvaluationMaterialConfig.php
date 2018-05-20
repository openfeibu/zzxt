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


class EvaluationMaterialConfig extends Model
{

    public static function getConfigs($is_student = 0)
    {
        $where = [];
        $where['is_show'] = 1;
        if($is_student){
            $where['is_image'] = 1;
        }
        else{
            $where['is_score'] = 1;
        }
		return Db::table('yf_evaluation_material_config')
				->where($where)
                ->order('sort asc ,cid asc')
				->select();
	}
    public static function getConfig($cid)
    {
		return Db::table('yf_evaluation_material_config')->find($cid);
	}
}
