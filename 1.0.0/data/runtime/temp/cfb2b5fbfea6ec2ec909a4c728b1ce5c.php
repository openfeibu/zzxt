<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:76:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/scholarship\scho_status.html";i:1503836877;s:86:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\scholarships_header.html";i:1503839545;s:76:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/scholarship\scho_header.html";i:1503839545;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1503885760;}*/ ?>
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
    <title>个人中心-学生资助管理系统</title>
    <meta name="Keywords" content=""/>
    <meta name="Description" content=""/>
    <link rel="stylesheet" type="text/css" href="<?php echo $yf_theme_path; ?>public/css/css.css">

    <script src="__PUBLIC__/others/jquery.min-2.2.1.js"></script>
    <!--<script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/jquery1.11.3.js"></script>-->
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/main.js"></script>

    <!--<script src="__PUBLIC__/others/jquery.form.js"></script>-->
    <script src="__PUBLIC__/layer/layer_zh-cn.js"></script>
</head>
<style type="text/css" media=print>
    .printHide{display : none }
</style>
<body>
<div class="personal_header printHide w1000">
    <div class="personal_logo">
        国家奖助学金管理系统
    </div>
    <div class="personal_r">
        <span class="nowtime"></span>
        <p>欢迎你,<?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?><a href="<?php echo url('home/Login/logout'); ?>">退出系统</a></p>
    </div>
</div>

<div class="nav printHide">
        <ul class="w1000">
            <li>
                <a href="<?php echo url('/personal'); ?>">首页</a>
            </li>
            <li <?php if('examineStatus' == ACTION_NAME): ?>class="active"<?php endif; ?>>
                <a href="<?php echo url('/home/examineStatus'); ?>">审核状态</a>
            </li>
            <li  <?php if('getGrants' == ACTION_NAME): ?>class="active"<?php endif; ?> >
                <a href="javascript:;" onclick="choose_type('3')">国家助学金</a>
            </li>
            <li <?php if('getNationalScholarship' == ACTION_NAME): ?>class="active"<?php endif; ?> id="type1">
                <a href="javascript:;" onclick="choose_type('1')">国家奖学金</a>
            </li>
            <li <?php if('getInspirational' == ACTION_NAME): ?>class="active"<?php endif; ?> id="type2">
                <a href="javascript:;" onclick="choose_type('2')">国家励志奖学金</a>
            </li>
            <li <?php if('' == ACTION_NAME): ?>class="active"<?php endif; ?> id="type1">
                <a href="<?php echo url('/notice'); ?>">系统通告</a>
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
                <a>审核状态</a>
                <span >-></span>
            </li>
        </ul>
    </div>
    <div class="myexam">
        <table width="800" style="margin:0 auto;border-radio:5px;font-size: 16px;line-height: 32px;">
            <tr class="line-table-height" style="font-size:16px;background:#438EB9;color:#fff;line-height:35px">
                <td class="k-s-content" width="40%">审核项目</td>
                <td class="k-s-content" >状态</td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content"  width="40%">国家助学金</td>
                <td class="k-s-content" >
                    <span <?php if($m_status == '未申请' || $m_status == '未通过'): ?>class="review-error" <?php elseif($m_status == '审核中'): ?>class="reviewing" <?php else: ?>class="review-success"<?php endif; ?>><?php echo $m_status; ?></span>
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content" width="40%">国家奖学金</td>
                <td class="k-s-content" >
                    <span <?php if($u_status == '未申请' || $u_status == '未通过'): ?>class="review-error" <?php elseif($u_status == '审核中'): ?>class="reviewing" <?php else: ?>class="review-success"<?php endif; ?>><?php echo $u_status; ?></span>
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content"  width="40%">国家励志奖学金</td>
                <td class="k-s-content" >
                    <span <?php if($n_status == '未申请' || $n_status == '未通过'): ?>class="review-error" <?php elseif($n_status == '审核中'): ?>class="reviewing" <?php else: ?>class="review-success"<?php endif; ?>><?php echo $n_status; ?></span>
                </td>
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
