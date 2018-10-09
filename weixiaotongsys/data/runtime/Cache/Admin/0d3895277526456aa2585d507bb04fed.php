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
<style>
    .wraps {
        width: 250px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
    }
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

<body class="J_scroll_fixed">
    <div class="wrap J_check_wrap">
        <ul class="nav nav-tabs">
            <li><a href="<?php echo U('index');?>">学校列表</a></li>
            <li><a href='<?php echo U("classmanage",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>班级管理</a></li>
            <li class="active"><a href='<?php echo U("interestclass",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>兴趣班管理</a></li>
            <li><a href='<?php echo U("addclass",array("schoolid"=>$schoolid,"schoolname"=>$schoolname));?>'>添加班级</a></li>
        </ul>
        <p>学校：<?php echo ($schoolname); ?></p>
           <input type="button" class="btn btn-primary add_class" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; margin-bottom: 10px;" value="兴趣班设置" />



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
   
      







        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th width="50">班级ID</th>
                    <th>兴趣班名称</th>
                    <th>是否毕业</th>
                    <th>班主任</th>
                    <th>注册时间</th>
                    <th>实际人数</th>
                    <th width="120">管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($class_list)): foreach($class_list as $key=>$vo): ?><tr>
                        <td><?php echo ($vo["id"]); ?></td>
                        <td><?php echo ($vo["classname"]); ?></td>

                        <td>
                            <?php if(is_array($vo['admininfo'])): foreach($vo['admininfo'] as $key=>$le): ?><ul>
                                    <?php echo ($le["name"]); ?>
                                </ul><?php endforeach; endif; ?>
                        </td>
                        <td>

                            <select id="school" name="main_teacher" class="normal_select" style="max-height: 50px;width: 200px; ">
                                <OPTION value="0">未设置</OPTION>
                                <?php if(is_array($teachers)): foreach($teachers as $key=>$to): $main=$vo['captain']==$to['id']?"selected":""; ?>
                                  <OPTION value="<?php echo ($to["id"]); ?>" <?php echo ($main); ?>><?php echo ($to["name"]); ?></OPTION><?php endforeach; endif; ?>           
                              </select>
                            <input type="submit" value="保存" data-school="<?php echo ($schoolid); ?>" style=" border:none; background-color:#0080FF; color:white; border-radius:3px; padding:5px 15px 5px 15px;     margin-top: -9px;" class="xxx">

                        </td>
                        <td>
                            <?php echo date('Y-m-d',$vo['create_time']); ?>
                        </td>
                        <td>

                            <?php echo ($vo["stu_count"]); ?></php>
                        </td>
                        <td>
                            <a href='<?php echo U("interestchange",array("id"=>$vo["id"],"schoolid"=>$schoolid));?>'>修改</a> |
                            <a class="J_ajax_del" href="<?php echo U('interestdelete',array('id'=>$vo['id']));?>">删除</a>
                        </td>
                    </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
        <div class="pagination"><?php echo ($page); ?></div>
    </div>


    <script src="/weixiaotong2016/statics/js/common.js"></script>
    <script>
    $(".add_class").click(
      function(){
        $(".tan_box").show()
      }
    )
  $(".back").click(
      function(){
        $(".tan_box").hide()
      }
    )

  $(function(){
    $("#class_first").change(function(){
        console.log($("#class_first").val());
      $.getJSON("/weixiaotong2016/index.php?g=admin&m=SchoolManage&a=get_student&classid="+$("#class_first").val(),{},function(data){
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

  $(function(){
    $("#class_second").change(function(){
      $.getJSON("/weixiaotong2016/index.php?g=admin&m=SchoolManage&a=get_student&classid="+$("#class_second").val(),{},function(data){
        $("#name02").empty()
        if(data.status=="success"){
          for(var key in data.data){
            $("#name02").append("<div><input name=second value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</div>");
          }
        }
      });
    });
  });

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



    $(".btn01").click(
    function(){

      if($("#class_second").val()==0)
        {
          alert('班级不能为空!');
          return false
        }

      $(".remind").empty();
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
      if($("#class_first").val()==0)
        {
          alert('班级不能为空!');
          return false
        }


      $(".remind").empty();
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
    //end


        $(function() {
            $("[data-toggle='tooltip']").tooltip();
        });
        $(".xxx").click(
            function set_teacher() {
                var c_id = $(this).parent().siblings("td:eq(0)").text();

                var schoolid = $(this).attr("data-school");


                var teachers = $(this).siblings(".normal_select").val();
                $.ajax({
                    type: "post",
                    async: false,
                    url: "<?php echo U('Teacher/PlayGroup/teachers');?>",
                    data: {
                        'teachers': teachers,
                        'c_id': c_id,
                        'schoolid': schoolid,
                    },
                    success: function(msg) {
                        history.go(0);
                    }
                });
            }
        )
    </script>
</body>

</html>