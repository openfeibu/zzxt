<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:69:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/work_study\index.html";i:1503998419;s:88:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\nav_membership_header.html";i:1503998419;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1503885760;}*/ ?>
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
<div class="header w1000">
    <!--<img src="<?php echo $yf_theme_path; ?>public/images/aiblogo.png" alt="广东农工商职业技术学院学生资助管理系统">-->
    <p>广东农工商职业技术学院学生资助管理系统</p>
</div>
<!-- 头部 E -->
<div class="container-fluid nav-bg printHide" >
    <nav class="w1000 ">
        <ul class="nav nav-tabs">
            <li  role="presentation" class="active"><a href="<?php echo url('/index_front'); ?>" >首页</a></li>
            <li  role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >家庭经济困难认定<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('/personal'); ?>">信息管理</a></li>
                    <li><a href="<?php echo url('/material'); ?>">佐证材料</a></li>
                </ul>
            </li>
            <li  role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >国家三金申请<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li <?php if('getGrants' == ACTION_NAME): ?>class="active"<?php endif; ?>>
                        <a  href="javascript:;" onclick="chooseType('1')">国家助学金</a>
                    </li>
                    <li <?php if('getInspirational' == ACTION_NAME): ?>class="active"<?php endif; ?> id="type2">
                        <a href="<?php echo url('/home/Scholarship/chooseType/2'); ?>">国家励志奖学金</a>
                    </li>
                    <li <?php if('getNationalScholarship' == ACTION_NAME): ?>class="active"<?php endif; ?> id="type1">
                        <a href="<?php echo url('/home/Scholarship/chooseType/1'); ?>">国家奖学金</a>
                    </li>
                </ul>
            </li>
            <li  role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >勤工助学<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="<?php echo url('home/workstudy/resume'); ?>">个人简历</a></li>
                    <li><a href="<?php echo url('home/workstudy/list'); ?>">岗位申报</a></li>
                </ul>
            </li>
            <li  role="presentation"><a href="<?php echo url('/questionnaire'); ?>">调查问卷</a></li>
            <li  role="presentation"><a href="<?php echo url('/evalu_status'); ?>">审核状态</a></li>
            <li role="presentation"><a href="">通知公示</a></li>
            <li role="presentation" class="dropdown">
                <a class="dropdown-toggle" data-hover="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" >评估公示<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="">本学期助学金名单公示</a></li>
                    <li><a href="">本学期国家励志奖学金名单公示</a></li>
                    <li><a href="">本学期国家奖学金名单公示</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>
</body>
</html>

<!--<div class="nav printHide">
    <ul class="w1000">
        <li><a href="<?php echo url('/personal'); ?>">首页</a></li>
        <li class=" active"><a href="<?php echo url('home/workstudy/resume'); ?>">个人信息</a></li>
        <li><a href="<?php echo url('home/workstudy/list'); ?>">岗位申报</a></li>
        <li><a href="<?php echo url('home/workstudy/showStatusList'); ?>">申报状态</a></li>
        <li><a href="<?php echo url('/notice'); ?>">公示公告</a></li>
    </ul>
</div>-->

<!-- 主体内容 S -->
<div class="main w1000" style="background:#fff;">
    <form action="" method="post">

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
                <td class="k-s-content content"><input type="text" name="studentname" value="<?php echo $list['studentname']; ?>"/></td>
                <td class="k-s-content title">学号</td>
                <td class="k-s-content content"><input type="text" name="studentid" value="<?php echo $list['studentid']; ?>"/></td>
                <td class="k-s-content title">性别</td>
                <td class="k-s-content content"><input type="text" name="gender"value="<?php echo $list['gender']; ?>" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">系专业班级</td>
                <td class="k-s-content content"><input type="text" name="class" value="<?php echo $list['department_name']; ?><?php echo $list['profession']; ?><?php echo $list['class']; ?>"/></td>
                <td class="k-s-content title">主修课程</td>
                <td class="k-s-content content"><input type="text" name="major" value="<?php echo $list['major']; ?>"/></td>
                <td class="k-s-content title">出生日期</td>
                <td class="k-s-content content"><input type="text" name="birthday"value="<?php echo $list['birthday']; ?>" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">籍贯</td>
                <td class="k-s-content content"><input type="text" name="native"value="<?php echo $list['native']; ?>" /></td>
                <td class="k-s-content title">民族</td>
                <td class="k-s-content content"><input type="text" name="nation" value="<?php echo $list['nation']; ?>"/></td>
                <td class="k-s-content title">政治面貌</td>
                <td class="k-s-content content"><input type="text" name="political" value="<?php echo $list['political']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">身份证号</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="id_number" value="<?php echo $list['id_number']; ?>"/></td>
                <td class="k-s-content title">身高体重</td>
                <td colspan="2" class="k-s-content content">
                    <div class="ranking">
                        <input type="text" name="height"value="<?php echo $list['height']; ?>">
                        （身高/cm）
                        /
                        <input type="text" name="weight"value="<?php echo $list['weight']; ?>">
                        （体重/kg）
                    </div>
                </td>
            </tr>
            <!--联系方式-->
            <tr class="line-table-height">
                <td rowspan="2" class="k-s-content title" style="width: 40px;">联系方式</td>
                <td class="k-s-content title">微信/QQ</td>
                <td class="k-s-content content"><input type="text" name="instant_messaging" value="<?php echo $list['instant_messaging']; ?>"/></td>
                <td class="k-s-content title">家庭住址</td>
                <td class="k-s-content content"><input type="text" name="address" value="<?php echo $list['address']; ?>" /></td>
                <td class="k-s-content title">联系电话</td>
                <td class="k-s-content content"><input type="text" name="tel" value="<?php echo $list['tel']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">邮箱</td>
                <td class="k-s-content content"><input type="text" name="email" value="<?php echo $list['email']; ?>"/></td>
                <td class="k-s-content title">辅导员姓名</td>
                <td class="k-s-content content"><input type="text" name="counselor_name" value="<?php echo $list['counselor_name']; ?>"/></td>
                <td class="k-s-content title">辅导员电话</td>
                <td class="k-s-content content"><input type="text" name="counselor_tel" value="<?php echo $list['counselor_tel']; ?>"/></td>
            </tr>
            <!--获奖情况-->
            <tr class="line-table-height">
                <td class="k-s-content title">获奖情况</td>
                <td colspan="6">
                    <textarea name="awards" id="" class="longtext"><?php echo $list['awards']; ?></textarea>
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
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[0][time]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[0][name]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[0][position]" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[1][time]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[1][name]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[1][position]" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[2][time]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[2][name]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[2][position]" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[3][time]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[3][name]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[3][position]" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[4][time]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[4][name]" /></td>
                <td colspan="2" class="k-s-content content"><input type="text" name="experience[4][position]" /></td>
            </tr>
            <!--兴趣爱好-->
            <tr class="line-table-height">
                <td class="k-s-content title" style="width: 40px;">兴趣爱好</td>
                <td colspan="6" class="k-s-content content">
                    <textarea name="hobby" id="" class="longtext"><?php echo $list['hobby']; ?></textarea>
                </td>
            </tr>
            <!--自我评价-->
            <tr class="line-table-height">
                <td class="k-s-content title" style="width: 40px;">自我评价</td>
                <td colspan="6" class="k-s-content content">
                    <textarea name="self_evaluation" id="" class="longtext"><?php echo $list['self_evaluation']; ?></textarea>
                </td>
            </tr>
            <!--申请理由-->
            <tr class="line-table-height">
                <td class="k-s-content title" style="width: 40px;">申请理由</td>
                <td colspan="6" class="k-s-content content">
                    <textarea name="apply_reason" id="" class="longtext"><?php echo $list['apply_reason']; ?></textarea>
                </td>
            </tr>
            </tbody>
        </table>

    </div>
    <button type="submit" class="print printHide">提交</button>
    </form>

</div>
<script>
    if ($("textarea[name='apply_reason']").val() != '') {
        $.get("<?php echo url('home/workstudy/ajaxforresume'); ?>", function(data){
            data = JSON.parse(data)
            $.each(data,function(index, val){
                $.each(val,function(key, value){
                    $("input[name='experience["+index+"]["+key+"]']").val(value);
                })
            })
        })
    }

</script>
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
