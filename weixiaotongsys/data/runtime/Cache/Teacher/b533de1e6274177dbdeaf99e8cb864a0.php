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
<html>

	<head>
		<style>
            p{font-family:Microsoft YaHei,"微软雅黑",黑体,Courier New !important;color:black !important;}
       p input{font-family:Microsoft YaHei,"微软雅黑",黑体,Courier New !important;color:black !important;  }
		</style>

		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>信息1</title>
		<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />

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

    .pager input{
    	height: 11px;
    }
    .pager{
    	margin-top: 0px;
    	margin-bottom: 10px；
    }
    .modal.fade.in {
    	top: 2%;
    }
        select{
    	width: auto;
    }

        .banzhuren_else a{
     font-size: 10px;	
      padding-bottom: 5px;	
      padding-top: 5px;	
      padding-right: 10px;	
      padding-left: 10px;
    }
   .banbox {
		width: 120px;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;

	}
	    .group_ck{
    	color: black;
    }
    span{
    	color:black;
    }
   div{
   	color: black;
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
					<a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">学生管理</a>
				</li>

				<li class="">
					<a href="<?php echo U('stumange');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">学生班级管理</a>
				</li>
				<li>
					<a href="<?php echo U('add',array('button_level'=>1));?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">新增学生</a>
				</li>
				<li>
					<a href="<?php echo U('excel');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">导入状态查询</a>
				</li>

				
			</ul>
			<input type="hidden" class="school" value="<?php echo ($schoolid); ?>">
			<!--亲属信息start-->
			<div style=" background-color:rgba(0,0,0,0.7); position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="qinshu">
				<div style=" width:800px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
					<form>
						<div>
							<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px; color:#61c881;">修改亲属信息</div>
							<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
						</div>
						<div style=" margin-top:8px;">
							<div style=" float:left; width:14px; height:14px; border-radius:50%; background-color:#e84e40; margin-top:3px; margin-right:10px;"></div>
							<div style=" float:left;">所有卡号均为10位数字，不足将自动在前面补0</div>
							<div class="clearfix"></div>
						</div>
						<div style=" margin-top:8px; margin-bottom:13px;">
							姓名：<span class="stuhuan"></span><span style=" margin-left:20px; margin-right:20px;"></span>学生编号：<span class="stuhua"></span>
						</div>
						<div style=" margin-bottom:20px;">
							亲情卡号一：
							<span style=" margin-left:10px; margin-right:5px;">姓名</span>
							<input type="text" name="qinshuxingming1" class="qinshuxingming0" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:130px; color: black;" placeholder="请输入内容" value="">
							<span style=" margin-left:10px; margin-right:5px;">号码 </span>
							<input type="text" name="qinshuhaoma1"  class="qinshuhaoma0" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:200px; color: black;" placeholder="请输入内容" value="">
							<input type="hidden" name="oldhaoma1"  class="oldhaoma0" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:200px; color: black;" placeholder="请输入内容" value="">
							<span style=" margin-left:10px; margin-right:5px;">关系</span>
							
							<input type="text" name="qinshuguanxi1"  class="qinshuguanxi0" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:124px;color: black;" placeholder="请输入内容" >
						</div>
						<div style=" margin-bottom:20px;">
							亲情卡号二：
							<span style=" margin-left:10px; margin-right:5px;">姓名</span>
							<input type="text" name="qinshuxingming2"  class="qinshuxingming1" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:130px;color: black;" placeholder="请输入内容">
							<span style=" margin-left:10px; margin-right:5px;">号码 </span>
							<input type="text" name="qinshuhaoma2" class="qinshuhaoma1"  style="margin-bottom:10px; margin-top: 5px; height: 14px; margin-left:5px; width:200px;color: black;" placeholder="请输入内容">
							<input type="hidden" name="oldhaoma2"  class="oldhaoma1" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; height: 14px; width:200px;color: black;" placeholder="请输入内容" value="">
							<span style=" margin-left:10px; margin-right:5px;">关系</span>
							<input type="text" name="qinshuguanxi2"  class="qinshuguanxi1" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:124px;color: black;" placeholder="请输入内容" >
						</div>
						<div style=" margin-bottom:20px;">
							亲情卡号三：
							<span style=" margin-left:10px; margin-right:5px;">姓名</span>
							<input type="text" name="qinshuxingming3"  class="qinshuxingming2" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:130px;color: black;" placeholder="请输入内容">
							<span style=" margin-left:10px; margin-right:5px;">号码 </span>
							<input type="text" name="qinshuhaoma3"  class="qinshuhaoma2" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:200px;color: black;" placeholder="请输入内容">
							<input type="hidden" name="oldhaoma3"  class="oldhaoma2" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:200px;color: black;" placeholder="请输入内容" value="">
							<span style=" margin-left:10px; margin-right:5px;">关系</span>
							<input type="text" name="qinshuguanxi3"  class="qinshuguanxi2" style="margin-bottom:10px; height: 14px; margin-top: 5px; margin-left:5px; width:124px;color: black;" placeholder="请输入内容" >
						</div>
						<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
							<input type="submit" value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='sub_qinshu()'>

						</div>
					</form>
					<!--关闭start-->
					<img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="guan1">
					<!--关闭end-->
				</div>
			</div>

			<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"  style="background: white">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">IC卡设置</h5>
						</div>
						<div class="modal-body">

							<!--卡号end-->
							<div>
								<div style=" cursor: pointer;">
									<ul class=" nav-tabs" style="height:30px; list-style:none;">
										<li class="active " id="aniu">
											<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">学生IC卡设置</a>
										</li>
										<li class=" " id="huoqu">
											<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">家长IC卡设置</a>
										</li>
									</ul>
								</div>
							</div>
							<form class="xuesheng">
								<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
									<div class="dbzr"></div>
									<img src="/weixiaotong2016/statics/images/delete.png" class="sic">
									<div class="clearfix"></div>
								</div>
								<div style=" margin-bottom:10px; margin-left:30px;">
									<span class="xiugai">新增号码：</span> <input type="text" id="newICcard" name="newICcard" placeholder="卡号长度10位数" maxlength="10">
									<input type="hidden" name="stu_old_card" class="stu_old_card">
								</div>

								<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
									<!--<input type="submit" value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" '>-->

								</div>
							</form>

							<div class="jiaz" style="margin-top: 10px;cursor: pointer;">
								<div style=" margin-top:8px;">
									<div style=" float:left; width:14px; height:14px; border-radius:50%; background-color:#e84e40;  margin-right:10px;"></div>
									<div style=" float:left;">所有卡号均为10位数字，不足将自动在前面补0</div>
									<div class="clearfix"></div>
								</div>
								<div>
									<span>家长卡一：</span>
									<input type="text" class="a0" name="card" data-id=""/>
									<input type="hidden" class="a_0" name="h_card">
								</div>
								<div>
									<span>家长卡二：</span>
									<input type="text" class="a1" name="card" data-id=""/>
									<input type="hidden" class="a_1" name="h_card">
								</div>
								<div>
									<span>家长卡三：</span>
									<input type="text" class="a2" name="card" data-id=""/>
									<input type="hidden" class="a_2" name="h_card"> 
								</div>
								<div>
									<span>家长卡四：</span>
									<input type="text" class="a3" name="card" data-id=""/>
									<input type="hidden" class="a_3" name="h_card">
								</div>
								<div>
									<span>家长卡五：</span>
									<input type="text" class="a4" name="card" data-id=""/>
									<input type="hidden" class="a_4" name="h_card">
								</div>
								<div>
									<span>其他卡号：</span>
									<input type="text" class="a5" name="card" data-id="" style="width: 400px;" maxlength="45" data-true = "1">
									<input type="hidden" class="a_5" name="h_card">
								</div>
								<div><span style="color: red;">若多过5条，请在“其他家长卡号”处用“,”隔开，系统将统一处理。(如：1000000001,1000000002)；</span></div>
							</div>
						</div>
						<div class="modal-footer">

							<button type="button" class="btn btn-default gb" data-dismiss="modal" style="background: white; color:black; font-weight:bold;">关闭</button>
							<button type="button" class="btn btn-info si" style="display: none;float: right;font-weight:bold;" onclick='sub_qrcj()'>提交更改</button>
							<button type="button" class="btn btn-info ci" style="display: none;float: right;font-weight:bold;">提交更改</button>

						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>

         <!--导入-->
              <div style=" background-color:rgba(0,0,0,0.7); position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="daoru"  >
				<div style=" width:600px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
					
						<div>
							<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">导入学生数据</div>
							<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
						</div>
						<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
						
						   <div>
						   	  <p  class="">第一步:</p>
						   	  <hr>
						   	  <a  href="/weixiaotong2016/statics/excel/student.xlsx" style="color:#00c1dd;cursor: pointer; ">学生数据导入模板-下载</a>
						   	  <hr>
						   	  <p>第二步:</p>
						   	  <hr>
						   	  <p>选择要导入的文件:

                              <form  action="<?php echo U('ImpUser');?>" method="post" enctype="multipart/form-data">
                              <input type="file" name="import">
                              <input type="hidden" name="button_level" value="1">
                              <input type="hidden" name="table" value="tablename"/><br><br>
                              <input type="submit" value="导入" class="btn btn-info">&nbsp;&nbsp;&nbsp;
                              <a class="btn btn-danger dao_close">取消</a>
                              	
                              </form>
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


        <!--导入end-->             <form action="<?php echo u('edit_post');?>" method="post" style="margin: 0px 0px 0px 0px;">
   
	                                        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="   display: none;">
											  <div class="modal-dialog">
											    <div class="modal-content">
											      <div class="modal-header" style="background: white">
											        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
											        <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">编辑学生资料</h5>
											        <hr style="margin: 0px;" />
											      </div>
											      <div class="modal-body2" style="    max-height: 300px;     overflow-y: auto;">
						                           
	    
											         <p class="" style="margin-left: 40px;">
											        <input type="hidden" class="student_id" name="student_id" ><br>
														 <!--头像-->
														 <input type='hidden' name='smeta[thumb]' id='thumb' value=''>
														 <span style="    margin-left: 29px;">头像:</span> <a href='javascript:void(0);' onclick="flashupload_self('thumb_images', '附件上传','thumb',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','','');return false;">

														 <img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb_preview'  style='cursor:hand; margin-left: 5px; margin-bottom: 10px; width: 60px;height: 55px;' /></a><br>
														 <span style="    margin-left: 29px;">学生:</span> &nbsp;<input type="text" name="student_name" class="student_mname" style="height: 15px;"><br>
											           家长电话: &nbsp;<input type="text" class="student_p" name="rel" style="height: 15px;"><br>
											           <!--家庭住址: &nbsp;<input type="text" class="student_address" name="address" style="height: 15px;"><br>-->
											          <span style="margin-left: 29px;">卡号:</span> &nbsp;<input type="text" class="newcardNo" name="newcardNo" style="height: 15px;"> <input type="hidden" class="oldcardNo" name="oldcardNo"><br>
											         

											          <span style="    margin-left: 29px;">性别: &nbsp;<input class="man" type="radio" name="sex" value="0"><span style="margin-right: 38px;">&nbsp;男</span><input type="radio" name="sex" value="1" class="woman" ><span>&nbsp;女</span></span><br>
											          <span style="margin-right: 121px;">是否住校: &nbsp;<input type="radio" name="in_residence" value="1" class="ye_res"><span style="margin-right: 38px;">&nbsp;是</span><input type="radio" name="in_residence" value="2"  class="no_res"><span>&nbsp;否</span></span><br>
                                                     <div style="    margin-left: 40px;
                                                      ">   <span style="float: left; margin-left: -1px; color: black;" >所属分组:</span>
                                                   <span style="  
    display: inline-block;
    margin-left: 10px;"> 
                                                   <?php if(is_array($grop)): foreach($grop as $key=>$vo): ?><input type="checkbox" name="depid[]" class="depid" style=" vertical-align: -3px;" value="<?php echo ($vo["id"]); ?>">
                                                      <span class="group_ck" style="font-size: 12px; cursor: pointer;margin-left: -3px; margin-right: 3px;"><?php echo ($vo["name"]); ?></span><?php endforeach; endif; ?>
                                                   </span>
                                                    </div>

                                                    <div style="
                                                         width: 379px;">
                                                      <span class="guardian" style="cursor: pointer; color: #4c8efc;">学生附加信息<span style="color:#0b7ebf;" class="icon-chevron-down"></span></span> 
                                                      <div style="display: none; margin-left: 40px;" class="fujia">
                                                      	<span style="margin-left: 29px;">籍贯:</span> &nbsp;<input type="text" class="native_place" name="native_place" style="height: 15px; color: black;"><br>
                                                      <span style="margin-left: 29px;">学号:</span> &nbsp;<input type="text" class="stu_id" name="stu_id" style="height: 15px; color: black;"><br>
                                                      	<span style="color: black;">家庭住址: </span>&nbsp;<input type="text" class="student_address" name="address" style="height: 15px;color: black;" ><br>
                                                     
                                                      </div>
                                                    	
                                                    </div>

											         



											       </p>

											      </div>
											      <div class="modal-footer">
											        <button type="button" class="btn btn-default" data-dismiss="modal" style="background: white; color:black; font-weight:bold;" >关闭</button>
											        <input class="btn btn-info " style="font-weight:bold;" type="submit" >
											      </div>
											   
											    </div>
											  </div>
										</div>
                                  </form>





			<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
				<div class="tab-pane fade in active" id="home">
					<br/>
					<form class="form-horizontal J_ajaxForm" action="<?php echo u('index');?>" method="get" id="form1" style="margin: 0px 0px 0px 0px;">
						<div class="search_type cc mb10">
							<div class="mb10">
								<span class="mr20">
                      年级: 
                      <select class="select_2" name="search_grade" style=" height: 30px" id="school_grade">
                        <option value='0'>&nbsp;&nbsp;请选择&nbsp;</option>
                        <?php if(is_array($grade)): foreach($grade as $key=>$vo): $grade_info=$gradeinfo==$vo['gradeid']?"selected":""; ?>
                            <OPTION value="<?php echo ($vo["gradeid"]); ?>" <?php echo ($grade_info); ?>><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;                      班级: 
                      <select class="select_2" name="search_class" style=" height: 30px" id="school_class">
                         <input type="hidden" class="newclass" value="<?php echo ($classinfo); ?>">
                     
     
                      </select> &nbsp;&nbsp;&nbsp;
                      <div style="display: inline-block; margin-left: 8px;">学生姓名: 
                      <input type="text" class="search_student_name" name="student_name" placeholder="-请输入-" style="width:100px; height: 15px;border-width:1px;" value="<?php echo ($studentname); ?>"> &nbsp;&nbsp;</div><br>
                      <div style="display: inline-block; margin-top: 5px;">
                      学号: 
                      <input type="text" class="select_2" name="student_card" placeholder="-请输入-" style="width:76px; height: 15px;border-width:1px;" value="<?php echo ($studentcard); ?>"> &nbsp;&nbsp;
                      卡号: 
                      <input type="text" class="select_2" name="iccard" placeholder="-请输入-" style="width:100px; height: 15px;border-width:1px;" value="<?php echo ($searchiccard); ?>"> &nbsp;&nbsp;
                      家长手机号: 
                      <input type="text" class="search_phone" name="phone" placeholder="-请输入-" style="width:120px; height: 15px;	px;border-width:1px;" value="<?php echo ($parent_phone); ?>">
                      <input type="submit" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;" value="搜索" />
                       <input type="button"  value="导入" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" class="leading" >
                      <input type="button" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;"  class="derive" value="导出" />
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
										<th class="pai" style=" border-left: none;border-width: 0.5px;">班级</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">姓名</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">学号</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">IC卡号</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">家长电话</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">是否住校</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">班级</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">分组</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">微信绑定</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;">服务开通</th>
										<th class="pai" style=" border-left: none;border-width: 0.5px;border-right: none">操作</th>
									</tr>
								</thead>
								<?php if(is_array($student)): foreach($student as $key=>$vo): ?><!-- <?php $type=array("1"=>"班主任","2"=>"带班老师"); $status=array("1"=>"是","0"=>"否"); $sign=empty($vo['teacher_subject'])?'':$vo['teacher_subject']; $tea=empty($vo['teacher_name'])?'-未设置-':$vo['teacher_name']; ?> -->
									<tr>
										<td class="pai2"><?php echo ($vo["classname"]); ?></td>
										<td class="pai2 stuname"><?php echo ($vo["student_name"]); ?></td>
										<td class="pai2 stuid" name="card"><?php echo ($vo["stu_id"]); ?></td>
										<td class="pai2 daibanzhuren" style="width: 100px;">
											<?php if($vo["cardNo"] != ''): ?><input type="hidden" value="<?php echo ($vo["userid"]); ?>">
												<button class="btn btn-primary btn-lg shuzi" data-toggle="modal" data-target="#myModal" style="background-color: transparent;color: #00c1dd;"><?php echo ($vo["cardNo"]); ?></button><?php endif; ?>
											<?php if($vo["cardNo"] == ''): ?><input type="hidden" value="<?php echo ($vo["userid"]); ?>">
												<button class="btn btn-primary btn-lg shuzi" data-toggle="modal" data-target="#myModal" style="background-color: transparent;color: #00c1dd;">设置</button><?php endif; ?>
										</td>

										<td class="pai2" width="100"><?php echo ($vo["phone"]); ?></td>
										<td class="pai2"><?php echo ($vo["in_residence"]); ?></td>
										<td class="pai2"><?php echo ($vo["classname"]); ?></td>
										<td class="pai2">
										  <div class="banbox" title="<?php echo ($vo["department_list"]); ?>" style="text-align: left;">
											<?php if(is_array($vo['student_department'])): foreach($vo['student_department'] as $key=>$so): echo ($so["name"]); ?>&nbsp;
												<input type="hidden" value="<?php echo ($so["id"]); ?>" class="self_depid"><?php endforeach; endif; ?>
                                          </div>
										</td>
										<?php if($vo['appid'] == null): ?><td class="pai2 banzhuren_else" style=" color:#00c1dd; cursor:pointer; width: 50px;"><a   class="btn btn-success showkey" data-type = "2" id=<?php echo ($vo["userid"]); ?>>未绑</a></td>
                                             <?php else: ?>
                                           

											<td class="pai2 banzhuren_else" style=" color:#00c1dd; cursor:pointer; width: 50px;"><a   class="btn btn-success showkey" data-type = "1" id=<?php echo ($vo["userid"]); ?>>已绑</a></td><?php endif; ?> 
										<td class="pai2"><?php echo ($vo["kaitong"]); ?></td>
										<td class="pai2">
											<a href="<?php echo U('delete',array('id'=>$vo['userid'],'button_level'=>1));?>" class="J_ajax_del" style=" color:#00c1dd;">
												<?php if($vo['stu_count'] != 0): elseif($vo['stu_count'] == 0): ?> 删除<?php endif; ?>
											</a>
											<input type="hidden" value="<?php echo ($vo["address"]); ?>">
											<a data-id = '<?php echo ($vo["userid"]); ?>' data-sex = '<?php echo ($vo["sex"]); ?>' data-photo = '<?php echo ($vo["photo"]); ?>'  data-place='<?php echo ($vo["native_place"]); ?>' data-target="#myModal3" data-toggle="modal"  class="edit" href="<?php echo U('change',array('id'=>$vo['userid']));?>" style=" color:#00c1dd;">
												 修改
											</a>
											<!--<a href="#" class="daibanzhuren1" style=" color:#00c1dd;"><input type="hidden" value="<?php echo ($vo["userid"]); ?>">亲属信息</a>-->
										</td>
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
		<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>
		<script type="text/javascript">
			//全局变量
//			var GV = {
//				DIMAUB: "/",
//				JS_ROOT: "statics/js/",
//				TOKEN: ""
//			};
		</script>
		<script>
    //获取分辨率
     sum = screen.width+screen.height;

   if(sum<'2240')
   {
     $(".modal-body2").css("max-height",'220px');
   }

 

 //查看ID
     $(".showkey").click(function(){
               var studentid = $(this).attr("id");
               var type = $(this).attr("data-type");
   
               var obj = $(this).text();
               
               if(obj!='已绑' && obj!='未绑')
              { 
              	if(type==1)
              	{
              	obj=$(this).text('已绑');
                }else{
                	obj=$(this).text('未绑');
                }
              	return;
              }

              $.ajax({
					type: "post",
					// async: false,
					url: "<?php echo U('Teacher/StudentInfo/bindingkey');?>",
					dataType:'json',
					data: {
						'studentid': studentid
					},
					success: function(res) {
						var data = eval(res.data);
						//TODO 因为只有一个绑定码 可以直接处理
						var bindKey = data[0]["bindingkey"];
						var tid = "#"+studentid;
						$(tid).text(bindKey);
						  
							// console.log(data.msg[0].bindingkey);
							// obj.text(data.msg[0].bindingkey);

					},
					error: function() {
						alert('系统错误,请稍后重试');
					}
				});
           });
            




  $('.guardian').click(function(){
  var aa = $(this).next()
  // alert("aaa");
  $(this).find('span:eq(0)').attr('class','icon-chevron-up')
       
   if(aa.css('display')=='none')
   {
    aa.css('display','block');
    console.log($(this).find('span:eq(0)').attr('class','icon-chevron-up'));
   }else{
    aa.css('display','none');
    $(this).find('span:eq(0)').attr('class','icon-chevron-down')
   }

  })






if($("#school_grade").val())
{     

	var newclass = $('body').find(".newclass").val();
	// alert(newclass);
	  $.getJSON("/weixiaotong2016/index.php?g=Teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
                if (data.status == "success") {
                    $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
                    for (var key in data.data) {

                    	if(newclass==data.data[key]["id"] ){

                        $("#school_class").append("<option value=" + data.data[key]["id"] + " selected>" + data.data[key]["classname"] + "</option>");
                    }else{
                    	$("#school_class").append("<option value=" + data.data[key]["id"] + " >" + data.data[key]["classname"] + "</option>");
                    }

                    }
                }
                if (data.status == "error") {
                    $("#school_class").append("<option value='0'>&nbsp;全部班级</option>");
                }
            });
}


//    $(function () {
//        $("#school_grade").change(function () {
//            $("#school_class").empty();
//            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=Plan&a=class_json&grade=" + $("#school_grade").val(), {}, function (data) {
//                if (data.status == "success") {
//                    $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
//                    for (var key in data.data) {
//                        $("#school_class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</option>");
//                    }
//                }
//                if (data.status == "error") {
//                    $("#school_class").append("<option value='0'>没有班级</option>");
//                }
//            });
//        });
//    });

    $(function () {
        $("#school_grade").change(function () {
            $("#school_class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=Teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
                if (data.status == "success") {
                    $("#school_class").append("<option value=0>" + "请选择班级" + "</option>");
                    for (var key in data.data) {
                        $("#school_class").append("<option value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</option>");
                    }
                }
                if (data.status == "error") {
                    $("#school_class").append("<option value='0'>没有班级</option>");
                }
            });
        });
    });





		$('.group_ck').click(function(){

         var checked = $(this).prev().attr('checked');

             if(checked){

           	 $(this).prev().removeAttr("checked");
           }else{
           	 $(this).prev().attr("checked",true)
           }

		})




    


 $('.edit').click(function(){

  var photo = $(this).attr("data-photo");

  if(photo)
  {
      $("#thumb_preview").attr("src",'/weixiaotong2016/uploads/microblog/'+photo+'');
      $("#thumb").val('/weixiaotong2016/uploads/microblog/'+photo+'');
  }

  $("#thumb_preview").attr("src");
 var name = $(this).parent().parent().find('td:eq(1)').text();
  $('.student_mname').val(name);
  var phone = $(this).parent().parent().find('td:eq(4)').text();
  $('.student_p').val(phone);



  $('.fujia').css("display",'none')

  $(".guardian").find("span:eq(0)").attr('class','icon-chevron-down')

  $(".stu_id").val($(this).parent().parent().find('td:eq(2)').text());
  $(".native_place").val($(this).attr('data-place'));
  // $(".add).val($(this).attr('data-place'));

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
        $('.a5').val('');
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
        $('.a_5').val('');

    })

     	$(".daoru").hide()
			$(".leading").click(
				function(ID) {
					$(".daoru").show()
					l = $(this).text()
					$(".dbzr").text(l)
				}
			)


     $(".dao_close").click(
				function() {
					$(".daoru").hide()
				}

			)





       $(".derive").click(function(){

       // var gradeid = 	$('#school_grade').val();
                    
	    if (confirm("确定要导出吗？")) {
	              // location.href="<?php echo U('stuUser');?>"
	location.href="/weixiaotong2016/index.php?g=teacher&m=StudentInfo&a=expUser&search_grade="+ $("[name='search_grade']").val()+"&search_class="+$("[name='search_class']").val()+"&student_name="+$(".search_student_name").val()+"&student_card="+$("[name='student_card']").val()+"&iccard="+$("[name='iccard']").val()+"&phone="+$(".search_phone").val()+"&button_level="+1+"";
	         //    $.ajax({
		        //     type:'get',
		        //     url: "<?php echo U('Teacher/StudentInfo/expUser');?>",
		        //     dataType:'json',
		        //     data: $("#form1").serialize(),
		        //     success:function(data){
		        //          //console.log(data);
		        //          alert('aaa');
		              
		        //     },
		        //     //请求失败
		        //     error:function(){
		        //        alert('请求失败')
		        //     }
		        // })            
	                           

	     }        
	               
     
            
       })




			$("#myModal").hide();
			var class_card = [];

			$(".ci").click(function() {
				var userid=$(".uisid").val();
				$(".jiaz input[name='card']").each(function() {
					
                  var k = $(this).next().val();
             
					var f = $(this).val();

                    //标识为其他卡号
                    if($(this).attr("data-true")==1)
                    {
                        var fcard5 = new Array();

                        var kcard5 = new Array();
                        fcard5 = f.split(",");



                        kcard5 = k.split(",");

                        if(fcard5.length>kcard5.length)
                        {
                            var count = fcard5.length;
                        }else{
                            var count = kcard5.length;
                        }


                        for(var i = 0; i < count; i++) {
                            if(kcard5[i]!=fcard5[i] && fcard5[i]=='')
                            {
                                alert("111");
                                class_card.push({
                                    cardNo: 1,
                                    old_card:kcard5[i],
                                })
                                continue;
                            }

                            if(kcard5[i]!=fcard5[i] && fcard5[i]==undefined)
                            {

                                class_card.push({
                                    cardNo: 1,
                                    old_card:kcard5[i],
                                })
                                continue;
                            }


                            if(fcard5[i]!=kcard5[i]) {
                                if (fcard5[i]) {

                                    var card_us = card_length(fcard5[i]);
                                }


                                class_card.push({
                                    cardNo: card_us,
                                    old_card:kcard5[i],
                                })

                            }



                        }

                        return true
                    }

				   
                    // var c = $(this).attr('data-id');
                    
                    // console.log(f);
                    if(k!=f && f=='')
                    {
                        class_card.push({
                            cardNo: 1,
                            old_card:k,
                        })
                    }
                 if(k==f)
                 {   
                 	 var f = '';
            
                 }
        

					if(f != "") {
						var lengthzhi = f.length;
						if(lengthzhi < 10) {
							var ui = 10 - lengthzhi;
							var us = "";
							for(var i = 0; i < ui; i++) {
								var j = "0";
								us += j;
							}
							var f = us + f;
						}						
						class_card.push({
							cardNo: f,
							old_card:k,
						})

					}

				})
	            $.ajax({
					type: "get",
					async: false,
					url: "<?php echo U('Teacher/StudentInfo/jiaadd');?>",
					data: {
						class_card:class_card,
						userid:userid

					},
					success: function(msg) {
						history.go(0);
					}
				});
			})
		function card_length(card)
		{
			var lengthzhi = card.length;

			if(lengthzhi > 10)
			{

				return false;
			}
			if(lengthzhi < 10) {
				var ui = 10 - lengthzhi;
				var us = "";
				for(var i = 0; i < ui; i++) {
					var j = "0";
					us += j;
				}
				var card = us + card;
			}
			return card;

		}
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
			$(".daibanzhuren").click(
				function() {
					w = $(this).children().val()
					$(".chuanzhi").val(w)
					$(".uisid").val(w);

				}
			)

			function sub_qrcj() {
				var userid = w;
				console.log(userid);
				var stu_old_card = $("input[name='stu_old_card']").val();

				var cardNo = $("input[name='newICcard']").val();

              

				if (cardNo=='') {
					alert('卡号不能为空');
					return false;
				}
				if(cardNo == stu_old_card)
				{
					alert('卡号不能与上次的相同')
					return false;
				}
				var lengthzhi = cardNo.length;
				if(lengthzhi < 10) {
					var ui = 10 - lengthzhi;
					var us = "";
					for(var i = 0; i < ui; i++) {
						var j = "0";
						us += j;
					}
					var cardNo = us + cardNo;
				}
				$.ajax({
					type: "get",
                    dataType: 'json',
					async: false,
					url: "<?php echo U('Teacher/StudentInfo/updateICcard');?>",
					data: {
						'userid': userid,
						'cardNo': cardNo,
						'stu_old_card':stu_old_card,
					},
					success: function(data) {

					    if(data.status)
						{
						    console.log(data);
                           history.go(0);
						}else{
					        alert(data.info);
						}

						//history.go(0);
					}
				});
			}
		</script>
		<script>
			$(".daitan").hide()
			$(".daibanzhuren").click(
				function(ID) {
					$(".daitan").show()
					l = $(".shuzi",this).text();

					$(".dbzr").text(l)
					console.log(l);
					$(".stu_old_card").val(l);
				}
			)
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

                    var cardno = $.trim($(this).prev().text());




                    var showcard = $('body').find(".shuzi");



                    $.ajax({
                        type: "get",
                        async: false,
                        dataType:'json',
                        url: "<?php echo U('Teacher/StudentInfo/delcard');?>",
                        data: {
                            cardno:cardno,


                        },
                        success: function(data) {
                            console.log(data);
                            if(data.status){

                                $(".dbzr").empty();
                                $('.sic').css('display','none');
                                $('.xiugai').text('新增卡号');
                                // console.log('点赞成功')
                                for (var i = 0; i < showcard.length; i++) {
                                    if(showcard.eq(i).text()==cardno)
                                    {
                                        showcard.eq(i).text("设置");
                                    }
                                }

                            }else{
                                alert(data.info);
                            }
                        },
                        //请求失败
                        error:function(){
                            alert('请求失败');
                        }
                    });









                }
            )




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
			$(".kecheng").click(
				function() {
					var x = $(this).parents("tr").index()
					var y = $(this).index()
					$(this).hide()
					$(".subbox").eq(x - 1).find(".subject").eq(y - 1).show()
					$(".subbox").eq(x - 1).find(".subject").eq(y - 1).click()
				}
			)
		</script>
		<script>
			$(".daiban").addClass("dailei")
			$(".daike").click(
				function() {
					$(this).addClass("dailei")
					$(this).siblings(".daiban").removeClass("dailei")
					$(".daike_box").show()
					$(".daiban_box").hide()
				}
			)
			$(".daiban").click(
				function() {
					$(this).addClass("dailei")
					$(this).siblings(".daike").removeClass("dailei")
					$(".daiban_box").show()
					$(".daike_box").hide()
				}
			)
		</script>
		<script>
			$(".daibanzhuren1").click(
				function() {
					stud = $(this).children().val()
					$(".chuanzhi").val(stud)
					var stuname = $(this).parent().siblings(".stuname").text()
					$(".stuhuan").text(stuname)
					var stuid = $(this).parent().siblings(".stuid").text();
					$(".stuhua").text(stuid);

				      $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Teacher/StudentInfo/showqinshu');?>",
					data: {
						studentid:stud,
						

					},
					success: function(data) {
						console.log(data);
						if(data.status){
                           for(var i = 0; i < data.msg.length; i++) {
							
							var name = data.msg[i].name; //姓名；
							var phone = data.msg[i].phone; //手机
							var relation = data.msg[i].appellation//关系 
							// console.log(relation);
						

							var j = "qinshuxingming" + i;

							var k = "qinshuhaoma" + i;

							var c = "qinshuguanxi"+i;

							var d = "oldhaoma"+i;
							// console.log(c);
                            
							var test = document.getElementsByClassName(j);
							var hest = document.getElementsByClassName(k);
                            var old =  document.getElementsByClassName(d); 
							var rela = document.getElementsByClassName(c);

							// console.log(rela);
                             
                             
                              
							// console.log(test);
							$(test).val(name);

							// $(test).attr('data-id',id);

							 $(old).val(phone);

							$(hest).val(phone);

							$(rela).val(relation);
						}



							                         
		                }else{
		                    alert('查看失败');
		                }
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});


				}
			)

			function sub_qinshu() {

				var studentid = stud;
				console.log(studentid);
                
                var schoolid = $('body').find('.school').val();
                console.log(schoolid);



		

				var arr1 = new Array();
				arr1[0] = $("input[name='qinshuxingming1']").val();
				arr1[1] = $("input[name='qinshuhaoma1']").val();
				arr1[2] = $("input[name='qinshuguanxi1']").val();
				arr1[3] = $("input[name='oldhaoma1']").val();
                
                
			
				var arr2 = new Array();
				arr2[0] = $("input[name='qinshuxingming2']").val();
				arr2[1] = $("input[name='qinshuhaoma2']").val()
				arr2[2] = $("input[name='qinshuguanxi2']").val();
				arr2[3] = $("input[name='oldhaoma2']").val();
				 
				

				var arr3 = new Array();
				arr3[0] = $("input[name='qinshuxingming3']").val();
				arr3[1] = $("input[name='qinshuhaoma3']").val();
				arr3[2] = $("input[name='qinshuguanxi3']").val();
				arr3[3] = $("input[name='oldhaoma3']").val();

		
				
				$.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Teacher/StudentInfo/qinshu');?>",
					data: {
						'qinshu1[]': arr1,
						'qinshu2[]': arr2,
						'qinshu3[]': arr3,
						'studentid': studentid,
						'schoolid':schoolid
					},
					success: function(msg) {
						history.go(0);
					}
				});
			}
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