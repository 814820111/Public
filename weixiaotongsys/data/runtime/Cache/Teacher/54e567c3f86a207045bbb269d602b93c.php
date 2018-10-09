<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
    <![endif]-->

	<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_TEACHER_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <link href="/weixiaotong2016/tpl_teacher/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="/weixiaotong2016/statics/simpleboot/css/index.css"/>
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
//全局变量
var GV = {
    HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};

</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
	</style><?php endif; ?>
<body>
		<div>
        <div class="right" style=" margin-left:0; width:100%; margin-bottom:50px;">
			<div class="content">
				<div class="content_left">
					<div class="left_up">
						<ul>
							<li ><a href="<?php echo U('Exam/index',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615589.png"/>发送成绩</a></li>
							<li style=" cursor:context-menu"><a href="<?php echo U('MessageInfo/index',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615721.png"/>发送信息</a></li>
							<li style=" cursor:context-menu"><a href="<?php echo u('Entrust/index',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615804.png"/>家长叮嘱</a></li>
							<li style=" cursor:context-menu"><a href="" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615805.png"/>同事留言</a></li>
							<li style=" cursor:context-menu"><a href="" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467616014.png"/>给同事信息</a></li>
							<li style=" cursor:context-menu"><a href="<?php echo U('AttendanceSelect/lists',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467616115.png"/>当日考勤</a></li>
							<li style=" cursor:context-menu"><a href="<?php echo U('ClassActivities/add',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615589.png"/>班级活动</a></li>
							<li style=" cursor:context-menu"><a href="<?php echo U('ClassAlbum/add',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615721.png"/>班级相册</a></li>
							<li style=" cursor:context-menu"><a href="<?php echo u('StudentInfo/index',array('button_level'=>1));?>" style="text-decoration: none;color: inherit;"><img src="/weixiaotong2016/statics/images/raw_1467615805.png"/>管理学生档案</a></li>
						</ul>
					</div>
					<div class="left_down">
						<ul>
							<li class="one" style="cursor:context-menu">
								<div>
									<h3>系统信息</h3>
									<a href="<?php echo u('SystermMessage');?>">more&gt;&gt;</a>
									<ul style=" margin-left:0px;" >
										<?php if($Xitong != null): if(count($Xitong) == 1): if(is_array($Xitong)): foreach($Xitong as $key=>$vo): ?><li style="width: 94.5%;cursor:context-menu">
															<h4><?php echo ($vo["post_title"]); ?>sssss</h4>
															<p class="date"><?php echo ($vo["post_date"]); ?></p>
															<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="<?php echo ($vo["post_excerpt"]); ?>"><?php echo ($vo["post_excerpt"]); ?></p>
														</li>
											<li style="width: 94.5%;cursor:context-menu">
												<h4>暂无公告</h4>
												<p class="date">06-22 12:30</p>
												<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无公告">暂无公告</p>
											</li><?php endforeach; endif; ?>
												<?php else: ?>
													<?php if(is_array($Xitong)): foreach($Xitong as $key=>$vo): ?><li style="width: 94.5%;cursor:context-menu">
															<h4><?php echo ($vo["post_title"]); ?>sssss</h4>
															<p class="date"><?php echo ($vo["post_date"]); ?></p>
															<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="<?php echo ($vo["post_excerpt"]); ?>"><?php echo ($vo["post_excerpt"]); ?></p>
														</li><?php endforeach; endif; endif; ?>
											<?php else: ?>
											<li style="width: 94.5%;cursor:context-menu">
												<h4>暂无公告</h4>
												<p class="date">06-22 12:30</p>
												<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无公告">暂无公告</p>
											</li>
											<li style="width: 94.5%;cursor:context-menu">
												<h4>暂无公告</h4>
												<p class="date">06-22 12:30</p>
												<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无公告">暂无公告</p>
											</li><?php endif; ?>
									</ul>
								</div>
							</li>
							<li class="one" style="cursor:context-menu">
								<div>
									<h3>校园公告</h3>
									<a href="<?php echo u('SchoolNotice/index');?>">more&gt;&gt;</a>
									<ul style=" margin-left:0px;">
									<?php if($notice != null): if(count($notice) == 1): if(is_array($notice)): foreach($notice as $key=>$vo): ?><li style="width: 94.5%;cursor:context-menu">
											<h4><?php echo ($vo["title"]); ?></h4>
											<p class="date"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="<?php echo ($vo["content"]); ?>"><?php echo ($vo["content"]); ?></p>
										</li>
										  <li style="width: 94.5%;cursor:context-menu">
											  <h4>暂无内容</h4>
											  <p class="date">06-22 12:30</p>
											  <p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										  </li><?php endforeach; endif; ?>
											<?php else: ?>
											<?php if(is_array($notice)): foreach($notice as $key=>$vo): ?><li style="width: 94.5%;cursor:context-menu">
													<h4><?php echo ($vo["title"]); ?></h4>
													<p class="date"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></p>
													<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="<?php echo ($vo["content"]); ?>"><?php echo ($vo["content"]); ?></p>
												</li><?php endforeach; endif; endif; ?>
									<?php else: ?>
										<li style="width: 94.5%;cursor:context-menu">
											<h4>暂无内容</h4>
											<p class="date">06-22 12:30</p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										</li>
										<li style="width: 94.5%;cursor:context-menu">
											<h4>暂无内容</h4>
											<p class="date">06-22 12:30</p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										</li><?php endif; ?>
									
									</ul>
								</div>
							</li>
							<li class="one" style="cursor:context-menu">
								<div>
									<h3>家长叮嘱</h3>
									<a href="<?php echo u('Entrust/index');?>">more&gt;&gt;</a>
									<ul style=" margin-left:0px;">
									<?php if($entrust != null): if(is_array($entrust)): foreach($entrust as $key=>$vo): ?><li style="width: 94.5%;cursor:context-menu">
											<h4><?php echo ($vo["name"]); ?>：</h4>
											<p class="date"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="<?php echo ($vo["content"]); ?>"><?php echo ($vo["content"]); ?></p>
										</li><?php endforeach; endif; ?>
									 <?php else: ?>
										<li style="width: 94.5%;cursor:context-menu">
											<h4>暂无内容</h4>
											<p class="date">06-22 12:30</p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										</li>
										<li style="width: 94.5%;cursor:context-menu">
											<h4>暂无内容</h4>
											<p class="date">06-22 12:30</p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										</li><?php endif; ?> 
								  </ul>
								</div>
							</li>
							<li class="one" style="cursor:context-menu">
								<div>
									<h3>待办事宜</h3>
									<a href="<?php echo u('ToduSchedule/index_todo');?>">more&gt;&gt;</a>
									<ul style=" margin-left:0px;">
									 <?php if($schedule != null): if(is_array($schedule)): foreach($schedule as $key=>$vo): ?><li style="width: 94.5%;cursor:context-menu">
											<h4><?php echo ($vo["title"]); ?></h4>
											<p class="date"><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="<?php echo ($vo["content"]); ?>"><?php echo ($vo["content"]); ?></p>
										</li><?php endforeach; endif; ?>
									   <?php else: ?>
										<li style="width: 94.5%;cursor:context-menu">
											<h4>暂无内容</h4>
											<p class="date">06-22 12:30</p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										</li>
										<li style="width: 94.5%;cursor:context-menu">
											<h4>暂无内容</h4>
											<p class="date">06-22 12:30</p>
											<p style=" width: 100%; white-space: nowrap; overflow: hidden;text-overflow: ellipsis" title="暂无内容">暂无内容</p>
										</li><?php endif; ?>	
									</ul>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="content_right">
					<div class="img">
						<img src="/weixiaotong2016/statics/images/img.jpg"/>
					</div>
					<div class="summary2">
						<h3 style=" font-size:14px;">家校互联月统计</h3>
						<ul style=" margin-left:0px;">
							<li style=" cursor:context-menu"><?php echo ($name); ?>老师，您共发送了<span><?php echo ($message_sum); ?></span>条信息</li>
							<li style=" cursor:context-menu">今日已发信息（<span><?php echo ($today_info); ?></span>）</li>
							<li style=" cursor:context-menu">本周已发信息（<span><?php echo ($week_info); ?></span>）</li>
							<li style=" cursor:context-menu">月度已发信息（<span><?php echo ($month_info); ?></span>）</li>
							<li style=" cursor:context-menu">班级相册（<span><?php echo ($microblog_info); ?></span>）</li>
							<li style=" cursor:context-menu">班级活动（<span><?php echo ($activity_info); ?></span>）</li>
							<li style=" cursor:context-menu">班级课件（<span><?php echo ($courseware_info); ?></span>）</li>
							<li style=" cursor:context-menu">信息群发（<span><?php echo ($message_sum); ?></span>）</li>
							<li style=" cursor:context-menu">动态（<span><?php echo ($Dynamic_info); ?></span>）</li>
							<li style=" cursor:context-menu;display: none">第13名 继续努力哦</li>
						</ul>
					</div>
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
        <div class="clearfix"></div>
        </div>
<script type="text/javascript" src="js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/jquery.js"></script>
	<script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
	<script>
	//全局变量
var GV = {
	HOST:"<?php echo ($_SERVER['HTTP_HOST']); ?>",
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
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
	<script src="/weixiaotong2016/statics/js/jquery_web.js"></script>

<script>
/*左侧栏下拉菜单*/

$(".click .one li").hide();
$(".click .first .one_click").click(
	function(){
		$(".click .one li").slideToggle()
		$(".point1").toggleClass("lei")
		$(".first  .one_click a").toggleClass("lei2")
		}
)

$(".click .tow li").hide();
$(".click .first .tow_click").click(
	function(){
		$(".click .tow li").slideToggle()
		$(".point2").toggleClass("lei")
		$(".first  .tow_click a").toggleClass("lei2")
		}
)

$(".click .three li").hide();
$(".click .first .three_click").click(
	function(){
		$(".click .three li").slideToggle()
		$(".point3").toggleClass("lei")
		$(".first  .three_click a").toggleClass("lei2")
		}
)

$(".click .four li").hide();
$(".click .first .four_click").click(
	function(){
		$(".click .four li").slideToggle()
		$(".point4").toggleClass("lei")
		$(".first  .four_click a").toggleClass("lei2")
		}
)

$(".click .five li").hide();
$(".click .first .five_click").click(
	function(){
		$(".click .five li").slideToggle()
		$(".point5").toggleClass("lei")
		$(".first  .five_click a").toggleClass("lei2")
		}
)

$(".click .six li").hide();
$(".click .first .six_click").click(
	function(){
		$(".click .six li").slideToggle()
		$(".point6").toggleClass("lei")
		$(".first  .six_click a").toggleClass("lei2")
		}
)

$(".click .seven li").hide();
$(".click .first .seven_click").click(
	function(){
		$(".click .seven li").slideToggle()
		$(".point7").toggleClass("lei")
		$(".first  .seven_click a").toggleClass("lei2")
		}
)

$(".click .eight li").hide();
$(".click .first .eight_click").click(
	function(){
		$(".click .eight li").slideToggle()
		$(".point8").toggleClass("lei")
		$(".first  .eight_click a").toggleClass("lei2")
		}
)

$(".click .nine li").hide();
$(".click .first .nine_click").click(
	function(){
		$(".click .nine li").slideToggle()
		$(".point9").toggleClass("lei")
				$(".first  .nine_click a").toggleClass("lei2")
}
)


</script>

<script>
   $(function () {
      // $('#myTab li:eq(0) a').tab('show');
   });
</script>
<script>
          //   $("#file-3").fileinput({
          //         showUpload: false,
          //         showCaption: false,
          //         browseClass: "btn btn-default",
          //         fileType: "any",
          //     previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
          //   });
          // $(document).ready(function() {
          //     $("#test-upload").fileinput({
          //         'showPreview' : false,
          //         'allowedFileExtensions' : ['jpg', 'png','gif'],
          //         'elErrorContainer': '#errorBlock'
          //     });

          // });
            </script>
</body>
</html>