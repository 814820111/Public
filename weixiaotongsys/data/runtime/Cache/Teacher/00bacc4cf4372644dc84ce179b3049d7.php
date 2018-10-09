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
    <!--<link rel="stylesheet" href="/weixiaotong2016/statics/simpleboot/css/bootstrap (2).css">-->
    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />

    <script type="text/javascript" src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
        <script src="/weixiaotong2016/statics/js/laydate/laydate.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
    <script src="/weixiaotong2016/statics/js/new_file.js"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>
    <script src="/weixiaotong2016/statics/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
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
        .ant-btn{
            display: inline-block;
            margin-bottom: 0;
            font-weight: 500;
            text-align: center;
            -ms-touch-action: manipulation;
            touch-action: manipulation;
            cursor: pointer;
            background-image: none;
            border: 1px solid transparent;
            white-space: nowrap;
            line-height: 1.15;
            padding: 0 15px;
            font-size: 12px;
            border-radius: 4px;
            height: 28px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            transition: all .3s cubic-bezier(.645,.045,.355,1);
            position: relative;
            color: rgba(0,0,0,.65);
            background-color: #fff;
            border-color: #d9d9d9;
        }
        .body_left{
            border: 1px solid #dedede;
            border-radius: 4px;
            background: #f4f6f8;
        }
        .body_right{
            border: 1px solid #dedede;
            border-radius: 4px;
            background: #f4f6f8;
        }
        .departments-display{
            border-radius: 4px;
            height: auto;
            overflow: auto;
            max-height: 100px;
            overflow: hidden;
            white-space: nowrap;
        }
        .scheduling-display{
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 2px 8px;
            height: auto;
            overflow: auto;
            max-height: 100px;
            overflow: hidden;
            white-space: nowrap;
        }
        .ant-tag-blue {
            color: #108ee9;
            background: #d2eafb;
            border-color: #d2eafb;
        }
        .ant-tag {
            display: inline-block;
            line-height: 20px;
            height: 22px;
            padding: 0 8px;
            border-radius: 4px;
            border: 1px solid #e9e9e9;
            background: #f3f3f3;
            font-size: 12px;
            transition: all .3s cubic-bezier(.215, .61, .355, 1);
            opacity: 1;
            margin-right: 8px;
            cursor: pointer;
            white-space: nowrap;
        }
        a{
            color: #38adff;
            cursor: pointer;
        }

        .ant-form-item{
            font-size: 12px;
            margin-bottom: 24px;
            color: rgba(0,0,0,.65);
            vertical-align: top;
            height: 32px;
        }
        .ant-form-item-label{
            width: 100px;
        }
        .period-hide {
            width: 120px;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            margin-left: 10px;
        }
        #test1{
            padding: 4px 7px;
            width: 100%;
            height: 28px;
            font-size: 12px;
            line-height: 1.5;
            margin-left: 10px;
        }
        .schedule_table_column th{
            vertical-align: middle;
            text-align: center;
        }
        .table tr  td{     border: 1px solid #ddd;}
        .schedule_period_div{
            overflow: hidden;
            white-space: nowrap;
            width: 200px;
            display: inline-block;
            text-overflow: ellipsis;
        }
        .ant-menu-item-group-title {
            color: rgba(0,0,0,.43);
            font-size: 12px;
            line-height: 1.5;
            padding: 8px 16px;
            transition: all .3s;
            text-align: center;
        }
        .menu_item {
            color: #fff;
            height: 26px;
            text-align: center;
            line-height: 26px;
            background-color: #2db7f5;
            text-overflow: ellipsis;
            overflow: hidden;
            border-radius: 0;
            width: 175px;
            margin: 0px auto;
            margin-top: 10px;
        }
    </style>
    <style type="text/css">
        /*opacity是设置遮罩透明度的，可以自己调节*/
        #loading{position:fixed;top:0;left:0;width:100%;height:100%;background:#f8f8f8;opacity:1;z-index:15000;}
        #loading img{position:absolute;top:50%;left:50%;width:40px;height:33px;margin-top:-16px;margin-left:-38px;}
        #loading p{position:absolute;top:55%;left:48%;width:33px;height:33px;margin-top:-15px;margin-left:-15px;}
    </style>

</head>
<body>
<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
        <li><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">考勤组管理</a></li>
        <li class="active"><a href="<?php echo U('lists');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">排班管理</a></li>
    </ul>
    <div id="loading" class="list-item">
        <img alt="" src="/weixiaotong2016/statics/image/loading.gif"><br>
        <p style="line-height: 24px;">loading...</p>
    </div>
    <div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
        <div style="background-color: rgba(0, 0, 0, 0.7); position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1040; display: none;" class="student_num">
            <div style=" width:550px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">
                <form id="form3" action="" method="post">
                    <div id="" style="width:100%;float:left; margin-top: 20px;">


                        <div class="c_selector_left" style="height:315px; width: 245px;background-color: ; float:left;">
                            <div class="title_left">
                                <span>选择</span>
                                <span>：</span>
                            </div>
                            <div class="body_left" style="height: 260px;overflow: auto;">
                                <div class="selector_left">
                                    <div class="c_search_content" style="    padding-left: 11px;">
                                        <span style="font-size: 10px;">教师姓名:</span>
                                        <!--<input type="text" class="teacher_name" style="height: 30px; margin-top: 10px;" oninput="searchRequest()">-->
                                        <input type="text" id="timeinput" class="sang_Calender" placeholder="-搜索-" style="margin-top: 10px; width: 150px; border: 1px solid #dce4ec;">

                                    </div>
                                </div>
                                <div class="mianbao" style="padding: 5px 11px; font-size: 12px;"><span class="get_back">返回上一级</span></div>
                                <div class="ding_selector_navbar" style=" padding: 5px 11px; font-size: 12px; margin-top:-5px;" ><input type="checkbox"  class="x_quan" style="vertical-align: -3px;width: 10px;height: 11px;">全选</span></div>
                                <div class="selector_main" style="padding: 0px 11px; font-size: 12px;">
                                    <li>
                                        <label><input type="checkbox" style="vertical-align: -3px;width: 10px;height: 11px;"></label>
                                        <span>个人</span>
                                        <span style="color:rgb(56, 173, 255); float: right;cursor: pointer" onclick="sub_level(1,2)">下级</span>
                                    </li>
                                </div>
                            </div>
                        </div>
                        <div class="c_selector_right"  style="height:315px; width: 245px;background-color:;float:right;">
                            <div class="title_right">
                                <span>已选</span>
                                <span>：</span>
                            </div>
                            <div class="body_right" style="height: 260px;overflow: auto;">
                                <div class="selector_right">
                                    <div class="person_body" style="padding: 0px 11px; font-size: 12px;">


                                    </div>
                                </div>

                            </div>
                        </div>




                    </div>

                    <!--<div class="stu_main_table" style="text-align: center;">-->
                    <!--<div class="stu_main"></div>-->

                    <!--</div>-->

                    <div class="layui-layer-btn layui-layer-btn-" style="position:absolute;;right:0;bottom:0;"><a class="layui-layer-btn0 person_confirm">确定</a><a class="layui-layer-btn1 student_num_guan">关闭</a></div>
                    <input type="hidden" name="electiveid" id="electiveid" value="46">

                </form>

                <!--关闭start-->
                <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="stu_num_guan">
                <!--关闭end-->
            </div>
        </div>





        <div class="tab-pane fade in active" id="home" style="margin-bottom: 50px;">
            <br/>
            <form class="form-horizontal J_ajaxForm" action="<?php echo u('add_group_post');?>" method="post" name="myform">


                <input type="hidden" class="att_type">
                <div class="kong">
                    <div style=" width:80px; float:left; text-align:right;"> 班次说明：</div>
                    <input name="att_group" class="att_group" type="hidden">
                    <input name="att_userid" class="att_userid" type="hidden">

                    <div class="departments-display" style="width: 500px;float: left;margin-left: 14px;display: none;"  >

                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="kong">
                    <input name="no_att_userid" class="no_att_userid" type="hidden">
                    <div style=" width:80px; float:left; text-align:right;"> 排班周期：</div>
                    <div class="no-departments-display" style="width: 500px;float: left;margin-left: 14px;display: none;" >

                    </div>
                    <!--<div class="departments-display"></div>-->
                    <div class="clearfix"></div>
                </div>

                <div class="kong">
                    <div style=" width:80px; float:left; text-align:right;"> 选择月份：</div>
                    <div style=" width:100px; float:left; text-align:right;margin-right: 14px;"><input type="text" id="test1" style=" border: 1px solid #dce4ec;"></div>
                    <div style="float: right;">
                        <input type="reset" class="btn btn-primary" onclick="period_save()" value="保存" style=>

                        <input type=button name="submit1" value="恢复" onclick="recover()" style="margin-left: 20px; " class="btn btn-default btn_submit">



                    </div>
                    <!--  <select class="select_2" name="teacher" style=" float:left; margin-left:14px;">
                       <option value='0'>--请选择--</option>
                       <?php if(is_array($teachers)): foreach($teachers as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>

                     </select> -->

                    <div class="clearfix"></div>
                </div>

                <div class="kong fenbian" >
                    <div class="div-table-top">
                        <div class="div-table-top-container">
                            <div class="ant-table-fixed-left" style="overflow-x:auto; ">
                                <table class="table" style="table-layout:fixed;">
                                    <thead class="ant-table-thead">
                                    <tr style="height: 56.3636px;">


                                    </tr>
                                    </thead>
                                    <tbody class="ant-table-tbody">

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                    <div class="div-table-bottom">

                    </div>

                </div>




            </form>
        </div>
    </div>
    <div id="mydiv" style=" position: absolute; width: 230px; height: 210px;background-color: white;  display: none;">
        <div class="mydiv-top" style="height: 20%">
            <div  id="mydiv-top-left" class="mydiv-top-div"  data-local="mydiv-top-left" style="float: left;width:50%;height:40px;border-bottom:1px solid #38adff;cursor: pointer; padding: 8px 20px;"  >
               按天排班
            </div>
            <div    class="mydiv-top-div" data-local="mydiv-top-right" style="float: right;width:50%;height:40px;   padding: 8px 20px; cursor: pointer;" >
              按周期排班
            </div>
        </div>
        <div class="mydiv-bottom">
            <div class="mydiv-bottom-left" >
                <ul style="margin: 0px;">
                    <li>
                        <div class="ant-menu-item-group-title" title="修改该员工当天班次">修改该员工当天班次</div>
                    </li>
                    <ul class="day_schedule" style="margin: 0px;">

                    </ul>
                </ul>
            </div>
            <div class="mydiv-bottom-right" style="display: none;" >
                <ul style="margin: 0px;">
                    <li>
                        <div class="ant-menu-item-group-title" title="从该天开始周期排班至月底">从该天开始周期排班至月底</div>
                    </li>
                    <ul class="period_schedule" style="margin: 0px;">

                    </ul>
                </ul>
            </div>
            <div class="mydiv-bottom-right"></div>
        </div>
    </div>
    <input class="groupid" type="hidden" value="<?php echo ($groupid); ?>">
    <div class="tab-pane fade" id="ios">
    </div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript">

    //获取分辨率
    sum = screen.width+screen.height;
    if(sum<'2240')
    {

        $(".fenbian").css("height",'400px');
    }


    $("html").click(function(event){
        if($("#mydiv").css("display")=='block')
        {
//            $("#mydiv").slideToggle("slow");
            $("#mydiv").hide();
        }

  })
    laydate.render({
        elem: '#test1'
        ,type: 'month'
        ,done: function(value, date, endDate){
            layer.load();
      //  console.log(value); //得到日期生成的值，如：2017-08-18
            var shijinn = value;
            $("#test1").val(value);
            //年月,区分部门人员的标识
            var timestamp2 = Date.parse(new Date(shijinn));
            //因为北京时间要减去8小时

            timestamp2 = timestamp2 / 1000 - 28800;

            var year = shijinn.substring(0, 4);
            var month = shijinn.substring(6, 8);

            var todayDate = new Date(year,month,0)
            var sumday = todayDate.getDate();

//            var date = "07/17/2014";    //此处也可以写成 17/07/2014 一样识别    也可以写成 07-17-2014  但需要正则转换
//            var day = new Date(Date.parse(date));   //需要正则转换的则 此处为 ： var day = new Date(Date.parse(date.replace(/-/g, '/')));
//            var today = new Array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
//            var week = today[day.getDay()];
            get_year_month(year,month)
            for (var i = 1; i<=sumday; i++)
            {
//                var todayWeekday = new Date(2018,6,01)
//                var date = "07/17/2014";    //此处也可以写成 17/07/2014 一样识别    也可以写成 07-17-2014  但需要正则转换
                var date = month+"/"+i+"/"+year;
                var day = new Date(Date.parse(date));   //需要正则转换的则 此处为 ： var day = new Date(Date.parse(date.replace(/-/g, '/')));
                var today = new Array('星期日','星期一','星期二','星期三','星期四','星期五','星期六');
                var week = today[day.getDay()];

            }
    }
    });

    //获取年月
    function get_year_month(year,month)
    {

        //获取分组id
        var groupid = $(".groupid").val();

        var mydate = new Date();

        if(!year && !month)
        {
            //获取今年
            var year =mydate.getFullYear();

            var month = mydate.getMonth()+1;

            var day  = mydate.getDate();
        }
         $(".ant-table-thead tr").children().remove();

        var todayDate = new Date(year,month,0)
        var sumday = todayDate.getDate();
        var html = "";
        html+="<th class=schedule_table_column style=width:120px;text-align:center;vertical-align:middle;position:relative;><span>姓名</span></th>"
        for (var i = 1; i<=sumday; i++)
        {
//                var todayWeekday = new Date(2018,6,01)
//                var date = "07/17/2014";    //此处也可以写成 17/07/2014 一样识别    也可以写成 07-17-2014  但需要正则转换
            var date = month+"/"+i+"/"+year;
            var day = new Date(Date.parse(date));   //需要正则转换的则 此处为 ： var day = new Date(Date.parse(date.replace(/-/g, '/')));
            var today = new Array('日','一','二','三','四','五','六');
            var week = today[day.getDay()];
            if(week=="日" || week=="六")
            {
                var style = "style=color:red;"
            }else{
                var style = ""
            }
            html+="<th class=schedule_table_column style=width:50px;text-align:center><span "+style+">"+i+"<br>"+week+"</span></th>"

        }
        $(".ant-table-thead tr").append(html);

        //遍历人员
        each_person(groupid,sumday)
    }


    function at_year_month()
    {
        var time = $("#test1").val()
        var timestamp2 = new Date(new Date(time).toLocaleDateString()).getTime()/1000;
        //因为北京时间要减去8小时


       return timestamp2;
    }



    function each_person(groupid,sumday)
    {
        $(".ant-table-tbody").children().remove();

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('show_person');?>",
            data: {
                groupid:groupid,
                at_year_month:at_year_month(),
            },

            success: function(res) {
                if(res.status)
                {
                    //获取当前年月
                    var at_month = $("#test1").val();

                    var person = res.data;
                    console.log(person);
                    var html = "";
                     for(var i = 0; i < person.length; i++)
                    {
                        var person_detail = person[i]['person_detail'];

                        html+="<tr style='vertical-align:middle;'>";
                            html+="<td class=schedule_table_column style=width:120px;text-align:center;position:relative;vertical-align:middle; data-userid="+person[i]['personid']+">";
                            html+="<span>"+person[i]['name']+"</span>";
                            html+="</td>";
                            for(var j = 1; j<= sumday; j++)
                            {
                               // console.log(at_month+"-"+j);

                                var time =  new Date(new Date(at_month+"-"+j).toLocaleDateString()).getTime()/1000;


                                   if(person_detail.length > 0) {

                                       for (var c = 0; c < person_detail.length; c++) {
                                           if (time == person_detail[c]['time']) {

                                               var schedule = person_detail[c]['name']?person_detail[c]['name'].substring(0, 2):"休息";
                                               var schedule_id = "data-schedulid="+person_detail[c]['scheduleid']+"";
                                               var data_time = "data-time="+person_detail[c]['time']+"";
                                               var data_type = "data-type=1";
                                               break;
                                           } else {
                                               var schedule = "";
                                               var schedule_id = "";
                                               var data_time = "";
                                               var data_type = "";
                                           }
                                       }
                                   }else{
                                       var schedule = "";
                                       var schedule = "";
                                       var schedule_id = "";
                                       var data_time = "";
                                       var data_type = "";
                                   }
                                html+="<td class=schedule_table_column style=width:50px;text-align:center;cursor:pointer; "+data_type+" "+data_time+" "+schedule_id+" ><span >"+schedule+"</span></td>"
                            }
                        html+="</tr>";

                    }

                    $(".ant-table-tbody").append(html);
                    setTimeout(function(){
                        layer.closeAll('loading');
                    });
                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

//$(".ant-table-tbody.schedule_table_column").click(function(e){
//    alert("1");
////    e.stopPropagation();
//    var offset = $(this).offset();
//    //元素位置
//    schedule_table_td = $(this).index();
//    //元素父级
//    parent_schedule_table = $(this).parent();
//
//    $(".mydiv-top-left").css("border-bottom","1px solid #38adff");
//    $(".mydiv-top-right").css("border-bottom","none");
//    $(".mydiv-bottom-left").show();
//    $(".mydiv-bottom-right").hide();
//    $("#mydiv").hide();
//    $("#mydiv").css("position", "abosolute").css("left", offset.left+"px").css("top", offset.top+36+"px").slideDown();
//
//})

  $(document).on('click', '.ant-table-tbody tr td', function(e){

    e.stopPropagation();
    var offset = $(this).offset();
      obj_offset = $(this);

    //元素位置
    schedule_table_td = $(this).index();
    //元素父级
    parent_schedule_table = $(this).parent();


    $(".mydiv-top-div").css("border-bottom","none");
      $("#mydiv-top-left").css("border-bottom","1px solid #38adff");
    $(".mydiv-bottom-left").show();
    $(".mydiv-bottom-right").hide();
    $("#mydiv").hide();
    $("#mydiv").css("position", "abosolute").css("left", offset.left+"px").css("top", offset.top+36+"px").slideDown();
  })
  $(window).resize(function() {
      var obj_size = obj_offset.offset();

      $("#mydiv").css("left", obj_size.left+"px").css("top", obj_size.top+36+"px")
  })



//function show_div(obj)
//{
//
//    var offset = $(obj).offset();
//    //元素位置
//    schedule_table_td = $(obj).index();
//    //元素父级
//    parent_schedule_table = $(obj).parent();
//
//    $(".mydiv-top-left").css("border-bottom","1px solid #38adff");
//    $(".mydiv-top-right").css("border-bottom","none");
//    $(".mydiv-bottom-left").show();
//    $(".mydiv-bottom-right").hide();
//    $("#mydiv").hide();
//    $("#mydiv").css("position", "abosolute").css("left", offset.left+"px").css("top", offset.top+36+"px").slideDown();
//
//}

    function check(form)
    {
        var att_name = $("#att_name").val();
        var att_group = $(".att_group").val();
        var att_userid = $(".att_userid").val();
        if(!att_name)
        {
            layer.msg('考勤组名称不能为空', {
                icon: 2
                ,shade: 0.01,
            });
            return false;
        }
        if(!att_group && !att_userid)
        {
            layer.msg('参与考勤人员不能为空！', {
                icon: 2
                ,shade: 0.01,
            });
            return false;
        }


        document.myform.submit();
    }


   function get_time()
    {
        var mydate = new Date();
        var str = "" + mydate.getFullYear() + "-0";
        str += (mydate.getMonth()+1);
        return str;
    }


    //获取班次
    function show_schedule()
    {
        var groupid = $(".groupid").val();
        $(".departments-display").show();

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('get_edit_scheduling');?>",
            data: {
                groupid:groupid,
            },

            success: function(res) {
                if(res.status)
                {

                    var scheudle = res.data;


                    var html = "";

                    var day_html ="";


                    for(var i = 0; i < scheudle.length; i++)
                    {
                        var name = scheudle[i]['name'];
                        var att_time = scheudle[i]['att_time'];
                        html += "<div class='ant-tag ant-tag-blue'>";
                        html += "<span class=ant-tag-text data-id="+scheudle[i]['id']+">" + name + att_time+"</span>";
                        html += "</div>";

                        day_html+="<li class=day-ant-menu-item  role=menuitem aria-selected=false data-id="+scheudle[i]['id']+" onclick =day_one_schedule(this,"+scheudle[i]['id']+")><p class=menu_item>"+name+"</p></li>"


                    }
                    day_html+="<li class=day-ant-menu-item  role=menuitem aria-selected=false data-id=0 onclick =day_one_schedule(this,0)><p class=menu_item>休息</p></li>"
                    $(".departments-display").append(html);
                    $(".day_schedule").append(day_html);
                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }
    function rtrim(s) {
        var lastIndex = s.lastIndexOf('-');
        if (lastIndex > -1) {
            s = s.substring(0, lastIndex);
        }
        return s;
    }

    //排班周期  明天过来写这里，把模态框写写好
    function show_scheudle_period()
    {
        var groupid = $(".groupid").val();
        $(".no-departments-display").show();

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('show_scheudle_period');?>",
            data: {
                groupid:groupid,
            },

            success: function(res) {
                if(res.status)
                {
                    var period = res.data;

                    var html = "";
                    var str = "";
                    var period_schedule_html = "";
                    for(var i = 0; i < period.length; i++)
                    {
                        if(!period[i]['name']){period[i]['name'] = "休息";}


                       str+=period[i]['name']+"-";
                    }

                    html += "<div class='ant-tag ant-tag-blue schedule_period_div'>";
                    html += "<span class=ant-tag-text title='每周轮班交替：" +rtrim(str)+"'>每周轮班交替：" +rtrim(str)+"</span>";
                    html += "</div>";
                    period_schedule_html+="<li class=period-ant-menu-item role=menuitem aria-selected=false onclick =period_schedule(this)><p class=menu_item ant-tag-blue>每周轮班交替：" +rtrim(str)+"</p></li>"

                    $(".no-departments-display").append(html);
                    $(".period_schedule").append(period_schedule_html);
                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    }

    function day_one_schedule(obj,id)
    {

        //获取当月
        var at_month = $("#test1").val();
        //获取时间戳
        var time =  new Date(new Date(at_month+"-"+schedule_table_td).toLocaleDateString()).getTime()/1000;

        var name = $(obj).find("p").text().substring(0, 2);

       $(parent_schedule_table).find("td").eq(schedule_table_td).attr("data-schedulid",id);
       $(parent_schedule_table).find("td").eq(schedule_table_td).attr("data-type",2);
       $(parent_schedule_table).find("td").eq(schedule_table_td).find("span").text(name);
       $(parent_schedule_table).find("td").eq(schedule_table_td).attr("data-time",time);

       $("#mydiv").slideToggle("slow");

    }

    function period_schedule()
    {

        //获取当月
        var at_month = $("#test1").val();
        //获取时间戳

       var exist =  exist_schedule();

       if(!exist['is_true'])
       {
           if (confirm(exist['content'])) {
               ajax_period();
           }
           $("#mydiv").slideToggle("slow");
           return false;
       }

        ajax_period();
        $("#mydiv").slideToggle("slow");

    }

    function ajax_period()
    {
        //获取当月
        var at_month = $("#test1").val();

        //获取分组
        var groupid = $(".groupid").val();

        var  td_length =  $(parent_schedule_table).find("td");
        //获取该分组的排班周期
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('show_scheudle_period');?>",
            data: {
                groupid:groupid,
            },

            success: function(res) {
                if(res.status)
                {
                    var period = res.data;
                    var k = 0;
                    for (var i = schedule_table_td; i<td_length.length; i++)
                    {


                        if(td_length.eq(i).attr("data-userid"))
                        {
                            continue;
                        }

                        if(k>period.length-1)
                        {
                            k = 0;
                        }
                        if(!period[k]['name']){period[k]['name'] = "休息";}

                        var time =  new Date(new Date(at_month+"-"+i).toLocaleDateString()).getTime()/1000;
                        td_length.eq(i).find("span").text(period[k]['name'].substring(0, 2))
                        td_length.eq(i).attr("data-schedulid",period[k]['scheduleid']);
                        td_length.eq(i).attr("data-type",2);
                        td_length.eq(i).attr("data-time",time);
                        k++;

                    }

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

    function exist_schedule() {
        var is_true = true;
        //获取当月
        var at_month = $("#test1").val().substring(6, 8);

        var td_length = $(parent_schedule_table).find("td");

        var name = td_length.eq(0).find("span").text();

        var str = "";

        var k = 0;
        for (var i = schedule_table_td; i < td_length.length; i++)
        {
           if(td_length.eq(i).attr("data-type")==1)
           {
               if(k<2) {
                   str += at_month + "-" + i + "、";
               }
                   k++;
               is_true = false;
           }

        }

          var myhash = new Array();
            myhash['is_true'] =  is_true;
            myhash['content'] =  name+exist_rtrim(str)+"等"+k+"天已有排班，是否覆盖原有排班？";
           return myhash;

    }


    function exist_rtrim(s) {
        var lastIndex = s.lastIndexOf('、');
        if (lastIndex > -1) {
            s = s.substring(0, lastIndex);
        }
        return s;
    }

    $(".mydiv-top-div").click(function(e)
    {

        e.stopPropagation();
        var div_name = $(this).attr("data-local");

     if(div_name=="mydiv-top-right")
     {
         $(this).css("border-bottom","1px solid #38adff");
         $(this).prev().css("border-bottom","none");
         $(".mydiv-bottom-left").hide();
         $(".mydiv-bottom-right").show();
     }else{
         $(this).next().css("border-bottom","none");
         $(this).css("border-bottom","1px solid #38adff");
         $(".mydiv-bottom-left").show();
         $(".mydiv-bottom-right").hide();
     }

    })


//    function show_my_div(obj)
//    {
//
//     var div_name = $(obj).attr("class");
//
//     if(div_name=="mydiv-top-right")
//     {
//         $(".mydiv-top-right").css("border-bottom","1px solid #38adff");
//         $(".mydiv-top-left").css("border-bottom","none");
//         $(".mydiv-bottom-left").hide();
//         $(".mydiv-bottom-right").show();
//     }else{
//         $(".mydiv-top-right").css("border-bottom","none");
//         $(".mydiv-top-left").css("border-bottom","1px solid #38adff");
//         $(".mydiv-bottom-left").show();
//         $(".mydiv-bottom-right").hide();
//     }
//
//    }




  $("document").ready(function() {


        //班次说明
        show_schedule();
        //排版周期
        show_scheudle_period();
     var time = $("#test1").val();

      var groupid = $(".groupid").val();
      //如果时间不存则去默认当天
      if(!time)
      {
          $("#test1").val(get_time())
            get_year_month();

      }
      $("#loading").hide();
    })
    function period_save()
    {
        var period = new Array();

        //获取分组
        var groupid = $(".groupid").val();

        var tr_obj = $(".ant-table-tbody").find("tr");


        var del_user = "";

//        alert(b[155][1]); //2
        for(var i = 0; i < tr_obj.length; i++)
        {
            var td_obj = tr_obj.eq(i).find("td");


            var userid = td_obj.eq(0).attr("data-userid");
            del_user+=userid+",";
//            person[userid] = {userid:userid}


            for(var j = 1; j<td_obj.length; j++)
            {

                var time = td_obj.eq(j).attr("data-time");

                var schedulid = td_obj.eq(j).attr("data-schedulid");

                if(time && schedulid)
                {
                          period.push({
                              userid:userid,
                              time:time,
                              schedulid:schedulid,
                          });
                }
            }

        }

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('add_period');?>",
            data: {
                groupid:groupid,
                period:period,
                userid:del_user,
                year_month:at_year_month(),
            },

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    location.reload();

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    }

  function recover()
  {
      var mydate = new Date();

      var groupid = $(".groupid").val();
          //获取今年
          var year =mydate.getFullYear();

          var month = mydate.getMonth()+1;

          var day  = mydate.getDate();

      var todayDate = new Date(year,month,0)
      var sumday = todayDate.getDate();

      //恢复人员
      each_person(groupid,sumday)

  }


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