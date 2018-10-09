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
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>考勤管理</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script> -->
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/datePicker/datePicker.js" type="text/javascript"></script>
<!-- <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script> -->
<!-- <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script> -->
<!-- <script src="/weixiaotong2016/statics/js/common.js"></script> -->
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
	.touchlei{ background-color:#eeeeee;}
      tr .pai {
        background-color: #e2e2e2;
      } 
      a{
  color: #00c1dd
}
div{
  color: black;
}
</style>
</head>
<body>
<div class="" style="margin-left: 20px; height: 28px; margin-right: 20px;">
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none; margin-left: 0;">
   		<li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">班级考勤查询</a></li>
      <li><a href="<?php echo U('count');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">班级考勤统计</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('ClassAttendance/index');?>" method="get" style="margin:0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                     <div style="  display: inline-block;" >

                    班级:
                      <select class="select_2" name="c_id" style=" width:auto;">
                         <option value='0'>-选择班级-</option>
                         <?php if(is_array($class)): foreach($class as $key=>$vo): $class_info=$classinfo==$vo['id']?"selected":""; ?>
                           <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($class_info); ?>><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
        <!--学生类型：
                      <select class="select_2" name="isin_residence" style=" width: auto;>
                         <option value=''>-请选择-</option>
                         <option value='0'>否</option>
                         <option value='1'>是</option>
                         <?php if(is_array($class2)): foreach($class2 as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp; -->
                      考勤时段: 
                      <select class="attendance_time" name="attendance_time" style=" width: auto;">
                         <option value='0'>-请选择-</option>

                      <?php $type=$attendance_time=='1'?"selected":""; ?>
                         <option value='1' <?php echo ($type); ?>>-上午上学-</option>
                      
                        <?php $type=$attendance_time=='2'?"selected":""; ?>
                         <option value='2' <?php echo ($type); ?>>-上午放学-</option>
              
                      <?php $type=$attendance_time=='3'?"selected":""; ?>
                         <option value='3' <?php echo ($type); ?>>-下午上学-</option>

                        <?php $type=$attendance_time=='4'?"selected":""; ?>
                         <option value='4' <?php echo ($type); ?>>-下午放学-</option>
                         <?php $type=$attendance_time=='5'?"selected":""; ?>
                         <option value='5' <?php echo ($type); ?>>-晚上上学-</option>
                         <?php $type=$attendance_time=='6'?"selected":""; ?>
                         <option value='6' <?php echo ($type); ?>>-晚上放学-</option> 

                         <?php if(is_array($class3)): foreach($class3 as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                      
                      学生姓名： 
                      <!-- <div class="mr20" style="width: 100px"> -->
                          <input type="text" class="select_2" name="search" placeholder="-请输入姓名-" style="width: 100px; height: 29px; border-width: 1px;color: black;">
                      <!-- </div> -->&nbsp; &nbsp;&nbsp;

                        <span>
                      接收时间：
                      <input type="text" class="J_date date" name="begintime" placeholder="-选择时间-" style=" width: 150px; height: 29px; border-width: 1px;color: black;">  -  <input type="text" class="J_date date" name="endtime" placeholder="-选择时间-" style="width: 150px; height: 27px; border-width: 1px; color: black;"><br>

                      状态： 
                      <select class="select_2" name="school4" style=" width: auto;     margin-top: 6px;">
                         <option >&nbsp;--请选择--&nbsp;</option>
                         <option value= "0">异常</option>
                         <option value='1'>正常</option>
                         <option value='2'>迟到</option>
                         <option value='3'>早退</option>
                         <option value='4'>病假</option>
                         <option value='5'>事假</option>
                         <option value='6'>未打卡</option>
                        
                       
                      </select> &nbsp;&nbsp;

                   
					     </span>
                 <button type="submit" class="btn btn-default" style="border:none;;color:#FFF;  background-color:#26a69a; margin-right:3%; margin-top: 5px;"> 查 询 </button>
                      <button type="button" class="btn btn-default daochu" style="border:none;;color:#FFF;  background-color:#26a69a; margin-top: 5px;"> 导 出 </button>
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
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;"><input type="checkbox"> 全选</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">学生班级</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">学生姓名</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">是否住校</th>
                            <!--<th style=" text-align: center;border-left:none;border-width: 0.5px;">学籍号</th>-->
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">IC卡号</th>
                            <!--<th style=" text-align: center;border-left:none;border-width: 0.5px;">上午到校打卡时间</th>-->
                            <!--<th style=" text-align: center;border-left:none;border-width: 0.5px;">上午离校打卡时间</th>-->
                            <!--<th style=" text-align: center;border-left:none;border-width: 0.5px;">下午到校打卡时间</th>-->
                            <!--<th style=" text-align: center;border-left:none;border-width: 0.5px;">下午离校打卡时间</th>-->
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">考勤时段</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">考勤时间</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;">未打卡原因</th>
                            <th class="pai" style=" text-align: center;border-left:none;border-width: 0.5px;border-right: none;">操作</th>
                          </tr>
                        </thead>
                        <?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
                           <td style=" text-align: center;border-left: none;border-top: none;"><input type="checkbox" class="J_check" data-yid="J_check_y" data-xid="J_check_x" name="ids[]" value="<?php echo ($vo["id"]); ?>"    title="ID:<?php echo ($vo["id"]); ?>"></td>
                           <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["classname"]); ?></td>
                           <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["student_name"]); ?></td>
                           <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["in_residence"]); ?></td>
                           <!--<td style=" text-align: center;border-left: none;border-top: none;">学籍号</td>-->
                           <td style=" text-align: center;border-left: none;border-top: none;"><?php echo ($vo["cardno"]); ?></td>

                           <td style=" text-align: center;border-left: none;border-top: none;">
                              
                               <?php echo ($vo["attendantype"]); ?>

                           </td>
                           <td style=" text-align: center;border-left: none;border-top: none;">
                               <?php if($vo['cardno'] != null): echo (date("Y-m-d H:i:s",$vo["arrivetime"])); ?>
                              <?php else: endif; ?>                             
                           </td>
                             
                           <td style=" text-align: center;border-left: none;border-top: none;">
                           <?php if($vo['cardno'] == null ): ?>卡未发
                            <?php elseif($vo['cardno'] != null && $vo['arrivetime'] == null): ?>
                             <select  data-id="<?php echo ($vo["userid"]); ?>"  card = "<?php echo ($vo["cardno"]); ?>"  class-id="<?php echo ($vo["classid"]); ?>" class="cause" name="cause" style="width: 100px;">
                               <option value="0">请选择</option>
                               <option value="2">迟到</option>
                               <option value="3">早退</option>
                               <option value="4">病假</option>
                               <option value="5">事假</option>
                               <option value="6">未打卡</option>
                               <option value="7">其他</option>
                             </select>
                            
                             <?php else: ?>
                              <?php echo ($vo["statu"]); endif; ?>
                           </td>


                           <td style=" text-align: center;border-left: none;border-top: none;border-right: none;">
                             <a href="<?php echo U('Teacher/edit',array('id'=>$vo['id']));?>">查看视频/相片</a>&nbsp; &nbsp;
                             <a href="<?php echo U('Teacher/edit',array('id'=>$vo['id']));?>">查看历史</a>
                           </td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>

<script>
$('#myTab a:first').tab('show');
</script>
<script>

$('.daochu').click(function(){
  

 if (confirm("确定要导出吗？")){

                location.href="<?php echo U('class_info_exp');?>";
            
  }

});





$(".cause").change(function(){
  var id = $(this).attr('data-id');

  var classid = $(this).attr('class-id');

  var val =  $(this).val();

  var card = $(this).attr('card');
  
 var  type = $('body').find('.attendance_time').val();

 if(type==0)
 {
 	alert('请选择考勤时段!');
 	return false;
 }

  var cbj =  $(this).parent();
  var obj = $(this).parent().find(".cause");
  // console.log(obj);
  // obj.remove();
    if (confirm("确定要保存吗？")) {

        
          causeAjax(id,val,type,classid,card);
    }

});


    function causeAjax(id,val,type,classid,card)
              {
                $.ajax({
                    type:'get',
                    url: "<?php echo U('Teacher/ClassAttendance/cause');?>",
                    dataType:'json',
                    data: {
                        'id': id,
                        'val':val,
                        'type':type,
                        'classid':classid,
                        'card':card,
                        
                    },
                    success:function(data){
                         //console.log(data);
                        if(data.status){
                           alert('保存成功');
                           location.reload();
                        }else{
                            alert('保存失败');
                            location.reload();
                        }
                    },
                    //请求失败
                    error:function(){
                       alert('请求失败')
                    }
                })
              }










		$("#file-3").fileinput({
			showUpload: false,
			showCaption: false,
			browseClass: "btn btn-default",
			fileType: "any",
	        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
		});
	    $(document).ready(function() {
	        $("#test-upload").fileinput({
	            'showPreview' : false,
	            'allowedFileExtensions' : ['jpg', 'png','gif'],
	            'elErrorContainer': '#errorBlock'
	        });

	    });
		</script>
    <script>
   $(function () {
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
                  'showPreview' : false,
                  'allowedFileExtensions' : ['jpg', 'png','gif'],
                  'elErrorContainer': '#errorBlock'
              });

          });
            </script>
                        <script>
            $(".touch").mouseenter(
					function(){
						$(".touch").addClass("touchlei")
						}
			)
			 $(".touch").mouseleave(
					function(){
						$(".touch").removeClass("touchlei")
						}
			)
            </script>
</body>
</html>