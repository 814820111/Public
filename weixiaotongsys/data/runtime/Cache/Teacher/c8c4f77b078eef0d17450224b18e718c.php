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
<title></title>

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
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
.touchlei{ background-color:#eeeeee;}
/*.modal{    width: 100px;
     margin-left: 0px; 
    }*/
              .modal.fade.in {
      top: 0%;
          }
          div{
            color: black;
          }
    select{
        color: black;
    }
</style>
</head>
<body>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px;">
   		<li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f;text-decoration:none; padding:10px 15px;">老师排班设置</a></li>
      <!--<li><a href="<?php echo U('index_scheudle');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">班次管理</a></li>-->
   	</ul>


   	<div style=" margin-left:30px;margin-right: 30px;">
	   	 <!--<form class="" method="post" action="<?php echo U('TeacherScheduleSelect/index');?>" style="margin: 20px 0px 0px;">-->

	   	   <!--教师姓名：-->
	      <!--<input type="text" name="teacher_name" value="<?php echo ($teacher_name); ?>"  autocomplete="off"  placeholder="输入教师姓名" style=" height: 15px; border-width: 1px; width: 100px;" >&nbsp;&nbsp;-->

	      <!--教育证号：-->
	      <!--<input type="text" name="education_card" value="<?php echo ($education_card); ?>"  autocomplete="off"  placeholder="请输入..." style=" height: 15px; border-width: 1px; width: 100px">&nbsp;&nbsp;-->


	      <!--工号：-->
	      <!--<input type="text" name="work_card" value="<?php echo ($work_card); ?>"  autocomplete="off"  placeholder="请输入..." style=" height: 15px; border-width: 1px; width: 100px;">&nbsp;&nbsp;-->
		  <!---->

	      <!--<input type="submit" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;    margin-bottom: 10px;" value="搜索" />-->
	      <input  class="add_group" type="button" style=" background-color: #26a69a; padding: 5px 10px; border-radius: 3px; border: none; color: white;    margin-bottom: 10px;" value="创建考勤组" />
	    <!--</form>-->

	 <form  action="<?php echo U('TeacherScheduleSelect/set_');?>" method="get"  >
      <table class="table table-hover table-bordered table-list">
        <thead>
          <tr>

            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">名称</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">人数</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">类型</th>
            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none;">考勤时间</th>

            <th style=" text-align: center; background-color: #e2e2e2; border-width: 0.5px; border-left: none; border-right: none;">操作</th>
          </tr>
        </thead>
 
          
                  <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                      <div class="modal-dialog">
                        <div class="modal-content">
                          <div class="modal-header" style="background: white;    height: 50px; ">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h5 class="modal-title" id="myModalLabel" style="color: black; font-weight:bold;">老师考勤设置修改</h5>
                            <hr>
                          </div>
                         
                        <div class="modal-body2" style="    overflow-y: auto;"> 
                          <div>
      
                          <span class="tea_t" style="border:2px solid #01AAED;">某某某老师</span> <input class="teaid" type="hidden"  name="teacherid[]">
                           
                      <hr>
                  
                   
                            <div class="text-center" >
                           
                                   <span style="margin-left: 5px;"> 星期一:</span> <select  id="operationGrade" class="monday" name="monday">
                                                                
                                                                   <option>请选择</option>
                                                                     <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>
                                                                   </select>
                                                                   <br>


                                   <span style="margin-left: 5px;"> 星期二:</span> <select id="operationGrade" class="tuesday" name="tuesday">
                                                              
                                                                   <option>请选择</option>
                                                                   <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>
                                                                   </select>
                                                              <br>
                                 <span>星期三:</span> <select id="operationGrade" class="wednesday" name="friday">
                                                                        
                                                                         <option>请选择</option>
                                                                          <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>
                                                                    </select><br>
                                  <sapn>星期四:</sapn> <select id="operationGrade" class="thursday" name="wednesday">
                                                                        
                                                                         <option>请选择</option>
                                                                          <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>       
                        
                                                                    </select><br>
                                  <span>星期五:</span> <select id="operationGrade" class="friday" name="thursday">
                                                                       
                                                                         <option>请选择</option>
                                                                         <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>
                                                                  </select><br>
                                   <span>星期六:</span> <select id="operationGrade" class="saturday" name="sunday">
                                                                      
                                                                           <option>请选择</option>
                                                                           <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>
                                                                  </select><br>
                                   <span>星期日:</span> <select id="operationGrade" class="sunday" name="saturday">
                                                                       
                                                                           <option>请选择</option>
                                                                           <?php if(is_array($schedule)): foreach($schedule as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>"><?php echo ($vi["name"]); ?></option><?php endforeach; endif; ?>
                                                                     </select>
                                  </div>
                                添加教师:
                                <?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><span class="teacher" data-id="<?php echo ($vo["id"]); ?>" style="margin-right:5px; cursor: pointer"><?php echo ($vo["name"]); ?></span><?php endforeach; endif; ?>
                            </div>  
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default gb" data-dismiss="modal" style=" background: white; color:black; font-weight:bold;">关闭</button>
                            <button  class="btn btn-info tj" style="font-weight:bold;" >提交</button>
                          </div>
                      </form>
                        </div>
                      </div>
                    </div>      

        <?php if(is_array($posts)): foreach($posts as $key=>$vo): ?><tr>
        <!-- TITLE -->
          <td style="text-align: center;"><?php echo ($vo["name"]); ?></td>
          <td style=" text-align: center; "><?php echo ($vo["num"]); ?></td>
          <td style=" text-align: center; "><?php echo ($vo["type_name"]); ?></td>
          <td style=" text-align: center; ">
              <?php if(is_array($vo["att_time"])): foreach($vo["att_time"] as $key=>$time): ?><div style="    text-align: left;"><?php echo ($time); ?></div><?php endforeach; endif; ?>
          </td>


          <td style=" text-align: center;  border-right: none;">
              <?php if($vo['type'] == 1): ?><span style="color: grey">编辑排班</span>
                  <?php else: ?>
                 <a  href="<?php echo U('TeacherScheduleSelect/edit_scheduling',array('id'=>$vo['id']));?>"class="set" style="cursor: pointer; color: #00c1dd;"  >编辑排班</a><?php endif; ?>
              <a href="<?php echo U('TeacherScheduleSelect/edit_group',array('id'=>$vo['id']));?>" style="color: #00c1dd;">修改规则</a>
              <a  href="<?php echo U('TeacherScheduleSelect/group_del',array('id'=>$vo['id'],'type'=>$vo['type']));?>" class="J_ajax_del" style="color: #00c1dd;">删除</a>

          </td>

		</tr><?php endforeach; endif; ?>

      </table>
      <div class="pagination" style="height: 100%;"><?php echo ($Page); ?></div>
   

   	</div>


    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop_self.js"></script>

<!--
把 attr("checked",this.checked); 换成
prop("checked", $(this).prop("checked")); 
可以解决：全选只能执行一次的问题

注意：prop的第二个参数的写法与attr的不同

 -->
<script >
    //获取分辨率
     sum = screen.width+screen.height;

   if(sum<'2240')
   {
     $(".modal-body2").css("max-height",'220px');
   }


$('.gb').click(function(){
  
  console.log('dsadsa');
 $('.tea').remove();

})

$('.close').click(function(){
  

 $('.tea').remove();

})

 $(".add_group").click(function(){

     location.href="/weixiaotong2016/index.php?g=teacher&m=TeacherScheduleSelect&a=add_group"
 })




$(document).on('click', '.set', function() {
 
  var id = $(this).attr('data-id');
 
  var name = $(this).attr('data-na');

    $('.tea_t').text(name);
    $('.teaid').val(id);

  var monday = $(this).attr('data-m');
  console.log(monday);
  var tuesday = $(this).attr('data-t');
  console.log(tuesday);
  var wednesday = $(this).attr('data-w');
  console.log(wednesday);

  var thursday = $(this).attr('data-th');
  var friday = $(this).attr('data-f');
  var saturday = $(this).attr('data-sa');
  var sunday = $(this).attr('data-su');

  var mobj = $(".monday").get(0);


   for(var i = 0; i < mobj.options.length; i++){
                   var tmp = mobj.options[i].value;
                   console.log(tmp);
                if(tmp == monday){
                    mobj.options[i].selected = 'selected';
                    break;
                }else{
                  mobj.options[i].selected='';
                }
            }
    var tobj = $(".tuesday").get(0);

   for(var i = 0; i < tobj.options.length; i++){
                   var tmp = tobj.options[i].value;
                   console.log(tmp);
                if(tmp == tuesday){
                    tobj.options[i].selected = 'selected';
                    break;
                }else{
                  tobj.options[i].selected='';
                }
            }



     var wobj = $(".wednesday").get(0);
     console.log(wobj);

   for(var i = 0; i < wobj.options.length; i++){
                   var tmp = wobj.options[i].value;
                   console.log(tmp);
                if(tmp == wednesday){
                    wobj.options[i].selected = 'selected';
                    break;
                }else{
                   wobj.options[i].selected='';
                }
            }


     var thobj = $(".thursday").get(0);

   for(var i = 0; i < thobj.options.length; i++){
                   var tmp = thobj.options[i].value;
                   //console.log(tmp);
                if(tmp == thursday){
                    thobj.options[i].selected = 'selected';
                    break;
                }else{
                   thobj.options[i].selected='';
                }
            }
      
    var fobj = $(".friday").get(0);

   for(var i = 0; i < fobj.options.length; i++){
                   var tmp = fobj.options[i].value;
                   //console.log(tmp);
                if(tmp == friday){
                    fobj.options[i].selected = 'selected';
                    break;
                }else{
                   fobj.options[i].selected='';
                }
            }        

  var saobj = $(".saturday").get(0);

   for(var i = 0; i < saobj.options.length; i++){
                   var tmp = saobj.options[i].value;
                   //console.log(tmp);
                if(tmp == saturday){
                    saobj.options[i].selected = 'selected';
                    break;
                }else{
                   saobj.options[i].selected='';
                }
            }

var suobj = $(".sunday").get(0);

   for(var i = 0; i < suobj.options.length; i++){
                   var tmp = suobj.options[i].value;
                   //console.log(tmp);
                if(tmp == sunday){
                    suobj.options[i].selected = 'selected';
                    break;
                }else{
                   suobj.options[i].selected='';
                }
            }   


})

     


  $('.teacher').click(function(){
   var na = $(this).parent().find('.tea').text();


   var name = $(this).text();
  
   var id = $(this).attr('data-id');
   var obj = $(this).parent();
   //console.log(obj)
   //去检索 如果存在则跳出
    var indesr = na.indexOf(name);
   
   // $(".dianji", this).parent().remove();
    // console.log(indesr);
   if(indesr < 0 ){
    obj.prepend('<span class="tea" style="border:2px solid #01AAED; margin-right:5px;"><input type="hidden" name="teacherid[]" value='+id+'>'+name+' <i class="fa fa-remove dianji" style="color: #00B7EE;position: relative;bottom: 3px; cursor: pointer;"></i></span>');
   
   }else{
    alert('老师已经存在!');
    return;
   }

    
   // console.log(name);


    })

$(document).on('click', '.dianji', function() {

        $(this).parent().remove();
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
</script>



   	<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="js/fileinput.js" type="text/javascript"></script>
	<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/common.js"></script>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="js/fileinput.js" type="text/javascript"></script>
	<script src="js/fileinput_locale_zh.js" type="text/javascript"></script>
	<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
	<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
	<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
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