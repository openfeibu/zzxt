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
use app\admin\model\AuthRule;
use app\admin\model\ClassCode as ClassCodeModel;
use think\Db;
use think\Cache;

class Admin extends Base
{
	/**
	 * 管理员列表
	 */
	public function admin_list()
	{
		$search_name=input('search_name');
		$this->assign('search_name',$search_name);
		$where='';
		if($search_name){
			//$map['admin_username']= array('like',"%".$search_name."%");
			$where = " (admin_username like '%".$search_name."%' OR admin_realname like '%".$search_name."%' )";
		}
        $classCode = new ClassCodeModel();
		$faculty = $classCode->getFaculties();
		//$admin_list=Db::name('admin')->where($map)->where('',)->order('admin_id')->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$admin_list=Db::name('admin')->alias('a')
									->join('yf_auth_group_access ags','a.admin_id = ags.uid')
									->join('yf_auth_group ag','ags.group_id = ag.id')
									->where('ag.id in (20,21,22,23,24,25,26)')
									->where($where)
									->order("charindex(','+convert(varchar,group_id)+',',',23,22,20,21,25,26,24,')")
									->order('admin_id asc')
									->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
									
		$page = $admin_list->render();
		$this->assign('admin_list',$admin_list);
        $this->assign('faculty_number', $faculty);
        $this->assign('page',$page);
		return $this->fetch();
	}
	/**
	 * 管理员添加
	 */
	public function admin_add()
	{
		$auth_group=Db::name('auth_group')->select();
		$classCode = new ClassCodeModel();
		$faculty = $classCode->getFaculties();
		$this->assign('auth_group',$auth_group);
		$this->assign('faculty_number', $faculty);
		return $this->fetch();
	}

	/**
	 * 管理员添加操作
	 */
	public function admin_runadd()
	{
//        halt(input('group_id',''));exit();
        $aid = session('admin_auth.aid');
        $user = Db::table('yf_auth_group_access')
            ->where('uid',$aid)
            ->find();
        $group_id = $user['group_id'];
        if ($group_id == 20) {
            if (input('group_id','') == 21 or input('group_id','') == 25) {
                $admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',0),input('admin_realname',''),input('group_id'),input('faculty_number',''));
                if($admin_id){
                    $this->success('班级小组添加成功',url('admin/Admin/admin_list'));
                }else{
                    $this->error('班级小组添加失败',url('admin/Admin/admin_list'));
                }
            } else {
                $this->error('您没有权限');
            }
        } else {
            $admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',0),input('admin_realname',''),input('group_id'),input('faculty_number',''));
            if($admin_id){
                $this->success('管理员添加成功',url('admin/Admin/admin_list'));
            }else{
                $this->error('管理员添加失败',url('admin/Admin/admin_list'));
            }
        }
	}
	/**
	 * 管理员修改
	 */
	public function admin_edit()
	{
		$auth_group=Db::name('auth_group')->select();
		$admin_list=Db::name('admin')->find(input('admin_id'));
        $classCode = new ClassCodeModel();
		$faculty = $classCode->getFaculties();
		$auth_group_access=Db::name('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->value('group_id');
		$this->assign('admin_list',$admin_list);
        $this->assign('faculty_number', $faculty);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		return $this->fetch();
	}
	/**
	 * 管理员修改操作
	 */
	public function admin_runedit()
	{
		$data=input('post.');
		$rst=AdminModel::edit($data);
		if($rst!==false){
			$this->success('管理员修改成功',url('admin/Admin/admin_list'));
		}else{
			$this->error('管理员修改失败',url('admin/Admin/admin_list'));
		}
	}
	/**
	 * 管理员删除
	 */
	public function admin_del()
	{

		$admin_id=input('admin_id');
		if (empty($admin_id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		//对应会员ID
		$member_id=Db::name('admin')->where('admin_id',$admin_id)->value('member_id');
		Db::name('admin')->delete($admin_id);
		//删除对应会员
		if($member_id){
			Db::name('member_list')->delete($member_id);
		}
		$rst=Db::name('auth_group_access')->where('uid',$admin_id)->delete();
		if($rst!==false){
			$this->success('管理员删除成功',$_SERVER['HTTP_REFERER']);
		}else{
			$this->error('管理员删除失败',$_SERVER['HTTP_REFERER']);
		}
	}
	public function admin_counselor_del()
	{
		$admin_id=input('admin_id');
		if (empty($admin_id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		//对应会员ID
		$member_id=Db::name('admin')->where('admin_id',$admin_id)->value('member_id');
		Db::name('admin')->delete($admin_id);
		//删除对应会员
		if($member_id){
			Db::name('member_list')->delete($member_id);
		}
		$rst=Db::name('auth_group_access')->where('uid',$admin_id)->delete();
		if($rst!==false){
			$this->success('管理员删除成功',$_SERVER['HTTP_REFERER']);
		}else{
			$this->error('管理员删除失败',$_SERVER['HTTP_REFERER']);
		}
	}

	public function counselor_admin_list()
	{
		$search_name=input('search_name');
		$this->assign('search_name',$search_name);
		$map=array();
		$where = '';
		if($search_name){
			//$map['a.admin_username']= array('like',"%".$search_name."%");
			$where = " (a.admin_username like '%".$search_name."%' OR a.admin_realname like '%".$search_name."%' )";
		}
		if(session('admin_auth.faculty_number')){
			$map['a.faculty_number']= session('admin_auth.faculty_number');
		}
		if(session('admin_auth.class_number'))
		{
			$map['a.class_number'] =['in',session('admin_auth.class_number')] ;
		}

        $classCode = new ClassCodeModel();
		$faculty = $classCode->getFaculties();
		$admin_list=Db::name('admin')->alias('a')
									->join('yf_auth_group_access ags','a.admin_id = ags.uid')
									->join('yf_auth_group ag','ags.group_id = ag.id')
									->where('ag.id in (21,25)')
									->where($map)
									->where($where)
									->order('admin_id')
									->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$admin_list_arr = $admin_list->all();
		foreach($admin_list_arr as $key => $admin)
		{
			$class = $classCode->getClass($admin['class_number']);
			$admin_list_arr[$key]['class_name'] = $class ? $class['class_name'] : '';
		}			
		$page = $admin_list->render();
		$this->assign('admin_list',$admin_list_arr);
        $this->assign('faculty_number', $faculty);
        $this->assign('page',$page);
		return $this->fetch();
	}
	public function counselor_admin_edit()
	{
		$auth_group=Db::name('auth_group')->where('id in (21,25)')->select();
		$admin_list=Db::name('admin')->find(input('admin_id'));
        $classCode = new ClassCodeModel();
		$auth_group_access=Db::name('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->value('group_id');
		$this->assign('admin_list',$admin_list);
		// $admin_professiones = session('admin_professiones');
		// $classes = $classCode->getCounselorClasses($admin_professiones);
		// $class_number = array_column($classes, 'class_number');
		$class_number = session('admin_auth.class_number');
		$classes = $classCode->getCounselorClasses($class_number);
		$this->assign('classes', $classes);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		return $this->fetch();
	}
	public function counselor_admin_runedit()
	{
		$data=input('post.');
		$data['faculty_number'] = session('admin_auth.faculty_number');

		$rst=AdminModel::edit($data);
		if($rst!==false){
			$this->success('管理员修改成功',url('admin/Admin/counselor_admin_list'));
		}else{
			$this->error('管理员修改失败',url('admin/Admin/counselor_admin_list'));
		}
	}
	public function counselor_admin_add()
	{
		$auth_group=Db::name('auth_group')->where('id in (21,25)')->select();
		$classCode = new ClassCodeModel();
		$this->assign('auth_group',$auth_group);
		// $admin_professiones = session('admin_professiones');
		// $classes = $classCode->getCounselorClasses($admin_professiones);
		// $class_number = array_column($classes, 'class_number');
		$class_number = session('admin_auth.class_number');
		$classes = $classCode->getCounselorClasses($class_number);
		$this->assign('classes', $classes);
		
		return $this->fetch();
	}
	public function counselor_admin_runadd()
	{
        $aid = session('admin_auth.aid');
        $user = Db::table('yf_auth_group_access')
            ->where('uid',$aid)
            ->find();
        $group_id = $user['group_id'];
        if ($group_id == 20) {
            if (input('group_id','') == 21 or input('group_id','') == 25) {
				$password = substr(input('admin_username'),-6);
                $admin_id=AdminModel::add(input('admin_username'),'',$password,input('admin_email',''),input('admin_tel',''),input('admin_open',0),input('admin_realname',''),input('group_id'),input('faculty_number',session('admin_auth.faculty_number')),input('class_number',''));
                if($admin_id){
                    $this->success('班级小组添加成功',url('admin/Admin/counselor_admin_list'));
                }else{
                    $this->error('班级小组添加失败',url('admin/Admin/counselor_admin_list'));
                }
            } else {
                $this->error('您没有权限');
            }
        } else {
            $admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',0),input('admin_realname',''),input('group_id'),input('faculty_number',session('admin_auth.faculty_number')),input('class_number',0));
            if($admin_id){
                $this->success('管理员添加成功',url('admin/Admin/counselor_admin_list'));
            }else{
                $this->error('管理员添加失败',url('admin/Admin/counselor_admin_list'));
            }
        }
	}
	/*院系小组查看成员（辅导员）*/
	public function faculty_admin_list()
	{
		$search_name=input('search_name');
		$this->assign('search_name',$search_name);
		$map=array();
		$where = '';
		if($search_name){
			//$map['a.admin_username']= array('like',"%".$search_name."%");
			$where = " (a.admin_username like '%".$search_name."%' OR a.admin_realname like '%".$search_name."%' )";
		}
        $classCode = new ClassCodeModel();
		$faculty = $classCode->getFaculties();
		$admin_list=Db::name('admin')->alias('a')
									->join('yf_auth_group_access ags','a.admin_id = ags.uid')
									->join('yf_auth_group ag','ags.group_id = ag.id')
									->where('ag.id in (20)')
									->where('a.faculty_number',session('admin_auth.faculty_number'))
									->where($where)
									->order('admin_id')
									->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$admin_list_arr = $admin_list->all();
		foreach($admin_list_arr as $key => $admin)
		{
			$class = $classCode->getCounselorClasses($admin['class_number']);
			$class_name = getValuesByArr($class,'class_name');
			$admin_list_arr[$key]['class_name'] = $class_name;
		}							
		$page = $admin_list->render();
		$this->assign('admin_list',$admin_list_arr);
        $this->assign('faculty_number', $faculty);
        $this->assign('page',$page);
		return $this->fetch();
	}
	public function faculty_admin_add()
	{
		$auth_group=Db::name('auth_group')->where('id in (20)')->select();
		$classCode = new ClassCodeModel();
		$faculties = $classCode->getFaculties();
		$this->assign('faculty_number',session('admin_auth.faculty_number'));
		$classes = $classCode->getFacultyClasses(session('admin_auth.faculty_number'));
		// $professiones = $classCode->getProfessiones(session('admin_auth.faculty_number'));
		// $this->assign('professiones', $professiones);
		$this->assign('auth_group',$auth_group);
		$this->assign('classes', $classes);
		$this->assign('faculties', $faculties);
		return $this->fetch();
	}
	public function faculty_admin_edit()
	{
		$auth_group=Db::name('auth_group')->where('id in (20)')->select();
		$admin_list=Db::name('admin')->find(input('admin_id'));
        $classCode = new ClassCodeModel();
		$faculties = $classCode->getFaculties();
		$classes = $classCode->getFacultyClasses(session('admin_auth.faculty_number'));
		$auth_group_access=Db::name('auth_group_access')->where(array('uid'=>$admin_list['admin_id']))->value('group_id');

		// $professiones = $classCode->getProfessiones(session('admin_auth.faculty_number'));

		// $admin_professiones = AdminModel::getAdminProfessiones($admin_list['admin_id']);
		// $profession_numbers = $classCode->handleAdminProfessiones($admin_professiones);

		// $this->assign('professiones', $professiones);
		// $this->assign('profession_numbers', $profession_numbers);
		$class_number = $admin_list['class_number'];
		$class_numbers = $class_number ? explode(',',$class_number) : [];
		$this->assign('class_numbers',$class_numbers);
		$this->assign('faculty_number',session('admin_auth.faculty_number'));
		$this->assign('classes', $classes);
		$this->assign('admin_list',$admin_list);
        $this->assign('faculties', $faculties);
		$this->assign('auth_group',$auth_group);
		$this->assign('auth_group_access',$auth_group_access);
		return $this->fetch();
	}
	/**
	 * 管理员修改操作
	 */
	public function faculty_admin_runedit()
	{
		$data=input('post.');
		$aid = $data['admin_id'];
		// $year_profession_numbers = $data['profession_number'] ;
		// foreach($year_profession_numbers as $key  => $val)
		// {
			// $year_profession_number = explode('_',$val);
			// $pdata['admin_id'] = $aid;
			// $pdata['current_grade'] = $year_profession_number[0];
			// $pdata['profession_number'] = $year_profession_number[1];
			// $pdatas[] = $pdata;
		// }
		
		$class_number = input('class_number/a');
		$class_number = $class_number ? implode(',',$class_number) : '';
		$data['class_number'] = $class_number;
		$data['admin_id'] = $aid;
		$data['faculty_number'] = session('admin_auth.faculty_number');
		$rst=AdminModel::edit($data);
		if($rst!==false){
			// Db::name('admin_profession')->where('admin_id',$aid)->delete();
			// Db::name('admin_profession')->insertAll($pdatas);
			$this->success('管理员修改成功',url('admin/Admin/faculty_admin_list'));
		}else{
			$this->error('管理员修改失败',url('admin/Admin/faculty_admin_list'));
		}
	}
	public function faculty_admin_runadd()
	{
        $aid = session('admin_auth.aid');
		$class_number = input('class_number/a');
		$class_number = $class_number ? implode(',',$class_number) : '';

		$admin_id=AdminModel::add(input('admin_username'),'',input('admin_pwd'),input('admin_email',''),input('admin_tel',''),input('admin_open',0),input('admin_realname',''),input('group_id'),input('faculty_number',session('admin_auth.faculty_number')),$class_number );
		if($admin_id){
			// $year_profession_numbers = $_POST['profession_number'] ;
			// foreach($year_profession_numbers as $key  => $val)
			// {
				// $year_profession_number = explode('_',$val);
				// $pdata['admin_id'] = $admin_id;
				// $pdata['current_grade'] = $year_profession_number[0];
				// $pdata['profession_number'] = $year_profession_number[1];
				// $pdatas[] = $pdata;
			// }
			// Db::name('admin_profession')->where('admin_id',$admin_id)->delete();
			// Db::name('admin_profession')->insertAll($pdatas);
			$this->success('管理员添加成功',url('admin/Admin/faculty_admin_list'));
		}else{
			$this->error('管理员添加失败',url('admin/Admin/faculty_admin_list'));
		}

	}
	/**
	 * 管理员开启/禁止
	 */
	public function admin_state()
	{
		$id=input('x');
		if (empty($id)){
			$this->error('用户ID不存在',url('admin/Admin/admin_list'));
		}
		$status=Db::name('admin')->where('admin_id',$id)->value('admin_open');//判断当前状态情况
		if($status==1){
			$statedata = array('admin_open'=>0);
			Db::name('admin')->where('admin_id',$id)->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('admin_open'=>1);
			Db::name('admin')->where('admin_id',$id)->setField($statedata);
			$this->success('状态开启');
		}
	}
	/**
	 * 用户组列表
	 */
	public function admin_group_list()
	{
		$auth_group=Db::name('auth_group')->select();
		$this->assign('auth_group',$auth_group);
		return $this->fetch();
	}
	/**
	 * 用户组添加
	 */
	public function admin_group_add()
	{
		return $this->fetch();
	}
	/**
	 * 用户组添加操作
	 */
	public function admin_group_runadd()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Admin/admin_group_list'));
		}else{
			$sldata=array(
				'title'=>input('title'),
				'status'=>input('status',0),
				'addtime'=>time(),
			);
			$rst=Db::name('auth_group')->insert($sldata);
			if($rst!==false){
				$this->success('用户组添加成功',url('admin/Admin/admin_group_list'));
			}else{
				$this->error('用户组添加失败',url('admin/Admin/admin_group_list'));
			}
		}
	}
	/**
	 * 用户组删除操作
	 */
	public function admin_group_del()
	{
		$rst=Db::name('auth_group')->delete(input('id'));
		if($rst!==false){
			$this->success('用户组删除成功',url('admin/Admin/admin_group_list'));
		}else{
			$this->error('用户组删除失败',url('admin/Admin/admin_group_list'));
		}
	}
	/**
	 * 用户组编辑
	 */
	public function admin_group_edit()
	{
		$group=Db::name('auth_group')->find(input('id'));
		$this->assign('group',$group);
		return $this->fetch();
	}
	/**
	 * 用户组编辑操作
	 */
	public function admin_group_runedit()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Admin/admin_group_list'));
		}else{
			$sldata=array(
				'id'=>input('id'),
				'title'=>input('title'),
				'status'=>input('status'),
			);
			Db::name('auth_group')->update($sldata);
			$this->success('用户组修改成功',url('admin/Admin/admin_group_list'));
		}
	}
	/**
	 * 用户组开启/禁用
	 */
	public function admin_group_state()
	{
		$id=input('x');
		$status=Db::name('auth_group')->where('id',$id)->value('status');//判断当前状态情况
		if($status==1){
			$statedata = array('status'=>0);
			Db::name('auth_group')->where('id',$id)->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('status'=>1);
			Db::name('auth_group')->where('id',$id)->setField($statedata);
			$this->success('状态开启');
		}
	}
	/**
	 * 权限配置
	 */
	public function admin_group_access()
	{
		$admin_group=Db::name('auth_group')->where(array('id'=>input('id')))->find();
		$data=AuthRule::get_ruels_tree();
		$this->assign('admin_group',$admin_group);
		$this->assign('datab',$data);
		return $this->fetch();
	}
	/**
	 * 权限配置保存
	 */
	public function admin_group_runaccess()
	{
		$new_rules = input('new_rules/a');
		$imp_rules = implode(',', $new_rules);
		$sldata=array(
			'id'=>input('id'),
			'rules'=>$imp_rules,
		);
		if(Db::name('auth_group')->update($sldata)!==false){
			Cache::clear();
			$this->success('权限配置成功',url('admin/Admin/admin_group_list'));
		}else{
			$this->error('权限配置失败',url('admin/Admin/admin_group_list'));
		}
	}
	/*
	 * 管理员信息
	 */
	public function profile()
	{
		$admin=array();
		if(session('admin_auth.aid')){
			$admin=Db::name('admin')->alias("a")->join(config('database.prefix').'auth_group_access b','a.admin_id =b.uid')
					->join(config('database.prefix').'auth_group c','b.group_id = c.id')
					->where(array('a.admin_id'=>session('admin_auth.aid')))->find();
			$news_count=Db::name('News')->where(array('news_auto'=>session('admin_auth.member_id')))->count();
			$admin['news_count']=$news_count;
		}
		$this->assign('admin', $admin);
		return $this->fetch();
	}
	/*
	 * 管理员头像
	 */
	public function avatar()
	{
		$imgurl=input('imgurl');
		//去'/'
		$imgurl=str_replace('/','',$imgurl);
		$url='/data/upload/avatar/'.$imgurl;
		$state=false;
		if(config('storage.storage_open')){
			//七牛
			$upload = \Qiniu::instance();
			$info = $upload->uploadOne('.'.$url,"image/");
			if ($info) {
				$state=true;
				$imgurl= config('storage.domain').$info['key'];
				@unlink('.'.$url);
			}
		}
		if($state !=true){
			//本地
			//写入数据库
			$data['uptime']=time();
			$data['filesize']=filesize('.'.$url);
			$data['path']=$url;
			Db::name('plug_files')->insert($data);
		}
		$admin=Db::name('admin')->where(array('admin_id'=>session('admin_auth.aid')))->find();
		$admin['admin_avatar']=$imgurl;
		$rst=Db::name('admin')->where(array('admin_id'=>session('admin_auth.aid')))->update($admin);
		if($rst!==false){
			session('admin_avatar',$imgurl);
			$this->success ('头像更新成功',url('admin/Admin/profile'));
		}else{
			$this->error ('头像更新失败',url('admin/Admin/profile'));
		}
	}
	public function test()
	{
		$faculty_number = '5';
		$year = date('Y');
		$month = date('m');
		if($month < 9){
			$years = [$year-3,$year-2,$year-1];
		}else{
			$years = [$year-2,$year-1,$year];
		}
		$years = implode(',',$years);
		$dataHandleClass = new \app\admin\model\DataHandle();
		$where = " WHERE 系所代码 = '".$faculty_number."' AND 当前所在级 in(".$years.")";
		$professiones = $dataHandleClass->getProfessiones($where);
		var_dump($professiones);exit;
		return $class;
	}
}
