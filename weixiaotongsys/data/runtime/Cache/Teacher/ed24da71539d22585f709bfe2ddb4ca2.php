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
    <link href="/weixiaotong2016/statics/simpleboot/css/fileinput_message.css" media="all" rel="stylesheet" type="text/css" />
    <!--<link href="/weixiaotong2016/statics/simpleboot/css/custom.css" media="all" rel="stylesheet" type="text/css" />-->
    <link href="/weixiaotong2016/statics/js/artDialog/skins/default.css" rel="stylesheet" />
    <script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
    <script src="/weixiaotong2016/statics/js/fileinput.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/fileinput_locale_zh.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/layer/layer.js" type="text/javascript"></script>
    <script src="/weixiaotong2016/statics/js/wind.js"></script>

    <style type="text/css">
        .col-auto {
            overflow: auto;
            _zoom: 1;
            _float: left;
        }

        .col-right {
            float: right;
            width: 30%;
            overflow: hidden;
            margin-left: 6px;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }

        .picList li {
            margin-bottom: 5px;
        }

        .touchlei {
            background-color: #eeeeee;
        }

        tr .pai,
        tr .pai2 {
            text-align: center;
            font-size: 14px;
            color: black;
        }

        tr .pai {
            background-color: #e2e2e2;
        }

        tr .pai2 {}

        .clearfix {
            clear: both;
        }

        .name {
            margin-right: 10px;
        }

        .dbzr {
            background-color: #61c881;
            color: white;
            text-align: center;
            padding: 0px 15px;
            float: left;
            border-radius: 8px;
        }

        .sic {
            width: 15px;
            margin-left: 5px;
            margin-top: -15px;
            cursor: pointer;
        }

        .daiban {
            border-bottom: 1px solid #dddddd;
        }

        .daike {
            width: 100px;
            text-align: center;
            line-height: 30px;
            float: left;
            border-bottom: 1px solid #dddddd;
        }

        .dailei {
            border: 1px solid #dddddd;
            border-bottom: none;
            font-weight: bold;
        }

        .banji {
            float: left;
            width: 20%;
            margin-bottom: 10px;
        }

        .banji input {
            margin-top: -2px;
            margin-right: 5px;
        }

        .subject {
            float: left;
            color: #03a9f4;
            margin-right: 15px;
            cursor: pointer;
        }

        .peizhi {
            color: #03a9f4;
        }

        .kecheng {
            color: #03a9f4;
            float: left;
            display: none;
            border: 1px solid #03a9f4;
            padding-left: 3px;
            padding-right: 3px;
            cursor: pointer;
        }

        .subinput {
            display: none;
        }

        .mr20 input{
            color: black;
        }
        .select_2{
            color: black;
            font-size: 14px;

        }

        .class{
            color: black;
            font-size: 14px;

        }

        .pager input{
            height: 11px;
        }
        .pager{
            margin-top: 0px;
            margin-bottom: 10px；
        }

        select{
            width: auto;
        }
        .title-txt {
            text-align: center;
            height: 30px;
            float: left;
            line-height: 30px;
            /*width: 80px;*/
        }
        /*table.gridtable .title-txt {*/
        /*text-align: right;*/
        /*width: 70px;*/
        /*}*/

        #sangcalender{
            z-index: 99999999;
        }
        #timeinput{
            float: left;
            border: medium none;
            background: transparent none repeat scroll 0% 0%;
            /*height: 30px;*/
            color: black;
            line-height: 30px;
            width: 186px;
            text-indent: 2px;
            font-size: 14px;
        }
        table.gridtable td {
            padding: 5px;
            background-color: #ffffff;
        }
        .drop-down{
            padding: 2px;
            background: transparent;
            width: 200px;
            font-size: 14px;
            color: black;
            height: 30px;
        }
        .leftTree {
            width: 25%;
            height: 600px;
            float: left;
        }
        #classTree{
            margin-top: 10px;
            border: 1px solid #d9d9d9;
            background: #fff;
            height: 600px;
            overflow-y: scroll;
            width: 85%;
            overflow-x: auto;
        }
        .rightTable{
            width: 60%;
            float: left;
            margin-left: 4%;
            margin-top: 10px;
            height: 540px;
            overflow-y: auto;
        }
        .stu_main_table{
            width: 100%;

            margin-top: 10px;

            overflow-y: auto;
        }

        #occupyTable td{
            width: 80px;
            cursor: pointer;
            text-align: center;
        }
        #occupyTable th{
            width: 80px;
            cursor: pointer;
            text-align: center;
        }
        #occupyTable tr td span {
            display: none;
        }
        #stu_table td{
            width: 80px;
            cursor: pointer;
            text-align: center;
        }
        #stu_table th{
            width: 80px;
            cursor: pointer;
            text-align: center;
        }
        #stu_table tr td span {
            display: none;
        }
        .class_time{
            overflow: hidden;
            white-space: nowrap;
            text-overflow: clip;
            width: 130px;
            display: inline-block;
            text-overflow: ellipsis;
        }
        #{
            border: 1px solid #dce4ec;
            float: left;
            background: transparent none repeat scroll 0% 0%;
            /* height: 30px; */
            color: black;
            line-height: 30px;
            width: 186px;
            text-indent: 2px;
            font-size: 14px
        }
    </style>
    <script>
        window.onload = function() {
            var sb = document.getElementById("tans");
            sb.onclick = function() {
                var tanboder = document.getElementById("tansboder");
            }
        }
    </script>
</head>

<body>
<div class="wrap jj">
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:30px; list-style:none;">
        <li class="">
            <a href="<?php echo U('index');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">选课-教务</a>
        </li>

        <li class="active">
            <a href="<?php echo U('teacher');?>" style="color:#1f1f1f; text-decoration:none; padding:10px 15px;">选课-教师</a>
        </li>



    </ul>
    <input type="hidden" class="school" value="<?php echo ($schoolid); ?>">
    <!--亲属信息start-->


    <!-- 模态框（Modal） -->

    <!--导入-->
    <div style=" background-color:rgba(0,0,0,0.7); width:100%; height:100%; position:absolute; display: none" class="show_class"  >
        <div style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

            <div>
                <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">学生调班选择</div>
                <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
            </div>
            <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">

                <div>
                    <p  class="">选择班级:</p>
                    <select class="class">
                        <?php if(is_array($class)): foreach($class as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
                    </select><br><br>






                    <!--     <form  action="<?php echo U('ImpUser');?>" method="post" enctype="multipart/form-data"> -->


                    <input type="submit" value="确定" class="btn btn-info del_class">&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-danger dao_close">取消</a>

                    <!-- </form> -->
                    </p>
                </div>

            </div>
            <div style=" margin-bottom:10px; margin-left:30px;">
                <span class="Sui"></span>
            </div>
            <!-- <div style=" margin-bottom:10px; margin-left:30px;">
            确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
        </div> -->
            <div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">


            </div>

            <!--关闭start-->
            <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="dao_close">
            <!--关闭end-->
        </div>
    </div>

    <!---->

    <div style=" background-color:rgba(0,0,0,0.7); width:100%; height:100%; position:absolute; display: none" class="student_drop"  >
        <div style=" width:400px; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">

            <div>
                <div style=" border:1px solid #dddddd; border-bottom:none; width:100px; text-align:center; line-height:30px;">学生退学原因</div>
                <div style=" border-bottom:1px solid #dddddd; margin-left:100px;"></div>
            </div>
            <div style=" margin-top:30px; margin-bottom:15px; margin-left:30px;" class="numberic">

                <div>
                    <p  class="">退学原因:</p>
                    <textarea  class="student_cause" name="" rows="4"></textarea>

                    <br><br>






                    <!--     <form  action="<?php echo U('ImpUser');?>" method="post" enctype="multipart/form-data"> -->


                    <input type="submit" value="确定" class="btn btn-info drop_student">&nbsp;&nbsp;&nbsp;
                    <a class="btn btn-danger drop_close">取消</a>

                    <!-- </form> -->
                    </p>
                </div>

            </div>
            <div style=" margin-bottom:10px; margin-left:30px;">
                <span class="Sui"></span>
            </div>
            <!-- <div style=" margin-bottom:10px; margin-left:30px;">
            确认卡号：<input type="text" placeholder="卡号长度10位数" style=" margin-top:8px; height:30px;">
        </div> -->
            <div style=" width:60px; margin-left:auto; margin-right:auto; margin-top:20px;">


            </div>

            <!--关闭start-->
            <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="drop_close">
            <!--关闭end-->
        </div>
    </div>



    <!--<?php echo ($html); ?>-->

    <div style=" background-color:rgba(0,0,0,0.7);    position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="daitan"  >
        <div style=" width:850px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
            <form id="form2" action="" method="post">
                <div id="top" style="width:100%;float:left;">

                    <input type="hidden" name="xuankeStrs" id="xuankeStrs">
                    <input type="hidden" name="classIds" id="classIds" value="">
                    <input type="hidden" name="ids" id="ids" value="">
                    <input type="hidden" name="semester" id="semester" value="">
                    <input type="hidden" name="selection" id="selection" value="<?php echo ($selection); ?>">
                    <input type="hidden" name="elective" id="elective" value="">


                    <table class="gridtable" align="left" style="margin-top: 20px;">
                        <tbody>
                        <tr>
                            <td class="title-txt"><span>学年</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="grade" id="grade" class="drop-down" onchange="getSetting();"><option value="">请选择学年</option><option value="2013-2014">2013-2014</option><option value="2014-2015">2014-2015</option><option value="2015-2016">2015-2016</option><option value="2016-2017">2016-2017</option><option value="2017-2018">2017-2018</option><option value="2018-2019">2018-2019</option><option value="2019-2020">2019-2020</option><option value="2020-2021">2020-2021</option><option value="2021-2022">2021-2022</option></select>
                                </div>
                            </td>
                            <td class="title-txt"><span>学期</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="term" id="term" class="drop-down" onchange="getSetting(this);" disabled="disabled">
                                        <option value="">请选择学期</option>
                                        <?php if(is_array($semester)): foreach($semester as $key=>$vo): $semester=$semesterid==$vo['id']?"selected":""; ?>
                                            <option value="<?php echo ($vo["id"]); ?>" <?php echo ($semester); ?>><?php echo ($vo["semester"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="title-txt"><span>课程</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="subject" id="subject" class="drop-down" onchange="getSubject(this);" disabled="disabled">
                                        <option value="">请选择课程</option>
                                        <?php if(is_array($subject)): foreach($subject as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["subject"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-txt"><span>老师</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="teacher" id="teacher" class="drop-down" onchange="getTeacher(this);" disabled="disabled">
                                        <option value="">不选择</option>
                                        <?php if(is_array($teacher)): foreach($teacher as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="title-txt"><span>上课地点</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="classroom" id="classroom" class="drop-down" onchange="getSetting(this);" disabled="disabled">
                                        <option value="">请选择教室</option>
                                        <?php if(is_array($semester)): foreach($semester as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["semester"]); ?></option><?php endforeach; endif; ?>
                                    </select>
                                </div>
                            </td>
                            <td class="title-txt"><span>人数</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <input type="text" name="sum" id="sum" style="border: 1px solid #dce4ec;    height: 16px;    width: 188px;" disabled="disabled">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="title-txt"><span>简介</span></td>
                            <td colspan="10"><textarea disabled="disabled" style="width: 98%;float: left;" rows="5"  name="courseIntroduce" id="courseIntroduce" placeholder="100个字以内的课程介绍....."></textarea></td>

                        </tr>
                        <tr><td colspan="10"><div class="beizu" style="color: red; display: none;">备注：只允许查看。</div></td></tr>
                        </tbody>
                    </table>



                </div>
                <div class="leftTree">
                    <div>
                        <div id="classMenuContent" class="optionDiv">
                            <ul id="classTree" class="ztree">

                            </ul>

                        </div>
                    </div>
                </div>
                <div class="rightTable">
                    <table id="occupyTable" border="1" cellpadding="2" cellspacing="0">
                        <tbody>

                        </tbody>
                    </table>
                </div>




            </form>

            <!--关闭start-->
            <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="xuanke_guan">
            <!--关闭end-->
        </div>
    </div>


    <div style=" background-color:rgba(0,0,0,0.7);    position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="student_manage"  >
        <div style=" width:700px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;">
            <form id="form3" action="" method="post">
                <div id="" style="width:100%;float:left;">

                    <input type="hidden" id="stu_elective">


                    <table class="gridtable" align="left" style="margin-top: 20px;">
                        <tbody>
                        <tr>

                            <td class="title-txt"><span>班级名称</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="class" id="class" class="drop-down" onchange="getSetting(this);" >

                                    </select>
                                </div>
                            </td>
                            <td class="title-txt"><span>学生姓名</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <input type="text" name="student_name" id="student_name" style="border: 1px solid #dce4ec;height: 16px;width: 188px;">
                                </div>
                            </td>
                            <td class="title-txt"><input type="button" value="搜&nbsp;索" style=" border:none; background-color:#26a69a; color:white; border-radius:3px; padding:5px 15px 5px 15px;" onclick='stu_search()'></td>
                        </tr>

                        <tr>
                            <td class="title-txt"><span>学生分类</span></td>
                            <td class="value-txt">
                                <div class="select_style">
                                    <select name="stu_type" id="stu_type" class="drop-down" onchange="getSubject(this);">
                                        <option value="">请选择</option>
                                        <option value="3">报名成功学生</option>
                                        <option value="2">审核中学生</option>
                                        <option value="1">可添加学生</option>

                                    </select>
                                </div>
                            </td>

                        </tr>
                        <tr><td colspan="10"><div class="beizu" style="color: red; display: none;">备注：班级和上课节次不允许修改，如要修改，请删除重开。</div></td></tr>
                        </tbody>
                    </table>



                </div>

                <div class="stu_main_table" style="text-align: center;">
                    <div class="stu_main"></div>

                </div>



                <div class="pagination" ">


        </div>
        </form>

        <!--关闭start-->
        <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="manage_guan">
        <!--关闭end-->
    </div>
</div>

<div style=" background-color:rgba(0,0,0,0.7);    position: fixed; top: 0;right: 0;bottom: 0; left: 0;z-index: 1040; display: none;" class="student_num"  >
    <div style=" width:450px;height: 400px;overflow: auto; background-color:white; margin-left:auto; margin-right:auto; margin-top:5%; padding:20px; position:relative;" class="">
        <form id="form3" action="" method="post">
            <div id="" style="width:100%;float:left;">




                <table class="stu_num_table"  style="margin-top: 20px;width: 400px;">
                    <tbody>




                    </tbody>
                </table>



            </div>

            <!--<div class="stu_main_table" style="text-align: center;">-->
            <!--<div class="stu_main"></div>-->

            <!--</div>-->

            <div class="layui-layer-btn layui-layer-btn-" style="position:absolute;;right:0;bottom:0;"><a class="layui-layer-btn0" >提交</a><a class="layui-layer-btn1">关闭</a></div>
            <input type="hidden" name="electiveid" id="electiveid">

        </form>

        <!--关闭start-->
        <img src="/weixiaotong2016/statics/images/cha.png" style=" position:absolute; top:20px; right:20px; width:15px; height:15px; cursor:pointer;" class="stu_num_guan">
        <!--关闭end-->
    </div>
</div>


<div id="myTabContent" class="tab-content" style=" padding-left:30px; padding-right:30px;">
    <div class="tab-pane fade in active" id="home">
        <br/>
        <form class="form-horizontal J_ajaxForm" action="<?php echo u('teacher');?>" method="get" style="margin: 0px 0px 5px;">
            <div class="search_type cc mb10">
                <div class="mb10">
								<span class="mr20">
                      课程:
                      <select class="select_2" name="subject" style=" height: 30px" id="subject">
                        <option value='0'>请选择</option>
                        <?php if(is_array($subject)): foreach($subject as $key=>$vo): $subject_info=$subjectid==$vo['id']?"selected":""; ?>
                            <OPTION value="<?php echo ($vo["id"]); ?>" <?php echo ($subject_info); ?>><?php echo ($vo["subject"]); ?></OPTION><?php endforeach; endif; ?>
                      </select> &nbsp;&nbsp;
                            老师:
                                    <input type="text" class="teacher_name" value="<?php echo ($teacher_name); ?>" name="teacher_name" placeholder="-教师姓名-" style="width: 90px; height: 17px;border-width:1px;" >


                      <input type="submit" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px;" value="搜索" />
                       <input type="button"  value="添加设置" style=" border:none; background-color:#26a69a; color:white; border-radius:5px; padding:5px 10px 5px 10px; cursor: pointer;" class="drop" >
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
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">学期</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">课程名</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">老师姓名</th>

                    <th class="pai" style=" border-left: none;border-width: 0.5px;">上课地点</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">上课时间</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">人数</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">已报</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">待审核</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">剩余</th>
                    <th class="pai" style=" border-left: none;border-width: 0.5px;">操作</th>
                </tr>
                </thead>
                <?php if(is_array($elective)): foreach($elective as $key=>$vo): ?><tr>
                        <td class="pai2"><?php echo ($vo["semester"]); ?></td>
                        <td class="pai2 stuname"><?php echo ($vo["subject"]); ?></td>
                        <td class="pai2 stuid" ><?php echo ($vo["name"]); ?></td>


                        <td class="pai2" width="100">教室</td>
                        <td class="pai2" width="100" title="<?php echo ($vo["class_time"]); ?>"><div class="class_time"><?php echo ($vo["class_time"]); ?></div></td>
                        <td class="pai2" width="100"><?php echo ($vo["num"]); ?></td>
                        <td class="pai2" width="100"><?php echo ($vo["singup"]); ?></td>
                        <td class="pai2" width="100"><?php echo ($vo["audit"]); ?></td>
                        <td class="pai2" width="100"><?php echo ($vo["remain"]); ?></td>
                        <td class="pai2">
                            <a  style=" color:#00c1dd;cursor: pointer;" onclick="edit(<?php echo ($vo["id"]); ?>,<?php echo ($vo["selection"]); ?>)">
                                查看
                            </a>

                            <a  onclick="student_num(this,<?php echo ($vo["id"]); ?>)" style=" color:#00c1dd; cursor: pointer;">
                                人数管理
                            </a>
                            <a  style=" color:#00c1dd;cursor: pointer;" onclick="stu_mange(<?php echo ($vo["id"]); ?>)"style=" color:#00c1dd;">
                                学生管理
                            </a>
                            <!--<a  style=" color:#00c1dd;cursor: pointer;" onclick="edit(<?php echo ($vo["id"]); ?>)">-->
                                <!--删除-->
                            <!--</a>-->
                        </td>


                    </tr><?php endforeach; endif; ?>
                <?php if(is_array($selection1)): foreach($selection1 as $key=>$vo): ?><tr>
                        <td class="pai2"><input type="checkbox" data-class = "<?php echo ($vo["classid"]); ?>" class="J_check" value="<?php echo ($vo["userid"]); ?>" id='sel_all' name="ids" ></td>
                        <td class="pai2 stuname"><?php echo ($vo["stu_name"]); ?></td>
                        <td class="pai2 stuid" ><?php echo ($vo["stu_id"]); ?></td>


                        <td class="pai2" width="100"><?php echo ($vo["phone"]); ?></td>
                        <td class="pai2"><?php echo ($vo["in_residence"]); ?></td>
                        <td class="pai2"><?php echo ($vo["classname"]); ?></td>

                        <td class="pai2"><?php echo ($vo["kaitong"]); ?></td>
                        <!-- 	<td class="pai2">
                                <a href="<?php echo U('delete',array('id'=>$vo['userid']));?>" class="J_ajax_del" style=" color:#00c1dd;">
                                    <?php if($vo['stu_count'] != 0): elseif($vo['stu_count'] == 0): ?> 删除<?php endif; ?>
                                </a>
                                <input type="hidden" value="<?php echo ($vo["address"]); ?>">
                                <a data-id = '<?php echo ($vo["userid"]); ?>' data-sex = '<?php echo ($vo["sex"]); ?>'  data-target="#myModal3" data-toggle="modal"  class="edit" href="<?php echo U('change',array('id'=>$vo['userid']));?>" style=" color:#00c1dd;">
                                     修改
                                </a>
                                <a href="#" class="daibanzhuren1" style=" color:#00c1dd;"><input type="hidden" value="<?php echo ($vo["userid"]); ?>">亲属信息</a>
                            </td> -->
                    </tr><?php endforeach; endif; ?>
            </table>


        </div>
    </form>


    <input class="uisid" type="hidden" />

</div>
</div>
<div class="tab-pane fade" id="ios">

</div>
<div class="pager"><?php echo ($Page); ?></div>

</div>
<script type="text/javascript" src="/weixiaotong2016/statics/js/datetime.js"></script>
<script src="/weixiaotong2016/statics/js/common.js"></script>
<script type="text/javascript">
    //全局变量
    var GV = {
        DIMAUB: "/",
        JS_ROOT: "statics/js/",
        TOKEN: ""
    };
</script>
<script>


    var ajaxForm_list = $('form.J_ajaxFsorm');
    if (ajaxForm_list.length) {
        Wind.use('ajaxForm', 'artDialog', function () {
            if ($.browser.msie) {
                //ie8及以下，表单中只有一个可见的input:text时，会整个页面会跳转提交
                ajaxForm_list.on('submit', function (e) {
                    //表单中只有一个可见的input:text时，enter提交无效
                    e.preventDefault();
                });
            }

            $('button.J_ajax_submit_btn').bind('click', function (e) {
                e.preventDefault();
                /*var btn = $(this).find('button.J_ajax_submit_btn'),
                 form = $(this);*/
                var btn = $(this),
                    form = btn.parents('form.J_ajaxForm');

                //批量操作 判断选项
                if (btn.data('subcheck')) {
                    btn.parent().find('span').remove();
                    if (form.find('input.J_check:checked').length) {
                        var msg = btn.data('msg');
                        if (msg) {
                            art.dialog({
                                id: 'warning',
                                icon: 'warning',
                                content: btn.data('msg'),
                                cancelVal: '关闭',
                                cancel: function () {
                                    btn.data('subcheck', false);
                                    btn.click();
                                }
                            });
                        } else {
                            btn.data('subcheck', false);
                            btn.click();
                        }

                    } else {
                        $('<span class="tips_error">请至少选择一项</span>').appendTo(btn.parent()).fadeIn('fast');
                    }
                    return false;
                }

                //ie处理placeholder提交问题
                if ($.browser.msie) {
                    form.find('[placeholder]').each(function () {
                        var input = $(this);
                        if (input.val() == input.attr('placeholder')) {
                            input.val('');
                        }
                    });
                }

                form.ajaxSubmit({
                    url: btn.data('action') ? btn.data('action') : form.attr('action'),
                    //按钮上是否自定义提交地址(多按钮情况)
                    dataType: 'json',
                    beforeSubmit: function (arr, $form, options) {
                        var text = btn.text();

                        //按钮文案、状态修改
                        btn.text(text + '中...').attr('disabled', true).addClass('disabled');
                    },
                    success: function (data, statusText, xhr, $form) {
                        var text = btn.text();

                        //按钮文案、状态修改
                        btn.removeClass('disabled').text(text.replace('中...', '')).parent().find('span').remove();

                        if (data.state === 'success') {
                            $('<span class="tips_success">' + data.info + '</span>').appendTo(btn.parent()).fadeIn('slow').delay(1000).fadeOut(function () {
                                if (data.referer) {
                                    //返回带跳转地址
                                    if (window.parent.art) {
                                        //iframe弹出页
                                        window.parent.location.href = data.referer;
                                    } else {
                                        window.location.href = data.referer;
                                    }
                                } else {
                                    if (window.parent.art) {
                                        reloadPage(window.parent);
                                    } else {
                                        //刷新当前页
                                        reloadPage(window);
                                    }
                                }
                            });
                        } else if (data.state === 'fail') {
                            $('<span class="tips_error">' + data.info + '</span>').appendTo(btn.parent()).fadeIn('fast');
                            btn.removeProp('disabled').removeClass('disabled');
                        }
                    }
                });
            });

        });
    }
    $(document).ready(function () {
        Wind.css('treeTable');
        Wind.use('treeTable', function () {
            $("#dnd-example").treeTable({
                indent: 20
            });
        });
    });

    $(document).on("click",".pagination a",function(){

        var beatlesJohn = {
            1: '通过',
            2: '审核',
            3: '删除',

        };
        //return false;
        $.getJSON($(this).attr('href'),function(data){
            console.log(data);
            setTimeout(function(){
                layer.closeAll('loading');
            });
            $("#stu_table").remove();
            $(".pagination").children().remove();


            if(!data.status){
                // console.log('aaa');
                $(".stu_main").append('<table><tr><td>没有数据!</td></table>');
            }
            var adata = data.data;

            var html=""
            html +="<table id='stu_table' border='1' cellpadding='2' cellspacing='0' style=' margin: 0 auto;'>";
            html += "<tr>";
            html += "<th>姓名</th>";
            html += "<th>班级</th>";
            html += "<th>状态</th>";
            html += "<th>操作</th>";
            html += "</tr>";
            for(var i = 0; i< adata.length; i++)
            {
                if(i==0)
                {
                    $(".pagination").append(adata[i]);
                    $(".pagination").find("a").last().nextAll().remove();

                    continue
                    //return false;
                }
                html +="<tr>";
                html +="<td>"+adata[i]['stu_name']+"</td>";
                html +="<td>"+adata[i]['classname']+"</td>";
                html +="<td>"+beatlesJohn[adata[i]['type']]+"</td>";
                console.log(adata[i]['type']);
                var add_style ="";
                var add_attr ="";
                var del_style ="";
                var del_attr ="";
                if(adata[i]['type']==1 || adata[i]['type']==2)
                {

                    add_style ="style=color:#00c1dd;cursor:pointer;";
                    add_attr ="onclick=select_type(this,"+adata[i]['id']+","+adata[i]['type']+")";
                    del_style ="style=color:gray;text-decoration:line-through;";
                }
                if(adata[i]['type']==3){
                    add_style ="style=color:gray;text-decoration:line-through;";
                    del_style ="style=color:#00c1dd;cursor:pointer;";
                    del_attr ="onclick=select_type(this,"+adata[i]['id']+","+adata[i]['type']+")";
                }

                html +="<td><a   "+add_style+"  "+add_attr+" >添加</a> <a "+del_style+" "+del_attr+">删除</a></td>";

                html +="</tr>";

            }
            html +="</table>";
            $(".stu_main").append(html);





        })
        return false;

    })

    //    $(document).keydown(function(event){
    //        if(event.keyCode==13){
    //           alert("11");
    //        }
    //    });


    $(document).on("keydown",".pagination input",function(event) {

        if(event.keyCode==13) {
            alert("22");
        }

//        return false;
        var beatlesJohn = {
            1: '通过',
            2: '审核',
            3: '删除',

        };
        //return false;
        $.getJSON($(this).attr('href'), function (data) {
            console.log(data);
            setTimeout(function () {
                layer.closeAll('loading');
            });
            $("#stu_table").remove();
            $(".pagination").children().remove();


            if (!data.status) {
                // console.log('aaa');
                $(".stu_main").append('<table><tr><td>没有数据!</td></table>');
            }
            var adata = data.data;

            var html = ""
            html += "<table id='stu_table' border='1' cellpadding='2' cellspacing='0' style=' margin: 0 auto;'>";
            html += "<tr>";
            html += "<th>姓名</th>";
            html += "<th>班级</th>";
            html += "<th>状态</th>";
            html += "<th>操作</th>";
            html += "</tr>";
            for (var i = 0; i < adata.length; i++) {
                if (i == 0) {
                    $(".pagination").append(adata[i]);
                    cosnoel.log($(".pagination").children("a:last-child"))
                    continue
                    //return false;
                }
                html += "<tr>";
                html += "<td>" + adata[i]['stu_name'] + "</td>";
                html += "<td>" + adata[i]['classname'] + "</td>";
                html += "<td>" + beatlesJohn[adata[i]['type']] + "</td>";
                console.log(adata[i]['type']);
                var add_style = "";
                var add_attr = "";
                var del_style = "";
                var del_attr = "";
                if (adata[i]['type'] == 1 || adata[i]['type'] == 2) {

                    add_style = "style=color:#00c1dd;cursor:pointer;";
                    add_attr = "onclick=select_type(this," + adata[i]['id'] + "," + adata[i]['type'] + ")";
                    del_style = "style=color:gray;text-decoration:line-through;";
                }
                if (adata[i]['type'] == 3) {
                    add_style = "style=color:gray;text-decoration:line-through;";
                    del_style = "style=color:#00c1dd;cursor:pointer;";
                    del_attr = "onclick=select_type(this," + adata[i]['id'] + "," + adata[i]['type'] + ")";
                }

                html += "<td><a   " + add_style + "  " + add_attr + " >添加</a> <a " + del_style + " " + del_attr + ">删除</a></td>";

                html += "</tr>";

            }
            html += "</table>";
            $(".stu_main").append(html);


        })
        return false;

    })



    function stu_search()
    {
        var id =  $("#stu_elective").val();
        if(!id)
        {
            alert("数据有误!");
            return false
        }
        var classid = $("#class").val();
        var student_name = $("#student_name").val();
        var stu_type = $("#stu_type").val();

        $("#stu_table").remove();
        $(".pagination").children().remove();

        $.ajax({
            type: "get",
            url: "<?php echo U('XuanAddStu');?>",
            dataType: 'json',
            data: {
                electiveid:id,//学期ID
                classid:classid,
                student_name:student_name,
                stu_type:stu_type,

            },
            success: function(res){
                if(res.status){

                    var adata = res.data;

                    var beatlesJohn = {
                        1: '通过',
                        2: '审核',
                        3: '删除',
                        4: '已添加其他课程',

                    };
                    var html=""
                    html +="<table id='stu_table' border='1' cellpadding='2' cellspacing='0' style=' margin: 0 auto;'>";
                    html += "<tr>";
                    html += "<th>姓名</th>";
                    html += "<th>班级</th>";
                    html += "<th>状态</th>";
                    html += "<th>操作</th>";
                    html += "</tr>";
                    for(var i = 0; i< adata.length; i++)
                    {
                        if(i==0)
                        {
                            $(".pagination").append(adata[i]);
                            $(".pagination").find("a").last().nextAll().remove();
                            continue
                            //return false;
                        }
                        html +="<tr>";
                        html +="<td>"+adata[i]['stu_name']+"</td>";
                        html +="<td>"+adata[i]['classname']+"</td>";
                        html +="<td>"+beatlesJohn[adata[i]['type']]+"</td>";

                        var add_style ="";
                        var add_attr ="";
                        var del_style ="";
                        var del_attr ="";
                        if(adata[i]['type']==1 || adata[i]['type']==2)
                        {
                            add_style ="style=color:#00c1dd;cursor:pointer;";
                            add_attr ="onclick=select_type(this,"+adata[i]['id']+","+adata[i]['type']+")";
                            del_style ="style=color:gray;text-decoration:line-through;";
                        }
                        if(adata[i]['type']==3){
                            add_style ="style=color:gray;text-decoration:line-through;";
                            del_style ="style=color:#00c1dd;cursor:pointer;";
                            del_attr ="onclick=select_type(this,"+adata[i]['id']+","+adata[i]['type']+")";
                        }
                        if(adata[i]['type']==4)
                        {
                            add_style ="style=color:gray;text-decoration:line-through;";
                            del_style ="style=color:gray;text-decoration:line-through;";
                        }

                        html +="<td><a   "+add_style+"  "+add_attr+" >添加</a> <a "+del_style+" "+del_attr+">删除</a></td>";
                        html +="</tr>";

                    }
                    html +="</table>";

                    $(".stu_main").append(html);
                }else{
                    alert(res.msg);
//                    history.go(0);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }


    //学生管理
    //学生管理
    function stu_mange(id)
    {

        if(!id)
        {
            alert("数据有误!");
            return false
        }
        $(".student_manage").show();
        $("#class").empty();

        $.ajax({
            type: "get",
            url: "<?php echo U('XuanAddStu');?>",
            dataType: 'json',
            data: {
                electiveid:id,//学期ID

            },
            success: function(res){
                if(res.status){
                    $("#stu_elective").val(id);
                    var adata = res.data;

                    var beatlesJohn = {
                        1: '通过',
                        2: '审核',
                        3: '删除',
                        4: '已添加其他课程',

                    };
                    var html=""
                    html +="<table id='stu_table' border='1' cellpadding='2' cellspacing='0' style=' margin: 0 auto;'>";
                    html += "<tr>";
                    html += "<th>姓名</th>";
                    html += "<th>班级</th>";
                    html += "<th>状态</th>";
                    html += "<th>操作</th>";
                    html += "</tr>";
                    for(var i = 0; i< adata.length; i++)
                    {
                        if(i==0)
                        {
                            $(".pagination").append(adata[i]);
                            $(".pagination").find("a").last().nextAll().remove();
                            continue
                            //return false;
                        }
                        html +="<tr>";
                        html +="<td>"+adata[i]['stu_name']+"</td>";
                        html +="<td>"+adata[i]['classname']+"</td>";
                        html +="<td>"+beatlesJohn[adata[i]['type']]+"</td>";

                        var add_style ="";
                        var add_attr ="";
                        var del_style ="";
                        var del_attr ="";
                        if(adata[i]['type']==1 || adata[i]['type']==2)
                        {
                            add_style ="style=color:#00c1dd;cursor:pointer;";
                            add_attr ="onclick=select_type(this,"+adata[i]['id']+","+adata[i]['type']+")";
                            del_style ="style=color:gray;text-decoration:line-through;";
                        }
                        if(adata[i]['type']==3){
                            add_style ="style=color:gray;text-decoration:line-through;";
                            del_style ="style=color:#00c1dd;cursor:pointer;";
                            del_attr ="onclick=select_type(this,"+adata[i]['id']+","+adata[i]['type']+")";
                        }
                        if(adata[i]['type']==4)
                        {
                            add_style ="style=color:gray;text-decoration:line-through;";
                            del_style ="style=color:gray;text-decoration:line-through;";
                        }

                        html +="<td><a   "+add_style+"  "+add_attr+" >添加</a> <a "+del_style+" "+del_attr+">删除</a></td>";
                        html +="</tr>";

                    }
                    html +="</table>";
                    $("#class").append("<option value=>"+"请选择班级"+"</option>");
                    for(var i = 0; i < res.class.length; i++) {
                        var class_name = res.class[i]['classname']; //学校的名字
                        var classid = res.class[i]['id']; //学校的ID

                        $("#class").append("<option value="+classid+"  >"+class_name+"</option>");


                    }
                    $(".stu_main").append(html);
                }else{
                    alert(res.msg);
//                    history.go(0);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

    }

    //人数管理
    function student_num(obj,electiveid)
    {

        $.ajax({
            type: "get",
            url: "<?php echo U('ClassNum');?>",
            dataType: 'json',
            data: {
                electiveid:electiveid,//选修表id
            },
            success: function(res){
                if(res.status){
                    $(".student_num").show();
                    $(".stu_num_table").children().remove();
                    var adata = res.data;


                    var html = "";
                    html +="<tr>";
                    html +="<td colspan=10><blockquote class=layui-elem-quote >该选修课总人数:<span class=stu_sum><span></blockquote><td>"
                    html +="<tr>";
                    for(var i =0; i<adata.length; i++)
                    {
                        html +="<tr>";
                        html +="<td class=title-txt><span>年级</span></td>";
                        html +="<td class=value-txt><div><input disabled style='border:1px solid #dce4ec;height:16px;width:188px;color:black' type='text' value="+adata[i]['classname']+"></div></td>";
                        html +="</tr>";
                        html +="<tr>";
                        html +="<td class=title-txt><span>人数设置</span></td>";
                        if(!adata[i]['num'])
                        {
                            adata[i]['num'] = '';
                        }
                        html +="<td class=value-txt><div><input class='class_num' name="+adata[i]['classid']+" style='border:1px solid #dce4ec;height:16px;width:60px;color:black;'  type='text' value="+adata[i]['num']+"></div></td>";
                        html +="</tr>";

                    }
                    $("#electiveid").val(res.electiveid);
                    $(".stu_num_table").append(html);
                    $(".stu_sum").text($(obj).parent().parent().find("td:eq(5)").text());
                }else{
                    alert(res.msg);

                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }
    $(".layui-layer-btn0").click(function(){

        var electiveid = $("#electiveid").val();
        console.log(electiveid);
        var lennon = {};
        $(".stu_num_table .class_num").each(function(){
            var classname = $(this).attr("name");
            console.log(classname);

            var num = $(this).val();
            lennon[classname] = num;

        });


        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('editClassNum');?>",
            data: {
                electiveid: electiveid,
                class_num: lennon,
            },

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    $(".student_num").hide();

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });

//  console.log(lennon);
    });
    $(".stu_num_guan").click(function(){
        $(".student_num").hide();

        $(".stu_num_table").children().remove();
    })
    $(".layui-layer-btn1").click(function(){
        $(".student_num").hide();

        $(".stu_num_table").children().remove();
    })

    function select_type(obj,selectid,type)
    {


        if(type==1 || type == 2)
        {
            var s_type = 3;
        }else{
            var s_type = 1;
        }

        $.ajax({
            type: "get",
            url: "<?php echo U('select_type');?>",
            dataType: 'json',
            data: {
                selectid:selectid,//
                type:s_type,

            },
            success: function(res){
                if(res.status){
                    $(obj).css("text-decoration","line-through");
                    $(obj).css("color","gray");
                    $(obj).removeAttr("onclick");

                    if(type==1)
                    {

                        $(obj).next().removeAttr("style");
                        $(obj).next().css("color","#00c1dd");
                        $(obj).next().css("cursor","pointer");
                        $(obj).next().attr("onclick","select_type(this,"+selectid+","+s_type+")");
                    }else{
                        $(obj).prev().removeAttr("style");
                        $(obj).prev().css("color","#00c1dd");
                        $(obj).prev().css("cursor","pointer");
                        $(obj).prev().attr("onclick","select_type(this,"+selectid+","+s_type+")");
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

    function changeColor(obj) {
//        var oldXuankeStrs = $("#xuankeStrs").val();
        if ($(obj).find(".tdText").text() == "") {
            $(obj).css("background-color","#BEBEBE");
            $(obj).find(".tdText").text("选修课");
        } else {
            $(obj).css("background-color","#ccff99");
            $(obj).find(".tdText").text("");
        }
        var xuankeStrs = "";
        $("#occupyTable td").each(function () {
            if ($(this).find(".tdText").text() != "") {
                xuankeStrs += $(this).find("span").text()+";";
            }
        });
        $("#xuankeStrs").val(xuankeStrs);
        isConfilt(obj);
    }



    function check_type(num)
    {
        console.log(num);
        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var level_top = level_bottom = chk.eq(num).attr('level');

        for (var j = num+1; j < count; j++) {

            var le = chk.eq(j).attr('level');
            if (chk.eq(num).attr("checked") == "checked") {
                if (eval(le) > eval(level_bottom)){
                    chk.eq(j).attr("checked", false);
                }
                else if (eval(le) == eval(level_bottom)){
                    break;
                }
            }
        }
        chk.eq(num).attr("checked", false);

    }


    function checknode(obj,type) {

        var chk = $("input[type='checkbox']");
        var count = chk.length;
        var num = chk.index(obj);


        var level_top = level_bottom = chk.eq(num).attr('level');
        for (var i = num; i >= 0; i--) {
            var le = chk.eq(i).attr('level');
            if (eval(le) < eval(level_top)) {
                chk.eq(i).attr("checked", true);
                var level_top = level_top - 1;
            }
        }
        for (var j = num + 1; j < count; j++) {
            var le = chk.eq(j).attr('level');
            if (chk.eq(num).attr("checked") == "checked") {
                if (eval(le) > eval(level_bottom)){
                    chk.eq(j).attr("checked", true);
                }
                else if (eval(le) == eval(level_bottom)){
                    break;
                }
            } else {
                if (eval(le) > eval(level_bottom)){
                    chk.eq(j).attr("checked", false);
                }else if(eval(le) == eval(level_bottom)){
                    break;
                }
            }
        }


        var classIds = "";
        $("input[name='menuid[]']").each(function () {
            if ($(this).attr('checked') && $(this).attr("level") == 2) {
                classIds += $(this).val() + ",";

            }
        });

        if(!type)
        {
            http_check(num);
        }



    }

    function http_check(num)
    {
        var classIds = "";
        $("input[name='menuid[]']").each(function () {
            if ($(this).attr('checked') && $(this).attr("level") == 2) {
                classIds += $(this).val() + ",";

            }
        });
        $.ajax({
            url: "<?php echo U('NodeClass');?>",
            type: "get",
            dataType: "json",
            data: {
                classIds: classIds,
                grade: $("#grade").val(),
                term: $("#term").val(),
                xuankeStrs: $("#xuankeStrs").val(),
                selection: $("#selection").val(),
            },
            success: function (data) {
                if (data.msg == "needRemove") {
                    alert("所选班级没有设置选课时间或没有共有的选课时间");
                    check_type(num);

                    return false;

                }else {
                    //将结果显示出来
                    var xuankeStr = data.msg;
                    //  console.log(xuankeStr);

                    $("#occupyTable").find("td").each(function (i) {
                        if ($(this).find(".tdText").text() != "x"){
                            $(this).removeAttr("onclick");
                            $(this).css("background-color","");
                            $(this).find(".tdText").text("");
                        }
//                        console.log($(this).find("span").text());
//                        console.log(xuankeStr['node_position']);
//                        if ($(this).find("span").text()==xuankeStr['node_position']) {
                        for (var i = 0; i < xuankeStr.length; i++) {
                            if ($(this).find("span").text() == xuankeStr[i]['node_position']) {
                                $(this).attr("onclick","changeColor(this);");
                                $(this).css("background-color","#ccff99");
//                                $(this).find(".tdText").text("选修课");
                                var xuankeStrs = "";
                                $("#occupyTable td").each(function () {
                                    if ($(this).find(".tdText").text() != "" && $(this).find(".tdText").text() != "x") {
                                        xuankeStrs += $(this).find("span").text() + ";";
                                    }
                                    $("#xuankeStrs").val(xuankeStrs);
                                });
                            }
                        }
//                            $(this).css("background-color","#BEBEBE");
//                            $(this).find(".tdText").text("选修课");
//                            var xuankeStrs = "";
//                            $("#occupyTable td").each(function () {
//                                if ($(this).find(".tdText").text() != "" && $(this).find(".tdText").text() != "x") {
//                                    xuankeStrs += $(this).find("span").text()+";";
//                                }
//                            });

//                        }
                    });
                    var ids = data.id;
                    $("#ids").val(ids);
                }
            },
            error: function (data) {
                alert("查询该班级是否已有选课记录失败");
            }
        });
    }

    function AddClassNode()
    {
        var classIds = "";
        $("input[name='menuid[]']").each(function () {
            if ($(this).attr('checked') && $(this).attr("level") == 2) {
                classIds += $(this).val() + ",";

            }
        });
        var xuankeStrs = $("#xuankeStrs").val();
        $("#classIds").val(classIds);
        $("#semester").val($("#term").val());

        var num = $("#sum").val();

        if(!num)
        {
            alert("人数不能为空！");
            return false
        }

        if(!classIds)
        {
            alert("请选择班级!");
            return false
        }
        if(!xuankeStrs)
        {
            alert("选课时间不能为空！");
            return false
        }

        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('AddClassNode');?>",
            data:$("#form2").serialize(),

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    $(".daitan").hide();
                    $(".ztree").children().remove();
                    $("#occupyTable").children().remove();
                    $("#subject").val('');
                    $("#teacher").val('');
                    $("#classroom").val('');
                    $("#sum").val('');
                    history.go(0);
                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }


    //隐藏显示
    function checkshen(obj)
    {
//	    var num = $(obj).val();
        if($(obj).val()==2)
        {
            $(".title-txt.needSH").css("display","block");
            $(".value-txt.needSH").css("display","table-cell");
            $("input[name='checkTypeTwo']").each(function() {
                if($(this).attr('checked'))
                {
                    $(this).removeAttr('disabled');
                }
            });
        }else{
            $(".title-txt.needSH").css("display","none");
            $(".value-txt.needSH").css("display","none");
            $(".value-txt.needSH").css("display","none");
            $("input[name='checkTypeTwo']").each(function() {
                if($(this).attr('checked'))
                {
                    $(this).attr('disabled',"disabled");
                }
            });
        }
    }

    function AddSelect()
    {
        if($("#term").val()=='')
        {
            alert("学期不能为空！");
            return false;
        }
        if($("input[name='begintime']").val()=='' || $("input[name='endtime']").val()=='')
        {
            alert("时间不能为空！");
            return false;
        }
        if($("input[name='begintime']").val() >= $("input[name='endtime']").val())
        {
            alert("起始时间不能大于结束时间");
            return false;
        }

//	    alert("提交");
        $.ajax({
            type: "get",
            async: false,
            dataType: 'json',
            url: "<?php echo U('AddSelect');?>",
            data:$("#form1").serialize(),

            success: function(res) {
                if(res.status)
                {
                    alert(res.msg);
                    $(".daitan").hide();

                }else{
                    alert(res.msg);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

    //查询该学期是否已经设置
    function getSetting(obj){
        ;
        var semesterid = $(obj).val();
//       console.log(semesterid);
        if(!semesterid)
        {
            return false
        }
        console.log(semesterid);
        $.ajax({
            type: "post",
            url: "<?php echo U('getSetting');?>",
            dataType: 'json',
            data: {
                semesterid:$(obj).val(),//学期ID

            },
            success: function(res){
                if(res.status){
                    if (confirm(res.msg)) {
                        Startedit(res);
                    }
                }else{
                    alert(res.msg);
//                    history.go(0);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


    }
    //修改
    function edit(id,selectionid)
    {

//        return false;
        $.ajax({
            type: "get",
            url: "<?php echo U('XuanEdit');?>",
            dataType: 'json',
            data: {
                id:id,//选修id
                selectionid:selectionid,//总表

            },
            success: function(res){
                if(res.status){
                    console.log(res.elective);
                    $(".daitan").show();
                    $(".beizu").css("display","block");
                    $("#subject").val(res.elective['subjectid']);
                    $("#teacher").val(res.elective['teacherid']);
                    //上课地点 先空着
                    $("#sum").val(res.elective['num']);
                    $("#term").val(res.elective['semesterid']);
                    $("#courseIntroduce").val(res.elective['courseintroduce']);
                    $("#elective").val(res.elective['id']);
                    $(".ztree").append(res.class_html);
                    $("#occupyTable").append(res.cours_html);
                    var xuankeStr = res.elective_node;
                    var check_classid = res.check_classid;
                    CheckClass(check_classid);


                    $("#occupyTable").find("td").each(function (i) {
                        for (var i = 0; i < xuankeStr.length; i++) {
                            if ($(this).find("span").text() == xuankeStr[i]) {
                                $(this).css("background-color", "#BEBEBE");
                                $(this).find(".tdText").text("选修课");
                                var xuankeStrs = "";
                                $("#occupyTable td").each(function () {
                                    if ($(this).find(".tdText").text() != "" && $(this).find(".tdText").text() != "x") {
                                        xuankeStrs += $(this).find("span").text() + ";";
                                    }
                                    $("#xuankeStrs").val(xuankeStrs);
                                });
                            }
                        }

                    });

                }else{
                    alert(res.msg);
                    history.go(0);
                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });
    }

    function CheckClass(classid)
    {

        var chk = $("input[type='checkbox']");
        var count = chk.length;

//        console.log(classid.length);


        for(var i = 0; i< classid.length; i++)
        {
            var aa = chk.eq(j).attr('level');

            for (var j = 1; j < count; j++) {

                var le = chk.eq(j).attr('level');


                if (classid[i] == chk.eq(j).val()) {


                    chk.eq(j).attr("checked", true);

                }
            }
        }




    }

    function Startedit(res)
    {
        $("input[name='begintime']").val(timestampToTime(res.data['begintime']));

        $("input[name='endtime']").val(timestampToTime(res.data['endtime']));

        $("input[name='checkType']").each(function() {
            if($(this).val()==res.data['enroll_audit'])
            {
                $(this).attr( "checked",true);
            }
        });
        if(res.data['enroll_audit']==2)
        {
            $("input[name='checkTypeTwo']").each(function() {



                if($(this).val()==res.data['auditor'])
                {
                    $(this).attr( "checked",true);
                }
                if($(this).attr('checked'))
                {
                    $(this).removeAttr('disabled');
                }
            });
            $(".title-txt.needSH").css("display","block");
            $(".value-txt.needSH").css("display","table-cell");
        }

        $("#workNum").val(res.data['days']);
        $("#forenoon").val(res.data['morning']);
        $("#afternoon").val(res.data['afternoon']);
        $("#evening").val(res.data['evening']);
    }

    //节次设置
    function xuankeClasstime(id,semester)
    {
        if(id)
        {
            $(".xuanke").show();
        }else{
            alert("数据有误,请重新打开");

            return false;
        }
        $("#term").val(semester);
        $("#selection").val(id);
        $.ajax({
            type: "get",
            url: "<?php echo U('getXuanKe');?>",
            dataType: 'json',
            data: {
                id:id,//

            },
            success: function(res){
                if(res.status){
                    console.log(res);
                    $(".ztree").append(res.class_html);
                    $("#occupyTable").append(res.cours_html);

                }else{
                    alert(res.msg);

                }
            },
            error: function() {
                alert('系统错误,请稍后重试');
            }
        });


    }
    //关闭
    $(".xuanke_guan").click(function(){
        $(".daitan").hide();
        $(".beizu").css("display","none");
        $(".ztree").children().remove();
        $("#occupyTable").children().remove();
        $("#subject").val('');
        $("#teacher").val('');
        $("#classroom").val('');
        $("#sum").val('');
        $("#courseIntroduce").val('');

    });
    $(".manage_guan").click(function(){
        $(".student_manage").hide();
        $("#stu_table").remove();
        $(".pagination").children().remove();


    });
    //获取天数节次
    function getXuanClass()
    {

    }




    function timestampToTime(timestamp) {
        var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        return Y+M+D+h+m+s;
    }
    //时间戳转换
    function datetime(time)
    {
        var date = new Date(time);
        Y = date.getFullYear() + '-';
        M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
        D = date.getDate() + ' ';
        h = date.getHours() + ':';
        m = date.getMinutes() + ':';
        s = date.getSeconds();
        console.log(Y+M+D+h+m+s);
        return  Y+M+D+h+m+s;
    }


    $(".daitan").hide()

    $(".drop").click(
        function() {
            $(".daitan").show()
            var id  = $("#selection").val();

            $.ajax({
                type: "get",
                url: "<?php echo U('get_se_node');?>",
                dataType: 'json',
                data: {
                    id:id,//

                },
                success: function(res){
                    if(res.status){
//                        console.log(res);
                        $(".ztree").append(res.class_html);
                        $("#occupyTable").append(res.cours_html);

                    }else{
                        alert(res.msg);

                    }
                },
                error: function() {
                    alert('系统错误,请稍后重试');
                }
            });

        })





























</script>
<script>
    $('#myTab a:first').tab('show');
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
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'elErrorContainer': '#errorBlock'
        });
    });
</script>
<script>
    $(function() {
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
            'showPreview': false,
            'allowedFileExtensions': ['jpg', 'png', 'gif'],
            'elErrorContainer': '#errorBlock'
        });
    });
</script>
<script>
    $(".touch").mouseenter(
        function() {
            $(".touch").addClass("touchlei")
        }
    )
    $(".touch").mouseleave(
        function() {
            $(".touch").removeClass("touchlei")
        }
    )
</script>
<script>
    $(".banzhuren").click(
        function() {
            $(".bantan").show()
        }
    )
    $(".banzhuren").click(
        function() {
            aaa = $(this).text()
            $(".bzr").text(aaa)
        }
    )
    $(".xuan").click(
        function() {
            k = $(this).parent().text()
            $(".bzr").text(k)
        }
    )
</script>
<script>
    $(".guan").click(
        function() {
            $(".bantan").hide()
        }

    )
</script>

<script>
    $(".xiala").click(
        function() {
            $(".shou01").slideToggle()
            $(".xshang").toggle()
            $(".bianzi").toggle()
        }

    )
</script>
<script>



</script>
<script>

</script>

<script>
    $(".guan").click(
        function() {
            $(".daitan").hide()
        }

    )
</script>
<script>
    $(".name").hide()
    $(".xuan2").click(
        function() {
            o = $(this).parent().index()
            $(".name").eq(o).toggle()
            $(".dbzr").hide()
        }
    )
</script>
<script type="text/javascript">
    $(".sic").click(
        function() {
            $(".dbzr").empty();
            $('.sic').css('display','none');
        }
    )
</script>
<script>
    $(".subinput").click(
        function() {
            var y = $(this).parents(".subbox").index()
            $(".add_box").eq(y - 1).children(".peizhi").hide()
            if($(this).prop("checked")) {
                $(this).parents(".subject").hide()
                var x = $(this).parent().index()
                $(".add_box").eq(y - 1).children(".kecheng").eq(x).show()
            }
        }
    )
</script>
<script>

</script>
<script>

</script>
<script>

</script>
<script>
    $(".qinshu").hide()
    $(".daibanzhuren1").click(
        function(ID) {
            $(".qinshu").show()
        }
    )
</script>
<script>
    $(".guan1").click(
        function() {
            $(".qinshu").hide()
            $('.qinshuxingming0').val('')
            $('.qinshuxingming1').val('')
            $('.qinshuxingming2').val('')
            $('.qinshuhaoma0').val('')
            $('.oldhaoma0').val('')
            $('.qinshuhaoma1').val('')
            $('.oldhaoma1').val('')
            $('.qinshuhaoma2').val('')
            $('.oldhaoma2').val('')
            $('.qinshuguanxi0').val('')
            $('.qinshuguanxi1').val('')
            $('.qinshuguanxi2').val('')
        }
    )
</script>
</body>

</html>