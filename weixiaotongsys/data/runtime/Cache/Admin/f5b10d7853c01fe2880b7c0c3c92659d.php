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
.chzn-container-single .chzn-single {
  position: relative;
  top: 12px;
  height: 29px; 
}

table td{
  color: black;
}
.line-limit-length {
    max-width:90px;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.chzn-container-single .chzn-single {
    position: relative;
    top: 12px;
    height: 29px;
}
</style>
<body class="J_scroll_fixed">

<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="<?php echo U('index');?>">学校列表</a></li>
        <li><a href="<?php echo U('addschool');?>">新增学校</a></li>
        <li><a href="<?php echo U('schoolcheck');?>">学校审核</a></li>
    </ul>
    <div class="well form-search">
        省份选择：

        <select  class="province" id="province" style="width: auto;">
           
            <option value="">省级选择</option>
            <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?> 
                <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
        </select>
        市级选择：
       <input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
        <select name="" class="citys"  id="citys" style="width: auto;">

            <option value="">市级选择</option>
        </select>

        县级选择:&nbsp;
        <input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>" >
        <select name="city_next" class="select_3" id="message_type"  style="width: auto;">
            <option value="">请选择区域</option>

        </select>
        学校名称：
        <select data-placeholder="输入关键字。。。" id="viewOLanguage" class="chzn-select"  tabindex="2" name="school_id">
            <option value=""></option>
        </select>
        <input type="hidden" class="type_school" value="<?php echo ($schoolid); ?>">
        <div style="position: relative;top: 10px;left: 8px;" >

            年级段：&nbsp;
            <select class="classname" style="width: auto;">
                <option value="">选择年级段</option>
                <?php if(is_array($class)): foreach($class as $key=>$vo): $grade=$grade_type==$vo['id']?"selected":""; ?> 
                    <option value="<?php echo ($vo["id"]); ?>" <?php echo ($grade); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
            </select>

            使用状态：
            <select name="" class="school_status" style="width: auto;">
                <option value='3' <?php if($school_status==3) echo("selected");?>>学校使用状态</option>
                <option value="0"  <?php if($school_status==0) echo("selected");?>>停用</option>
                <option value="1" <?php if($school_status==1) echo("selected");?>>试用期</option>
                <option value="2" <?php if($school_status==2) echo("selected");?>>收费期</option>
            </select>
  <!--              <select name="" class="school_status" >
                <option value='' <?php if($status=='') echo("selected");?>>学校使用状态</option>
                <option value="0" <?php if($status==0) echo("selected");?>>停用</option>
                <option value="1" <?php if($status==1) echo("selected");?>>试用期</option>
                <option value="2" <?php if($status==2) echo("selected");?>>收费期</option>
            </select> -->
           <span style=" margin-left: 210px;">
            <input type="submit" class="btn btn-primary ss" value="搜索" />&nbsp;&nbsp;
            <input type="submit" class="btn btn-primary" value="导出" />&nbsp;&nbsp;
            <a class="btn btn-danger" href="<?php echo U('SchoolManage/index');?>">清空</a>
            </span>
        </div>
    </div>



</div>
</div>


<table class="table table-hover table-bordered">
    <thead>
    <tr>
        <th width="50">学校ID</th>
        <th>学校的区域</th>
        <th>学校名称</th>
        <th>学校的类型</th>
        <th>学校地址</th>
        <th>联系人</th>
        <th>联系电话</th>
        <th>负责代理商</th>
        <th>创建时间</th>
        <th>状态</th>
        <th width="120">管理操作</th>
    </tr>
    </thead>
    <tbody>
    <?php $school_statuses=array("0"=>"停用","1"=>"试用期","2"=>"收费期"); ?>
    <?php if(is_array($school)): foreach($school as $key=>$vo): ?><tr>
            <td><?php echo ($vo["schoolid"]); ?></td>
            <td><?php echo ($vo["agent_name"]); ?></td>
            <td><?php echo ($vo["school_name"]); ?></td>
            <td><?php echo ($vo["class_name"]); ?></td>
            <td><p class="line-limit-length" data-toggle="tooltip" data-placement="right" title="<?php echo ($vo["school_address"]); ?>"><?php echo ($vo["school_address"]); ?><p/></td>

            <td><?php echo ($vo["school_user"]); ?></td>
            <td><?php echo ($vo["school_phone"]); ?></td>
            <td><?php echo ($vo["name"]); ?></td>
            <td><?php echo date('Y-m-d H:i:s',$vo['create_time']); ?></td>
            <td><?php echo ($school_statuses[$vo['school_status']]); ?></td>
            <td style="width: 137px;">
                <a href='<?php echo U("change",array("schoolid"=>$vo["schoolid"]));?>'>修改资料</a> |
                <!--<a class="J_ajax_del" href="<?php echo U('user/delete',array('id'=>$vo['id']));?>">删除</a> |-->
                <?php if($vo['school_status'] == 0): ?><a href="<?php echo U('run',array('schoolid'=>$vo['schoolid']));?>" class="J_ajax_dialog_btn" data-msg="您确定要启用此学校吗？">启用</a>
                    <?php elseif($vo['school_status'] == 1): ?>
                    <a href="<?php echo U('pay',array('schoolid'=>$vo['schoolid']));?>">充值</a>
                    <?php else: ?>
                    <a href="<?php echo U('stop',array('schoolid'=>$vo['schoolid']));?>" class="J_ajax_dialog_btn" data-msg="您确定要停用此学校吗？">停用</a><?php endif; ?>
                <br /> <a href="<?php echo U('classmanage',array('schoolid'=>$vo['schoolid'],'schoolname'=>$vo['school_name']));?>">班级管理</a>
                     <a href="<?php echo U('grademanage',array('schoolid'=>$vo['schoolid'],'schoolname'=>$vo['school_name']));?>">年级管理</a><br/>
                   <a href="<?php echo U('departmentmanage',array('schoolid'=>$vo['schoolid'],'schoolname'=>$vo['school_name']));?>">分组管理</a>

                 <a href="<?php echo U('schoolsubject',array('schoolid'=>$vo['schoolid'],'schoolname'=>$vo['school_name']));?>">科目管理</a><br>
                <a href="<?php echo U('switch_index',array('schoolid'=>$vo['schoolid'],'schoolname'=>$vo['school_name']));?>">开关设置</a>
               

            </td>
        </tr><?php endforeach; endif; ?>
    </tbody>
</table>

<div class="pagination"><?php echo ($page); ?></div>
</div>

<script src="/weixiaotong2016/statics/js/common.js"></script>
<script src="/weixiaotong2016/statics/chosen/chosen.jquery.js"></script>


<script>



$(".agtj").click(function(){
  
  alert($("#agent").text());

})


$(".transfer").click(function(){
	  var school = $(this).parent().parent().find("td:eq(1)").text();
	  $(".school_name").val(school);
	  var schoolid = $(this).parent().parent().find("td:eq(0)").text();
	  $(".ag_schoolid").val(schoolid);
      var agent = $(this).attr("data-ag");
	  $("#agent").find("option[value = '"+agent+"']").attr("selected","selected");
	  $("#myModal5").modal("show");
})

    $(".btn-primary").click(function(){




        var type = $(".select_3  option:selected").val();
        var schooiid=$(".chzn-select  option:selected").val();
        var classname=$(".classname option:selected").val();
        var school_status=$(".school_status option:selected").val();


        location.href="<?php echo U('SchoolManage/index');?>?type="+type+"&schooiid="+schooiid+"&classname="+classname+"&school_status="+school_status+"&province="+$("#province option:selected").val()+"&citys="+$("#citys option:selected").val()+"&school_id="+$('body').find("select[name='school_id']").val()+"";     	

    })




if($("#province").val())
{

  // console.log($("#province").val());

 var new_citys = $('body').find(".new_citys").val();


 var new_message_type = $('body').find('.new_message_type').val();

 


 var type_school = $('body').find(".type_school").val();


    if(new_citys)
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
                                $("#viewOLanguage").append("<option value="+schoolid+" selected>"+school_name+"</option>");
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











          $(function() {
              $("#province").change(function() {
              
                 $("#citys").empty();
                 $("#message_type").empty();
                 // $("#student").empty();
                  $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                  
                      if(data.status=="success"){
                      
                          $("#citys").append("<option value=0>"+"请选择市级"+"</option>");
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
        $("#message_type").append("<option value=>"+"选择区域"+"</option>");
//        $("#grade").empty();
//        $("#classs").empty();
//        $("#classs").append("<option value=>"+"选择班级"+"</option>");
//        $("#grade").append("<option value=0>"+"选择年级"+"</option>");
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

          //      $(function() {
          //     $("#message_type").change(function() {
               
          //        // $("#student").empty();
          //         $.getJSON("/weixiaotong2016/index.php?g=Admin&m=SchoolManage&a=lookup&type="+$("#message_type").val(),{},function(data){
          //           console.log(data);
          //             if(data.status=="success"){
                      
          //                 $("#message_type").append("<option value=0>"+"请选择区域"+"</option>");
          //                 for(var key in data.data){
          //                     $("#message_type").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
          //                 }
          //             }
          //             if(data.status=="error"){
          //                 $("#message_type").append("<option value='0'>没有市级</option>");
          //             }
          //         });
          //     });
          // });
  




    //选择市级的下拉的ajax

    // $(".citys").click(function(){
    //     $(".jiu").hide();
    //     var Province =$(".province option:selected").val();
    //     console.log(Province);
    //     if(Province==""){
    //         alert("请选择你要搜索的省")
    //     }else{
    //         $.ajax({
    //             type:"post",
    //             url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=Provinces',
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


    
    //选择市级的下拉的ajax
//    $(".citys").click(function(){
//        $(".jiu").hide();
//        var Province =$(".province option:selected").val();
//        if(Province==""){
//            alert("请选择你要搜索的省")
//        }else{
//            $.ajax({
//                type:"post",
//                url: '/weixiaotong2016/index.php/?g=Admin&m=SchoolManage&a=Provinces',
//                async:true,
//                data:{
//                    Province:Province
//                },
//                dataType: 'json',
//                success: function(res) {
//                    var html = "";
//                    res = eval(res.data);
//                    for(var i = 0; i < res.length; i++) {
//                        var name=res[i].name;//地区的名字；
//                        var term_id=res[i].term_id;//地区的ID
//                        html+='<option class="jiu"value="'+term_id+'">'+name+' </option> '
//                    }
//                    $(".citys").append(html);
//                },
//                error: function() {
//                    console.log('系统错误,请稍后重试');
//                }
//            });
//        }
//
//    })



    $("#viewOLanguage").chosen();
    $("#viewOLanguage").trigger("liszt:updated");

    $(".select_3").change(function(){
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
            type:"post",
            url: '/weixiaotong2016/index.php/?g=Admin&m=AdminUtils&a=lookup',
            async:true,
            data:{
                type:type
            },
            dataType: 'json',
            success: function(res) {
                $(".Sio").text("")
                var html = "";
                res = eval(res.data);
                for(var i = 0; i < res.length; i++) {
                    var school_name=res[i].school_name;//学校的名字
                    var schoolid=res[i].schoolid;//学校的ID
                    html+='<option class="Sio" value="'+schoolid+'">'+school_name+' </option> '
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
</script>
</body>
</html>