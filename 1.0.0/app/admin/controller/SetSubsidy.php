<?php
/**
 * Created by PhpStorm.
 * User: cai76
 * Date: 2017/7/31
 * Time: 17:04
 */

namespace app\admin\controller;

use think\Db;
class SetSubsidy extends Base
{
    public function index()
    {
        if (request()->isAjax()) {
            $data = request()->post();
            $data['begin_time'] = strtotime($data['begin_time']);
            $data['end_time'] = strtotime($data['end_time']);
            $bool = Db::table('yf_set_subsidy')
                ->where('id',$data['id'])
                ->update([
                'begin_time' => $data['begin_time'],
                'end_time' => $data['end_time']
                ]);
            if ($bool) {
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }
        }
        $list = Db::table('yf_set_subsidy')->select();
        $this->assign('list', $list);
        return $this->view->fetch();
    }

    public function set_subsidy_list()
    {
        $list = Db::table('yf_set_subsidy')->select();
        return $this->view->fetch();
    }

    public function setPublicityTime() {
        if (request()->isAjax()) {
            $data = request()->post();
            $data['begin_time'] = strtotime($data['begin_time']);
            $data['end_time'] = strtotime($data['end_time']);
            $bool = Db::table('yf_set_subsidy')
                ->where('id',$data['id'])
                ->update([
                'begin_time' => $data['begin_time'],
                'end_time' => $data['end_time']
                ]);
            if ($bool) {
                return json_encode([
                    'code' => 200,
                    'msg' => '更新成功'
                ]);
            }
            return json_encode([
                'code' => 400,
                'msg' => '修改失败'
            ]);
        }
        $list = Db::table('yf_set_subsidy')->select();
        $this->assign('list', $list);
        return $this->view->fetch();
    }

}