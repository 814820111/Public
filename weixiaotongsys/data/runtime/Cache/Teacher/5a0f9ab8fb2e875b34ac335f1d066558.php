<?php if (!defined('THINK_PATH')) exit();?>	<!doctype html>
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
<html>

<head>
	<style>

	</style>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>信息1</title>
	<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
	<!--<link href="/weixiaotong2016/statics/simpleboot/css/custom.css" media="all" rel="stylesheet" type="text/css" />-->
	<link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
	<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/wind.js"></script>

	<style type="text/css">
		.col-auto {
			overflow: auto;
			_zoom: 1;
			_float: left;
		}

		.col-right {
			float: right;
			width: 30%;
			overflow: hidden;
			margin-left: 6px;
		}

		.table th,
		.table td {
			vertical-align: middle;
		}

		.picList li {
			margin-bottom: 5px;
		}

		.touchlei {
			background-color: #eeeeee;
		}

		tr .pai,
		tr .pai2 {
			text-align: center;
			font-size: 14px;
			color: black;
		}

		tr .pai {
			background-color: #e2e2e2;
		}

		tr .pai2 {}

		.clearfix {
			clear: both;
		}

		.name {
			margin-right: 10px;
		}

		.dbzr {
			background-color: #61c881;
			color: white;
			text-align: center;
			padding: 0px 15px;
			float: left;
			border-radius: 8px;
		}

		.sic {
			width: 15px;
			margin-left: 5px;
			margin-top: -15px;
			cursor: pointer;
		}

		.daiban {
			border-bottom: 1px solid #dddddd;
		}

		.daike {
			width: 100px;
			text-align: center;
			line-height: 30px;
			float: left;
			border-bottom: 1px solid #dddddd;
		}

		.dailei {
			border: 1px solid #dddddd;
			border-bottom: none;
			font-weight: bold;
		}

		.banji {
			float: left;
			width: 20%;
			margin-bottom: 10px;
		}

		.banji input {
			margin-top: -2px;
			margin-right: 5px;
		}

		.subject {
			float: left;
			color: #03a9f4;
			margin-right: 15px;
			cursor: pointer;
		}

		.peizhi {
			color: #03a9f4;
		}

		.kecheng {
			color: #03a9f4;
			float: left;
			display: none;
			border: 1px solid #03a9f4;
			padding-left: 3px;
			padding-right: 3px;
			cursor: pointer;
		}

		.subinput {
			display: none;
		}

		.mr20 input{
			color: black;
		}
		.select_2{
			color: black;
			font-size: 14px;

		}

		.class{
			color: black;
			font-size: 14px;

		}

		.pager input{
			height: 11px;
		}
		.pager{
			margin-top: 0px;
			margin-bottom: 10px；
		}

		select{
			width: auto;
		}
		.title-txt {
			text-align: center;
			height: 30px;
			float: left;
			line-height: 30px;
			width: 80px;
		}
		table.gridtable .title-txt {
			text-align: right;
			width: 70px;
		}

	#sangcalender{
		z-index: 99999999;
	}
		#timeinput{
			float: left;
			border: medium none;
			background: transparent none repeat scroll 0% 0%;
			/*height: 30px;*/
			color: black;
			line-height: 30px;
			width: 186px;
			text-indent: 2px;
			font-size: 14px;
		}
		table.gridtable td {
			padding: 5px;
			background-color: #ffffff;
		}
		.drop-down{
			padding: 2px;
			background: transparent;
			width: 200px;
			font-size: 14px;
			color: black;
			height: 30px;
		}
		.leftTree {
			width: 25%;
			height: 600px;
			float: left;
		}
		#classTree{
			margin-top: 10px;
			border: 1px solid #d9d9d9;
			background: #fff;
			height: 600px;
			overflow-y: scroll;
			width: 85%;
			overflow-x: auto;
		}
	.rightTable{
		width: 60%;
		float: left;
		margin-left: 4%;
		margin-top: 10px;
		height: 540px;
		overflow-y: auto;
	}
		#occupyTable td{
			width: 80px;
			cursor: pointer;
			text-align: center;
		}
		#occupyTable th{
			width: 80px;
			cursor: pointer;
			text-align: center;
		}
		#occupyTable tr td span {
			display: none;
		}
	</style>
	<script>
        window.onload = function() {
            var sb = document.getElementById("tans");
            sb.onclick = function() {
                var tanboder = document.getElementById("tansboder");
            }
        }
	</script>
</head>

<body>
<div class="wrap jj">
	<ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
		<li class="active">
			<a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">选课-教务</a>
		</li>

		<li class="">
			<a href="<?php echo U('teacher');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">选课-教师</a>
		</li>



	</ul>
	<input type="hidden" class="school" value="<?php echo ($schoolid); ?>">
	<!--亲属信息start-->


	<!-- 模态框（Modal） -->

	<!--导入-->
	<div style=" background-color:rgba(0,0,0,0.7); width:100%; height:100%; position:absolute; display: none" class="show_class"  >
		<div style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

			<div>
				<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">学生调班选择</div>
				<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
			</div>
			<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">

				<div>
					<p  class="">选择班级:</p>
					<select class="class">
						<?php if(is_array($class)): foreach($class as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
					</select><br><br>






					<!--     <form  action="<?php echo U('ImpUser');?>" method="post" enctype="multipart/form-data"> -->


					<input type="submit" value="确定" class="btn btn-info del_class">&nbsp;&nbsp;&nbsp;
					<a class="btn btn-danger dao_close">取消</a>

					<!-- </form> -->
					</p>
				</div>

			</div>
			<div style=" margin-bottom:10px; margin-left:30px;">
				<span class="Sui"></span>
			</div>
			<!-- <div style=" margin-bottom:10px; margin-left:30px;">
            确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
        </div> -->
			<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">


			</div>

			<!--关闭start-->
			<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="dao_close">
			<!--关闭end-->
		</div>
	</div>

	<!---->

	<div style=" background-color:rgba(0,0,0,0.7); width:100%; height:100%; position:absolute; display: none" class="student_drop"  >
		<div style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

			<div>
				<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">学生退学原因</div>
				<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
			</div>
			<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">

				<div>
					<p  class="">退学原因:</p>
					<textarea  class="student_cause" name="" rows="4"></textarea>

					<br><br>



					<!--     <form  action="<?php echo U('ImpUser');?>" method="post" enctype="multipart/form-data"> -->


					<input type="submit" value="确定" class="btn btn-info drop_student">&nbsp;&nbsp;&nbsp;
					<a class="btn btn-danger drop_close">取消</a>

					<!-- </form> -->
					</p>
				</div>

			</div>
			<div style=" margin-bottom:10px; margin-left:30px;">
				<span class="Sui"></span>
			</div>
			<!-- <div style=" margin-bottom:10px; margin-left:30px;">
            确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
        </div> -->
			<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">


			</div>

			<!--关闭start-->
			<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="drop_close">
			<!--关闭end-->
		</div>
	</div>


	<div style=" background-color:rgba(0,0,0,0.7);    position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="daitan"  >
		<div style=" width:600px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
			<form  id="form1" action="<?php echo U('AddSelect');?>" >
				<input type="hidden" id="select_id" name="select_id" >
				<input type="hidden" id="semesterid" name="semesterid" >
				<div>
					<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">添加设置</div>
					<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
				</div>
				<table class="gridtable" align="left" style="margin-top: 20px;">
					<tbody><tr>
						<td class="title-txt"><span>学年</span></td>
						<td class="value-txt">
							<div class="select_style">
								<select name="grade" id="grade" class="drop-down" onchange="getSetting();"><option value="">请选择学年</option><option value="2013-2014">2013-2014</option><option value="2014-2015">2014-2015</option><option value="2015-2016">2015-2016</option><option value="2016-2017">2016-2017</option><option value="2017-2018">2017-2018</option><option value="2018-2019">2018-2019</option><option value="2019-2020">2019-2020</option><option value="2020-2021">2020-2021</option><option value="2021-2022">2021-2022</option></select>
							</div>
						</td>
						<td class="title-txt"><span>学期</span></td>
						<td class="value-txt">
							<div class="select_style">
								<select name="semesterid" id="term" class="drop-down" onchange="getSetting(this);">
									<option value="">请选择学期</option>
									<?php if(is_array($semester)): foreach($semester as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["semester"]); ?></option><?php endforeach; endif; ?>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td class="title-txt"><span>选课开始</span></td>
						<td class="value-txt">

							<div class="input-text">
								<input type="text" id="timeinput" class="sang_Calender" name="begintime" placeholder="-选择时间-"  style="border: 1px solid #dce4ec;">

							</div>
						</td>
						<td class="title-txt"><span>选课截止</span></td>
						<td class="value-txt">
							<div class="input-text">
								<input type="text" id="timeinput" class="sang_Calender" name="endtime" placeholder="-选择时间-"  style="border: 1px solid #dce4ec;">
							</div>
						</td>
					</tr>
					<tr>
						<td class="title-txt"><span>报名审核</span></td>
						<td class="value-txt" style="width:200px;">
							<table class="SHType">
								<tbody><tr>
									<td>
										<div class="radio i-checks" style="padding-top:0px;">
											<div class="iradio_square-green checked" style="position: relative;" onclick="getChecked(1,this);">
												<input style="" checked="checked" value="1" name="checkType" type="radio" onclick="checkshen(this)">
											</div>不需要审核
										</div>
									</td>
									<td>
										<div class="radio i-checks" style="padding-top:0px;">
											<div class="iradio_square-green" style="position: relative;" onclick="getChecked(2,this);">
												<input style="" value="2" name="checkType" type="radio" onclick="checkshen(this)">
											</div>需要审核
										</div>
									</td>
								</tr>
								</tbody></table>
						</td>
						<td class="title-txt needSH" style="display:none;"><span>审核人</span></td>
						<td class="value-txt needSH" style="display:none;" >
							<table>
								<tbody><tr>
									<td>
										<div class="radio i-checks" style="padding-top:0px;">
											<div class="iradio_square-green checked" style="position: relative; " onclick="getChecked(0,this);">
												<input style="" checked="checked" disabled="disabled" value="1" name="checkTypeTwo" type="radio">
											</div>教务老师
										</div>
									</td>
									<td>
										<div class="radio i-checks" style="padding-top:0px;">
											<div class="iradio_square-green" style="position: relative; display: inline-block;" onclick="getChecked(0,this);">
												<input style=""  value="2" name="checkTypeTwo" type="radio">
											</div>授课老师
										</div>
									</td>
								</tr>
								</tbody></table>
						</td>
					</tr>
					<tr><td colspan="4"><div style="height:1px; background: GRAY;width:100%;"></div></td></tr>
					<tr><td colspan="4">学校正常上课节次<u><a onclick="gotoPitchEdit()" style="font-size:10px;margin-left:20px;color:gray;cursor:pointer;">去设置</a></u></td></tr>
					<tr>
						<td class="title-txt"><span>天数</span></td>
						<td class="value-txt">
							<div class="select_style">
								<select name="workNum" id="workNum" class="drop-down">
									<option value="1">1天</option>
									<option value="2">2天</option>
									<option value="3">3天</option>
									<option value="4">4天</option>
									<option value="5" selected="selected">5天</option>
									<option value="6">6天</option>
									<option value="7">7天</option>
								</select>
							</div>
						</td>
						<td class="title-txt"><span>上午</span></td>
						<td class="value-txt">
							<div class="select_style">
								<select name="forenoon" id="forenoon" class="drop-down">
									<option value="0">0节</option>
									<option value="1">1节</option>
									<option value="2">2节</option>
									<option value="3">3节</option>
									<option value="4" selected="selected">4节</option>
									<option value="5">5节</option>
									<option value="6">6节</option>
									<option value="7">7节</option>
									<option value="8">8节</option>
									<option value="9">9节</option>
									<option value="10">10节</option>
								</select>
							</div>
						</td>
					</tr>
					<tr>
						<td class="title-txt"><span>下午</span></td>
						<td class="value-txt">
							<div class="select_style">
								<select name="afternoon" id="afternoon" class="drop-down">
									<option value="0">0节</option>
									<option value="1">1节</option>
									<option value="2">2节</option>
									<option value="3">3节</option>
									<option value="4" selected="selected">4节</option>
									<option value="5">5节</option>
									<option value="6">6节</option>
									<option value="7">7节</option>
									<option value="8">8节</option>
									<option value="9">9节</option>
									<option value="10">10节</option>
								</select>
							</div>
						</td>
						<td class="title-txt"><span>晚上</span></td>
						<td class="value-txt">
							<div class="select_style">
								<select name="evening" id="evening" class="drop-down">
									<option value="0" selected="selected">0节</option>
									<option value="1">1节</option>
									<option value="2">2节</option>
									<option value="3">3节</option>
									<option value="4">4节</option>
									<option value="5">5节</option>
									<option value="6">6节</option>
									<option value="7">7节</option>
									<option value="8">8节</option>
									<option value="9">9节</option>
									<option value="10">10节</option>
								</select>
							</div>
						</td>
					</tr>
					</tbody></table>
				<!-- <div style=" margin-bottom:10px; margin-left:30px;">
                          确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
                        </div> -->
				<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
					<input type="button" value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='AddSelect()'>

				</div>
			</form>
			<!--关闭start-->
			<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="guan">
			<!--关闭end-->
		</div>
	</div>
	<!--<?php echo ($html); ?>-->

	<div style=" background-color:rgba(0,0,0,0.7);    position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="xuanke"  >
		<div style=" width:700px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
			<form id="form2" action="" method="post">
			<div id="top" style="width:100%;float:left;">

					<input type="hidden" name="xuankeStrs" id="xuankeStrs">
					<input type="hidden" name="classIds" id="classIds" value="">
					<input type="hidden" name="ids" id="ids" value="">
					<input type="hidden" name="selection" id="selection" value="">



					<div class="search-form">
						<div class="title-txt"><span>学期</span></div>
						<div class="select_style">
							<select name="term" id="term" class="drop-down s_term" disabled="disabled">
								<?php if(is_array($semester)): foreach($semester as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["semester"]); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>

			</div>
			<div class="leftTree">
				<div>
					<div id="classMenuContent" class="optionDiv">
						<ul id="classTree" class="ztree">
							<?php echo ($html); ?>
						</ul>

					</div>
				</div>
			</div>
			<div class="rightTable">
				<table id="occupyTable" border="1" cellpadding="2" cellspacing="0">
					<tbody>

					</tbody>
				</table>
			</div>



				<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
					<input type="button" value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='add_node()'>

				</div>
			</form>

			<!--关闭start-->
		<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="xuanke_guan">
			<!--关闭end-->
		</div>
	</div>


	<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
		<div class="tab-pane fade in active" id="home">
			<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('index');?>" method="get" style="margin: 0px 0px 5px;">
				<div class="search_type cc mb10">
					<div class="mb10">
								<span class="mr20">
                      学期:
                      <select class="select_2" name="semester" style=" height: 30px" id="school_grade">
                        <option value='0'>请选择</option>
                        <?php if(is_array($semester)): foreach($semester as $key=>$vo): $semester_info=$semesterid==$vo['id']?"selected":""; ?>
                            <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($semester_info); ?>><?php echo ($vo["semester"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;



                      <input type="submit" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;" value="搜索" />
                       <!--<input type="button"  value="调班" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" class="change_class" >-->
                       <input type="button"  value="添加设置" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" class="drop" >
                       </div>

                  </span>
					</div>
				</div>
			</form>
			<form class="J_ajaxForm" action="" method="post">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-list">
						<thead>
						<tr style="background-color:#CCC;">
							<th class="pai" style=" border-left: none;border-width: 0.5px;">学期</th>
							<th class="pai" style=" border-left: none;border-width: 0.5px;">选课开始</th>
							<th class="pai" style=" border-left: none;border-width: 0.5px;">选课结束</th>
							<th class="pai" style=" border-left: none;border-width: 0.5px;">报名审核</th>
							<th class="pai" style=" border-left: none;border-width: 0.5px;">操作</th>
							<!--<th class="pai" style=" border-left: none;border-width: 0.5px;">班级</th>-->

							<!--<th class="pai" style=" border-left: none;border-width: 0.5px;">服务开通</th>-->
							<!-- <th class="pai" style=" border-left: none;border-width: 0.5px;border-right: none">操作</th> -->
						</tr>
						</thead>
						<?php if(is_array($selection)): foreach($selection as $key=>$vo): ?><tr>
							<td class="pai2"><?php echo ($vo["semester"]); ?></td>
							<td class="pai2 stuname"><?php echo (date("Y-m-d H:i:s",$vo["begintime"])); ?></td>
							<td class="pai2 stuid" ><?php echo (date("Y-m-d H:i:s",$vo["endtime"])); ?></td>


							<td class="pai2" width="100">
								<?php if($vo["enroll_audit"] == 1 ): ?>不需要审核
									<?php else: ?>
									<?php if($vo["auditor"] == 1 ): ?>教务老师
										<?php elseif($vo["auditor"] == 2): ?>
										授课老师<?php endif; endif; ?>
							</td>
							<td class="pai2">
								<a  style=" color:#00c1dd;cursor: pointer;" onclick="edit(<?php echo ($vo["id"]); ?>)">
								修改
								</a>

								<a  onclick="xuankeClasstime(<?php echo ($vo["id"]); ?>,<?php echo ($vo["semesterid"]); ?>)" style=" color:#00c1dd; cursor: pointer;">
									班级选课节次设置
								</a>
								<a  class="edit" href="<?php echo U('set_node',array('id'=>$vo['id'],'semesterid'=>$vo['semesterid']));?>" style=" color:#00c1dd;">
									开设选修班
								</a>
							</td>


						</tr><?php endforeach; endif; ?>
						<?php if(is_array($selection1)): foreach($selection1 as $key=>$vo): ?><tr>
								<td class="pai2"><input type="checkbox" data-class = "<?php echo ($vo["classid"]); ?>" class="J_check" value="<?php echo ($vo["userid"]); ?>" id='sel_all' name="ids" ></td>
								<td class="pai2 stuname"><?php echo ($vo["stu_name"]); ?></td>
								<td class="pai2 stuid" ><?php echo ($vo["stu_id"]); ?></td>


								<td class="pai2" width="100"><?php echo ($vo["phone"]); ?></td>
								<td class="pai2"><?php echo ($vo["in_residence"]); ?></td>
								<td class="pai2"><?php echo ($vo["classname"]); ?></td>

								<td class="pai2"><?php echo ($vo["kaitong"]); ?></td>
								<!-- 	<td class="pai2">
                                        <a href="<?php echo U('delete',array('id'=>$vo['userid']));?>" class="J_ajax_del" style=" color:#00c1dd;">
                                            <?php if($vo['stu_count'] != 0): elseif($vo['stu_count'] == 0): ?> 删除<?php endif; ?>
                                        </a>
                                        <input type="hidden" value="<?php echo ($vo["address"]); ?>">
                                        <a data-id = '<?php echo ($vo["userid"]); ?>' data-sex = '<?php echo ($vo["sex"]); ?>'  data-target="#myModal3" data-toggle="modal"  class="edit" href="<?php echo U('change',array('id'=>$vo['userid']));?>" style=" color:#00c1dd;">
                                             修改
                                        </a>
                                        <a href="#" class="daibanzhuren1" style=" color:#00c1dd;"><input type="hidden" value="<?php echo ($vo["userid"]); ?>">亲属信息</a>
                                    </td> -->
							</tr><?php endforeach; endif; ?>
					</table>


				</div>
			</form>


			<input class="uisid" type="hidden" />

		</div>
	</div>
	<div class="tab-pane fade" id="ios">

	</div>
	<div class="pager"><?php echo ($Page); ?></div>

</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript">
    //全局变量
    var GV = {
        DIMAUB: "/",
        JS_ROOT: "statics/js/",
        TOKEN: ""
    };
</script>
<script>


    var ajaxForm_list = $('form.J_ajaxFsorm');
    if (ajaxForm_list.length) {
        Wind.use('ajaxForm', 'artDialog', function () {
            if ($.browser.msie) {
                //ie8及以下，表单中只有一个可见的input:text时，会整个页面会跳转提交
                ajaxForm_list.on('submit', function (e) {
                    //表单中只有一个可见的input:text时，enter提交无效
                    e.preventDefault();
                });
            }

            $('button.J_ajax_submit_btn').bind('click', function (e) {
                e.preventDefault();
				/*var btn = $(this).find('button.J_ajax_submit_btn'),
				 form = $(this);*/
                var btn = $(this),
                    form = btn.parents('form.J_ajaxForm');

                //批量操作 判断选项
                if (btn.data('subcheck')) {
                    btn.parent().find('span').remove();
                    if (form.find('input.J_check:checked').length) {
                        var msg = btn.data('msg');
                        if (msg) {
                            art.dialog({
                                id: 'warning',
                                icon: 'warning',
                                content: btn.data('msg'),
                                cancelVal: '关闭',
                                cancel: function () {
                                    btn.data('subcheck', false);
                                    btn.click();
                                }
                            });
                        } else {
                            btn.data('subcheck', false);
                            btn.click();
                        }

                    } else {
                        $('<span class="tips_error">请至少选择一项</span>').appendTo(btn.parent()).fadeIn('fast');
                    }
                    return false;
                }

                //ie处理placeholder提交问题
                if ($.browser.msie) {
                    form.find('[placeholder]').each(function () {
                        var input = $(this);
                        if (input.val() == input.attr('placeholder')) {
                            input.val('');
                        }
                    });
                }

                form.ajaxSubmit({
                    url: btn.data('action') ? btn.data('action') : form.attr('action'),
                    //按钮上是否自定义提交地址(多按钮情况)
                    dataType: 'json',
                    beforeSubmit: function (arr, $form, options) {
                        var text = btn.text();

                        //按钮文案、状态修改
                        btn.text(text + '中...').attr('disabled', true).addClass('disabled');
                    },
                    success: function (data, statusText, xhr, $form) {
                        var text = btn.text();

                        //按钮文案、状态修改
                        btn.removeClass('disabled').text(text.replace('中...', '')).parent().find('span').remove();

                        if (data.state === 'success') {
                            $('<span class="tips_success">' + data.info + '</span>').appendTo(btn.parent()).fadeIn('slow').delay(1000).fadeOut(function () {
                                if (data.referer) {
                                    //返回带跳转地址
                                    if (window.parent.art) {
                                        //iframe弹出页
                                        window.parent.location.href = data.referer;
                                    } else {
                                        window.location.href = data.referer;
                                    }
                                } else {
                                    if (window.parent.art) {
                                        reloadPage(window.parent);
                                    } else {
                                        //刷新当前页
                                        reloadPage(window);
                                    }
                                }
                            });
                        } else if (data.state === 'fail') {
                            $('<span class="tips_error">' + data.info + '</span>').appendTo(btn.parent()).fadeIn('fast');
                            btn.removeProp('disabled').removeClass('disabled');
                        }
                    }
                });
            });

        });
    }
     $(document).ready(function () {
     	Wind.css('treeTable');
         Wind.use('treeTable', function () {
             $("#dnd-example").treeTable({
                 indent: 20
             });
         });
     });

    function changeColor(obj) {
        if ($(obj).find(".tdText").text() == "") {
            $(obj).css("background-color","#BEBEBE");
            $(obj).find(".tdText").text("选修课");
        } else {
            $(obj).css("background-color","white");
            $(obj).find(".tdText").text("");
        }
        var xuankeStrs = "";
        $("#occupyTable td").each(function () {
            if ($(this).find(".tdText").text() != "" && $(this).find(".tdText").text() != "x") {
                xuankeStrs += $(this).find("span").text()+";";
            }
        });
        $("#xuankeStrs").val(xuankeStrs);
        isConfilt(obj);
    }

    function isConfilt(obj) {


        var classIds = "";
        $("input[name='menuid[]']").each(function () {
            if ($(this).attr('checked') && $(this).attr("level") == 2) {
                classIds += $(this).val() + ",";

            }
        });
        if (classIds != "") {
            $.ajax({
                url :"<?php echo U('ClickNodeDel');?>",
                type: "get",
                dataType : "json",
                data:{
                    classIds : classIds,
                    xuankeStr : $(obj).find("span").text(),
                    selection : $("#selection").val(),
                    term : $("#term").val()
                },
                success: function(data) {
                    if (data.msg == "confilt") {
                        alert("该位置已安排选修课，不能删除");
                        //将选中的这节课去掉
                        $(obj).css("background-color","#BEBEBE");
                        $(obj).find(".tdText").text("选修课");
                        var xuankeStrs = "";
                        $("#occupyTable td").each(function () {
                            if ($(this).find(".tdText").text() != "" && $(this).find(".tdText").text() != "x") {
                                xuankeStrs += $(this).find("span").text()+";";
                            }
                        });
                        $("#xuankeStrs").val(xuankeStrs);
                    }
                }
            });
        }
    }




    function check_type(num)
	{
	    console.log(num);
        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var level_top = level_bottom = chk.eq(num).attr('level');

        for (var j = num+1; j < count; j++) {

            var le = chk.eq(j).attr('level');
            if (chk.eq(num).attr("checked") == "checked") {
                if (eval(le) > eval(level_bottom)){
                    chk.eq(j).attr("checked", false);
                }
                else if (eval(le) == eval(level_bottom)){
                    break;
                }
            }
        }
        chk.eq(num).attr("checked", false);

	}


    function checknode(obj) {

        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var num = chk.index(obj);
        console.log(num);


        var level_top = level_bottom = chk.eq(num).attr('level');
        console.log(level_bottom);
        for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (eval(le) < eval(level_top)) {
                chk.eq(i).attr("checked", true);
                var level_top = level_top - 1;
            }
        }
        for (var j = num + 1; j < count; j++) {
            var le = chk.eq(j).attr('level');
            console.log(le);
            if (chk.eq(num).attr("checked") == "checked") {
                if (eval(le) > eval(level_bottom)){
                    chk.eq(j).attr("checked", true);
                }
                else if (eval(le) == eval(level_bottom)){
                    break;
                }
            } else {
                if (eval(le) > eval(level_bottom)){
                    chk.eq(j).attr("checked", false);
                }else if(eval(le) == eval(level_bottom)){
                    break;
                }
            }
        }

        console.log($(obj).attr("checked"));

    var classIds = "";
    $("input[name='menuid[]']").each(function () {
        if ($(this).attr('checked') && $(this).attr("level") == 2) {
            classIds += $(this).val() + ",";

        }
    });

        console.log($("#xuankeStrs").val());
    $.ajax({
        url: "<?php echo U('XuanClass');?>",
        type: "get",
        dataType: "json",
        data: {
            classIds: classIds,
            grade: $("#grade").val(),
            term: $("#term").val(),
            xuankeStrs: $("#xuankeStrs").val(),
            selection: $("#selection").val()
        },
        success: function (data) {
            if (data.msg == "needRemove") {
                if (confirm("所有选中班级的选课时间应该一致，是否需要清空原选课时间，重新添加？") == true) {
                    $.ajax({
                        url: "<?php echo U('node_empty');?>",
                        type: "post",
                        dataType: "json",
                        data: {
                            classIds: classIds,
                            term: $("#term").val(),
                            selection: $("#selection").val()

                        },
                        success: function (data) {
                            if (data.msg == "confilt") {
                                alert("由于这些班级的选课时间已被使用，所以不能删除");
                                //清空所有选中的
                                check_type(num);

                            } else {
                                //ok

                                $("#ids").val("");
                            }
                        }

                    });
                } else {

                    check_type(num);


                }
            } else if (data.msg == "kong") {
                $("#occupyTable td").each(function () {
                    if ($(this).find(".tdText").text() != "x") {
                        $(this).find(".tdText").text("");
                        $(this).css("background-color", "");
                    }
                });
                $("#xuankeStrs").val("");
                $("#ids").val("");
            } else if(data.msg=="lin") {
                $("#xuankeStrs").val(1);
			}else {
                //将结果显示出来
                var xuankeStr = data.msg;
                //  console.log(xuankeStr);

                $("#occupyTable").find("td").each(function (i) {
//                        console.log($(this).find("span").text());
//                        console.log(xuankeStr['node_position']);
//                        if ($(this).find("span").text()==xuankeStr['node_position']) {
                    for (var i = 0; i < xuankeStr.length; i++) {
                        if ($(this).find("span").text() == xuankeStr[i]['node_position']) {
                            $(this).css("background-color", "#BEBEBE");
                            $(this).find(".tdText").text("选修课");
                            var xuankeStrs = "";
                            $("#occupyTable td").each(function () {
                                if ($(this).find(".tdText").text() != "" && $(this).find(".tdText").text() != "x") {
                                    xuankeStrs += $(this).find("span").text() + ";";
                                }
                                $("#xuankeStrs").val(xuankeStrs);
                            });
                        }
                    }


//                        }
                });
                var ids = data.id;
                $("#ids").val(ids);
            }
        },
        error: function (data) {
            alert("查询该班级是否已有选课记录失败");
        }
    });

        console.log(classIds);

    }

    function add_node()
	{
        var classIds = "";
        $("input[name='menuid[]']").each(function () {
            if ($(this).attr('checked') && $(this).attr("level") == 2) {
                classIds += $(this).val() + ",";

            }
        });
        var xuankeStrs = $("#xuankeStrs").val();
        var xuankeStrs = $("#classIds").val(classIds);

        if(!classIds)
		{
		    alert("请选择班级!");
		    return false
		}
		if(!xuankeStrs)
		{
            alert("请选择节次!");
            return false
		}


        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('add_node');?>",
            data:$("#form2").serialize(),

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    $(".xuanke").hide();
                    $(".ztree").children().remove();
                    $("#occupyTable").children().remove();
                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
	}


	//隐藏显示
    function checkshen(obj)
	{
//	    var num = $(obj).val();
	   if($(obj).val()==2)
	   {
	       $(".title-txt.needSH").css("display","block");
	       $(".value-txt.needSH").css("display","table-cell");
           $("input[name='checkTypeTwo']").each(function() {
               if($(this).attr('checked'))
               {
                   $(this).removeAttr('disabled');
               }
           });
	   }else{
           $(".title-txt.needSH").css("display","none");
           $(".value-txt.needSH").css("display","none");
           $(".value-txt.needSH").css("display","none");
           $("input[name='checkTypeTwo']").each(function() {
               if($(this).attr('checked'))
               {
                   $(this).attr('disabled',"disabled");
               }
           });
	   }
	}

	function AddSelect()
	{
	    if($("#term").val()=='')
		{
		    alert("学期不能为空！");
		    return false;
		}
		if($("input[name='begintime']").val()=='' || $("input[name='endtime']").val()=='')
		{
		    alert("时间不能为空！");
		    return false;
		}
		if($("input[name='begintime']").val() >= $("input[name='endtime']").val())
		{
		    alert("起始时间不能大于结束时间");
		    return false;
		}

//	    alert("提交");
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('AddSelect');?>",
            data:$("#form1").serialize(),

            success: function(res) {
              if(res.status)
			  {
			      alert(res.msg);
                  $(".daitan").hide();
                  history.go(0);

			  }else{
                  alert(res.msg);
			  }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
	}

	//查询该学期是否已经设置
    function getSetting(obj){
     ;
       var semesterid = $(obj).val();
//       console.log(semesterid);
       if(!semesterid)
	   {
	       return false
	   }
     console.log(semesterid);
        $.ajax({
            type: "post",
            url: "<?php echo U('getSetting');?>",
            dataType: 'json',
            data: {
                semesterid:$(obj).val(),//学期ID

            },
            success: function(res){
                if(res.status){
                    if (confirm(res.msg)) {
                        Startedit(res);
                    }
                }else{
                    alert(res.msg);
//                    history.go(0);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


	}
	//修改
	function edit(id)
	{
        $.ajax({
            type: "get",
            url: "<?php echo U('edit');?>",
            dataType: 'json',
            data: {
                id:id,//学期ID

            },
            success: function(res){
                if(res.status){
                    console.log(res.data);
                    $(".daitan").show();
                    $("#term").attr("disabled","disabled");
                    $("#term").val(res.data['semesterid']);
                    $("#semesterid").val(res.data['semesterid']);
                    $("#select_id").val(id);
                    Startedit(res);
                }else{
                    alert(res.msg);
                    history.go(0);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
	}

	function Startedit(res)
	{
        $("input[name='begintime']").val(timestampToTime(res.data['begintime']));

        $("input[name='endtime']").val(timestampToTime(res.data['endtime']));

        $("input[name='checkType']").each(function() {
            if($(this).val()==res.data['enroll_audit'])
            {
                $(this).attr( "checked",true);
            }
        });
        if(res.data['enroll_audit']==2)
        {
            $("input[name='checkTypeTwo']").each(function() {



                if($(this).val()==res.data['auditor'])
                {
                    $(this).attr( "checked",true);
                }
                if($(this).attr('checked'))
                {
                    $(this).removeAttr('disabled');
                }
            });
            $(".title-txt.needSH").css("display","block");
            $(".value-txt.needSH").css("display","table-cell");
        }

        $("#workNum").val(res.data['days']);
        $("#forenoon").val(res.data['morning']);
        $("#afternoon").val(res.data['afternoon']);
        $("#evening").val(res.data['evening']);
	}

	//节次设置
    function xuankeClasstime(id,semester)
	{
	    if(id)
		{
            $(".xuanke").show();
		}else{
	        alert("数据有误,请重新打开");

	        return false;
		}

		$(".s_term").val(semester);
	    $("#selection").val(id);
        $.ajax({
            type: "get",
            url: "<?php echo U('getXuanKe');?>",
            dataType: 'json',
            data: {
                id:id,//

            },
            success: function(res){
                if(res.status){
                    console.log(res);
                  $(".ztree").append(res.class_html);
                  $("#occupyTable").append(res.cours_html);

                }else{
                    alert(res.msg);

                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


	}

	//获取天数节次
	function getXuanClass()
	{

	}




    function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        return Y+M+D+h+m+s;
    }
    //时间戳转换
 function datetime(time)
 {
     var date = new Date(time);
     Y = date.getFullYear() + '-';
     M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
     D = date.getDate() + ' ';
     h = date.getHours() + ':';
     m = date.getMinutes() + ':';
     s = date.getSeconds();
     console.log(Y+M+D+h+m+s);
     return  Y+M+D+h+m+s;
 }


    $(".daitan").hide()

    $(".drop").click(
        function(ID) {
            $(".daitan").show()
            l = $(this).text()
            console.log(l);
            $(".dbzr").text(l)
            $(".old_card").text(l);
        }
    )


    $(".guan").click(
        function() {
            $(".daitan").hide()
            $(".title-txt.needSH").css("display","none");
            $(".value-txt.needSH").css("display","none");
            $(".value-txt.needSH").css("display","none");
            $("input[name='checkTypeTwo']").each(function() {
                if($(this).attr('checked'))
                {
                    $(this).attr('disabled',"disabled");
                }
            });
            $("input[name='checkType']").each(function() {
                if($(this).val()==1)
                {
                    $(this).attr( "checked",true);
                }
            });

            $("#term").removeAttr('disabled');
            $("#term").val('');
            $("input[name='begintime']").val('');
            $("input[name='endtime']").val('');
            $("#workNum").val(5);
            $("#forenoon").val(4);
            $("#afternoon").val(4);
            $("#evening").val(0);
        }

    )
    $(".xuanke_guan").click(
        function() {
            $(".xuanke").hide();
          $(".ztree").children().remove();
          $("#occupyTable").children().remove();
        }

    )















    $('.edit').click(function(){

        var name = $(this).parent().parent().find('td:eq(1)').text();
        $('.student_mname').val(name);
        var phone = $(this).parent().parent().find('td:eq(4)').text();
        $('.student_p').val(phone);

        $('.student_address').val($(this).prev().val());
        var in_residence = $(this).parent().parent().find('td:eq(5)').text();

        var self_depid = $(this).parent().parent().find('td:eq(7)').find('.self_depid');

        var card = $(this).parent().parent().find('td:eq(3)').find('.shuzi').text();

        if(card == "设置")
        {
            card = '';
        }

        $('.newcardNo').val(card);
        $('.oldcardNo').val(card);
        $('body').find('.depid').removeAttr('checked');

        var depid =$('body').find('.depid');

        for (var i = 0; i < depid.length; i++) {
            for (var j = 0; j < self_depid.length; j++) {

                if(depid.eq(i).val()==self_depid.eq(j).val())
                {
                    depid.eq(i).attr("checked",true);

                }
            }
        }

        var userid = $(this).attr('data-id');

        var sex  =  $(this).attr('data-sex');

        $('.student_id').val(userid);


        if(in_residence== '否')
        {
            $('.no_res').attr('checked',true);
        }

        if(in_residence == '是')
        {
            $('.ye_res').attr('checked',true)
        }

        if(sex == 0){
            $('.man').attr('checked',true)

        }
        if(sex == 1)
        {
            $('.woman').attr('checked',true);
        }

    })




    $('.gb').click(function(){
        // console.log('dsadsa');
        $('.a0').val('');
        $('.a1').val('');
        $('.a2').val('');
        $('.a3').val('');
        $('.a4').val('');
        $('.a0').removeAttr('data-id')
        $('.a1').removeAttr('data-id')
        $('.a2').removeAttr('data-id')
        $('.a3').removeAttr('data-id')
        $('.a4').removeAttr('data-id')
        $('.a_0').val('');
        $('.a_1').val('');
        $('.a_2').val('');
        $('.a_3').val('');
        $('.a_4').val('');

    })




    $(".dao_close").click(
        function() {
            $(".daoru").hide()
        }

    )





    $(".derive").click(function(){

        if (confirm("确定要导出吗？")) {
            location.href="<?php echo U('stuUser');?>"



        }



    })




    $("#myModal").hide();
    var class_card = [];


    $("#huoqu").click(function() {
        $(".si").hide();
        $(".jiaz").show();
        $(".xuesheng").hide();
        $("#huoqu").attr("class", "active");
        $("#aniu").attr("class", "");
        $(".ci").css("display", "block")
    })
    $("#aniu").click(function() {
        $(".jiaz").hide();
        $(".si").show();
        $(".xuesheng").show();
        $("#huoqu").attr("class", "");
        $("#aniu").attr("class", "active");
        $(".ci").css("display", "none")
    })
    $(".daibanzhuren").click(function() {
        $(".jiaz").hide();
        $(".si").show();
        $(".xuesheng").show();
        $("#huoqu").attr("class", "");
        $("#aniu").attr("class", "active");
        $(".ci").css("display", "none")
        var shuzhi = $(".shuzi", this).text();




        if(shuzhi == "设置") {
            $('.sic').css('display','none');
            $(".xiugai").text("新增卡号：");
        } else {
            $('.sic').css('display','block');
            $(".xiugai").text("修改卡号：");
        }
    })
    $("#huoqu").click(function() {
        var userid = $(".uisid").val();
        // console.log(userid);
        $.ajax({
            type: "post",
            url: "<?php echo U('Teacher/StudentInfo/chaxuan');?>",
            async: true,
            dataType: 'json',
            data: {
                userid: userid
            },
            success: function(res) {
                // console.log(userid);
                res = eval(res.data);


                // console.log(res);
                for(var i = 0; i < res.length; i++) {

                    var cardno = res[i].cardno; //id卡号；
                    var id = res[i].id;

                    var j = "a" + i;

                    var k = "a_" + i;

                    var test = document.getElementsByClassName(j);
                    var hest = document.getElementsByClassName(k);



                    // console.log(test);
                    $(test).val(cardno);

                    $(test).attr('data-id',id);

                    $(hest).val(cardno);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    })
</script>
<script>
    $('#myTab a:first').tab('show');
</script>
<script>
    $("#file-3").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-default",
        fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
    });
    $(document).ready(function() {
        $("#test-upload").fileinput({
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'elErrorContainer': '#errorBlock'
        });
    });
</script>
<script>
    $(function() {
        $('#myTab li:eq(0) a').tab('show');
    });
</script>
<script>
    $("#file-3").fileinput({
        showUpload: false,
        showCaption: false,
        browseClass: "btn btn-default",
        fileType: "any",
        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
    });
    $(document).ready(function() {
        $("#test-upload").fileinput({
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'elErrorContainer': '#errorBlock'
        });
    });
</script>
<script>
    $(".touch").mouseenter(
        function() {
            $(".touch").addClass("touchlei")
        }
    )
    $(".touch").mouseleave(
        function() {
            $(".touch").removeClass("touchlei")
        }
    )
</script>
<script>
    $(".banzhuren").click(
        function() {
            $(".bantan").show()
        }
    )
    $(".banzhuren").click(
        function() {
            aaa = $(this).text()
            $(".bzr").text(aaa)
        }
    )
    $(".xuan").click(
        function() {
            k = $(this).parent().text()
            $(".bzr").text(k)
        }
    )
</script>
<script>
    $(".guan").click(
        function() {
            $(".bantan").hide()
        }

    )
</script>

<script>
    $(".xiala").click(
        function() {
            $(".shou01").slideToggle()
            $(".xshang").toggle()
            $(".bianzi").toggle()
        }

    )
</script>
<script>



</script>
<script>

</script>

<script>
    $(".guan").click(
        function() {
            $(".daitan").hide()
        }

    )
</script>
<script>
    $(".name").hide()
    $(".xuan2").click(
        function() {
            o = $(this).parent().index()
            $(".name").eq(o).toggle()
            $(".dbzr").hide()
        }
    )
</script>
<script type="text/javascript">
    $(".sic").click(
        function() {
            $(".dbzr").empty();
            $('.sic').css('display','none');
        }
    )
</script>
<script>
    $(".subinput").click(
        function() {
            var y = $(this).parents(".subbox").index()
            $(".add_box").eq(y - 1).children(".peizhi").hide()
            if($(this).prop("checked")) {
                $(this).parents(".subject").hide()
                var x = $(this).parent().index()
                $(".add_box").eq(y - 1).children(".kecheng").eq(x).show()
            }
        }
    )
</script>
<script>

</script>
<script>

</script>
<script>

</script>
<script>
    $(".qinshu").hide()
    $(".daibanzhuren1").click(
        function(ID) {
            $(".qinshu").show()
        }
    )
</script>
<script>
    $(".guan1").click(
        function() {
            $(".qinshu").hide()
            $('.qinshuxingming0').val('')
            $('.qinshuxingming1').val('')
            $('.qinshuxingming2').val('')
            $('.qinshuhaoma0').val('')
            $('.oldhaoma0').val('')
            $('.qinshuhaoma1').val('')
            $('.oldhaoma1').val('')
            $('.qinshuhaoma2').val('')
            $('.oldhaoma2').val('')
            $('.qinshuguanxi0').val('')
            $('.qinshuguanxi1').val('')
            $('.qinshuguanxi2').val('')
        }
    )
</script>
</body>

</html>