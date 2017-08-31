<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:77:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/\evaluation\evalu_status.html";i:1503813473;s:82:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\personal_header.html";i:1503836877;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1503885760;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="default"/>
    <meta content="telephone=no" name="format-detection"/>
    <meta name="screen-orientation" content="portrait">
    <meta name="x5-orientation" content="portrait">
    <title>个人中心-学生资助管理系统</title>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <link rel="stylesheet" href="__PUBLIC__/ace/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />
    <link rel="stylesheet" href="__PUBLIC__/ace/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $yf_theme_path; ?>public/css/css.css">
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/jquery1.11.3.js"></script>
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/main.js"></script>

</head>
<style type="text/css" media=print>
    .printHide{display : none }
    .print-page-break{page-break-after: always;}+
</style>
<body>
<div class="personal_header printHide w1000">
    <div class="personal_logo">
        学生资助管理系统
    </div>
    <div class="personal_r">
        <span class="nowtime"></span>

        <p>欢迎你,<?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?><a href="<?php echo url('home/Login/logout'); ?>">退出系统</a></p>
    </div>
</div>


<div class="nav printHide">
    <ul class="w1000">
        <li><a href="<?php echo url('/home/examineStatus'); ?>">首页</a></li>
        <li><a href="<?php echo url('/personal'); ?>">信息管理</a></li>
        <li><a href="<?php echo url('/material'); ?>">佐证材料</a></li>
        <li class=" active"><a href="<?php echo url('/evalu_status'); ?>">审核状态</a></li>
        <li><a href="<?php echo url('/home/show/evalu_notice'); ?>">通知公告</a></li>
    </ul>
</div>
<!-- 主体内容 S -->

<div class="main w1000" style="background:#fff;">
    <div class="fb-source source_none" >
        <ul>
            <li>
                <a href="">首页</a>
                <span >-></span>
            </li>
            <li>
                <a>经济困难认定</a>
                <span >-></span>
            </li>
            <li>
                <a>审核状态</a>
                <span >-></span>
            </li>
        </ul>
    </div>
    <div class="myexam">
        <table width="800" style="margin:0 auto;border-radio:5px;">
            <tr class="line-table-height"style="font-size: 16px;" >
                <td class="k-s-content"  width="40%">审核状态</td>
                <td class="k-s-content" ><span class="review-success">已通过！</span></td>
            </tr>
        </table>
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
