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
<title>信息1</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
<link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
<script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden; margin-left: 6px; }
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
.touchlei{ background-color:#eeeeee;}
tr .pai,tr .pai2{ text-align:center;}
tr .pai{ background-color:#e2e2e2;}
tr .pai2{ background-color:white;}
.clearfix{ clear:both;}
.name{ margin-right:10px;}
#name01{ border:1px solid #dddddd; height:280px; overflow-y:scroll; background-color:#f5f5f5;}
#name01 input{display: none;}
#name01 div{ border: 1px solid #dddddd; border-left:none; border-right: none; line-height:30px; cursor:pointer;}
#name02{ line-height:30px; cursor:pointer; border:1px solid #dddddd; height:280px; overflow-y:scroll; background-color:#f5f5f5;}
#name02 input{display: none;}
#name02 div{ border: 1px solid #dddddd; border-left:none; border-right: none;line-height:30px; cursor:pointer;}
.oplei{ background-color:#929191;}
.btnlei{ background-color:#C9BFBF;}
.btn01{ padding:0px 20px; text-align:center; line-height:25px; border:1px solid #bbbbbb; width:80px; margin-left:auto; margin-right:auto; border-radius:5px; cursor:pointer; margin-top:65px;}
.btn02{ padding:0px 20px; text-align:center; line-height:25px; border:1px solid #bbbbbb; width:80px; margin-left:auto; margin-right:auto; border-radius:5px; cursor:pointer; margin-top:5px;}
.btn03{ padding:0px 20px; text-align:center; line-height:25px; border:1px solid #bbbbbb; width:80px; margin-left:auto; margin-right:auto; border-radius:5px; cursor:pointer; margin-top:55px;}
.btn04{ padding:0px 20px; text-align:center; line-height:25px; border:1px solid #bbbbbb; width:80px; margin-left:auto; margin-right:auto; border-radius:5px; cursor:pointer; margin-top:5px;}
</style>

</head>
<body>
<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
   		<li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">兴趣班列表</a></li>
      <li><a href="<?php echo U('add');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">新增兴趣班</a></li>
   	</ul>
         <!--弹出框 start--> 
 <div style="position: absolute; background-color:rgba(0,0,0,0.7); width: 100%; height: 100%;display: none;" class="tan_box"> 
     <form> 
         <div style=" background-color:white; padding: 20px 30px;width: 80%; margin-left: auto; margin-right: auto; margin-top: 100px;"> 
          
              <div style="color:#61c881;">兴趣班设置</div>
                <div style=" padding:20px; width: 680px; margin-left: auto; margin-right: auto;">
                  <div style=" float:left; border:1px solid #dddddd; width:250px; text-align:center;">
                      <div style=" background-color:#e2e2e2;  padding-top:5px; padding-bottom:5px;">
                              <span>兴趣班级：</span>
                              <select id="class_first" name="class_first" style=" width:100px; border-radius:0; height:25px; padding:2px; color:#607d8b;">
                                  <option value="0">-请选择-</option>
                                  <?php if(is_array($class_list)): foreach($class_list as $key=>$to): ?><OPTION value="<?php echo ($to["id"]); ?>"><?php echo ($to["classname"]); ?></OPTION><?php endforeach; endif; ?>
                              </select>
                        </div>
                       
                            <div id="name01"></div>
                        
                    
                    </div>
                    <div style=" float:left; width:140px;" class="btn_box">
                          <div class="btn01">>></div>
                            <div class="btn02"><<</div>
                            <div class="btn03">>></div>
                            <div class="btn04"><<</div>
                            <div class="remind"></div>
                    </div>
                        
                    <div style=" float:left; border:1px solid #dddddd; width:250px; text-align:center;">
                      <div style=" background-color:#e2e2e2;  padding-top:5px; padding-bottom:5px;">
                              全部班级：
                              	<select id="class_second" name="class_second" style=" width:100px; border-radius:0; height:25px; padding:2px; color:#607d8b;">
                                  <option value="0">-请选择-</option>
                                  <?php if(is_array($class_all)): foreach($class_all as $key=>$to): ?><OPTION value="<?php echo ($to["id"]); ?>" ><?php echo ($to["classname"]); ?></OPTION><?php endforeach; endif; ?>
                              </select>
                        </div>
                            <div id="name02"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            
                <div style=" width:160px; margin-left:auto; margin-right:auto;">
                     <input type="hidden" id="oid" name="oid" value="1417"> 
                     <input type="button" class="qrcj" onclick="excuse()" value="确认" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;">
                     <input type="button" value="取消" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px; margin-left: 30px;" class="back">
                </div>  
         </div> 
     </form> 
 </div> 
 
 <!--弹出框 end-->
   	<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
		<div class="tab-pane fade in active" id="home">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('index');?>" method="post" style="margin: 0px 0px 5px;">
          <div class="search_type cc mb10">
              <div class="mb10">
                  <span class="mr20">
                      <div id="b_begintime1417" style="display:none;">2016/10/24</div>
                      <input type="button" class="add_class" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;" value="兴趣班设置" />
                  </span>
              </div>
          </div>
			</form>
      <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                      <table class="table table-hover table-bordered table-list">
                        <thead>
                          <tr style="background-color:#CCC;">
                            <th class="pai">兴趣班名称</th>
                            <th class="pai">是否毕业</th>
                            <th class="pai">班主任</th>
                            <th class="pai">注册时间</th>
                            <th class="pai">实际人数</th>
                            <th class="pai">操作</th>
                          </tr>
                        </thead>
                        <?php if(is_array($class_list)): foreach($class_list as $key=>$vo): $type=array("1"=>"正规班","2"=>"兴趣班"); $status=array("1"=>"是","0"=>"否"); $sign=empty($vo['captain'])?'-未设置-':$vo['captain']; ?>
                        <tr class="zufu" style="background-color: white;">
                           <input type="hidden" class="chuanzhi" id="c_id" name="c_id" value="<?php echo ($vo["id"]); ?>">
                           <td class="pai2"><?php echo ($vo["classname"]); ?></td>
                           <td class="pai2"><?php echo ($status[$vo['status']]); ?></td>
                           <td class="pai2" style="width: 300px;">
                              <select id="school" name="main_teacher"  class="normal_select" style="max-height: 50px;width: 200px; ">
                                <OPTION value="0">未设置</OPTION>
                                <?php if(is_array($teachers)): foreach($teachers as $key=>$to): $main=$vo['captain']==$to['id']?"selected":""; ?>
                                  <OPTION value="<?php echo ($to["id"]); ?>" <?php echo ($main); ?>><?php echo ($to["name"]); ?></OPTION><?php endforeach; endif; ?>           
                              </select>
                              <input type="submit" value="保存" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" class="xxx">
                           </td>
                           <td class="pai2" style="width: 300px;"  ><?php echo (date("Y-m-d H:i",$vo["create_time"])); ?></td>
                           <td class="pai2"><?php echo ($vo["stu_count"]); ?></td>
                           <td class="pai2">
                             <a href="<?php echo U('delete',array('id'=>$vo['id']));?>"  class="J_ajax_del" style=" color:#00c1dd;">
                             <?php if($vo['stu_count'] != 0): elseif($vo['stu_count'] == 0): ?> 
                             删除<?php endif; ?>
                             </a>
                             <a href="<?php echo U('edit',array('id'=>$vo['id']));?>" style=" color:#00c1dd;">修改</a>
                           </td>
                        </tr><?php endforeach; endif; ?>
                    </table>
                    <div class="pagination"><?php echo ($Page); ?></div>
                  </div>
                </form>
        </div>
        </div>
	<div class="tab-pane fade" id="ios">
	</div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script>
  $(".back").click(
      function(){
        $(".tan_box").hide()
      }
    )
$(".add_class").click(
      function(){
        $(".tan_box").show()
      }
    )
</script>
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/",
    JS_ROOT: "statics/js/",
    TOKEN: ""
};
</script>
<script>
$(".xxx").click(
  function set_teacher() {
    var c_id = $(this).parent().siblings(".chuanzhi").val();
    var teachers = $(this).siblings(".normal_select").val(); 
    $.ajax({
      type:"post",
      async:false,
      url:"<?php echo U('Teacher/PlayGroup/teachers');?>",
      data:{'teachers': teachers,'c_id':c_id},
      success: function(msg){
        history.go(0);
      }
    });
  }
  )

</script>
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
 <script>
 $(".guan").click(
 			function(){
				$(".bantan").hide()
				}
 
 )
 </script>
  </script> 
    <!--选择班级  -->
  <script>
  $(function(){
    $("#class_first").change(function(){
      $.getJSON("/weixiaotong2016/index.php?g=teacher&m=PlayGroup&a=get_student&classid="+$("#class_first").val(),{},function(data){
        $("#name01").empty()
        console.log(data);
        if(data.status=="success"){
          // console.log(data.status);
          for(var key in data.data){
            $("#name01").append("<div><input name=first value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</div>");
          }
        }
      });
    });
  });

  </script>
  <script>
  $(function(){
    $("#class_second").change(function(){
      $.getJSON("/weixiaotong2016/index.php?g=teacher&m=PlayGroup&a=get_student&classid="+$("#class_second").val(),{},function(data){
        $("#name02").empty()
        if(data.status=="success"){
          for(var key in data.data){
            $("#name02").append("<div><input name=second value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</div>");
          }
        }
      });
    });
  });

  </script>
  <script>
    $("#name01 div").live("click",
      function(){
        $(this).addClass("oplei").siblings().removeClass("oplei")
		k=$(this).index()
		w=$(this).children().val()
		p=$(this).text()
		
      }
      )
	 $("#name02 div").live("click",
      function(){
        $(this).addClass("oplei").siblings().removeClass("oplei")
		k2=$(this).index()
		w2=$(this).children().val()
		p2=$(this).text()
      }
      )
  </script>
  <script>
	$(".btn_box div").mousedown(
		function(){
			$(this).addClass("btnlei")
			}
	)
	$(".btn_box div").mouseup(
		function(){
			$(this).removeClass("btnlei")
			}
	)
  </script>
  <script>
  $(".btn01").click(
  	function(){
      $(".remind").empty();

      if($("#class_second").val()==0)
        {
          alert('班级不能为空!');
          return false
        }
			if(k>=0){
        example=0;
        var obj = document.getElementsByName("second");


        for(i=0;i<obj.length;i++){
          if(obj[i].value==w){
            $(".remind").append("<span style=color:red>*已存在</span>");
            example=1;
          }
        }
        if(example==0){
          $("#name01 div").eq(k).empty()
          $("#name01 div").eq(k).css("border","none")
          $("#name02").append("<div><input name=second value="+w+">"+p+"</div>")
          k=-1
        }
			}
		}
  )
  $(".btn02").click(
  	function(){
      $(".remind").empty();

       if($("#class_first").val()==0)
        {
          alert('班级不能为空!');
          return false
        }


			if(k2>=0){
        example_else=0;
        var obj = document.getElementsByName("first");
        for(i=0;i<obj.length;i++){
          if(obj[i].value==w2){
            $(".remind").append("<span style=color:red>*已存在</span>");
            example_else=1;
          }
        }
        if(example_else==0){
          $("#name02 div").eq(k2).empty()
          $("#name02 div").eq(k2).css("border","none")
          $("#name01").append("<div><input name=first value="+w2+">"+p2+"</div>")
          k2=-1
        }				
			}
		}
  )
  </script>
  <script>
    function excuse(){
      var class_first=$("#class_first").val();
      var obj = document.getElementsByName("first");
      check_first = [];
      for(i=0;i<obj.length;i++){
          check_first.push(obj[i].value);
      }
      var class_second=$("#class_second").val();
      var obj_else = document.getElementsByName("second");
      check_second = [];
      for(i=0;i<obj_else.length;i++){
          check_second.push(obj_else[i].value);
      }
      $.ajax({
        type:"post",
        async:false,
        url:"<?php echo U('Teacher/PlayGroup/student_change');?>",
        data:{'class_first': class_first,'check_first':check_first,'class_second':class_second,'check_second':check_second},
        success: function(msg){
          history.go(0);
        }
      });
    }
  </script>
</body>
</html>