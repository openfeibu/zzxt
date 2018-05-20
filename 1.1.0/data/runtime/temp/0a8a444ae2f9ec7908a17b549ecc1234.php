<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/\evaluation\personal_front.html";i:1526786770;s:94:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\header\nav_membership_header.html";i:1524040517;s:91:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/evaluation\evaluation_info_table.html";i:1526787263;s:72:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\footer.html";i:1515387963;}*/ ?>
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

<!-- 主体内容 S -->
<div class="main w1000" style="background:#fff;">
    <div class="fb-source source_none" >
        <ul>
            <li>
                <a href="<?php echo url('/'); ?>">首页</a>
                <span >-></span>
            </li>
            <li>
                <a>经济困难认定</a>
                <span >-></span>
            </li>
            <li>
                <a>信息管理</a>
                <span >-></span>
            </li>
        </ul>
    </div>
    <!--startprint1-->
    <div class="personal_table">
		<form name="evau_form" action="" id="evalu_form"/>

		            <table width="800px">
            <tbody>
            <tr class="printHide" style="height:30px;">
                <td colspan="2" style="border-bottom:1px solid #000000;">

                </td>
                <td colspan="1" style="text-align: right;border-bottom:1px solid #000000;">
                    <span style="font-size: 13px;color: grey;">广东农工商职业技术学院</span>
                </td>
            </tr>
            <tr>
                <td colspan="3" style="text-align: center;font-size: 25px;font-weight: bold;line-height:48px;">
                    家庭经济困难学生认定申请表
                </td>
            </tr>

        </table>
        <br>
		<table width="800px" class="k-w-table line_table">
			<tbody>
				<tr class="line-table-height">
					<td class="k-s-content title"  rowspan="4" style="width: 40px;">学生基本情况</td>
					<td class="k-s-content title" style="text-align: center;width:80px;">姓名</td>
                    <td colspan="2" class="k-s-content content" style="width:160px;"><input type="text" name="name" value="<?php echo $user_info['studentname']; ?>" disabled/></td>
                    <td class="k-s-content title" style="width: 80px;">性别</td>
                    <td class="k-s-content content" style="width: 80px;"><input type="text" name="sex"  value="<?php echo $user_info['gender']; ?>" disabled/></td>
                    <td class="k-s-content title" style="width: 80px;">出生年月</td>
                    <td class="k-s-content content" style="width: 100px;"><input type="text" name="nation"  value="<?php echo $user_info['birthday']; ?>" disabled/></td>
                    <td class="k-s-content title" style="width: 80px;">民族</td>
                    <td class="k-s-content content" style="width: 100px;"><input type="text" name="nation"  value="<?php echo $user_info['nation']; ?>" disabled/></td>
				</tr>
				<tr class="line-table-height">
                    <td class="k-s-content title" style="text-align: center;">身份证</td>
                    <td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user_info['id_number']; ?>" disabled/></td>
                    <td colspan="2" class="k-s-content title">政治面貌</td>
                    <td colspan="2" class="k-s-content content">
                        
                    </td>
                    <td class="k-s-content title">家庭人均年收入</td>
                    <td colspan="2" class="k-s-content content">
                        <input type="text" name="nation"  value="" style="width:60px;">元
                    </td>
                </tr>
				<tr class="line-table-height">
					<td class="k-s-content title" style="text-align: center;">院（系）</td>
					<td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user_info['department_name']; ?>" disabled/></td>
					<td class="k-s-content title">专业</td>
                    <td colspan="3" class="k-s-content content"><input type="text" name="sex"  value="<?php echo $user_info['class_name']; ?>" disabled/></td>
					 <td class="k-s-content title" style="width: 60px;">年级</td>
                    <td class="k-s-content content"><input type="text" name="nation"  value="<?php echo $user_info['current_grade']; ?>" disabled/></td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" style="text-align: center;">班级</td>
					<td colspan="5" class="k-s-content content"><input type="text" name="name" value="<?php echo $user_info['department_name']; ?>" disabled/></td>
					<td class="k-s-content title" style="text-align: center;width: 60px; ">联系电话</td>
                    <td colspan="2" class="k-s-content content"><input type="text" name="number" value="<?php echo $eval_app['number']; ?>"/></td>
				</tr>
				<tr class="line-table-height">
					<td class="k-s-content title" style="height:400px;">学生陈述申请认定理由</td>
					<td class="k-s-content content" colspan="9" style="text-align: left;vertical-align:top;">
						<div>
							<textarea style="width: 100%;height: 300px;"></textarea>
							<p>本人承诺以上所填内容真实无误，并予以认可，如不真实，本人愿意承担相应后果。
							</p>
							<div style="float: right;">
                                <div class="level_form">
                                    <div class="signature">
                                        <label for="">学生签字：</label>
                                        <input type="text" value="<?php echo $user_info['studentname']; ?>" disabled style="text-align:left;">
                                    </div>
                                </div>
                                <div class="level_form">
                                    <div class="level_time">
                                        <input type="text" value="" disabled>
                                        <label for="">年</label>
                                    </div>
                                    <div class="level_time">
                                        <input type="text" value="" disabled>
                                        <label for="">月</label>
                                    </div>
                                    <div class="level_time">
                                        <input type="text" value="" disabled>
                                        <label for="">日</label>
                                    </div>
                                </div>
                            </div>
							<div class="clearfix"></div>
							</p>
							<p>注：可另附详细情况说明。</p>
						</div>
					</td>
				</tr>	
			</tbody>
		</table>
        


		</form>
    </div>
    <!--endprint1-->

    <div style="width: 756px;margin:0 auto;">
        注：
        <ul>
            <li>1.本表供学生根据需要申请家庭经济困难认定用，可复印。请如实填写，到户籍所在地村委会（居委会）、乡（镇）或街道核实、盖章后，连同相关证明材料交到学校。</li>
            <li>2.家庭成员健康状况主要填写是否患重大疾病，是否残疾及等级。</li>
            <li>3.选择性项目必须填写。</li>
            <li>4.斜体字在填写时请删除。</li>
            <li>5.涂改无效。</li>
        </ul>
    </div>


    <?php if($is_eval_app != 1): ?>
	<button type="submit" class="print printHide evalu_btn">提交</button>
	<?php else: ?>
    <button class="print printHide" onclick="preview(1)">打印</button>
	<?php endif; ?>
</div>
<!-- 主体内容 E -->
<script>
$(".evalu_btn").click(function(){
	 if(confirm("提交后将不能修改！确定无误提交吗？"))
	{
		$.ajax({
			type: 'post',
			url: "<?php echo url('home/show/evaluation_application'); ?>",
			data: $("#evalu_form").serialize(),
			success: function(data) {
				if(data.code == 200)
				{
					window.location.href="<?php echo url('home/show/material'); ?>";
				}else{
					alert(data.message);
				}
			}
		});
	}
});
$('.number').keyup(function(){
    var val = $(this).val();
    if(val.length==1){
        $(this).val(val.replace(/[^1-9]/g,''));
    }else{
        $(this).val(val.replace(/\D/g,''));
    }
});
</script>
<?php if($is_eval_app == 1 && $pass_status != 9): ?>
<script>
	$("#evalu_form").find("input").attr('disabled',true);
	$("#evalu_form").find("select").attr('disabled',true);
	$("#evalu_form").find("textarea").attr('disabled',true);
</script>
<?php endif; ?>



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

