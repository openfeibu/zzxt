<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:72:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/\work\work_personal.html";i:1503813474;s:78:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\work_header.html";i:1503813361;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1503813361;}*/ ?>
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
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/jquery1.11.3.js"></script>
    <script type="text/javascript" src="<?php echo $yf_theme_path; ?>public/js/main.js"></script>
</head>
<style type="text/css" media=print>
    .printHide{display : none }
</style>
<body>
<div class="personal_header printHide w1000">
    <div class="personal_logo">
        勤工助学管理系统
    </div>
    <div class="personal_r">
        <span class="nowtime"></span>
        <p>欢迎你,<?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?><a href="<?php echo url('home/Login/logout'); ?>">退出系统</a></p>
    </div>
</div>

<div class="nav printHide">
    <ul class="w1000">
        <li><a href="<?php echo url('/personal'); ?>">首页</a></li>
        <li class=" active"><a href="<?php echo url('/work'); ?>">个人信息</a></li>
        <li><a href="<?php echo url('/job_declar'); ?>">岗位申报</a></li>
        <li><a href="<?php echo url('/job_status'); ?>">申报状态</a></li>
        <li><a href="<?php echo url('/notice'); ?>">公示公告</a></li>
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
                <a>勤工助学金</a>
                <span >-></span>
            </li>
            <li>
                <a>个人信息</a>
                <span >-></span>
            </li>
        </ul>
    </div>
    <!--startprint1-->
    <div class="personal_table">
        <table width="756px">
            <tbody>
            <tr style="height:30px;">
                <td colspan="2">

                </td>
                <td colspan="1" style="text-align: right;">
                    <span style="font-size: 13px;color: grey;">广东农工商职业技术学院</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-size: 25px;font-weight: bold;border-top:1px solid #000000;line-height:48px;">
                    勤工助学个人简历
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <table width="756px" class="k-w-table line_table">
            <tbody>
            <tr class="line-table-height work_tab">
                <td rowspan="4" class="k-s-content title" style="width: 40px;">个人信息</td>
                <td class="k-s-content title">姓名</td>
                <td class="k-s-content content"><input type="text" name="name" /></td>
                <td class="k-s-content title">学号</td>
                <td class="k-s-content content"><input type="text" name="sex" /></td>
                <td class="k-s-content title">性别</td>
                <td class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">系专业班级</td>
                <td class="k-s-content content"><input type="text" name="name" /></td>
                <td class="k-s-content title">主修课程</td>
                <td class="k-s-content content"><input type="text" name="sex" /></td>
                <td class="k-s-content title">出生日期</td>
                <td class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">籍贯</td>
                <td class="k-s-content content"><input type="text" name="name" /></td>
                <td class="k-s-content title">民族</td>
                <td class="k-s-content content"><input type="text" name="sex" /></td>
                <td class="k-s-content title">政治面貌</td>
                <td class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">身份证号</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="name" /></td>
                <td class="k-s-content title">身高体重</td>
                <td colspan="2" class="k-s-content content">
                    <div class="ranking">
                        <input type="text">
                        （身高/cm）
                        /
                        <input type="text">
                        （体重/kg）
                    </div>
                </td>
            </tr>
            <!--联系方式-->
            <tr class="line-table-height">
                <td rowspan="2" class="k-s-content title" style="width: 40px;">联系方式</td>
                <td class="k-s-content title">微信/QQ</td>
                <td class="k-s-content content"><input type="text" name="name" /></td>
                <td class="k-s-content title">家庭住址</td>
                <td class="k-s-content content"><input type="text" name="sex" /></td>
                <td class="k-s-content title">联系电话</td>
                <td class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">邮箱</td>
                <td class="k-s-content content"><input type="text" name="name" /></td>
                <td class="k-s-content title">辅导员姓名</td>
                <td class="k-s-content content"><input type="text" name="sex" /></td>
                <td class="k-s-content title">辅导员电话</td>
                <td class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <!--获奖情况-->
            <tr class="line-table-height">
                <td class="k-s-content title">获奖情况</td>
                <td colspan="6">
                    <textarea name="" id="" class="longtext"></textarea>
                </td>
            </tr>
            <!--工作经历-->
            <tr class="line-table-height">
                <td rowspan="6" class="k-s-content title" style="width: 40px;">学习经历与工作实践经历</td>
                <td colspan="2" class="k-s-content title">日期</td>
                <td colspan="2" class="k-s-content title">项目名称</td>
                <td colspan="2" class="k-s-content title">职位</td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="name" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="sex" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="name" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="sex" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="name" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="sex" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="name" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="sex" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="name" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="sex" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="nation" /></td>
            </tr>
            <!--兴趣爱好-->
            <tr class="line-table-height">
                <td class="k-s-content title" style="width: 40px;">兴趣爱好</td>
                <td colspan="6" class="k-s-content content">
                    <textarea name="" id="" class="longtext"></textarea>
                </td>
            </tr>
            <!--自我评价-->
            <tr class="line-table-height">
                <td class="k-s-content title" style="width: 40px;">自我评价</td>
                <td colspan="6" class="k-s-content content">
                    <textarea name="" id="" class="longtext"></textarea>
                </td>
            </tr>
            <!--申请理由-->
            <tr class="line-table-height">
                <td class="k-s-content title" style="width: 40px;">申请理由</td>
                <td colspan="6" class="k-s-content content">
                    <textarea name="" id="" class="longtext"></textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <button type="submit" class="print printHide">提交</button>


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
        $.post("url",function(){
        })
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
