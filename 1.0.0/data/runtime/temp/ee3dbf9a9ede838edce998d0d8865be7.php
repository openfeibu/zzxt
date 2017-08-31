<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:69:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\member\ajax_member_list.html";i:1503813359;}*/ ?>
<?php if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr>
		<td class="hidden-xs" height="28" ><?php echo $v['member_list_id']; ?></td>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo (isset($v['member_list_nickname']) && ($v['member_list_nickname'] !== '')?$v['member_list_nickname']:"未设置"); ?>【<?php echo (isset($v['member_list_email']) && ($v['member_list_email'] !== '')?$v['member_list_email']:"未设置"); ?>】</td>
		<td class="hidden-sm hidden-xs"><?php echo (isset($v['member_list_from']) && ($v['member_list_from'] !== '')?$v['member_list_from']:"本地"); ?></td>
		<td class="hidden-sm hidden-xs">
			<?php if($v['member_list_sex'] == 1): ?>程序猿
				<?php elseif($v['member_list_sex'] == 2): ?>程序媛
				<?php else: ?>保密
			<?php endif; ?>
		</td>
		<td class="hidden-sm hidden-xs"><?php echo $v['member_group_name']; ?></td>
		<td class="hidden-sm hidden-xs"><?php echo $v['score']; ?></td>
		<td class="hidden-sm hidden-xs"><?php echo date('Y-m-d H:i:s',$v['member_list_addtime']); ?></td>
		<td class="hidden-xs">
			<?php if($v['member_list_open'] == 1): ?>
				<a class="red open-btn" href="<?php echo url('admin/Member/member_state'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="已开启">
					<div id="zt<?php echo $v['member_list_id']; ?>"><button class="btn btn-minier btn-yellow">开启</button></div>
				</a>
				<?php else: ?>
				<a class="red open-btn" href="<?php echo url('admin/Member/member_state'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="已禁用">
					<div id="zt<?php echo $v['member_list_id']; ?>"><button class="btn btn-minier btn-danger">禁用</button></div>
				</a>
			<?php endif; ?>
		</td>
		<td class="hidden-xs">
			<?php if($v['user_status'] == 1): ?>
				<a class="red active-btn" href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="已激活">
					<div id="jh<?php echo $v['member_list_id']; ?>">
						<button class="btn btn-minier btn-yellow">已激活</button>
					</div>
				</a>
				<?php else: ?>
				<a class="red active-btn" href="<?php echo url('admin/Member/member_active'); ?>" data-id="<?php echo $v['member_list_id']; ?>" title="未激活">
					<div id="jh<?php echo $v['member_list_id']; ?>">
						<button class="btn btn-minier btn-danger">未激活</button>
					</div>
				</a>
			<?php endif; ?>
		</td>
		<td>
			<div class="hidden-sm hidden-xs action-buttons">
				<a class="green"  href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" title="修改">
					<i class="ace-icon fa fa-pencil bigger-130"></i>
				</a>
				<a class="red confirm-rst-url-btn" href="<?php echo url('admin/Member/member_del',array('member_list_id'=>$v['member_list_id'],'p'=>input('p',1))); ?>" data-info="你确定要删除吗？" title="删除">
					<i class="ace-icon fa fa-trash-o bigger-130"></i>
				</a>
			</div>
			<div class="hidden-md hidden-lg">
				<div class="inline position-relative">
					<button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown" data-position="auto">
						<i class="ace-icon fa fa-cog icon-only bigger-110"></i>
					</button>
					<ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo url('admin/Member/member_edit',array('member_list_id'=>$v['member_list_id'])); ?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="修改">
											<span class="green">
												<i class="ace-icon fa fa-pencil bigger-120"></i>
											</span>
							</a>
						</li>

						<li>
							<a href="<?php echo url('admin/Member/member_del',array('member_list_id'=>$v['member_list_id'],'p'=>input('p',1))); ?>"  class="tooltip-error confirm-rst-url-btn" data-info="你确定要删除吗？" data-rel="tooltip" title="" data-original-title="删除">
											<span class="red">
												<i class="ace-icon fa fa-trash-o bigger-120"></i>
											</span>
							</a>
						</li>
					</ul>
				</div>
			</div>
		</td>
	</tr>
<?php endforeach; endif; else: echo "" ;endif; ?>
<tr>
	<td height="50" colspan="12" align="left"><?php echo $page; ?></td>
</tr>
