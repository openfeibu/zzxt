<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:62:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\model\model_list.html";i:1503813359;s:57:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\base.html";i:1503813357;s:59:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\header.html";i:1503813357;s:61:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\left_nav.html";i:1503813357;s:61:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\head_nav.html";i:1503813357;s:59:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\footer.html";i:1503813357;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>YFCMF后台管理</title>

	<meta name="description" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
	<link rel="Bookmark" href="__ROOT__/favicon.ico" >
    <link rel="Shortcut Icon" href="__ROOT__/favicon.ico" />
	<!-- bootstrap & fontawesome必须的css -->
	<link rel="stylesheet" href="__PUBLIC__/ace/css/bootstrap.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/font-awesome/css/font-awesome.min.css" />
	<link rel="stylesheet" href="__PUBLIC__/datePicker/bootstrap-datepicker.css" />
	<link rel="stylesheet" href="__PUBLIC__/datetimepicker/bootstrap-datetimepicker.css" />
	<!-- 此页插件css -->

	<!-- ace的css -->
	<link rel="stylesheet" href="__PUBLIC__/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
	<!-- IE版本小于9的ace的css -->
	<!--[if lte IE 9]>
	<link rel="stylesheet" href="__PUBLIC__/ace/css/ace-part2.min.css" class="ace-main-stylesheet" />
	<![endif]-->

	<!--[if lte IE 9]>
	<link rel="stylesheet" href="__PUBLIC__/ace/css/ace-ie.css" />
	<![endif]-->

	<link rel="stylesheet" href="__PUBLIC__/yfcmf/yfcmf.css" />
	<!-- 此页相关css -->
	
	<!-- ace设置处理的js -->
	<script src="__PUBLIC__/ace/js/ace-extra.js"></script>
	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
	<script src="__PUBLIC__/others/html5shiv.min.js"></script>
	<script src="__PUBLIC__/others/respond.min.js"></script>
	<![endif]-->
    <!-- 引入基本的js -->
    <script type="text/javascript">
        var admin_ueditor_handle = "<?php echo url('admin/Ueditor/upload'); ?>";
        var admin_ueditor_lang ='zh-cn';
    </script>
    <!--[if !IE]> -->
    <script src="__PUBLIC__/others/jquery.min-2.2.1.js"></script>
    <!-- <![endif]-->
    <!-- 如果为IE,则引入jq1.12.1 -->
    <!--[if IE]>
    <script src="__PUBLIC__/others/jquery.min-1.12.1.js"></script>
    <![endif]-->

    <!-- 如果为触屏,则引入jquery.mobile -->
    <script type="text/javascript">
        if('ontouchstart' in document.documentElement) document.write("<script src='__PUBLIC__/others/jquery.mobile.custom.min.js'>"+"<"+"/script>");
    </script>
    <script src="__PUBLIC__/others/bootstrap.min.js"></script>
	<link rel="stylesheet" href="__PUBLIC__/others/admin.css">

</head>

<body class="no-skin">
<!-- 导航栏开始 -->
<div id="navbar" class="navbar navbar-default navbar-fixed-top">
	<div class="navbar-container" id="navbar-container">
		<!-- 导航左侧按钮手机样式开始 -->
		<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
			<span class="sr-only">Toggle sidebar</span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>

			<span class="icon-bar"></span>
		</button><!-- 导航左侧按钮手机样式结束 -->
		<button data-target="#sidebar2" data-toggle="collapse" type="button" class="pull-left navbar-toggle collapsed">
			<span class="sr-only">Toggle sidebar</span>
			<i class="ace-icon fa fa-dashboard white bigger-125"></i>
		</button>
		<!-- 导航左侧正常样式开始 -->
		<div class="navbar-header pull-left">
			<!-- logo -->
			<a href="<?php echo url('admin/Index/index'); ?>" class="navbar-brand" title="管理后台首页">
				<small>
					<i class="fa fa-leaf"></i>
					广东农工商职业技术学院学生资助管理系统
				</small>
			</a>
		</div><!-- 导航左侧正常样式结束 -->

		<!-- 导航栏开始 -->
		<div class="navbar-buttons navbar-header pull-right" role="navigation">
			<ul class="nav ace-nav">
				<li class="grey">
					<a href="<?php echo url('home/Show/index'); ?>" target="_blank">
						前台首页
					</a>
				</li>

				<li class="purple">
					<a data-info="确定要清理缓存吗？" class="confirm-rst-btn" href="<?php echo url('admin/Sys/clear'); ?>">
						清除缓存
					</a>
				</li>
				<!-- 用户菜单开始 -->
				<li class="light-blue dropdown-modal">
					<a data-toggle="dropdown" href="#" class="dropdown-toggle">
						<img class="nav-user-photo" src="<?php echo get_imgurl($admin_avatar,2); ?>" alt="<?php echo session('admin_auth.admin_username'); ?>" />
								<span class="user-info">
									<small>欢迎,</small>
									<?php echo session('admin_auth.admin_username'); ?>
								</span>

						<i class="ace-icon fa fa-caret-down"></i>
					</a>

					<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
						<li>
							<a href="<?php echo url('admin/Admin/profile'); ?>">
								<i class="ace-icon fa fa-user"></i>
								用户中心
							</a>
						</li>

						<li class="divider"></li>

						<li>
							<a href="<?php echo url('admin/Login/logout'); ?>"  data-info="你确定要退出吗？" class="confirm-btn">
								<i class="ace-icon fa fa-power-off"></i>
								注销
							</a>
						</li>
					</ul>
				</li><!-- 用户菜单结束 -->
			</ul>
		</div><!-- 导航栏结束 -->
	</div><!-- 导航栏容器结束 -->
</div><!-- 导航栏结束 -->

<!-- 整个页面内容开始 -->
<div class="main-container" id="main-container">
	<!-- 菜单栏开始 -->
	<div id="sidebar" class="sidebar responsive sidebar-fixed ace-save-state">
	<script type="text/javascript">
		try{ace.settings.loadState('sidebar')}catch(e){}
	</script>
	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
		<!--左侧顶端按钮-->
		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<a class="btn btn-success" href="<?php echo url('trim(admin/News/news_list)'); ?>" role="button" title="文章列表"><i class="ace-icon fa fa-signal"></i></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"><i class="ace-icon fa fa-pencil"></i></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="会员列表"><i class="ace-icon fa fa-users"></i></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>
		</div>
		<!--左侧顶端按钮（手机）-->
		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="会员列表"></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"></a>
		</div>
	</div>
	<!-- 菜单列表开始 -->
	<ul class="nav nav-list">
		<!--一级菜单遍历开始-->
		<?php if(is_array($menus) || $menus instanceof \think\Collection || $menus instanceof \think\Paginator): if( count($menus)==0 ) : echo "" ;else: foreach($menus as $key=>$v): if(!empty($v['_child'])): ?>
				<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>open<?php endif; ?>">
			<a href="javascript:void(0);" class="dropdown-toggle">
				<i class="menu-icon fa <?php echo $v['css']; ?>"></i>
				<span class="menu-text"><?php echo $v['title']; ?></span>
				<b class="arrow fa fa-angle-down"></b>
			</a>
			<ul class="submenu">
				<!--二级菜单遍历开始-->
				<?php if(is_array($v['_child']) || $v['_child'] instanceof \think\Collection || $v['_child'] instanceof \think\Paginator): if( count($v['_child'])==0 ) : echo "" ;else: foreach($v['_child'] as $key=>$vv): if(!empty($vv['_child'])): ?>
						<li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active open<?php endif; ?>">
					<a href="javascript:void(0);" class="dropdown-toggle">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php echo $vv['title']; ?>
						<b class="arrow fa fa-angle-down"></b>
					</a>
					<b class="arrow"></b>
					<ul class="submenu">
						<!--三级菜单遍历开始-->
						<?php if(is_array($vv['_child']) || $vv['_child'] instanceof \think\Collection || $vv['_child'] instanceof \think\Paginator): if( count($vv['_child'])==0 ) : echo "" ;else: foreach($vv['_child'] as $key=>$vvv): ?>
							<li class="<?php if((count($menus_curr) >= 3) AND ($menus_curr[2] == $vvv['id'])): ?>active<?php endif; ?>">
							<a href="<?php echo url(trim($vvv['name'])); ?>">
								<i class="menu-icon fa fa-caret-right"></i>
								<?php echo $vvv['title']; ?>
							</a>
							<b class="arrow"></b>
							</li>
						<?php endforeach; endif; else: echo "" ;endif; ?><!--三级菜单遍历结束-->
					</ul>
					</li>
					<?php else: ?>
					<li class="<?php if((count($menus_curr) >= 2) AND ($menus_curr[1] == $vv['id'])): ?>active<?php endif; ?>">
					<a href="<?php echo url(trim($vv['name'])); ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php echo $vv['title']; ?>
					</a>
					<b class="arrow"></b>
					</li>
					<?php endif; endforeach; endif; else: echo "" ;endif; ?><!--二级菜单遍历结束-->
			</ul>
			</li>
			<?php else: ?>
			<li class="<?php if((count($menus_curr) >= 1) AND ($menus_curr[0] == $v['id'])): ?>active<?php endif; ?>">
			<a href="<?php echo url(trim($v['name'])); ?>">
				<i class="menu-icon fa fa-caret-right"></i>
				<?php echo $v['title']; ?>
			</a>
			<b class="arrow"></b>
			</li>
			<?php endif; endforeach; endif; else: echo "" ;endif; ?><!--一级菜单遍历结束-->
	</ul><!-- 菜单列表结束 -->

	<!-- 菜单栏缩进开始 -->
	<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
		<i id="sidebar-toggle-icon" class="ace-icon fa fa-angle-double-left ace-save-state" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
	</div><!-- 菜单栏缩进结束 -->
</div>
	<!-- 菜单栏结束 -->

	<!-- 主要内容开始 -->
	<div class="main-content">
		<div class="main-content-inner">
			<!-- 右侧主要内容页顶部标题栏开始 -->
			<div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse breadcrumbs-fixed" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
	<div class="nav-wrap-up pos-rel">
		<div class="nav-wrap">
			<ul class="nav nav-list">
				<?php if(($id_curr != '') AND (!empty($menus_child))): if(is_array($menus_child) || $menus_child instanceof \think\Collection || $menus_child instanceof \think\Paginator): if( count($menus_child)==0 ) : echo "" ;else: foreach($menus_child as $key=>$k): ?>
				<li>
					<a href="<?php echo url(''.$k['name'].''); ?>">
					<o class="font12 <?php if($id_curr == $k['id']): ?>rigbg<?php endif; ?>"><?php echo $k['title']; ?></o>
					</a>
					<b class="arrow"></b>
				</li>
				<?php endforeach; endif; else: echo "" ;endif; else: ?>
				<li>
					<a href="<?php echo url('admin/Index/index'); ?>">
						<o class="font12">学生资助管理系统</o>
					</a>
					<b class="arrow"></b>
				</li>
				<?php endif; ?>
			</ul>
		</div>
	</div><!-- /.nav-list -->
</div>
			<!-- 右侧主要内容页顶部标题栏结束 -->
			<!-- 右侧下主要内容开始 -->
			
	<div class="page-content">

		<div class="row maintop">
			<div class="col-xs-5 col-sm-2  margintop5">
				<a href="<?php echo url('admin/Model/model_add'); ?>">
					<button class="btn btn-sm btn-danger">
						<i class="ace-icon fa fa-bolt bigger-110"></i>
						添加模型
					</button>
				</a>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12">
				<div>
					<table class="table table-striped table-bordered table-hover" id="dynamic-table">
						<thead>
						<tr>
							<th class="hidden-xs">ID</th>
							<th>模型标识</th>
							<th>模型标题</th>
							<th>数据引擎</th>
							<th class="hidden-sm hidden-xs">添加日期</th>
							<th>状态</th>
							<th style="border-right:#CCC solid 1px;">操作</th>
						</tr>
						</thead>

						<tbody>
							<?php if(is_array($models) || $models instanceof \think\Collection || $models instanceof \think\Paginator): if( count($models)==0 ) : echo "" ;else: foreach($models as $key=>$v): ?>
							<tr>
								<td height="28"  class="hidden-xs" ><?php echo $v['model_id']; ?></td>
								<td><?php echo $v['model_name']; ?></td>
								<td><?php echo $v['model_title']; ?></td>
								<td><?php echo $v['model_engine']; ?></td>
								<td class="hidden-sm hidden-xs"><?php echo date('Y-m-d',$v['create_time']); ?></td>
								<td>
									<?php if($v['model_status'] == 1): ?>
										<a class="red open-btn" href="<?php echo url('admin/Model/model_state'); ?>" data-id="<?php echo $v['model_id']; ?>" title="已开启">
											<div id="zt<?php echo $v['model_id']; ?>"><button class="btn btn-minier btn-yellow">开启</button></div>
										</a>
										<?php else: ?>
										<a class="red open-btn" href="<?php echo url('admin/Model/model_state'); ?>" data-id="<?php echo $v['model_id']; ?>" title="已禁用">
											<div id="zt<?php echo $v['model_id']; ?>"><button class="btn btn-minier btn-danger">禁用</button></div>
										</a>
									<?php endif; ?>														</td>
								<td>
									<div class="hidden-sm hidden-xs action-buttons">
										<a class="blue" href="javascript:;" onclick="return addmenu(<?php echo $v['model_id']; ?>);" data-toggle="tooltip"   title="添加到后台左侧菜单">
											<i class="ace-icon fa fa-plus-circle bigger-130"></i>													</a>
										<a class="green confirm-url-btn"  href="<?php echo url('admin/Model/model_edit',['model_id'=>$v['model_id']]); ?>" data-info="将重建数据库,原有数据自动备份，确认修改？" data-toggle="tooltip" title="修改">
											<i class="ace-icon fa fa-pencil bigger-130"></i>
										</a>
										<a class="green"  href="<?php echo url('admin/Model/model_copy',['model_id'=>$v['model_id']]); ?>"  data-toggle="tooltip" title="复制模型">
											<i class="ace-icon fa fa-exchange bigger-130"></i>
										</a>
										<a class="red confirm-rst-url-btn" href="<?php echo url('admin/Model/model_del',array('model_id'=>$v['model_id'])); ?>" data-info="你确定要删除吗？不建议直接删除" data-toggle="tooltip" title="删除">
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
													<a href="javascript:;" onclick="return addmenu(<?php echo $v['model_id']; ?>);" class="tooltip-success blue" data-rel="tooltip" title="添加到后台左侧菜单"  data-original-title="添加到后台左侧菜单">
																<span class="green">
																	<i class="ace-icon fa fa fa-plus-circle bigger-120"></i>
																</span>
													</a>
												</li>
												<li>
													<a href="<?php echo url('admin/Model/model_edit',['model_id'=>$v['model_id']]); ?>" class="tooltip-success confirm-url-btn" data-rel="tooltip" title="修改" data-info="将重建数据库,原有数据自动备份，确认修改？" data-original-title="修改">
																<span class="green">
																	<i class="ace-icon fa fa-pencil bigger-120"></i>
																</span>
													</a>
												</li>
												<li>
													<a href="<?php echo url('admin/Model/model_copy',['model_id'=>$v['model_id']]); ?>" class="tooltip-success" data-rel="tooltip" title="复制模型"  data-original-title="复制模型">
																<span class="green">
																	<i class="ace-icon fa fa-exchange bigger-120"></i>
																</span>
													</a>
												</li>
												<li>
													<a href="<?php echo url('admin/Model/model_del',array('model_id'=>$v['model_id'])); ?>"  class="tooltip-error confirm-rst-url-btn" data-info="你确定要删除吗？不建议直接删除" data-rel="tooltip" title="删除" data-original-title="删除">
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
						</tbody>
					</table>

				</div>
			</div>
		</div>
		<!--添加到后台menu-->
		<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-backdrop fade in" id="gbbb" style="height: 100%;"></div>
			<form class="form-horizontal ajaxForm2" name="model_addmenu" method="post" action="<?php echo url('admin/Model/model_addmenu'); ?>">
				<input type="hidden" name="model_id" id="model_id" value="" />
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" id="gb" data-dismiss="modal"
									aria-hidden="true">×
							</button>
							<h4 class="modal-title" id="myModalLabel">
								添加到后台菜单
							</h4>
						</div>
						<div class="modal-body">
							<div class="row">
								<div class="col-xs-12">
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 上级栏目：  </label>
										<div class="col-sm-9">
											<select name="admin_rule_pid"class="col-sm-4 selector" required>
												<option value="0">顶级栏目</option>
												<?php if(is_array($admin_rule) || $admin_rule instanceof \think\Collection || $admin_rule instanceof \think\Paginator): if( count($admin_rule)==0 ) : echo "" ;else: foreach($admin_rule as $key=>$v): ?>
												<option value="<?php echo $v['id']; ?>"><?php echo $v['lefthtml']; ?><?php echo $v['title']; ?></option>
												<?php endforeach; endif; else: echo "" ;endif; ?>
											</select>
											<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>后台菜单名</span>
										</div>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 导航标题：  </label>
										<div class="col-sm-9">
											<input type="text" name="menu_name" id="menu_name"  class="col-xs-10 col-sm-5" required/>
											<span class="lbl">&nbsp;&nbsp;<span class="red"></span>后台菜单名</span>
										</div>
									</div>
									<div class="space-4"></div>

									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 样式名称：  </label>
										<div class="col-sm-9">
											<input type="text" name="css" id="css" class="col-xs-10 col-sm-3"/>
											<span class="lbl">&nbsp;&nbsp;<span class="red">*</span>样式图标样式</span>
										</div>
										<span class="col-sm-3"></span><span class="col-sm-9" style="font-size:12px; color:#999; margin-top:5px;">预留样式：fa-tachometer ， fa-folder ， fa-list ， fa-list-alt ， fa-calendar</span>
									</div>
									<div class="space-4"></div>
									<div class="form-group">
										<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 排序（从小到大）： </label>
										<div class="col-sm-9">
											<input type="text" name="sort" id="sort"  value="50" class="col-xs-10 col-sm-3" />
											<span class="lbl">&nbsp;&nbsp;<span class="red"></span>越小越靠前</span>
										</div>
									</div>
									<div class="space-4"></div>
								</div>
							</div>

						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">
								提交保存
							</button>
							<button type="button" class="btn btn-default" id="gbb" data-dismiss="modal"
									aria-hidden="true">关闭
							</button>
						</div>
					</div>
				</div>
			</form>
		</div><!--修改-->
	</div><!-- /.page-content -->

			<!-- 右侧下主要内容结束 -->
		</div>
	</div><!-- 主要内容结束 -->
	<!-- 页脚开始 -->
	<div class="footer">
	<div class="footer-inner">
		<div class="footer-content">
			<span class="bigger-120">
				<span class="blue bolder"><a href="http://www.gdaib.edu.cn" target="_ablank">GDAIB</a></span>
				学生资助管理系统 &copy; <?php echo date('Y'); ?>
			</span>
		</div>
	</div>
</div>

	<!-- 页脚结束 -->
	<!-- 返回顶端开始 -->
	<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
		<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
	</a>
	<!-- 返回顶端结束 -->
</div><!-- 整个页面内结束 -->

<!-- ace的js,可以通过打包生成,避免引入文件数多 -->
<script src="__PUBLIC__/ace/js/ace.js"></script>
<script src="__PUBLIC__/ace/js/ace.min.js"></script>
<!-- jquery.form、layer、yfcmf的js -->
<script src="__PUBLIC__/others/jquery.form.js"></script>
<script src="__PUBLIC__/others/maxlength.js"></script>
<script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
<script src="__PUBLIC__/datePicker/bootstrap-datepicker.js"></script>
<script src="__PUBLIC__/datetimepicker/bootstrap-datetimepicker.js"></script>
<script src="__PUBLIC__/datetimepicker/locales/bootstrap-datetimepicker.zh-CN.js"></script>
<script src="__PUBLIC__/yfcmf/yfcmf.js?<?php echo time(); ?>"></script>
<!-- 此页相关插件js -->
<script src="__PUBLIC__/others/admin.js"></script>

<!-- 与此页相关的js -->
</body>
</html>
