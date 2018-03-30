<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\admin\model\Admin as AdminModel;
use app\admin\model\ClassCode as ClassCodeModel;
use app\common\controller\Common;
use think\Db;
use think\Cache;

class ClassCode extends Common
{
    public function __construct()
    {
        parent::__construct();
        $this->classCode = new ClassCodeModel();
    }
    public function getClasses()
    {
        $faculty_number = input('faculty_number','');
        $faculties = $this->classCode->getFacultyClasses($faculty_number);
        $html = '<option value="">请选择专业</option>';
		foreach($faculties as $key => $faculty)
		{
			$html .= "<option value='".$faculty['class_number']."'>".$faculty['current_grade'].$faculty['class_name']."</option>";
		}
        return [
            'code' => 200,
            'data' => $faculties,
            'html' => $html
        ];
    }
}
