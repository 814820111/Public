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
       p input{font-family:Microsoft YaHei,"微软雅黑",黑体,Courier New !important;color:black !important; }
  
		</style>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>信息1</title>

		<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
		<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.js"></script>
		<link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
		<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>

		<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
		<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
		<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
		<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
		<script src="/weixiaotong2016/statics/js/jquery.js"></script>
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
			 .select_2{
    	color: black;
    	font-size: 14px;

    }
			
			.picList li {
				margin-bottom: 5px;
			}
			tr .pai,
			tr .pai2 {
				text-align: center;
				    color: black;
			}
			
			tr .pai {
				background-color: #e2e2e2;
			}			
			
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
				padding: 0 10px;
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
			
			.newbox div {
				float: left;
				width: 20%;
				margin-bottom: 10px;
			}
			
			.newbox div input {
				margin-top: -2px;
				margin-right: 5px;
			}
			
			.del {
				width: 14px;
				margin-left: 5px;
				margin-top: -2px;
			}
			
			.add_box {
				border: 1px solid #DDDDDD;
				background-color: #f5f5f5;
				text-align: center;
				width: 551px;
				border-top: none;
				padding: 5px;
			}
			
			.class_box {
				border: 1px solid #DDDDDD;
				background-color: #f5f5f5;
				text-align: center;
				line-height: 35px;
				width: 150px;
				border-top: none;
				border-right: none;

			}
			
			.add_ke {
				float: left;
				margin-right: 10px;
				margin-bottom: 5px;
			}
			
			.sub_lei {
				border: 1px solid #03a9f4;
				background-color: #e3f1fa;
			}
			
			.sou {
				display: none
			}
			
			.del {
				width: 10px;
				display: none;
			}
			
			.del_lei {
				display: block;
				float: right;
				margin-top: 5px;
			}
			
			.zongbox {
				margin-top: 15px;
			}
			.manid{

				color: black;
			}

			.zhike{
				color: black;
				font-style: normal;	
			}
	     
	      .mr20 input	{
	      	color: black;
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
    	height: auto;
    	color: black;
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
	    .modal.fade.in {
    	top: 2%;
    }
    .group_ck{
    	color: black;
    }

			/*	.class_div{border:1px solid red;}*/
		</style>

	</head>

	<body >
		<div class="">
			<ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
				<li class="active">
					<a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">教师管理</a>
				</li>
				<li>
					<a href="<?php echo U('add',array('button_level'=>1));?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">新增教师</a>
				</li>
				<li>
					<a href="<?php echo U('excel');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">导入状态查询</a>
				</li>
			</ul>
			<!--卡号start-->
	 <div style=" background-color:rgba(0,0,0,0.7);    position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="daitan"  >
        <div style=" width:600px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
          <form>
            <div>
              <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">IC卡设置</div>
              <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
            </div>
            <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
              <div class="dbzr"></div>
              <img src="/weixiaotong2016/statics/images/delete.png" class="sic" >
              <div class="clearfix"></div>
            </div>
            <div style=" margin-bottom:10px; margin-left:30px;">
            <span class="Sui"></span> <input type="text" id="card_no" placeholder="卡号长度10位数" style=" margin-top:8px; height:20px;"><input type="hidden"  name="old_card" class="old_card" >
            </div>
            <!-- <div style=" margin-bottom:10px; margin-left:30px;">
                      确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
                    </div> -->
            <div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
              <input type="button" value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='sub_card()'>

            </div>
          </form>
          <!--关闭start-->
          <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="guan">
          <!--关闭end-->
        </div>
      </div>


			<!--卡号end-->


					            <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style=" display: none;">
										  <div class="modal-dialog">
										    <div class="modal-content">
										      <div class="modal-header" style="background: white">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">重置密码</h5>
										        <hr>
										      </div>
										      <div class="modal-body2">
					                
    
										        <p class="text-center">
										          <input type="hidden" class="techar_id" ><br>
                                                  <span style="margin-left: 29px;">教师:</span> &nbsp;<input type="text" name="teacher_mname" class="teacher_mname"><br>
										          <span style="margin-left: 14px;">新密码:</span> &nbsp;<input type="password" class="rel" name="password"><br>
										          <span>确认密码: </span>&nbsp;<input type="password" class="pwd"></p>
										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-default" data-dismiss="modal" style="background: white; color:black; font-weight:bold;">关闭</button>
										        <button class="btn btn-info pwdtj" style="font-weight:bold;" >提交</button>
										      </div>
										   
										    </div>
										  </div>
										</div>


                                        <div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="    display: none;">
										  <div class="modal-dialog">
										    <div class="modal-content">
										      <div class="modal-header" style="background: white">
										        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										        <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">编辑教师资料</h5>
										        <hr style="margin: 0px;" />
										      </div>
										      <div class="modal-body2" style="max-height: 300px;     overflow-y: auto;">
					                           
    
										         <p class="" style="margin-left: 40px;">
										        <input type="hidden" class="techar_id" ><br>
                                                  <span style="margin-left: 29px;">教师:</span> &nbsp;<input type="text" name="teacher_name" class="teacher_cmname" style="height: 15px;" ><br>
										    
										           <span style="margin-left: 29px;">卡号:</span> &nbsp;<input type="text" class="newcardNo" name="newcardNo" style="height: 15px;"><input type="hidden" class="oldcardNo" name="oldcardNo"><br>
										        <span style="margin-left: 29px;">邮箱:</span> &nbsp;<input type="text" name="email" class="email" style="height: 15px;" ><input type="hidden" class="old_email" value > <br>
                                                   联系号码: &nbsp;<input type="text" class="teacher_p" name="rel" style="height: 15px;"><br>
                                                     <span style="margin-right: 123px;">在职状态: &nbsp;<input class="work" type="radio" name="duty" value="1" style="    vertical-align: -3px;"><span style="margin-right: 10px;">&nbsp;在职</span><input type="radio" name="duty" value="2" class="resign"  style="    vertical-align: -3px;"><span>&nbsp;离职</span></span>
                                                         <div style="
                                                      margin-left: 40px; margin-bottom: 10px;">   <span style="    float: left;
    margin-left: 29px; color: black;">角色:</span>
                                                   <span style="  
    display: inline-block;
    margin-left: 10px;"> 
                                                   <?php if(is_array($duty)): foreach($duty as $key=>$vo): ?><input type="checkbox" name="tea_duty" class="tea_duty" style=" vertical-align: -3px;" value="<?php echo ($vo["id"]); ?>">
                                                   <span class="group_ck" style="font-size: 12px; cursor: pointer;margin-left: -3px; margin-right: 3px;"><?php echo ($vo["name"]); ?></span><?php endforeach; endif; ?>
                                                   </span>
                                                    </div>


                                                   <div style="
                                                      margin-left: 40px;">   <span style=" float: left;color: black;
   ">所属分组:</span>
                                                   <span style="  
    display: inline-block;
    margin-left: 10px;"> 
                                                   <?php if(is_array($grop)): foreach($grop as $key=>$vo): ?><input type="checkbox" name="depid" class="depid" style=" vertical-align: -3px;" value="<?php echo ($vo["id"]); ?>">
                                                   <span class="group_ck" style="font-size: 12px; cursor: pointer; margin-left: -3px; margin-right: 3px;"><?php echo ($vo["name"]); ?></span><?php endforeach; endif; ?>
                                                   </span>
                                                    </div>
                                                  
                       
										          </p>

										      </div>
										      <div class="modal-footer">
										        <button type="button" class="btn btn-default" data-dismiss="modal" style="background: white; color:black; font-weight:bold;" >关闭</button>
										        <button class="btn btn-info edit_tj" style="font-weight:bold;" >提交</button>
										      </div>
										   
										    </div>
										  </div>
										</div>

        <!--导入-->
        <div style=" background-color:rgba(0,0,0,0.7); position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="daoru"  >
				<div style=" width:600px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
					
						<div>
							<div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">导入教师数据</div>
							<div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
						</div>
						<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
						
						   <div>
						   	  <p  class="">第一步:</p>
						   	  <hr>
						   	  <a  href="/weixiaotong2016/statics/excel/teacher_model.xls" style="color:#00c1dd;cursor: pointer; ">教师数据导入模板-下载</a>
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
						<!--<div style=" margin-bottom:10px; margin-left:30px;">-->
						<!--<span class="Sui"></span>	-->
						<!--</div>-->
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


        <!--导入end-->


			<!--代班代课start-->
			<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background-color: white;">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

							<div style=" cursor: pointer;">
								<ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
									<li class="active " id="aniu">
										<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">代班设置</a>
									</li>
									<li class=" " id="huoqu">
										<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">代课设置</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="modal-body">
							<div class="hideid">
								<div>
									年级：
									<select class="select_2" name="search_grade" id="grade_info">
										<option value='0'>--请选择--</option>
										<?php if(is_array($grade)): foreach($grade as $key=>$vo): ?><OPTION value="<?php echo ($vo["gradeid"]); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
									</select> &nbsp;&nbsp;
								</div>
								<div style="  overflow-y:scroll; padding:10px; padding-left:10;border: 1px solid gainsboro;" class="class_info">
									<?php if(is_array($class)): foreach($class as $key=>$vo): ?><div class="banji" style=" float:left; width:20%; margin-bottom:10px;cursor:pointer;">
											<div style="width: 20px;height: 20px;position: relative;top: 23px;"></div>
											<input type="checkbox" name="class_else" id="class_chose" value="<?php echo ($vo["id"]); ?>">
											<span class="manid"><?php echo ($vo["classname"]); ?></span>
										</div><?php endforeach; endif; ?>
									<div class="clearfix"></div>
									<div class="newbox">
									</div>
								</div>
							</div>
							<form class="daike_box" style=" display:none;">
								<div style=" overflow-y:scroll; padding-left:0;">
									<table class="juy">
										<tr>
											<th style=" border:1px solid #DDDDDD; background-color:#e2e2e2; width:150px; text-align:center; line-height:25px;">代班</th>
											<th style=" border:1px solid #DDDDDD; background-color:#e2e2e2; width:550px; text-align:center;">所有科目</th>
										</tr>

									</table>

									<div class="subbox">

									</div>
								</div>
								<div class="append_boxke" style="width: 100%;">

									<label style="color: gray;"><i class="fa fa-edit" style="color: #00B7EE;"></i>科目选择</label>
									<?php if(is_array($Wsubject)): foreach($Wsubject as $key=>$vo): ?><span class="kemuzhi" style="color:gray;font-size: 15px;cursor: pointer;margin-right: 10px;">
                                     	<i class="fa fa-upload"style="color: gainsboro;"></i>
                                     	<i class="zhike"><?php echo ($vo["subject"]); ?></i>
                                     	<input class="suiid" type="hidden" value="<?php echo ($vo["id"]); ?>" />
                                     </span><?php endforeach; endif; ?>
								</div>
								<i></i>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-default tijiao" data-dismiss="modal" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;height: 33px;" \>提交更新</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>

			<!--带班代课end-->
			
			<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
				<div class="tab-pane fade in active" id="home">
					<br/>
					<form class="form-horizontal J_ajaxForm" action="<?php echo u('index');?>" method="post">
						<div class="search_type cc mb10">
							<div class="mb10">
								<span class="mr20">
			    年级: 
                      <select class="search_grade" name="search_grade" style=" " id="school_grade" style="height: 30px;">
                        <option value='0'>&nbsp;请选择&nbsp;</option>
                        <?php if(is_array($grade)): foreach($grade as $key=>$vo): $grade_info=$gradeinfo==$vo['gradeid']?"selected":""; ?>
                            <OPTION value="<?php echo ($vo["gradeid"]); ?>" <?php echo ($grade_info); ?>><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                      班级: 
                      <select class="search_class" name="search_class" style="" id="school_class" style="height: 30px;">
                      <input type="hidden" class="newclass" value="<?php echo ($search_class); ?>">
                     
     
                      </select> &nbsp;&nbsp;
                      
                      教师姓名: <input type="text"  class="teacher_name"  value="<?php echo ($teacher_name); ?>"  name="search_name" placeholder="-教师姓名-" style="width: 90px; height: 17px;border-width:1px;">&nbsp;&nbsp;
                      
                      手机号码：<input type="text" class="search_phone" value="<?php echo ($teacher_phone); ?>" name="search_phone" placeholder="-请输入联系号码-" style="width: 120px; height: 17px;border-width:1px;" ><br>
                      <div style="display: inline-block; margin-top: 5px;">
                      
                      卡号: <input type="text" class="teacher_card" value="<?php echo ($teacher_card); ?>" name="search_card" placeholder="-请输入IC卡号-"  style="width: 110px; height: 17px;border-width:1px;">
                       
                      <!-- <input type="text" value="<?php echo ($teacher_class); ?>" name="search_grade" placeholder="-请输入班级-" style="width: 150px; height: 10px;border-width:1px;"> -->

                       
                      

                      <input type="submit" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;   " value="搜索" />
                      <input type="button"  value="导入" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" class="leading" ></a>
                      <input type="button"  value="导出" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" class="derive" >
                      <input type="button" class="qk" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" value="清空"></
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
										<th class="pai" >编号</th>
										<th class="pai">姓名</th>
										<th class="pai">IC卡号</th>
										<th class="pai">带班/带课</th>
										<th class="pai">电话</th>
										<th class="pai">角色</th>
										<th class="pai">教师组</th>
										<th class="pai">微信绑定</th>
										<th class="pai">状态</th>
										<th class="pai">操作</th>
									</tr>
								</thead>
								<?php if(is_array($teacher_info)): foreach($teacher_info as $key=>$vo): $type=array("1"=>"校长","2"=>"副校长","3"=>"主任","4"=>"任课教师","5"=>"教师","6"=>"班主任","7"=>"学校管理员"); $status=array("1"=>"是","0"=>"否"); $sign=empty($vo['teacher_subject'])?'':$vo['teacher_subject']; $tea=empty($vo['teacher_name'])?'-未设置-':$vo['teacher_name']; ?>
									<tr >
										<td class="pai2 cid" ><?php echo ($vo["id"]); ?></td>
										<td class="pai2"><?php echo ($vo["name"]); ?></td>
										
										<td class="pai2 daibanzhuren" style=" color:#00c1dd; cursor:pointer;">
											<?php if($vo["card"] != ''): ?><input type="hidden" class="tea_id" value="<?php echo ($vo["teacherid"]); ?>">
												<span class="zhis"><?php echo ($vo["card"]); ?></span><?php endif; ?>				
											<?php if($vo["card"] == ''): ?><input type="hidden" class="tea_id" value="<?php echo ($vo["teacherid"]); ?>">
											<span class="zhis" style="background-color: transparent;color: #00c1dd;">设置</span><?php endif; ?> 
										</td>
										<td class="pai2 banzhuren banbox" style=" color:#00c1dd; cursor: pointer; ">
											<input type="hidden" class="t_id" value="<?php echo ($vo["id"]); ?>">
											<?php if($sign == ''): ?><div class=" banbox" data-toggle="modal" data-target="#myModal" style="background-color: transparent;color: #00c1dd; text-align: left;">设置</div>
												<input type="hidden" class="laoshiid" value="<?php echo ($vo["id"]); ?>" />
												<input type="hidden" class="zhishu" value="<?php echo ($vo["teacher_classid"]); ?>" />
												<?php else: ?>
												<div class="indeed">
													<input type="hidden" class="laoshiid" value="<?php echo ($vo["id"]); ?>" />
													<input type="hidden" class="zhishu" value="<?php echo ($vo["teacher_classid"]); ?>" />
													<div class="banbox" data-toggle="modal" data-target="#myModal" title="<?php echo ($vo["teacher_subject"]); ?>" style="background-color: transparent;color: #00c1dd;text-align: left; ">
														<?php echo ($vo["teacher_subject"]); ?>
													</div>
												</div><?php endif; ?>
										</td>
										<td class="pai2"><?php echo ($vo["phone"]); ?></td>
										<td class="pai2">
										  <div class="banbox" style="text-align: left; width: 70px;" title="<?php echo ($vo["teacher_duty"]); ?>">
											<?php if(is_array($vo['teacher_set'])): foreach($vo['teacher_set'] as $key=>$so): ?><input type="hidden" class="duty_id" value="<?php echo ($so["id"]); ?>">
												<?php echo ($so["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; ?>
											</div>
										</td>
										
										<td class="pai2" style="">
											<div class="banbox" style="text-align: left; width: 70px;" title="<?php echo ($vo["teacher_duty"]); ?>">
												<?php if(is_array($vo['teacher_set'])): foreach($vo['teacher_set'] as $key=>$so): ?><input type="hidden" class="duty_id" value="<?php echo ($so["id"]); ?>">
													<?php echo ($so["name"]); ?>&nbsp;&nbsp;<?php endforeach; endif; ?>
											</div>
                                        </td>
											
											<?php if($vo['appid'] == null): ?><td class="pai2 banzhuren_else " style=" color:#00c1dd; cursor:pointer; width: 50px;"><a  class="btn btn-success showkey" data-type = "2" id=<?php echo ($vo["id"]); ?>>未绑</a></td>
                                            
                                            <?php else: ?>
                                           
											<td class="pai2 banzhuren_else" style=" color:#00c1dd; cursor:pointer; width: 50px;"><a  class="btn btn-success showkey" data-type = "1" id=<?php echo ($vo["id"]); ?>>已绑</a></td><?php endif; ?> 

											<td class="pai2" style=" color:#00c1dd; cursor:pointer;">
											<?php if($vo['state'] == 1): ?><a style="color:#00c1dd;" data-id="<?php echo ($vo["state"]); ?>">在职</a>
                                            <?php elseif($vo['state'] == 2): ?><a style="color: red;" data-id="<?php echo ($vo["state"]); ?>">离职<a><?php endif; ?>

											</td>
                                            
        



											<td class="pai2">
												
                                                 <a  class="reset"  data-toggle="modal" data-target="#myModal2" style=" color:#00c1dd; cursor: pointer;"  data-na="<?php echo ($vo["name"]); ?>"  data-id="<?php echo ($vo["id"]); ?>">重置密码</a> 

												<a  style=" color:#00c1dd; cursor: pointer" data-id=<?php echo ($vo["id"]); ?> data-info_id="<?php echo ($vo["teacherid"]); ?>"  class="deltec">
													<?php if($vo['stu_count'] != 0): elseif($vo['stu_count'] == 0): ?> 删除<?php endif; ?>
												</a>

                                                 <input type="hidden"  value="<?php echo ($vo["email"]); ?>"> 
												 <a   class="edit" data-toggle="modal"   data-na="<?php echo ($vo["name"]); ?>"  data-id="<?php echo ($vo["id"]); ?>" data-target="#myModal3" href="<?php echo U('edit',array('id'=>$vo['id']));?>" style=" color:#00c1dd;">编辑</a>
											</td>
									</tr><?php endforeach; endif; ?>
							</table>
							<div class="pagination"><?php echo ($Page); ?></div>

						</div>
					</form>

					<div style="height: 50px;"></div>
				</div>

			</div>
			<input type="hidden" class="Loocliassid" />
            <!--存放班级改变时候的班级ID-->
			<input type="hidden" class="cliaasid" />
			<div class="tab-pane fade" id="ios">
			</div>

		</div>
		<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
		<script src="/weixiaotong2016/statics/js/common.js"></script>

		<script type="text/javascript">


   //获取分辨率
     sum = screen.width+screen.height;

   if(sum<'2240')
   {
     $(".modal-body2").css("max-height",'220px');
   }





$(".qk").click(function(){

 location.href="<?php echo U('index');?>";


})




if($("#school_grade").val())
{     

	var newclass = $('body').find(".newclass").val();
	// alert(newclass);
	  $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
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
                    $("#school_class").append("<option value='0'>全部班级</option>");
                }
            });
}


    $(function () {
        $("#school_grade").change(function () {
            $("#school_class").empty();
            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherUtils&a=get_class&grade=" + $("#school_grade").val(), {}, function (data) {
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
			
               //编辑教师信息
               $(".edit").click(function(){
             	var teacherid = $(this).attr("data-id");
             	var teacher_name = $(this).attr("data-na");

            
                var duty = $(this).parent().parent().find('td:eq(8)').find("a").attr("data-id");
                
                if(duty==1)
                {
                   $('.work').attr('checked',true);
                }else{
                  $('.resign').attr('checked',true);
                }

             	$('.email').val($(this).prev().val());
             	$('.old_email').val($(this).prev().val());

             	var self_depid = $(this).parent().parent().find('td:eq(6)').find('.self_depid');

                var self_dutyid = $(this).parent().parent().find('td:eq(5)').find('.duty_id');

                console.log(self_dutyid);

             

             	var card = $(this).parent().parent().find('td:eq(2)').find('.zhis').text();

             	if(card == '设置')
             	{
             		card='';
             	}

             	$('.newcardNo').val(card);
             	$('.oldcardNo').val(card);

             	$('body').find('.depid').removeAttr('checked');
             	$('body').find('.tea_duty').removeAttr('checked');

             	var depid =$('body').find('.depid');

             	var duty_id = $('body').find(".tea_duty");

              for (var i = 0; i < duty_id.length; i++) {
              	for (var j = 0; j < self_dutyid.length; j++) {
             			
             			if(duty_id.eq(i).val()==self_dutyid.eq(j).val())
             			{
             				duty_id.eq(i).attr("checked",true);
             			
             			}
             		}
              	
              }

             	
             	for (var i = 0; i < depid.length; i++) {
             		for (var j = 0; j < self_depid.length; j++) {
             			
             			if(depid.eq(i).val()==self_depid.eq(j).val())
             			{
             				depid.eq(i).attr("checked",true);
             			
             			}
             		}
             	}

             	var phone  = $(this).parent().parent().find('td:eq(4)').text();
             
             	$('.techar_id').val(teacherid);
             	$('.teacher_p').val(phone);
             	$('.teacher_cmname').val(teacher_name);
              
             })              
          
               $('.edit_tj').click(function(){
	               var teacherid = $('.techar_id').val();
	           
	               var teacher = $('.teacher_cmname').val();
	               var rel = $('.teacher_p').val();

	               var  newcardNo = $('.newcardNo').val();
	              
	               var  oldcardNo = $('.oldcardNo').val();

	               var email = $('.email').val();
	               var old_email = $("body").find('.old_email').val();

	          var cbj=document.getElementsByName('duty');
                var type="";
                for(var i=0; i<cbj.length; i++){
                    if(cbj[i].checked){
                        type+=cbj[i].value;
                    }
                }
             

	               // alert(old_email);
	               

	               if(email==old_email)
	               {
	               	 email = '';
	               }
          
	               // alert(email);
	             
	               

               var str=""; 
                 $("[name='depid']:checked").each(function(){ 
					str+=$(this).val()+",";  
					// alert($(this).val()); 
					}) 
				var group = [];
				var strs = str.split(",");//分割字符串


				  for(var j=0;j<strs.length-1;j++){
				   	   var c_class=strs[j];
				   	   group.push({
				   	   	  dmpid:c_class
				   	   })
				   }

				   // console.log(group);
				   // return false;


				   var strge=""; 
                 $("[name='tea_duty']:checked").each(function(){ 
					strge+=$(this).val()+",";  
					// alert($(this).val()); 
					}) 
				var duty = [];
				var strsg = strge.split(",");//分割字符串


				  for(var j=0;j<strsg.length-1;j++){
				   	   var c_duty=strsg[j];
				   	   duty.push({
				   	   	  dutyid:c_duty
				   	   })
				   }
				
             
	               
                   
                   if(rel == '')
                   {
                   	layer.msg('联系号码不能为空', {
                                icon: 2
                                ,shade: 0.01,
                            });
                   	return false;
                   }

                   editAjax(teacherid,rel,group,newcardNo,oldcardNo,teacher,email,type,duty);
	             
             });


               //编辑密码函数
              function editAjax(teacherid,rel,group,newcardNo,oldcardNo,teacher,email,type,duty)
              {
		        $.ajax({
		            type:'get',
		            url: "<?php echo U('Teacher/TeacherInfo/edit');?>",
		            dataType:'json',
		            data: {
						'teacherid': teacherid,
						'rel':rel,
						'group':group,
						'newcardNo':newcardNo,
						'oldcardNo':oldcardNo,
						'name':teacher,
						'email':email,
						'state':type,
						'duty':duty,
					},
		            success:function(data){
		                 console.log(data);
		                if(data.status){
		                	alert('修改成功');
		                    location.reload(); 

		                  // alert('成功!');
		                }else{
		                    alert('修改失败');
		                }
		            },
		            //请求失败
		            error:function(){
		               alert('请求失败')
		            }
		        })
              }



 


              //重置密码ajax
             $(".reset").click(function(){
             	var teacherid = $(this).attr("data-id");
             	var teacher_name = $(this).attr("data-na");
             	console.log(teacher_name);	
             	$('.techar_id').val(teacherid);
             	$('.teacher_mname').val(teacher_name);
              
             })
          

             $('.pwdtj').click(function(){
	               var teacherid = $('.techar_id').val();
	               var password = $('.pwd').val();
	               var teacher = $('.teacher_mname').val();
	               var rel = $('.rel').val();
	               console.log(rel);
                   
                   if(password == '' || rel == '')
                   {
                   	layer.msg('密码不能为空', {
                                icon: 2
                                ,shade: 0.01,
                            });
                   	return false;
                   }

	               if(password!=rel){
	               	 layer.msg('两次密码输入的不一致', {
                                icon: 2
                                ,shade: 0.01,
                            });
	               	return false;
	               }
	               // console.log(teacherid);
                   

	               // console.log(pwd);
	               // console.log(js);
	               reAjax(teacherid,password,teacher)

             })


           //重置密码函数
              function reAjax(teacherid,password,teacher)
              {
		        $.ajax({
		            type:'get',
		            url: "<?php echo U('Teacher/TeacherInfo/password');?>",
		            dataType:'json',
		            data: {
						'teacherid': teacherid,
						'password':password,
					},
		            success:function(data){
		                 //console.log(data);
		                if(data.status){
		                  alert('修改成功')
		                }else{
		                    alert('修改失败');
		                }
		            },
		            //请求失败
		            error:function(){
		               alert('请求失败')
		            }
		        })
              }
 
             //点击触发导出
             $(".derive").click(function(){

              if (confirm("确定要导出吗？")) {
						 
						 location.href="/weixiaotong2016/index.php?g=teacher&m=TeacherInfo&a=expUser&search_grade="+ $(".search_grade").val()+"&search_class="+$(".search_class").val()+"&search_name="+$(".teacher_name").val()+"&search_card="+$(".teacher_card").val()+"&search_phone="+$(".search_phone").val()+"&button_level="+1+"";
			                  
                            //   layer.msg('导出成功!', {
                            //     icon: 6
                            //     ,shade: 0.01,
                            // });

						  }
			      
     
            
             })

             //点击删除
            $(".deltec").click(function(){
               var teacherid = $(this).attr("data-id");
               var info_id = $(this).attr("data-info_id");

               var obj = $(this).parent().parent('tr');

                layer.msg('你确定要删除该老师吗？', {
						  time: 0 //不自动关闭
						  ,btn: ['删除', '取消']
						  ,yes: function(index){
						 
						         // var obj = $(this).parent().parent('tr');
			            //           console.log(obj);
			                    delAjax(teacherid,info_id,obj);
						  }
			      });
   


            });

            function delAjax(teacherid,info_id,obj)
          {
		        $.ajax({
		            type:'get',
		            url: "<?php echo U('Teacher/TeacherInfo/delete');?>",
		            dataType:'json',
		            data: {
						'teacherid': teacherid,
						'info_id': info_id,
						'button_level':1,
					},
		            success:function(data){
		                 console.log(data);
		                if(data.status){
		                    // console.log('点赞成功')
                            layer.msg('教师账号'+data.msg+'删除成功', {
                                icon: 1	
                                ,shade: 0.01,
                            });

		                 obj.remove();
		                }else{
		                    alert(data.info);
		                }
		            },

		            //请求失败
		            error:function(){
		               alert('请求失败')
		            }
		        })
       }







           //点击查看ID
           $(".showkey").click(function(){
               var teacherid = $(this).attr("id");
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
					url: "<?php echo U('Teacher/TeacherInfo/bindingkey');?>",
					dataType:'json',
					data: {
						'teacherid': teacherid,

					},
					success: function(res) {

					    if(res.status)
						{
                            var data = eval(res.data);

                            //TODO 因为只有一个绑定码 可以直接处理
                            var bindKey = data[0]["bindingkey"];
                            var tid = "#"+teacherid;
                            $(tid).text(bindKey);
						}else{
					        alert(res.info);
						}


							// console.log(data.msg[0].bindingkey);
							// obj.text(data.msg[0].bindingkey);

					},
					error: function() {
						alert('系统错误,请稍后重试');
					}
				});
           });
            
        
       





			$("#myModal").hide();
			$(".tijiao").click(function() {
				var teacherid = $(".Loocliassid").val();
				var class_si = $(".cliaasid").val();
				var class_subject = [];
				$(".jiang").each(function() {
					var fanhui = $(this).val()
					var fanclass = $(this).parent().prev().val();
					if(fanhui != "") {
						var strs = fanhui.split(","); //字符分割
						for(var i = 0; i < strs.length - 1; i++) {
							var c_id = strs[i];
							class_subject.push({
								c_id: fanclass,
								subject:c_id
							})
						}
					}
				})
				var class_banji = [];
				var strsa=class_si.split(","); //字符分割
				   for(var j=0;j<strsa.length-1;j++){
				   	   var c_class=strsa[j];
				   	   class_banji.push({
				   	   	  classid:c_class
				   	   })
				   }


                    $.ajax({
					type: "get",
					async: false,
					url: "<?php echo U('Teacher/TeacherInfo/teacher_class_subject');?>",
					data: {
						'teacherid': teacherid,
						'class_subject': class_subject,
						'class_banji':class_banji
					  },
					success: function(msg) {
						window.location.reload(); //刷新当前页面.
					},
				error: function() {
						alert('系统错误,请稍后重试');
					}
				  });
			})
			$("#huoqu").click(function() {
				$(".hideid").hide()
				$(".daike_box").css("display", "block")
				$("#huoqu").attr("class", "active");
				$("#aniu").attr("class", "");

			})
			$("#aniu").click(function() {
				$("#huoqu").attr("class", "");
				$("#aniu").attr("class", "active");
				$(".hideid").show();
				$(".daike_box").css("display", "none");
			})

			//根据老师带班情况让复选选中
			$(".banbox").click(function() {
				$(".hideid").show();
			    $(".daike_box").css("display", "none");
			    $("#huoqu").attr("class", "");
				$("#aniu").attr("class", "active");
				$(".banji input").prop("checked", false);
				var fuxuan = $(".zhishu", this).val();
				console.log(fuxuan);
				var laoclassid = $(".laoshiid", this).val();
				// console.log(laoclassid)
				$(".Loocliassid").val(laoclassid);
				$(".cliaasid").val(fuxuan); //用于通过对应的班级选择对应的课程
				var strs = fuxuan.split(","); //字符分割 
				for(var i = 0; i < strs.length - 1; i++) {
					var shuzid = strs[i];
					$(".banji input").each(function() {
						var fuxuan = $(this).val()
						if(shuzid == fuxuan) {
							$(this).prop("checked", true);
						}
					})
				}
				//老师带啦多少班级的ajax请求
				var teacherid = $(".Loocliassid").val();
				$(".dai").remove();
				$.ajax({
					type: "post",
					url: '/weixiaotong2016/index.php/?g=Teacher&m=TeacherInfo&a=teacher_class',
					async: true,
					dataType: 'json',
					data: {
						teacherid: teacherid
					},
					success: function(res) {
					    console.log(res);
                        if(res.aaa=='1')
                        {
                            alert(res.url);
                            alert(res.newUrl);
                            return false;

                        }
						var html = "";
						res = eval(res.date);
							for(var i = 0; i < res.length; i++) {
							var classname = res[i].classname; //班级的名称						
							var lengthig = res[i].teacher_su.length;
							var classid = "";
							var classids = res[i].classid; //班级ID
							html += '<tr class="dai" style="cursor: pointer;">'
							html += '<td class="class_box"style="color: black;background-color:white">' + classname + '</td>   '
							html += '<td class="add_box" style="color: black;background-color:white">'
							html += '<input class="jig" type="hidden"  value="' + classids + '" /> ';
							html += '<div class="jian">'
							if(lengthig == 0) {
								html += '<span class="peizhi"><button type="button" class="btn btn-primary"style="background-color: #06C08E;border-radius: 20px;height: 24px;"><span class="fa fa-plus"style="position: relative;bottom: 5px;" >设置</span></button></span>'
							} else {
								for(var g = 0; g < res[i].teacher_su.length; g++) {
									var cd = res[i].teacher_su[g].id + ",";
									classid += cd
									var bao = res[i].teacher_su[g].subject;
							html += '<span name="dian" style="border: 1px solid #03a9f4;margin-left: 5px;color: black;">' + bao + '<i class="fa fa-remove dianji" style="color: #00B7EE;position: relative;bottom: 3px;"></i><input class="sui" type="hidden"  value="' + cd + '" /> </span>'
								}
							html += '<button type="button" class="btn btn-primary py"style="background-color: #06C08E;border-radius: 20px;height: 24px;display: none;position: relative;left: 39.5%;"><span  class="fa fa-plus"style="position: relative;bottom: 5px;">设置</span></button>'

							}
							html += '<input class="pin" type="hidden"  value="0" /> '
							html += '<span class="xuanze"style="display: none;color:#00c1dd;">请点击下方课程进行配置</span>'
							html += '<input class="jiang" type="hidden"  value="' + classid + '" /> ';
							html += '</div>'
							html += '</td> '

							html += '</tr>'
						}
						$(".juy").append(html);
						//点击删除选取的课程
						$('[name="dian"]').click(function() {						
							var Huo = $(this).parent().children("input:last-child").val();
							alert("111");
							var shuzhi = $(".sui", this).val();
							var xiazhi = Huo.replace(shuzhi, "");
							$(this).parent().children("input:last-child").val(xiazhi);
							$(".dianji", this).parent().remove();
						})

						$(".jian").click(function() {
							var zongname = $('[name="dian"]', this).text();
							$(".pin").val("0")
							$(".pin", this).val("1");
							$(".jiang").each(function() {
								var fuxuan = $(this).val()
								if(fuxuan == "") {
									$(this).parent().children("button:first-child").css("display", "block");
								}
							})

							$(".xuanze").css("display", "none");
							$(".xuanze", this).css("display", "block");
							$(".py", this).css("display", "none");
							$(".peizhi").show();
							$(".peizhi", this).hide();

						})

					},
					error: function() {
						alert('系统错误,请稍后重试');
					}
				});
			})
			$(document).on('click', '.jian', function() {
				var zongname = $('[name="dian"]', this).text();
				$(".pin").val("0")
				$(".pin", this).val("1");
				$(".jiang").each(function() {
					var fuxuan = $(this).val()

					if(fuxuan == "") {

						$(this).parent().children("button:first-child").css("display", "block");

					}
				})

				if(zongname == "") {
					$(".xuanze").css("display", "none");
					$(".xuanze", this).css("display", "block");
					$(".py", this).css("display", "none");
					$(".peizhi").show();
					$(".peizhi", this).hide();
				}
			})
			$(document).on('click', '[name="dian"]', function() {

				var Huo = $(this).parent().children("input:last-child").val();

				var shuzhi = $(".sui", this).val();
				var xiazhi = Huo.replace(shuzhi, "");

				$(this).parent().children("input:last-child").val(xiazhi);
				$(".dianji", this).parent().remove();
			})
			$(document).on('click', '.kemuzhi', function() {
				var zhiu = $(".zhike", this).text();
				var suiid = $(".suiid", this).val() + ",";
				var i = 0;
				htmls = '<span name="dian" style="border: 1px solid #03a9f4;margin-left: 5px;color: black;">' + zhiu + '<i class="fa fa-remove dianji" style="color: #00B7EE;position: relative;bottom: 3px;"></i><input class="sui" type="hidden"  value="' + suiid + '" /> </span>'
				$(".pin").each(function() {
					var fu = $(this).val();
					if(fu == 1) {
						i++;

						var shukuang = $(this).next().next().val();

						var indesr = shukuang.indexOf(suiid);
						if(indesr < 0) {
							$(this).parent().prepend(htmls)
							var jiuyshuju = shukuang + suiid
							$(this).next().next().val(jiuyshuju)
						} else {
							alert("该老师已经认职该班级" + zhiu)
						}

					}
				})
				if(i == 0) {
					alert("请选择你要添加课程的班级")
				}

			})

			// 点击div 让复选框选中
			$(".banji").click(function() {
				var namekecheng = $(".manid", this).text();
				var html = "";
				var classid = "";
				var checkboxdanxuan = $("input[type='checkbox']", this).is(':checked');
			
				var cliaasid = $(".cliaasid").val();
			
				var checkboxid = $("input[type='checkbox']", this).val() + ",";
		
				var iuy = $("input[type='checkbox']", this).val();
                  
                var indesr = cliaasid.indexOf(checkboxid);  
              
				if(checkboxdanxuan == false) {
                    

					$("input[type='checkbox']", this).prop("checked", true);
					// console.log(cliaasid);
					var jiahe = cliaasid + checkboxid;
					// console.log(jiahe);
					$(".cliaasid").val(jiahe);
					html += '<tr class="dai" style="cursor: pointer;">'
					html += '<td class="class_box"style="color: black">' + namekecheng + '</td>   '
					html += '<td class="add_box">'
					html += '<input  type="hidden"  value="' + iuy + '" /> ';
					html += '<div class="jian">'
					html += '<span class="peizhi"><button type="button" class="btn btn-primary"style="background-color: #06C08E;border-radius: 20px;height: 24px;"><span class="fa fa-plus"style="position: relative;bottom: 5px;" >设置</span></button></span>'
					html += '<input class="pin" type="hidden"  value="0" /> '
					html += '<span class="xuanze"style="display: none;color:#00c1dd;">请点击下方课程进行配置</span>'
					html += '<input class="jiang" type="hidden"  value="' + classid + '" /> ';
					html += '</div>'
					html += '</td> '
					html += '</tr>'
					$(".juy").append(html);
				} else {
					$("input[type='checkbox']", this).prop("checked", false);
					var xiazhi = cliaasid.replace(checkboxid, "");
				
					$(".cliaasid").val(xiazhi);
					$(".class_box").each(function() {
						var fuxuanid = $(this).text()
						if(namekecheng == fuxuanid) {
							$(this).parent().remove();
						}
					})
				}
			})

			$(".daike").click(
				function() {
					$(".append_box tr").remove();
					$(".subbox div").remove();
					var boxes = document.getElementsByName("class_else");
					class_val = [];
					for(k in boxes) {
						if(boxes[k].checked)
							class_val.push(boxes[k].value);
					}
					$.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherInfo&a=teacher_class&teacherid=" + tea_id, {}, function(date) {
						if(date.statues == "success") {
							for(k = 0; k < date.date.length; k++) {
								$(".append_box").append("<tr><td class=class_box>" + date.date[k]["classname"] + "</td><td class=add_box><span class=peizhi>请点击下方课程进行配置</span><span class=clearfix></span></td></tr>");
								$(".subbox").append("<div class=zongbox><div class=class_div>" + date.date[k]["classname"] + "<input type=hidden name=classid_box value=" + date.date[k]["classid"] + "></div><div class=class_subject id=one></div><div class=clearfix></div></div>");
								for(i = 0; i < date.date[k]["subject"].length; i++) {
									$(".class_subject").eq(k).append("<div class=subject onClick=this.children[0].click()><input type=checkbox name=subinput id=two class=subinput value=" + date.date[k]["subject"][i]["id"] + ">" + date.date[k]["subject"][i]["subject"] + "<img src=/weixiaotong2016/statics/images/cha.png class=del></div>");
								}
								for(peo = 0; peo < date.date[k]["teacher_su"].length; peo++) {
									var boxe_else = document.getElementsByName("subinput");
									for(pro = 0; pro < boxe_else.length; pro++) {
										if(boxe_else[pro].value == date.date[k]["teacher_su"][peo]["id"]) {
											boxe_else[pro].checked = true;
											var suoyin = $(".subinput").parent().eq(pro).text()
											var out = $(".subinput").parents(".zongbox").index()
											$(".add_box").eq(out).children("span").remove()
											$(".add_box").eq(out).append("<div class=add_ke id=quxiao>" + suoyin + "<span class=sou>" + pro + "</span>" + "</div>")
											$(".subinput").parent().eq(pro).addClass("sub_lei")
											$(".subinput").parent().eq(pro).children(".del").addClass("del_lei")
											break
										}
									}
								}
							}
						}
					})
				}
			)
			$("#grade_info").change(function() {
				$(".banji").remove();
				$(".newbox").empty();
				$.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherInfo&a=class_json&gradeid=" + $("#grade_info").val(), {}, function(data) {
					if(data.status == "success") {
						for(var key in data.data) {
							$(".newbox").append("<div class=gra_cla>" + "<input type=checkbox id=test name=test value=" + data.data[key]["id"] + ">" + data.data[key]["classname"] + "</div>");
						}
						$.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherInfo&a=teacher_class&teacherid=" + tea_id, {}, function(date) {
							if(date.statues == "success") {
								for(var words in date.date) {
									var t_cla = date.date[words]["classid"];
									var boxes = document.getElementsByName("test");
									for(i = 0; i < boxes.length; i++) {
										if(boxes[i].value == t_cla) {
											boxes[i].checked = true;
											break
										}
									}
								}
							}
						});
					}
				});
			});
		</script>
		<script>
			$("body").on("click", "#two", function() {
				var sub_text = $(this).parent().text()
				var x = $(this).parents(".zongbox").index()
				var y = $(this).parent().index()
				var z = $(".add_ke").length
				if($(this).prop("checked")) {
					$(this).parent().addClass("sub_lei")
					$(this).parent().children(".del").addClass("del_lei")
					$(".add_box").eq(x).children("span").remove()
					$(".add_box").eq(x).append("<div class=add_ke id=quxiao>" + sub_text + "<span class=sou>" + y + "</span>" + "</div>")
				} else {
					var num = 0
					$(this).parent().removeClass("sub_lei")
					$(this).parent().children(".del").removeClass("del_lei")
					for(num = 0; num < z; num++) {
						var arr = $(".add_ke").eq(num).children(".sou").text()
						if(y == arr) {
							$(".add_ke").eq(num).remove()

						}
					}
				}

			});
		</script>

		
		<script type="text/javascript">
			//弹窗中通过年级选班级
			function sub_class() {
				if($("#grade_info").val() == 0) {
					var obj = document.getElementsByName("class_else");
				} else {
					var obj = document.getElementsByName("test");
				}
				check_val = [];
				for(k in obj) {
					if(obj[k].checked)
						check_val.push(obj[k].value);
				}
				$.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Teacher/TeacherInfo/save_relation');?>",
					data: {
						'teacherid': tea_id,
						'class_arr': check_val
					},
					success: function(msg) {
						history.go(0);
					}
				});
			}
			//IC卡号设置
			function sub_card() {
				var card = $("#card_no").val();
                var old_card = $('.old_card').val();
                if(card == old_card )
                {
        	         alert('与上次卡号相同');  
                    return false;
                }
               
                if(card == '')
                {     
                   alert('卡号不能为空');         	
                	return false
                }
                var lengths=card.length;	
                if(lengths=="10"){
                $.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Teacher/TeacherInfo/card_save');?>",
                    dataType: 'json',
					data: {
						'teacherid': teacher_idea,
						'card': card,
						'old_card':old_card,
					},
					success: function(data) {
                        if(data.status)
                        {
                            history.go(0);
                        }else{
                            alert(data.info);
                        }

                    }
				});
                }else{
                	alert("请输入十位数的ID卡号")
                }

			}
		</script>
		<script>
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
			$(".daibanzhuren").click(
				function() {
					w = $(this).parent().index()
					console.log(w);
					$(".chuanzhi").val(w)
					teacher_idea = $(this).children(".tea_id").val();


				}
			)
			$(".daibanzhuren").click(function(){
				var zhis= $(".zhis",this).text();
				$(".old_card").val(zhis);
             


				console.log(zhis);
				if(zhis=="设置"){
                    $('.sic').css('display','none');
					$(".Sui").text("新增IC卡");
				}else{
					$(".Sui").text("修改IC卡号");
					$('.sic').css('display','block');
				}
			})

			function sub_qrcj() {
				var main_id = w;
				var teachers = $("input[name='teachers']").val();
				// var main_id = $("input[name='main_id']").val();
				$.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Teacher/ClassManage/teachers');?>",
					data: {
						'teachers': teachers,
						'main_id': main_id
					},
					success: function(msg) {
						history.go(0);
					}
				});
			}
		</script>
		<!--设置卡号-->
		<script>
			$(".daitan").hide()
			$(".daibanzhuren").click(
				function(ID) {
					$(".daitan").show()
					l = $(this).text()
					console.log(l);
					$(".dbzr").text(l)
					$(".old_card").text(l);
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



   <!--导入excel-->
		<script>
			$(".daoru").hide()
			$(".leading").click(
				function(ID) {
					$(".daoru").show()
					l = $(this).text()
					$(".dbzr").text(l)
				}
			)
		</script>

		<script>
			$(".dao_close").click(
				function() {
					$(".daoru").hide()
				}

			)
		</script>


   <!--导入excel end-->


		<script type="text/javascript">
            $(".sic").click(
                function() {

                    var cardno = $.trim($(this).prev().text());




                    var showcard = $('body').find(".zhis");



                    $.ajax({
                        type: "get",
                        async: false,
                        dataType:'json',
                        url: "<?php echo U('Teacher/TeacherInfo/delcard');?>",
                        data: {
                            cardno:cardno,


                        },
                        success: function(data) {
                            console.log(data);
                            if(data.status){

                                $(".dbzr").empty();
                                $('.sic').css('display','none');
                                $('.Sui').text('新增卡号');
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
//			$(".sic").click(
//				function() {
//					$(".dbzr").empty()
//					$('.sic').css('display','none');
//				}
//			)
		</script>
		<!--<script>
$(".subinput").click(
 			function(){
				var y=$(this).parents(".subbox").index()
				$(".add_box").eq(y-1).children(".peizhi").hide()
				if($(this).prop("checked")){
					$(this).parents(".subject").hide()
					var x=$(this).parent().index()
					$(".add_box").eq(y-1).children(".kecheng").eq(x).show()
					}
				}
 )
 </script>
 <script>
 $(".kecheng").click(
 		function(){
			var x=$(this).parents("tr").index()
			var y=$(this).index()
			$(this).hide()
			$(".subbox").eq(x-1).find(".subject").eq(y-1).show()
			$(".subbox").eq(x-1).find(".subject").eq(y-1).click()
			}
 )
 </script>-->

	</body>

</html>