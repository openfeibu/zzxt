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

/**
 * 后台用户模型
 * @package app\admin\model
 */
class Evaluation extends Model
{

    public function getEvaluation($id)
    {
		return Db::table('yf_evaluation_application')
				->alias('app')
				->join('yf_user u', 'u.studentid = app.user_id', 'left')
				->where('evaluation_id',$id)
				->find();
	}
}