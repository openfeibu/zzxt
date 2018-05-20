<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:83:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/scholarship\scho_scholar.html";i:1524043029;s:94:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\header\nav_membership_header.html";i:1524040517;s:72:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\footer.html";i:1515387963;}*/ ?>
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

<div class="main w1000" style="background:#fff;">
    <div class="fb-source source_none" >
        <ul>
            <li>
                <a href="<?php echo url('/'); ?>">首页</a>
                <span >-></span>
            </li>
            <li>
                <a>国家奖学金申请审批表</a>
                <span >-></span>
            </li>
        </ul>
    </div>
    <!--startprint4-->
    <form action="" method="post" enctype="multipart/form-data" id="schoForm">
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
                    国家奖学金申请审批表
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <table width="756px" class="k-w-table line_table">
            <tbody>
            <tr class="line-table-height scholar_tab">
                <td rowspan="4" class="k-s-content title" style="width: 40px;">基本情况</td>
                <td class="k-s-content title" style="text-align: center;">姓名</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['studentname']; ?>"/></td>
                <td class="k-s-content title">性别</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['gender']; ?>"/></td>
                <td class="k-s-content title">出生年月</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['birthday']; ?>"/></td>
            </tr>
            <tr class="line-table-height tab_style">
                <td class="k-s-content title" style="text-align: center;">政治面貌</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['political']; ?>"/></td>
                <td class="k-s-content title">民族</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['nation']; ?>"/></td>
                <td class="k-s-content title">入学时间</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['admission_date']; ?>"/></td>
            </tr>
            <tr class="line-table-height tab_style">
                <td class="k-s-content title" style="text-align: center;">专业</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['profession']; ?>"/></td>
                <td class="k-s-content title">学制</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['school_system']; ?>"/></td>
                <td class="k-s-content title">联系电话</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="tel" /></td>
            </tr>
            <tr class="line-table-height tab_style">
                <td class="k-s-content title" style="text-align: center;">身份证号</td>
                <td colspan="6" class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['id_number']; ?>"/></td>
            </tr>
            <!--学习情况-->
            <tr class="line-table-height scholar_tab">
                <td rowspan="2" class="k-s-content title" style="width: 40px;">学习情况</td>
                <td colspan="3" class="k-s-content title" style="text-align: center;">
                    <div class="ranking">
                        成绩排名：
                        <input type="text" name="course_ranking" value="<?php if(isset($list['course_ranking'])): ?><?php echo $list['course_ranking']; endif; ?>">
                        /
                        <input type="text" name="course_total_people" value="<?php if(isset($list['course_total_people'])): ?><?php echo $list['course_total_people']; endif; ?>">
                        （名次/总人数）
                    </div>
                </td>
                <td colspan="4" class="k-s-content title">
                    实行综合考评排名：
                    <div style="display:inline-block;">
                        <label>
                            是<input type="radio" name="is_assessment" value="1" style="height:auto;width: auto;margin-right: 5px;" <?php if(isset($list['is_assessment']) && $list['is_assessment']=='1'): ?> checked <?php endif; ?> />
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            否<input type="radio" name="is_assessment" value="0" style="height:auto;width: auto;margin-right: 5px;" <?php if(isset($list['is_assessment']) && $list['is_assessment']=='0'): ?> checked <?php endif; ?>/>
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height scholar_tab">
                <td colspan="3" class="k-s-content title">
                    必修课
                    <input type="text" style="width:10%;border-bottom: 1px solid #555555;" name="compulsory_course" value="<?php if(isset($list['compulsory_course'])): ?><?php echo $list['compulsory_course']; endif; ?>" >门，
                    其中及格以上
                    <input type="text" style="width:10%;border-bottom: 1px solid #555555;" name="pass_count" value="<?php if(isset($list['pass_count'])): ?><?php echo $list['pass_count']; endif; ?>">门
                </td>
                <td colspan="4" class="k-s-content title" style="text-align: center;">
                    <div class="ranking">
                        如是，排名：
                        <input type="text" name="assessment_ranking" value="<?php if(isset($list['assessment_ranking'])): ?><?php echo $list['assessment_ranking']; endif; ?>">
                        /
                        <input type="text" name="assessment_total_people" value="<?php if(isset($list['assessment_total_people'])): ?><?php echo $list['assessment_total_people']; endif; ?>">
                        （名次/总人数）
                    </div>
                </td>
            </tr>
            <!--大学期间主要获奖情况-->
            <tr class="line-table-height">
                <td rowspan="5" class="k-s-content title">大学期间主要获奖情况</td>
                <td class="k-s-content title">日期</td>
                <td colspan="3" class="k-s-content title">奖项名称</td>
                <td colspan="3" class="k-s-content title">颁奖单位</td>
            </tr>
			<?php if($is_data): foreach($list['awards'] as $r): ?>
			<tr class="line-table-height">
				<td class="k-s-content content"><?php echo $r['date']; ?></td>
				<td class="k-s-content content" colspan="3"><?php echo $r['name']; ?></td>
				<td class="k-s-content content" colspan="3"><?php echo $r['unit']; ?></td>
            </tr>
			<?php endforeach; else: ?>
            <tr class="line-table-height">
                <td class="k-s-content content"><input type="text" name="awards[0][date]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[0][name]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[0][unit]" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content content"><input type="text" name="awards[1][date]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[1][name]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[1][unit]" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content content"><input type="text" name="awards[2][date]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[2][name]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[2][unit]" /></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content content"><input type="text" name="awards[3][date]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[3][name]" /></td>
                <td colspan="3" class="k-s-content content"><input type="text" name="awards[3][unit]" /></td>
            </tr>
			<?php endif; ?>
            <!--申请理由-->
            <tr class="line-table-height">
                <td class="k-s-content title">申请理由(200字)</td>
                <td colspan="7" class="k-s-content content" style="text-align: left;">
                    <textarea name="reason" id="" class="longtext"><?php if(isset($list['reason'])): ?><?php echo $list['reason']; endif; ?></textarea>
                    <div style="float: right;">
                        <div class="level_form">
                            <div class="signature">
                                <label for="">申请人签名（手签）：</label>
                                <input type="text" value="<?php echo $user_info['studentname']; ?>">
                            </div>
                        </div>
                        <div class="level_form">
                            <div class="level_time">
                                <input type="text" value="<?php echo date('Y',$list['time']); ?>">
                                <label for="">年</label>
                            </div>
                            <div class="level_time">
                                <input type="text" value="<?php echo date('m',$list['time']); ?>">
                                <label for="">月</label>
                            </div>
                            <div class="level_time">
                                <input type="text" value="<?php echo date('d',$list['time']); ?>">
                                <label for="">日</label>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
    <!--endprint4-->
    <div style="width: 756px;margin:0 auto;">
        <p style="font-size: 16px;font-weight: 600;">《国家奖学金申请审批表》填写说明</p>
        <ul>
            <li>1.表格为一页，正反两面，不得随意增加页数。表格填写应当字迹清晰、信息完整，不得涂改数据或出现空白项。</li>
            <li>2.表格中学习成绩、综合考评成绩排名的范围由各院系自行确定，院系、年级、专业排名均可，但必须注明评选范围的总人数。</li>
            <li>3.表格中“申请理由”栏的填写应当全面详实，能够如实反映学生学习成绩优异、社会实践、创新能力、综合素质等方面特别突出。字数控制在200字左右。</li>
            <li>4.表格上报一律使用原件，不得使用复印件。学生成绩单、获奖证书复印件等证明材料随表报送。</li>
        </ul>
    </div>


    <?php if(!$is_data): ?>
	<button class="print printHide" type="submit" id="schosubmit">提交</button>
	<?php endif; ?>
    <button class="print printHide" onclick="preview(4)">打印</button>
    </form>
</div>

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

