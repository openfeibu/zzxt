<?php

namespace app\home\model;

use think\Model;

class Application extends Model
{
    public function index($user_id)
    {
        $bool = $this->table('yf_application')
            ->where('user_id',$user_id)
            ->find();
        if(!$bool) {
            return false;
        }
    }

}
