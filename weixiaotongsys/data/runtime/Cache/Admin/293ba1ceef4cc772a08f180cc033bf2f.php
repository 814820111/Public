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
    <![endif]-->
    <link href="/weixiaotong2016/statics/chosen/chosen.css" rel="stylesheet"/>
	<link href="/weixiaotong2016/statics/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/weixiaotong2016/statics/simpleboot/font-awesome/4.2.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <link href="/weixiaotong2016/tpl_admin/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
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
var GV = {
    DIMAUB: "/weixiaotong2016/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/validate.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
         label.error{
            display: inline-block;
            margin: 0;
            color: red;
            margin-left: 10px;
        }
	</style><?php endif; ?>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<style>


	.wraps {
		width: 120px;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;
		color: black;
	}
	
	.chzn-container-single .chzn-single {
		position: relative;
		top: 12px;
		height: 29px;
	}
	
	.mohu {
		width: 100px;

		bottom: 30px;
		left: 30px;
		background-color: whitesmoke;
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

	table td{
		color: black;
	}		
    
    span {
    	color: black;
    }

    div{
    	color: black;
    }

    img{
    	width: 60px;
    	height: 55px;
    }
    .showkey{
     font-size: 10px;	
      padding-bottom: 3px;	
      padding-top: 3px;	
      padding-right: 10px;	
      padding-left: 10px;
    }


</style>


<body class="J_scroll_fixed">

	<div class="wrap J_check_wrap">
		<ul class="nav nav-tabs">
			<li class="active">
				<a href="javascript:;">所有学生</a>
			</li>
			<li>
				<!--<a href="<?php echo U('Student/add',array('school'=>empty($term['schoolid'])?'':$term['schoolid']));?>" target="_self">添加学生</a>-->
				<a  id="add_student" onclick="add_student(this)"  data-school ='' style="cursor:pointer;" target="_self">添加学生</a>
			</li>
			<li>
				<a href="<?php echo U('Student/excel_list');?>" target="_self">查看导入数据</a>
			</li>
		
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Student/index');?>" style=" padding: 12px;">
			<div class="search_type cc mb10">
				<div class="mb10">

					<span class="mr20">
				     	省份:
						<select  class="province"  name="province" id="province" style="width: 105px;">
							<option value="">
                     
                        省级选择&nbsp;
                        &nbsp;
                       
                        </option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?> 
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>
						<input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
						市级:
						<select class="select_1" name="citys" id="citys" style="width: 105px;">
                               <option value="">选择市级</option>
						</select>
						<input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
						区级:
						<select class="select_3" name="message_type" id="message_type" style="width: 105px;">
							 <option value="0">选择区域</option>
						</select>
						学校：
				  <select data-placeholder="输入关键字。。。" name="schoolid" id="viewOLanguage" class="chzn-select"  tabindex="2" >
                    <option value=""></option>
                   </select>

                   <input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
						</span>
				</div>
               <div class="mb10" >
				   <span class="mr20">
               年级:

				   <select class="select_4" name="grade" id="grade" style="width: 105px;">
					   <option value="">选择年级</option>
				   </select>
				   班级:
				   <input type="hidden" class="new_grade" value="<?php echo ($new_grade); ?>">
				   <select class="select_5" name="classs" id="classs" style="width: 105px;">
					   <option value="">选择班级</option>
				   </select>
				   <input type="hidden" class="new_classs" value="<?php echo ($new_classs); ?>">
查询&nbsp;
                   <span style="width: 45%; margin-top: 13px; ">
						<select class="tiaojian" name="tiaojian" style="width: 105px;">
						 
						    <option value="0">
                     
                        查询类型&nbsp;
                        &nbsp;</option>
						  
							<option value="name"  <?php if($tiaojian==name) echo("selected");?> >学生名字</option>
					
							<option value="cardno" <?php if($tiaojian==cardno) echo("selected");?>>学生卡号</option>
						
							<option value="names" <?php if($tiaojian==names) echo("selected");?>>家长名字</option>
						
							<option value="phone" <?php if($tiaojian==phone) echo("selected");?>>家长号码</option>
						</select>
				            <input type="text" placeholder="请输入" name="shuzhi" class="zhi"  id="tiaojiancontent" value="<?php echo ($shuzhi); ?>" style="width: 100px;">

						</span>
						<!-- 时间：
						<input type="text" name="start_time" class="J_date" value="<?php echo ((isset($formget["start_time"]) && ($formget["start_time"] !== ""))?($formget["start_time"]):''); ?>" style="width: 80px;" autocomplete="off">- -->
						<!-- <input type="text" class="J_date" name="end_time" value="<?php echo ($formget["end_time"]); ?>" style="width: 80px;" autocomplete="off"> &nbsp; &nbsp; -->
						<div style="       display: inline-block; margin-top: 8px; margin-left: 30px;">
                       <input type="submit" class=" btn btn-primary ss" style=""  value="搜索" />&nbsp;&nbsp;
                        
                        
						<a class=" btn btn-danger" href="<?php echo U('student');?>">导入</a>&nbsp;&nbsp;
                        

						<input type="button" class=" btn btn-success daochu" value="导出" />&nbsp;&nbsp;
                        
                        <a class=" btn btn-primary" href="<?php echo U('idupload');?>">导入学号卡号</a>&nbsp;&nbsp;

						<a class=" btn btn-danger" href="<?php echo U('Student/index');?>">清空</a>

						<!-- <a class="btn btn-danger drop" >退学</a> -->
						</div>
					   <div style="margin-top: 8px; ">
						   <a class=" btn btn-danger " onclick="del_parent_card(1)">批量删除家长卡</a>
						   <a class=" btn btn-danger" onclick="del_parent_card(2)">删除全校家长卡</a>
						   <a class=" btn btn-danger" onclick="all_del_student()">批量删除学生</a>
						   <a class=" btn btn-danger" onclick="class_del_student()">按班级删除学生</a>


					   </div>

				   </span>
                     </div>
			</div>
		</form>

	<!--退学弹窗start-->

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

	<!--退学弹窗end-->


      <!-- 亲属关系 -->
      
  	<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width: 700px; left: 45%;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"  style="background: white">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;"></span>&nbsp;亲属关系</h5>
						</div>
						<div class="modal-body">

							<input type="hidden" class="school">
							<div>
								
							</div>
							<form class="">
								<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
								
								
									<div class="clearfix"></div>
								</div>
								<div style=" margin-bottom:10px; margin-left:30px;">
							 <form>
												
												<div style=" margin-top:8px;">
													<div style=" float:left; width:14px; height:14px; border-radius:50%; background-color:#e84e40; margin-top:3px; margin-right:10px;"></div>
													<div style=" float:left;">该栏目填写的是学生亲属号码</div>
													<div class="clearfix"></div>
												</div>
												<div style=" margin-top:8px; margin-bottom:13px;">
													姓名：<span class="stuhuan" style="color:#3a87ad;"></span><span style=" margin-left:20px; margin-right:20px;"></span>
												</div>
												<div style=" margin-bottom:20px;">
													亲情卡号一：
													<span style=" margin-left:10px; margin-right:5px;">姓名</span>
													<input type="text" name="qinshuxingming1" class="qinshuxingming0" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:90px;" placeholder="请输入内容" value="">
													<span style=" margin-left:10px; margin-right:5px;">号码 </span>
													<input type="text" name="qinshuhaoma1"  class="qinshuhaoma0" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:108px;" placeholder="请输入内容" value="">
													<input type="hidden" name="oldhaoma1"  class="oldhaoma0" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:200px;" placeholder="请输入内容" value="">
													<span style=" margin-left:10px; margin-right:5px;">关系</span>
													
													<input type="text" name="qinshuguanxi1"  class="qinshuguanxi0" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:106px;" placeholder="请输入内容" >
												</div>
												<div style=" margin-bottom:20px;">
													亲情卡号二：
													<span style=" margin-left:10px; margin-right:5px;">姓名</span>
													<input type="text" name="qinshuxingming2"  class="qinshuxingming1" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:90px;" placeholder="请输入内容">
													<span style=" margin-left:10px; margin-right:5px;">号码 </span>
													<input type="text" name="qinshuhaoma2" class="qinshuhaoma1"  style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:108px;" placeholder="请输入内容">
													<input type="hidden" name="oldhaoma2"  class="oldhaoma1" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:200px;" placeholder="请输入内容" value="">
													<span style=" margin-left:10px; margin-right:5px;">关系</span>
													<input type="text" name="qinshuguanxi2"  class="qinshuguanxi1" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:106px;" placeholder="请输入内容" >
												</div>
												<div style=" margin-bottom:20px;">
													亲情卡号三：
													<span style=" margin-left:10px; margin-right:5px;">姓名</span>
													<input type="text" name="qinshuxingming3"  class="qinshuxingming2" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:90px;" placeholder="请输入内容">
													<span style=" margin-left:10px; margin-right:5px;">号码 </span>
													<input type="text" name="qinshuhaoma3"  class="qinshuhaoma2" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:108px;" placeholder="请输入内容">
													<input type="hidden" name="oldhaoma3"  class="oldhaoma2" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:200px;" placeholder="请输入内容" value="">
													<span style=" margin-left:10px; margin-right:5px;">关系</span>
													<input type="text" name="qinshuguanxi3"  class="qinshuguanxi2" style="margin-bottom:10px; margin-top: 5px; margin-left:5px; width:106px;" placeholder="请输入内容" >
												</div>
											
					</form>
								</div>

								<div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
									<!--<input type="submit" value="保&nbsp;存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" '>-->

								</div>
							</form>

					
						</div>
						<div class="modal-footer">

							<button type="button" class="btn btn-default guan1" data-dismiss="modal" style="background: white; color:black; font-weight:bold;">关闭</button>
							<button type="button" class="btn btn-primary " style="display: block;float: right;font-weight:bold;" onclick='sub_qinshu()'>提交更改</button>
						

						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>





      <!-- 亲属关系end -->


	<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"  style="background: white">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;"><span class="ICname" style="color: #3a87ad;"></span>&nbsp;的卡号设置</h5>
						</div>
						<div class="modal-body">

							<input type="hidden" class="school">
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
									<img src="/weixiaotong2016/statics/images/delete.png" class="sic" style="height: 15px;">
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

							<div class="jiaz" style="margin-top: 10px;cursor: pointer; display: none">
								<div style=" margin-top:8px;">
									<div style=" float:left; width:14px; height:14px; border-radius:50%; background-color:#e84e40;  margin-right:10px;"></div>
									<div style=" float:left; color: black;">所有卡号均为10位数字，不足将自动在前面补0</div>
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
							<button type="button" class="btn btn-primary si" style="display: none;float: right;font-weight:bold;" onclick='sub_qrcj()'>提交更改</button>
							<button type="button" class="btn btn-primary ci" style="display: none;float: right;font-weight:bold;">提交更改</button>

						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>


		<!--家长IC卡号设置-->
           <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header"  style="background: white">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
							<h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;"><span class="ICname" style="color: #3a87ad;"></span>&nbsp;的卡号设置</h5>
						</div>
						<div class="modal-body">

							<input type="hidden" class="school">
							<div>
								<div style=" cursor: pointer;">
									<ul class=" nav-tabs" style="height:30px; list-style:none;">
									
										<li class="active" id="huoqu">
											<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">家长IC卡设置</a>
										</li>
									</ul>
								</div>
							</div>
					

							<div class="jiaz" style="margin-top: 10px;cursor: pointer; display: block;">
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
							<button type="button" class="btn btn-primary si" style="display: none;float: right;font-weight:bold;" onclick='sub_qrcj()'>提交更改</button>
							<button type="button" class="btn btn-primary ci" style="display: none;float: right;font-weight:bold;">提交更改</button>

						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>
     


		<!--家长IC卡号设置end-->
    



		<form class="J_ajaxForm" action="" method="post">
			<div class="table-actions">
				<!-- 				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Student/listorders');?>">排序</button> -->
				<!-- <button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Stuent/check',array('check'=>1));?>" data-subcheck="true">审核</button>
				<button class="btn btn-primary btn-small J_ajax_submit_btn" type="submit" data-action="<?php echo U('Stuent/check',array('uncheck'=>1));?>" data-subcheck="true">取消审核</button> -->
			</div>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<!-- <th align='center'><input type='checkbox' id='checkAll' name="checkAll" style="    vertical-align: -2px;">选择</th> -->
						<th><input id="checkAll" name="checkAll" type="checkbox"></th>
						<th>头像</th>
						<th>姓名</th>
						<th>学校</th>
						<th>性别</th>
						<th>登录手机号</th>
						<th>班级</th>
						<th>IC卡号</th>
						<th>家长</th>
						<th>微信绑定</th>
						<th>创建时间</th>
						<th align='center'>操作</th>
					</tr>
				</thead>
				<?php if(is_array($students)): foreach($students as $key=>$vo): ?><tr>
						<td><input id="sel_all" class="J_check" type="checkbox" value="<?php echo ($vo["id"]); ?>"></td>
						<!-- <td><input type="checkbox" class="J_check" id='sel_all' name="ids" value="<?php echo ($vo["id"]); ?>" title="id:<?php echo ($vo["id"]); ?>"></td> -->
						<td style="width: 60px;">
							<?php if($vo['photo'] == '' ): ?><img  src="/weixiaotong2016/uploads/microblog/weixiaotong.png" >
						</td>
						<?php else: ?>
						<img src="/weixiaotong2016/uploads/microblog/<?php echo ($vo["photo"]); ?>"  ></td><?php endif; ?>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($vo["school_name"]); ?></td>
						<td>
							<?php if($vo['sex'] == 1): ?>男
								<?php elseif($vo['from'] == 0): ?> 女<?php endif; ?>
						</td>
						<!--<td><?php echo ($vo["classname"]); ?></td>-->
						<td><?php echo ($vo["phone"]); ?></td>

						<td>
							<ul>
								<?php if(is_array($vo['classlist'])): foreach($vo['classlist'] as $key=>$cl): ?><li>
										<?php echo ($cl["classname"]); ?>
									</li><?php endforeach; endif; ?>
							</ul>
						
						</td>
						<td class="daibanzhuren" data-school = "<?php echo ($vo['schoolid']); ?>" >
                          <?php if($vo['cardno'] == null): ?><input type="hidden" value="<?php echo ($vo["id"]); ?>">

							<a class=" btn-lg shuzi" data-toggle="modal" data-target="#myModal"  style="background-color: transparent; cursor: pointer;">设置</a>
					
						   <?php else: ?>
						   <input type="hidden" value="<?php echo ($vo["id"]); ?>">
						   	<a class=" btn-lg shuzi" data-toggle="modal" data-target="#myModal" style="background-color: transparent; cursor: pointer;"><?php echo ($vo['cardno']); ?></a><?php endif; ?>

						</td>
						<td style="width: 120px;">
							<div class="wraps" wraps data-toggle="tooltip" data-placement="right" title="<?php echo ($vo["names"]); ?>"> &nbsp;<?php echo ($vo["names"]); ?></div>
							<br />
							<a onclick="jiazhang(<?php echo ($vo["id"]); ?>);" >编辑</a>
						</td>
						<td style="text-align: center;vertical-align: middle;">
						 <?php if($vo['appid'] == null): ?><a  class="btn btn-primary showkey" id=<?php echo ($vo["id"]); ?>  data-type="2">未绑定</a> 
						    <?php else: ?>
						    <a  class="btn btn-primary showkey" id=<?php echo ($vo["id"]); ?> data-type = "1" >已绑定</a><?php endif; ?> 
					    </td>
						<td><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
						<td>
							<a href="<?php echo U('Student/edit',array('term'=>empty($term['term_id'])?'':$term['term_id'],'id'=>$vo['id'],'schoolid'=>$vo['schoolid']));?>">修改</a> |
							<a href="<?php echo U('Student/student_delete',array('term'=>empty($term['term_id'])?'':$term['term_id'],'id'=>$vo['id'],'schoolid'=>$vo['schoolid']));?>" class="J_ajax_del">删除</a>
							<!--<a  class=" btn-lg daibanzhuren1" data-id=<?php echo ($vo['id']); ?>  data-toggle="modal"  style="background-color: transparent; cursor: pointer;">亲属信息</a>-->
							<a  class=" btn-lg jiazhangkahao" data-id=<?php echo ($vo['id']); ?> data-schoolid = "<?php echo ($vo['schoolid']); ?>" data-toggle="modal"  style="background-color: transparent; cursor: pointer;">家长卡号</a>
							

						</td>
					</tr><?php endforeach; endif; ?>
				<!-- <tfoot>
					<tr>
						<th width="15"><label><input type="checkbox" class="J_check_all" data-direction="x" data-checklist="J_check_x"></label></th>
						<th width="50">排序</th>
						<th>标题</th>
						<th>栏目</th>
						<th width="50">点击量</th>
						<th width="50">评论量</th>
						<th width="50">关键字</th>
						<th width="50">来源</th>
						<th width="50">摘要</th>
						<th width="50">缩略图</th>
						<th width="80">发布人</th>
						<th width="70">发布时间</th>
						<th width="50">状态</th>
						<th width="60">操作</th>
					</tr>
				</tfoot> -->
			</table>
			<div class="pagination"><?php echo ($Page); ?></div>
<input class="uisid" type="hidden" />
		</form>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
	<script>

        $(function() {
            $("#checkAll").click(function() {
                $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
            });
            var $J_check = $("input[class='J_check']");
            $J_check.click(function(){
                $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
            });
        });

        function class_del_student()
		{
            if (confirm("确定要按班级删除学生吗？")) {
              var classid = $("#classs").val();
                var schoolid = $("#viewOLanguage").val();
                if(!classid)
				{
				    alert("班级不能为空");
				    return false;
				}

                $.ajax({
                    type: "get",
                    // async: false,
                    url: "<?php echo U('Admin/Student/all_del_student');?>",
                    dataType: 'json',
                    data: {
                        'schoolid': schoolid,
                        'classid': classid,

                    },
                    success: function (res) {
                        if (res.status == "success") {
                            layer.msg(res.data, {
                                icon: 1
                                , shade: 0.01,
                            });
                            $(".J_check").each(function () {
                                if ($(this).attr("checked")) {
                                    $(this).parent().parent().remove();
                                }

                            })
                            return false;
                        } else {
                            layer.msg(res.data, {
                                icon: 2
                                , shade: 0.01,
                            });
                            return false;

                        }
                    },
                    error: function () {
                        alert('系统错误,请稍后重试');
                    }
                });
			}
		}

        function all_del_student()
		{


            if (confirm("确定要批量删除学生吗？")) {
                var schoolid = $("#viewOLanguage").val();
                var s_id = "";
                $("input[class='J_check']").each(function () {

                    if ($(this).attr("checked")) {
                        s_id += $(this).val() + ",";
                    }
                })

                if (!s_id) {
                    layer.msg('请选择要删除的学生', {
                        icon: 2
                        , shade: 0.01,
                    });
                    return false;
                }

                $.ajax({
                    type: "post",
                    // async: false,
                    url: "<?php echo U('Admin/Student/all_del_student');?>",
                    dataType: 'json',
                    data: {
                        'schoolid': schoolid,
                        's_id': s_id,

                    },
                    success: function (res) {
                        if (res.status == "success") {
                            layer.msg(res.data, {
                                icon: 1
                                , shade: 0.01,
                            });
                            $(".J_check").each(function () {
                                if ($(this).attr("checked")) {
                                    $(this).parent().parent().remove();
                                }

                            })
                            return false;
                        } else {
                            layer.msg(res.data, {
                                icon: 2
                                , shade: 0.01,
                            });
                            return false;

                        }
                    },
                    error: function () {
                        alert('系统错误,请稍后重试');
                    }
                });
            }
		}


        function del_parent_card(type)
		{

            layer.msg('你确定你很帅么？', {
                time: 0 //不自动关闭
                ,btn: ['确定', '取消']
                ,yes: function(index){
                    layer.close(index);

                }
            });

		    var schoolid =$("#viewOLanguage").val();
		    if(!schoolid)
			{
                layer.msg('请选择学校!', {
                    icon: 2
                    ,shade: 0.01,
                });
                return false;
			}
		    if(type==1)
			{
                var s_id = "";

                $("input[class='J_check']").each(function(){

                    if($(this).attr("checked"))
                    {
                        s_id+=$(this).val()+",";
                    }
                })

                if(!s_id)
                {
                    layer.msg('请选择需要删除卡号的学生!', {
                        icon: 2
                        ,shade: 0.01,
                    });
                    return false;
                }

			}

            $.ajax({
                type: "post",
                // async: false,
                url: "<?php echo U('Admin/Student/del_parent_card');?>",
                dataType:'json',
                data: {
                    'type': type,
					'schoolid':schoolid,
					's_id':s_id,

                },
                success: function(res) {
                   if(res.status=="success")
				   {
                       layer.msg(res.data, {
                           icon: 1
                           ,shade: 0.01,
                       });
                       return false;
				   }else{
                       layer.msg(res.data, {
                           icon: 2
                           ,shade: 0.01,
                       });
                       return false;

				   }
                },
                error: function() {
                    alert('系统错误,请稍后重试');
                }
            });

		}




$(document).ready(function () {
    $("#message_type").val(0);
    $("#citys").val(0);

});


//TJxs



$("#viewOLanguage").change(function(){

   var  add_school = $(this).val();
    $("#add_student").attr("data-school",add_school);


})
function add_student(obj)
{
    var is_school = $(obj).attr('data-school');

        location.href="<?php echo U('Student/add');?>";

}
	
 //微信绑定码
 $(".showkey").click(function(){
          
  	  layer.load();
               var studentid = $(this).attr("id");

                var type = $(this).attr("data-type");
               var obj = $(this).text();
               
               
               if(obj!='已绑定' && obj!='未绑定')
              { 
              	if(type==1)
              	{
              	obj=$(this).text('已绑定');
              	setTimeout(function(){
                      layer.closeAll('loading');
                    });
                }else{
                	obj=$(this).text('未绑定');
                	setTimeout(function(){
                      layer.closeAll('loading');
                    });
                }
              	return;
              }
        

              $.ajax({
					type: "post",
					// async: false,
					url: "<?php echo U('Admin/Student/bindingkey');?>",
					dataType:'json',
					data: {
						'studentid': studentid
					},
					success: function(res) {
							 setTimeout(function(){
                      layer.closeAll('loading');
                     });	
						if(res.status=='0')
						{
							alert(res.info);
							return false;

						}
					
						var data = eval(res.data);
					// console.log(res);
					
						//TODO 因为只有一个绑定码 可以直接处理
						var bindKey = data[0]["bindingkey"];

					

						if(bindKey==null || res.status=='error')
						{
							bindKey = '未绑定';
						}
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




    $('.drop').click(function(){

  if (confirm("确定要执行以下操作吗？")) {

  
     // var id = document.getElementsByName('ids');
     //  var ids = new Array();

    // for (var i = 0; i < id.length; i++) {
	   //                  if (id[i].checked){
	   //                      ids.push(id[i].value);
	                       
	   //                      console.log($(this).find('.tt').remove());
	   //                  }
	   //                  // $(this).closest('tr').remove();
	   //              }
	      var id = document.getElementsByName('ids');
	   var ids = new Array();
	                //将所有选中复选框的默认值写入到id数组中
	                for (var i = 0; i < id.length; i++) {
	                    if (id[i].checked){
	                        ids.push(id[i].value);
	                        // console.log($(this).find('.tt').remove());
	                    }
	                    // $(this).closest('tr').remove();

	               }

	            if(ids.length > 1)
	            {
	            	alert("请一次只退学一个!!");
	            	return false;

	            }   

	            if(ids.length < 1 )
	            {
	            	alert("请选择学生");
	            	return false
	            }
         
	            $(".student_drop").fadeIn(300);
       
      
   }

	
	      



})  
 













 	   $(function() {
            $("#checkAll").click(function() {
                $('input[class="J_check"]').prop("checked", $(this).prop("checked"));
            });
            var $J_check = $("input[class='J_check']");
            $J_check.click(function(){
                $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
            });
        });










if($("#province").val())
{
 var new_citys = $('body').find(".new_citys").val();

 var new_message_type = $('body').find('.new_message_type').val();

    var new_grade = $('body').find('.new_grade').val();
    var new_classs = $('body').find('.new_classs').val();
 // console.log(type);

 var type_school = $('body').find(".type_school").val();



	  if(new_citys || $("#province").val())
	  {
	      $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
	                    console.log(data);
	                      if(data.status=="success"){
	                      $("#citys").empty();	
	                          $("#citys").append("<option value=>"+"选择市级"+"</option>");
	                          for(var key in data.data){
	                          	
                                 if(new_citys==data.data[key]["term_id"]){
	                              $("#citys").append("<option value="+data.data[key]["term_id"]+ " selected >"+data.data[key]["name"]+"</option>");

                                    }else{
                                    	 $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                                    }
	                            }
                                           $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
						                    // console.log(data);
						                      if(data.status=="success"){
						                        $("#message_type").empty();
                                                  $("#message_type").append("<option value=>"+"选择区域"+"</option>");
						                        
						                          for(var key in data.data){
                                                    if(new_message_type == data.data[key]["term_id"]){ 
						                              $("#message_type").append("<option value="+data.data[key]["term_id"]+" selected >"+data.data[key]["name"]+"</option>");
						                             }else{
						                             	$("#message_type").append("<option value="+data.data[key]["term_id"]+" >"+data.data[key]["name"]+"</option>");
						                             }

						                          }
						                          var type = $(".select_3  option:selected").val();
						                        
                                                 $.ajax({
														type: "post",
														url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
														async: true,
														data: {
															type: type
														},
														dataType: 'json',
														success: function(res) {
															// $(".Sio").text("")
															 $("#viewOLanguage").empty();
															var html = "";
															res = eval(res.data);

                                                            $("#viewOLanguage").append("<option value=''>选择学校</option>");
															for(var i = 0; i < res.length; i++) {
																var school_name = res[i].school_name; //学校的名字
																var schoolid = res[i].schoolid; //学校的ID

																// alert('aa');
																// alert(type_school);
																if(schoolid == type_school){
																// html += '<option class="Sio" value="' + schoolid + ' " selected>' + school_name + ' </option> '
																$("#viewOLanguage").append("<option value="+schoolid+" selected >"+school_name+"</option>");
                                                                    $("#add_student").attr("data-school",schoolid);

															   }else{
															   $("#viewOLanguage").append("<option value="+schoolid+" >"+school_name+"</option>");
															   }
															}
															$(".chzn-select").append(html)
															$("#viewOLanguage").chosen();
															$("#viewOLanguage").trigger("liszt:updated");
														},
														error: function() {
															console.log('系统错误,请稍后重试');
														}
													});

                                                 //选择年级
												if(type_school){
                                                    $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showgrade&schoolid="+type_school,{},function(data){
                                                        if(data.status=="success"){
                                                            $("#grade").empty();
                                                            $("#grade").append("<option value=>"+"选择年级"+"</option>");

                                                            for(var key in data.data){
                                                                if(new_grade == data.data[key]["gradeid"]){
                                                                    $("#grade").append("<option value="+data.data[key]["gradeid"]+" selected >"+data.data[key]["name"]+"</option>");
                                                                }else{
                                                                    $("#grade").append("<option value="+data.data[key]["gradeid"]+" >"+data.data[key]["name"]+"</option>");
                                                                }

                                                            }
                                                            //选择班级
                                                            if(new_grade){
                                                                $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showclass&schoolid="+type_school+"&gradeid="+new_grade,{},function(data) {
                                                                    if(data.status=="success"){
                                                                        $("#classs").empty();
                                                                        $("#classs").append("<option value=>"+"选择班级"+"</option>");

                                                                        for(var key in data.data){
                                                                            if(new_classs == data.data[key]["id"]){
                                                                                $("#classs").append("<option value="+data.data[key]["id"]+" selected >"+data.data[key]["classname"]+"</option>");
                                                                            }else{
                                                                                $("#classs").append("<option value="+data.data[key]["id"]+" >"+data.data[key]["classname"]+"</option>");
                                                                            }

                                                                        }
																	}
                                                                    if(data.status=="error"){
                                                                        $("#classs").append("<option value='0'>暂无班级</option>");
                                                                    }

                                                                });
															}

														}
                                                        if(data.status=="error"){
                                                            $("#grade").append("<option value='0'>暂无年级</option>");
                                                        }
													});
												}


						                      }
						                      if(data.status=="error"){
						                          $("#message_type").append("<option value='0'>没有区域</option>");
						                      }
						                  });   
                                
                               

	                      }
	                      if(data.status=="error"){
	                          $("#citys").append("<option value='0'>没有市级</option>");
	                      }
	                  });

	    }


}




 //选择市级的下拉的ajax
              $(function() {
						  $("#province").change(function(){

                              $("#citys").empty();
                              $("#message_type").empty();
                              $(".Sio").text("")

                              $("#viewOLanguage").empty();
                              $("#viewOLanguage").chosen();
                              $("#viewOLanguage").trigger("liszt:updated");
                              $("#grade").empty();
                              $("#classs").empty();
                              $("#classs").append("<option value=>"+"选择班级"+"</option>");
                              $("#grade").append("<option value=0>"+"选择年级"+"</option>");

                              // $("#student").empty();

                              $("#message_type").append("<option value=>"+"选择区域"+"</option>");
                              $("#citys").append("<option value=0>"+"选择市级"+"</option>");

                              if( $("#province").val()==0)
                              {
                                  return false;
                              }

									   $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){


										  if(data.status=="success"){


											  for(var key in data.data){
												  $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
											  }
										  }
										  if(data.status=="error"){
											  $("#citys").append("<option value='0'>没有市级</option>");
										  }
									  });


					})
          });

             $(function() {
              $("#citys").change(function() {
                  $("#message_type").empty();
                  $(".Sio").text("")
                  $("#viewOLanguage").empty();
                  $("#viewOLanguage").chosen();
                  $("#viewOLanguage").trigger("liszt:updated");
                  $("#message_type").append("<option value=>"+"选择区域"+"</option>");
                  $("#grade").empty();
                  $("#classs").empty();
                  $("#classs").append("<option value=>"+"选择班级"+"</option>");
                  $("#grade").append("<option value=0>"+"选择年级"+"</option>");
                  if( $("#citys").val()==0)
                  {
                      return false;
                  }

                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                    console.log(data);
                      if(data.status=="success"){
                      

                          for(var key in data.data){
                              $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                          }
                      }
                      if(data.status=="error"){
                          $("#message_type").append("<option value='0'>暂无区域</option>");
                      }
                  });
              });
          });
//选择年级
$(function() {
    $("#viewOLanguage").change(function() {
        $("#grade").empty();
        $(".Sio").text("")
        $("#classs").empty();
        $("#classs").append("<option value=>"+"选择班级"+"</option>");
        $("#grade").append("<option value=0>"+"选择年级"+"</option>");
        if( $("#viewOLanguage").val()==0)
        {
            return false;
        }

        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showgrade&schoolid="+$("#viewOLanguage").val(),{},function(data){
            console.log(data);
            if(data.status=="success"){


                for(var key in data.data){
                    $("#grade").append("<option value="+data.data[key]["gradeid"]+">"+data.data[key]["name"]+"</option>");
                }
            }
            if(data.status=="error"){
                $("#grade").append("<option value='0'>暂无年级</option>");
            }
        });
    });
});
//选择班级
$(function() {
    $("#grade").change(function() {
        $("#classs").empty();
        $("#classs").append("<option value=0>"+"选择班级"+"</option>");
        if( $("#grade").val()==0)
        {
            return false;
        }

        $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=showclass&schoolid="+$("#viewOLanguage").val()+"&gradeid="+$("#grade").val(),{},function(data){
            console.log(data);
            if(data.status=="success"){


                for(var key in data.data){
                    $("#classs").append("<option value="+data.data[key]["id"]+">"+data.data[key]["classname"]+"</option>");
                }
            }
            if(data.status=="error"){
                $("#classs").append("<option value='0'>暂无班级</option>");
            }
        });
    });
});


		$(function() {
			$("[data-toggle='tooltip']").tooltip();
		});

		function refersh_window() {
			var refersh_time = getCookie('refersh_time');
			if(refersh_time == 1) {
				window.location = "<?php echo U('AdminPost/index',$formget);?>";
			}
		}
		setInterval(function() {
			refersh_window();
		}, 2000);
		$(function() {
			setCookie("refersh_time", 0);
			Wind.use('ajaxForm', 'artDialog', 'iframeTools', function() {
				//批量移动
				$('.J_articles_move').click(
					function(e) {
						var str = 0;
						var id = tag = '';
						$("input[name='ids[]']").each(function() {
							if($(this).attr('checked')) {
								str = 1;
								id += tag + $(this).val();
								tag = ',';
							}
						});
						if(str == 0) {
							art.dialog.through({
								id: 'error',
								icon: 'error',
								content: '您没有勾选信息，无法进行操作！',
								cancelVal: '关闭',
								cancel: true
							});
							return false;
						}
						var $this = $(this);
						art.dialog.open(
							"/weixiaotong2016/index.php?g=portal&m=AdminPost&a=move&ids=" +
							id, {
								title: "批量移动",
								width: "80%"
							});
					});
			});
		});
		// $(".select_3").click(function() {
		// 	$(".jiu").hide();
		// 	$.ajax({
		// 		type: "post",
		// 		url: '/weixiaotong2016/index.php/?g=Admin&m=Student&a=chadi',
		// 		async: true,
		// 		data: {
		// 			type: 3
		// 		},
		// 		dataType: 'json',
		// 		success: function(res) {
		// 			var html = "";
		// 			res = eval(res.data);
		// 			for(var i = 0; i < res.length; i++) {
		// 				var name = res[i].name; //地区的名字；
		// 				var term_id = res[i].term_id; //地区的ID
		// 				html += '<option class="jiu"value="' + term_id + '">' + name + ' </option> '
		// 			}
		// 			$(".select_3").append(html);
		// 		},
		// 		error: function() {
		// 			console.log('系统错误,请稍后重试');
		// 		}
		// 	});
		// })

		$("#viewOLanguage").chosen();
		$("#viewOLanguage").trigger("liszt:updated");
		//学校的点击事件

		$(".select_3").change(function() {
            $("#viewOLanguage").empty();
            $(".Sio").text("")
            $("#viewOLanguage").chosen();
            $("#viewOLanguage").trigger("liszt:updated");
            $("#viewOLanguage").append("<option value=''>选择学校</option>");
            $("#grade").empty();
            $("#classs").empty();
            $("#classs").append("<option value=>"+"选择班级"+"</option>");
            $("#grade").append("<option value=0>"+"选择年级"+"</option>");
			var type = $(".select_3  option:selected").val();


			$.ajax({
				type: "post",
				url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
				async: true,
				data: {
					type: type
				},
				dataType: 'json',
				success: function(res) {

					var html = "";
					res = eval(res.data);

					for(var i = 0; i < res.length; i++) {
						var school_name = res[i].school_name; //学校的名字
						var schoolid = res[i].schoolid; //学校的ID
						html += '<option name="school"  class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
					}
                    $(".chzn-select").append(html)
                    $("#viewOLanguage").chosen();
                    $("#viewOLanguage").trigger("liszt:updated");
				},
				error: function() {
					console.log('系统错误,请稍后重试');
				}
			});
		})



		$(".ss").click(function() {

            var province = $("#province option:selected").val();
			var xuan = $(".tiaojian option:selected").val();
			var zhi = $(".zhi").val();

			var citys = $("#citys  option:selected").val();

			var type = $(".select_3  option:selected").val();
			var typeschool = $(".chzn-select  option:selected").val();
		
			var isSuccess = 1;
			if(zhi == "") {
				if(xuan != 0) {
					var isSuccess = 0;
					alert("在选好条件在输入框中输入你要找的数据类型");

				}
			}
			if(xuan == 0) {
				if(zhi != "") {
					var isSuccess = 0;
					alert("请选择你要搜索的查询类型");
                    return false;
				}
			}



            if(zhi == "" && xuan == 0) {
                if(!province){
                    alert("请选择省份");
                    var isSuccess =0;
                    return false;
                }
                if(citys==0)
				{
				    alert("请选择市级");
                    var isSuccess =0;
				    return false
				}

//				if(type == 0) {
//					alert("请选择地区");
//					var isSuccess = 0;
//					return false;
//				}
//				if(typeschool == "") {
//					var isSuccess = 0;
//					alert("请选择学校");
//					return false
//				}
			}
			if(isSuccess == 0) {
				return false;
			}
		})
		
		$(".daochu").click(function(){
			var xuan = $(".tiaojian option:selected").val();
			var zhi = $(".zhi").val();
			var type = $(".select_3  option:selected").val();
			var typeschool = $(".chzn-select  option:selected").val();
            var grade = $("#grade").val();
            var classs = $("#classs").val();
			var isSuccess = 1;
			if(zhi == "") {
				if(xuan != 0) {
					var isSuccess = 0;
					alert("在选好条件在输入框中输入你要找的数据类型");

				}
			}
			if(xuan == 0) {
				if(zhi != "") {
					var isSuccess = 0;
					alert("请选择你要搜索的查询类型")
				}
			}
			if(zhi == "" && xuan == 0) {
				if(type == 0) {
					alert("请选择地区");
					var isSuccess = 0;
				}
				if(typeschool == "") {
					var isSuccess = 0;
					alert("请选择学校");
				}
			}
			if(isSuccess==1){
               location.href="<?php echo U('Student/Lexcel');?>?schoolid="+typeschool+"&tiaojian="+xuan+"&shuzhi="+zhi+"&grade="+grade+"&classs="+classs+"" ;
			}
			
		})
  
   //修改卡号

   function sub_qrcj() {
   	            var schoolid = $('body').find('.school').val();

				var userid = w;

				var stu_old_card = $("input[name='stu_old_card']").val();
				
				var cardNo = $("input[name='newICcard']").val();
				// console.log(cardNo);
              

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
					type: "post",
					async: false,
                    dataType: 'json',
					url: "<?php echo U('Admin/Student/updateICcard');?>",
					data: {
						'userid': userid,
						'cardNo': cardNo,
						'stu_old_card':stu_old_card,
						'schoolid':schoolid,
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
			}


  //亲属关系
 	$(".daibanzhuren1").click(
				function(ID) {
					$(".qinshu").show()
				}
			)    

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

    $('.close').click(function(){

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






  //亲属关系end



$(".daibanzhuren1").click(
				function() {
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



					stud = $(this).attr('data-id');
					console.log(stud);
					// $(".chuanzhi").val(stud)
					var stuname = $(this).parent().parent().find("td:eq(2)").text()
					console.log(stuname)
					$(".stuhuan").text(stuname)
					var stuid = $(this).parent().siblings(".stuid").text();
					$(".stuhua").text(stuid);


				   $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Student/showqinshu');?>",
					data: {
						studentid:stud,
						

					},
					success: function(data) {
						console.log(data);

						if(data.status){
							$("#myModal1").modal("show")  
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

			function sub_qinshu() {

				var studentid = stud;
                
                var schoolid = $('body').find('.daibanzhuren').attr('data-school');
   

            if($("input[name='qinshuxingming1']").val() && $("input[name='qinshuhaoma1']").val() && $("input[name='qinshuguanxi1']").val())
            {

				var arr1 = new Array();
				arr1[0] = $("input[name='qinshuxingming1']").val();
				arr1[1] = $("input[name='qinshuhaoma1']").val();
				arr1[2] = $("input[name='qinshuguanxi1']").val();
				arr1[3] = $("input[name='oldhaoma1']").val();
              }  
                
			if($("input[name='qinshuxingming2']").val() && $("input[name='qinshuhaoma2']").val() && $("input[name='qinshuguanxi2']").val())
			{
				var arr2 = new Array();
				arr2[0] = $("input[name='qinshuxingming2']").val();
				arr2[1] = $("input[name='qinshuhaoma2']").val()
				arr2[2] = $("input[name='qinshuguanxi2']").val();
				arr2[3] = $("input[name='oldhaoma2']").val();
			}	 
				
              

             if($("input[name='qinshuxingming3']").val() && $("input[name='qinshuhaoma3']").val() && $("input[name='qinshuxingming3']").val())
             {

				var arr3 = new Array();
				arr3[0] = $("input[name='qinshuxingming3']").val();
				arr3[1] = $("input[name='qinshuhaoma3']").val();
				arr3[2] = $("input[name='qinshuguanxi3']").val();
				arr3[3] = $("input[name='oldhaoma3']").val();
             }
		
				
				$.ajax({
					type: "get",
					async: false,
					url: "<?php echo U('Admin/Student/qinshu');?>",
					data: {
						'qinshu1[]': arr1,
						'qinshu2[]': arr2,
						'qinshu3[]': arr3,
						'studentid': studentid,
						'schoolid':schoolid
					},
					success: function(msg) {
						console.log(msg);
						if(msg.status=='0')
						{
							alert(msg.info);
							return false;
						}
						history.go(0);
					}
				});
			}



  //模态


 	$(".daibanzhuren").click(
				function() {
					w = $(this).children().val()

					$(".chuanzhi").val(w)
					$(".uisid").val(w);

					var ICname = $(this).prev().prev().prev().prev().text()

					s = $(this).attr('data-school');
					$('.school').val(s);
					$('.ICname').text(ICname);

				}
			)



   	$(".sic").click(
				function() {

					var cardno = $(this).prev().text();
					console.log(cardno);


                    var showcard = $('body').find(".shuzi")

 
                    $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Student/delcard');?>",
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






      	$(".daibanzhuren").click(
				function(ID) {
					$(".daitan").show()
					l = $(".shuzi",this).text();


					$(".dbzr").text(l)

					$(".stu_old_card").val(l);
				}
			)


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


  		$("#myModal").hide();
  		$("#myModal1").hide();
  		$("#myModal4").hide();
			var class_card = [];

			$(".ci").click(function() {
               var schoolid = $('body').find('.school').val();



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



        
				 //console.log(f);
					//console.log(arr);
                  
                 //console.log(f);
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
//           if(!istrue)
//		   {
//		       alert("请输入完整卡号!");
//		       return false;
//		   }

	            $.ajax({
					type: "post",
					async: false,
					url: "<?php echo U('Admin/Student/jiaadd');?>",
					data: {
						class_card:class_card,
						userid:userid,
						schoolid:schoolid,

					},
					success: function(msg) {
						if(msg.status=='0')
						{
							alert(msg.info);
							return false;
						}
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

           	$(".jiazhangkahao").click(function() {
				$(".si").hide();
				$(".jiaz").show();
				// $(".xuesheng").hide();

				var userid = $(this).attr("data-id");
				var schoolid = $(this).attr("data-schoolid");
                $('.school').val(schoolid);
				$(".uisid").val(userid);
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
					url: "<?php echo U('Admin/Student/chaxuan');?>",
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












			
			$(".jiazhangkahao").click(function() {
                var ICname = $(this).parent().parent().find("td:eq(1)").text();



                $('.ICname').text(ICname);
				var userid = $(this).attr("data-id");


				$.ajax({
					type: "get",
					url: "<?php echo U('Admin/Student/chaxuan');?>",
					async: true,
					dataType: 'json',
					data: {
						userid: userid
					},
					success: function(res) {
						if(res.status=='0')
						{
							alert(res.info);
							return false;
						}
						$("#myModal4").modal("show")  
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

	<link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
	<script src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>

	<script>
        layui.use(['layer'], function(){
            var layer = layui.layer;
        });
        //床位对调
        function jiazhang(userid) {

            layui.use(['layer'], function() {
                var $ = layui.jquery,
                    layer = layui.layer;

                var index = layer.open({
                    type: 2,
                    id	: 1,
                    title: '家长信息',
                    btn: ['关闭'],
                    area: ['600px', '500px'],
                    offset : ['20px', '200px'],
                    maxmin: true,
                    content: "<?php echo U('parentlist');?>?id="+userid,

                    shade: 0.8,
                    shadeClose: true,
                    maxmin :true,
                    end: function(){
                        location.reload();
                    }
                });
            });
        }
	</script>
</body>

</html>