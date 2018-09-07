<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>系统发生错误</title>
    <meta name="robots" content="noindex,nofollow" />
    <style>
        /* Base */
        *{padding: 0;margin:0;}
        body {
            color: #333;
            font: 16px Verdana, "Helvetica Neue", helvetica, Arial, 'Microsoft YaHei', sans-serif;
            margin: 0;
            padding: 0 20px 20px;
        }
        h1{
            margin: 10px 0 0;
            font-size: 28px;
            font-weight: 500;
            line-height: 32px;
        }
        h2{
            color: #4288ce;
            font-weight: 400;
            padding: 6px 0;
            margin: 6px 0 0;
            font-size: 18px;
            border-bottom: 1px solid #eee;
        }
        h3{
            margin: 12px;
            font-size: 16px;
            font-weight: bold;
        }
        abbr{
            cursor: help;
            text-decoration: underline;
            text-decoration-style: dotted;
        }
        a{
            color: #78b0f0;
            cursor: pointer;
            text-decoration: none;
        }

        .fb-error{width: 500px;margin:10% auto 0 auto;}
        .fb-error-title{font-size: 40px;color: #333333;text-align: center;margin:50px 0 30px 0;line-height: 40px;}
        .fb-error-con{font-size: 16px;color: #999;text-align: center;line-height: 40px;}
        .fb-error-button{width: 150px;height: 50px;border-radius: 5px;margin:38px auto 0 auto;background: #b14b4d;text-align: center;line-height: 50px;}
        .fb-error-button a{color: #fff;font-size: 16px;display: block;}
    </style>
</head>
<body>
    <div class="fb-error">
       <div class="fb-error-img"><img src="/public/img/error.png" alt=""></div>
	    <?php switch ($code) {?>
            <?php case 1:?>

			<div class="fb-success-title success"><?php echo(strip_tags($msg));?></div>
            <?php break;?>
            <?php case 0:?>
			<div class="fb-error-title error"><?php echo(strip_tags($msg));?></div>
            <?php break;?>
        <?php } ?>
       <div class="fb-error-con">
            <!--<p>可能原因：网络信号差；网址输入错误；该页面已被移动或删除。</p>-->
            <p>如有任何建议，请及时反馈给 网络中心</p>
       <div class="fb-error-button"><a id="href" href="<?php echo($url);?>">返回上一页(<span id="wait">3</span>s)</a></div>

    </div>

</body>
<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</html> 

