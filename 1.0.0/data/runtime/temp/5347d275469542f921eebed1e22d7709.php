<?php if (!defined('THINK_PATH')) exit(); /*a:6:{s:69:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\operate_table\showfield.html";i:1503813358;s:57:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\base.html";i:1503813357;s:59:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\header.html";i:1503813357;s:61:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\left_nav.html";i:1503813357;s:61:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\head_nav.html";i:1503813357;s:59:"D:\UPUPW_K2.1\htdocs\zzxt/app/admin\view\public\footer.html";i:1503813357;}*/ ?>
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
        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段列表：  </label>
        <div class="col-sm-10">
            <label class="col-sm-12 no-padding-left">
                <a class="purple new-row" href="" data-toggle="modal" data-target="#myModal" title="插入到最后">
                    <i class="ace-icon fa fa-plus-circle bigger-130"></i>添加字段
                </a>
            </label>
    </div>



    <div class="row">
        <div class="col-xs-12">
            <div>
                <form id="export-form" method="post"   class="form-horizontal"  action="<?php echo url('admin/Sys/export'); ?>">
                    <table class="table table-striped table-bordered table-hover" id="dynamic-table">
                        <thead>
                        <tr>
                            <!--<th width="4%" align="center" style="text-align:center;">-->
                                <!--<label class="pos-rel">-->
                                    <!--<input class="check-all ace" id='chkAll' checked="chedked" type="checkbox" value=""  onclick='CheckAll(this.form)'>-->
                                    <!--<span class="lbl"></span>-->
                                <!--</label></th>-->
                            <th>名称</th>
                            <th class="hidden-sm hidden-xs">标题</th>
                            <th class="hidden-sm hidden-xs">类型</th>
                            <!--<th class="hidden-sm hidden-xs">创建时间</th>-->
                            <th style="border-right:#CCC solid 1px;">操作</th>
                        </tr>
                        </thead>

                        <tbody>

                        <?php foreach($list as $row): ?>
                        <tr>
                            <!--<td height="28" align="center" >-->
                                <!--<label class="pos-rel">-->
                                    <!--<input class="ids ace" checked="chedked" type="checkbox" name="tables[]" value="">-->
                                    <!--<span class="lbl"></span>-->
                                <!--</label>-->
                            <!--</td>-->
                            <td><?php echo $row['field']; ?></td>
                            <td class="hidden-sm hidden-xs"><?php echo $row['name']; ?></td>
                            <td class="hidden-sm hidden-xs"><?php echo $row['option_type']; ?></td>
                            <td>
                                <div class="hidden-sm hidden-xs action-buttons" >
                                    <a class="green"  id="" title="修改表" href="<?php echo url('/OperateTable/checkField',['field'=>$row['field']]); ?>">
                                        <i class="ace-icon fa fa-pencil bigger-130"></i>
                                    </a>
                                    <a class="red" href="<?php echo url('/OperateTable/delete',['field'=>$row['field']]); ?>" title="删除字段">
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
                                                <a href="<?php echo url('admin/Sys/optimize?tables='.$v['name']); ?>" id="optimize_<?php echo $v['name']; ?>"  class="tooltip-success" data-rel="tooltip" title="" data-original-title="优化表">
																	<span class="green">
																		<i class="ace-icon fa fa-check-circle bigger-120"></i>
																	</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="<?php echo url('admin/Sys/repair?tables='.$v['name']); ?>" id="repair_<?php echo $v['name']; ?>" class="tooltip-success" data-rel="tooltip" title="" data-original-title="修复表">
																	<span class="green">
																		<i class="ace-icon fa fa-check-square-o bigger-120"></i>
																	</span>
                                                </a>
                                            </li>

                                            <li>
                                                <a href="<?php echo url('admin/Sys/exportsql?table='.$v['name']); ?>"  class="tooltip-error" data-rel="tooltip" title="" data-original-title="备份表">
																	<span class="red">
																		<i class="ace-icon fa fa-download bigger-120"></i>
																	</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td height="50" colspan="7" align="left">&nbsp;</td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>
        </div>
    </div>

        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"
                                aria-hidden="true">×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            添加字段
                        </h4>
                    </div>
                    <div class="modal-body">
                        <!-->
                        <div class="row">
                            <form action="<?php echo url('/admin/OperateTable/addField'); ?>" method="post" id="form2">
                            <div class="col-xs-12">
                                <!--<input name="tr_index" id="tr_index" type="hidden" value="" />-->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段名：  </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="field" onKeyUp="value=value.replace(/[^\w\.\/]/ig,'')" id="model_name" onblur="auto_pk()" class="col-xs-6 col-sm-6" value="" required/>
                                        <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填，标识必须是以字母开头,字母或数字组合</span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 名称：  </label>
                                    <div class="col-sm-10">
                                        <input type="text" name="name" id="model_title" value="" class="col-xs-6 col-sm-6" required/>
                                        <span class="lbl">&nbsp;&nbsp;<span class="red">*</span>必填,可以英文和中文</span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 选项：  </label>
                                    <div class="col-sm-10">
                                        <textarea name="score"  class="col-xs-6 col-sm-6" required placeholder="选项名字|分数，所需提交的材料（多个材料用|分开）"></textarea>
                                        <span class="lbl"><span class="red">*</span>选项名字|分数，所需提交的材料（多个材料用|分开）</span><br>
                                        <span class="lbl">例如:是|100，扶贫帮扶手册|户口簿|相关证明 </span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段类型：  </label>
                                    <div class="col-sm-10">
                                        <select name="field_type"  id="field_type" class="col-xs-10 col-sm-5 selector field_type" required>
                                            <option value="">请选择字段类型</option>
                                            <option value="char" >字符型char</option>
                                            <option value="varchar">字符型varchar</option>
                                            <option value="text" >字符型text</option>
                                            <option value="nchar(MAX)" >字符型nchar(MAX)</option>
                                            <option value="ntext(MAX)" >字符型ntext(MAX)</option>
                                            <option value="nvarchar(MAX)">字符型nvarchar(MAX)</option>
                                        </select>
                                        <span class="lbl"><span class="red">*</span>必填,若选择包含（MAX）长度请填写为-1</span>
                                    </div>
                                    <div class="space-4 col-xs-12"></div>
                                </div>
                                <div id="input_length">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 字段长度：  </label>
                                        <div class="col-sm-10">
                                            <input type="field_length" value="" name="field_length" id="field_length" placeholder="输入字段长度" class="col-xs-10 col-sm-5"/><span class="lbl"></span>
                                            <span class="lbl"><span class="red">*</span>必填</span>
                                        </div>
                                    </div>
                                    <div class="space-4 col-xs-12"></div>
                                </div>
                                <div id="input_default">
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label no-padding-right" for="form-field-1"> 选项类型：  </label>
                                        <div class="col-sm-10">
                                            <select name="option_type"  id="option_type" class="col-xs-10 col-sm-5 selector field_type" required>
                                                <option value="">请选择选项类型</option>
                                                <option value="text" >文本</option>
                                                <option value="file">单文件</option>
                                                <option value="select">选择文本</option>
                                                <option value="checkbox">复选框</option>
                                                <option value="radio">单选框</option>
                                            </select>
                                            <span class="lbl"><span class="red">*</span>必填</span>
                                        </div>
                                    </div>
                                    <div class="space-4 col-xs-12"></div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="is_null"> 是否为空： </label>
                                    <div class="col-sm-10" style="padding-top:5px;">
                                        <input name="is_null" id="is_null" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox"  />
                                        <span class="lbl">&nbsp;&nbsp;默认为空</span>
                                    </div>
                                </div>
                                <div class="space-4 col-xs-12"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label no-padding-right" for="model_status"> 是否启用： </label>
                                    <div class="col-sm-10" style="padding-top:5px;">
                                        <input name="enable" id="model_status" value="1" class="ace ace-switch ace-switch-4 btn-flat" type="checkbox"  checked/>
                                        <span class="lbl">&nbsp;&nbsp;默认启用</span>
                                    </div>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary insert-field" id="queren">
                            确认
                        </button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            关闭
                        </button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    </div><!-- /.page-content -->
</div>
<script>
    $(function(){
        $("#queren").click(function () {
            var form = $("#form2").serialize();
            $.post("<?php echo url('/admin/OperateTable/addField'); ?>",form,function(data){
                if (data.code == 400) {
                    alert(data.msg)
                }
                if (data.code == 200) {
                    window.location.reload();
                }
            })
        })
    })
</script>

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
