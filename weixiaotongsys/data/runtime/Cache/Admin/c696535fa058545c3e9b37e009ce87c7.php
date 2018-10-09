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
	.banbox {
		width: 120px;
		white-space: nowrap;
		text-overflow: ellipsis;
		overflow: hidden;

	}

	.line-limit-length {
		max-width: 110px;
		overflow: hidden;
		text-overflow: ellipsis;
		white-space: nowrap;
	}

	table td{

		color: black;
	}

	div {
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
				.zhike{
				color: black;
				font-style: normal;	
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
			<li class="active"><a href="javascript:;">所有老师</a></li>
			<li><a href="<?php echo U('Teacher/add',array('province'=>$province,'citys'=>$new_citys,'message_type'=>$new_message_type,'schoolid'=>$schoolid));?>" target="_self">添加老师</a></li>
			<li>
				<a href="<?php echo U('Teacher/excel_list');?>" target="_self">查看导入数据</a>
			</li>
		</ul>

		    <!--修改卡号-->
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
											<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">老师IC卡设置</a>
										</li>
										
									</ul>
								</div>
							</div>
							<form class="xuesheng">
								<div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
									<div class="dbzr"></div>
									<img src="/weixiaotong2016/statics/images/delete.png" class="sic" style="height: 15px
									;">
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

						
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary si" onclick='sub_qrcj()'>提交更改</button>

							<button type="button" class="btn btn-danger gb" data-dismiss="modal">关闭</button>
						
							

						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>

        
			<!--代班代课start-->
			<!-- 模态框（Modal） -->
			<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background-color: white;">
							<button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <!--存放老师id-->
                             <input type="hidden" class="Loocliassid" />
                                    <!--存放班级改变时候的班级ID-->
                             <input type="hidden" class="cliaasid" />
							<div style=" cursor: pointer;">
								<ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
									<li class="active " id="daibananiu">
										<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">代班设置</a>
									</li>
									<li class=" " id="huoqudaike">
										<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">代课设置</a>
									</li>
								</ul>
							</div>
						</div>
						<div class="modal-body">
							<div class="hideid">

								<div>
									老师：<span class="dk_teacher"></span>
									
								</div>
								<input type="hidden" class="tischoolid">
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
								
								</div>
								<i></i>

							</form>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-primary tijiao" data-dismiss="modal" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>提交更新</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>

			<!--带班代课end-->

		<!--教师职务start-->
		<!-- 模态框（Modal） -->
		<div class="modal fade" id="myModal7" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header" style="background-color: white;">
						<button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
						<!--存放老师id-->
						<input type="hidden" class="Loocliassids" />
						<!--存放班级改变时候的班级ID-->
						<input type="hidden" class="cliaasids" />
						<div style=" cursor: pointer;">
							<ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
								<li>职位管理</li>
							</ul>
						</div>
					</div>
					<div class="modal-body">
						<div class="hideids">

							<div>
								老师：<span class="dk_teachers"></span>

							</div>
							<input type="hidden" class="tischoolids">
							<div style="  overflow-y:scroll; padding:10px; padding-left:10;border: 1px solid gainsboro;" class="zhiwei_info">
								<?php if(is_array($class)): foreach($class as $key=>$vo): ?><div class="zhiwei" style=" float:left; width:20%; margin-bottom:10px;cursor:pointer;">
										<div style="width: 20px;height: 20px;position: relative;top: 23px;"></div>
										<input type="checkbox" name="class_else" id="class_chose" value="<?php echo ($vo["id"]); ?>">
										<span class="manid"><?php echo ($vo["classname"]); ?></span>
									</div><?php endforeach; endif; ?>
								<div class="clearfix"></div>
								<div class="newbox">
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-primary tijiaozhiwei" data-dismiss="modal" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>提交更新</button>
						<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
					</div>
				</div>
				<!-- /.modal-content -->
			</div>
			<!-- /.modal -->
		</div>

		<!--教师职务end-->

	<!-- 模态框（Modal） 分组 -->
			<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header" style="background-color: white;">
							<button type="button" class="close dkgb" data-dismiss="modal" aria-hidden="true">&times;</button>
                             <!--存放老师id-->
                             <input type="hidden" class="groupschool" />
                                    <!--存放班级改变时候的班级ID-->
                 
							<div style=" cursor: pointer;">
								<ul class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
									<li class="active " id="daibananiu">
										<a style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">分组设置</a>
									</li>
		
								</ul>
							</div>
						</div>
					<form action="" method="get"  onsubmit="return checkform(this)">	
						<div class="modal-body">
							<div class="hide" style="display: block;">


								<div>
									老师：<span class="group_teacher"></span>
									
								</div>
								<input type="hidden" class="teacherid">
								<div style="  overflow-y:scroll; padding:10px; padding-left:10;border: 1px solid gainsboro;" class="fenzu">
								
										
							
									<div class="clearfix"></div>
									<div class="newbox">
									</div>
								</div>
							</div>
				
						</div>
					
						<div class="modal-footer">
							<input type="button" class="btn btn-primary tijiaofenzu" data-dismiss="modal" value="提交更新" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" \>
							<button type="button" class="btn btn-danger" data-dismiss="modal">关闭</button>
						</div>
						</form>	
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal -->
			</div>


 <!--重置密码-->


       	<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="    display: none;">
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
													<input type="hidden" class="passschoolid" >
                                                  <span style="margin-left: 28px;">教师:</span> &nbsp;<input type="text" name="teacher_mname" readonly="true" class="teacher_mname"><br>
										           <span style="margin-left: 14px;">新密码:</span> &nbsp;<input type="password" class="rel" name="password"><br>
										          <span>确认密码:</span> &nbsp;<input type="password" class="pwd"></p>
										      </div>
										      <div class="modal-footer">
										      <button class="btn btn-primary pwdtj" style="font-weight:bold;" >提交</button>
										        <button type="button" class="btn btn-danger" data-dismiss="modal" style="">关闭</button>
										    
										      </div>
										   
										    </div>
										  </div>
					</div>
     <!--重置密码end-->


		<form class="well form-search" method="get" action="<?php echo U('Teacher/index');?>" style="    padding: 12px;">
			<div class="search_type cc mb10">
				<div class="mb10">
					<span class="mr20">
						省份选择：
						<select  class="province"  name="province" id="province" style="width: auto;">
							<option value="">&nbsp;&nbsp;&nbsp;省级选择&nbsp;&nbsp;&nbsp;</option>
							<?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?> 
								<option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
						</select>&nbsp;&nbsp;
						市级:
						<input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
						<select name="citys" class="citys"  id="citys" style="width: auto;">
							<option value="0">请先选择省份</option>
						</select>&nbsp;&nbsp;

						区域:
						<input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
						<select name="message_type" class="select_3" id="message_type" style="width: auto;">
							<option value="0">请选择你的区域</option>
						</select>&nbsp;&nbsp;              
						学校:
						<select data-placeholder="输入关键字。。。" id="viewOLanguage" class="chzn-select"  tabindex="2" name="schoolid">
							<option value=""></option>
						</select>
						<input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
					<div class="mr20" >
                        条件选择：	
                       <span style="width: 45%; margin-top: 13px; ">
						<select  class="keyword"  name="keywordtype" style="width: auto;">
								<option value="">&nbsp;&nbsp;
                     
                        查询类型&nbsp;
                        &nbsp;</option>
								<option value="name"  <?php if($tiaojian==name) echo("selected");?>>姓名</option>
								<option value="phone" <?php if($tiaojian==phone) echo("selected");?>>电话</option>
								<option value="cardno" <?php if($tiaojian==cardno) echo("selected");?>>卡号</option>
							</select>
							<input type="text" class="zhi" name="keyword" style="width: 150px;" value="<?php echo ($keyword); ?>" placeholder="根据条件进行模糊查询">
						</span>	
						<div style="       display: inline-block;
    margin-top: 8px; margin-left: 200px;">	
							<input type="submit" class="btn btn-primary ss" style="" value="搜索" />&nbsp;&nbsp;
							<a class="btn btn-danger" href="<?php echo U('Teacher/teacher');?>">导入</a>&nbsp;&nbsp;                       
							<a class="btn btn-success daochu"  >导出</a>&nbsp;&nbsp;             
							<a class="btn btn-danger" href="<?php echo U('Teacher/index');?>">清空</a>
						</div>

					 </div>	

						<!--手机号码：-->
						<!--<input type="text" name="phoneNumber" style="width: 200px;" value="<?php echo ($formget["keyword"]); ?>" placeholder="请输入手机号...">-->

					</span>
				</div>
			</div>
		</form>
		            <tr>
                           <td><div id='content_tip'></div>
              <script type="text/plain" id="content" name="post[post_content]"></script>
                <script type="text/javascript">
                //编辑器路径定义
                var editorURL = GV.DIMAUB;
                </script>
                <script type="text/javascript"  src="/weixiaotong2016/statics/js/ueditor/ueditor.config.js"></script>
                <script type="text/javascript"  src="/weixiaotong2016/statics/js/ueditor/ueditor.all.min.js"></script>
				</td>
            </tr>
            
		<form class="J_ajaxForm" action="" method="post">
			<div class="table-actions">
			</div>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th>头像</th>
						<th>姓名</th>
						<th>学校</th>
						<th>性别</th>
						<th>卡号</th>
						<th>手机号码</th>
						<th>科室</th>
						<th>职位</th>
						<th>任课班级</th>
						<th>微信绑定</th>
						<th>创建时间</th>
						<th align='center'>操作</th>	
					</tr>
				</thead>
				<?php if(is_array($teachers)): foreach($teachers as $key=>$vo): $sign=empty($vo['teacher_subject'])?'':$vo['teacher_subject']; ?>
				<?php $signs=empty($vo['dutylist'])?'':$vo['dutylist']; ?>
				<tr>

					<td style="width: 60px;">
						
								<?php if($vo['photo'] == '' ): ?><img src="/weixiaotong2016/xp_qian/images/PersonalCenter/user_b.png" />
								<?php else: ?> 
									<img  src="/weixiaotong2016/uploads/microblog/<?php echo ($vo["photo"]); ?>" /><?php endif; ?>
					</td>
					<td ><p style="width: 50px;"><?php echo ($vo["name"]); ?></p></td>
					<td><?php echo ($vo["school_name"]); ?></td>
					<td><?php if($vo['sex'] == 1): ?>男
								<?php elseif($vo['from'] == 0): ?> 
									女<?php endif; ?></td>
					<td class="daibanzhuren" data-school = "<?php echo ($vo['schoolid']); ?>">
                     <?php if($vo['cardno'] == null): ?><input type="hidden" value="<?php echo ($vo["info_id"]); ?>">

							<a class=" btn-lg shuzi" data-toggle="modal" data-target="#myModal"  style="background-color: transparent; cursor: pointer;">设置</a>
					
						   <?php else: ?>
						   <input type="hidden" value="<?php echo ($vo["info_id"]); ?>">
						   	<a class=" btn-lg shuzi" data-toggle="modal" data-target="#myModal" style="background-color: transparent; cursor: pointer;"><?php echo ($vo['cardno']); ?></a><?php endif; ?>


					</td>
					<td><?php echo ($vo["phone"]); ?></td>
					<td>
						<a class="dep" style="cursor: pointer;"  data-depid = "<?php echo ($vo['departmentid']); ?>" data-toggle="modal" data-target="#myModal5" data-school = "<?php echo ($vo['schoolid']); ?>"  data-id = "<?php echo ($vo['id']); ?>">
                       <?php if($vo["departmentlist"] == null): ?><p class="line-limit-length" data-toggle="tooltip" data-placement="right" title="<?php echo ($vo['departmentlist']); ?>">设置</p> 
                       
                       <?php else: ?>
						<p class="line-limit-length" data-toggle="tooltip" data-placement="right" title="<?php echo ($vo['departmentlist']); ?>" style="width: 80px;"><?php echo ($vo["departmentlist"]); ?></p><?php endif; ?>

						</a>
					
					</td>
					<td data-school = "<?php echo ($vo['schoolid']); ?>" >
						<input type="hidden" class="t_id" value="<?php echo ($vo["id"]); ?>">
						<?php if($signs == ''): ?><div class="indeed">

								<input type="hidden" class="laoshiid" value="<?php echo ($vo["id"]); ?>" />
								<input type="hidden" class="zhishu" value="<?php echo ($vo["teacher_dutylid"]); ?>" />
								<a  data-toggle="modal" class="zhiweibox"  style="background-color: transparent; cursor: pointer;">设置</a>
							</div>
							<?php else: ?>
							<div class="indeed">
								<input type="hidden" class="laoshiid" value="<?php echo ($vo["id"]); ?>" />
								<input type="hidden" class="zhishu" value="<?php echo ($vo["teacher_dutylid"]); ?>" />
								<div data-toggle="modal" class="zhiweibox"  style="background-color: transparent; cursor: pointer; color:  #2fa4e7;"  title="<?php echo ($vo['dutylist']); ?>" >
									<?php echo ($vo['dutylist']); ?>
								</div>
							</div><?php endif; ?>

					</td>
					<td class="pai2 banzhuren " data-school = "<?php echo ($vo['schoolid']); ?>" style="width: 120px;">
							<input type="hidden" class="t_id" value="<?php echo ($vo["id"]); ?>">
										<?php if($sign == ''): ?><div class="indeed">
											
												<input type="hidden" class="laoshiid" value="<?php echo ($vo["id"]); ?>" />
												<input type="hidden" class="zhishu" value="<?php echo ($vo["teacher_classid"]); ?>" />
												<a  data-toggle="modal" class="banbox"  style="background-color: transparent; cursor: pointer;">设置</a>
											  </div>	
												<?php else: ?>
												<div class="indeed">
													<input type="hidden" class="laoshiid" value="<?php echo ($vo["id"]); ?>" />
													<input type="hidden" class="zhishu" value="<?php echo ($vo["teacher_classid"]); ?>" />
													<div data-toggle="modal" class="banbox"  style="background-color: transparent; cursor: pointer; color:  #2fa4e7;"  title="<?php echo ($vo["teacher_subject"]); ?>" >
														<?php echo ($vo["teacher_subject"]); ?>
											</div>
										</div><?php endif; ?>
					</td>
					<td style="text-align: center;vertical-align: middle; width: 60px;" data-school = "<?php echo ($vo['schoolid']); ?>" >
					<?php if($vo['appid'] == null): ?><a  class="btn btn-primary showkey" id=<?php echo ($vo["id"]); ?>  data-type="2">未绑定</a> 
					    <?php else: ?>
					    <a  class="btn btn-primary showkey" id=<?php echo ($vo["id"]); ?> data-type = "1" >已绑定</a><?php endif; ?>
					</td>
					<td style="width: "><?php echo (date("Y-m-d H:i:s",$vo["create_time"])); ?></td>
					<td style="">
					     <a  class="reset"  data-toggle="modal" data-target="#myModal3" style=" cursor: pointer;"  data-na="<?php echo ($vo["name"]); ?>"  data-id="<?php echo ($vo["id"]); ?>"  data-school="<?php echo ($vo["schoolid"]); ?>" >重置密码</a>
						<a href="<?php echo U('Teacher/edit',array('term'=>empty($term['term_id'])?'':$term['term_id'],'id'=>$vo['id'],'schoolid'=>$vo['schoolid'],'info_id'=>$vo['info_id']));?>">修改</a> |
						<a href="<?php echo U('Teacher/delete',array('id'=>$vo['id'],'schoolid'=>$vo['schoolid'],'info_id'=>$vo['info_id']));?>" class="J_ajax_del">删除</a></td>
				</tr><?php endforeach; endif; ?>


			</table>
			<div class="pagination"><?php echo ($Page); ?></div>
			<!--<?php if(count($teachers) > 20): ?>-->

			<!--<?php endif; ?>-->


		</form>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>
	
	<script>

        $(".ss").click(function() {

            var province = $("#province option:selected").val();
            var xuan = $(".keyword option:selected").val();
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
                    alert("请选择你要搜索的查询类型")
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

//                if(type == 0) {
//                    alert("请选择地区");
//                    var isSuccess =0;
//                    return false;
//                }
//                if(typeschool == "") {
//                    var isSuccess = 0;
//                    alert("请选择学校");
//                    return false;
//                }
            }
            if(isSuccess == 0) {
                return false;
            }
        })





$(document).ready(function () {
    $("#message_type").val(0);
    $("#citys").val(0);

});
 
 //微信绑定码
 $(".showkey").click(function(){




  	  layer.load();
               var teacherid = $(this).attr("id");
                var type = $(this).attr("data-type");
               var obj = $(this).text();
               var schoolid = $(this).parent().attr("data-school");
               var cbj =$(this);

               
               
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
					url: "<?php echo U('Admin/Teacher/bindingkey');?>",
					dataType:'json',
					data: {
						'teacherid': teacherid,
						'schoolid':schoolid
					},
					success: function(res) {
							 setTimeout(function(){
                      layer.closeAll('loading');
                    });
						var data = eval(res.data);
					
						//TODO 因为只有一个绑定码 可以直接处理
						var bindKey = data[0]["bindingkey"];

					

						if(bindKey==null)
						{
							bindKey = '未绑定';
						}
						var tid = "#"+teacherid;
						$(cbj).text(bindKey);
						  
							// console.log(data.msg[0].bindingkey);
							// obj.text(data.msg[0].bindingkey);

					},
					error: function() {
						alert('系统错误,请稍后重试');
					}
				});
           });



  $('.tijiaofenzu').click(function(){

     var id = document.getElementsByName('group[]');

     var teacherid = $("body").find(".teacherid").val();

     var schoolid = $("body").find(".groupschool").val();

   
     var value = new Array();
            for(var i = 0; i < id.length; i++){
             if(id[i].checked)
             value.push(id[i].value);
            }

     $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Teacher/departmentpost');?>",
					data: {
						group:value,
						teacherid:teacherid,
						schoolid:schoolid,
						

					},
					success: function(res) {
				    
					window.location.reload(); //刷新当前页面.
                                   
							
                         
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});





         

})




  $('.dep').click(function(){

  	  $("body").find(".group").remove();

  	  $("body").find(".groupschool").val($(this).attr("data-school"));

  	  $("body").find(".teacherid").val($(this).attr("data-id"));

  	  $("body").find(".group_teacher").text($(this).parent().parent().find("td:eq(1)").text());
     
      $(this).parent().parent().find("td:eq(1)").text()


  	  layer.load();

   var schoolid = $(this).attr("data-school");
  var depid = $(this).attr("data-depid");
  

        $.ajax({
					type: "get",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Teacher/departmentedit');?>",
					data: {
						schoolid:schoolid,
						depid:depid,
						

					},
					success: function(res) {
						 setTimeout(function(){
                      layer.closeAll('loading');
                    });
					      res = eval(res.data);

						  
						   for (var i = 0; i < res.length; i++) {
						   	 
                               if(res[i].check==1)
                               { 
                               	// console.log('aaa');
                               	$(".fenzu").append("<div class=group style='float:left;    margin-right: 10px;'><div style=width: 20px;height: 20px;position: relative;top: 23px;></div><input type=checkbox name=group[] value = "+res[i].id+"  checked><span class=manid style='vertical-align: -2px;'>"+res[i].name+"</span></div>")
                                 
                                 }else{
                                  $(".fenzu").append("<div class=group style='float:left;    margin-right: 10px;'><div style=width: 20px;height: 20px;position: relative;top: 23px;></div><input type=checkbox name=group[] value = "+res[i].id+" ><span class=manid style='vertical-align: -2px;'>"+res[i].name+"</span></div>")
                         
                               }
                         }
					
                                   
							
                         
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});


 
  })


          $(".reset").click(function(){
             	var teacherid = $(this).attr("data-id");
             	console.log(teacherid);
             	var teacher_name = $(this).attr("data-na");
             	console.log(teacher_name);
              var schoolid = $(this).attr("data-school");
              console.log(schoolid);
              $('.techar_id').val(teacherid);
             	$('.teacher_mname').val(teacher_name);
              $('.passschoolid').val(schoolid);
             })


 $('.pwdtj').click(function(){
	               var teacherid = $('.techar_id').val();
	               var password = $('.pwd').val();
	               var teacher = $('.teacher_mname').val();
	               var rel = $('.rel').val();
	          		var passschoolid= $('.passschoolid').val();
                   // $("#myModal3").hide();
                    // $("#myModal3").modal("hide")

                   
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
	            $.ajax({
					type: "post",
					async: false,
					dataType:'json',
					url: "<?php echo U('Admin/Teacher/password');?>",
					data: {
						teacherid:teacherid,
						password:password,
                        passschoolid:passschoolid,

					},
					success: function(data) {
					
						if(data.status){
							$("#myModal3").modal("hide")
                            layer.msg(data.info, {
                                icon: 1
                                ,shade: 0.01,
                            });
							
                            
		                }else{
		                    alert(data.info);
		                }
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});

             })

       


			$(document).on('click', '.kemuzhi', function() {
				var zhiu = $(".zhike", this).text();
				var suiid = $(".suiid", this).val() + ",";
				var i = 0;
				htmls = '<span name="dian" style="border: 1px solid #03a9f4;margin-left: 5px;color: block;">' + zhiu + '<i class="fa fa-remove dianji" style="color: #00B7EE;position: relative;bottom: 3px;"></i><input class="sui" type="hidden"  value="' + suiid + '" /> </span>'
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

          
 

  
  $(".toclass").click(function(){
  // alert('aaaa');
   layer.load();

  })










//班级代课
 			//根据老师带班情况让复选选中
			$(".banbox").click(function() {
				// alert(1);
				// return false;
				 

				 // $("#myModal2")
				 // return  false;
				 // $("#myModal2").modal("show")  

              layer.load();
				 teacher_name =  $(this).parent().find("td:eq(1)").text();
				 // console.log(teacher_name);
				 $('.dk_teacher').text(teacher_name);
               
                var schoolid = $(this).parent().parent().attr("data-school");
                

                var class_obj = $('body').find('.class_info');

                $('.tischoolid').val(schoolid);

                $('body').find('.banji').remove();
                $('body').find('.kemuzhi').remove();	


                 var fuxuan = $(this).prev().val();
                 var laoclassid = $(this).prev().prev().val();

         
                 $.ajax({
					type: "get",
					async: true,

					dataType:'json',
					url: "<?php echo U('Admin/Teacher/showclass');?>",
					data: {
						schoolid:schoolid,
						

					},
					success: function(data) {
					
						if(data.status){
                          
                           for (var i = 0; i < data.msg.length; i++) {
                            
                             		class_obj.append('<div class="banji" style=" float:left; width:20%; margin-bottom:10px;cursor:pointer;"><div style="width: 20px;height: 20px;position: relative;top: 23px;"></div><input type="checkbox" name="class_else" id="class_chose" value='+data.msg[i]["id"]+' ><span class="manid" style=    "vertical-align: -3px;">'+data.msg[i]["classname"]+'</span></div>');              	

                           }
							
                    // var fuxuan = $(this).prev().val();

			
			
				// var laoclassid = $(".laoshiid", this).val();
				
		 
							$(".Loocliassid").val(laoclassid);
							$(".cliaasid").val(fuxuan); //用于通过对应的班级选择对应的课程
							var strs = fuxuan.split(","); //字符分割 
						
							for(var i = 0; i < strs.length; i++) {
								var shuzid = strs[i];
								
								$(".banji input").each(function() {
									var fuxuan = $(this).val()
									
									if(shuzid == fuxuan) {
										$(this).prop("checked", true);
									}
								})
							}

		                 var  teacherid = $(".Loocliassid").val();

		         $.ajax({
					type: "post",
					url: "<?php echo U('Admin/Teacher/teacher_class');?>",
					async: true,
					dataType: 'json',
					data: {
						teacherid: teacherid
					},
					success: function(res) {
						   
          
						var html = "";
						res = eval(res.data);
				
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
								html += '<span class="peizhi"><button type="button" class="btn btn-success"style="background-color: #06C08E;border-radius: 20px;height: 24px;"><span class="fa fa-plus"style="position: relative;bottom: 5px;" >设置</span></button></span>'
							} else {
								for(var g = 0; g < res[i].teacher_su.length; g++) {
									var cd = res[i].teacher_su[g].id + ",";
									classid += cd
									var bao = res[i].teacher_su[g].subject;
							html += '<span name="dian" style="border: 1px solid #03a9f4;margin-left: 5px;color: black;">' + bao + '<i class="fa fa-remove dianji" style="color: #00B7EE;position: relative;bottom: 3px;"></i><input class="sui" type="hidden"  value="' + cd + '" /> </span>'
								}
							html += '<button type="button" class="btn btn-success py"style="background-color: #06C08E;border-radius: 20px;height: 24px;display: none;position: relative;left: 39.5%;"><span  class="fa fa-plus"style="position: relative;bottom: 5px;">设置</span></button>'

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

				        

                            
		                }else{
		                  
		                  alert(data.info);
		                }
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});
 // alert(1);
             
                 $.ajax({
					type: "get",
					async: true,
					dataType:'json',
					url: "<?php echo U('Admin/Teacher/subject');?>",
					data: {
						schoolid:schoolid,
						

					},
					success: function(data) {
						// console.log(data);

						if(data.status){
						
                      
                      	setTimeout(function(){
                      layer.closeAll('loading');
                    });
							    $("#myModal2").modal("show")  
							  
                          
                           for (var i = 0; i < data.msg.length; i++) {
                            
                            
                            $('.append_boxke').append('	<span class="kemuzhi" style="color:gray;font-size: 15px;cursor: pointer;margin-right: 10px;"><i class="fa fa-upload"style="color: gainsboro;"></i><i class="zhike">'+data.msg[i]["subject"]+'</i><input class="suiid" type="hidden" value='+data.msg[i]["id"]+' /></span>')
                             	

                           }
							
                            
		                }else{
		                   alert(data.info);
		                   setTimeout(function(){
                      layer.closeAll('loading');
                    }); 
		                }
					},
					//请求失败
					 error:function(){
		               alert('请求失败');
		            }
				});             








				$(".hideid").show();
			    $(".daike_box").css("display", "none");
			    $("#huoqudaike").attr("class", "");
				$("#daibananiu").attr("class", "active");
				$(".banji input").prop("checked", false);
				// var fuxuan = $(".zhishu", this).val();
				

				//老师带啦多少班级的ajax请求
				
				
	

				$(".dai").remove();
				
			})

//职位管理
        $(".zhiweibox").click(function() {

            //layer.load();
            teacher_name =  $(this).parent().find("td:eq(1)").text();
             //console.log(teacher_name);
            $('.dk_teachers').text(teacher_name);

            var schoolid = $(this).parent().parent().attr("data-school");


            var class_obj = $('body').find('.zhiwei_info');

            $('.tischoolids').val(schoolid);

            $('body').find('.zhiwei').remove();
            $('body').find('.kemuzhis').remove();


            var fuxuan = $(this).prev().val();
            var laoclassid = $(this).prev().prev().val();

            $.ajax({
                type: "get",
                async: true,

                dataType:'json',
                url: "<?php echo U('Admin/Teacher/showzhiwei');?>",
                data: {
                    schoolid:schoolid,
                },
                success: function(data) {
                    if(data.status){
                        for (var i = 0; i < data.msg.length; i++) {
                            class_obj.append('<div class="job" style=" float:left; width:20%; margin-bottom:10px;cursor:pointer;"><div style="width: 20px;height: 20px;position: relative;top: 23px;"></div><input type="checkbox" name="class_else" id="class_chose" value='+data.msg[i]["id"]+' ><span class="manid" style=    "vertical-align: -3px;">'+data.msg[i]["classname"]+'</span></div>');
                        }
						$(".Loocliassids").val(laoclassid);
                        $(".cliaasids").val(fuxuan); //用于通过对应的班级选择对应的课程
                        var strs = fuxuan.split(","); //字符分割
						for(var i = 0; i < strs.length; i++) {
                            var shuzid = strs[i];
							$(".job input").each(function() {
                                var fuxuan = $(this).val()
								if(shuzid == fuxuan) {
                                    $(this).prop("checked", true);
                                }
                            })
                        }
						var  teacherid = $(".Loocliassids").val();
                    }else{
                        alert(data.info);
                    }
                },
                //请求失败
                error:function(){
                    alert('请求失败');
                }
            });
            // alert(1);
            $("#myModal7").modal("show");
            $(".job input").prop("checked", false);
            $(".job").remove();

        })




		$("#huoqudaike").click(function() {
				$(".hideid").hide()
				$(".daike_box").css("display", "block")
				$("#huoqudaike").attr("class", "active");
				$("#daibananiu").attr("class", "");

			})

			$("#daibananiu").click(function() {
				$("#huoqudaike").attr("class", "");
				$("#daibananiu").attr("class", "active");
				$(".hideid").show();
				$(".daike_box").css("display", "none");
			})




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
			   
			    
			   
				   for(var j=0;j<strsa.length;j++){
				   	   var c_class=strsa[j];
				   	   class_banji.push({
				   	   	  classid:c_class
				   	   })
				   }
				
                 // console.log(class_banji);

				   var schoolid = $('.tischoolid').val();
				 
                    $.ajax({
					type: "get",
					async: false,
					url: "<?php echo U('Admin/Teacher/teacher_class_subject');?>",
					data: {
						'teacherid': teacherid,
						'class_subject': class_subject,
						'class_banji':class_banji,
						'schoolid':schoolid,
					  },
					success: function(msg) {
						window.location.reload(); //刷新当前页面.
					},
				error: function() {
						alert('系统错误,请稍后重试');
					}
				  });
			})

        $(".tijiaozhiwei").click(function() {
            var teacherid = $(".Loocliassids").val();
            var class_si = $(".cliaasids").val();
            var class_banji = [];
            var strsa=class_si.split(","); //字符分割

            for(var j=0;j<strsa.length;j++){
                var c_class=strsa[j];
                class_banji.push({
                    zhiweiid:c_class
                })
            }

            // console.log(class_banji);

            var schoolid = $('.tischoolids').val();

            $.ajax({
                type: "get",
                async: false,
                url: "<?php echo U('Admin/Teacher/teacher_zhiwei_edit');?>",
                data: {
                    'teacherid': teacherid,
                    'teacher_zhiwei':class_banji,
                    'schoolid':schoolid,
                },
                success: function(msg) {
                    window.location.reload(); //刷新当前页面.
                },
                error: function() {
                    alert('系统错误,请稍后重试');
                }
            });
        })

       // 点击div 让复选框选中
	 $(document).on('click', '.banji', function() {
				var namekecheng = $(".manid", this).text();
				// console.log(namekecheng);
			
				var html = "";
				var classid = "";
				var checkboxdanxuan = $("input[type='checkbox']", this).is(':checked');
			
				var cliaasid = $(".cliaasid").val();
				
				var checkboxid = $("input[type='checkbox']", this).val() + ",";
				
		
				var iuy = $("input[type='checkbox']", this).val();
		
				if(checkboxdanxuan == false) {
					$("input[type='checkbox']", this).prop("checked", true);

					var jiahe = cliaasid + checkboxid;
					
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

        // 点击div 让复选框选中
        $(document).on('click', '.job', function() {

            var checkboxdanxuan = $("input[type='checkbox']", this).is(':checked');
            var cliaasid = $(".cliaasids").val();

            var checkboxid = $("input[type='checkbox']", this).val() + ",";
            if(checkboxdanxuan == false) {
                $("input[type='checkbox']", this).prop("checked", true);
                var jiahe = cliaasid + checkboxid;

                $(".cliaasids").val(jiahe);
            } else {
                $("input[type='checkbox']", this).prop("checked", false);
                var xiazhi = cliaasid.replace(checkboxid, "");

                $(".cliaasids").val(xiazhi);
            }
        })

$(document).on('click', '[name="dian"]', function() {

				var Huo = $(this).parent().children("input:last-child").val();
				var shuzhi = $(".sui", this).val();
				var xiazhi = Huo.replace(shuzhi, "");
				$(this).parent().children("input:last-child").val(xiazhi);
				$(".dianji", this).parent().remove();
			})

//班级代课end









if($("#province").val())
{

	// console.log($("#province").val());
 var new_citys = $('body').find(".new_citys").val();


 var new_message_type = $('body').find('.new_message_type').val();

 


 var type_school = $('body').find(".type_school").val();


	  if(new_citys || $("#province").val())
	  {
	      $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
	                    // console.log(data);
	                      if(data.status=="success"){
	                      $("#citys").empty();	
	                          $("#citys").append("<option value=>"+"请选择市级"+"</option>");
	                          for(var key in data.data){
	                          	
                                 if(new_citys==data.data[key]["term_id"]){
	                              $("#citys").append("<option value="+data.data[key]["term_id"]+ " selected>"+data.data[key]["name"]+"</option>");

                                    }else{
                                    	 $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                                    }
	                            }
                                           $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
						                    // console.log(data);
						                      if(data.status=="success"){
						                        $("#message_type").empty();
                                                  $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
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
															$(".Sio").text("")
															var html = "";
															res = eval(res.data);
															for(var i = 0; i < res.length; i++) {
																var school_name = res[i].school_name; //学校的名字
																var schoolid = res[i].schoolid; //学校的ID
																if(schoolid== type_school){
																$("#viewOLanguage").append("<option value="+schoolid+" selected >"+school_name+"</option>");
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





//修改老师卡号
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
					url: "<?php echo U('Admin/Teacher/updateICcard');?>",
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




$(".daibanzhuren").click(
				function() {
					w = $(this).children().val()
					$(".chuanzhi").val(w)
					$(".uisid").val(w);

					var ICname = $(this).prev().prev().prev().text()
                     console.log(ICname);
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
					url: "<?php echo U('Admin/Teacher/delcard');?>",
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
					console.log(l);
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

				// console.log(shuzhi);




				if(shuzhi == "设置") {
					$('.sic').css('display','none');
					$(".xiugai").text("新增卡号：");
				} else {
					$('.sic').css('display','block');
					$(".xiugai").text("修改卡号：");
				}
			})


  		$("#myModal").hide();
  		$("#myModal2").hide();
  		$("#myModal5").hide();

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




//修改卡号end


  $('.daochu').click(function(){

   var xuan = $(".keyword option:selected").val();
   console.log(xuan);
    
     var zhi = $(".zhi").val();
      
      console.log(zhi);
   var citys = $(".citys option:selected").val();
   console.log(citys);
   if(citys=='')
   {
   	alert('请选择市级');
   	return false;
   }
   var message_type = $('.message_type option:selected').val();
   console.log(message_type);
   if(message_type=='')
   {
   	alert('请选择县');
   	return false;
   }
   var school = $(".chzn-select  option:selected").val();

   if(school == '')
   {
   	alert('请选择学校');
   	return false;
   }

   if (citys != false && message_type != false && school != false) {

		    if (confirm("确定要导出吗？")) {
		              
		                        
		          location.href="<?php echo U('Teacher/excel');?>?schoold="+school+"&tiaojian="+xuan+"&shuzhi="+zhi+"" ;                  

		     }   

     
   }
    


  })

		function refersh_window() {
			var refersh_time = getCookie('refersh_time');
			if (refersh_time == 1) {
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
								if ($(this).attr('checked')) {
									str = 1;
									id += tag + $(this).val();
									tag = ',';
								}
							});
							if (str == 0) {
								art.dialog.through({
									id : 'error',
									icon : 'error',
									content : '您没有勾选信息，无法进行操作！',
									cancelVal : '关闭',
									cancel : true
								});
								return false;
							}
							var $this = $(this);
							art.dialog.open(
									"/weixiaotong2016/index.php?g=portal&m=AdminPost&a=move&ids="
											+ id, {
										title : "批量移动",
										width : "80%"
									});
						});
			});
		});

        $(function () { $("[data-toggle='tooltip']").tooltip(); });
        //选择市级的下拉的ajax
              $(function() {
              $("#province").change(function() {

                 $("#citys").empty();
                 $("#message_type").empty();
                  $(".Sio").text("")
                  $("#viewOLanguage").chosen();
                  $("#viewOLanguage").trigger("liszt:updated");

                 // $("#student").empty();
                  $("#citys").append("<option value=0>"+"请选择市级"+"</option>");
                 $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
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
              });
          });

             $(function() {
              $("#citys").change(function() {
                  $("#message_type").empty();
                  $(".Sio").text("")
                  $("#viewOLanguage").empty();
                  $("#viewOLanguage").chosen();
                  $("#viewOLanguage").trigger("liszt:updated");
                  $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
                  $("#viewOLanguage").append("<option value=''>请选择学校</option>");
                  if( $("#citys").val()==0)
                  {
                      return false;
                  }
                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                      if(data.status=="success"){


                          for(var key in data.data){
                              $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                          }
                      }
                      if(data.status=="error"){
                          $("#message_type").append("<option value='0'>没有市级</option>");
                      }
                  });
              });
          });
        // $(".citys").click(function(){
        //     $(".jiu").hide();
        //     var Province =$(".province option:selected").val();
        //     if(Province==""){
        //         alert("请选择你要搜索的省")
        //     }else{
        //         $.ajax({
        //             type:"post",
        //             url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
        //             async:true,
        //             data:{
        //                 Province:Province
        //             },
        //             dataType: 'json',
        //             success: function(res) {
        //                 var html = "";
        //                 res = eval(res.data);
        //                 for(var i = 0; i < res.length; i++) {
        //                     var name=res[i].name;//地区的名字；
        //                     var term_id=res[i].term_id;//地区的ID
        //                     html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
        //                 }
        //                 $(".citys").append(html);
        //             },
        //             error: function() {
        //                 console.log('系统错误,请稍后重试');
        //             }
        //         });
        //     }

        // })
        // //选择县级市
        // $(".message_type").click(function(){
        //     $(".jius").hide()
        //     var zhi= $(".citys option:selected").val();
        //     if(zhi==""){
        //         alert("请选你要搜索的市")
        //     }else{
        //         $.ajax({
        //             type:"post",
        //             url: '/weixiaotong2016/index.php/?g=Admin&m=Teacher&a=Provinces',
        //             async:true,
        //             data:{
        //                 Province:zhi
        //             },
        //             dataType: 'json',
        //             success: function(res) {
        //                 var html = "";
        //                 res = eval(res.data);
        //                 for(var i = 0; i < res.length; i++) {
        //                     var name=res[i].name;//地区的名字；
        //                     var term_id=res[i].term_id;//地区的ID
        //                     html+='<option class="jius"value="'+term_id+'">'+name+' </option> '
        //                 }
        //                 $(".message_type").append(html)
        //             },
        //             error: function() {
        //                 console.log('系统错误,请稍后重试');
        //             }
        //         });
        //     }

        // })
        $("#viewOLanguage").chosen();
        $("#viewOLanguage").trigger("liszt:updated");

        $("#message_type").change(function(){
            $("#viewOLanguage").empty();
            $(".Sio").text("")
            $("#viewOLanguage").chosen();
            $("#viewOLanguage").trigger("liszt:updated");
            $("#viewOLanguage").append("<option value=''>请选择学校</option>");

            var type = $("#message_type").val();
            $.ajax({
                type:"post",
                url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
                async:true,
                data:{
                    type:type
                },
                dataType: 'json',
                success: function(res) {



                    var html = "";
                    res = eval(res.data);

                    for(var i = 0; i < res.length; i++) {
                        var school_name=res[i].school_name;//学校的名字
                        var schoolid=res[i].schoolid;//学校的ID
                        html+='<option name="school" class="Sio" value="'+schoolid+'">'+school_name+' </option> '
                    }
                    $(".chzn-select").append(html)

                    $("#viewOLanguage").trigger("liszt:updated");
                },
                error: function() {
                    console.log('系统错误,请稍后重试');
                }
            });
        })
	</script>
</body>
</html>