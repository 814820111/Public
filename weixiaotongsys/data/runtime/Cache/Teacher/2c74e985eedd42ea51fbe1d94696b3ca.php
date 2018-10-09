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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>信息</title>
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
.kong{ margin-bottom:20px;}
.clearfix{ clear:both;}
.btn2{ float:left; border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;}
  select{
        color: black;
      }

      div{
        color: black;
      }
      p{
        color: black;
      }
</style>

</head>
<body>
<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
   		<li><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">考试管理</a></li>
         <li class="active" ><a href="" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;"style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">录入发送</a></li>
   	</ul>
   	<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
		<div class="tab-pane fade in active" id="home" style="margin-bottom: 50px;">
        	<br/>
			<form class="form-horizontal J_ajaxForm" action="<?php echo u('score_post');?>" method="post" name="myform">

                  <div class="kong">
                        <div style=" width:80px; float:left; text-align:right;">班级：</div>
                      <select class="select_2" name="class" id="class" style=" margin-left:14px; float:left;">
                        <option value='0'>--请选择班级--</option>
                        <?php if(is_array($class)): foreach($class as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> 
                      <div class="clearfix"></div>
                  </div>
                <div class="kong">
                    <div style=" width:80px; float:left; text-align:right;">考试：</div>
                    <select class="select_2" name="exam" id="exam" style=" margin-left:14px; float:left;">
                        <!--<option value='0'>&#45;&#45;请选择考试&#45;&#45;</option>-->
                        <!--<?php if(is_array($exam)): foreach($exam as $key=>$vo): ?>-->
                            <!--<OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></OPTION>-->
                        <!--<?php endforeach; endif; ?>-->
                    </select>
                    <!--<button  style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">-->
                        <!--<a href="<?php echo U('expUser');?>" style="color:white" target="_blank">下载模板</a>-->
                    <!--</button>-->
                    <span style="margin-left: 20px;"><a href="<?php echo U('add');?>">没有考试?去设置</a></span>
                    <div class="clearfix"></div>
                </div>
                <div class="kong1">

                </div>
                <div class="kong">
                    <div style="width: 600px;margin-left:100px;">根据班级学生名单按秩序在excel表格中录入相应的科目成绩（如下图所示），录入完成后右键鼠标选择复制或全选按ctrl+c，然后回到本页面点击‘粘帖成绩”按钮，此时系统会根据您在excel表格中录入的学生成绩自动匹配到相应的学生名录下。</div>
                    <div style="margin-left:100px;margin-top: 10px;"><img src="/weixiaotong2016/statics/images/cj2.png" alt=""></div>
                </div>
                <!--<div class="kong">-->

                        <!--<button  style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">-->
                            <!--<a href="<?php echo U('downfile');?>" target="_blank">下载模板</a>-->
                        <!--</button>-->

                <!--</div>-->
                <div class="kong">
                    <div style=" width:80px; float:left; text-align:right;">成绩录入：</div>
                    <!--<textarea  id="content" name="content" placeholder="请您直接选中编辑框" style="margin-left:14px; float:left;width:50%;height:200px;" rows="" cols="">-->
                    <!--</textarea>-->
                    <textarea ng-model="score.val" id="content" name="content" placeholder="请您直接选中编辑框，手动“粘贴”(Ctrl + V)成绩记录到编辑框中，再进行点击“下一步”" style="width:50%;margin-left:14px;" cols="200" rows="10" class="ng-valid ng-dirty"></textarea>
                    <div class="clearfix"></div>
                </div>
                <input type="hidden" id="classid">
                <input type="hidden" id="examid">
                <div style="margin-top:50px;">
                  		<!--<input type=button name="submit1" value="发布" onclick="check(this.form)" style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">-->
                  		<!--<input type="submit" name="submit" onclick="replace()" value="下一步" style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">-->
                  		<!--<input type="submit" name="submit" onclick="replace()" value="下一步" style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">-->
                       <button id="submit"  style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">下一步</button>
                        <div class="clearfix"></div>
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
    var submitBtn = document.getElementById("submit");

    submitBtn.onclick = function (event) {
        //alert("preventDefault!");
        var strContent = document.getElementById("content").value;
//         alert("处理前的strContent为\r\n"+strContent);
         strContent = strContent.replace(/\r\n/g, '<br/>'); //IE9、FF、chrome
         strContent = strContent.replace(/\n/g, '<br/>'); //IE7-8
         strContent = strContent.replace(/\s/g, ' '); //空格处理
//         alert("转换之后的html代码为\r\n"+strContent);
        document.getElementById("content").value = strContent;
        return true;
    };

    function  replace(){

         alert("1111");
         //return false;
//         var strContent = document.getElementById("content").value;
//        // alert("处理前的strContent为\r\n"+strContent);
//         strContent = strContent.replace(/\r\n/g, '<br/>'); //IE9、FF、chrome
//         strContent = strContent.replace(/\n/g, '<br/>'); //IE7-8
//         strContent = strContent.replace(/\s/g, ' '); //空格处理
//         alert("转换之后的html代码为\r\n"+strContent);
         //document.getElementById("show").innerHTML = strContent
     }
    $("#class").change(function() {
        var classid = $("#class option:selected").val();
        $.ajax({
            type: "post",
            url: "<?php echo U('class_exam');?>",
            async: true,
            data: {
                classid: classid

            },
            dataType: 'json',
            success : function(res){
                var res = eval(res);
                console.log(res.length);
                var html = "";
                var htmls = "";
                if(res.length>0){
                    html+="<option value='0'>请选择</option>"
                for (var i = 0; i < res.length; i++) {
                    id = res[i].id;
                    name = res[i].name;
                    html+="<option value='"+id+"'>"+name+"</option>"

//                    htmls+=' <button  style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">';
//                    htmls+=' <a href="/weixiaotong2016/index.php/Teacher/Exam/expUser?classid'+classid+'" style="color:white" >';
//                    htmls+=' </button>';
                 }
                 $("#classid").val(classid);
                  $("#exam").html(html);
                }else{
                    html+="<option value='0'>请选择</option>"
                    html+="<option value='0' selected>"+"未设置考试信息"+"</option>";
                    $("#exam").html(html);
                }

            },
            error: function(res){

            }
        });
    });

        $("#exam").change(function() {
            var examid = $("#exam option:selected").val();
            //alert(examid);
            var classid = $("#classid").val();
            //alert(examid);
            //alert(classid);
            var htmls = "";
            $("#examid").val(examid);
            if(examid>0){
//                htmls+=' <button  style="height: 30px;margin-left: 100px;margin-bottom: 20px;" class="btn btn-primary btn_submit">';
                htmls+=' <span  style="height: 30px;margin-left: 100px;margin-bottom: 20px;" class="btn btn-primary btn_submit">';
                htmls+=' <a href="/weixiaotong2016/index.php/Teacher/Exam/expUser?classid='+classid+'&examid='+examid+'" style="color:white" >';
                htmls+='下载模板</a>'
//                htmls+=' </button>';
                htmls+=' </span>';
                $(".kong1").html(htmls);
            }else{
                $(".kong1").html(htmls);
            }
        });
</script>
<script type="text/javascript">
    $("#btn1").click(function(){
        $("input[name='subject[]']").attr("checked","true");
    });
    $("#btn2").click(function(){
        $("input[name='subject[]']").removeAttr("checked");
    });

    $("#btn3").click(function(){
        $("input[name='class[]']").attr("checked","true");
    });
    $("#btn4").click(function(){
        $("input[name='class[]']").removeAttr("checked");
    });


    
</script>

</body>
</html>