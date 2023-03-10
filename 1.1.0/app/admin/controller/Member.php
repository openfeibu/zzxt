<?php
// +----------------------------------------------------------------------
// | YFCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.rainfer.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: rainfer <81818832@qq.com>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use think\Db;
use app\admin\model\MemberList;

class Member extends Base
{
	/*
     * 用户管理
     */
	public function member_list(){
		$key=input('key');
		$opentype_check=input('opentype_check','');
		$activetype_check=input('activetype_check','');
		$where=array();
		if($opentype_check !== ''){
			$where['member_list_open']=$opentype_check;
		}
		if($activetype_check !== ''){
			$where['user_status']=$activetype_check;
		}
		switch($this->admin['group_id'])
		{
			case '22':	
			$where['u.faculty_number'] = $this->admin['faculty_number'];
			break;
			case '20':	
			$where['u.class_number'] = ['in','('.$this->admin['class_number'].')'];
			break;
		}
		$member_model=new MemberList;
		$member_list=$member_model->alias('a')->join(config('database.prefix').'member_group b','a.member_list_groupid=b.member_group_id')
				->join('yf_user u','u.id_number = a.id_number')
				->where($where)->where('member_list_username|member_list_email|member_list_nickname|u.id_number','like',"%".$key."%")
				->order('class_number','asc')
				->order('member_list_addtime','desc')
				->field('u.*,a.member_list_id,a.member_list_username,a.member_list_province,a.member_list_city,a.member_list_town,a.member_list_nickname,a.member_list_headpic,a.member_list_addtime,a.member_list_open,a.user_status')
				->paginate(config('paginate.list_rows'),false,['query'=>get_query()]);
		$show=$member_list->render();
		$show=preg_replace("(<a[^>]*page[=|/](\d+).+?>(.+?)<\/a>)","<a href='javascript:ajax_page($1);'>$2</a>",$show);
		$this->assign('opentype_check',$opentype_check);
		$this->assign('activetype_check',$activetype_check);
		$this->assign('member_list',$member_list);
		$this->assign('page',$show);
		$this->assign('val',$key);
		if(request()->isAjax()){
			return $this->fetch('ajax_member_list');
		}else{
			return $this->fetch();
		}
	}
	/*
     * 添加用户显示
     */
	public function member_add(){
		$province = Db::name('Region')->where ( array('pid'=>1) )->select ();
		$this->assign('province',$province);
		$member_group=Db::name('member_group')->order('member_group_order')->select();
		$this->assign('member_group',$member_group);
		return $this->fetch();
	}

	/*
     * 添加用户操作
     */
	public function member_runadd(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_list'));
		}else{
			$member_list_salt=random(10);
			$sl_data=array(
				'member_list_groupid'=>input('member_list_groupid'),
				'member_list_username'=>input('member_list_username'),
				'member_list_salt' => $member_list_salt,
				'member_list_pwd'=>encrypt_password(input('member_list_pwd'),$member_list_salt),
				'member_list_nickname'=>input('member_list_nickname'),
				'member_list_province'=>input('member_list_province'),
				'member_list_city'=>input('member_list_city'),
				'member_list_town'=>input('member_list_town'),
				'member_list_sex'=>input('member_list_sex'),
				'member_list_tel'=>input('member_list_tel'),
				'member_list_email'=>input('member_list_email'),
				'member_list_open'=>input('member_list_open',0),
				'user_url'=>input('user_url'),
				'member_list_addtime'=>time(),
				'user_status'=>input('user_status',0),
				'signature'=>input('signature'),
				'score'=>input('score',0,'intval'),
				'coin'=>input('coin',0,'intval'),
			);
			$rst=MemberList::create($sl_data);
			if($rst!==false){
				$this->success('学生添加成功',url('admin/Member/member_list'));
			}else{
				$this->error('学生添加失败',url('admin/Member/member_list'));
			}
		}
	}

	/*
     * 修改用户信息界面
     */
	public function member_edit(){
		$province = Db::name('Region')->where ( array('pid'=>1) )->select ();
		$member_group=Db::name('member_group')->order('member_group_order')->select();
		$member_list_edit=Db::name('member_list')->where(array('member_list_id'=>input('member_list_id')))->find();
		$city=Db::name('Region')->where ( array('pid'=>$member_list_edit['member_list_province']) )->select ();
		$town=Db::name('Region')->where ( array('pid'=>$member_list_edit['member_list_city']) )->select ();
		$this->assign('member_list_edit',$member_list_edit);
		$this->assign('province',$province);
		$this->assign('city',$city);
		$this->assign('town',$town);
		$this->assign('member_group',$member_group);
		return $this->fetch();
	}
	/*
	 * 修改用户操作
	 */
	public function member_runedit(){
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_list'));
		}else{
			$sl_data['member_list_id']=input('member_list_id');
			$pwd=input('member_list_pwd');
			if (!empty($pwd)){
				$member_list_salt=random(10);
				$sl_data['member_list_salt']=$member_list_salt;
				$sl_data['member_list_pwd']=encrypt_password($pwd,$member_list_salt);
			}
			$sl_data['member_list_nickname']=input('member_list_nickname');
			$rst=MemberList::update($sl_data);
			if($rst!==false){
				$this->success('学生修改成功',url('admin/Member/member_list'));
			}else{
				$this->error('学生修改失败',url('admin/Member/member_list'));
			}
		}
	}
	/*
     * 学生禁止/取消禁止
     */
	public function member_state(){
		$id=input('x');
		$member_model=new MemberList;
		$status=$member_model->where(array('member_list_id'=>$id))->value('member_list_open');//判断当前状态情况
		if($status==1){
			$statedata = array('member_list_open'=>0);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('member_list_open'=>1);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('状态开启');
		}
	}
	/*
     * 学生激活/取消激活
     */
	public function member_active()
	{
		$id=input('x');
		$member_model=new MemberList;
		$status=$member_model->where(array('member_list_id'=>$id))->value('user_status');//判断当前状态情况
		if($status==1){
			$statedata = array('user_status'=>0);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('未激活');
		}else{
			$statedata = array('user_status'=>1);
			$member_model->where(array('member_list_id'=>$id))->setField($statedata);
			$this->success('已激活');
		}
	}

	/*
     * 学生删除
     */
	public function member_del()
	{
		$p=input('p');
		$member_list_id=input('member_list_id');
		$member_model=new MemberList;
		$rst=Db::name('admin')->where('member_id',$member_list_id)->find();
		if($rst){
			$this->error('此学生已关联管理员,请从管理员处删除',url('admin/Member/member_list', array('p' => $p)));
		}else{
			$member = $member_model->where(array('member_list_id'=>$member_list_id))->find();
			
			$rst=$member_model->where(array('member_list_id'=>$member_list_id))->delete();
			DB::name('user')->where(array('id_number'=>$member['id_number']))->delete();
			DB::name('evaluation_application')->where(array('member_list_id'=>$member_list_id))->delete();
			DB::name('evaluation_status')->where(array('member_list_id'=>$member_list_id))->delete();
			DB::name('evaluation_material')->where(array('member_list_id'=>$member_list_id))->delete();
			if($rst!==false){
				$this->success('学生删除成功',url('admin/Member/member_list', array('p' => $p)));
			}else{
				$this->error('学生删除失败',url('admin/Member/member_list', array('p' => $p)));
			}
		}
	}
	/*
     *学生组显示列表
     */
	public function member_group_list()
	{
		$member_group=Db::name('member_group');
		$member_group_list=$member_group->order('member_group_order')->select();
		$this->assign('member_group_list',$member_group_list);
		return $this->fetch();
	}

	/*
     * 学生组添加方法
     */
	public function member_group_runadd()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$rst=Db::name('member_group')->insert(input('post.'));
			if($rst!==false){
				$this->success('学生组添加成功',url('admin/Member/member_group_list'));
			}else{
				$this->error('学生组添加失败',url('admin/Member/member_group_list'));
			}
		}
	}

	/*
     * 学生组删除
     */
	public function member_group_del()
	{
		$member_group_id=input('member_group_id');
		if (empty($member_group_id)){
			$this->error('学生组ID不存在',url('admin/Member/member_group_list'));
		}
        $rst=Db::name('member_group')->where(array('member_group_id'=>input('member_group_id')))->delete();
        if($rst!==false){
            $this->success('学生组删除成功',url('admin/Member/member_group_list'));
        }else{
            $this->error('学生组删除失败',url('admin/Member/member_group_list'));
        }
	}

	/*
     * 改变学生组状态
     */
	public function member_group_state()
	{
		$member_group_id=input('x');
		if (!$member_group_id){
			$this->error('ID:'.$member_group_id.'不存在',url('admin/Member/member_group_list'));
		}
		$status=Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->value('member_group_open');//判断当前状态情况
		if($status==1){
			$statedata = array('member_group_open'=>0);
			Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->setField($statedata);
			$this->success('状态禁止');
		}else{
			$statedata = array('member_group_open'=>1);
			Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->setField($statedata);
			$this->success('状态开启');
		}
	}

	/*
     * 排序更新
     */
	public function member_group_order()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$post=input('post.');
			foreach ($post as $id => $sort){
				Db::name('member_group')->where(array('member_group_id' => $id ))->setField('member_group_order' , $sort);
			}
			$this->success('排序更新成功',url('admin/Member/member_group_list'));
		}
	}

	/*
     * 修改学生组返回值
     */
	public function member_group_edit()
	{
		$member_group_id=input('member_group_id');
		$member_group=Db::name('member_group')->where(array('member_group_id'=>$member_group_id))->find();
		$sl_data['member_group_id']=$member_group['member_group_id'];
		$sl_data['member_group_name']=$member_group['member_group_name'];
		$sl_data['member_group_open']=$member_group['member_group_open'];
		$sl_data['member_group_toplimit']=$member_group['member_group_toplimit'];
		$sl_data['member_group_bomlimit']=$member_group['member_group_bomlimit'];
		$sl_data['member_group_order']=$member_group['member_group_order'];
		$sl_data['code']=1;
		return json($sl_data);
	}

	/*
     * 修改用户组方法
     */
	public function member_group_runedit()
	{
		if (!request()->isAjax()){
			$this->error('提交方式不正确',url('admin/Member/member_group_list'));
		}else{
			$sl_data=array(
				'member_group_id'=>input('member_group_id'),
				'member_group_name'=>input('member_group_name'),
				'member_group_toplimit'=>input('member_group_toplimit'),
				'member_group_bomlimit'=>input('member_group_bomlimit'),
				'member_group_order'=>input('member_group_order'),

			);
			$rst=Db::name('member_group')->update($sl_data);
			if($rst!==false){
				$this->success('学生组修改成功',url('admin/Member/member_group_list'));
			}else{
				$this->error('学生组修改失败',url('admin/Member/member_group_list'));
			}
		}
	}
}
