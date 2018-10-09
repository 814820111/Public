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

    .wraps {
        width: 240px;
        white-space: nowrap;
        text-overflow: ellipsis;
        overflow: hidden;
        color: black;
    }

    .example-image {
        width: 40px;
        height: 36px;
    }
    .mydiv-image {
        width: 230px;
        height: 210px;
    }

</style>
<body class="J_scroll_fixed">
<div class="wrap J_check_wrap">
    <ul class="nav nav-tabs">
        <li class="active"><a href="">考勤短信查询</a></li>
    </ul>
    <div class="common-form">
        <fieldset>
            <div class="stu-change-class">
                <div class="stu-select">
                         <span class="mr20">
                        省份选择：
                        <select  class="province"  name="province" id="province" style="width: auto;">
                            <option value="">&nbsp;&nbsp;

                                省级选择&nbsp;
                                &nbsp;

                            </option>
                            <?php if(is_array($Province)): foreach($Province as $key=>$vo): $pro=$province==$vo['term_id']?"selected":""; ?>
                                <option value="<?php echo ($vo["term_id"]); ?>"<?php echo ($pro); ?>><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                        </select>&nbsp;&nbsp;
                        <input type="hidden" class="new_citys" value="<?php echo ($new_citys); ?>">
                        市级:
                        <select class="select_1" name="citys" id="citys" style="width: auto;">

                            <option value="0" selected>请先选择省份</option>

                        </select> &nbsp;&nbsp;
                        <input type="hidden" class="new_message_type" value="<?php echo ($new_message_type); ?>">
                        区级:
                        <select class="select_3" name="message_type" id="message_type" style="width: auto;">
                            <option value="0">请选择你的区域</option>
                        </select> &nbsp;&nbsp;
                        学校：
                        <select id="school" style="width: auto;">
                            <option value="" >请选择学校</option>
                        </select><br>

                        <span class="mr20" >
                            班级选择：
                            <span style="width: 45%; margin-top: 13px; ">
                                <select id="classname" name="classid" style="width: auto;">

                                    <option value="0"> &nbsp;&nbsp; 班级选择 &nbsp;&nbsp; </option>
                                </select>&nbsp;&nbsp;
                            </span>
                            手机号码：
                            <span style="width: 45%; margin-top: 13px; ">
                                <input type="text" id="phone" name="phone" style=" width: 110px;">
                            </span>
                            卡号：
                            <span style="width: 45%; margin-top: 13px; ">
                                <input type="text" id="cardNo" name="cardNo" style=" width: 110px;">
                            </span><br>


                        </span>
查询时间： <input type="date" name="begin" class="stu-select-inputlist"  id="begin_time" style="width: 135px;">-<input type="date" name="end" id="end_time" class="stu-select-inputlist"  id="time" style="width: 135px;">
                             <!--考勤时段 :<select>-->
                             <!--<option value="0">请选择</option>-->
                             <!--<option value="1">上午上学</option>-->
                             <!--<option value="2">上午放学</option>-->
                             <!--<option value="3">下午上学</option>-->
                             <!--<option value="4">下午放学 </option>-->
                             <!--<option value="5">晚上上学 </option>-->
                             <!--<option value="6">晚上放学 </option>-->
                             <!--</select>-->

                    </span><br>
                    考勤状态： <input type="radio" value="1" name="att_type" style="vertical-align: -3px;" >上午上学
                    <input type="radio" value="2" name="att_type" style="vertical-align: -3px;">上午放学
                    <input type="radio" value="3" name="att_type" style="vertical-align: -3px;">下午上学
                    <input type="radio" value="4" name="att_type" style="vertical-align: -3px;">下午放学
                    <input type="radio" value="5" name="att_type" style="vertical-align: -3px;">晚上上学
                    <input type="radio" value="6" name="att_type" style="vertical-align: -3px;">晚上放学

                    <!--<div class="stu-select-list">-->



                    <!--<label class="stu-select-label">学校:</label>-->
                    <!--<select class="stu-select-inputlist" name="schoolid">-->
                    <!--&lt;!&ndash;<option value="1">学校1</option>&ndash;&gt;-->
                    <!--&lt;!&ndash;<option value="2">学校2</option>&ndash;&gt;-->
                    <!--&lt;!&ndash;<option value="3">学校3</option>&ndash;&gt;-->
                    <!--<?php if(is_array($school)): foreach($school as $key=>$vo): ?>-->
                    <!--<option id=<?php echo ($vo["schoolid"]); ?>><?php echo ($vo["school_name"]); ?></option>-->
                    <!--<?php endforeach; endif; ?>-->
                    <!--</select>-->
                    <!--</div>-->

                    <!--<div class="stu-select-list">-->
                    <!--<label class="stu-select-label">班级:</label>-->
                    <!--<select class="stu-select-inputlist" name="schoolid" id="classname">-->
                    <!--</select>-->
                    <!--</div>-->
                    <!--<div class="stu-select-list">-->
                    <!--<label class="stu-select-label">日期:</label>-->
                    <!--<input type="date" name="select_date" class="stu-select-inputlist" style="width: 206px;height: 20px;padding: 4px 6px;" id="time">-->
                    <!--</div>-->
                    <button type="button" class="btn btn-primary" id="chaxun" style="margin-top: -10px;">查询</button>
                    <!--<button type="button" class="btn btn-success" id="daochu" style="margin-top: -10px;">导出</button>-->
                </div>
            </div>
            <div style="clear: both"></div>
        </fieldset>
    </div>
    <!--此班级共<em id="sum" style="font-style: normal;"></em>人，发卡数为<em id="card_sum" style="font-style: normal;"></em>今日已打卡<em id="ye_sum" style="font-style: normal;"></em>人，未打卡<em id="no_sum" style="font-style: normal;"></em>人，出勤率为<em id="rate" style="font-style: normal;"></em>-->
    <table class="table table-hover table-bordered">
        <thead>
        <tr>
            <th >家长姓名</th>
            <th>手机号码</th>
            <th>学校</th>
            <th>班级</th>
            <th>学生</th>
            <th>卡号</th>
            <th>考勤时段</th>
            <th>到校照片</th>
            <th>短信下发时间</th>
            <th>短信内容</th>
            <th>发送状态</th>
            <th>微信发送状态码</th>

            <!--<th>考勤状态</th>-->
        </tr>
        </thead>
        <tbody>
        <!--<tr><td>1</td><td>1</td><td><img width="30" height="30" src="/weixiaotong2016uploads/avatar/<?php echo ($vo["photo"]); ?>" /></td><td>1</td><td>1</td></tr>-->
        </tbody>
    </table>

    <div class="pagination"><?php echo ($Page); ?></div>
    <div id="mydiv" style=" position: absolute; width: 230px; height: 210px;background-color: red;  display: none;">
        <img class="mydiv-image" src="">

    </div>
    <!--<iframe src="<?php echo U('studentlist');?>" class="change_class_iframe"></iframe>-->
</div>
<script src="/weixiaotong2016/statics/js/common.js"></script>
</body>
<script>

    $(document).on('mouseover', '.example-image', function(e){
        e.stopPropagation();
        var img = $(this).attr("src");

        obj_offset = $(this);
        var offset = $(this).offset();
        console.log(offset);

        //元素位置
        schedule_table_td = $(this).index();
        console.log(schedule_table_td);
        //元素父级
        parent_schedule_table = $(this).parent();

//        $(".mydiv-top-left").css("border-bottom","1px solid #38adff");
//        $(".mydiv-top-right").css("border-bottom","none");
//        $(".mydiv-bottom-left").show();
//        $(".mydiv-bottom-right").hide();
        $("#mydiv").hide();
//        $("#mydiv).css("background-image","url("+img+")");
        $(".mydiv-image").attr("src",img);
        $("#mydiv").css("position", "abosolute").css("left", offset.left+40+"px").css("top", offset.top+-210+"px").fadeIn(500);
    })

    $(document).on('mouseout', '.example-image', function(e){
        $("#mydiv").hide();


    })

    $(window).resize(function() {
        var obj_size = obj_offset.offset();

        $("#mydiv").css("left", obj_size.left+58+"px").css("top", obj_size.top+-210+"px")
    })


    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().replace(/:\d{1,2}$/,' ');
    }

    //选择市级的下拉的ajax
    $(function() {
        $("#province").change(function(){


            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=role_type&Province="+$("#province").val(),{},function(data){
                $("#citys").empty()

                if(data.status=="success"){

                    $("#citys").append("<option value=>"+"请选择市级"+"</option>");
                    for(var key in data.data){
                        $("#citys").append("<option value="+data.data[key]["term_id"]+">"+data.data[key]["name"]+"</option>");
                    }
                }
                if(data.status=="error"){
                    $("#citys").append("<option value=''>没有市级</option>");
                }
            });


        })
    });


    $(function() {
        $("#citys").change(function() {
            console.log($("#citys").val())
            $("#message_type").empty();
            // $("#student").empty();

            $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
            $.getJSON("/weixiaotong2016/index.php?g=Admin&m=AdminUtils&a=Provinces&Province="+$("#citys").val(),{},function(data){
                console.log(data);
                if(data.status=="success"){

                    // $("#message_type").append("<option value=>"+"请选择区域"+"</option>");
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




    $(".select_3").change(function() {

        var type = $(".select_3  option:selected").val();
        $("#school").empty();
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
                    html += '<option class="Sio" value="' + schoolid + '">' + school_name + ' </option> '
                }
                $("#school").append("<option value=''>请选择学校</option>");
                $("#school").append(html)
                $("#viewOLanguage").chosen();
                $("#viewOLanguage").trigger("liszt:updated");
            },
            error: function() {
                console.log('系统错误,请稍后重试');
            }
        });
    })

    $("#school").change(function(){
        $("#classname").empty();


        $.getJSON("/weixiaotong2016/index.php?g=admin&m=AdminUtils&a=schoolclass&schoolid="+$("#school").val(),{},function(data){
            if(data.status=="success"){
                $("#classname").append("<option value=''>请选择班级</option>");
                for(var key in data.data){
                    $("#classname").append("<option value="+data.data[key]["id"]+">"+data.data[key]["classname"]+"</option>");
                }
            }
            if(data.status=="error"){
                $("#classname").append("<option value='0'>没有班级</option>");
            }
        });



    })


    //导出
    $("#daochu").click(function(){

//        var xuan = $(".tiaojian option:selected").val();
//        var zhi = $(".zhi").val();
//        var type = $(".select_3  option:selected").val();
        var school = $("#school  option:selected").val();
        var classname = $("#classname  option:selected").val();
        var begin_time = $("#begin_time").val();
        var end_time = $("#end_time").val();



        var isSuccess = 1;

        if(school=="")
        {
            alert('请选择学校');
            isSuccess = 0;
            return false;
        }
//        if(classname=="")
//        {
//            alert("请选择班级");
//            isSuccess = 0;
//            return false;
//        }
        if(begin_time && !end_time)
        {
            alert('请将时间补充完整!');
            return false;
        }
        if(!begin_time && end_time)
        {
            alert('请将时间补充完整!');
            return false
        }




        if(isSuccess==1){
            location.href="<?php echo U('Attendance/Lexcel');?>?schoolid="+school+"&classid="+classname+"&begin_time="+begin_time+"&end_time="+end_time+"";
        }

    })


    $(document).on("click",".pagination a",function(){

        layer.load();
        //return false;
        $.getJSON($(this).attr('href'),function(data){
             console.log(data);
            setTimeout(function(){
                layer.closeAll('loading');
            });
            $("table tbody").children().remove();
            $(".pagination").children().remove();

            if(data.status=="error"){
                // console.log('aaa');
                $("table tbody").append('<tr><td>没有数据!</td>');
            }

            var adata = data;


            var parent_name = "";
            var phone = "";
            var student_name = "";
            var school_name = "";
            var classname = "";
            var attendancetype = "";
            var pic = "";
            var cardNo = "";
            var time = "";
            var content = "";
            var status = "";
            var errcode = "";
            // $("table tbody").children().remove();
            for (var i=0;i<adata.length;i++){
                if(i==0)
                {
                    $(".pagination").append(adata[i]);
                    continue
                    //return false;
                }

                parent_name = adata[i]['parent_name'];
                phone = adata[i]['phone'];
                student_name = adata[i]['stu_name'];
                school_name = adata[i]['school_name'];
                classname = adata[i]['classname'];
                attendancetype = adata[i]['attendancetype'];
                pic = adata[i]['leavepicture'];
                cardNo = adata[i]['cardno'];
                time = adata[i]['time'];
                content = adata[i]['content'];
                status = adata[i]['status'];
                errcode = adata[i]['errcode'];

                if(pic)
                {
                    var td_img = '<img class="example-image" src="http://ow3hm6y11.bkt.clouddn.com/'+pic+'"></td>';
                }else{
                    var td_img = "暂无图片";
                }

                $("table tbody").append('<tr><td>'+parent_name+'</td><td>'+phone+'</td><td>'+school_name+'</td><td>'+classname+'</td><td>'+student_name+'</td><td>'+cardNo+'</td><td>'+attendancetype+'</td><td>'+td_img+'</td><td>'+time+'</td><td><div class="wraps" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="'+content+'">'+content+'</div></td><td>'+status+'</td><td>'+errcode+'</td></tr>');

            }


        })
        return false;

    })





    $("#chaxun").click(function () {

        var schoolid = $("#school option:selected").val();

        var classid = $("#classname option:selected").val();

        var begin_time = $("#begin_time").val();
        var end_time = $("#end_time").val();
        var phone = $("#phone").val();
        var cardNo = $("#cardNo").val();

        var cbj=document.getElementsByName('att_type');
        var att_type="";
        for(var i=0; i<cbj.length; i++){
            if(cbj[i].checked){
                att_type+=cbj[i].value;
            }
        }

//        var istrue = '';
//        if(!$("#province").val())
//        {
//            alert("请选择省份!");
//            return false;
//        }
//        if(!$("#citys").val())
//        {
//            alert("请选择市级!");
//            return false;
//        }
//        if(!$("#message_type").val())
//        {
//            alert("请选择区级!");
//            return false;
//        }
        if(!$("#school").val() && !phone && !cardNo)
        {
            alert("请选择学校或输入卡号和手机号！");
            return false;
        }

//                    if(!classid)
//                    {
//                        alert("请选择班级");
//                        return false
//                    }
        if(begin_time && !end_time)
        {
            alert('请将时间补充完整!');
            setTimeout(function(){
                layer.closeAll('loading');
            });
            return false;
        }
        if(!begin_time && end_time)
        {
            alert('请将时间补充完整!');
            setTimeout(function(){
                layer.closeAll('loading');
            });
            return false
        }
        layer.load();

        $.ajax({
            url:"/weixiaotong2016/index.php/Admin/Attendance/get_message",
            dataType:"json",
            type:"get",
            data:{
                begin_time:begin_time,
                end_time:end_time,
                classid:classid,
                phone:phone,
                schoolid:schoolid,
                cardNo:cardNo,
                att_type:att_type
            },
            success:function (res) {
                setTimeout(function(){
                    layer.closeAll('loading');
                });
                var adata = res;


;
                var parent_name = "";
                var phone = "";
                var student_name = "";
                var school_name = "";
                var classname = "";
                var attendancetype = "";
                var pic = "";
                var cardNo = "";
                var time = "";
                var content = "";
                var status = "";
                var errcode = "";


                $("table tbody").children().remove();
                $(".pagination").children().remove();
                if(res.status=="error"){
                    // console.log('aaa');
                    $("table tbody").append('<tr><td style="width: 100px;">没有数据!</td><tr>');
                }
                for (var i=0;i<adata.length;i++){
                    if(i==0)
                    {
                        $(".pagination").append(adata[i]);
                        //return false;
                        continue
                    }
                    parent_name = adata[i]['parent_name'];
                    phone = adata[i]['phone'];
                    student_name = adata[i]['stu_name'];
                    school_name = adata[i]['school_name'];
                    attendancetype = adata[i]['attendancetype'];
                    pic = adata[i]['leavepicture'];
                    classname = adata[i]['classname'];
                    cardNo = adata[i]['cardno'];
                    time = adata[i]['time'];
                    content = adata[i]['content'];
                    status = adata[i]['status'];
                    errcode = adata[i]['errcode'];


                    // j++



                    if(pic)
                    {
                        var td_img = '<img class="example-image" src="http://ow3hm6y11.bkt.clouddn.com/'+pic+'"></td>';
                    }else{
                        var td_img = "暂无图片";
                    }



//                <div class="wraps" wraps data-toggle="tooltip" data-placement="right" title="<?php echo ($vo["names"]); ?>"> &nbsp;<?php echo ($vo["names"]); ?></div>
                    $("table tbody").append('<tr><td>'+parent_name+'</td><td>'+phone+'</td><td>'+school_name+'</td><td>'+classname+'</td><td>'+student_name+'</td><td>'+cardNo+'</td><td>'+attendancetype+'</td><td>'+td_img+'</td><td>'+time+'</td><td> <div class="wraps" style="cursor: pointer;" data-toggle="tooltip" data-placement="right" title="'+content+'">'+content+'</div></td><td>'+status+'</td><td>'+errcode+'</td></tr>');
                }

//                            var attendance_rate = Math.round((adata.length-j)/adata.length*100)+'%';
//                            if(isNaN(attendance_rate))
//                            {
//                                attendance_rate = ':无数据!';
//                            }
//                            $("#rate").text(attendance_rate);
//                            console.log(attendance_rate);
            },
            error:function (res) {
                var data = eval(res.data);
//                            alert("失败");

            }
        })
    });

</script>
</html>