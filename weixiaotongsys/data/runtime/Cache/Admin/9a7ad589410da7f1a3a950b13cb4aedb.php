<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录</title>
	<link rel="stylesheet" href="/weixiaotong2016/tpl_admin/simpleboot/assets/css/login.css">

</head>
<style>
	.J_ajax_submit_btn {
		height: 35px;
		width: 250px;
		border: 1px solid #d3d8dc;
		box-sizing: border-box;
		margin-bottom: 9px;
		margin-left: 50px;
		-moz-border-radius: 3px;
		-webkit-border-radius: 3px;
		border-radius: 3px;
		color: #fff;
		/* padding-left: 40px; */
		background: #29C3FB;
	}
	.code_img img{
		width: 119px;
		height: 35px;
	}
	.tips_error{
		display: block;
		text-align: center;
		color: #e4393c;
	}
	.tips_success{
		display: block;
		text-align: center;
		color:#5FB878;
	}
</style>
<script>
    if (window.parent !== window.self) {
        document.write = '';
        window.parent.location.href = window.self.location.href;
        setTimeout(function () {
            document.body.innerHTML = '';
        }, 0);
    }
</script>
<body>
<div class="login">
	<div class="login_title">
		<p>智慧校园登录</p>
	</div>
	<div class="login_main">
		<div class="main_left"></div>
		<div class="main_right">
			<div class="right_title">用户登录</div>
			<form method="post" name="login" action="<?php echo U('public/dologin');?>" autoComplete="off" class="J_ajaxForm"><!--  -->
				<div class="username">
					<img src="/weixiaotong2016/tpl_admin/simpleboot/assets/images/username.png" alt="">
					<input class="input" id="J_admin_name" required name="username" type="text" placeholder="帐号名或邮箱" title="帐号名或邮箱" value="<?php echo ($_COOKIE['admin_username']); ?>"/>
				</div>
				<div class="password">
					<img src="/weixiaotong2016/tpl_admin/simpleboot/assets/images/password.png" alt="">
					<input class="input" id="admin_pwd" type="password" required name="password" placeholder="密码" title="密码" />
				</div>
				<div class="code">

					<input class="input" type="text" name="verify" placeholder="请输入验证码" />
					<div class="code_img">
						<?php echo sp_verifycode_img('length=4&font_size=25&width=238&height=50','style="cursor: pointer;" title="点击获取"');?>
					</div>
				</div>
				<!--<div class="yes_login"><a href="">登&nbsp;&nbsp;&nbsp;&nbsp;录</a></div>-->
				<div class="yes_login"><button  type="submit" name="submit" class="btn btn_submit J_ajax_submit_btn">登录</button></div>
			</form>
		</div>
	</div>
</div>

</body>
</html>
<script>
    var GV = {
        DIMAUB: "/weixiaotong2016/",
        JS_ROOT: "statics/js/",//js版本号
        TOKEN : ''	//token ajax全局
    };
</script>
<script src="/weixiaotong2016/statics/js/wind.js"></script>
<script src="/weixiaotong2016/statics/js/jquery.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/common.js"></script>
<script>
    (function(){
        document.getElementById('J_admin_name').focus();

    })();
</script>