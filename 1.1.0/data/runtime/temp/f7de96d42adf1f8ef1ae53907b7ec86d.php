<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:78:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\faculty_group\showMaterial.html";i:1526632019;s:63:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\base.html";i:1504198734;s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\header.html";i:1515324146;s:67:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\left_nav.html";i:1514991728;s:67:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\head_nav.html";i:1514991728;s:66:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\scholar.html";i:1522192587;s:79:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\common\grants_inspirational.html";i:1522826490;s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\footer.html";i:1515324146;}*/ ?>
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
    <div class="page-header">
        <h1>
            您当前操作
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                <a href="<?php echo url('admin/scholarships_group/showreviewlist'); ?>">国家<?php echo config('application_type.'.$type_id); ?>班级审核</a>
            </small>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                添加评语
            </small>
            <!--<small>-->
            <!--<i class="ace-icon fa fa-angle-double-right"></i>-->
            <!--个人简历-->
            <!--</small>-->
        </h1>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="w800">
                <table class="table_heading" style="width:100%">
                    <tr>
                        <td colspan="2"></td>
                        <td style="text-align: right"><span style="font-size: 13px;color:grey;">广东农工商职业技术学院</span></td>
                    </tr>
                    <tr>
                        <td colspan="3" style="font-size: 25px;font-weight: 600;text-align: center;border-top: 1px solid #000;line-height: 48px;">
                            普通本科高校、高等职业学校国家<?php echo config('application_type.'.$type_id); ?>申请表
                        </td>
                    </tr>
                </table>
                <table class="table table-bordered tab_center">
                    <!--本人情况-->
                    <?php if($type_id == 1): ?>
                    <tr class="line-table-height scholar_tab">
    <td rowspan="4" class="k-s-content title" style="width: 40px;">基本情况</td>
    <td class="k-s-content title" style="text-align: center;">姓名</td>
    <td class="k-s-content content"><input type="text" name="" value="<?php echo $user['studentname']; ?>"/></td>
    <td class="k-s-content title">性别</td>
    <td class="k-s-content content"><input type="text" name="" value="<?php echo $user['gender']; ?>"/></td>
    <td class="k-s-content title">出生年月</td>
    <td colspan="2" class="k-s-content content"><input type="text" name="" value="<?php echo $user['birthday']; ?>"/></td>
</tr>
<tr class="line-table-height tab_style">
    <td class="k-s-content title" style="text-align: center;">政治面貌</td>
    <td class="k-s-content content"><input type="text" name="" value="<?php echo $user['political']; ?>"/></td>
    <td class="k-s-content title">民族</td>
    <td class="k-s-content content"><input type="text" name="" value="<?php echo $user['nation']; ?>"/></td>
    <td class="k-s-content title">入学时间</td>
    <td colspan="2" class="k-s-content content"><input type="text" name="" value="<?php echo $user['admission_date']; ?>"/></td>
</tr>
<tr class="line-table-height tab_style">
    <td class="k-s-content title" style="text-align: center;">专业</td>
    <td class="k-s-content content"><input type="text" name="" value="<?php echo $user['profession']; ?>"/></td>
    <td class="k-s-content title">学制</td>
    <td class="k-s-content content"><input type="text" name="" value=""/></td>
    <td class="k-s-content title">联系电话</td>
    <td colspan="2" class="k-s-content content"><input type="text" name="tel" /></td>
</tr>
<tr class="line-table-height tab_style">
    <td class="k-s-content title" style="text-align: center;">身份证号</td>
    <td colspan="6" class="k-s-content content"><input type="text" name="" value="<?php echo $user['id_number']; ?>"/></td>
</tr>
<!--学习情况-->
<tr class="line-table-height scholar_tab">
    <td rowspan="2" class="k-s-content title" style="width: 40px;">学习情况</td>
    <td colspan="3" class="k-s-content title" style="text-align: center;">
        <div class="ranking">
            成绩排名：
            <input type="text" name="course_ranking" style="width:50px;border-bottom: 1px solid #555555;">
            /
            <input type="text" name="course_total_people" style="width:50px;border-bottom: 1px solid #555555;">
            （名次/总人数）
        </div>
    </td>
    <td colspan="4" class="k-s-content title">
        实行综合考评排名：
        <div style="display:inline-block;">
            <label>
                是<input type="radio" name="is_assessment" value="1" style="height:auto;width: auto;margin-right: 5px;"/>
            </label>
        </div>
        <div style="display:inline-block;">
            <label>
                否<input type="radio" name="is_assessment" value="0" style="height:auto;width: auto;margin-right: 5px;"/>
            </label>
        </div>
    </td>
</tr>
<tr class="line-table-height scholar_tab">
    <td colspan="3" class="k-s-content title">
        必修课
        <input type="text" style="width:10%;border-bottom: 1px solid #555555;" name="compulsory_course">门，
        其中及格以上
        <input type="text" style="width:10%;border-bottom: 1px solid #555555;" name="pass_count">门
    </td>
    <td colspan="4" class="k-s-content title" style="text-align: center;">
        <div class="ranking">
            如是，排名：
            <input type="text" name="assessment_ranking" style="width:50px;border-bottom: 1px solid #555555;">
            /
            <input type="text" name="assessment_total_people" style="width:50px;border-bottom: 1px solid #555555;">
            （名次/总人数）
        </div>
    </td>
</tr>
<!--大学期间主要获奖情况-->
<tr class="line-table-height">
    <td rowspan="5" class="k-s-content title">大学期间主要获奖情况</td>
    <td class="k-s-content title">日期</td>
    <td colspan="3" class="k-s-content title">奖项名称</td>
    <td colspan="3" class="k-s-content title">颁奖单位</td>
</tr>
<tr class="line-table-height">
    <td class="k-s-content content"><input type="text" name="awards[0][date]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[0][name]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[0][unit]" /></td>
</tr>
<tr class="line-table-height">
    <td class="k-s-content content"><input type="text" name="awards[1][date]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[1][name]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[1][unit]" /></td>
</tr>
<tr class="line-table-height">
    <td class="k-s-content content"><input type="text" name="awards[2][date]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[2][name]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[2][unit]" /></td>
</tr>
<tr class="line-table-height">
    <td class="k-s-content content"><input type="text" name="awards[3][date]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[3][name]" /></td>
    <td colspan="3" class="k-s-content content"><input type="text" name="awards[3][unit]" /></td>
</tr>
<!--申请理由-->
<tr class="line-table-height">
    <td class="k-s-content title">申请理由(200字)</td>
    <td colspan="7" class="k-s-content content" style="text-align: left;">
        <textarea name="reason" id="" class="longtext"  style="width:100%;height:200px;resize:none;"></textarea>
        <div style="float: right;">
            <div class="level_form" style="float: left;">
                <div class="signature">
                    <label for="" style="float: left;">申请人签名（手签）：</label>
                    <input type="text" value="<?php echo $user['studentname']; ?>" style="float: left;width:200px;border-bottom: 1px solid #555555;">
                </div>
            </div>
            <div class="level_form" style="float: left;margin-left:10px;">
                <div class="level_time" style="float: left;">
                    <input type="text" value=""  style="width:100px;border-bottom: 1px solid #555555;">
                    <label for="">年</label>
                </div>
                <div class="level_time" style="float: left;" >
                    <input type="text" value="" style="width:100px;border-bottom: 1px solid #555555;">
                    <label for="">月</label>
                </div>
                <div class="level_time" style="float: left;">
                    <input type="text" value=""  style="width:100px;border-bottom: 1px solid #555555;">
                    <label for="">日</label>
                </div>
            </div>
        </div>
    </td>
</tr>

                    <?php else: ?>
                    <tr>
                        <td rowspan="4" class="tab_title tab_40px">本人情况</td>
                        <td class="tab_title tab_80px">姓名</td>
                        <td class="tab_content tab_100px"><?php echo $user['studentname']; ?></td>
                        <td class="tab_title">性别</td>
                        <td class="tab_content"><?php echo $user['gender']; ?></td>
                        <td class="tab_title">出生年月</td>
                        <td class="tab_content tab_140px"><?php echo $user['birthday']; ?></td>
                        <td colspan="2" rowspan="4" class="tab_content tab_126px">
                            <img src="<?php echo $user['member_list_headpic']; ?>" style="width: 125px; height: 175px;" alt="">
                        </td>
                    </tr>
                    <tr>
                        <td class="tab_title">民族</td>
                        <td class="tab_content"><?php echo $user['nation']; ?></td>
                        <td class="tab_title">政治面貌</td>
                        <td class="tab_content"><?php echo $user['political']; ?></td>
                        <td class="tab_title">学号</td>
                        <td class="tab_content"><?php echo $user['user_id']; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_title">身份证号</td>
                        <td colspan="3" class="tab_content"><?php echo $user['id_number']; ?></td>
                        <td class="tab_title">联系电话</td>
                        <td class="tab_content"><?php echo $user['tel']; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_title">学院、院系、班级</td>
                        <td colspan="5" class="tab_content">广东农工商职业技术学院<?php echo $user['department_name']; ?><?php echo $user['profession']; ?><?php echo $user['class']; ?></td>
                    </tr>
                    <!--家庭经济情况-->
                    <tr>
                        <td rowspan="3" class="tab_title">家庭经济情况</td>
                        <td class="tab_title">家庭户口</td>
                        <td colspan="5" class="tab_content">
                            <div style="display:inline-block;margin-right: 20px;">
                                <label>
                                    <input <?php if($user['family_type']==0): ?> checked <?php endif; ?> disabled type="radio" name="" style="height:auto;width: auto;margin-right: 5px;"/>城镇
                                </label>
                            </div>
                            <div style="display:inline-block;">
                                <label>
                                    <input <?php if($user['family_type']==1): ?> checked <?php endif; ?> disabled type="radio" name="" style="height:auto;width: auto;margin-right: 5px;"/>农村
                                </label>
                            </div>
                        </td>
                        <td class="tab_title">家庭总人口数</td>
                        <td class="tab_content"><?php echo $user['population']; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_title">家庭月总收入</td>
                        <td class="tab_content"><?php echo $user['monthly_total_income']; ?></td>
                        <td class="tab_title">人均月收入</td>
                        <td class="tab_content"><?php echo $user['monthly_people_income']; ?></td>
                        <td class="tab_title">收入来源</td>
                        <td colspan="3" class="tab_content"><?php echo $user['income_source']; ?></td>
                    </tr>
                    <tr>
                        <td class="tab_title">家庭住址</td>
                        <td colspan="5" class="tab_content"><?php echo $user['address']; ?></td>
                        <td class="tab_title">邮政编码</td>
                        <td class="tab_content"><?php echo $user['zip_code']; ?></td>
                    </tr>
                    <!--家庭成员情况-->
                    <?php $num = count($user['members']);?>
                    <tr><!--自行替换为要循环出来的数量+1-->
                        <td rowspan="<?php echo $num+1; ?>"  class="tab_title">家庭成员情况</td>
                        <td class="tab_title">姓名</td>
                        <td class="tab_title">年龄</td>
                        <td class="tab_title">与本人关系</td>
                        <td colspan="5" class="tab_title">工作或学习单位</td>
                    </tr>
                    <?php foreach($user['members'] as $r): ?>
                    <tr>
                        <td class="tab_content"><?php echo $r['name']; ?></td>
                        <td class="tab_content"><?php echo $r['age']; ?></td>
                        <td class="tab_content"><?php echo $r['relation']; ?></td>
                        <td colspan="5" class="tab_content"><?php echo $r['unit']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <!--申请理由-->
                    <tr>
                        <td colspan="9" class="tab_content">
                            <p class="tab_left">申请理由</p>
                            <textarea name="" id="" class="tab_opinion" disabled><?php echo $user['reason']; ?></textarea>
                            <div class="tab_sign">
                                <label for="">申请人签名：</label>
                                <input type="text" value="<?php echo $user['studentname']; ?>" disabled>
                            </div>
                            <div class="clearfix"></div>
                            <div class="tab_time">
                                <input type="text" value="<?php echo date('Y',$user['create_at']); ?>" disabled>年
                                <input type="text" value="<?php echo date('n',$user['create_at']); ?>" disabled>月
                                <input type="text" value="<?php echo date('d',$user['create_at']); ?>" disabled>日
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                    <!--班级小组评语-->
                    <tr>
                        <td colspan="9" class="tab_content">
                            <p class="tab_left">班级评定小组意见</p>
                            <textarea class="tab_opinion" disabled><?php echo $user['group_opinion']['text']; ?></textarea>
                            <!-- <div class="tab_sign">
                                <label for="">组长签名：</label>
                                <input type="text" value="<?php echo $user['group_opinion']['name']; ?>" disabled>
                            </div>
                            -->
                            <div class="clearfix"></div>
                            <div class="tab_time">
                                <input type="text" value="<?php echo date('Y',$user['group_opinion']['time']); ?>" disabled>年
                                <input type="text" value="<?php echo date('n',$user['group_opinion']['time']); ?>"disabled>月
                                <input type="text" value="<?php echo date('d',$user['group_opinion']['time']); ?>"disabled>日
                            </div>
                        </td>
                    </tr>
                </table>
                <form action="<?php echo url('admin/ScholarshipHandle/MultipleFacultyFill'); ?>" method="post" id="passingForm" class="passingForm">
                    <table class="w800">
                        <tr>
                            <td class="tab_title"><p class=" tab_left" style="font-size: 16px;">院系小组添加评语：</p></td>
                            <td colspan="2"></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="tab_content">
                                <?php if((!in_array($user['check_status'],[2]) && $type_id !=1) || (!in_array($user['check_status'],[3]) && $type_id ==1)): ?>
                                <textarea name="faculty_opinion[text]" class="tab_opinion"><?php echo $user['faculty_opinion']['text']; ?></textarea>
                                <?php else: ?>
                                <select class="form-control tab_select text" name="faculty_opinion[text]">
                                    <?php foreach(\think\Config::get('scholarships_opinion') as $k => $v): ?>
                                    <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php endif; ?>
                                <!-- <div class="tab_sign">
                                    <label for="">院系小组负责人签名：</label>
                                    <input type="text" name="faculty_opinion[name]" value="<?php echo $user['faculty_opinion']['name']; ?>">
                                </div>
                                <div class="clearfix"></div>
                                <div class="tab_time">
                                    <input type="text" name="faculty_opinion[year]" value="<?php echo date('Y',$user['faculty_opinion']['time']); ?>">年
                                    <input type="text" name="faculty_opinion[month]" value="<?php echo date('n',$user['faculty_opinion']['time']); ?>">月
                                    <input type="text" name="faculty_opinion[day]" value="<?php echo date('d',$user['faculty_opinion']['time']); ?>">日
                                </div> -->
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3" style="height: 30px;"></td>
                        </tr>
                        <input type="hidden" value="<?php echo $user['user_id']; ?>" name="user_id">
                        <input type="hidden" value="<?php echo $id; ?>" name="status_id">
                        <input type="hidden" value="<?php echo $type_id; ?>" name="type_id">
                            <tr>
                                <td style="width: 266px;"></td>
                                <td class="tab_content" style="width: 266px;">
                                    <button type="submit"  class="btn btn-primary" name="pass">通过</button>
                                    <!-- <button type="submit" class="btn btn-danger" name="fail" value="1">不通过</button> -->
                                </td>
                                <td style="width: 266px;"></td>
                            </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<?php if((!in_array($user['check_status'],[2]) && $type_id !=1) || (!in_array($user['check_status'],[3]) && $type_id ==1)): ?>
<script>
$(".passingForm").find("textarea").attr('disabled',true);
$(".passingForm").find("input").attr('disabled',true);
$(".passingForm").find("select").attr('disabled',true);
$(".passingForm").find("button").attr('disabled',true);
</script>
<?php endif; ?>

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
