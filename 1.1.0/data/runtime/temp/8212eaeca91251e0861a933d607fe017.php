<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:75:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\member\ajax_member_list.html";i:1515375308;}*/ ?>
<?php if(is_array($member_list) || $member_list instanceof \think\Collection || $member_list instanceof \think\Paginator): if( count($member_list)==0 ) : echo "" ;else: foreach($member_list as $key=>$v): ?>
	<tr>
		<td class="hidden-xs" height="28" ><?php echo $v['member_list_id']; ?></td>
		<td><?php echo $v['member_list_username']; ?></td>
		<td><?php echo (isset($v['studentname']) && ($v['studentname'] !== '')?$v['studentname']:"未设置"); ?></td>
		<td><?php echo $v['profession']; ?><?php echo $v['class']; ?></td>
		<td><?php echo $v['department_name']; ?></td>
		<td class="hidden-sm hidden-xs"><?php echo date('Y-m-d H:i:s',$v['member_list_addtime']); ?></td>
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
