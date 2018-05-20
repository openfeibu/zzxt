<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/\student_notice\notice_details.html";i:1504198734;s:94:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\header\nav_membership_header.html";i:1524040517;s:87:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/student_notice\notice_header.html";i:1504198734;s:72:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\footer.html";i:1515387963;}*/ ?>
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
        广东农工商职业技术学院学生资助管理系统 v1.0
    </div>
    <div class="personal_r">
        <span class="nowtime"></span>
        <p>欢迎你,<?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?>
            <a href="<?php echo url('home/Center/password'); ?>">修改密码</a>
            <a href="<?php echo url('home/Login/logout'); ?>">退出系统</a>
        </p>
    </div>
</div>
<!-- 头部 E -->
<div class="container-fluid nav-bg printHide" >
    <nav class="w1000 ">
        <ul class="nav nav-tabs">
            <li  role="presentation" >
                <a href="<?php echo url('/'); ?>" >首页</a>
            </li>

            <li role="presentation" <?php if('examineStatus' == ACTION_NAME): ?>class="active"<?php endif; ?>>
                <a href="<?php echo url('Student/examineStatus'); ?>">个人中心</a>
            </li>
            <li  role="presentation" class="dropdown">
                <a class="dropdown-toggle"   role="button" aria-haspopup="true" aria-expanded="false" >家庭经济困难认定<span class="caret"></span></a>
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
                <a class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false" >三金申请<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:;" onclick="choose_type('3')">国家助学金<span class="status_error" id="error_choose_3"></span></a>
                    </li>
                    <li>
                        <a href="javascript:;" onclick="choose_type('2')">国家励志奖学金<span class="status_error" id="error_choose_2"></span></a>
                    </li>
                    <li>
                        <a href="javascript:;" onclick="choose_type('1')">国家奖学金<span class="status_error" id="error_choose_1"></span></a>
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
                                    layer.alert(data.msg, {icon: 5});
                                    return false;
                                }
                            }
                        })
                    }
                </script>
            </li>
            <!-- <li role="presentation"
                 <?php if('index' == ACTION_NAME): ?>class="dropdown active"
                 <?php elseif('workStudyList' == ACTION_NAME): ?> class=" dropdown active"
                 <?php else: ?>class="dropdown"
                <?php endif; ?>>
                <a class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false" >勤工助学<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('home/workstudy/resume'); ?>">个人简历</a></li>
                    <li><a href="<?php echo url('home/workstudy/list'); ?>">岗位申报</a></li>
                </ul>
            </li> -->

            <li role="presentation"
                <?php if('grantsPublicity' == ACTION_NAME): ?> class="dropdown active"
                <?php elseif('motivPublicity' == ACTION_NAME): ?> class=" dropdown active"
                <?php elseif('scholarPublicity' == ACTION_NAME): ?> class=" dropdown active"
                <?php elseif('evaluPublicity' == ACTION_NAME): ?> class=" dropdown active"
                <?php elseif('showlist' == ACTION_NAME): ?> class=" dropdown active"
                <?php else: ?> class="dropdown"
                <?php endif; ?>>
                <a class="dropdown-toggle"  role="button" aria-haspopup="true" aria-expanded="false" >通知公示<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li>
                        <a href="<?php echo url('/home/Publicity/evaluPublicity'); ?>">家庭经济评估公示</a>
                    </li>
                    <li>
                        <a href="<?php echo url('/home/Publicity/grantsPublicity/1/3'); ?>">国家助学金公示</a>
                    </li>
                    <li>
                        <a href="<?php echo url('/home/Publicity/motivPublicity/1/2'); ?>">国家励志奖学金公示</a>
                    </li>
                    <li>
                        <a href="<?php echo url('/home/Publicity/scholarPublicity/1/1'); ?>">国家奖学金公示</a>
                    </li>
                    <li>
                        <a href="<?php echo url('/home/Listn/showlist/23'); ?>">系统通知</a>
                    </li>
                </ul>
            </li>
			<?php if($is_question_open): ?>
            <li role="presentation" <?php if('showSurvey' == ACTION_NAME): ?>class="active"<?php endif; ?>>
                <a href="<?php echo url('home/Survey/showSurvey'); ?>">调查问卷</a>
            </li>
			<?php endif; ?>
        </ul>
    </nav>
</div>
</body>
<script>
$("body").on("mouseover mouseout",".nav-tabs li.dropdown",function(event){  if(event.type == "mouseover"){
//鼠标悬浮
$(this).find(".dropdown-menu").stop().fadeIn(200)
}else if(event.type == "mouseout"){
  //鼠标离开
  $(this).find(".dropdown-menu").stop().fadeOut(200)
  } })

</script>
</html>


<!-- 导航 -->
<!--<div class="nav">
    <ul class="w1000">
        <li >
            <a href="<?php echo url('/index_front'); ?>">首页</a>
        </li>
        <li <?php if('evaluPublicity' == ACTION_NAME): ?>class="active"<?php endif; ?>>
            <a href="<?php echo url('/home/Publicity/evaluPublicity'); ?>">家庭经济评估公示</a>
        </li>
        <li <?php if('grantsPublicity' == ACTION_NAME): ?>class="active"<?php endif; ?>>
            <a href="<?php echo url('/home/Publicity/grantsPublicity/1/3'); ?>">国家助学金公示</a>
        </li>
        <li <?php if('motivPublicity' == ACTION_NAME): ?>class="active"<?php endif; ?>>
            <a href="<?php echo url('/home/Publicity/motivPublicity/1/1'); ?>">国家奖学金公示</a>
        </li>
        <li <?php if('scholarPublicity' == ACTION_NAME): ?>class="active"<?php endif; ?>>
            <a href="<?php echo url('/home/Publicity/scholarPublicity/1/2'); ?>">国家励志奖学金公示</a>
        </li>
        <li <?php if('showList' == ACTION_NAME): ?>class="active"<?php elseif('index' == ACTION_NAME): ?>class="active"<?php endif; ?>>
            <a href="<?php echo url('/home/Listn/showlist/23'); ?>">系统通知</a>
        </li>
    </ul>
</div>-->
<!-- 主体内容 S -->
<div class="main w1000">
    <div class="fb-source">
        <ul>
            <li>
                <a href="<?php echo url('home/Show/index_front'); ?>">首页</a>
                <span >-></span>
            </li>
            <li>
                <a href="<?php echo url('home/Listn/showlist'); ?>">系统通知</a>
                <span >-></span>
            </li>
            <li>
                <a><?php echo $news_title; ?></a>
                <span >-></span>
            </li>
        </ul>
    </div>

    <div class="details">
        <div class="details_name"><?php echo $news_title; ?></div>
        <div class="details_date">发布时间：<?php echo date("Y-m-d H:i:s",$news_time); ?></div>
        <div class="details_con">
            <p><?php echo $content; ?></p>
        </div>
        <!--<div class="details_enclosure">-->
            <!--附件：<a href="">重要通知</a>-->
        <!--</div>-->
    </div>
</div>
<!-- 主体内容 E -->



<!-- footer S -->
<footer>
	<p>学院微博：@广东农工商学院发布@广东农工商职业技术学院</p>
	<p>粤垦路校区地址：广州市天河区粤垦路198号 增城校区地址：广州增城市中新镇风光路393号</p>
	<p class="copy">版权所有：广东农工商职业技术学院 备案号：4401060500008</p>
	<p>广东农工商职业技术学院学生资助管理系统 v1.0</p>
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
