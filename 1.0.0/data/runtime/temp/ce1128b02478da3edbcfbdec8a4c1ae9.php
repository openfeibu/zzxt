<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:79:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/\evaluation\personal_front.html";i:1504168698;s:88:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\header\nav_membership_header.html";i:1504001484;s:85:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/evaluation\evaluation_info_table.html";i:1504187338;s:66:"D:\UPUPW_K2.1\htdocs\zzxt/app/home/view/default/public\footer.html";i:1504001484;}*/ ?>
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
		<?php if($is_eval_app): ?>
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
            <tr>
                <td colspan="2" style="padding: 10px">
                    年级班级（专业）<input type="text" style="border-bottom:1px solid #555555;display:inline-block;width: auto" value="<?php echo $user_info['current_grade']; ?><?php echo $user_info['profession']; ?><?php echo $user_info['class']; ?>" disabled>
                </td>
                <td colspan="1">

                </td>
            </tr>
            <tr>
                <td style="padding: 5px">
                    院（系）<input type="text" placeholder="（高校学生填写）" style="border-bottom:1px solid #555555;width: auto" value="<?php echo $user_info['department_name']; ?>" disabled>
                </td>
                <td style="padding: 5px">
                    宿舍<input type="text" placeholder="（高校学生填写）" style="border-bottom:1px solid #555555;width: auto" value="">
                </td>
                <td style="padding: 5px">
                    学号<input type="text" placeholder="（高校学生填写）" style="border-bottom:1px solid #555555;width: auto" value="<?php echo $user_info['studentid']; ?>" disabled>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <table width="800px" class="k-w-table line_table">
            <tbody>
            <tr class="line-table-height">
                <td rowspan="8" style="width: 40px;">学生基本情况</td>
                <td class="k-s-content title" style="text-align: center;">姓名</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user_info['studentname']; ?>" disabled/></td>
                <td class="k-s-content title">性别</td>
                <td class="k-s-content content"><input type="text" name="sex"  value="<?php echo $user_info['sex']; ?>" disabled/></td>
                <td class="k-s-content title">民族</td>
                <td class="k-s-content content"><input type="text" name="nation"  value="<?php echo $user_info['nation']; ?>" disabled/></td>
                <td class="k-s-content title">出生年月</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="date"  value="<?php echo $user_info['date']; ?>" disabled/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">身份证号</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="date"  value="<?php echo $user_info['id_number']; ?>" disabled/></td>
                <td colspan="3" class="k-s-content title">户口（转入学校户口的学生填写入学前户口）</td>
                <td colspan="3" class="k-s-content content">
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="account" style="height:auto;width: auto;margin-right: 5px;"value="0"  <?php if($user_info['is_rural_student']=='否'): ?> checked <?php endif; ?>/>城镇
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="account" style="height:auto;width: auto;margin-right: 5px;"value="1"  <?php if($user_info['is_rural_student']=='是'): ?> checked <?php endif; ?>/>农村
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td rowspan="4" class="k-s-content title">家庭情况</td>
                <td class="k-s-content title">家庭人口数</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="population"  value="<?php echo $eval_app['population']; ?>"></td>
                <td colspan="2" class="k-s-content title">家庭成员在学人数</td>
                <td colspan="3" class="k-s-content content" ><input type="text" name="school_population"  value="<?php echo $eval_app['school_population']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="9" class="k-s-content title" style="text-align: left;padding-left:20px;">
                    1.建档立卡户
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="establish_card" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['establish_card'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                        </label>
                        <input type="radio" name="establish_card" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['establish_card'] == 0): ?>checked<?php endif; ?>/>否
                    </div>
                    2.特困供养人员
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="special_person" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['special_person'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="special_person" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['special_person'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    3.城乡最低生活保障户
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="mini_living" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['mini_living'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="mini_living" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['mini_living'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td colspan="9" class="k-s-content title" style="text-align: left;padding-left:20px;">
                    4.特困职工子女
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="poor_children" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['poor_children'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="poor_children" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['poor_children'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    5.城镇低收入困难家庭
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="low_income" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['low_income'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="low_income" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['low_income'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    6.孤儿
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="orphan" style="height:auto;width: auto;margin-right: 5px;" value="1" value="1" <?php if($eval_app['orphan'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="orphan" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['orphan'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td colspan="9" class="k-s-content title" style="text-align: left;padding-left:20px;">
                    7.父母一方抚养
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="single_parent" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['single_parent'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="single_parent" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['single_parent'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    8.烈士子女、因公牺牲军人警察子女
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="martyrs_children" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['martyrs_children'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="martyrs_children" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['martyrs_children'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td rowspan="2" class="k-s-content ltitle">健康状况</td>
                <td class="k-s-content content" colspan="9">
                    1.残疾
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['disability'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['disability'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    2.患重大疾病
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="suffering" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['suffering'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="suffering" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['suffering'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content content" colspan="9">
                    如是残疾，请选择类别：
					<?php foreach($eval_form['disability_type'] as $key => $val): ?>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability_type" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['disability_type']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                    <input type="text" name="disability_type_other" style="border-bottom:1px solid #555555;width: auto;height: auto;" value="<?php echo $eval_app['disability_type_other']; ?>">
                    <br>残疾等级：
					<?php foreach($eval_form['disability_grade'] as $key => $val): ?>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability_grade" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['disability_grade']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                </td>
            </tr>
            <!-- 第6行 -->
            <tr class="line-table-height">
                <td rowspan="3" class="k-s-content title" style="width: 40px;">家庭信息</td>
                <td class="k-s-content title">户籍地址</td>
                <td class="k-s-content content" colspan="9">
                    <form action="" name="form1" class="city_form">
                        <div class="infolist" style="width:55%">
                            <!--<lable>所在地区：</lable>-->
                            <div class="liststyle">
                                <span id="Province">
                                    <i>请选择省份</i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="请选择省份">请选择省份</a></li>
                                    </ul>
                                    <input type="hidden" name="cho_Province" value="请选择省份">
                                </span>
                                <span id="City">
                                    <i>请选择城市</i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="请选择城市">请选择城市</a></li>
                                    </ul>
                                    <input type="hidden" name="cho_City" value="请选择城市">
                                </span>
                                <span id="Area">
                                    <i>请选择地区</i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="请选择地区">请选择地区</a></li>
                                    </ul>
                                    <input type="hidden" name="cho_Area" value="请选择地区">
                                </span>
                            </div>
                        </div>
                    </form>
                    <div style="margin-top:10px;">
                        <label for="">户籍情况：</label>
                        <select name="residence_address_situation" id="" style="width: 200px;">
							<?php foreach($eval_form['residence_address_situation'] as $key => $val): ?>
							 <option value="<?php echo $key; ?>" <?php if($key == $eval_app['residence_address_situation']): ?>selected<?php endif; ?>><?php echo $val; ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <input type="text" class="tab_input_bottom" name="residence_address" style="margin-bottom: 5px;"  value="<?php echo $eval_app['residence_address']; ?>"/>
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">邮政编码</td>
                <td class="k-s-content content"><input type="text" name="zip_code" value="<?php echo $eval_app['zip_code']; ?>"/></td>
                <td colspan="2" class="k-s-content title">联系电话</td>
                <td class="k-s-content content"><input type="text" name="number" value="<?php echo $eval_app['number']; ?>"/></td>
                <td colspan="2" class="k-s-content title">家庭人均年收入</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="annual_income"  class="number" value="<?php echo $eval_app['annual_income']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="1" class="k-s-content title">住房情况</td>
                <td colspan="5" class="k-s-content content">
					<?php foreach($eval_form['housing_situation'] as $key => $val): ?> 
					<div style="display:inline-block;">
                        <label>
                            <input type="radio" name="housing_situation" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['housing_situation']): ?>checked<?php endif; ?>/ ><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                    <input type="text" name="housing_situation_other" style="width: auto;height: auto;border-bottom:1px solid #555555;" value="<?php echo $eval_app['housing_situation_other']; ?>">
                </td>
                <td colspan="1" class="k-s-content title">购车情况</td>
                <td colspan="3" class="k-s-content content">
					<?php foreach($eval_form['car_situation'] as $key => $val): ?> 
					<div style="display:inline-block;">
                        <label>
                            <input type="radio" name="car_situation" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['car_situation']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                </td>
            </tr>
            <tr class="line-table-height">
                <td rowspan="11" class="k-s-content title" style="width: 40px;">家庭成员情况（直系亲属，含祖父母）</td>
                <td class="k-s-content title" style="width: 70px;">姓名</td>
                <td class="k-s-content title" style="width: 70px;">年龄</td>
                <td class="k-s-content title" style="width: 70px;">与学生关系</td>
                <td colspan="2" class="k-s-content title">工作（学习）单位</td>
                <td class="k-s-content title" style="width: 70px;">联系电话</td>
                <td class="k-s-content title" style="width: 70px;">从业情况</td>
                <td class="k-s-content title" style="width: 70px;">文化程度</td>
                <td class="k-s-content title" style="width: 70px;">年收入（元）</td>
                <td class="k-s-content title" style="width: 70px;">健康状况</td>
            </tr>
			
			<?php $__FOR_START_12941__=1;$__FOR_END_12941__=8;for($i=$__FOR_START_12941__;$i < $__FOR_END_12941__;$i+=1){ if($eval_app['members']['name'][$i-1]): ?>
			 <tr class="line-table-height">
                <td class="k-s-content content"><input type="text" name="members[name][]" value="<?php echo $eval_app['members']['name'][$i-1]; ?>"></td>
                <td class="k-s-content content"><input type="text" name="members[age][]" value="<?php echo $eval_app['members']['age'][$i-1]; ?>" class="number"></td>
                <td class="k-s-content content">
					<?php echo $eval_form['relationship'][$eval_app['members']['relationship'][$i-1]]; ?>
                </td>
                <td colspan="2" class="k-s-content content"><input type="text" name="members[unit][]" value="<?php echo $eval_app['members']['unit'][$i-1]; ?>"></td>
                <td class="k-s-content content"><input type="text" name="members[number][]"  value="<?php echo $eval_app['members']['number'][$i-1]; ?>"></td>
                <td class="k-s-content content">
					<?php echo $eval_form['career'][$eval_app['members']['career'][$i-1]]; ?>
				</td>
                <td class="k-s-content content">
					<?php echo $eval_form['culture'][$eval_app['members']['culture'][$i-1]]; ?>
				</td>
                <td class="k-s-content content"><input type="text" name="members[income][]" class="number" value="<?php echo $eval_app['members']['income'][$i-1]; ?>"></td>
                <td class="k-s-content content">              
					<?php echo $eval_form['handicap'][$eval_app['members']['handicap'][$i-1]]; ?><br>           
					<?php echo $eval_form['health'][$eval_app['members']['health'][$i-1]]; ?>
                </td>
            </tr>
			<?php endif; } ?>


            <tr class="line-table-height">
                <td class="k-s-content title">影响家庭紧急状况有关信息</td>
                <td colspan="10" class="k-s-content content" style="text-align:left;">
                    <div style="padding: 5px;">
                        <label for="">家庭主要收入来源类型</label>
                        <input type="text" name="income_source" style="width: auto;border-bottom: 1px solid #555555;" placeholder="主要收入来源" value="<?php echo $eval_app['income_source']; ?>">
                    </div>
                    <p>
                        （只能选填其中一项。<br>
                        1.<u>工资、奖金、津贴、补贴和其他劳动收入</u>；
                        2.<u>离退休金、基本养老金、基本生活费、失业保险金</u>；
                        3.<u>继承、接受赠予、出租或出售家庭财产获得的收入</u>；
                        4.<u>存款及利息，有价证券及红利、股票、博彩收入</u>；
                        5.<u>经商、办厂以及从事种植业、养殖业、加工业扣除必要成本后的收入</u>；
                        6.<u>赡养费、抚(扶)养费</u>；
                        7.<u>自谋职业收入</u>；
                        8.<u>其他应当计入家庭的收入</u>）
                    </p>
                    <div style="padding: 5px;">
                        <label for="">学生已获资助情况</label>
                        <input type="text" name="funded" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="时间、受资助的具体项目、受助金额人民币元" value="<?php echo $eval_app['funded']; ?>">
                    </div>
                    <p><strong>（如无以下情形，只需填写“无”）：</strong></p>
                    <div style="padding: 5px;">
                        <label for="">家庭遭受自然灾害情况</label>
						<select name="members[natural_disasters_type][]" id="">
							<?php foreach($eval_form['natural_disasters_type'] as $key => $val): ?> 
								<option value="<?php echo $key; ?>" <?php if($key == $eval_app['natural_disasters_type']): ?>selected<?php endif; ?>><?php echo $val; ?></option>
							<?php endforeach; ?>
						</select>
                        <input type="text" name="natural_disasters" style="width: 60%;border-bottom: 1px solid #555555;" placeholder="（时间最近两年内发生、损失金额、人员伤亡等具体描述）" value="<?php echo $eval_app['natural_disasters']; ?>">
                    </div>
                    <div style="padding: 5px;">
                        <label for="">家庭遭受突发意外事件</label>
						<select name="members[unexpected_events_type][]" id="">
							<?php foreach($eval_form['unexpected_events_type'] as $key => $val): ?> 
								<option value="<?php echo $key; ?>" <?php if($key == $eval_app['unexpected_events_type']): ?>selected<?php endif; ?>><?php echo $val; ?></option>
							<?php endforeach; ?>
						</select>
                        <input type="text" name="unexpected_events" style="width: 60%;border-bottom: 1px solid #555555;" placeholder="（时间最近两年内发生、损失金额、人员伤亡等具体描述）" value="<?php echo $eval_app['unexpected_events']; ?>">
                    </div>
                    <div style="padding: 5px;">
                        <label for="">家庭欠债情况</label>
                        <input type="text" name="debt" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="（时间、原因、金额人民币元）" value="<?php echo $eval_app['debt']; ?>">
                    </div>
                    <div style="padding: 5px;">
                        <label for="">其他情况</label>
                        <input type="text" name="other" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="（时间、人员）" value="<?php echo $eval_app['other']; ?>">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>

		<?php else: ?>
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
            <tr>
                <td colspan="2" style="padding: 10px">
                    年级班级（专业）<input type="text" style="border-bottom:1px solid #555555;display:inline-block;width: auto" value="<?php echo $user_info['professional_cetegory']; ?><?php echo $user_info['class']; ?>" disabled>
                </td>
                <td colspan="1">

                </td>
            </tr>
            <tr>
                <td style="padding: 5px">
                    院（系）<input type="text" placeholder="（高校学生填写）" style="border-bottom:1px solid #555555;width: auto" value="<?php echo $user_info['department_name']; ?>" disabled>
                </td>
                <td style="padding: 5px">
                    宿舍<input type="text" placeholder="（高校学生填写）" style="border-bottom:1px solid #555555;width: auto" value="">
                </td>
                <td style="padding: 5px">
                    学号<input type="text" placeholder="（高校学生填写）" style="border-bottom:1px solid #555555;width: auto" value="<?php echo $user_info['studentid']; ?>" disabled>
                </td>
            </tr>
            </tbody>
        </table>
        <br>
        <table width="800px" class="k-w-table line_table">
            <tbody>
            <tr class="line-table-height">
                <td rowspan="8" style="width: 40px;">学生基本情况</td>
                <td class="k-s-content title" style="text-align: center;">姓名</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="name" value="<?php echo $user_info['studentname']; ?>" disabled/></td>
                <td class="k-s-content title">性别</td>
                <td class="k-s-content content"><input type="text" name="sex"  value="<?php echo $user_info['sex']; ?>" disabled/></td>
                <td class="k-s-content title">民族</td>
                <td class="k-s-content content"><input type="text" name="nation"  value="<?php echo $user_info['nation']; ?>" disabled/></td>
                <td class="k-s-content title">出生年月</td>
                <td colspan="2" class="k-s-content content"><input type="text" name="date"  value="<?php echo $user_info['date']; ?>" disabled/></td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">身份证号</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="date"  value="<?php echo $user_info['id_number']; ?>" disabled/></td>
                <td colspan="3" class="k-s-content title">户口（转入学校户口的学生填写入学前户口）</td>
                <td colspan="3" class="k-s-content content">
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="account" style="height:auto;width: auto;margin-right: 5px;"value="0"  <?php if($user_info['is_rural_student']=='否'): ?> checked <?php endif; ?> disabled />城镇
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="account" style="height:auto;width: auto;margin-right: 5px;"value="1"  <?php if($user_info['is_rural_student']=='是'): ?> checked <?php endif; ?> disabled />农村
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td rowspan="4" class="k-s-content title">家庭情况</td>
                <td class="k-s-content title">家庭人口数</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="population"  value="<?php echo $eval_app['population']; ?>"></td>
                <td colspan="2" class="k-s-content title">家庭成员在学人数</td>
                <td colspan="3" class="k-s-content content" ><input type="text" name="school_population"  value="<?php echo $eval_app['school_population']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="9" class="k-s-content title" style="text-align: left;padding-left:20px;">
                    1.建档立卡户
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="establish_card" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['establish_card'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                        </label>
                        <input type="radio" name="establish_card" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['establish_card'] == 0): ?>checked<?php endif; ?>/>否
                    </div>
                    2.特困供养人员
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="special_person" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['special_person'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="special_person" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['special_person'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    3.城乡最低生活保障户
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="mini_living" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['mini_living'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="mini_living" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['mini_living'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td colspan="9" class="k-s-content title" style="text-align: left;padding-left:20px;">
                    4.特困职工子女
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="poor_children" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['poor_children'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="poor_children" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['poor_children'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    5.城镇低收入困难家庭
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="low_income" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['low_income'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="low_income" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['low_income'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    6.孤儿
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="orphan" style="height:auto;width: auto;margin-right: 5px;" value="1" value="1" <?php if($eval_app['orphan'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="orphan" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['orphan'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td colspan="9" class="k-s-content title" style="text-align: left;padding-left:20px;">
                    7.父母一方抚养
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="single_parent" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['single_parent'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="single_parent" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['single_parent'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    8.烈士子女、因公牺牲军人警察子女
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="martyrs_children" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['martyrs_children'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="martyrs_children" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['martyrs_children'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td rowspan="2" class="k-s-content ltitle">健康状况</td>
                <td class="k-s-content content" colspan="9">
                    1.残疾
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['disability'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['disability'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                    2.患重大疾病
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="suffering" style="height:auto;width: auto;margin-right: 5px;" value="1" <?php if($eval_app['suffering'] == 1): ?>checked<?php endif; ?>/>是
                        </label>
                    </div>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="suffering" style="height:auto;width: auto;margin-right: 5px;" value="0" <?php if($eval_app['suffering'] == 0): ?>checked<?php endif; ?>/>否
                        </label>
                    </div>
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content content" colspan="9">
                    如是残疾，请选择类别：
					<?php foreach($eval_form['disability_type'] as $key => $val): ?>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability_type" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['disability_type']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                    <input type="text" name="disability_type_other" style="border-bottom:1px solid #555555;width: auto;height: auto;" value="<?php echo $eval_app['disability_type_other']; ?>">
                    <br>残疾等级：
					<?php foreach($eval_form['disability_grade'] as $key => $val): ?>
                    <div style="display:inline-block;">
                        <label>
                            <input type="radio" name="disability_grade" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['disability_grade']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                </td>
            </tr>
            <!-- 第6行 -->
            <tr class="line-table-height">
                <td rowspan="3" class="k-s-content title" style="width: 40px;">家庭信息</td>
                <td class="k-s-content title">户籍地址</td>
                <td class="k-s-content content" colspan="9">
                    <form action="" name="form1" class="city_form">
                        <div class="infolist" style="width:55%">
                            <!--<lable>所在地区：</lable>-->
                            <div class="liststyle">
                                <span id="Province">
                                    <i>请选择省份</i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="请选择省份">请选择省份</a></li>
                                    </ul>
                                    <input type="hidden" name="cho_Province" value="请选择省份">
                                </span>
                                <span id="City">
                                    <i>请选择城市</i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="请选择城市">请选择城市</a></li>
                                    </ul>
                                    <input type="hidden" name="cho_City" value="请选择城市">
                                </span>
                                <span id="Area">
                                    <i>请选择地区</i>
                                    <ul>
                                        <li><a href="javascript:void(0)" alt="请选择地区">请选择地区</a></li>
                                    </ul>
                                    <input type="hidden" name="cho_Area" value="请选择地区">
                                </span>
                            </div>
                        </div>
                    </form>
                    <div style="margin-top:10px;">
                        <label for="">户籍情况：</label>
                        <select name="residence_address_situation" id="" style="width: 200px;">
							<?php foreach($eval_form['residence_address_situation'] as $key => $val): ?>
							 <option value="<?php echo $key; ?>" <?php if($key == $eval_app['residence_address_situation']): ?>selected<?php endif; ?>><?php echo $val; ?></option>
							<?php endforeach; ?>
                        </select>
                    </div>
                    <input type="text" class="tab_input_bottom" name="residence_address" style="margin-bottom: 5px;"  value="<?php echo $eval_app['residence_address']; ?>"/>
                </td>
            </tr>
            <tr class="line-table-height">
                <td class="k-s-content title">邮政编码</td>
                <td class="k-s-content content"><input type="text" name="zip_code" value="<?php echo $eval_app['zip_code']; ?>"/></td>
                <td colspan="2" class="k-s-content title">联系电话</td>
                <td class="k-s-content content"><input type="text" name="number" value="<?php echo $eval_app['number']; ?>"/></td>
                <td colspan="2" class="k-s-content title">家庭人均年收入</td>
                <td colspan="3" class="k-s-content content"><input type="text" name="annual_income"  class="number" value="<?php echo $eval_app['annual_income']; ?>"/></td>
            </tr>
            <tr class="line-table-height">
                <td colspan="1" class="k-s-content title">住房情况</td>
                <td colspan="5" class="k-s-content content">
					<?php foreach($eval_form['housing_situation'] as $key => $val): ?> 
					<div style="display:inline-block;">
                        <label>
                            <input type="radio" name="housing_situation" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" / ><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                    <input type="text" name="housing_situation_other" style="width: auto;height: auto;border-bottom:1px solid #555555;" value="<?php echo $eval_app['housing_situation_other']; ?>">
                </td>
                <td colspan="1" class="k-s-content title">购车情况</td>
                <td colspan="3" class="k-s-content content">
					<?php foreach($eval_form['car_situation'] as $key => $val): ?> 
					<div style="display:inline-block;">
                        <label>
                            <input type="radio" name="car_situation" value="<?php echo $key; ?>" style="height:auto;width: auto;margin-right: 5px;" <?php if($key == $eval_app['car_situation']): ?>checked<?php endif; ?>/><?php echo $val; ?>
                        </label>
                    </div>
					<?php endforeach; ?>
                </td>
            </tr>
            <tr class="line-table-height">
                <td rowspan="11" class="k-s-content title" style="width: 40px;">家庭成员情况（直系亲属，含祖父母）</td>
                <td class="k-s-content title" style="width: 70px;">姓名</td>
                <td class="k-s-content title" style="width: 70px;">年龄</td>
                <td class="k-s-content title" style="width: 70px;">与学生关系</td>
                <td colspan="2" class="k-s-content title">工作（学习）单位</td>
                <td class="k-s-content title" style="width: 70px;">联系电话</td>
                <td class="k-s-content title" style="width: 70px;">从业情况</td>
                <td class="k-s-content title" style="width: 70px;">文化程度</td>
                <td class="k-s-content title" style="width: 70px;">年收入（元）</td>
                <td class="k-s-content title" style="width: 70px;">健康状况</td>
            </tr>
			
			<?php $__FOR_START_9379__=1;$__FOR_END_9379__=8;for($i=$__FOR_START_9379__;$i < $__FOR_END_9379__;$i+=1){ ?>
			 <tr class="line-table-height">
                <td class="k-s-content content"><input type="text" name="members[name][]" value=""></td>
                <td class="k-s-content content"><input type="text" name="members[age][]" class="number" value=""></td>
                <td class="k-s-content content">
                    <select name="members[relationship][]" id="">
                        <?php foreach($eval_form['relationship'] as $key => $val): ?> 
                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php endforeach; ?>
                    </select>
                </td>
                <td colspan="2" class="k-s-content content"><input type="text" name="members[unit][]" value=""></td>
                <td class="k-s-content content"><input type="text" name="members[number][]" value=""></td>
                <td class="k-s-content content">
					<select name="members[career][]" id="">
						<?php foreach($eval_form['career'] as $key => $val): ?> 
						<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
                <td class="k-s-content content">
					<select name="members[culture][]" id="">
						<?php foreach($eval_form['culture'] as $key => $val): ?> 
							<option value="<?php echo $key; ?>" ><?php echo $val; ?></option>
						<?php endforeach; ?>
					</select>
				</td>
                <td class="k-s-content content"><input type="text" name="members[income][]" class="number" value=""></td>
                <td class="k-s-content content">
                    <select name="members[handicap][]" id="">
						<?php foreach($eval_form['handicap'] as $key => $val): ?> 
                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php endforeach; ?>
                    </select>
                    <select name="members[health][]" id="" style="width: 75px;margin-top: 3px;">
						<?php foreach($eval_form['health'] as $key => $val): ?> 
                        <option value="<?php echo $key; ?>"><?php echo $val; ?></option>
						<?php endforeach; ?>
                    </select>
                </td>
            </tr>
			<?php } ?>
			
            <tr class="line-table-height">
                <td class="k-s-content title">影响家庭紧急状况有关信息</td>
                <td colspan="10" class="k-s-content content" style="text-align:left;">
                    <div style="padding: 5px;">
                        <label for="">家庭主要收入来源类型</label>
                        <input type="text" name="income_source" style="width: auto;border-bottom: 1px solid #555555;" placeholder="主要收入来源">
                    </div>
                    <p>
                        （只能选填其中一项。<br>
                        1.<u>工资、奖金、津贴、补贴和其他劳动收入</u>；
                        2.<u>离退休金、基本养老金、基本生活费、失业保险金</u>；
                        3.<u>继承、接受赠予、出租或出售家庭财产获得的收入</u>；
                        4.<u>存款及利息，有价证券及红利、股票、博彩收入</u>；
                        5.<u>经商、办厂以及从事种植业、养殖业、加工业扣除必要成本后的收入</u>；
                        6.<u>赡养费、抚(扶)养费</u>；
                        7.<u>自谋职业收入</u>；
                        8.<u>其他应当计入家庭的收入</u>）
                    </p>
                    <div style="padding: 5px;">
                        <label for="">学生已获资助情况</label>
                        <input type="text" name="funded" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="时间、受资助的具体项目、受助金额人民币元" value="<?php echo $eval_app['funded']; ?>">
                    </div>
                    <p><strong>（如无以下情形，只需填写“无”）：</strong></p>
                    <div style="padding: 5px;">
                        <label for="">家庭遭受自然灾害情况</label>
						<select name="members[natural_disasters_type][]" id="">
							<?php foreach($eval_form['natural_disasters_type'] as $key => $val): ?> 
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php endforeach; ?>
						</select>
                        <input type="text" name="natural_disasters" style="width: 60%;border-bottom: 1px solid #555555;" placeholder="（时间最近两年内发生、损失金额、人员伤亡等具体描述）" value="<?php echo $eval_app['natural_disasters']; ?>">
                    </div>
                    <div style="padding: 5px;">
                        <label for="">家庭遭受突发意外事件</label>
						<select name="members[unexpected_events_type][]" id="">
							<?php foreach($eval_form['unexpected_events_type'] as $key => $val): ?> 
								<option value="<?php echo $key; ?>"><?php echo $val; ?></option>
							<?php endforeach; ?>
						</select>
                        <input type="text" name="unexpected_events" style="width: 60%;border-bottom: 1px solid #555555;" placeholder="（时间最近两年内发生、损失金额、人员伤亡等具体描述）" value="<?php echo $eval_app['unexpected_events']; ?>">
                    </div>
                    <div style="padding: 5px;">
                        <label for="">家庭欠债情况</label>
                        <input type="text" name="debt" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="（时间、原因、金额人民币元）" value="<?php echo $eval_app['debt']; ?>">
                    </div>
                    <div style="padding: 5px;">
                        <label for="">其他情况</label>
                        <input type="text" name="other" style="width: 80%;border-bottom: 1px solid #555555;" placeholder="（时间、人员）" value="<?php echo $eval_app['other']; ?>">
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
		<?php endif; ?>
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


    <?php if($is_eval_app != 1): ?><button type="submit" class="print printHide evalu_btn">提交</button><?php endif; ?>
    <button class="print printHide" onclick="preview(1)">打印</button>
</div>
<!-- 主体内容 E -->
<script>
$(".evalu_btn").click(function(){
	 if(confirm("提交后将不能修改！确定无误提交吗？"))
	{	
		$.ajax({
			type: 'post',
			url: '<?php echo url('home/show/evaluation_application'); ?>',
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
<?php if($is_eval_app == 1): ?>
<script>
 $("#evalu_form").find("input").attr('disabled',true);
  $("#evalu_form").find("select").attr('disabled',true);
</script>
<?php endif; ?>


<!--<img id="studentPicture_herf_show" style="width: 125px; height: 175px; display: inline;" src="images/defaultGraph.jpg" height="175px" width="125px">-->
<!--<input type="file" class="upload" value="" style="width:100%;height:100%;position:absolute;top:0;left:0;opacity:0;cursor:pointer;">-->
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

