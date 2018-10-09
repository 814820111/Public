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
<html>
<head>
<style>
</style>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>食谱</title>
<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap_message.css">
<link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css"/>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<style type="text/css">
.col-auto { overflow: auto; _zoom: 1;_float: left;}
.col-right { float: right; width: 30%; overflow: hidden;}
.table th, .table td {vertical-align: middle;}
.picList li{margin-bottom: 5px;}
.clearfix{ clear:both;}
.xuan02,.xuan02a,.xuan02b{ display:none;}
.xuan03,.xuan03a,.xuan03b{ display:none;}
.quanlei{ display:block;}
          i{
          	font-style: normal;
          	color: black;
          }
  #Ttab {
	width: 450px;
	white-space: nowrap;
	text-overflow: ellipsis;
	overflow: hidden;
	color: black;
	  display: inline-block;
	  margin-left: 10px;
}
</style>
</head>
<body>
<div>
    <ul id="myTab" class="nav nav-tabs" style=" margin-left:30px; margin-top:20px;">
   		<li class="active"><a href="<?php echo U('index');?>" style="color:#1f1f1f; font-weight: bold;">每周食谱创建</a></li>
   		<li><a href="<?php echo U('lists');?>" style="color:#1f1f1f">食谱列表</a></li>
   	</ul>


   	<div id="myTabContent" class="tab-content" style=" margin-bottom: 100px;">
   		<form name="myform" id="myform" action="<?php echo u('add_post');?>" method="post" class="form-horizontal J_ajaxForms" enctype="multipart/form-data"  onsubmit="return checkForm()">
			<input type="hidden" name="button_level" value="1">
			<div style=" margin-top: 20px;">

			  <div style=" width: 100px; float: left; text-align: right; color: #2b2b2b; margin-right: 10px;">年级：</div>
			  <select class="select_2" name="search_grade">
                <option value='0'>全校</option>
                <?php if(is_array($grade)): foreach($grade as $key=>$vo): ?><OPTION value="<?php echo ($vo["gradeid"]); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>
              </select> &nbsp;&nbsp;
			  <div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
			  <div style="width: 100px; float: left; text-align: right; margin-right: 10px; ">食谱标题：</div>
				<input type="text" name="title"   class="Diet" placeholder="请输入内容" style=" width: 220px; color: black; padding-left: 5px; height: 28px; "><span id="Dtab"></span>
				<div class="clearfix"></div>
			</div>
			<!-- <div style=" margin-top: 10px;">
				<div style=" width: 100px; float: left; text-align: right; margin-right: 10px; margin-right: 10px;">开始日期：</div>
				<select style=" width: 200px; color: #a9a9a9; height: 28px; padding-left: 5px;">
					<option>-请选择-</option>
				</select>
				<div class="clearfix"></div>
			</div> -->
			<div style=" margin-top: 20px;">
				<div style="  width: 100px; float: left; text-align: right; margin-right: 10px;">时间：</div>
				<!--<input    type="text" name="begin" class="J_date" placeholder="-选择时间-" style=" width: 120px; color: #a9a9a9; padding-left: 5px; height: 28px; ">&nbsp;至&nbsp;<input    type="text" name="end" class="J_date" placeholder="-选择时间-" style=" width: 120px; color: #a9a9a9; padding-left: 5px; height: 28px; "><span id="Ttab"></span><i style="    vertical-align: -3px; margin-left: 30px;">定时发送:</i><input type="checkbox" name="optionsRadiosinline" value="1" ><input type="time" name="timing" value="09:00" style=" border-width: 1px;width: 95px; height: 28px;" name="time_wf1"  />-->
			 <input type="text" name="cook_time" class="J_date" placeholder="-选择时间-" style=" width: 120px; color: black; padding-left: 5px; height: 28px; "><span id="Ttab" title=""></span>
				<div class="clearfix"></div>
			</div>

		
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期一：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="monday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb1' value=''>
					<div style=" width: 300px;">
						<a id="pic" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb1',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb1_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb1_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic').find('img').remove(); $('#pic').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb1_preview width=80 height=60 style=cursor:hand />'); $('#thumb1').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>

				<div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期二：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="tuesday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb2' value=''>
					<div style=" width: 300px;">
						<a id="pic2" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb2',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb2_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb2_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic2').find('img').remove(); $('#pic2').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb2').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期三：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="wednesday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb3' value=''>
					<div style=" width: 300px;">
						<a id="pic3" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb3',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb3_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb3_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic3').find('img').remove(); $('#pic4').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb3').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期四：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="thursday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb4' value=''>
					<div style=" width: 300px;">
						<a id="pic4" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb4',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb4_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb4_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic4').find('img').remove(); $('#pic4').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb4').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期五：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="friday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb5' value=''>
					<div style=" width: 300px;">
						<a id="pic5" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb5',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb5_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb5_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic5').find('img').remove(); $('#pic5').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb5').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期六：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="saturday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb6' value=''>
					<div style=" width: 300px;">
						<a id="pic6" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb6',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb6_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb6_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic6').find('img').remove(); $('#pic6').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb6').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>
				<div class="clearfix"></div>
			</div>
			<div style=" margin-top: 20px;">
				<div style=" width:100px; float: left; text-align: right; margin-right: 10px;">星期日：</div>
				<textarea style="  width:60%; height: 150px; resize: none;" name="sunday"></textarea>
				<div  style="display: inline-block;"><input type='hidden' name='cookpic[]' id='thumb7' value=''>
					<div style=" width: 300px;">
						<a id="pic7" style="  " href='javascript:void(0);' onclick="flashupload('thumb_images', '附件上传','thumb7',thumb_images,'4,jpg|jpeg|gif|png|bmp,4,,,4','','&max_count=1','');return false;">

							<img src='/weixiaotong2016/statics/images/icon/upload-pic.png' id='thumb7_preview' width='80' height='60' style='cursor:hand' />
						</a>
						<!-- <input type="button" class="btn" onclick="crop_cut_thumb($('#thumb').val());return false;" value="裁减图片">  -->
						<input type="button" class="btn" onclick="$('#thumb7_preview').attr('src','/weixiaotong2016/statics/images/icon/upload-pic.png');$('#pic7').find('img').remove(); $('#pic7').append('<img src=/weixiaotong2016/statics/images/icon/upload-pic.png id=thumb2_preview width=80 height=60 style=cursor:hand />'); $('#thumb7').val('');return false;" value="取消图片" style=" padding:5px 8px 5px 8px; font-size:14px;">
					</div>

				</div>
				<div class="clearfix"></div>
			</div>

			<!-- <div style=" margin-left: 110px; margin-top: 15px;">
				<input type="checkbox" style=" float: left;">
				<span style=" margin-left: 5px; margin-right: 20px; float: left">微信推送</span>
				<input type="checkbox" style=" float: left">
				<span style=" margin-left: 5px; float: left">同时发送给自己</span>
				<div class="clearfix"></div>
			</div>
			<div style=" margin-left: 110px; margin-top: 15px;">
				<div style=" float: left; width: 13px; height: 13px; border-radius: 50%; background-color:#e84e40; margin-right: 10px; margin-top: 3px;"></div>
				<div style=" float: left;">
					说明：食谱每天早晨09：00定时发送到家长手机，如不需发送请到开关设置中进行配置。
				</div>
				<div class="clearfix"></div>
			</div> -->
			<div style=" margin-top: 15px; margin-left: 110px;">
			<input type="reset" value="重置" style=" background-color: #adadad; color: white; border: none; padding: 4px 15px; border-radius: 3px; margin-right: 50px;">
				<input type="submit" value="发送" style=" background-color: #26a69a; color: white; border: none; padding: 4px 15px; border-radius: 3px;">
				
			</div>
			<div style="margin-top: 10px;"><i style=" vertical-align: -3px; margin-left: 30px;">发送老师:</i><input type="checkbox" name="teachertype" value="1" ></div>
			<div style="margin-top: 10px;"><i style="    vertical-align: -3px; margin-left: 30px;">定时发送:</i><input type="checkbox" name="optionsRadiosinline" value="1" ><input type="time" name="timing" value="09:00" style=" border-width: 1px;width: 95px; height: 28px;" name="time_wf1"  /></div>


		</form>
	</div>
	<script src="/weixiaotong2016/statics/js/common.js"></script>
	<script type="text/javascript" src="/weixiaotong2016/statics/js/content_addtop.js"></script>
  <script>






	  $(".dingshi").click(function(){

	   check = $(this).attr("checked");



		  if(!check)
		  {
		  	$(this).removeAttr("checked");
		  }else{
		  	$(this).attr("checked",true);
		  }


	  })



	$("input[name=cook_time]").blur(function(){
         time = $(this).val();

         if(time)
		 {
             var d=getMonDate();
             var arr=[];
             for(var i=0; i<7; i++)
             {
                 arr.push(d.getFullYear()+'年'+(d.getMonth()+1)+'月'+d.getDate()+'日 （'+getDayName(d.getDay())+'）');
                 d.setDate(d.getDate()+1);
             }
             $("#Ttab").text(arr);
             $("#Ttab").css("color","red");
             $("#Ttab").css("font-size","12px");
             $("#Ttab").attr("title",arr);
		 }else{
             $("#Ttab").text('');
		 }






    })
      function getMonDate()
      {

          var d=new Date(time),


              day=d.getDay(),

              date=d.getDate();
//          console.log(d);
          if(day==1)
              return d;
          if(day==0)
              d.setDate(date-6);
          else
              d.setDate(date-day+1);
          return d;
      }
      // 0-6转换成中文名称
      function getDayName(day)
      {
          var day=parseInt(day);

          if(isNaN(day) || day<0 || day>6)
              return false;
          var weekday=["星期天","星期一","星期二","星期三","星期四","星期五","星期六"];
          return weekday[day];
      }


      //      function getWeek(time){
//          var now='';
//          time?(now = new Date(time)):(now = new Date());
//          var day = now.getDay();
//          console.log(day);
//          if(day == 0){
//              day = 7;
//          }
//          var nowTime = now.getTime(),
//              MondayTime = nowTime - (day-1)*24*60*60*1000,    // 周一
//              SundayTime =  nowTime + (7-day)*24*60*60*1000;   // 周日
//		    var monday = new Date(MondayTime),                   // 格式化周一
//              start_Year =monday.getFullYear(),
//              start_Month = monday.getMonth()+ 1,
//              start_Day = monday.getDate();
//          var sunday = new Date(SundayTime),                   // 格式化周末
//
//              end_Year =sunday.getFullYear(),
//              end_Month = sunday.getMonth()+ 1,
//              end_Day = sunday.getDate();
//
//          if(start_Month<10) {
//              start_Month="0"+start_Month;
//          }
//          if(start_Day < 10) {
//              start_Day="0"+start_Day;
//          }
//          if(end_Month<10) {
//              end_Month="0"+end_Month;
//          }
//          if(end_Day < 10) {
//              end_Day="0"+end_Day;
//          }
//          var start_time = start_Year+'-'+start_Month+'-'+start_Day;
//          var end_time = end_Year+'-'+end_Month+'-'+end_Day;
//          if(new Date()<new Date(end_time)){
//              var today = new Date().toLocaleDateString().replace(/\//g, "-");
//              var today_year = today.substring(0,4);
//              var today_month = today.substring(5,7);
//              var today_day = today.substring(8,10);
//              if(today_day<10) {
//                  today_day="0"+today_day;
//              }
//              end_time = today_year+'-'+today_month+'-'+today_day;
//          }
//          return start_time+' -- '+end_time;
//      }


      function checkForm(){

       var grade = $(".select_2").val();

      var Diet = $(".Diet").val();

      var time = $("input[name='cook_time']").val();







          if (Diet=='') {
    		alert('食谱标题不能为空')

             
            
    		return false;
    	}


    	if(time == ''){
    		// Ttab.innerHTML = '* 时间段不能为空!';
    		alert("请选择要发送的时间段");
            return false;
    	}


    	if($("textarea[name='monday']").val()=='' && $("textarea[name='tuesday']").val()==''&& $("textarea[name='wednesday']").val()==''&& $("textarea[name='thursday']").val()=='' &&　$("textarea[name='friday']").val()=='' && $("textarea[name='saturday']").val()=='' && $("textarea[name='sunday']").val()=='')
		{
		    alert("内容不能全为空!");
		    return false;
		}

          if($("input[name='optionsRadiosinline']").is(':checked')) {

              if($("input[name='timing']").val()=='')
			  {
			      alert("定时时间不能为空！");
			      return false;
			  }

          }

          if(time == ''){
              // Ttab.innerHTML = '* 时间段不能为空!';
              alert("请选择要发送的时间段");
              return false;
          }
  

            return true;

    }
 
//  $(".xuan01").click(
//  			function(){
//				x=$(this).index()
//				$(".xuan02").eq(x).show()
//				$(".xuan03").eq(x).show()
//				
//				
//				}
//  )
//  $(".xuan02 .xuan04").click(
//  			function(){
//				y=$(this).parent().index()
//				$(".xuan01").eq(y).children(".xuan05").click()
//				}
//  )
//  $(".xuan02").click(
//  			function(){
//				y=$(this).index()
//				$(this).hide()
//				$(".xuan03").eq(y).hide()
//				
//				}
//  )
//   $(".xuan03 .xuan06").click(
//  			function(){
//				Z=$(this).parent().index()
//				$(".xuan01").eq(Z).children(".xuan05").click()
//				}
//  )
//   $(".xuan03").click(
//  			function(){
//				y=$(this).index()
//				$(this).hide()
//				$(".xuan02").eq(y).hide()
//				
//				}
//  )
//$(".quan03").click(
// 			function(){
//				
//				$(".xuan02").show()
//				$(".xuan03").show()
//				$(".banji input").prop("checked",true)
//				
//				}
// )
// $(".quan02").click(
// 			function(){
//				$(".xuan02").hide()
//				$(".xuan03").hide()
//				$(".xuan02").click()
//				$(".xuan02 .xuan04").click()
//				$(".xuan03").click()
//				$(".xuan03 .xuan06").click()
//				}
// )
/*$(".quan01").click(
 			function(){
				$(".xuan01").click()
				}
 )
   */
  </script>
  <script>
  
 
//  $(".xuan01a").click(
//  			function(){
//				c=$(this).index()
//				$(".xuan02a").eq(c).show()
//				$(".xuan03a").eq(c).show()
//				
//				
//				}
//  )
//  $(".xuan02a .xuan04a").click(
//  			function(){
//				d=$(this).parent().index()
//				$(".xuan01a").eq(d).children(".xuan05a").click()
//				}
//  )
//  $(".xuan02a").click(
//  			function(){
//				d=$(this).index()
//				$(this).hide()
//				$(".xuan03a").eq(d).hide()
//				
//				}
//  )
//   $(".xuan03a .xuan06a").click(
//  			function(){
//				e=$(this).parent().index()
//				$(".xuan01a").eq(e).children(".xuan05a").click()
//				}
//  )
//   $(".xuan03a").click(
//  			function(){
//				f=$(this).index()
//				$(this).hide()
//				$(".xuan02a").eq(f).hide()
//				
//				}
//  )
//$(".quan03a").click(
// 			function(){
//				
//				$(".xuan02a").show()
//				$(".xuan03a").show()
//				$(".geren input").prop("checked",true)
//				
//				}
// )
// $(".quan02a").click(
// 			function(){
//				$(".xuan02a").hide()
//				$(".xuan03a").hide()
//				$(".xuan02a").click()
//				$(".xuan02a .xuan04a").click()
//				$(".xuan03a").click()
//				$(".xuan03a .xuan06a").click()
//				}
// )
/*$(".quan01").click(
 			function(){
				$(".xuan01").click()
				}
 )
   */
  </script>
  <script>
  
 
//  $(".xuan01b").click(
//  			function(){
//				l=$(this).index()
//				$(".xuan02b").eq(l).show()
//				$(".xuan03b").eq(l).show()
//				
//				
//				}
//  )
//  $(".xuan02b .xuan04b").click(
//  			function(){
//				m=$(this).parent().index()
//				$(".xuan01b").eq(m).children(".xuan05b").click()
//				}
//  )
//  $(".xuan02b").click(
//  			function(){
//				m=$(this).index()
//				$(this).hide()
//				$(".xuan03b").eq(m).hide()
//				
//				}
//  )
//   $(".xuan03b .xuan06b").click(
//  			function(){
//				n=$(this).parent().index()
//				$(".xuan01b").eq(n).children(".xuan05b").click()
//				}
//  )
//   $(".xuan03b").click(
//  			function(){
//				p=$(this).index()
//				$(this).hide()
//				$(".xuan02b").eq(p).hide()
//				
//				}
//  )
//$(".quan03b").click(
// 			function(){
//				
//				$(".xuan02b").show()
//				$(".xuan03b").show()
//				$(".xuexiao input").prop("checked",true)
//				
//				}
// )
// $(".quan02b").click(
// 			function(){
//				$(".xuan02b").hide()
//				$(".xuan03b").hide()
//				$(".xuan02b").click()
//				$(".xuan02b .xuan04b").click()
//				$(".xuan03b").click()
//				$(".xuan03b .xuan06b").click()
//				}
// )
/*$(".quan01").click(
 			function(){
				$(".xuan01").click()
				}
 )
   */
  </script>
<script>
//$('#myTab a:first').tab('show');
</script>
<script>
//		$("#file-3").fileinput({
//			showUpload: false,
//			showCaption: false,
//			browseClass: "btn btn-default",
//			fileType: "any",
//	        previewFileIcon: "<i class='glyphicon glyphicon-king'></i>"
//		});
//	    $(document).ready(function() {
//	        $("#test-upload").fileinput({
//	            'showPreview' : false,
//	            'allowedFileExtensions' : ['jpg', 'png','gif'],
//	            'elErrorContainer': '#errorBlock'
//	        });
//
//	    });
		</script>
        <!--全选start-->                  
<script type="text/javascript">
//var change = function (chkArray, val) 
//{
// for (var i = 0 ; i < chkArray.length ; i ++) 
////遍历指定组中的所有项
//     chkArray[i].checked = val;              
////设置项为指定的值-是否选中
//}
</script>
<!--全选end-->

<script>
//$('#myTab a:first').tab('show');
</script>
<script type="text/javascript"> 
//$(function () {
//  //setInterval(function(){public_lock_renewal();}, 10000);
//  $(".J_ajax_close_btn").on('click', function (e) {
//      e.preventDefault();
//      Wind.use("artDialog", function () {
//          art.dialog({
//              id: "question",
//              icon: "question",
//              fixed: true,
//              lock: true,
//              background: "#CCCCCC",
//              opacity: 0,
//              content: "您确定需要关闭当前页面嘛？",
//              ok:function(){
//          setCookie("refersh_time",1);
//          window.close();
//          return true;
//        }
//          });
//      });
//  });
//  /////---------------------
//   Wind.use('validate', 'ajaxForm', 'artDialog', function () {
//      //javascript
//          
//              //编辑器
//              editorcontent = new baidu.editor.ui.Editor();
//              editorcontent.render( 'content' );
//              try{editorcontent.sync();}catch(err){};
//              //增加编辑器验证规则
//              jQuery.validator.addMethod('editorcontent',function(){
//                  try{editorcontent.sync();}catch(err){};
//                  return editorcontent.hasContents();
//              });
//              var form = $('form.J_ajaxForms');
//          //ie处理placeholder提交问题
//          if ($.browser.msie) {
//              form.find('[placeholder]').each(function () {
//                  var input = $(this);
//                  if (input.val() == input.attr('placeholder')) {
//                      input.val('');
//                  }
//              });
//          }
//          //表单验证开始
//          form.validate({
//        //是否在获取焦点时验证
//        onfocusout:false,
//        //是否在敲击键盘时验证
//        onkeyup:false,
//        //当鼠标掉级时验证
//        onclick: false,
//              //验证错误
//              showErrors: function (errorMap, errorArr) {
//          //errorMap {'name':'错误信息'}
//          //errorArr [{'message':'错误信息',element:({})}]
//          try{
//            $(errorArr[0].element).focus();
//            art.dialog({
//              id:'error',
//              icon: 'error',
//              lock: true,
//              fixed: true,
//              background:"#CCCCCC",
//              opacity:0,
//              content: errorArr[0].message,
//              cancelVal: '确定',
//              cancel: function(){
//                $(errorArr[0].element).focus();
//              }
//            });
//          }catch(err){
//          }
//              },
//              //验证规则
//              rules: {'post[post_title]':{required:1},'post[post_content]':{editorcontent:true}},
//              //验证未通过提示消息
//              messages: {'post[post_title]':{required:'请输入标题'},'post[post_content]':{editorcontent:'内容不能为空'}},
//              //给未通过验证的元素加效果,闪烁等
//              highlight: false,
//              //是否在获取焦点时验证
//              onfocusout: false,
//              //验证通过，提交表单
//              submitHandler: function (forms) {
//                  $(forms).ajaxSubmit({
//                      url: form.attr('action'), //按钮上是否自定义提交地址(多按钮情况)
//                      dataType: 'json',
//                      beforeSubmit: function (arr, $form, options) {
//                          
//                      },
//                      success: function (data, statusText, xhr, $form) {
//                          if(data.status){
//                setCookie("refersh_time",1);
//                //添加成功
//                Wind.use("artDialog", function () {
//                    art.dialog({
//                        id: "succeed",
//                        icon: "succeed",
//                        fixed: true,
//                        lock: true,
//                        background: "#CCCCCC",
//                        opacity: 0,
//                        content: data.info,
//                    button:[
//                      {
//                        name: '继续添加？',
//                        callback:function(){
//                          reloadPage(window);
//                          return true;
//                        },
//                        focus: true
//                      },{
//                        name: '返回列表页',
//                        callback:function(){
//                          location='<?php echo U('SchoolPlan/index');?>';
//                          return true;
//                        }
//                      }
//                    ]
//                    });
//                });
//              }else{
//                isalert(data.info);
//              }
//                      }
//                  });
//              }
//          });
//      });
//  ////-------------------------
//});
</script>
</body>
</html>