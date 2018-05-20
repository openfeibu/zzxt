<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:65:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/\index.html";i:1524744660;s:89:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\header\nav_guest_header.html";i:1515387963;s:72:"D:\UPUPW_K2.1\htdocs\zzxt\1.0.0/app/home/view/default/public\footer.html";i:1515387963;}*/ ?>
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
    <!--<img src="<?php echo $yf_theme_path; ?>public/images/aiblogo.png" alt="广东农工商职业技术学院学生资助管理系统 v1.0">-->
    <p>广东农工商职业技术学院学生资助管理系统 v1.0</p>
</div>
<!-- 头部 E -->

<div class="nav-old">
    <ul class="w1000">
        <li class="active"><a href="<?php echo url('/'); ?>">首页</a></li>
        <li class=""><a href="<?php echo url('/home/Listn/showList/5'); ?>">通知公告</a></li>
        <li class=""><a href="<?php echo url('/home/Listn/showList/3'); ?>">资助新闻</a></li>
        <li class=""><a href="<?php echo url('/home/Listn/showList/6'); ?>">资助政策</a></li>
    </ul>
</div>

<!-- 主体内容 S -->
<div class="main w1000">
    <!-- 登录 -->
    <div class="login">
        <div class="login-title">资助管理系统登录</div>
        <?php if(!empty($user['member_list_id'])): ?>
        <p class="personal_name">欢迎&nbsp;&nbsp;<span><?php echo (isset($user['member_list_nickname']) && ($user['member_list_nickname'] !== '')?$user['member_list_nickname']:$user['member_list_username']); ?></span></p>
        <div class="personal_link">
            <a class="btn personal_btn" href="<?php echo url('/home/student/examinestatus'); ?>">个人中心</a>
            <a class="personal_exit" href="<?php echo url('home/Login/logout'); ?>">退出</a>
        </div>
        <?php else: ?>
        <form action="<?php echo url('home/Login/runlogin'); ?>" method="post" class="ajaxForm2">
            <div class="input-item">
                <label>身份证：</label>
                <input type="text" name="member_list_username">
            </div>
            <div class="input-item">
                <label>密码：</label>
                <input type="password" name="member_list_pwd">
            </div>
			<!-- <div class="input-item"> -->
				<!-- <label></label> -->
                <!-- <a href="<?php echo url('home/login/forgot_pwd'); ?>">忘记密码？</a> -->
            <!-- </div> -->
            <input type="submit" value="登录">
            <div class="login_error"></div>
        </form>
        <?php endif; ?>
    </div>
    <!-- 登录 -->
    <!-- 轮播图 -->
    <div class="banner">
        <ul>
            <li class="active">
                <a href="">
                    <img src="<?php echo $yf_theme_path; ?>public/images/upload.jpg" alt="">
                    <span>校园风光</span>
                </a>
            </li>
            <li>
                <a href="">
                    <img src="/data/upload/2018-01-07/5a51cf82131d7.jpg" alt="">
                    <span>校园风光</span>
                </a>
            </li>
        </ul>
        <ol>
            <li class="active"></li>
            <li></li>
        </ol>
    </div>
    <!-- 轮播图 -->
    <!-- 招生新闻 -->
    <div class="fb-portlet">
        <div class="fb-portlet-title">
            <span>资助新闻</span>
            <a href="/home/Listn/showList/3.html" class="fb-portlet-more fb-transition">更多</a>
        </div>
        <ul>
            <?php $policy=get_news("cid:3;field:n_id,news_title,news_content;limit:6;order:news_time desc",false,10,"null","");if(is_array($policy) || $policy instanceof \think\Collection || $policy instanceof \think\Paginator): $i = 0; $__LIST__ = $policy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li>
                <a href="<?php echo url('home/News/index',array('id'=>$vo['n_id'])); ?>">
                    <p><?php echo $vo['news_title']; ?></p>
                    <span><?php echo date("Y-m-d",$vo['news_time']); ?></span>
                </a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <!-- 招生新闻 -->
    <div class="portlet">

        <!-- 联系我们 -->
        <div class="fb-portlet-about">
            <div class="fb-portlet-title">
                <span>联系我们</span>
            </div>
            <?php $contact=get_news("cid:21;field:n_id,news_title,news_content;limit:8;order:news_time desc",false,10,"null","");if(is_array($contact) || $contact instanceof \think\Collection || $contact instanceof \think\Paginator): $i = 0; $__LIST__ = $contact;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <?php echo $vo['news_content']; endforeach; endif; else: echo "" ;endif; ?>
        </div>
        <!-- 联系我们 -->

        <!-- 相关链接 -->
        <div class="fb-portlet-url">
            <div class="fb-portlet-title">
                <span>相关链接</span>
            </div>
            <div class="input-item">
                <label for="">院系速览：</label>
                <select onchange="mbar(this)" name="select" style="width:120px;height:27px" >
                    <option selected="selected">----请选择----</option>

                    <option value="http://www.gdaib.edu.cn">学院主页</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj07.html">计算机系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj03.html">热作系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj05.html">外语系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj06.html">艺术系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj01.html">商务系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj02.html">管理系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj04.html">财经系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj08.html">机电系</option>

                    <option value="http://www.gdaib.edu.cn/templets/zsjy/yxjj09.html">国际交流学院</option>
                </select>
            </div>
            <div class="input-item">
                <label for="">各省招办：</label>
                <select onchange="mbar(this)" name="select" style="width:120px;height:27px">
                    <option selected="selected">----请选择----</option>

                    <option value="http://www.eeagd.edu.cn">广东省教育考试院</option>

                    <option value="http://www.gdhed.edu.cn/">广东省教育厅</option>

                </select>
            </div>
        </div>
        <!-- 相关链接 -->

    </div>

    <!-- 招生政策 -->
    <div class="fb-portlet">
        <div class="fb-portlet-title">
            <span>资助政策</span>
            <a href="<?php echo url('/policy',['id' => '6']); ?>" class="fb-portlet-more fb-transition">更多</a>
        </div>
        <ul>
            <?php $policy=get_news("cid:6;field:n_id,news_title,news_content;limit:6;order:news_time desc",false,10,"null","");if(is_array($policy) || $policy instanceof \think\Collection || $policy instanceof \think\Paginator): $i = 0; $__LIST__ = $policy;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li>
                <a href="<?php echo url('home/News/index',array('id'=>$vo['n_id'])); ?>">
                    <p><?php echo $vo['news_title']; ?></p>
                    <span><?php echo date("Y-m-d",$vo['news_time']); ?></span>
                </a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
            <!--<li><a href="<?php echo url('/policy_details'); ?>"><p>广东省家庭经济困难学生认定工作指导意见</p><span>2017-09-05</span></a></li>-->
            <!--<li><a href="<?php echo url('/policy_details'); ?>"><p>关于印发学生勤工助学管理办法（试行）的通知</p><span>2017-09-05</span></a></li>-->
            <!--<li><a href="<?php echo url('/policy_details'); ?>"><p>广东省家庭经济困难学生认定工作指导意见</p><span>2017-09-05</span></a></li>-->
            <!--<li><a href=""><p>关于印发学生勤工助学管理办法（试行）的通知</p><span>2017-09-05</span></a></li>-->
            <!--<li><a href=""><p>广东省家庭经济困难学生认定工作指导意见</p><span>2017-09-05</span></a></li>-->
            <!--<li><a href=""><p>关于印发学生勤工助学管理办法（试行）的通知</p><span>2017-09-05</span></a></li>-->
        </ul>
    </div>
    <!-- 招生政策 -->

    <!-- 通知公告 -->
    <div class="fb-portlet" style="margin-left: 15px;">
        <div class="fb-portlet-title">
            <span>通知公告</span>
            <a href="<?php echo url('/notice',['id' => '5']); ?>" class="fb-portlet-more fb-transition">更多</a>
        </div>
        <ul>
            <?php $notice=get_news("cid:5;field:n_id,news_title,news_content;limit:6;order:news_time desc",false,10,"null","");if(is_array($notice) || $notice instanceof \think\Collection || $notice instanceof \think\Paginator): $i = 0; $__LIST__ = $notice;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
            <li>
                <a href="<?php echo url('home/News/index',array('id'=>$vo['n_id'])); ?>">
                    <p><?php echo $vo['news_title']; ?></p>
                    <span><?php echo date("Y-m-d",$vo['news_time']); ?></span>
                </a>
            </li>
            <?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <!-- 通知公告 -->
    <div class="clear"></div>
    <div class="fb-seamless">
        <div class="fb-seamless-title">
            <span>校园风光</span>
        </div>
        <div class="fb-seamless-con">
            <ul>
                <?php $scenery=get_news("cid:22;field:n_id,news_title,news_content,news_img;limit:6;order:news_time desc",false,10,"null","");if(is_array($scenery) || $scenery instanceof \think\Collection || $scenery instanceof \think\Paginator): $i = 0; $__LIST__ = $scenery;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                <li><img src="<?php echo $vo['news_img']; ?>" alt=""></li>
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/2.jpg" alt=""></li>-->
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/3.jpg" alt=""></li>-->
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/4.jpg" alt=""></li>-->
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/4.jpg" alt=""></li>-->
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/4.jpg" alt=""></li>-->
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/4.jpg" alt=""></li>-->
                <!--<li><img src="<?php echo $yf_theme_path; ?>public/images/5.jpg" alt=""></li>-->
                <?php endforeach; endif; else: echo "" ;endif; ?>
            </ul>
        </div>
    </div>
</div>
<!-- 主体内容 E -->

<script>



    $(function(){
        var time = null,index=0;
        $(".banner ol li").on("click",function(){
            var i = $(this).index();
            $('.banner ul li').eq(i).fadeIn().siblings("li").fadeOut();
            $(this).addClass("active").siblings("li").removeClass("active");
            i = index;
        })
        run();
        function run (){
            time = setInterval(function(){
                i = ++index > $(".banner ol li").length-1 ? 0 : index;
                $('.banner ul li').eq(i).fadeIn().siblings("li").fadeOut();
                $(".banner ol li").eq(i).addClass("active").siblings("li").removeClass("active");
                i = index;
            },1000)
        }
        $(".banner").hover(function(){
            clearInterval(time);
        },function(){
            run();
        });
        var se_i =  $(".fb-seamless-con li").length;
        var se_t = null;
        var se_long = 0;
        $(".fb-seamless-con ul").append($(".fb-seamless-con ul").html());
        se_run();
        function se_run(){
            se_t = setInterval(function(){
                se_long += 1;
                $(".fb-seamless-con ul").css("left",-se_long);
                if(se_long >= se_i*195){
                    $(".fb-seamless-con ul").css("left",0);
                    se_long = 0;
                }
            },20)
        }
        $(".fb-seamless-con").hover(function(){
            clearInterval(se_t);
        },function(){
            se_run();
        })
    })
    function mbar(sobj){
        var docurl =sobj.options[sobj.selectedIndex].value;
        if (docurl != "") {
            open(docurl,'_blank');
            sobj.selectedIndex=0;
            sobj.blur();
        }
    }
</script>

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

