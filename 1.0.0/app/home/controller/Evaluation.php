<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\home\controller;

use think\Cache;
use think\Db;
use think\captcha\Captcha;

class Evaluation extends Base
{
	public function materialUpload()
    {
		return $this->view->fetch('home_page/index_front');
	}

}