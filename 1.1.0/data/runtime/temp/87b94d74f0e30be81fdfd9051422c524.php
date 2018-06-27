<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:59:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\sys\sys.html";i:1504198734;s:63:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\base.html";i:1504198734;s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\header.html";i:1515324146;s:67:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\left_nav.html";i:1514991728;s:67:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\head_nav.html";i:1514991728;s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\footer.html";i:1515324146;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>学生资助管理系统v1.0</title>

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
					<a href="<?php echo url('/home/index'); ?>" target="_blank">
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
									<small><?php echo $admin['title']; ?></small>
									<?php echo session('admin_auth.admin_username'); ?>
								</span>

						<!--<i class="ace-icon fa fa-caret-down"></i>-->
					</a>

					<!--<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">-->
						<!--<li>-->
							<!--<a href="<?php echo url('admin/Admin/profile'); ?>">-->
								<!--<i class="ace-icon fa fa-user"></i>-->
								<!--用户中心-->
							<!--</a>-->
						<!--</li>-->

						<!--<li class="divider"></li>-->

						<!--<li>-->
							<!--<a href="<?php echo url('admin/Login/logout'); ?>"  data-info="你确定要退出吗？" class="confirm-btn">-->
								<!--<i class="ace-icon fa fa-power-off"></i>-->
								<!--注销-->
							<!--</a>-->
						<!--</li>-->
					<!--</ul>-->
				</li><!-- 用户菜单结束 -->
				<li class="red">
					<a href="<?php echo url('admin/Login/logout'); ?>">
						退出系统
					</a>
				</li>
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
	<!-- <div class="sidebar-shortcuts" id="sidebar-shortcuts">

		<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
			<a class="btn btn-success" href="<?php echo url('trim(admin/News/news_list)'); ?>" role="button" title="文章列表"><i class="ace-icon fa fa-signal"></i></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"><i class="ace-icon fa fa-pencil"></i></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="会员列表"><i class="ace-icon fa fa-users"></i></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"><i class="ace-icon fa fa-cogs"></i></a>
		</div>

		<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
			<a class="btn btn-success" href="<?php echo url('admin/News/news_list'); ?>" role="button" title="文章列表"></a>
			<a class="btn btn-info" href="<?php echo url('admin/News/news_add'); ?>" role="button" title="添加文章"></a>
			<a class="btn btn-warning" href="<?php echo url('admin/Member/member_list'); ?>" role="button" title="会员列表"></a>
			<a class="btn btn-danger" href="<?php echo url('admin/Sys/sys'); ?>" role="button" title="站点设置"></a>
		</div>
	</div> -->
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
			<!-- <div id="sidebar2" class="sidebar h-sidebar navbar-collapse collapse breadcrumbs-fixed" data-sidebar="true" data-sidebar-scroll="true" data-sidebar-hover="true">
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
	</div>
</div> -->
<!-- /.nav-list -->

			<!-- 右侧主要内容页顶部标题栏结束 -->
			<!-- 右侧下主要内容开始 -->
			
	<div class="page-content">
		<!--主题-->
		<div class="page-header">
			<h1>
				您当前操作
				<small>
					<i class="ace-icon fa fa-angle-double-right"></i>
					站点设置
				</small>
			</h1>
		</div>
		<div class="row">

			<div class="tabbable">
				<ul class="nav nav-tabs" id="myTab">
					<li class="active">
						<a data-toggle="tab" href="#basic">
							基本设置
						</a>
					</li>

					<li>
						<a data-toggle="tab" href="#contact">
							联系方式
						</a>
					</li>

					<li>
						<a data-toggle="tab" href="#seo">
							SEO设置
						</a>
					</li>
				</ul>
				<form class="form-horizontal ajaxForm2" name="sys" method="post" action="<?php echo url('admin/Sys/runsys'); ?>">
					<fieldset>
						<div class="tab-content">
							<div id="basic" class="tab-pane fade in active">
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 站点名称 </label>
									<div class="col-sm-9">
										<input type="text" name="options[site_name]" id="site_name" value="<?php echo $sys['site_name']; ?>" class="col-xs-10 col-sm-7" required/>
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="resone">*</span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 站点网址 </label>
									<div class="col-sm-9">
										<input type="url" name="options[site_host]" id="site_host" value="<?php echo $sys['site_host']; ?>"  class="col-xs-10 col-sm-7" required/>
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="restwo">*</span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 站点主题(PC) </label>
									<div class="col-sm-9">
										<select name="options[site_tpl]" id="site_tpl" class="col-xs-10 col-sm-7" required>
											<?php if(is_array($templates) || $templates instanceof \think\Collection || $templates instanceof \think\Paginator): if( count($templates)==0 ) : echo "" ;else: foreach($templates as $key=>$vo): ?>
												<option value="<?php echo $vo; ?>" <?php if($sys['site_tpl'] == $vo): ?>selected="selected"<?php endif; ?>><?php echo $vo; ?></option>
											<?php endforeach; endif; else: echo "" ;endif; ?>
										</select>
									<span class="help-inline col-xs-12 col-sm-5">
										<span class="middle" id="restwo">*</span>
									</span>
									</div>
								</div>
								<div class="space-4"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 站点主题(手机) </label>
									<div class="col-sm-9">
										<select name="options[site_tpl_m]" id="site_tpl_m" class="col-xs-10 col-sm-7" required>
											<?php if(is_array($templates) || $templates instanceof \think\Collection || $templates instanceof \think\Paginator): if( count($templates)==0 ) : echo "" ;else: foreach($templates as $key=>$vo): ?>
											<option value="<?php echo $vo; ?>" <?php if($sys['site_tpl_m'] == $vo): ?>selected="selected"<?php endif; ?>><?php echo $vo; ?></option>
											<?php endforeach; endif; else: echo "" ;endif; ?>
										</select>
										<span class="help-inline col-xs-12 col-sm-5">
										<span class="middle" id="restwo">*</span>
									</span>
									</div>
								</div>
								<div class="space-4"></div>
								<div class="form-group" id="pic_list">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 网站LOGO </label>
									<div class="col-sm-9">
										<input type="hidden" name="checkpic" id="checkpic" value="<?php echo $sys['site_logo']; ?>" />
										<input type="hidden" name="oldcheckpic" id="oldcheckpic" value="<?php echo $sys['site_logo']; ?>" />
										<input type="hidden" name="oldcheckpicname" id="oldcheckpic" value="<?php echo $sys['site_logo']; ?>" />
										<a href="javascript:;" class="file" title="点击选择所要上传的图片">
											<input type="file" name="file0" id="file0" multiple="multiple"/>
											选择上传文件
										</a>
										&nbsp;&nbsp;<a href="javascript:;" onclick="return backpic('<?php echo get_imgurl($sys['site_logo']); ?>');" title="还原修改前的图片" class="file">
										撤销上传
										</a>
										<div><img src="<?php echo get_imgurl($sys['site_logo']); ?>" height="70" id="img0" ></div>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 备案信息 </label>
									<div class="col-sm-9">
										<input type="text" name="options[site_icp]" id="site_icp" value="<?php echo $sys['site_icp']; ?>"  class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="restwo"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 统计代码 </label>
									<div class="col-sm-9">
										<textarea  name="options[site_tongji]" cols="20" rows="2" class="col-xs-10 col-sm-7 limited"   id="form-field-9"  maxlength="500"><?php echo $sys['site_tongji']; ?></textarea>
										<input type="hidden" name="maxlengthone" value="500" />
								<span class="help-inline col-xs-5 col-sm-5">
									还可以输入 <span class="middle charsLeft"></span> 个字符
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 版权信息 </label>
									<div class="col-sm-9">
										<textarea  name="options[site_copyright]" cols="20" rows="3" class="col-xs-10 col-sm-7 limited1"   id="form-field-10"  maxlength="150"><?php echo $sys['site_copyright']; ?></textarea>
										<input type="hidden" name="maxlengthone" value="150" />
								<span class="help-inline col-xs-5 col-sm-5">
									还可以输入 <span class="middle charsLeft1"></span> 个字符
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group none">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 是否开启自动更新： </label>
									<div class="col-sm-9" style="padding-top:5px;">
										<input name="update_check" id="update_check" <?php if(\think\Config::get('update_check') == 1): ?>checked<?php endif; ?>  value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
										<span class="lbl"></span>
									</div>
								</div>
								<div class="space-4"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 后台极验验证： </label>
									<div class="col-sm-9" style="padding-top:5px;">
										<input name="geetest_on" id="geetest_on" <?php if(config('geetest.geetest_on')): ?>checked<?php endif; ?>  value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox" />
										<span class="lbl"><a href="http://www.geetest.com" target="_blank" style="margin-left: 10px;"><span class="label label-lg label-pink">申请：http://www.geetest.com</span></a></span>
										<span class="help-inline">需开启路由</span>
									</div>
								</div>
								<div class="space-4"></div>
								<div id="geetest" <?php if(config('geetest.geetest_on') == 0): ?>style="display: none;"<?php endif; ?>>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 极验captcha_id：</label>
									<div class="col-sm-9">
										<input type="text" name="captcha_id" id="captcha_id" value="<?php echo config('geetest.captcha_id'); ?>" class="col-xs-10 col-sm-7" />
										<span class="help-inline col-xs-12 col-sm-5">
									<span class="lbl"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 极验private_key： </label>
									<div class="col-sm-9">
										<input type="password" name="private_key" id="private_key" value="<?php echo config('geetest.private_key'); ?>" class="col-xs-10 col-sm-7" />
										<span class="help-inline col-xs-12 col-sm-5">
									<span class="lbl"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>
								</div>
							</div>

							<div id="contact" class="tab-pane fade">
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 公司名称 </label>
									<div class="col-sm-9">
										<input type="text" name="options[site_co_name]" id="site_co_name" value="<?php echo $sys['site_co_name']; ?>" class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="resone"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 公司地址 </label>
									<div class="col-sm-9">
										<input type="text" name="options[site_address]" id="site_address" value="<?php echo $sys['site_address']; ?>"  class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="restwo"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 地图lat </label>
									<div class="col-sm-9">
										<input type="text" name="options[map_lat]" id="map_lat" value="<?php echo $map_lat; ?>" class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="resone"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>
								
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 地图lng </label>
									<div class="col-sm-9">
										<input type="text" name="options[map_lng]" id="map_lng" value="<?php echo $map_lng; ?>" class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="resone"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>							
								
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 联系电话 </label>
									<div class="col-sm-9">
										<input type="text" name="options[site_tel]" id="site_tel" value="<?php echo $sys['site_tel']; ?>"  class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="restwo"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 站长邮箱 </label>
									<div class="col-sm-9">
										<input type="email" name="options[site_admin_email]" id="site_admin_email" value="<?php echo $sys['site_admin_email']; ?>"  class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="restwo"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 站长QQ </label>
									<div class="col-sm-9">
										<input type="number" name="options[site_qq]" id="site_qq" value="<?php echo $sys['site_qq']; ?>"  class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="restwo"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>
							</div>

							<div id="seo" class="tab-pane fade">
								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 首页SEO标题 </label>
									<div class="col-sm-9">
										<input type="text" name="options[site_seo_title]" id="site_seo_title" value="<?php echo $sys['site_seo_title']; ?>"  class="col-xs-10 col-sm-7" />
								<span class="help-inline col-xs-12 col-sm-5">
									<span class="middle" id="resthr"></span>
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 首页SEO关键字 </label>
									<div class="col-sm-9">
										<textarea  name="options[site_seo_keywords]" cols="20" class="col-xs-10 col-sm-7 limited2"  id="form-field-11"  maxlength="100"><?php echo $sys['site_seo_keywords']; ?></textarea>
										<input type="hidden" name="maxlength" value="100" />
								<span class="help-inline col-xs-5 col-sm-5">
									还可以输入 <span class="middle charsLeft2"></span> 个字符,以英文 , 号隔开
								</span>
									</div>
								</div>
								<div class="space-4"></div>

								<div class="form-group">
									<label class="col-sm-3 control-label no-padding-right" for="form-field-1"> 首页SEO描述 </label>
									<div class="col-sm-9">
										<textarea  name="options[site_seo_description]" cols="20" rows="4" class="col-xs-10 col-sm-7 limited3"   id="form-field-12"  maxlength="200"><?php echo $sys['site_seo_description']; ?></textarea>
										<input type="hidden" name="maxlengthone" value="200" />
								<span class="help-inline col-xs-5 col-sm-5">
									还可以输入 <span class="middle charsLeft3"></span> 个字符
								</span>
									</div>
								</div>
								<div class="space-4"></div>
							</div>
						</div>
						<div class="clearfix form-actions">
							<div class="col-sm-offset-3 col-sm-9">
								<button class="btn btn-info" type="submit">
									<i class="ace-icon fa fa-check bigger-110"></i>
									保存
								</button>

								&nbsp; &nbsp; &nbsp;
								<button class="btn" type="reset">
									<i class="ace-icon fa fa-undo bigger-110"></i>
									重置
								</button>
							</div>
						</div>
					</fieldset>
				</form>
			</div>
		</div>

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
				学生资助管理系统v1.0 &copy; <?php echo date('Y'); ?>
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