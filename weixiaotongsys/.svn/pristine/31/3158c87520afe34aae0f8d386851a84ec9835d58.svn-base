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
    <link href="/weixiaotong2016/tpl_teacher/simpleboot/assets/css/mychangestyle.css" rel="stylesheet" />
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
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 210px; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle; color: black;}
.picList li{margin-bottom: 5px;}
 div {overflow:auto;}

 tr{color: black;} 
 td select{color: black;}
 html{overflow-y:auto;overflow-x:auto;}
 .normal_select{
  width: 100px;
 }


select{
    color: black;
}


</style>
</head>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap" style=" margin-top: 20px;margin-left: 30px; margin-right: 30px;     margin-bottom: 30px;">
  <ul class="nav nav-tabs">
     <li style="color: #000;">班级课程表</li>
  </ul>
  <form name="myform" id="myform1" action="<?php echo u('index');?>" method="post" class="form-horizontal J_ajaxForms" enctype="multipart/form-data">
  <div class="col-auto">
    <div class="table_full">
      <table class="table table-bordered" style=" border:none;">
                <!-- <div class="control-group">
                    <div class="mb10">
                       <span class="mr20">学校：
                          <select id="school" name="school"  class="normal_select" style="max-height: 100px;">
                              <OPTION value="0">请选择学校</OPTION> 
                              <?php if(is_array($school_name)): foreach($school_name as $key=>$vo): ?><OPTION value="<?php echo ($vo["schoolid"]); ?>"><?php echo ($vo["school_name"]); ?></OPTION><?php endforeach; endif; ?>           
                          </select>
                       </span>
                    </div>
                </div> --> 
                <div class="">
                    <div class="">
                       <span class="mr20">班级：
                          <select id="class" name="classid"  class="normal_select" style="max-height: 100px;" onchange="check(this.form)">
                              <OPTION value="0">请选择班级</OPTION> 
                              <?php if(is_array($class)): foreach($class as $key=>$vo): $class_se=$class_id==$vo['id']?"selected":""; ?>
                                   <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($class_se); ?>><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                          </select><button  onclick="sub_qrcj()"  type="button" style=" background-color:#26a79b; border-color:#26a79b; border-style:none; color: white; border-radius: 5px; padding: 5px 15px; font-size: 17px; margin-left: 10px;">保存课表</button>
                       </span>
               <!--         <button class="  btn_submit J_ajax_submit_btn"type="submit" style=" background-color:#26a79b; border-color:#26a79b; border-style:none; color: white; border-radius: 5px; padding: 5px 12px;  margin-left: 10px;">查询</button> -->
                    </div>
                </div> 
              </table>
             
            </div>
          </div>
          <div class="" style=" background-color: white; width: 70px; margin-left: auto; margin-right: auto;">
  <input type="hidden" class="input" name="class_id" value="<?php echo ($class_id); ?>"  readOnly="true">
 
       
  </div>
        </form>  
  <form name="myform" id="myform" action="<?php echo u('add');?>" method="post" class="form-horizontal J_ajaxForms" enctype="multipart/form-data">
  
  <input type="hidden" class="input" name="class_id" value="<?php echo ($class_id); ?>" >

  <div class="" style="margin-top: -35px;">
    <div class="table_full" style="    margin-bottom: 10px;">
      <table class="table table-bordered" style="width: 1050px;
     margin: auto;">
                <!-- <div class="control-group">
                    <div class="mb10">
                       <span class="mr20">学校：
                          <select id="school" name="school"  class="normal_select" style="max-height: 100px;">
                              <OPTION value="0">请选择学校</OPTION> 
                              <?php if(is_array($school_name)): foreach($school_name as $key=>$vo): ?><OPTION value="<?php echo ($vo["schoolid"]); ?>"><?php echo ($vo["school_name"]); ?></OPTION><?php endforeach; endif; ?>           
                          </select>
                       </span>
                    </div>
                </div> --> 
                <!-- <div class="control-group">
                    <div class="mb10">
                       <span class="mr20">班级：
                          <select id="class" name="classid"  class="normal_select" style="max-height: 100px;">
                              <OPTION value="0">请选择班级</OPTION> 
                              <?php if(is_array($class)): foreach($class as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>           
                          </select>
                       </span>
                    </div>
                </div>  -->
                <thead>
    <div style=" font-size: 17px; text-align: center;
    margin-bottom: 10px;"><span style=" font-weight: bold; margin-right: 5px;"><&nbsp;<?php echo ($classname); ?>&nbsp;></span><span sty>课程表</span></div>
                	
        <tr width="110">
            <th style=" text-align: center;">节次</th>
            <th style=" text-align: center;">星期一</th>
            <th style=" text-align: center;">星期二</th>
            <th style=" text-align: center;">星期三</th>
            <th style=" text-align: center;">星期四</th>
            <th style=" text-align: center;">星期五</th>
            <th style=" text-align: center;">星期六</th>
            <th style=" text-align: center;">星期天</th>
        </tr>
        </thead> 
        <colgroup><col/><col /></colgroup>
        <tr>
           <td style=" text-align: center;">第一节</td>
           <td width="110">
           	<select id="school" name="mon_fir"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondayone=$monday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_fir"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdayone=$tuesday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_fir"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdayone=$wednesday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_fir"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdayone=$thursday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_fir"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridayone=$friday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_fir"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdayone=$saturday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_fir"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundayone=$sunday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundayone); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第二节</td>
           <td width="110">
           	<select id="school" name="mon_se"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondaytwo=$monday_two['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_se"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdaytwo=$tuesday_two['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_se"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdaytwo=$wednesday_two['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>          
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_se"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdaytwo=$thursday_two['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_se"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridaytwo=$friday_two['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_se"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdaytwo=$sunday_one['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_se"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundaytwo=$sunday_two['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundaytwo); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第三节</td>
           <td width="110">
           	<select id="school" name="mon_th"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondaythree=$monday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_th"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdaythree=$tuesday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_th"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdaythree=$wednesday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_th"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdaythree=$thursday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_th"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridaythree=$friday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_th"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdaythree=$saturday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_th"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundaythree=$sunday_three['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundaythree); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第四节</td>
           <td width="110">
           	<select id="school" name="mon_fo"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondayfour=$monday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_fo"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdayfour=$tuesday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_fo"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdayfour=$wednesday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_fo"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdayfour=$thursday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_fo"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridayfour=$friday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_fo"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdayfour=$saturday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_fo"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundayfour=$sunday_four['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundayfour); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第五节</td>
           <td width="110">
           	<select id="school" name="mon_fi"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondayfive=$monday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>          
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_fi"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdayfive=$tuesday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_fi"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdayfive=$wednesday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_fi"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
               <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdayfive=$thursday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_fi"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridayfive=$friday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>          
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_fi"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdayfive=$saturday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_fi"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundayfive=$sunday_five['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundayfive); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第六节</td>
           <td width="110">
           	<select id="school" name="mon_si"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondaysix=$monday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_si"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdaysix=$tuesday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>          
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_si"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdaysix=$wednesday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_si"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdaysix=$thursday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_si"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridaysix=$friday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_si"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdaysix=$saturday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_si"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundaysix=$sunday_six['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundaysix); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第七节</td>
           <td width="110">
           	<select id="school" name="mon_seve"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondayseven=$monday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_seve"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdayseven=$tuesday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_seve"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdayseven=$wednesday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_seve"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdayseven=$thursday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_seve"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridayseven=$friday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_seve"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdayseven=$saturday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_seve"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundayseven=$sunday_seven['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundayseven); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>            
            </select>
           </td>
        </tr>
        <tr>
           <td style=" text-align: center;">第八节</td>
           <td width="110">
           	<select id="school" name="mon_ei"  class="normal_select" style="max-height: 50px;">
           	    <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $mondayeight=$monday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($mondayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>          
            </select>
           </td>
           <td width="110">
           	<select id="school" name="tu_ei"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $tuesdayeight=$tuesday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($tuesdayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="we_ei"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $wednesdayeight=$wednesday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($wednesdayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="th_ei"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $thursdayeight=$thursday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($thursdayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="fri_ei"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $fridayeight=$friday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($fridayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sat_ei"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $saturdayeight=$saturday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($saturdayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
           <td width="110">
           	<select id="school" name="sun_ei"  class="normal_select" style="max-height: 50px;">
                <OPTION value="0">未设置</OPTION>
                <?php if(is_array($lesson_name)): foreach($lesson_name as $key=>$vo): $sundayeight=$sunday_eight['id']==$vo['id']?"selected":""; ?>
                     <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($sundayeight); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>           
            </select>
           </td>
        </tr>
        <!-- </foreach> -->
        </tbody>
      </table>
    </div>

  </div>
    <div  style="margin: auto 0px;">
     
    </div>


 </form>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
<script>

function check(form)
{
    alert("11");
  $("#class").val();

  if($("#class").val()!=='0')
  {
    form.submit();
  }
  


}

 // document.myform.submit();

    function sub_qrcj() {
    var classid = $("input[name='class_id']").val();

    $.ajax({
      type:"post",
      async:false,
      url:"<?php echo U('Teacher/ClassSubject/add');?>",
      data:$('#myform').serialize(),
      success: function(msg){
        history.go(0);
      }
    });
  }
</script>
<script type="text/javascript"> 
$(function () {
	$(".J_ajax_close_btn").on('click', function (e) {
	    e.preventDefault();
	    Wind.use("artDialog", function () {
	        art.dialog({
	            id: "question",
	            icon: "question",
	            fixed: true,
	            lock: true,
	            background: "#CCCCCC",
	            opacity: 0,
	            content: "您确定需要关闭当前页面嘛？",
	            ok:function(){
					setCookie("refersh_time",1);
					window.close();
					return true;
				}
	        });
	    });
	});
	/////---------------------
	 Wind.use('validate', 'ajaxForm', 'artDialog', function () {
			//javascript
	        
	            //编辑器
	            editorcontent = new baidu.editor.ui.Editor();
	            editorcontent.render( 'content' );
	            try{editorcontent.sync();}catch(err){};
	            //增加编辑器验证规则
	            jQuery.validator.addMethod('editorcontent',function(){
	                try{editorcontent.sync();}catch(err){};
	                return editorcontent.hasContents();
	            });
	            var form = $('form.J_ajaxForms');
	        //ie处理placeholder提交问题
	        if ($.browser.msie) {
	            form.find('[placeholder]').each(function () {
	                var input = $(this);
	                if (input.val() == input.attr('placeholder')) {
	                    input.val('');
	                }
	            });
	        }
	        //表单验证开始
	        form.validate({
				//是否在获取焦点时验证
				onfocusout:false,
				//是否在敲击键盘时验证
				onkeyup:false,
				//当鼠标掉级时验证
				onclick: false,
	            //验证错误
	            showErrors: function (errorMap, errorArr) {
					//errorMap {'name':'错误信息'}
					//errorArr [{'message':'错误信息',element:({})}]
					try{
						$(errorArr[0].element).focus();
						art.dialog({
							id:'error',
							icon: 'error',
							lock: true,
							fixed: true,
							background:"#CCCCCC",
							opacity:0,
							content: errorArr[0].message,
							cancelVal: '确定',
							cancel: function(){
								$(errorArr[0].element).focus();
							}
						});
					}catch(err){
					}
	            },
	            //验证规则
	            rules: {'post[post_title]':{required:1},'post[post_content]':{editorcontent:true}},
	            //验证未通过提示消息
	            messages: {'post[post_title]':{required:'请输入标题'},'post[post_content]':{editorcontent:'内容不能为空'}},
	            //给未通过验证的元素加效果,闪烁等
	            highlight: false,
	            //是否在获取焦点时验证
	            onfocusout: false,
	            //验证通过，提交表单
	            submitHandler: function (forms) {
	                $(forms).ajaxSubmit({
	                    url: form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
	                    dataType: 'json',
	                    beforeSubmit: function (arr, $form, options) {
	                        
	                    },
	                    success: function (data, statusText, xhr, $form) {
	                        if(data.status){
								setCookie("refersh_time",1);
								//添加成功
								Wind.use("artDialog", function () {
								    art.dialog({
								        id: "succeed",
								        icon: "succeed",
								        fixed: true,
								        lock: true,
								        background: "#CCCCCC",
								        opacity: 0,
								        content: data.info,
										button:[
											{
												name: '继续添加？',
												callback:function(){
													reloadPage(window);
													return true;
												},
												focus: true
											},{
												name: '返回列表页',
												callback:function(){
													location='<?php echo U('BabyClass/index');?>';
													return true;
												}
											}
										]
								    });
								});
							}else{
								isalert(data.info);
							}
	                    }
	                });
	            }
	        });
	    });
	////-------------------------
});
</script>
</body>
</html>