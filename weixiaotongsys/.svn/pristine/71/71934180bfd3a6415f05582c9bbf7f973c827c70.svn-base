<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh_CN" style="overflow: hidden;">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<!-- Set render engine for 360 browser -->
<meta name="renderer" content="webkit">
<meta charset="utf-8">
<title>微校通后台管理</title>

<meta name="description" content="This is page-header (.page-header &gt; h1)">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!-- <script src=”http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js”></script> -->
<script src="http://cdn.bootcss.com/jquery/1.9.0/jquery.min.js"></script>
<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_TEACHER_STYLE');?>/theme.min.css" rel="stylesheet">
<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_TEACHER_STYLE');?>/css/newindex.css" rel="stylesheet">
<link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
<link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
<script src="http://apps.bdimg.com/libs/jquery/1.8.3/jquery.min.js"></script>
<!--[if IE 7]>
	<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
<![endif]-->
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_TEACHER_STYLE');?>/simplebootadminindex.min.css?">
<!--[if lte IE 8]>
	<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/simplebootadminindex-ie.css?" />
<![endif]-->
<style>
.navbar .nav_shortcuts .btn{margin-top: 5px;}

/*-----------------导航hack--------------------*/
.nav-list>li.open{position: relative;}
.nav-list>li.open .back {display: none;}
.nav-list>li.open .normal {display: inline-block !important;}
.nav-list>li.open a {padding-left: 7px;}
.nav-list>li .submenu>li>a {background: #fff;}
.nav-list>li .submenu>li a>[class*="fa-"]:first-child{left:20px;}
.nav-list>li ul.submenu ul.submenu>li a>[class*="fa-"]:first-child{left:30px;}
.clicklei{ background-color: #58b374; }
.leftlei{ display: none;}
.youkong{ margin-left: 0; }
/*----------------导航hack--------------------*/
</style>

<script>
//全局变量
var GV = {
	HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- 家校互动 -->
<?php $submenus=(array)json_decode($SUBMENU_CONFIG_ONE); ?>

<?php function getsubmenu($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li class="show01" style="display: none;">
						<?php if(empty($menu->items)){ ?>
							<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
								<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?>"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?> normal"></i>
								<span class="menu-text normal"><?php echo ($menu->name); ?></span>
								<b class="arrow fa fa-angle-right normal"></b>
								<i class="fa fa-reply back"></i>
								<span class="menu-text back">返回</span>
								
							</a>
							
							<ul  class="submenu">
									<?php getsubmenu1((array)$menu->items) ?>
							</ul>
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu1($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<?php if(empty($menu->items)){ ?>
							<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
								<b class="arrow fa fa-angle-right"></b>
							</a>
							<ul  class="submenu">
									<?php getsubmenu2((array)$menu->items) ?>
							</ul>
						<?php } ?>

					</li>

				<?php } ?>
<?php } ?>

<?php function getsubmenu2($submenus){ ?>
<?php foreach($submenus as $menu){ ?>
					<li>
						<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
								&nbsp;<i class="fa fa-angle-double-right"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
							</a>
					</li>

				<?php } ?>
<?php } ?>


<!-- 教务管理 -->
<?php $submenus_two=(array)json_decode($SUBMENU_CONFIG_TWO); ?>

<?php function getsubmenu_two($submenus_two){ ?>
<?php foreach($submenus_two as $menu){ ?>
					<li class="show02" style="display: none;">
						<?php if(empty($menu->items)){ ?>
							<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
								<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?>"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?> normal"></i>
								<span class="menu-text normal"><?php echo ($menu->name); ?></span>
								<b class="arrow fa fa-angle-right normal"></b>
								<i class="fa fa-reply back"></i>
								<span class="menu-text back">返回</span>
								
							</a>
							
							<ul  class="submenu">
									<?php getsubmenu_two_first((array)$menu->items) ?>
							</ul>	
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu_two_first($submenus_two){ ?>
<?php foreach($submenus_two as $menu){ ?>
					<li>
						<?php if(empty($menu->items)){ ?>
							<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
							</a>
						<?php }else{ ?>
							<a href="#" class="dropdown-toggle">
								<i class="fa fa-caret-right"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
								<b class="arrow fa fa-angle-right"></b>
							</a>
							<ul  class="submenu">
									<?php getsubmenu_two_second((array)$menu->items) ?>
							</ul>	
						<?php } ?>
						
					</li>
					
				<?php } ?>
<?php } ?>

<?php function getsubmenu_two_second($submenus_two){ ?>
<?php foreach($submenus_two as $menu){ ?>
					<li>
						<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
								&nbsp;<i class="fa fa-angle-double-right"></i>
								<span class="menu-text"><?php echo ($menu->name); ?></span>
							</a>
					</li>
					
				<?php } ?>
<?php } ?>




<!-- 教学办公 -->
	<?php $submenus_three=(array)json_decode($SUBMENU_CONFIG_THREE); ?>

	<?php function getsubmenu_three($submenus_three){ ?>
	<?php foreach($submenus_three as $menu){ ?>
	<li class="show03" style="display: none;">
		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?>"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?> normal"></i>
			<span class="menu-text normal"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right normal"></b>
			<i class="fa fa-reply back"></i>
			<span class="menu-text back">返回</span>

		</a>

		<ul  class="submenu">
			<?php getsubmenu_three_first((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>

	<?php function getsubmenu_three_first($submenus_three){ ?>
	<?php foreach($submenus_three as $menu){ ?>
	<li>
		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right"></b>
		</a>
		<ul  class="submenu">
			<?php getsubmenu_three_second((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>


	<?php function getsubmenu_three_second($submenus_three){ ?>
	<?php foreach($submenus_three as $menu){ ?>
	<li>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			&nbsp;<i class="fa fa-angle-double-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
	</li>

	<?php } ?>
	<?php } ?> 	





 

<!--视频监控-->

	<?php $submenus_five=(array)json_decode($SUBMENU_CONFIG_FIVE); ?>
	<?php function getsubmenu_five($submenus_five){ ?>
	<?php foreach($submenus_five as $menu){ ?>
	<li class="show05" style="display: none;">
		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?>"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?> normal"></i>
			<span class="menu-text normal"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right normal"></b>
			<i class="fa fa-reply back"></i>
			<span class="menu-text back">返回</span>

		</a>

		<ul  class="submenu">
			<?php getsubmenu_five_first((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>


	<?php function getsubmenu_five_first($submenus_five){ ?>
	<?php foreach($submenus_five as $menu){ ?>
	<li>

		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right"></b>
		</a>
		<ul  class="submenu">
			<?php getsubmenu_five_second((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>

	<?php function getsubmenu_five_second($submenus_five){ ?>
	<?php foreach($submenus_five as $menu){ ?>
	<li>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			&nbsp;<i class="fa fa-angle-double-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
	</li>

	<?php } ?>
	<?php } ?>

<!--成长档案-->
	<?php $submenus_six=(array)json_decode($SUBMENU_CONFIG_SIX); ?>

	<?php function getsubmenu_six($submenus_six){ ?>
	<?php foreach($submenus_six as $menu){ ?>
	<li class="show06" style="display: none;">
		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?>"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?> normal"></i>
			<span class="menu-text normal"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right normal"></b>
			<i class="fa fa-reply back"></i>
			<span class="menu-text back">返回</span>

		</a>

		<ul  class="submenu">
			<?php getsubmenu_six_first((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>

	<?php function getsubmenu_six_first($submenus_six){ ?>
	<?php foreach($submenus_six as $menu){ ?>
	<li>
		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right"></b>
		</a>
		<ul  class="submenu">
			<?php getsubmenu_six_second((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>


	<?php function getsubmenu_six_second($submenus_six){ ?>
	<?php foreach($submenus_six as $menu){ ?>
	<li>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			&nbsp;<i class="fa fa-angle-double-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
	</li>

	<?php } ?>
	<?php } ?> 





	<!-- 校网 -->
	<?php $submenus_seven=(array)json_decode($SUBMENU_CONFIG_SEVEN); ?>
	<?php function getsubmenu_seven($submenus_seven){ ?>
	<?php foreach($submenus_seven as $menu){ ?>
	<li class="show07" style="display: none;">
		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?>"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-<?php echo ((isset($menu->icon) && ($menu->icon !== ""))?($menu->icon):'desktop'); ?> normal"></i>
			<span class="menu-text normal"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right normal"></b>
			<i class="fa fa-reply back"></i>
			<span class="menu-text back">返回</span>

		</a>

		<ul  class="submenu">
			<?php getsubmenu_seven_first((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>


	<?php function getsubmenu_seven_first($submenus_seven){ ?>
	<?php foreach($submenus_seven as $menu){ ?>
	<li>

		<?php if(empty($menu->items)){ ?>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
		<?php }else{ ?>
		<a href="#" class="dropdown-toggle">
			<i class="fa fa-caret-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
			<b class="arrow fa fa-angle-right"></b>
		</a>
		<ul  class="submenu">
			<?php getsubmenu_seven_second((array)$menu->items) ?>
		</ul>
		<?php } ?>

	</li>

	<?php } ?>
	<?php } ?>

	<?php function getsubmenu_seven_second($submenus_seven){ ?>
	<?php foreach($submenus_seven as $menu){ ?>
	<li>
		<a href="javascript:openapp('<?php echo ($menu->url); ?>','<?php echo ($menu->id); ?>','<?php echo ($menu->name); ?>');">
			&nbsp;<i class="fa fa-angle-double-right"></i>
			<span class="menu-text"><?php echo ($menu->name); ?></span>
		</a>
	</li>

	<?php } ?>
	<?php } ?>
<?php if(APP_DEBUG): ?><style>
#think_page_trace_open{left: 0 !important;
right: initial !important;}			
</style><?php endif; ?>

</head>

<body style="min-width:900px;" screen_capture_injected="true">
	<div id="loading"><i class="loadingicon"></i><span>正在加载...</span></div>
	<!-- <div id="right_tools_wrapper">
		<span id="right_tools_clearcache" title="清除缓存" onclick="javascript:openapp('<?php echo U('admin/setting/clearcache');?>','right_tool_clearcache','清除缓存');"><i class="fa fa-trash-o right_tool_icon"></i></span>
		<span id="refresh_wrapper" title="刷新当前页" ><i class="fa fa-refresh right_tool_icon"></i></span>
	</div> -->
    	<!-- 	<?php $type=array("1"=>"校长","2"=>"副校长","3"=>"主任","4"=>"任课教师","5"=>"教师","6"=>"班主任","7"=>"学校管理员"); ?> -->
        <div class="dingbu" style=" height:50px; margin-bottom:1px;">
    	<div class="logo" style=" width:190px;"><i></i>智校园</div>
        <div class="info" style=" height:50px;">
					<p><?php echo ($school_name); ?><span><?php echo ($teacher_name); ?>老师您好！&nbsp; 角色：<?php echo ($role); ?></span></p>
				</div>
                  <ul class=" simplewind-nav pull-right" style=" float:right;">

				<!-- <div class="help">
					<ul>
						<li><a href="" class="help1">用户</a></li>
						<li><a href="" class="help2">帮助中心</a></li>
						<li><a href="" class="help3">积分兑换</a></li>
						<li><a href="" class="help4">系统公告</a></li>
						<li><a href="" class="help5">维护人员 17483940596</a></li>
						<li><a href="" class="help6">在线留言</a></li>
					</ul>
				</div> -->
					<li class="light-blue" style=" padding-top:4px;">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle" style=" text-decoration:none;">
							<img class="nav-user-photo" src="/weixiaotong2016/statics/images/icon/logo-18.png" alt="<?php echo ($admin["user_login"]); ?>">
							<span class="user-info">
								<small>欢迎,</small><?php echo ((isset($admin["user_nicename"]) && ($admin["user_nicename"] !== ""))?($admin["user_nicename"]):$admin[user_login]); ?>
							</span>
							<i class="fa fa-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
								<li><a href="javascript:openapp('<?php echo U('setting/site');?>','index_site','站点管理');" style=" text-decoration:none;"><i class="fa fa-cog"></i> 站点管理</a></li>
								<li><a href="javascript:openapp('<?php echo U('user/userinfo');?>','index_userinfo','个人资料');" style=" text-decoration:none;"><i class="fa fa-user"></i> 个人资料</a></li>
							<li><a href="<?php echo U('Index/ursr_quit');?>" style=" text-decoration:none;"><i class="fa fa-sign-out"></i> 退出</a></li>
						</ul>
					</li>
				</ul>
        <div class="top" style=" width:550px;">
				<div class="help">
					<ul style="width: 620px;padding-left: 0">
                    	<li><a href="" class="help1 yuan" style=" text-decoration:none;">用户</a></li>
						<li><a href="" class="help2 yuan" style=" text-decoration:none;">帮助中心</a></li>
						<li><a href="" class="help3 yuan" style=" text-decoration:none;">积分兑换</a></li>
						<li><a href="" class="help4 yuan" style=" text-decoration:none;">系统公告</a></li>
						<li><a href="" class="help5 yuan" style=" text-decoration:none;">维护人员 17483940596</a></li>
						<li><a href="javascript:openapp('<?php echo U('LeaveMessage/index');?>','index_site','在线留言');" class="help6 yuan" style=" text-decoration:none;">在线留言</a></li>
					</ul>
                    				
				</div>
                
		</div>

        <div class="clearfix"></div>
    </div>
  <!--<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid" >
				<a href="#" class="brand" style="background-color:#61c881;color:#fff;width:149px">
					<small>
				<img style="height:30px;width:61px" src="/weixiaotong2016/tpl_admin/simpleboot/assets/images/logo-4.png">
						<font style="font-weight:blod" >智校园</font>
				</small>
				</a>
				<div class="pull-left nav_shortcuts" >
					<div class="info">
					阳光幼儿园<span>彭书国老师您好！&nbsp; 角色：学校管理员</span>
				</div><!---->  
	
					<!-- <a class="btn btn-small btn-warning" href="/weixiaotong2016/" title="前台首页" target="_blank">
						<i class="fa fa-home"></i>
					</a>
					
					<a class="btn btn-small btn-success" href="javascript:openapp('<?php echo U('portal/AdminTerm/index');?>','index_termlist','分类管理');" title="分类管理">
						<i class="fa fa-th"></i>
					</a>
					<a class="btn btn-small btn-info" href="javascript:openapp('<?php echo U('portal/AdminPost/index');?>','index_postlist','文章管理');" title="文章管理">
						<i class="fa fa-pencil"></i>
					</a>
					<a class="btn btn-small btn-danger" href="javascript:openapp('<?php echo U('admin/setting/clearcache');?>','index_clearcache','清除缓存');" title="清除缓存">
						<i class="fa fa-trash-o"></i>
					</a> -->
                    <!--</div>
				<ul class="nav simplewind-nav pull-right" style=" height:40px;">-->
				

				<!-- <div class="help">
					<ul>
						<li><a href="" class="help1">用户</a></li>
						<li><a href="" class="help2">帮助中心</a></li>
						<li><a href="" class="help3">积分兑换</a></li>
						<li><a href="" class="help4">系统公告</a></li>
						<li><a href="" class="help5">维护人员 17483940596</a></li>
						<li><a href="" class="help6">在线留言</a></li>
					</ul>
				</div> -->
                <!--<li class="light-blue">
						<a data-toggle="dropdown" href="#" class="dropdown-toggle">
							<img class="nav-user-photo" src="/weixiaotong2016/statics/images/icon/logo-18.png" alt="<?php echo ($admin["user_login"]); ?>">
							<span class="user-info">
								<small>欢迎,</small><?php echo ((isset($admin["user_nicename"]) && ($admin["user_nicename"] !== ""))?($admin["user_nicename"]):$admin[user_login]); ?>
							</span>
							<i class="fa fa-caret-down"></i>
						</a>
						<ul class="user-menu pull-right dropdown-menu dropdown-yellow dropdown-caret dropdown-closer">
								<li><a href="javascript:openapp('<?php echo U('setting/site');?>','index_site','站点管理');"><i class="fa fa-cog"></i> 站点管理</a></li>
								<li><a href="javascript:openapp('<?php echo U('user/userinfo');?>','index_userinfo','个人资料');"><i class="fa fa-user"></i> 个人资料</a></li>
							<li><a href="<?php echo U('Public/logout');?>"><i class="fa fa-sign-out"></i> 退出</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</div>-->
					
    
	<div class="main-container container-fluid">
		<div class="sidebar leftmeun leftlei" id="sidebar">
		<!-- 	<div class="sidebar-shortcuts" id="sidebar-shortcuts">
				<ul class="nav nav-list">
					<li>
					<a href="#" class="dropdown-toggle">
								<i class="fa fa-th normal"></i>
								<span class="menu-text normal">信息通知1</span>
								<b class="arrow fa fa-angle-right normal"></b>
								<i class="fa fa-reply back"></i>
								<span class="menu-text back">返回</span>

							</a>
						</li>
				</ul>
			</div> -->
			<div id="nav_wraper">
			<ul class="nav nav-list">
				<li style=" height:41px;">
					<a href="#" class="dropdown-toggle" style="background-color:#61c881;color:#fff; height:41px;padding-top:4px;">
								<i class="fa fa-th normal"></i>
								<span class="menu-text normal" style="color:#fff;">功能模块</span>
								<b class="arrow fa fa-angle-right normal" style="color:#fff; margin-top:4px;" ></b>
								<i class="fa fa-reply back" style=""></i>
								<span class="menu-text back">返回</span>
								
							</a>
						</li>
				<li style=" border: 5px solid green;display: none"><?php echo getsubmenu($submenus);?></li>
				<li style=" border: 5px solid green;display: none"><?php echo getsubmenu_two($submenus_two);?></li>
				<li style=" border: 5px solid green;display: none"><?php echo getsubmenu_three($submenus_three);?></li>
				<li style=" border: 5px solid green;display: none"><?php echo getsubmenu_five($submenus_five);?></li>
				<li style=" border: 5px solid green;display: none"><?php echo getsubmenu_six($submenus_six);?></li>
				<li style=" border: 5px solid green;display: none"><?php echo getsubmenu_seven($submenus_seven);?></li>
			</ul>
			</div>
			
		</div>

		<div class="main-content youkong">
			<div class="newnav">
        <ul>
			<?php if(!empty($submenus_seven)): ?><li class="click07">校网</li><?php endif; ?>
			<?php if(!empty($submenus_six)): ?><li class="click06">成长档案</li><?php endif; ?>
			<?php if(!empty($submenus_five)): ?><li class="click05">视频监控</li><?php endif; ?>
			<?php if(!empty($submenus_three)): ?><li class="click03">教学办公</li><?php endif; ?>
			<?php if(!empty($submenus_two)): ?><li class="click02">教务管理</li><?php endif; ?>
			<?php if(!empty($submenus)): ?><li class="click01">家校互动</li><?php endif; ?>
            <a href="/weixiaotong2016/index.php/Teacher"><li class="click00 clicklei">我的主页</li></a>
            <li style="width: 130px;" class="mybloke">功能模块</li>
            <!-- <li>家校互动</li> -->
        </ul>
        <div class="clearfix"></div>
    	</div>
			<div class="breadcrumbs" id="breadcrumbs">
		
				<a id="task-pre" class="task-changebt">←</a>
				<div id="task-content">
				<ul class="macro-component-tab" id="task-content-inner">
					<li class="macro-component-tabitem noclose" app-id="0" app-url="<?php echo U('main/index');?>" app-name="首页">
						<span class="macro-tabs-item-text">首页</span>
					</li>
				</ul>
				<div style="clear:both;"></div>
				</div>
				<a id="task-next" class="task-changebt">→</a>
			</div>

			<div class="page-content" id="content">
				<iframe src="<?php echo U('Main/index');?>" style="width:100%;height: 100%;" frameborder="0" id="appiframe-0" class="appiframe"></iframe>
			</div>
		</div>
	</div>
	
	<script src="/weixiaotong2016/statics/js/jquery.js"></script>
	<script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
	<script>
   //获取分辨率
     sum = screen.width+screen.height;

   if(sum<'2450')
   {
     $(".newnav li").css("padding",'0px 25px');
   }


	var ismenumin = $("#sidebar").hasClass("menu-min");
	$(".nav-list").on( "click",function(event) {
		var closest_a = $(event.target).closest("a");
		if (!closest_a || closest_a.length == 0) {
			return
		}
		if (!closest_a.hasClass("dropdown-toggle")) {
			if (ismenumin && "click" == "tap" && closest_a.get(0).parentNode.parentNode == this) {
				var closest_a_menu_text = closest_a.find(".menu-text").get(0);
				if (event.target != closest_a_menu_text && !$.contains(closest_a_menu_text, event.target)) {
					return false
				}
			}
			return
		}
		var closest_a_next = closest_a.next().get(0);
		if (!$(closest_a_next).is(":visible")) {
			var closest_ul = $(closest_a_next.parentNode).closest("ul");
			if (ismenumin && closest_ul.hasClass("nav-list")) {
				return
			}
			closest_ul.find("> .open > .submenu").each(function() {
						if (this != closest_a_next && !$(this.parentNode).hasClass("active")) {
							$(this).slideUp(150).parent().removeClass("open")
						}
			});
		}
		if (ismenumin && $(closest_a_next.parentNode.parentNode).hasClass("nav-list")) {
			return false;
		}
		$(closest_a_next).slideToggle(150).parent().toggleClass("open");
		return false;
	});
	</script>
	<script src="/weixiaotong2016/tpl_teacher/simpleboot/assets/js/index.js"></script>
<script>
$(".click00").click(
		function(){
			$(this).addClass("clicklei").siblings().removeClass("clicklei")
			$(".leftmeun").addClass("leftlei")
			$(".main-content").addClass("youkong")
			$(".mybloke").show()
		}
	)
$(".click01").click(function(){
	// 	alert('aaa');
	// var show =	document.getElementsByClassName('show01');
	
	// // console.log(show);
	 // for (var i = 0; i<show.length;i++) {
  //      show[i].style.display="block";
  //    };  
            // var show01 = $("body").find(".show01");

          

			$(".show01").each(function(){
				$(this).css("display","block");
			})
			// $(".show01").css("display"," block")
			// $(".show01").each(function(){
   //              $(this).css("display","none");
            $(".show05").each(function(){
				$(this).css("display","none");
			})
              $(".show02").each(function(){
				$(this).css("display","none");
			})
            $(".show06").each(function(){
				$(this).css("display","none");
			})     	
			// })
			// show.style.display="block
			 $(".show03").each(function(){
				$(this).css("display","none");
			}) 
			$(".show07").each(function(){
				$(this).css("display","none");
			}) 
		
            // $(".show07").css("display"," none")
			$(this).addClass("clicklei").siblings().removeClass("clicklei")
			$(".leftmeun").removeClass("leftlei")
			$(".main-content").removeClass("youkong")
			$(".mybloke").hide()
		}
	)
$(".click02").click(
		function(){
			$(".show02").each(function(){
				$(this).css("display","block");
			})
			// $(".show02").css("display"," block")

			$(".show01").each(function(){
				$(this).css("display","none");
			})
			$(".show06").each(function(){
				$(this).css("display","none");
			})
			// $(".show01").css("display"," none")
			// $(".show06").css("display","none")
			$(".show05").each(function(){
				$(this).css("display","none");
			})
			$(".show03").each(function(){
				$(this).css("display","none");
			})
			$(".show07").each(function(){
				$(this).css("display","none");
			})
			// $(".show05").css("display"," none")
			// $(".show03").css("display"," none")
            // $(".show07").css("display"," none")
			$(this).addClass("clicklei").siblings().removeClass("clicklei")
			$(".leftmeun").removeClass("leftlei")
			$(".main-content").removeClass("youkong")
			$(".mybloke").hide()
		}
	)
$(".click03").click(
		function(){
			$(".show03").each(function(){
				$(this).css("display","block");
			})
			// $(".show03").css("display"," block")
			$(".show06").each(function(){
				$(this).css("display","none");
			})
			// $(".show06").css("display","none")
			$(".show01").each(function(){
				$(this).css("display","none");
			})


			// $(".show01").css("display"," none")
			$(".show05").each(function(){
				$(this).css("display","none");
			})
			$(".show02").each(function(){
				$(this).css("display","none");
			})
			// $(".show05").css("display"," none")
			// $(".show02").css("display"," none")
			$(".show07").each(function(){
				$(this).css("display","none");
			})
            // $(".show07").css("display"," none")
			$(this).addClass("clicklei").siblings().removeClass("clicklei")
			$(".leftmeun").removeClass("leftlei")
			$(".main-content").removeClass("youkong")
			$(".mybloke").hide()
		}
	)
$(".click07").click(
    function(){
    	$(".show07").each(function(){
				$(this).css("display","block");
			})
        // $(".show07").css("display"," block")
       	$(".show06").each(function(){
				$(this).css("display","none");
		}) 
        // $(".show06").css("display","none")
        $(".show03").each(function(){
				$(this).css("display","none");
			})
		// $(".show03").css("display","none")
		$(".show05").each(function(){
				$(this).css("display","none");
			})	
		// $(".show05").css("display","none")
		$(".show01").each(function(){
				$(this).css("display","none");
			})	
        // $(".show01").css("display"," none")
        	$(".show02").each(function(){
				$(this).css("display","none");
			})
        // $(".show02").css("display"," none")
        $(this).addClass("clicklei").siblings().removeClass("clicklei")
        $(".leftmeun").removeClass("leftlei")
        $(".main-content").removeClass("youkong")
        $(".mybloke").hide()
    }
)
$(".click05").click(
    function(){
    	  $(".show05").each(function(){
				$(this).css("display","block");
			})
        // $(".show05").css("display"," block")
       	$(".show07").each(function(){
				$(this).css("display","none");
			}) 
        // $(".show07").css("display","none")
       	$(".show03").each(function(){
				$(this).css("display","none");
			}) 
		// $(".show03").css("display","none")
		$(".show06").each(function(){
				$(this).css("display","none");
		})
	     $(".show01").each(function(){
				$(this).css("display","none");
			})
		// $(".show06").css("display","none")
        // $(".show01").css("display"," none")
        $(".show02").each(function(){
				$(this).css("display","none");
			})
        // $(".show02").css("display"," none")
        $(this).addClass("clicklei").siblings().removeClass("clicklei")
        $(".leftmeun").removeClass("leftlei")
        $(".main-content").removeClass("youkong")
        $(".mybloke").hide()
    }
)
$(".click06").click(
    function(){
    	 // $(".show06").css("display"," block")
        $(".show06").each(function(){
				$(this).css("display","block");
			})
        $(".show05").each(function(){
				$(this).css("display","none");
			}) 

        // $(".show05").css("display"," none")
         $(".show07").each(function(){
				$(this).css("display","none");
			})
        // $(".show07").css("display","none")
         $(".show03").each(function(){
				$(this).css("display","none");
			})
		// $(".show03").css("display","none")
		 $(".show01").each(function(){
				$(this).css("display","none");
			})
        // $(".show01").css("display"," none")
        $(".show02").each(function(){
				$(this).css("display","none");
			}) 
        // $(".show02").css("display"," none")
        $(this).addClass("clicklei").siblings().removeClass("clicklei")
        $(".leftmeun").removeClass("leftlei")
        $(".main-content").removeClass("youkong")
        $(".mybloke").hide()
    }
)




</script>


</body>
</html>