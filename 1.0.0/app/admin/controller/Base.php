<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\Common;
use app\admin\model\AuthRule;
use think\Db;

class Base extends Common
{
	public function _initialize()
	{
        parent::_initialize();
 		if(!$this->check_admin_login()) $this->redirect('admin/Login/login');//未登录
 		$auth=new AuthRule;
		$id_curr=$auth->get_url_id();
        if(!$auth->check_auth($id_curr) && $id_curr !=0) $this->error('没有权限',url('admin/Index/index'));
		//获取有权限的菜单tree
		$menus=$auth->get_admin_menus();
		$this->assign('menus',$menus);
		//当前方法倒推到顶级菜单ids数组
		$menus_curr=$auth->get_admin_parents($id_curr);
		$this->assign('menus_curr',$menus_curr);
		//取当前操作菜单父节点下菜单 当前菜单id(仅显示状态)
        $menus_child=$auth->get_admin_parent_menus($id_curr);
		$this->assign('menus_child',$menus_child);
		$this->assign('id_curr',$id_curr);
		if(session('admin_auth.aid')){
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))->find();
			$news_count=Db::name('News')->where(array('news_auto'=>session('admin_auth.member_id')))->count();
			$admin['news_count']=$news_count;
		}
		$this->admin = $admin;
		$this->assign('admin', $admin);
		$this->assign('admin_avatar',session('admin_auth.admin_avatar'));
		$this->admin=Db::name('admin')->find(session('admin_auth.aid'));
	}
	public function export_excel($data,$table,$field_titles,$fields)
	{
		error_reporting(E_ALL);
        date_default_timezone_set('Asia/chongqing');
        $objPHPExcel = new \PHPExcel();
        //import("Org.Util.PHPExcel.Reader.Excel5");
        /*设置excel的属性*/
        $objPHPExcel->getProperties()->setCreator("wuzhijie")//创建人
        ->setLastModifiedBy("wuzhijie")//最后修改人
        ->setKeywords("excel")//关键字
        ->setCategory("result file");//种类

        //第一行数据
        $objPHPExcel->setActiveSheetIndex(0);
        $active = $objPHPExcel->getActiveSheet();
        foreach($field_titles as $i=>$name){
            $ck = num2alpha($i++) . '1';
            $active->setCellValue($ck, $name);
        }
        //填充数据
        foreach($data as $k => $v){
            $k=$k+1;
            $num=$k+1;//数据从第二行开始录入
            $objPHPExcel->setActiveSheetIndex(0);
            foreach($fields as $i=>$name){
                $ck = num2alpha($i++) . $num;
                $active->setCellValue($ck, $v[$name]);
            }
        }
        $objPHPExcel->getActiveSheet()->setTitle($table);
        $objPHPExcel->setActiveSheetIndex(0);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$table.'.xls"');
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
	}
}
