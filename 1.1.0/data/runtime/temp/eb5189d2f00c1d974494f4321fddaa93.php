<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:81:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/scholarship\scho_motiv.html";i:1523861331;s:94:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\header\nav_membership_header.html";i:1522719940;s:72:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\footer.html";i:1515387963;}*/ ?>
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
                <a href="<?php echo url('/index_front'); ?>" >首页</a>
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
            <li role="presentation" <?php if('showSurvey' == ACTION_NAME): ?>class="active"<?php endif; ?>>
                <a href="<?php echo url('/questionnaire'); ?>">调查问卷</a>
            </li>
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
                <a href="">首页</a>
                <span >-></span>
            </li>
            <li>
                <a>国家励志奖学金申请表</a>
                <span >-></span>
            </li>
        </ul>
    </div>
    <!--startprint3-->
    <form action="" method="post" enctype="multipart/form-data">
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
                    普通本科高校、高等职业学校国家励志奖学金申请表
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <table width="756px" class="k-w-table line_table">
            <tbody>
            <tr class="line-table-height gants_tab">
                <td rowspan="4" class="k-s-content title" style="width: 40px;">本人情况</td>
                <td class="k-s-content title" style="text-align: center;">姓名</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['studentname']; ?>"/></td>
                <td class="k-s-content title">性别</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['gender']; ?>"/></td>
                <td class="k-s-content title">出生年月</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['birthday']; ?>"/></td>
                <td class="k-s-content" rowspan="4" style="text-align: center;position:relative;width: 125px;">

                    <img class="test1" style="width: 125px; height: 175px; display: inline;" src="<?php echo $user['member_list_headpic']; ?>" height="175px" width="125px" alt="照片">
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title" style="text-align: center;">民族</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['nation']; ?>"/></td>
                <td class="k-s-content title">政治面貌</td>
                <td class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['political']; ?>"/></td>
                <td class="k-s-content title">学号</td>
                <td class="k-s-content content"><input type="text" name="user_id" value="<?php echo $user_info['studentid']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title" style="text-align: center;">身份证号码</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['id_number']; ?>"/></td>
                <td class="k-s-content title">联系电话</td>
                <td class="k-s-content content"><input type="text" name="tel" /></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="2" class="k-s-content title">院系、班级</td>
                <td colspan="4" class="k-s-content content"><input type="text" name="" value="<?php echo $user_info['department_name'],$user_info['class_name']; ?>"/></td>
            </tr>
            <!--家庭经济情况-->
            <tr class="line-table-height">
                <td rowspan="3" class="k-s-content title">家庭经济情况</td>
                <td class="k-s-content title" style="text-align: center;">家庭户口</td>
                <td colspan="3" class="k-s-content content">
                    <div style="display:inline-block;">
						<label>
							<input type="radio" name="family_type" value="城镇" style="height:auto;width: auto;margin-right: 5px;" <?php if($user_info['is_rural_student']=='否'): ?> checked <?php endif; ?> disabled/>城镇
						</label>
					</div>
					<div style="display:inline-block;">
						<label>
							<input type="radio" name="family_type" value="农村" style="height:auto;width: auto;margin-right: 5px;" <?php if($user_info['is_rural_student']=='是'): ?> checked <?php endif; ?> disabled/>农村
						</label>
					</div>
                </td>
                <td class="k-s-content title">家庭人口总数</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="population" value="<?php if(isset($list['population'])): ?><?php echo $list['population']; endif; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">家庭月总收入</td>
                <td class="k-s-content content"><input type="text" name="monthly_total_income" value="<?php if(isset($list['monthly_total_income'])): ?><?php echo $list['monthly_total_income']; endif; ?>"/></td>
                <td class="k-s-content title">人均月收入</td>
                <td class="k-s-content content"><input type="text" name="monthly_people_income" value="<?php if(isset($list['monthly_people_income'])): ?><?php echo $list['monthly_people_income']; endif; ?>"/></td>
                <td class="k-s-content title">收入来源</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="income_source" value="<?php if(isset($list['income_source'])): ?><?php echo $list['income_source']; endif; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">家庭住址</td>
                <td colspan="4" class="k-s-content content"><input type="text" name="address"  value="<?php if(isset($list['address'])): ?><?php echo $list['address']; endif; ?>"/></td>
                <td class="k-s-content title">邮政编码</td>
                <td colspan="1" class="k-s-content content"><input type="text" name="zip_code"  value="<?php if(isset($list['zip_code'])): ?><?php echo $list['zip_code']; endif; ?>"/></td>
            </tr>
            <!--家庭成员情况-->
            <tr class="line-table-height">
                <td rowspan="6" class="k-s-content title">家庭成员情况</td>
                <td class="k-s-content title">姓名</td>
                <td class="k-s-content title">年龄</td>
                <td class="k-s-content title">与本人关系</td>
                <td colspan="4" class="k-s-content title">工作或学习单位</td>
            </tr>
            <?php if($is_data): foreach($list['members'] as $r): ?>
                    <tr>
                        <td class="k-s-content content"><?php echo $r['name']; ?></td>
                        <td class="k-s-content content"><?php echo $r['age']; ?></td>
                        <td class="k-s-content content"><?php echo $r['relation']; ?></td>
                        <td colspan="4" class="k-s-content content"><?php echo $r['unit']; ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr class="line-table-height">
                        <td class="k-s-content content"><input type="text" name="members[0][name]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[0][age]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[0][relation]" /></td>
                        <td colspan="4" class="k-s-content content"><input type="text" name="members[0][unit]" /></td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content content"><input type="text" name="members[1][name]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[1][age]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[1][relation]" /></td>
                        <td colspan="4" class="k-s-content content"><input type="text" name="members[1][unit]" /></td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content content"><input type="text" name="members[2][name]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[2][age]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[2][relation]" /></td>
                        <td colspan="4" class="k-s-content content"><input type="text" name="members[2][unit]" /></td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content content"><input type="text" name="members[3][name]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[3][age]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[3][relation]" /></td>
                        <td colspan="4" class="k-s-content content"><input type="text" name="members[3][unit]" /></td>
                    </tr>
                    <tr class="line-table-height">
                        <td class="k-s-content content"><input type="text" name="members[4][name]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[4][age]" /></td>
                        <td class="k-s-content content"><input type="text" name="members[4][relation]" /></td>
                        <td colspan="4" class="k-s-content content"><input type="text" name="members[4][unit]" /></td>
                    </tr>
                    <?php endif; ?>
            <!--学生成绩-->
            <tr class="line-table-height">
                <td colspan="8" class="k-s-content content" style="text-align: left;">
                    <label>学生成绩：</label>
                    <textarea name="achievement" class="longtext"><?php if(isset($list['achievement'])): ?><?php echo $list['achievement']; endif; ?></textarea>
                </td>
            </tr>
            <!--申请理由-->
            <tr class="line-table-height">
                <td colspan="8" class="k-s-content content" style="text-align: left;">
                    <label>申请理由：</label>
                    <textarea name="reason" id="" class="longtext"><?php echo $list['reason']; ?></textarea>
                    <div style="float: right;">
                        <div class="level_form">
                            <div class="signature">
                                <label for="">申请人签名：</label>
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
    <!--endprint3-->
    <?php if(!$is_data): ?>
	<button class="print printHide" type="submit" >提交</button>
	<?php endif; ?>
    <button class="print printHide" onclick="preview(3)">打印</button>
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

