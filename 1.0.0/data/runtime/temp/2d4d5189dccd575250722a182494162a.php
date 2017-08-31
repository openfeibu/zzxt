<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:78:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/\home_page\policy_details.html";i:1504001484;s:83:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\nav_guest_header.html";i:1504001484;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1504001484;}*/ ?>
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

    <script src="__PUBLIC__/others/jquery.form.js"></script>
    <script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
    <script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
</head>
<body>
<!-- 头部 S -->
<div class="header w1000">
    <!--<img src="<?php echo $yf_theme_path; ?>public/images/aiblogo.png" alt="广东农工商职业技术学院学生资助管理系统">-->
    <p>广东农工商职业技术学院学生资助管理系统</p>
</div>
<!-- 头部 E -->

<div class="nav-old">
    <ul class="w1000">
        <li class=""><a href="<?php echo url('/index_front'); ?>">首页</a></li>
        <li class=""><a href="<?php echo url('/home/Listn/showList/5'); ?>">通知公告</a></li>
        <li class=""><a href="<?php echo url('/home/Listn/showList/3'); ?>">资助新闻</a></li>
        <li class="active"><a href="<?php echo url('/home/Listn/showList/6'); ?>">资助政策</a></li>
    </ul>
</div>
<!-- 导航 -->
<!--<div class="nav">-->
    <!--<ul class="w1000">-->
        <!--<li class=""><a href="<?php echo url('/index_front'); ?>">首页</a></li>-->
        <!--<li class=""><a href="<?php echo url('/home/Listn/showList/5'); ?>">通知公告</a></li>-->
        <!--<li class=""><a href="<?php echo url('/home/Listn/showList/3'); ?>">资助新闻</a></li>-->
        <!--<li class="active"><a href="<?php echo url('/home/Listn/showList/6'); ?>">资助政策</a></li>-->
    <!--</ul>-->
<!--</div>-->
<!-- 导航 -->
<!-- 主体内容 S -->
<div class="main w1000">
    <div class="fb-source">
        <ul>
            <li>
                <a href="">首页</a>
                <span >-></span>
            </li>
            <li>
                <a>资助政策</a>
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
