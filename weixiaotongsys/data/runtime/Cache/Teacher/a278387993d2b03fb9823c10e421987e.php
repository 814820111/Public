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
<style type="text/css">
  


            a{
            color:#00c1dd;
         }   
         div{
          color: black;
         }
</style>

<script src="http://code.jquery.com/jquery-1.4.4.min.js" type="text/javascript"></script>  



<script src="/weixiaotong2016/statics/js/common.js"></script>
<script src="/weixiaotong2016/Public/js/common.js"></script>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="js/fileinput.js" type="text/javascript"></script>
<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<body>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
      <li class="active"><a href="<?php echo U('StudentLeave/index_leave');?>" style="color:#1f1f1f;text-decoration: none;">学生请假</a></li>
   	</ul>


      <div style=" background-color:rgba(0,0,0,0.7); width:100%; height:200%; position:absolute; display: none" class="daitan"  >
        <div style=" width:600px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
          <form>
            <div>
              <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">回复信息</div>
              <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
            </div>
            <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">
              <div class="dbzr"></div>
            
              <div class="clearfix"></div>
            </div>
             <input type="hidden" class="vacate" name="vacate">
             <input type="hidden" class="sta" name="status">
              
              <div style=" margin-top: 20px;">
                  <div style="width: 100px; float: left; text-align: right; ">消息内容:&nbsp;&nbsp;</div>
                  <textarea  class="content" name="content"  style="width: 400px;" rows="3"></textarea>
               
                  <div class="clearfix"></div>
           </div>


    
            <!-- <div style=" margin-bottom:10px; margin-left:30px;">
                      确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
                    </div> -->
            <div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">
              <input type="submit"  class="fs" value="发&nbsp;送" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='sub_card()'>

            </div>
          </form>
          <!--关闭start-->
          <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="guan">
          <!--关闭end-->
        </div>
      </div>





 


<div class="" style="margin-left: 25px; margin-right: 20px;">
  <form class="" method="get" action="<?php echo U('StudentLeave/index_leave');?>" style="margin: 20px 0px 5px">
       班级： 
      <select class="select_2" name="class" style=" width: auto; vertical-align: 1px;">
        <option value='0'>请选择班级</option>
        <?php if(is_array($categorys)): foreach($categorys as $key=>$vo): $class_info=$class_c==$vo['id']?"selected":""; ?>
        <option value="<?php echo ($vo["id"]); ?>" <?php echo ($class_info); ?>><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
      </select> &nbsp;&nbsp;
      学生姓名：
      <input type="text" style="width: 7%;     vertical-align: 1px; height: 30px ;border-width: 1px; color: black;" name="student_name" value="<?php echo ($student_name); ?>" autocomplete="off"  placeholder="请输入学生姓名..." >&nbsp;&nbsp;
	    选择时间：
	        <input type="text" class="sang_Calender" name="start_time" placeholder="-选择时间-" style="width: 10%; height: 30px;     vertical-align: 1px; border-width: 1px; color: black;" value="<?php echo ($start_time_unix); ?>">  -  <input type="text" class="sang_Calender" name="end_time" placeholder="-选择时间-" style="width: 10%; height: 30px; border-width: 1px; color: black;" value="<?php echo ($end_time_unix); ?>"> &nbsp; &nbsp;
         <div> 
      请假状态： 
       <select class="select_2" name="status" style=" width: auto;     vertical-align: 1px;">
       <!-- 注：什么都不写(即不写value)则传0，若写成value='0'则什么都 不传即为空 -->
         <option value='-1' <?php if($status==-1) echo("selected");?>>-请选择-</option>
         <option value='0' <?php if($status==0) echo("selected");?>>等待</option>
         <option value='1' <?php if($status==1) echo("selected");?>>同意</option>
         <option value='2' <?php if($status==2) echo("selected");?>>拒绝</option>
      </select> &nbsp;&nbsp;
         请假类型： 
       <select class="select_2" name="leavetype" style=" width: auto;     vertical-align: 1px;">
       <!-- 注：什么都不写(即不写value)则传0，若写成value='0'则什么都 不传即为空 -->
         <option value=''>-请选择-</option>
         <option value='病假'<?php if($leavetype==病假) echo("selected");?>>病假</option>
         <option value='事假' <?php if($leavetype==事假) echo("selected");?>>事假</option>
      </select> &nbsp;&nbsp;
      <input  type="submit"  style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;     vertical-align: 1px;"  value="查询" />
      </div>
    </form>
     <form class="js-ajax-form" action="" method="post" action="<?php echo U('StudentLeave/index_leave');?>">
      <table class="table table-hover table-bordered table-list">
        <thead>
          <tr>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;"><input type='checkbox' id='checkAll' name="checkAll">全选</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">班级</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">学生姓名</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">开始时间</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">结束时间</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">原因</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">请假类型</th>
            <th style=" text-align: center; background-color: #e2e2e2;border-left: none;border-width:0.5px;">请假状态</th>

          </tr>
        </thead>
        <?php if(is_array($lists)): foreach($lists as $key=>$vo): ?><tr>
       <td style=" text-align: center; border-left:none;border-top:none;"><input type="checkbox" class="J_check" id='sel_all' name="ids[]" value="<?php echo ($vo["phone"]); ?>" title="Phone:<?php echo ($vo["phone"]); ?>"></td>
            <td style=" text-align: center; border-left:none;border-top:none;"><?php echo ($vo["classname"]); ?></td>
            <td style=" text-align: center; border-left:none;border-top:none;"><?php echo ($vo["student_name"]); ?></td>
            <td style=" text-align: center; border-left:none;border-top:none;"><?php echo (date("Y-m-d H:i:s",$vo["begintime"])); ?></td>
            <td style=" text-align: center; border-left:none;border-top:none;"><?php echo (date("Y-m-d H:i:s",$vo["endtime"])); ?></td>
           	
            <td style=" text-align: center;border-left:none;border-top:none;"><?php echo ($vo["leavetype"]); ?></td>
            
           
   


            <td style=" text-align: center; border-left:none;border-top:none;border-right:none;">
	           <?php if($vo['status'] == 0): ?>等待
	              <?php elseif($vo['status'] == 1): ?> 
	              同意
	              <?php elseif($vo['status'] == 2): ?>
	              拒绝<?php endif; ?>
            </td>
            <td style=" text-align: center; ">
	            	<?php if($vo['status'] == 1): ?><a title="已同意，该按钮不可点击"  href ="javascript:return false;" onclick="false;" style="cursor: default;">
	                    <span class="edit" style="opacity: 0.4; cursor: pointer; color:#00c1dd;">同意</span> 
	                  </a>
	                  &nbsp;&nbsp;||&nbsp;&nbsp;
	                  <a  onclick="agree_not(<?php echo ($vo["id"]); ?>,2)"  style="cursor: pointer; color:#00c1dd;">拒绝</a>
	                <?php elseif($vo['status'] == 2): ?>

	                  <a  class="agree"  data-id="<?php echo ($vo["id"]); ?>"  data-ad = "1"  style="cursor: pointer;color:#00c1dd;">同意</a>
	                   &nbsp;&nbsp;||&nbsp;&nbsp;
	                   <a title="已拒绝，该按钮不可点击"  href ="javascript:return false;" onclick="false;" style="cursor: default;">
	                    <span class="edit" style="opacity: 0.4; cursor: pointer; color:#00c1dd;">拒绝</span> 
	                  </a>
	                <?php elseif($vo['status'] == 0): ?>
		                <a  class="agree"  data-id="<?php echo ($vo["id"]); ?>"  data-ad = "1"  data-target="#myModal2"  data-toggle="modal" style="cursor: pointer;color:#00c1dd;"  >同意</a>
		                  &nbsp;&nbsp;||&nbsp;&nbsp;
		                <a  class="refuse" onclick="agree_not(<?php echo ($vo["id"]); ?>,-1)" style="cursor: pointer;color:#00c1dd;">拒绝</a><?php endif; ?>
            </td>                
        </tr><?php endforeach; endif; ?>
      </table>
  
      <div class="pagination" style="position: relative;bottom: 50px;"><?php echo ($Page); ?></div>
    </form>

</div>


    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>


    <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>

<script >
      $(function() {
        $("#checkAll").click(function() {
          $('input[class="J_check"]').prop("checked", $(this).prop("checked")); 
        });
        var $J_check = $("input[class='J_check']");
        $J_check.click(function(){
          $("#checkAll").prop("checked",$J_check.length == $("input[class='J_check']:checked").length ? true : false);
        });
      });
</script>
<script >

$('.agree').click(function(){
   id = $(this).attr('data-id');
   console.log(id);
    

   status = $(this).attr('data-ad');
   console.log(status);

     
       $(".daitan").show()
     $('.vacate').val(id);
     $('.sta').val(status);  
      

})


$('.fs').click(function(){
  id = $('.vacate').val();
  status = $('.sta').val();
  
  content = $('.content').val();
  console.log(content);

  console.log(id);
  console.log(status);
  agree_not(id,status,content);

})




$(".guan").click(
        function() {
          $(".daitan").hide()
        }

      )





function agree_not(id,status,content)
{

   // console.log(id);
   // console.log(status);

    $.ajax({
      type:"post",
      async:false,
      url:"<?php echo U('StudentLeave/agree_not');?>",
      data:{'id': id,'status_a':status,'content':content},
      success: function(msg){
        alert(msg);
        location.reload() 
      }
    });
}



</script>









</body>
</html>