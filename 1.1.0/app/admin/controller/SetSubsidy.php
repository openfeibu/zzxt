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

    /**
     * 设置开启时间
     */
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
	public function editAll()
	{
		$ids = input('id/a');
		$data = $_POST;
		
		foreach($ids as $key => $id)
		{	
			$udata = array(
				'begin_time' => $data['begin_time'][$key] ? strtotime($data['begin_time'][$key]) : '',
				'end_time' => $data['end_time'][$key] ? strtotime($data['end_time'][$key]) : '',
				'ypublic_begin_time' => $data['ypublic_begin_time'][$key] ? strtotime($data['ypublic_begin_time'][$key]) : '',
				'ypublic_end_time' => $data['ypublic_end_time'][$key] ? strtotime($data['ypublic_end_time'][$key]) : '',
				// 'xpublic_begin_time' => $data['xpublic_begin_time'][$key] ? strtotime($data['xpublic_begin_time'][$key]) : '',
				// 'xpublic_end_time' => $data['xpublic_end_time'][$key] ? strtotime($data['xpublic_end_time'][$key]) : '',
			);
			$bool = Db::name('set_subsidy')
                ->where('id',$id)
                ->update($udata);
		}
		
		$this->success('修改成功');
	}
    public function set_subsidy_list()
    {
        $list = Db::table('yf_set_subsidy')->select();
        return $this->view->fetch();
    }

    /**
     * 设置公示时间
     * @return string
     */
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