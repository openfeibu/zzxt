<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:92:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/\student_personal_front\personal_status.html";i:1504001484;s:88:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\nav_membership_header.html";i:1504001484;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1504001484;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="default"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title>学生资助管理系统-广东农工商职业技术学院</title>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <link rel="stylesheet" type="text/css" href="<?php echo $yf_theme_path; ?>public/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $yf_theme_path; ?>public/css/css.css">
    <script src="__PUBLIC__/others/jquery.min-2.2.1.js"></script>
    <!--<script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/jquery1.11.3.js"></script>-->
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/main.js"></script>
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/bootstrap/js/bootstrap-hover-dropdown.js"></script>

    <script src="__PUBLIC__/others/jquery.form.js"></script>
    <script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
</head>
<body>
<!-- 头部 S -->
<div class="personal_header printHide w1000">
    <div class="personal_logo">
        广东农工商职业技术学院学生资助管理系统
    </div>
    <div class="personal_r">
        <span class="nowtime"></span>
        <p>欢迎你,<?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?><a href="<?php echo url('home/Login/logout'); ?>">退出系统</a></p>
    </div>
</div>
<!-- 头部 E -->
<div class="container-fluid nav-bg printHide" >
    <nav class="w1000 ">
        <ul class="nav nav-tabs">
            <li  role="presentation" >
                <a href="<?php echo url('/index_front'); ?>" >首页</a>
            </li>
            <li  role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >家庭经济困难认定<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/personal'); ?>">信息管理</a></li>
                    <li><a href="<?php echo url('/material'); ?>">佐证材料</a></li>
                </ul>
            </li>
            <li  role="presentation"
                 <?php if('getGrants' == ACTION_NAME): ?>class="dropdown active"
                 <?php elseif('getInspirational' == ACTION_NAME): ?> class=" dropdown active"
                 <?php elseif('getNationalScholarship' == ACTION_NAME): ?>class=" dropdown active"
                 <?php else: ?>class="dropdown"
                 <?php endif; ?>>
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >三金申请<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if('getGrants' == ACTION_NAME): ?>class="active"<?php endif; ?> >
                        <a  href="javascript:;" onclick="choose_type('3')">国家助学金</a>
                    </li>
                    <li id="type2" <?php if('getInspirational' == ACTION_NAME): ?>class="active"<?php endif; ?> >
                        <a href="javascript:;" onclick="choose_type('1')">国家奖学金</a>
                    </li>
                    <li id="type1" <?php if('getNationalScholarship' == ACTION_NAME): ?>class="active"<?php endif; ?> >
                        <a href="javascript:;" onclick="choose_type('2')">国家励志奖学金</a>
                    </li>
                </ul>
                <script>
                    function choose_type(value) {
                        var url = "<?php echo url('/home/Scholarship/chooseType'); ?>";
                        var choose_type = value;
                        $.ajax({
                            url:url,
                            type:'post',
                            data:{'choose_type':choose_type},
                            success:function (data) {
                                if (data.code == 1) {
                                    window.location.href = data.url;
                                } else {
                                    layer.alert(data.msg, {icon: 5}, function (index) {
                                        layer.close(index);
                                    });
                                    return false;
                                }
                            }
                        })
                    }
                </script>
            </li>
            <li  role="presentation"
                 <?php if('index' == ACTION_NAME): ?>class="dropdown active"
                 <?php elseif('workStudyList' == ACTION_NAME): ?> class=" dropdown active"
                 <?php else: ?>class="dropdown"
                <?php endif; ?>
            >
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >勤工助学<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('home/workstudy/resume'); ?>">个人简历</a></li>
                    <li><a href="<?php echo url('home/workstudy/list'); ?>">岗位申报</a></li>
                </ul>
            </li>
            <li  role="presentation" <?php if('showSurvey' == ACTION_NAME): ?>class="active"<?php endif; ?>><a href="<?php echo url('/questionnaire'); ?>">调查问卷</a></li>
            <li  role="presentation" <?php if('examineStatus' == ACTION_NAME): ?>class="active"<?php endif; ?>><a href="<?php echo url('/personal_status'); ?>">个人中心</a></li>
            <!--<li role="presentation"><a href="">通知公示</a></li>-->
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >通知公示<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li class=""><a href="<?php echo url('home/Show/evalu_notice'); ?>">家庭经济评估公示</a></li>
                    <li class=""><a href="<?php echo url('home/show/grants_notice'); ?>">国家助学金公示</a></li>
                    <li class=""><a href="<?php echo url('home/Show/scholar_notice'); ?>">国家奖学金公示</a></li>
                    <li class=""><a href="<?php echo url('home/show/motiv_notice'); ?>">国家励志奖学金公示</a></li>
                    <li><a href="<?php echo url('/home/Listn/showList/23'); ?>">系统通知</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
</body>
</html>
<!-- 主体内容 S -->
<div class="main w1000" style="background:#fff;">
    <div class="fb-source source_none" >
        <ul>
            <li>
                <a href="">首页</a>
                <span >-></span>
            </li>
            <li>
                <a>个人中心</a>
                <span >-></span>
            </li>
        </ul>
    </div>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
                    <table  id="simple-table"  class="table table-striped table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>项目</th>
                            <th>状态</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>家庭经济困难认定</td>
                            <td >
                                <span class="<?php echo $e_class; ?>">
                                    <?php if($e_status == 1): ?>申请书已经提交
                                    <?php elseif($e_status==2): ?>辅导员通过
                                    <?php elseif($e_status==3): ?>班级小组通过
                                    <?php elseif($e_status==4): ?>院系小组通过
                                    <?php elseif($e_status==5): ?>学生处通过
                                    <?php elseif($e_status==6): ?>辅导员不通过
                                    <?php elseif($e_status==7): ?>班级小组不通过
                                    <?php elseif($e_status==8): ?>院系小组不通过
                                    <?php elseif($e_status==9): ?>学生处不通过
                                    <?php else: ?>未申请
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td >国家助学金</td>
                            <td >
                                <span class="<?php echo $m_class; ?>">
                                    <?php if($m_status == 1): ?>申请书已经提交
                                    <?php elseif($m_status==2): ?>班级小组通过
                                    <?php elseif($m_status==3): ?>院系小组通过
                                    <?php elseif($m_status==4): ?>学生处通过
                                    <?php elseif($m_status==5): ?>班级小组不通过
                                    <?php elseif($m_status==6): ?>院系小组不通过
                                    <?php elseif($m_status==7): ?>学生处不通过
                                    <?php else: ?>未申请
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td >国家励志奖学金</td>
                            <td >
                                <span class="<?php echo $u_class; ?>">
                                    <?php if($u_status == 1): ?>申请书已经提交
                                    <?php elseif($u_status==2): ?>班级小组通过
                                    <?php elseif($u_status==3): ?>院系小组通过
                                    <?php elseif($u_status==4): ?>学生处通过
                                    <?php elseif($u_status==5): ?>班级小组不通过
                                    <?php elseif($u_status==6): ?>院系小组不通过
                                    <?php elseif($u_status==7): ?>学生处不通过
                                    <?php else: ?>未申请
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td >国家奖学金</td>
                            <td >
                                <span class="<?php echo $n_class; ?>">
                                    <?php if($n_status == 1): ?>申请书已经提交
                                    <?php elseif($n_status==2): ?>辅导员通过
                                    <?php elseif($n_status==3): ?>院系小组通过
                                    <?php elseif($n_status==4): ?>学生处通过
                                    <?php elseif($n_status==5): ?>班级小组不通过
                                    <?php elseif($n_status==6): ?>院系小组不通过
                                    <?php elseif($n_status==7): ?>学生处不通过
                                    <?php else: ?>未申请
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td >勤工助学</td>
                            <td >
                                <span class="<?php echo $w_class; ?>">
                                    <?php if($w_status == 0): ?>不通过
                                    <?php elseif($w_status==1): ?>用人部门通过
                                    <?php elseif($w_status==2): ?>学生处通过
                                    <?php elseif($w_status==3): ?>录用
                                    <?php elseif($w_status==4): ?>已经有工作
                                    <?php else: ?>未申请
                                    <?php endif; ?>
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
        </div>
    </div>
</div>



<!-- 主体内容 E -->



<!-- footer S -->
<footer>
	<p>学院微博：@广东农工商学院发布@广东农工商职业技术学院</p>
	<p>粤垦路校区地址：广州市天河区粤垦路198号 增城校区地址：广州增城市中新镇风光路393号</p>
	<p class="copy">版权所有：广东农工商职业技术学院 备案号：4401060500008</p>
</footer>
<!-- footer E -->
</body>
<script>
    $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
    setInterval(function(){
        $('.nowtime').html(new Date().toLocaleString()+' 星期'+'日一二三四五六'.charAt(new Date().getDay()));
    },1000);
    $(".personal_table input").blur(function(){
	/*
		var value  = $(this).val();
		var name = $(this).attr('name');
		if($(this).hasClass("noBlur")){
			return false;
		}else{
			$.post("<?php echo url('home/show/evaluation_application'); ?>",{'name':name,'value':value},function(data){
				if($("."+name).length>0){
					$("."+name).text(value);
				}
				console.log(data);
			 });
		}
		*/
    })
</script>
<script>
    $(".pro_img").on('click','.img_close',function (e) {
        new upField($(this)).del();
    })

    $("body").on('change','.upload',function (e) {
        var field=new upField($(this));
        var maxSize=500; //kb
        var name=$(this).attr('name');
        var pic = $(this).prop('files');
        var fordata=new FormData();
        fordata.append('imgFile',pic[0]); //添加字段

        if(pic[0].size/1024>maxSize) {
            field.addErr('图片不能超过'+maxSize+'kb')
            return false;
        }
        $.ajax({
            url:'http://img2.cdn.wzdala.com:8088/upload_json_2016.asp',
            //url:'http://183.71.200.186:8084/upload_json.asp',
            type:'POST',
            dataType:'json',
            data:fordata,
            processData: false,
            contentType: false,
            error: function(){
                field.addErr('未知错误')
            },
            success: function(data){
                if(data.error==0){
                    // field.add(e.url,name);
                    $(".test1").attr("src",data.url)
                }else{

                    field.addErr(e.message);
                }
            }
        })

    })

    function upField(doc){
        var self=this;
        this.waitTime=3000;  //错误信息 显示时长
        this.doc=doc;

        this.addErr = function (message) {
            var error=this.doc.parent(".img").find('.error');
            error.html(message).show();
            setTimeout(function () {
                error.html('').hide();
            },3000)
        };

        this.add=function (img,name) {
            var template='<div class="img_close" name="'+name+'"></div>';
            template+='<img src="'+img+'" alt="">';
            this.doc.parent(".img").html(template);
            //添加input
            var input='<input name='+name+' type="hidden" value='+img+' class="up-item">';
            $("#myform").append(input);
        };
        this.del = function () {
            var img=this.doc.parent(".img");
            var name=img.find(".img_close").attr('name');
            var template='<input name="'+name+'" type="file" id="'+name+'" class="upload">';
            template+='<span>+</span>';
            template+='<div class="error"></div> ';
            img.html(template);
            $(".up-item[name="+name+"]")[0]&&$(".up-item[name="+name+"]").remove();
        };
    }
</script>

</html>
