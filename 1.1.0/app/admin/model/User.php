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

/**
 * 配置模型
 * @package app\admin\model
 */
class User extends Model
{
    public static $fields = [
        'id',
        'studentid',
        'password',
        'studentname',
        'id_number',
        'gender',
        'birthday',
        'political',
        'nation',
        'grade',
        'class',
        'profession',
        'admission_date',
        'department_name',
        'is_rural_student',
        'faculty_number',
        'profession_number',
        'class_number',
        'current_grade',
		'phone'
    ];
    public static function getUserFields($name =''){
        $fields = self::$fields;
        $user_fields = [];
        foreach(self::$fields as $k => $val)
        {
            $val = $name ? $name.'.'.$val : $val;
            array_push($user_fields,$val);
        }
        return array_values($user_fields);
    }
	public static function getUserFromSchool()
	{
		
	}
}
