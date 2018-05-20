<?php if (!defined('THINK_PATH')) exit(); /*a:7:{s:81:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\evaluation\faculty_add_review.html";i:1526630565;s:63:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\base.html";i:1504198734;s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\header.html";i:1515324146;s:67:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\left_nav.html";i:1514991728;s:67:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\head_nav.html";i:1514991728;s:88:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\evaluation\student_information_table.html";i:1512529658;s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/admin\view\public\footer.html";i:1515324146;}*/ ?>
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
                <a href="<?php echo url('admin/EvaluFront/E_faculty_review'); ?>">学生家庭经济困难认定</a>
            </small>
            <small>
                <i class="ace-icon fa fa-angle-double-right"></i>
                查看学生信息
            </small>
        </h1>
    </div>
    <div class="row clearfix">
        <div class="col-md-12 column">
            <div class="w900">

                <table class="table_heading" style="width:100%">
    <tr>
        <td colspan="2"></td>
        <td style="text-align: right"><span style="font-size: 13px;color:grey;">广东农工商职业技术学院</span></td>
    </tr>
    <tr>
        <td colspan="3" style="font-size: 25px;font-weight: 600;text-align: center;border-top: 1px solid #000;line-height: 48px;">
            家庭经济困难学生认定申请表
        </td>
    </tr>
</table>
<table class="table table-bordered tab_center" id="evalu_form">
    <tr class="line-table-height">
        <td class="k-s-content title"  rowspan="3" style="width: 40px;">学生基本情况</td>
        <td class="k-s-content title" style="text-align: center;width: 60px; ">院系</td>
        <td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user['department_name']; ?>" disabled/></td>
        <td class="k-s-content title">专业</td>
        <td colspan="3" class="k-s-content content"><input type="text" name="sex"  value="<?php echo $user['profession']; ?><?php echo $user['class']; ?>" disabled/></td>
        <td class="k-s-content title" style="width: 60px;">年级</td>
        <td class="k-s-content content"><input type="text" name="nation"  value="<?php echo $user['current_grade']; ?>" disabled/></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" style="text-align: center;">姓名</td>
        <td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user['studentname']; ?>" disabled/></td>
        <td class="k-s-content title" style="width: 60px;">性别</td>
        <td class="k-s-content content" style="width: 60px;"><input type="text" name="sex"  value="<?php echo $user['gender']; ?>" disabled/></td>
        <td class="k-s-content title" style="width: 80px;">出生年月</td>
        <td class="k-s-content content" style="width: 100px;"><input type="text" name="nation"  value="<?php echo $user['birthday']; ?>" disabled/></td>
        <td class="k-s-content title">民族</td>
        <td class="k-s-content content"><input type="text" name="nation"  value="<?php echo $user['nation']; ?>" disabled/></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" style="text-align: center;">身份证</td>
        <td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user['id_number']; ?>" disabled/></td>
        <td colspan="2" class="k-s-content title">入学前户口</td>
        <td colspan="2" class="k-s-content content">
            <div style="display:inline-block;">
                <label>
                    <input type="radio" name="account" style="height:auto;width: auto;margin-right: 5px;"value="0"  <?php if($user['is_rural_student']=='否'): ?> checked <?php endif; ?> disabled/>城镇
                </label>
            </div>
            <div style="display:inline-block;">
                <label>
                    <input type="radio" name="account" style="height:auto;width: auto;margin-right: 5px;"value="1"  <?php if($user['is_rural_student']=='是'): ?> checked <?php endif; ?> disabled/>农村
                </label>
            </div>
        </td>
        <td class="k-s-content title">健康</td>
        <td colspan="2" class="k-s-content content">
            <div style="display:inline-block;">
                <label>
                    <input type="radio" name="suffering" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['suffering'] == 1): ?>checked<?php endif; ?>/>
                </label>
            </div>
            <div style="display:inline-block;">
                <label>
                    <input type="radio" name="suffering" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['suffering'] == 0): ?>checked<?php endif; ?>/>否
                </label>
            </div>
        </td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title"  rowspan="5" style="width: 40px;">家庭基本情况</td>
        <td class="k-s-content title" style="text-align: center;width: 60px; ">户籍地址</td>
        <td colspan="6" class="k-s-content content"><input type="text" name="residence_address" value="<?php echo $eval_app['residence_address']; ?>"/></td>
        <td class="k-s-content title">邮编</td>
        <td colspan="3" class="k-s-content content"><input type="text" name="zip_code" value="<?php echo $eval_app['zip_code']; ?>"/></td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title" style="text-align: center;width: 60px; ">联系电话</td>
        <td colspan="2" class="k-s-content content"><input type="text" name="number" value="<?php echo $eval_app['number']; ?>"/></td>
        <td colspan="2" class="k-s-content title">家庭在上学人口</td>
        <td colspan="2" class="k-s-content content"><input type="text" name="school_population"  value="<?php echo $eval_app['school_population']; ?>" style="width:30px;" />人</td>
        <td class="k-s-content title">家庭人口</td>
        <td class="k-s-content content"><input type="text"  name="population"  value="<?php echo $eval_app['population']; ?>" style="width:30px;" />人</td>
    </tr>
    <tr class="line-table-height">
        <td class="k-s-content title">住房情况</td>
        <td colspan="4" class="k-s-content content">
            <?php foreach($eval_form['housing_situation'] as $key => $val): ?>
            <div style="display:inline-block;">
                <label>
                    <input type="radio" name="housing_situation" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['housing_situation']): ?>checked<?php endif; ?>/ ><?php echo $val; ?>
                </label>
            </div>
            <?php endforeach; ?>
            <input type="text" name="housing_situation_other" style="width: auto;height: auto;border-bottom:1px solid #555555;width:100px;" value="<?php echo $eval_app['housing_situation_other']; ?>">
        </td>
        <td class="k-s-content title">购车情况</td>
        <td colspan="3" class="k-s-content content">
            <?php foreach($eval_form['car_situation'] as $key => $val): ?>
            <div style="display:inline-block;">
                <label>
                    <input type="radio" name="car_situation" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['car_situation']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                </label>
            </div>
            <?php endforeach; ?>
        </td>
    </tr>
    <tr class="line-table-height">
        <td colspan="9" class="k-s-content content" style="text-align: left; ">
            <input type="checkbox" name="establish_card" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['establish_card'] == 1): ?>checked<?php endif; ?>/>建档立卡贫困户
            <input type="checkbox" name="special_person" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['special_person'] == 1): ?>checked<?php endif; ?>/>特困供养户
            <input type="checkbox" name="mini_living" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['mini_living'] == 1): ?>checked<?php endif; ?>/>城乡低保户
            <input type="checkbox" name="low_income" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['low_income'] == 1): ?>checked<?php endif; ?>/>城镇低收入困难家庭
            <input type="checkbox" name="single_parent" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['single_parent'] == 1): ?>checked<?php endif; ?> />单亲家庭
        </td>

    </tr>
    <tr class="line-table-height">
        <td colspan="9" class="k-s-content content" style="text-align: left; ">
            <input type="checkbox" name="orphan" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;"  <?php if($eval_app['orphan'] == 1): ?>checked<?php endif; ?>/>孤儿
            <input type="checkbox" name="martyrs_children" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['martyrs_children'] == 1): ?>checked<?php endif; ?>/>烈士或国家抚恤对象
            <input type="checkbox" name="poor_children" value="1" style="height:auto;width: auto;margin-left: 5px;margin-right: 5px;" <?php if($eval_app['poor_children'] == 1): ?>checked<?php endif; ?>/>特困职工子女
        </td>

    </tr>

    <?php $num = 1; $__FOR_START_14628__=1;$__FOR_END_14628__=5;for($i=$__FOR_START_14628__;$i < $__FOR_END_14628__;$i+=1){ if($eval_app['members']['name'][$i-1]): $num++; endif; } ?>

    <tr class="line-table-height">
        <td rowspan="<?php echo $num; ?>" class="k-s-content title" style="width: 40px;">家庭成员情况(含祖父母）</td>
        <td class="k-s-content title" style="width: 70px;">姓名</td>
        <td class="k-s-content title" style="width: 70px;">年龄</td>
        <td class="k-s-content title" style="width: 70px;">与学生关系</td>
        <td colspan="2" class="k-s-content title">工作（学习）单位</td>
        <td class="k-s-content title" style="width: 70px;">从业情况</td>
        <td class="k-s-content title" style="width: 70px;">文化程度</td>
        <td class="k-s-content title" style="width: 70px;">年收入（元）</td>
        <td class="k-s-content title" style="width: 70px;">健康状况</td>
    </tr>


    <?php $__FOR_START_18294__=1;$__FOR_END_18294__=5;for($i=$__FOR_START_18294__;$i < $__FOR_END_18294__;$i+=1){ if($eval_app['members']['name'][$i-1]): ?>
     <tr class="line-table-height">
        <td class="k-s-content content"><input type="text" name="members[name][]" value="<?php echo $eval_app['members']['name'][$i-1]; ?>"></td>
        <td class="k-s-content content"><input type="text" name="members[age][]" value="<?php echo $eval_app['members']['age'][$i-1]; ?>" class="number"></td>
        <td class="k-s-content content">
            <?php echo $eval_form['relationship'][$eval_app['members']['relationship'][$i-1]]; ?>
        </td>
        <td colspan="2" class="k-s-content content"><input type="text" name="members[unit][]" value="<?php echo $eval_app['members']['unit'][$i-1]; ?>"></td>
        <td class="k-s-content content">
            <?php echo $eval_form['career'][$eval_app['members']['career'][$i-1]]; ?>
        </td>
        <td class="k-s-content content">
            <?php echo $eval_form['culture'][$eval_app['members']['culture'][$i-1]]; ?>
        </td>
        <td class="k-s-content content"><input type="text" name="members[income][]" class="number" value="<?php echo $eval_app['members']['income'][$i-1]; ?>"></td>
        <td class="k-s-content content">
            <?php echo $eval_form['handicap'][$eval_app['members']['handicap'][$i-1]]; ?><br>
            <?php echo $eval_form['health'][$eval_app['members']['health'][$i-1]]; ?>
        </td>
    </tr>
    <?php endif; } ?>

    <tr class="line-table-height">
        <td class="k-s-content title">影响家庭紧急状况有关信息</td>
        <td colspan="10" class="k-s-content content" style="text-align:left;">
            <div style="padding: 5px;">
                <label for="">家庭主要收入来源类型</label>
                <input type="text" name="income_source" style="width: auto;border-bottom: 1px solid #555555;" placeholder="主要收入来源" value="<?php echo $eval_app['income_source']; ?>">
            </div>
            <p>
                （只能选填其中一项。<br>
                1.<u>工资、奖金、津贴、补贴和其他劳动收入</u>；
                2.<u>离退休金、基本养老金、基本生活费、失业保险金</u>；
                3.<u>继承、接受赠予、出租或出售家庭财产获得的收入</u>；
                4.<u>存款及利息，有价证券及红利、股票、博彩收入</u>；
                5.<u>经商、办厂以及从事种植业、养殖业、加工业扣除必要成本后的收入</u>；
                6.<u>赡养费、抚(扶)养费</u>；
                7.<u>自谋职业收入</u>；
                8.<u>其他应当计入家庭的收入</u>）
            </p>
            <div style="padding: 5px;">
                <label for="">学生已获资助情况</label>
                <input type="text" name="funded" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="时间、受资助的具体项目、受助金额人民币元" value="<?php echo $eval_app['funded']; ?>">
            </div>
            <p><strong>（如无以下情形，只需填写“无”）：</strong></p>
            <div style="padding: 5px;">
                <label for="">家庭遭受自然灾害情况</label>
                <input type="text" name="natural_disasters" style="width: 60%;border-bottom: 1px solid #555555;" placeholder="（时间最近两年内发生、损失金额、人员伤亡等具体描述）" value="<?php echo $eval_app['natural_disasters']; ?>">
            </div>
            <div style="padding: 5px;">
                <label for="">家庭遭受突发意外事件</label>
                <input type="text" name="unexpected_events" style="width: 60%;border-bottom: 1px solid #555555;" placeholder="（时间最近两年内发生、损失金额、人员伤亡等具体描述）" value="<?php echo $eval_app['unexpected_events']; ?>">
            </div>
            <div style="padding: 5px;">
                <label for="">家庭欠债情况</label>
                <input type="text" name="debt" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="（时间、原因、金额人民币元）" value="<?php echo $eval_app['debt']; ?>">
            </div>
            <div style="padding: 5px;">
                <label for="">其他情况</label>
                <input type="text" name="other" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="（时间、人员）" value="<?php echo $eval_app['other']; ?>">
            </div>
        </td>
    </tr>
</table>
<script>
 $("#evalu_form").find("input").attr('disabled',true);
  $("#evalu_form").find("select").attr('disabled',true);
</script>

                    <tr >
                        <h3 style="text-align:center">佐证材料</h3>
                    </tr>
                    <tr>
                        <td>
                        <div class="photo">
                            <ul>
                                <?php if(is_array($material) || $material instanceof \think\Collection || $material instanceof \think\Paginator): if( count($material)==0 ) : echo "" ;else: foreach($material as $key=>$v): ?>
                                <li>
                                    <div class="img">
                                        <div class="cell"><img src="<?php echo $v['images']; ?>" alt="<?php echo $v['name']; ?>"></div>
                                    </div>
                                    <p><?php echo $v['name']; ?></p>
                                </li>
                                <?php endforeach; endif; else: echo "" ;endif; ?>
                            </ul>
                        </div>
                        <div class="clearfix"></div>
                        </td>
                    </tr>
                    <?php if($user['group_opinion']): ?>
                    <tr>
                        <td colspan="11" class="tab_content">
                            <p class="tab_left">班级评定小组意见</p>
                            <textarea class="tab_opinion" disabled><?php echo $user['group_opinion']['text']; ?></textarea>
                            <div class="clearfix"></div>
                            <div class="tab_time">
                                <input type="text" value="<?php echo date('Y',$user['group_opinion']['time']); ?>" disabled>年
                                <input type="text" value="<?php echo date('n',$user['group_opinion']['time']); ?>" disabled>月
                                <input type="text" value="<?php echo date('d',$user['group_opinion']['time']); ?>" disabled>日
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </table>
                <form action="<?php echo url('admin/EvaluationHandle/faculty'); ?>" method="post" id="passingForm" class="passingForm">
                <table class="w800">
                     <tr>
                        <td class="tab_title"><p class=" tab_left" style="font-size: 16px;">院系小组添加评语：</p></td>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="tab_content">
                            <?php if(!in_array($user['evaluation_status'],[3,9])): ?>
                            <textarea name="faculty_opinion[text]" class="tab_opinion"><?php echo $user['faculty_opinion']['text']; ?></textarea>
                            <?php else: ?>
                            <select class="form-control tab_select" name="faculty_opinion[text]">
                                <?php foreach(\think\Config::get('eval_opinion2') as $k => $v): ?>
                                <option value="<?php echo $v; ?>"><?php echo $v; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php endif; ?>
                            <!--
                            <div class="modify pull-left">
                                <p>院系小组修改评分：</p>
                                <div class="modify_score">
                                    <button type="button" class="modify_less btn"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                    <input type="text" name="change_fraction" class="modify_num" value="<?php echo $user['change_fraction']; ?>">
                                    <button type="button" class="modify_add btn"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                </div>
                            </div>
                            <div class="tab_sign">
                                <label>院系小组负责人签名：</label>
                                <input type="text" name="faculty_opinion[name]" value="<?php echo $user['faculty_opinion']['name']; ?>" >
                            </div>
                            <div class="clearfix"></div>
                            <div class="tab_time">
                                <input type="text" name="faculty_opinion[year]" value="<?php echo date('Y',$user['faculty_opinion']['time']); ?>">年
                                <input type="text" name="faculty_opinion[month]" value="<?php echo date('n',$user['faculty_opinion']['time']); ?>">月
                                <input type="text" name="faculty_opinion[day]" value="<?php echo date('d',$user['faculty_opinion']['time']); ?>">日
                            </div>
                            -->
                        </td>
                    </tr>

                    <tr>
                        <td colspan="3" style="height: 30px;"></td>
                    </tr>
                    <tr>
                        <td style="width: 266px;"></td>
                        <td class="tab_content" style="width: 266px;">
                            <input type="hidden" name="evaluation_id" value="<?php echo $user['evaluation_id']; ?>">
                            <input type="hidden" name="status_id" value="<?php echo $status_id; ?>">
                            <!-- <a href="<?php echo url('admin/Counselor/showEvaluationEvidence',['id'=>$user['evaluation_id']]); ?>" target="_blank" class="btn btn-info">查看相关证明</a> -->
                            <button type="submit" class="btn btn-success" name="pass">通过</button>
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
<?php if(!in_array($user['evaluation_status'],[3,9])): ?>
<script>
$("#passingForm").find("textarea").attr('disabled',true);
$("#passingForm").find("input").attr('disabled',true);
$("#passingForm").find("select").attr('disabled',true);
$("#passingForm").find("button").attr('disabled',true);
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
