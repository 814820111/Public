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
    <script src="/weixiaotong2016/statics/js/jquery.js"></script>
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
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 2px 8px;
            height: auto;
            overflow: auto;
            max-height: 100px;
            overflow: hidden;
            white-space: nowrap;
        }
        .no-departments-display{
            border: 1px solid #e4e4e4;
            border-radius: 4px;
            padding: 2px 8px;
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

<div id="loading" class="list-item">
    <img alt="" src="/weixiaotong2016/statics/image/loading.gif"><br>
    <p style="line-height: 24px;">loading...</p>
</div>
<div class="">
    <ul id="myTab" class=" nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
        <li><a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;" class="touch">考勤组管理</a></li>
        <li class="active"><a href="<?php echo U('lists');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">修改考勤</a></li>
    </ul>
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
                                        <input type="text" id="timeinput"   oninput = "teacher_search()" class="teacher_search" placeholder="-搜索-" style="margin-top: 10px; width: 150px; border: 1px solid #dce4ec;">

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

        <!--排班班次设置modal-->
        <div style="background-color: rgba(0, 0, 0, 0.7); position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1040; display: none;" class="schedule_set">
            <div style=" width:550px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">
                <form id="form3" action="" method="post">
                    <div id="" style="width:100%;float:left; margin-top: 20px;">


                        <table class="table">
                            <thead>
                            <tr>
                                <th><input type="checkbox" ></th>
                                <th>班次名称</th>
                                <th>考勤时间</th>

                            </tr>
                            </thead>
                            <tbody class="scheduling_main">

                            </tbody>
                        </table>

                    </div>


                    <div class="layui-layer-btn layui-layer-btn-" style="position:absolute;;right:0;bottom:0;"><a class="layui-layer-btn0 scheduling_confirm">确定</a><a class="layui-layer-btn1 schedule_set_guan">关闭</a></div>
                    <input type="hidden" name="electiveid" id="electiveid" value="46">

                </form>

                <!--关闭start-->
                <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="schedule_set_guan">
                <!--关闭end-->
            </div>
        </div>

        <!--固定班次设置-->
        <div style="background-color: rgba(0, 0, 0, 0.7); position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1040; display: none;" class="fixation_schedule_set">
            <div style=" width:550px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">
                <form id="form3" action="" method="post">
                    <div id="" style="width:100%;float:left; margin-top: 20px;">


                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>班次名称</th>
                                <th>考勤时间</th>

                            </tr>
                            </thead>
                            <tbody class="fixation_schedule_main">
                            </tbody>
                        </table>




                    </div>


                    <div class="layui-layer-btn layui-layer-btn-" style="position:absolute;;right:0;bottom:0;"><a class="layui-layer-btn0" onclick=fixation_confirm()>确定</a><a class="layui-layer-btn1 fixation_schedule_guan">关闭</a></div>
                    <input type="hidden" name="electiveid" id="electiveid" value="46">

                </form>

                <!--关闭start-->
                <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="fixation_schedule_guan">
                <!--关闭end-->
            </div>
        </div>

        <div class="tab-pane fade in active" id="home" style="margin-bottom: 50px;">
            <br/>
            <form class="form-horizontal J_ajaxForm" action="<?php echo u('edit_post');?>" method="post" name="myform">
                <input class="groupid" type="hidden"  name="groupid" value="<?php echo ($groupid); ?>">

                <div class="kong">
                    <div style=" width:100px; float:left; text-align:right;">考勤组名称：</div>
                    <input type="text" name="att_name" id="att_name" placeholder="-请输入内容-" style="width: 220px; height: 30px; border:1px solid #dce4ec; margin-left:14px; float:left; color: black;">
                    <div class="clearfix"></div>
                </div>
                <input type="hidden" class="att_type">
                <div class="kong">
                    <div style=" width:100px; float:left; text-align:right;"> 参与考勤人员：</div>
                    <input name="att_group" class="att_group" type="hidden">
                    <input name="att_userid" class="att_userid" type="hidden">

                    <div class="departments-display" style="width: 500px;float: left;margin-left: 14px;display: none;" onclick ="get_person(1,1)" >

                    </div>
                    <input type="button" class="ant-btn part_att" value="请选择" style="margin-left:14px;" onclick ="get_person(0,1)" >
                    <div class="clearfix"></div>
                </div>
                <div class="kong">
                    <input name="no_att_userid" class="no_att_userid" type="hidden">
                    <div style=" width:100px; float:left; text-align:right;"> 无需考勤人员：</div>
                    <div class="no-departments-display" style="width: 500px;float: left;margin-left: 14px;display: none;" onclick ="get_person(2,2)" >

                    </div>
                    <input type="button" class="ant-btn no_part_att" value="请选择" style="margin-left:14px;" onclick ="get_person(0,2)" >
                    <!--<div class="departments-display"></div>-->
                    <div class="clearfix"></div>
                </div>
                <!--<div class="kong">-->
                    <!--<div style=" width:80px; float:left; text-align:right;margin-right: 14px;">考勤组负责人：</div>-->
                    <!--&lt;!&ndash;  <select class="select_2" name="teacher" style=" float:left; margin-left:14px;">-->
                       <!--<option value='0'>&#45;&#45;请选择&#45;&#45;</option>-->
                       <!--<?php if(is_array($teachers)): foreach($teachers as $key=>$vo): ?>-->
                          <!--<OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></OPTION>-->
                       <!--<?php endforeach; endif; ?>-->

                     <!--</select> &ndash;&gt;-->
                    <!--<div style=" border:1px solid #bbbbbb;  overflow-y:scroll; padding:10px; width: 500px; height: 150px;">-->

                        <!--<div class="clearfix"></div>-->
                    <!--</div>-->
                    <!--<div class="clearfix"></div>-->
                <!--</div>-->
                <div class="kong">
                    <div style=" width:100px; float:left; text-align:right;">考勤类型：</div>
                    <div style="margin-left: 78px;float: left; z-index: 999;    position: absolute;  width: 200px; height: 50px;">
                    </div>
                    <div style="margin-left: 14px;float: left; position: relative; z-index: 998; color: grey;">

                        <label style="    display: inline-block;">
                            <span><input type="radio" name="schedule" value="1" style="vertical-align: -2px;" checked></span>
                            <span>固定班制 <i style="font-style:normal;font-size:13px;">(每天考勤时间一样)</i></span>
                            <p style="color:grey; margin-top: 10px; ">适用于：IT、金融、文化传媒、政府/事业单位、教育培训等行业</p>
                        </label><br>
                        <label>
                            <span><input type="radio" name="schedule" value="2" style="vertical-align: -2px;"></span>
                            <span>排班制 <i style="font-style:normal;font-size:13px;">(自定义设置考勤时间)</i></span>
                            <p style="color: grey;margin-top: 10px; ">适用于：餐饮、制造、物流贸易、客户服务、医院等行业</p>
                        </label>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="kong">
                    <?php if($group['type'] == 1): ?><div class="fixation-div" style="display:block;">
                        <div style=" width:100px; float:left; text-align:right;margin-right: 14px; ">工作日设置：</div>
                        <div style="float: left">快捷设置班次：<span class="fixation-xiu">休息</span>&nbsp;<a data-type="1" >更改班次</a></div><br>
                        <!--  <select class="select_2" name="teacher" style=" float:left; margin-left:14px;">
                           <option value='0'>--请选择--</option>
                           <?php if(is_array($teachers)): foreach($teachers as $key=>$vo): ?><OPTION value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></OPTION><?php endforeach; endif; ?>

                         </select> -->
                        <div style=" border:1px solid #bbbbbb; float:left; padding:10px; width: 500px; margin-top: 10px; ">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th><input class="fixation-quan" type="checkbox"  ></th>
                                    <th>工作日</th>
                                    <th>班次时间段</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><input type="checkbox" value="1"  name="week[]"></td>
                                    <td>周一 <input type="hidden" value="1" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  value="2" name="week[]"></td>
                                    <td>周二 <input type="hidden" value="2" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" value="3" name="week[]"></td>
                                    <td>周三 <input type="hidden" value="3" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox"  value="4" name="week[]"></td>
                                    <td>周四 <input type="hidden" value="4" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" value="5" name="week[]"></td>
                                    <td>周五 <input type="hidden" value="5" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" value="6" name="week[]"></td>
                                    <td>周六 <input type="hidden" value="6" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                <tr>
                                    <td><input type="checkbox" value="7" name="week[]"></td>
                                    <td>周日 <input type="hidden" value="7" name="fixation_week[]"></td>
                                    <td>休息</td>
                                    <td><input type='hidden' name='schedule_fixation[]' value=0><a data-type="2">更改班次</a></td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                        <?php else: ?>
                    <div class="schedule-div" style="display:block;">
                        <div style=" width:80px; float:left; text-align:right;margin-right: 14px;">考勤班次：</div>
                        <input name="scheduling" class="scheduling" type="hidden">
                        <div class="scheduling-display" style="width: 500px;float: left;display: block;" onclick="get_scheduling()">
                        </div>
                        <input type="button" class="ant-btn scheduling_att"   value="选择班次" style="display: none;" onclick="get_schedule()"  >

                    </div><?php endif; ?>


                    <div class="clearfix"></div>
                </div>
                <?php if($group['type'] == 2): ?><div class="kong scheduling-period" style="display: block;">
                    <div class="" >
                        <div style=" width:80px; float:left; text-align:right;">排班周期：</div>
                        <input name="scheduling" class="scheduling" type="hidden">

                        <input type="button" class="ant-btn scheduling_a"  value="请设置排班周期" style="margin-left: 14px; display: none;" onclick="get_schedule_set()" >
                        <div id="scheduling-period-div" style="width:400px;float:left; display: block;">

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>周期名称</th>
                                    <th>周期班次</th>
                                    <th>周期天数</th>
                                    <th>操作</th>
                                </tr>
                                </thead>
                                <tbody class="scheduling-period-table">

                                </tbody>
                            </table>




                        </div>
                    </div>

                    <div class="clearfix"></div>
                </div><?php endif; ?>
                <div style="height: 100px;">
                    <input type=button name="submit1" value="提交" onclick="check(this.form)" style="height: 30px;margin-left: 80px" class="btn btn-primary btn_submit">

                    <input type="reset" class="btn2" value="清空" style=" background-color:#adadad; margin-left: 80px">
                    <div class="clearfix"></div>
                </div>
                <!--排班周期设置modal-->
                <div style="background-color: rgba(0, 0, 0, 0.7); position: fixed; top: 0px; right: 0px; bottom: 0px; left: 0px; z-index: 1040; display: none;" class="scheduling-period-set">
                    <div style=" width:730px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">
                        <form id="form3" action="" method="post">
                            <div id="" style="width:100%;float:left; margin-top: 20px;">
                                <h4 class="modal-title" id="myModalLabel">
                                    设置排班周期
                                </h4>
                                <div class="modal-body" style="border-top: 1px solid #e9e9e9; border-bottom: 1px solid #e9e9e9;">
                                    <div class="ant-form-item" style="line-height: 30px;">
                                        <div class="ant-form-item-label" style="float: left;">
                                            <label style="float: right">周期名称:</label>
                                        </div>
                                        <div class="col-md-10" style="float: left;"><input type="text" class="period_name" name ="period_name" style=" border-radius: 4px;height:28px;width: 60%;margin-right:8px; border: 1px solid #dce4ec;"><span style="font-size: 12px;">最多6个中文字符 （中文或英文）</span></div>

                                    </div>
                                    <div class="ant-form-item" style="line-height: 30px;">
                                        <div class="ant-form-item-label" style="float: left;">
                                            <label style=" float: right;    margin-top: 4px;">每个周期天数:</label>
                                        </div>
                                        <div class="col-md-10" style="float: left;"><span class="jian" style="cursor: pointer;vertical-align: 2px;">－</span><input type="text"  name="period_num" class="period_num" value="2" oninput="searchRequest()";  onkeyup="this.value=this.value.replace(/\D/g,'')" onafterpaste="this.value=this.value.replace(/\D/g,'')" style=" border-radius: 4px;height:22px;width: 15%;border: 1px solid #dce4ec;"><span class="jia" style="cursor: pointer;vertical-align: 2px;"> +</span><span style="font-size: 12px;margin-left: 5px;">以2天为周期进行循环，最大周期天数为31天</span></div>

                                    </div>

                                </div>



                            </div>

                            <!--<div class="stu_main_table" style="text-align: center;">-->
                            <!--<div class="stu_main"></div>-->

                            <!--</div>-->
                            <div class="clearfix"></div>

                            <div class="layui-layer-btn layui-layer-btn-" style=""><a class="layui-layer-btn0 scheduling_period_confirm">确定</a><a class="layui-layer-btn1 scheduling-period-set-guan">关闭</a></div>
                            <input type="hidden" name="electiveid" id="electiveid" value="46">

                        </form>

                        <!--关闭start-->
                        <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="scheduling-period-set-guan">
                        <!--关闭end-->
                    </div>
                </div>


            </form>
        </div>
    </div>
    <div class="tab-pane fade" id="ios">
    </div>
</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript">





    $("document").ready(function() {

    var groupid = $(".groupid").val()
      $.ajax({
          type: "get",
          async: true,
          dataType: 'json',
          url: "<?php echo U('edit_data');?>",
          data: {
              groupid:groupid,

          },

          success: function(res) {
              if(res.status)
              {
                  console.log(res);
                var group = res.group;
                var person = res.person;
                var group_schedule = res.group_schedule;
                var schedule_period_detai = res.schedule_period_detai;
                $("#att_name").val(group['name']);

                  $("input[name='schedule']").each(function(){
                      if($(this).val()==group['type'])
                      {
                          $(this).attr("checked",true);
                      }
                  })
//                  if(group['type']==1)
//                  {
//                      $(".fixation-div").show();
//                      $(".schedule-div").hide();
//                  }else{
//                      $(".fixation-div").hide();
//                      $(".schedule-div").show();
//                  }



                  each_person(person)
                  each_schedule(group['type'],group_schedule,schedule_period_detai);
                  $("#loading").hide();

              }else{
                  alert(res.msg);
              }
          },
          error: function() {
              alert('系统错误,请稍后重试');
          }
      });

  })

  //遍历人员
  function each_person(person)
  {
      var html = "";
      var no_atthtml = "";

     $(".part_att").hide();

     var groupid = "";
     var userid = "";
     var no_userid = "";


     for(var i = 0; i< person.length; i++)
      {
          var name = person[i]['name'];
          console.log(name);

          if(person[i]['is_att']==2) {
              no_atthtml += "<div class='ant-tag ant-tag-blue'>";
              no_atthtml += "<span class=ant-tag-text>" + name + "</span>";
              no_atthtml += "</div>";
              no_userid += person[i]['personid'] + ",";

          }else{


              html += "<div class='ant-tag ant-tag-blue'>";
              html += "<span class=ant-tag-text>" + name + "</span>";
              html += "</div>";

              if (person[i]['teacher_groupid'] && person[i]['teacher_groupid']!=0) {
                  groupid += person[i]['teacher_groupid'] + ",";

              } else {
                  userid += person[i]['personid'] + ",";
              }
          }

      }


      if(no_atthtml)
      {
          $(".no_att_userid").val(no_userid);
          $(".no_part_att").hide();

          $(".no-departments-display").append(no_atthtml);
          $(".no-departments-display").show();
      }

      if(html)
      {
          $(".att_userid").val(userid);
          $(".att_group").val(groupid);
          $(".departments-display").append(html);
          $(".departments-display").show();

      }else{
          $(".departments-display").hide();
          $(".part_att").show();
      }



  }
  //遍历班次
  function each_schedule(type,group_schedule,schedule_period_detai) {
       if(type==1)
       {
           $(".fixation-div input[name='week[]']").click(function(){
               if(!$(this).attr("checked"))
               {
                   $(this).parent().next().next().text("休息");
                   $(this).parent().parent().find("td:eq(3) input").val(0);
                   $(this).parent().next().next().removeAttr("data-id");

               }

           })
           for(var i=0;i<group_schedule.length;i++){
               (function (i) {
                   sp = $(".fixation-div input[name='week[]']").eq(i);
                   var att_name = (group_schedule[i]['name']+group_schedule[i]['att_time']);

              if(group_schedule[i]['scheduleid']==0)
              {
                  att_name = "休息"
              }else{
                  sp.attr("checked",true);
              }




                   sp.parent().next().next().text(att_name);
                   sp.parent().next().next().attr("data-id",group_schedule[i]['scheduleid']);
                   sp.parent().next().next().next().find("input").val(group_schedule[i]['scheduleid']);
                   //开始时间
//                   btime = data.msg[i]['begintime'];
//                   //console.log(btime);
//                   etime = data.msg[i]['endtime'];
//                   //console.log(etime);
//                   latetime = data.msg[i]['latetime'];
//                   //console.log(latetime);
//                   opt = data.msg[i]['opt'];
//
//                   type = data.msg[i]['type'];
//
//                   sp = $("body").find(".span5").eq(type-1);
//
//                   //是否计入考勤
//                   //kaoqin_ss1 = data[i]['kaoqin_ss1'];
//                   //记录家长老师的发送情况
//                   //teacherid = data[i]['teacherid'];
//                   //记录家长的发送情况
//                   // parentid = data[i]['parentid'];
//                   sp.find("input[type='checkbox']").attr("checked",true);
//                   sp.find("input[type='time']").eq(0).val(btime);
//                   sp.find("input[type='time']").eq(0).removeAttr("readonly");
//                   sp.find("input[type='time']").eq(0).css("color","black");
//                   sp.find("input[type='time']").eq(1).val(etime);
//                   sp.find("input[type='time']").eq(1).removeAttr("readonly");
//                   sp.find("input[type='time']").eq(1).css("color","black");
//                   sp.find("input[type='time']").eq(2).val(latetime);
//                   sp.find("input[type='time']").eq(2).removeAttr("readonly");
//                   sp.find("input[type='time']").eq(2).css("color","black");
               })(i);
           }
       }else{
           get_schedule(1)
           var period_html = "";
           var table_html = "";
           var schedulingid = "";
           var period_id = "";
           for(var i = 0; i<schedule_period_detai.length; i++)
           {
                var att_name = schedule_period_detai[i]['name'];
                var att_time = schedule_period_detai[i]['att_time'];
                var scheduleid = schedule_period_detai[i]['scheduleid'];
               schedulingid+=schedule_period_detai[i]['scheduleid']+",";
               period_html += "<div class='ant-tag ant-tag-blue-period'>";
               period_html += "<span class=ant-tag-text data-id="+scheduleid+">"+att_name+": "+att_time+"</span>";
               period_html += "</div>";
           }
           var schedule_name = "";
           for (var j = 0; j<group_schedule.length; j++ )
           {
               if(j==0)
               {

                   var num = group_schedule[j]['week_num'];

                   var period_name = group_schedule[j]['name'];
                   $(".period_name").val(period_name);
                   $(".period_num").val(num);
                   continue;
               }
               if(!group_schedule[j]['name'])
               {
                   group_schedule[j]['name'] = "休息";
               }
               schedule_name += group_schedule[j]['name']+"-";
               period_id +=group_schedule[j]['scheduleid']+",";

           }
           table_html+="<tr>"
           table_html+="<td>"+period_name+"</td>"
           table_html+="<td class='period-hide'><input type='hidden' class='schedule_period_id' value="+period_id+"><div title="+schedule_name.substring(0,schedule_name.length-1)+" style=overflow:hidden;white-space:nowrap;text-overflow:clip;width:110px;display:inline-block;text-overflow:ellipsis;>"+schedule_name.substring(0,schedule_name.length-1)+"</div></td>"
           table_html+="<td>"+num+"</td>"
           table_html+="<td><a onclick='get_schedule_set()'>设置</a></td>"
           table_html+="</tr>";
           $(".scheduling-display").append(period_html);
           $(".modal-body").find(".ant-form-item :eq(1)").nextAll().remove();

           var jia_html = "";

           for(var k = 1; k <=num; k++)
           {

               jia_html +="<div class='ant-form-item' style=line-height:30px;>";
               jia_html +="<div class='ant-form-item-label' style=float:left;>";
               jia_html += "<label style=float:right;line-height:30px;>第"+k+"天:</label>";
               jia_html += "</div>";
               jia_html +="<div class='col-md-10 select_schedule' style='float:left;'>"
               jia_html +="<select name='schedule_period[]'>"

               $(".ant-tag-blue-period").find("span").each(function () {
                   var id = $(this).attr("data-id");
                   var name = $(this).text();

                   jia_html += "<option value=" + id + ">" + name + "</option>";

               });
               jia_html+="<option value='0'>休息</option>";
               jia_html +="</select>"
               jia_html +="</div>";
               jia_html +="</div>";

           }
           $(".modal-body").append(jia_html);





           $(".scheduling").val(schedulingid);

           $(".scheduling-period-table").append(table_html);
       }

  }

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

    function rtrim(s) {
        var lastIndex = s.lastIndexOf(',');
        if (lastIndex > -1) {
            s = s.substring(0, lastIndex);
        }
        return s;
    }

    function teacher_search() {
        var teacher_html = "";
        var teacher_name = $(".teacher_search").val();

        var att_type = $(".att_type").val();
        if (att_type == 1) {
            var teacher_id = $(".att_userid").val();
        } else {
            var teacher_id = $(".no_att_userid").val();
        }
        $(".selector_main").children().remove();

        if (teacher_name){
            $.getJSON("/weixiaotong2016/index.php?g=teacher&m=TeacherScheduleSelect&a=get_teacher_name&teacher_name=" + teacher_name, {}, function (data) {
                if (data.status == "success") {
                    teacher_html = "<div class=selector_main style='padding: 0px 11px; font-size: 12px;'>"
                    var teacher_arr = data.data;

                    for (var i = 0; i < teacher_arr.length; i++) {
                        var name = teacher_arr[i]['name'];
                        var id = teacher_arr[i]['id'];
                        if (teacher_id.indexOf(id) > -1) {
                            var check = "checked";
                        } else {
                            var check = "";
                        }

                        teacher_html += "<li>";
                        teacher_html += "<label><input id='teacher_"+id+"' type='checkbox' data-type = 2 onclick=javascript:checknode(this); style='vertical-align:-3px;' name='teacher[]' value=" + id + " " + check + "></label>";
                        teacher_html+="<label for='teacher_"+id+"' style='font-weight:normal;font-size: 14px;'>"+name+"</label>";
                        //department_html+="<span style='color:rgb(56, 173, 255); float: right;cursor: pointer' onclick='sub_level("+department[i]['id']+")'>下级</span>";
                        teacher_html += "</li>";
                    }

                    $(".selector_main").append(teacher_html);

//                for(var key in data.data){
//                    $(".newbox").append("<div class=gra_cla>"+"<input type=checkbox id=test name=test value="+data.data[key]["id"]+">"+data.data[key]["name"]+"</div>");
//                }
//                $.getJSON("/weixiaotong2016/index.php?g=teacher&m=Group&a=teacher_in&de_id="+de_id,{},function(date){
//                    if(date.statues=="success"){
//                        for(var words in date.date){
//                            var t_cla=date.date[words]["teacher_id"];
//                            var boxes = document.getElementsByName("test");
//                            for(i=0;i<boxes.length;i++){
//                                if(boxes[i].value == t_cla){
//                                    boxes[i].checked = true;
//                                    break
//                                }
//                            }
//                        }
//                    }
//                });
                }


            })
        }else{
            if(att_type==1)
            {
                get_person(0,1);
            }else{
                get_person(0,2);
            }

        }

    }

    //1为参与考勤人 2为无需考勤人员 3为考勤组负责人
    function get_person(att_val,type)
    {

        $("#timeinput").val("");

        //获取分组id
        var groupid =$(".att_group").val();

        $(".att_type").val(type);

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('get_group');?>",
            data: {
            },

            success: function(res) {
                if(res.status) {
                    $(".get_back").css("color", "black");
                    $(".get_back").css("cursor", "");
                    $(".get_back").removeAttr("onclick");
                    $(".selector_main").children().remove();
                    $(".person_body").children().remove();
                    if (type == 1) {


                        if (groupid.indexOf("1") > -1) {

                            var geren = "style='color:grey;float: right;'";
                            var checked = "checked";
                        } else {
                            var geren = "style='color:rgb(56, 173, 255); float: right;cursor: pointer' onclick='sub_level(1,2)'"
                        }
                    }
                    var one_person = "";
                    //只有参与考勤人员需要复选框
                    var checkbox = "";
                    if(type==1)
                    {
                        var checkbox = "<input type='checkbox' style='vertical-align:-3px;width: 10px;height: 11px;' data-type='1' onclick=javascript:checknode(this); name='one_person[]' value=1 "+checked+">";
                    }else{
                        var checkbox = "";
                    }
                    if(type==2)
                    {
                        var geren = "style='color:rgb(56, 173, 255); float: right;cursor: pointer' onclick='sub_level(1,2)'"
                    }
                    one_person+="<li >";
                    one_person+="<label>"+checkbox+"</label>";
                    one_person+="<label for='geren_check' style='font-weight:normal;font-size: 14px;'>个人</label>";
                    one_person+="<span "+geren+">下级</span>";
                    one_person+="</li>";

                    $(".student_num").show();
                    var department = res.department;
                    var teacher_info = res.teacher_info;


                    //遍历分组
                    var department_html = "";
                    for(var i = 0; i<department.length; i++)
                    {


                        if(type==1)
                        {
                            var fen_checkbox = "<input type='checkbox' style='vertical-align:-3px;width: 10px;height: 11px;' data-type='1' onclick=javascript:checknode(this); name='one_person[]' value="+department[i]['id']+" "+checked+">";
                            if(groupid.indexOf(department[i]['id']) > -1){
                                var fenzu = "style='color:grey;float: right;'";
                                var fen_checked = "checked";
                            }else{
                                var fenzu = "style='color:rgb(56, 173, 255); float: right;cursor: pointer' onclick='sub_level("+department[i]['id']+",1)'"
                            }
                        }else{
                            fen_checkbox = "";
                            var fenzu = "style='color:rgb(56, 173, 255); float: right;cursor: pointer' onclick='sub_level("+department[i]['id']+",1)'"
                        }


                        department_html+="<li>";
                        department_html+="<label >"+fen_checkbox+"</label>";
                        department_html+="<label for='fenzu_"+department[i]['id']+"' style='font-weight:normal;font-size: 13px;'>"+department[i]['name']+"</label>";
                        department_html+="<span "+fenzu+">下级</span>";
                        department_html+="</li>";
                    }
                    $(".selector_main").append(department_html);
                    $(".selector_main").append(one_person);

                    get_check(att_val)

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


    }


    function get_check(val)
    {

        if(!val) {
            return false
        }

        if (val==1) {
            var groupid = $(".att_group").val();
            var userid = $(".att_userid").val();
        }

        if(val==2)
        {
            var userid = $(".no_att_userid").val();
        }
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('get_val');?>",
            data: {
                userid:userid,
                groupid:groupid,
            },

            success: function(res) {
                if(res.status)
                {
                    //获取分组
                    var group = res.group;
                    //获取老师
                    var teacher = res.teacher;


                    if(group) {

                        $(".selector_main input[type='checkbox']").each(function () {
                            $(this).attr("checked", false);
                            var id = $(this).val();
                            for (var i = 0; i < group.length; i++) {
                                if (id == group[i]['id']) {
                                    $(this).attr("checked", true);
                                }
                            }
                        });
                    }
                    //遍历数组;
                    each_arr(group,teacher,groupid);
                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

        function each_arr(group,teacher,groupid)
        {
            console.log(teacher);

            var group_html ="";
            var teacher_html = "";

            if(groupid) {

                if (groupid.indexOf("1") > -1) {
                    $(".selector_main input[type='checkbox']").each(function () {
                        if ($(this).val() == 1) {
                            $(this).attr("checked", true);
                        }

                    });
                    var ge_html = "";
                    ge_html += "<li style=margin-top: 5px;>";
                    ge_html += "<span>个人</span>";
                    ge_html += "<span style=float:right;cursor:pointer; data-type=1 data-id=1 onclick=sub_close(this,1)>×</span>"
                    ge_html += "</li>"
                    $(".person_body").append(ge_html);
                }

            }
            if(group) {
                for (var i = 0; i < group.length; i++) {
                    var group_name = group[i]['name'];
                    var group_id = group[i]['id'];
                    group_html += "<li style=margin-top: 5px;>";
                    group_html += "<span>" + group_name + "</span>";
                    group_html += "<span style=float:right;cursor:pointer; data-type=1 data-id=" + group_id + " onclick=sub_close(this," + group_id + ")>×</span>"
                    group_html += "</li>"
                }
            }

            if(teacher) {
                var teacher_html = "";
                for (var i = 0; i < teacher.length; i++) {
                    var teacher_name = teacher[i]['name'];
                    var teacher_id = teacher[i]['id'];
                    teacher_html += "<li style=margin-top: 5px;>";
                    teacher_html += "<span>" + teacher_name + "</span>";
                    teacher_html += "<span style=float:right;cursor:pointer; data-type=2 data-id=" + teacher_id + " onclick=sub_close(this," + teacher_id + ")>×</span>"
                    teacher_html += "</li>"


                }
            }
            $(".person_body").append(teacher_html);
            $(".person_body").append(group_html);
        }

    }

    function sub_level(id,type)
    {
        var att_type = $(".att_type").val();



        $(".get_back").css("color","#38adff");
        $(".get_back").css("cursor","pointer");
        if(att_type==1)
        {
            var userid = $(".att_userid").val();
            $(".get_back").attr("onclick","get_person(0,1);");
        }else if(att_type==2)
        {
            var userid = $(".no_att_userid").val();
            $(".get_back").attr("onclick","get_person(0,2);");
        }

        if(userid)
        {
            var teacher_arr = rtrim(userid).split(",");
        }




        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('get_person');?>",
            data: {
                id:id,
                type:type,
            },

            success: function(res) {
                if(res.status)
                {
                    $(".selector_main").children().remove();
//                    $(".student_num").show();
                    var teacher = res.data;
                    //遍历分组
                    var teacher_html = "";
                    for(var i = 0; i<teacher.length; i++) {
                        if (teacher_arr) {

                            for (var j = 0; j < teacher_arr.length; j++) {
                                if (teacher[i]['id'] == teacher_arr[j]) {

                                    var check = "checked";
                                    break;
                                } else {
                                    var check = "";
                                }
                            }
                        }
                      console.log(check);
                        teacher_html+="<li>";
                        teacher_html+="<label><input id='teacher_"+teacher[i]['id']+"' type='checkbox' data-type = 2 onclick=javascript:checknode(this); style='vertical-align:-3px;' name='teacher[]' value="+teacher[i]['id']+" "+check+"></label>";
                        teacher_html+="<label for='teacher_"+teacher[i]['id']+"' style='font-weight:normal;font-size: 14px;'>"+teacher[i]['name']+"</label>";
                        //department_html+="<span style='color:rgb(56, 173, 255); float: right;cursor: pointer' onclick='sub_level("+department[i]['id']+")'>下级</span>";
                        teacher_html+="</li>";
                    }

                    $(".selector_main").append(teacher_html);

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

    $(".x_quan").click(function(){

        var checked = $(this).attr("checked");

        if(checked) {
            var html = ""
            $(".selector_main input[type='checkbox']").each(function () {
                var name = $(this).parent().next().text();
                var id = $(this).val();
                var type = $(this).attr("data-type");
                var flag = true;
                $(this).attr("checked", true);
                $(".person_body li").each(function () {
                    if($(this).find("span:eq(1)").attr("data-id")==id)
                    {
                        flag = false;
                    }
                });
                if(flag)
                {
                    html +=  "<li style=margin-top: 5px;>";
                    html +="<span>"+name+"</span>";
                    html +="<span style=float:right;cursor:pointer; data-type="+type+" data-id="+id+" onclick=sub_close(this,"+id+")>×</span>"
                    html +="</li>"
                }

            });
            $(".person_body").append(html);
        }else{
            $(".selector_main input[type='checkbox']").each(function () {
                $(this).attr("checked", false);
                var id = $(this).val();
                var flag = true;
                $(".person_body li").each(function () {
                    if($(this).find("span:eq(1)").attr("data-id")==id)
                    {
                        $(this).remove();
                    }
                });



            });
        }

    })

    function checknode(obj)
    {
        var is_true = $(obj).attr("checked");
        var name  = $(obj).parent().next().text();
        var xia = $(obj).parent().next().next();

        var att_group = $(".att_group").val();
        var att_userid = $(".att_userid").val();
        var att_type = $(".att_type").val();


        var id = $(obj).val();
        var type = $(obj).attr("data-type")

        if(is_true)
        {
            if(type==1)
            {
                xia.removeAttr("style");
                xia.removeAttr("onclick");
                xia.attr("style","color:grey;float: right;");

                $(".att_group").val(att_group+id+",");
            }else{
                if(att_type==1)
                {
                    $(".att_userid").val(att_userid+id+",");
                }else if(att_type==2)
                {
                    var no_userid = $(".no_att_userid").val();

                    $(".no_att_userid").val(no_userid+id+",");
                }
//               $(".att_userid").val(att_userid+id+",");
            }

            var html = ""
            html +=  "<li style=margin-top: 5px;>";
            html +="<span>"+name+"</span>";
            html +="<span style=float:right;cursor:pointer; data-type="+type+" data-id="+id+" onclick=sub_close(this,"+id+")>×</span>"
            html +="</li>"


            $(".person_body").append(html);

        }else{

            if(type==1)
            {
                xia.removeAttr("style");
                xia.attr("style","color:rgb(56, 173, 255); float: right;cursor: pointer;");
                xia.attr("onclick","sub_level(1,2)");
            }

//            else{
//                $(".att_userid").val(att_userid+id+",");
//            }
//           alert("111");
            $(".person_body li").each(function () {


                if($(this).find("span:eq(1)").attr("data-id")==id)
                {
                    $(this).remove();
                }
            });
            var shuzi = id + ",";

            if(att_type ==1) {
                var xiazhi = att_group.replace(shuzi, "");

                var user = att_userid.replace(shuzi, "");

                $(".att_group").val(xiazhi);
                $(".att_userid").val(user);

            }else if(att_type==2)
            {

                var no_userid = $(".no_att_userid").val();
                var no_user = no_userid.replace(shuzi,"");
                $(".no_att_userid").val(no_user);
            }


        }

    }

    function sub_close(obj,id)
    {
        var type = $(obj).attr("data-type");
        var att_type = $(".att_type").val();

        var att_group = $(".att_group").val();
        var att_userid = $(".att_userid").val();
        var no_userid = $(".no_att_userid").val();
        var att_type = $(".att_type").val();
        $(obj).parent().remove();

        $(".selector_main input[type='checkbox']").each(function () {
            var xia = $(this).parent().next().next();
            if($(this).val()==id)
            {
                if(type==1)
                {
                    xia.removeAttr("style");
                    xia.attr("style","color:rgb(56, 173, 255); float: right;cursor: pointer;");
                    xia.attr("onclick","sub_level(1,2)");
                }
                $(this).attr("checked",false);

            }
        });

        var shuzi = id + ",";
        if(att_type ==1) {
            var xiazhi = att_group.replace(shuzi, "");

            var user = att_userid.replace(shuzi, "");

            $(".att_group").val(xiazhi);
            $(".att_userid").val(user);

        }else if(att_type==2)
        {
            var no_userid = $(".no_att_userid").val();
            var no_user = no_userid.replace(shuzi,"");
            $(".no_att_userid").val(no_user);
        }
    }

    $(".departments-display").click(function(){

        $(".student_num").show();

    })

    $(".person_confirm").click(function() {

        var att_type = $(".att_type").val();
        console.log(att_type);
//
        //考勤人员
        if (att_type == 1) {
            $(".departments-display").children().remove();
            var html = "";
            var groupid = "";
            var userid = "";
            $(".person_body li").each(function () {
                var name = $(this).find("span:eq(0)").text();

                var id = $(this).find("span:eq(1)").attr("data-id");
                if ($(this).find("span:eq(1)").attr("data-type") == 1) {

                    groupid += id + ",";
                } else {
                    userid += id + ",";
                }


                html += "<div class='ant-tag ant-tag-blue'>";
                html += "<span class=ant-tag-text>" + name + "</span>";
                html += "</div>";
            });
            $(".departments-display").append(html);

            var arr = $(".departments-display").find("div").length;
            if(arr > 0)
            {
                $(".departments-display").show();
                $(".part_att").hide()
            }else{
                $(".departments-display").hide();
                $(".part_att").show();
            }

            $(".student_num").hide();
            $(".att_group").val(groupid)
            $(".att_userid").val(userid)
        }
        //无需考勤人员
        if(att_type==2)
        {

            $(".no-departments-display").children().remove();

            var html = "";
            var groupid = "";
            var userid = "";
            $(".person_body li").each(function () {
                var name = $(this).find("span:eq(0)").text();

                var id = $(this).find("span:eq(1)").attr("data-id");

                userid += id + ",";


                html += "<div class='ant-tag ant-tag-blue'>";
                html += "<span class=ant-tag-text>" + name + "</span>";
                html += "</div>";
            });
            $(".no-departments-display").append(html);

            var arr = $(".no-departments-display").find("div").length;
            if(arr > 0)
            {
                $(".no-departments-display").show();
                $(".no_part_att").hide()
            }else{
                $(".no-departments-display").hide();
                $(".no_part_att").show();
            }

            $(".student_num").hide();
            $(".no_att_userid").val(userid)
        }



    })

    $("input[name='schedule']").click(function(){

        var id = $(this).val();
        if(id==1)
        {
            $(".fixation-div").css("display","block");
            $(".schedule-div").css("display","none");
            $(".scheduling-period").css("display","none");
        }else{
            $(".fixation-div").css("display","none");
            $(".schedule-div").css("display","block");
        }

    })

    function fixation_confirm()
    {

        if(fixation_type==1)
        {

            $(".fixation_schedule_main input[name='scheudle']").each(function () {
                if ($(this).attr("checked")) {

                    var name = $(this).parent().next().text();
                    var att_time = $(this).parent().next().next().text();
                    var id = $(this).val();
                    $(".fixation_schedule_main input[name='schedule_fixation[]']").remove();
                    $(".fixation-div table input[name='week[]']").each(function () {
                        var obj = $(this).parent().parent();
                        obj.find("td:eq(2)").text(name + ":" + " " + att_time);
                        obj.find("td:eq(2)").attr("data-id", id);
                        obj.find("td:eq(3) input").val(id);
                        obj.find("td:eq(0)").find("input").attr("checked",true);

                    });
                    $(".fixation-xiu").text(name);
                    $(".fixation-quan").attr("checked",true);
                }
            });


        }else {

            $(".fixation_schedule_main input[name='scheudle']").each(function () {

                if ($(this).attr("checked")) {

                    var name = $(this).parent().next().text();
                    var att_time = $(this).parent().next().next().text();
                    fixation_obj.find("td:eq(2)").text(name + ":" + " " + att_time);
                    fixation_obj.find("td:eq(2)").attr("data-id", $(this).val());
//                 fixation_obj.find("td:eq(3) input").remove();
                    fixation_obj.find("td:eq(3) input").val($(this).val())
                    fixation_obj.find("td:eq(0)").find("input").attr("checked", true);
                }
            });

        }
        $(".fixation_schedule_set").hide();

        $(".fixation_schedule_main input[name='scheudle']").attr("checked", false);
    }
    $(".fixation-div a").click(function(){
        fixation_obj = $(this).parent().parent();

        fixation_type = $(this).attr("data-type");

        $(".fixation_schedule_set").show();

        var scheduleid = $(this).parent().prev().attr("data-id");
        console.log(scheduleid);

        var input_length  =$(".fixation_schedule_main input").length

        $(".fixation_schedule_main input[name='scheudle']").each(function () {
            if($(this).val()==scheduleid)
            {
                $(this).attr("checked",true);
            }
        });

        if(input_length > 0)
        {
            return false;
        }

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('get_scheudle');?>",
            data: {

            },

            success: function(res) {
                if(res.status)
                {
                    var scheudle = res.data;

                    var html = "";

                    var checked = "";

                    for(var i = 0; i < scheudle.length; i++)
                    {
                        if(scheudle[i]['id']==scheduleid)
                        {
                            checked = "checked";
                        }

                        html+="<tr>";
                        html+="<td><input type=radio name=scheudle value="+scheudle[i]['id']+"  "+checked+"></td>";
                        html+="<td>"+scheudle[i]['name']+"</td>";
                        html+="<td>"+scheudle[i]['att_time']+"</td>";
                        html+="</tr>";
                    }
                    $(".fixation_schedule_main").append(html);

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


    })

    $(".student_num_guan").click(function(){

        var att_type = $(".att_type").val();

        $(".selector_main").children().remove();

        if(att_type==1)
        {
            $(".departments-display").children().remove();
            var html = "";
            var groupid = "";
            var userid = "";
            $(".person_body li").each(function () {
                var name = $(this).find("span:eq(0)").text();

                var id = $(this).find("span:eq(1)").attr("data-id");
                if ($(this).find("span:eq(1)").attr("data-type") == 1) {

                    groupid += id + ",";
                } else {
                    userid += id + ",";
                }


                html += "<div class='ant-tag ant-tag-blue'>";
                html += "<span class=ant-tag-text>" + name + "</span>";
                html += "</div>";
            });
            $(".departments-display").append(html);

            var arr = $(".departments-display").find("div").length;
            if(arr > 0)
            {
                $(".departments-display").show();
                $(".part_att").hide()
            }else{
                $(".departments-display").hide();
                $(".part_att").show();
            }

            $(".student_num").hide();
            $(".att_group").val(groupid)
            $(".att_userid").val(userid)
        }else if(att_type==2)
        {
            $(".no-departments-display").children().remove();

            var html = "";
            var groupid = "";
            var userid = "";
            $(".person_body li").each(function () {
                var name = $(this).find("span:eq(0)").text();

                var id = $(this).find("span:eq(1)").attr("data-id");

                userid += id + ",";


                html += "<div class='ant-tag ant-tag-blue'>";
                html += "<span class=ant-tag-text>" + name + "</span>";
                html += "</div>";
            });
            $(".no-departments-display").append(html);

            var arr = $(".no-departments-display").find("div").length;
            if(arr > 0)
            {
                $(".no-departments-display").show();
                $(".no_part_att").hide()
            }else{
                $(".no-departments-display").hide();
                $(".no_part_att").show();
            }

            $(".student_num").hide();
            $(".no_att_userid").val(userid)
        }

        $(".person_body").children().remove();
        $(".student_num").hide();



    });

    $(".fixation_schedule_guan").click(function(){

        $(".fixation_schedule_set").hide();

        $(".fixation_schedule_main input[name='scheudle']").attr("checked",false);


    })

    $(".fixation-div input[name='week[]']").click(function(){
        if(!$(this).attr("checked"))
        {
            $(this).parent().next().next().text("休息");
            $(this).parent().parent().find("td:eq(3) input").val(0);
            $(this).parent().next().next().removeAttr("data-id");

        }else{
            return false
        }

    })

    $(".fixation-quan").click(function(){
        if(!$(this).attr("checked"))
        {
            $(".fixation-xiu").text("休息");
            $(".fixation-div table input[name='week[]']").each(function () {
                var obj = $(this).parent().parent();
                obj.find("td:eq(2)").text("休息");
                obj.find("td:eq(2)").removeAttr("data-id");
                obj.find("td:eq(3) input").val(0);
                obj.find("td:eq(0)").find("input").attr("checked",false);
            });
        }else{
            return false
        }
    })

    function get_schedule(type)
    {
        if(!type) {
            $(".schedule_set").show();
        }
        var checked_length  =$(".scheduling_main input").length;
        if(checked_length > 0)
        {
            return false;
        }
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('get_scheudle');?>",
            data: {

            },

            success: function(res) {
                if(res.status)
                {
                    var scheudle = res.data;

                    var html = "";

                    for(var i = 0; i < scheudle.length; i++)
                    {
                        html+="<tr>";
                        html+="<td><input type=checkbox name=scheduling value="+scheudle[i]['id']+" onclick=scheduling_check(this)></td>";
                        html+="<td>"+scheudle[i]['name']+"</td>";
                        html+="<td>"+scheudle[i]['att_time']+"</td>";
                        html+="</tr>";
                    }
                    $(".scheduling_main").append(html);

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    }

    $(".scheduling_confirm").click(function(){
        var html  = "";
        var scheduleid = "";
        $(".scheduling-display").children().remove();
        $(".scheduling_main input[name='scheduling']").each(function () {

            var att_name = $(this).parent().next().text();
            var att_time = $(this).parent().next().next().text();
            if($(this).attr("checked"))
            {
                scheduleid += $(this).val() + ",";
                html += "<div class='ant-tag ant-tag-blue-period'>";
                html += "<span class=ant-tag-text data-id="+$(this).val()+">"+att_name+": "+att_time+"</span>";
                html += "</div>";
            }


        });
        $(".scheduling-display").append(html);

        var arr = $(".scheduling-display").find("div").length;
        if(arr > 0)
        {
            $(".scheduling-display").show();
            $(".scheduling_att").hide()
        }else{
            $(".scheduling-display").hide();
            $(".scheduling_att").show();
        }

//        $(".schedule_set").hide();

        $(".scheduling").val(scheduleid);



        show_scheduling();
        if(is_checknode_true())
        {
            if (confirm("确定从考勤组移除"+scheduling_name+"吗？因该班次已被设置了排班，移除后则需要从新排班")) {
                remove_att();
                //删除该班次

                $(".schedule_set").hide();
            }else{
            }
        }else{
            $(".schedule_set").hide();
        }

    });

    function remove_att()
    {
        $("#scheduling-period-div").hide();
        $(".scheduling_a").show();
        $(".schedule_period_id").val("");
        $(".scheduling-period-table").children().remove();
    }



    function is_checknode_true()
    {
        var schedule_id=  $(".schedule_period_id").val();


        var istrue = false;

        var id = ""

        $(".scheduling_main input[name='scheduling']").each(function () {

            if($(this).attr("checked"))
            {
                id+=$(this).val()+",";
            }

        })

        if(schedule_id)
        {
            schedule_id = schedule_id.substring(0, schedule_id.length - 1);
            var arr = schedule_id.split(",");
            for(var i =0; i<arr.length; i++)
            {
                if(arr[i]==0)
                {
                    continue;
                }

                if(id.indexOf(arr[i])==-1)
                {
                    return true;
                }

            }

        }
        return istrue;
    }


    function scheduling_check(obj)
    {
        if(!$(obj).attr("checked"))
        {

            scheduling_name = $(obj).parent().next().text();

        }
    }

    function show_scheduling()
    {
        var scheduling = $(".scheduling").val();
        if(scheduling)
        {
            $(".scheduling-period").show();
        }else{
            $(".scheduling-period").hide();
        }
    }
    function get_scheduling()
    {
        //获取已经选择的班次id
        var scheduleid = $(".scheduling").val();


        $(".schedule_set").show();
        $(".scheduling_main input[name='scheduling']").each(function () {

            if(scheduleid.indexOf($(this).val()) > -1)
            {
                $(this).attr("checked",true);
            }


        });


    }


    function get_schedule_set()
    {
        $(".scheduling-period-set").show();
        var schedule_id=  $(".schedule_period_id").val();



        if(schedule_id)
        {
            schedule_id = schedule_id.substring(0, schedule_id.length - 1);
            var arr = schedule_id.split(",");
        }
        $(".select_schedule select").empty();

        $(".select_schedule select").each(function(i){
            var select_obj = $(this);
            var html = "";
            if(arr)
            {
                var s_id = arr[i];

            }

            $(".ant-tag-blue-period").find("span").each(function () {
                var id = $(this).attr("data-id");
                var name = $(this).text();

                if(s_id==id)
                {

                    var select = "selected";
                }else{
                    var select = "";
                }

                html+="<option value="+id+" "+select+">"+name+"</option>";

            });
            if(s_id==0)
            {
                var select = "selected";
            }else{
                var select = "";
            }
            html+="<option value='0' "+select+">休息</option>";

            $(select_obj).append(html);

        })

    }



    function scheduling_period_div()
    {
        //周期名称
        var period_name = $(".period_name").val();

        //周期天数
        var num = $(".period_num").val();

        var table_html= "";

        var schedule_name = "";

        var schedule_id = "";

        $(".scheduling-period-table").children().remove();
        $(".select_schedule select").each(function(){

            schedule_name +=getStr($(this).find("option:selected").text(),":")+"-";
            schedule_id +=$(this).val()+",";
        })


        table_html+="<tr>"
        table_html+="<td>"+period_name+"</td>"
        table_html+="<td class='period-hide'><input type='hidden' class='schedule_period_id'><div title="+schedule_name.substring(0,schedule_name.length-1)+" style=overflow:hidden;white-space:nowrap;text-overflow:clip;width:110px;display:inline-block;text-overflow:ellipsis;>"+schedule_name.substring(0,schedule_name.length-1)+"</div></td>"
        table_html+="<td>"+num+"</td>"
        table_html+="<td><a onclick='get_schedule_set()'>设置</a></td>"
        table_html+="</tr>";

        $(".scheduling-period-table").append(table_html);
        $(".schedule_period_id").val(schedule_id);
//        $(".scheduling-period-div").show();
        $(".scheduling_a").hide();

    }

    function getStr(string,str){
        var str_before = string.split(str)[0];

        return str_before;
    }

    //明天过来做这里
    $(".jia").click(function(){
        var num_obj = $(this).prev();
        //获取框内的数字
        var num = $(this).prev().val();
        if(parseInt(num) >= 31)
        {
            alert("周期不能大于31天！");
            return false;
        }
        var jia_num = parseInt(num)+1;
        $(num_obj).val(jia_num);
        var jia_html = "";
        jia_html +="<div class='ant-form-item' style=line-height:30px;>";
        jia_html +="<div class='ant-form-item-label' style=float:left;>";
        jia_html += "<label style=float:right;line-height:30px;>第"+jia_num+"天:</label>";
        jia_html += "</div>";
        jia_html +="<div class='col-md-10 select_schedule' style='float:left;'>"
        jia_html +="<select name='schedule_period[]'>"

        var select_obj = $(this);
        $(".ant-tag-blue-period").find("span").each(function () {
            var id = $(this).attr("data-id");
            var name = $(this).text();

            jia_html += "<option value=" + id + ">" + name + "</option>";

        });
        jia_html+="<option value='0'>休息</option>";
        jia_html +="</select>"
        jia_html +="</div>";
        jia_html +="</div>";



        $(".modal-body").append(jia_html);





    })

    $(".jian").click(function(){
        var num_obj = $(this).next();
        //获取框内的数字
        var num = $(this).next().val();
        //获取总条数

        if(parseInt(num) <= 2)
        {
            alert("周期不能小于于2天！");
            return false;
        }

        $(num_obj).val(parseInt(num)-1);
        remove_select($(num_obj).val());

    });

    function searchRequest()
    {
        var teacher_name=$(".period_num").val();

        remove_select(teacher_name);
    }

    function remove_select(num)
    {

        if(isNaN(num))
        {
            alert("必须输入汉字！");
            return false;

        }

        if(num < 2)
        {
            alert("周期不能小于2天");
            return false
        }
        if(num >=31)
        {
            alert("周期不能大于31天");
            return false;
        }
        //获取总条数
        var item_length = $(".ant-form-item select")

        //减少
        var jian_num  = item_length.length-parseInt(num);
        console.log(jian_num);

        if(jian_num > 0)
        {
            for(var i = item_length.length-1; i>0; i--)
            {
                if(i==num-1)
                {
                    return false;
                }
                item_length.eq(i).parent().parent().remove();

            }
        }else{
            var jia_html = "";

            for(var j = 0; j < Math.abs(jian_num); j++)
            {
                item_length.length++;
                jia_html +="<div class='ant-form-item' style=line-height:30px;>";
                jia_html +="<div class='ant-form-item-label' style=float:left;>";
                jia_html += "<label style=float:right;line-height:30px;>第"+item_length.length+"天:</label>";
                jia_html += "</div>";
                jia_html +="<div class='col-md-10 select_schedule' style='float:left;'>"
                jia_html +="<select name='schedule_period[]'>"

                var select_obj = $(this);
                $(".ant-tag-blue-period").find("span").each(function () {
                    var id = $(this).attr("data-id");
                    var name = $(this).text();

                    jia_html += "<option value=" + id + ">" + name + "</option>";

                });
                jia_html+="<option value='0'>休息</option>";
                jia_html +="</select>"
                jia_html +="</div>";
                jia_html +="</div>";

            }
            $(".modal-body").append(jia_html);
        }
    }
    $(".scheduling_period_confirm").click(function(){

        var period_name = $(".period_name").val();

        var period_num = $(".period_num").val();

        if(!period_name)
        {
            layer.msg('周期名称不能为空！！', {
                icon: 2
                ,shade: 0.01,
            });
            return false;
        }
        if(!period_num)
        {
            layer.msg('周期天数不能为空！', {
                icon: 2
                ,shade: 0.01,
            });
            return false;
        }

        var period_num = $(".period_num").val();
        if(period_num >31)
        {
            alert("周期不能大于31");
            return false;
        }
        if(period_num < 2)
        {
            alert("周期不能小于2");
            return false;
        }


        scheduling_period_div();
        $("#scheduling-period-div").show();
        $(".scheduling-period-set").hide ();


    })

    $(".scheduling-period-set-guan").click(function(){
        $(".scheduling-period-set").hide();
    })
    $(".schedule_set_guan").click(function(){
        $(".schedule_set").hide();
    })
//    window.onload=function(){
//        $("#loading").hide();
//    }

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