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
	</style><?php endif; ?><head>

    <title>学生分配宿舍</title>


    <style>
        .rightGuid_grade{float:left;width:98%;height:180px;border:1px solid #d9dfe5;}
        .rightGuid_grade .classInfo,.gradeInfo{height:40px;line-height:40px;font-size:14px;color:#333333;background-color:#d9dfe5;}
        .rightGuid_grade #classDormitory{width:100%;height:140px;overflow-x:scroll;padding-bottom:4px;border:1px solid #d9dfe5; border-top:none;}
        #classDormitory tr td{padding:10px 10px;}
        /* 提示图标信息 */
        .boyIcon{height:12px;width:30px;border-radius:6px;float:left;background-color:#2a93db;margin-top:14px; margin-right:4px;}
        .girlIcon{height:12px;width:30px;border-radius:6px;float:left;background-color:#ff9d8c;margin-top:14px; margin-right:4px;}

        /* 寝室背景 */
        .boyDormitory{width:100px; height:35px; cursor:pointer; border-radius:4px;background-color:#2a93db;color:white;text-align:center; line-height:35px;}
        .girlDormitory{width:100px; height:35px; cursor:pointer; border-radius:4px;background-color:#ff9d8c;color:white;text-align:center; line-height:35px;}

        .bottomGuid_grade{float:left;margin-top:22px;width:98%;height:580px;}
        .bottomGuid_grade .buildingInfo{height:40px;line-height:40px;font-size:14px;color:#333333;}

        #buildingDormitory tr th{padding:0 5px;height:50px;background-color:#d9dfe5;}
        #buildingDormitory tr td{padding:0px 4px;}

    </style>
</head>
<body>
<div>
    <ul id="myTab" class="nav-tabs" style=" margin-top:30px; height:28px; list-style:none;">
        <li><a href="<?php echo U('Dormitory/dormitory_student');?>" style="color:#1f1f1f;text-decoration: none;">宿舍入住管理</a></li>
        <li class="active"><a href="#" style="color:#1f1f1f;text-decoration: none;">宿舍分配床位</a></li>
    </ul>

    <div class="rightGuid_grade" style="margin-top: 10px;">
        <div class="classInfo">
            <input type="hidden" id="classId" value="<?php echo ($classid); ?>">
            <span style="margin-left:12px;">当前:<span class="className"><?php echo ($classname); ?></span></span>
            <span style="margin-left:10px;">住宿总人数:<span class="classAllStuNum"><?php echo ($studentnum); ?></span>(住宿男生<span class="classBoyStuNum"><?php echo ($man); ?></span>  已分配名额<span class="boyBed">18</span>  已入住<span class="boyBed"><?php echo ($mannum); ?></span>/住宿女生<span class="classGirlStuNum"><?php echo ($woman); ?></span> 已分配名额<span class="girlBed">5</span>已入住<span class="boyBed"><?php echo ($womannum); ?></span>)</span>
            <div style="float:right;margin-right:10px;"><div class="girlIcon"></div>女生寝室(已入住/总分配名额)</div>
            <div style="float:right;margin-left:12px;"><div class="boyIcon"></div>男生寝室(已入住/总分配名额)</div>
        </div>
        <!-- 已选寝室-->
        <div id="classDormitory">
            <table align="left">
                <tbody>
                <tr class="boy">
                    <?php if(is_array($room)): foreach($room as $key=>$vo): if($vo['sex'] == 0 ): ?><td>

                            <div  class="boyDormitory">
                                <?php echo ($vo["roomname"]); ?>(<?php echo ($vo["isbed"]); ?>/<?php echo ($vo["bednum"]); ?>)
                            </div>

                        </td><?php endif; endforeach; endif; ?>
                </tr>
                <tr class="girl">
                    <?php if(is_array($room)): foreach($room as $key=>$vo): if($vo['sex'] == 1 ): ?><td>
                                <div  class="girlDormitory">
                                    <?php echo ($vo["roomname"]); ?>(<?php echo ($vo["isbed"]); ?>/<?php echo ($vo["bednum"]); ?>)
                                </div>
                            </td><?php endif; endforeach; endif; ?>
                </tr>
                </tbody></table>
        </div>
    </div>

    <div class="bottomGuid_grade">
        <div class="buildingInfo">
            <div style="float:left;">
                <label class="layui-form-label"> 选择楼栋</label>
                <select id="buildingId" onchange="changeBuilding(this.value)" style="float:left;height:40px;width:175px;font-size:16px;color:#999999;">
                    <option value="" >请选择楼栋</option>
                    <?php if(is_array($build)): foreach($build as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["buildname"]); ?></option><?php endforeach; endif; ?>>
                </select>

            </div>


        </div>
        <!-- 该栋楼寝室-->
        <form class="J_ajaxForm" action="" method="post">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-list">
                    <thead>
                    <tr style="background-color:#e2e2e2;">

                        <th style=" text-align: center;">层数</th>
                        <th style=" text-align: center;">性别</th>
                        <th style=" text-align: center;">可分配寝室数</th>
                        <th style=" text-align: center;">可分配床位数</th>
                        <th style=" text-align: center;">班级已分配床位数</th>
                        <th style=" text-align: center;">操作</th>
                    </tr>
                    </thead>

                  <tbody id="tbodyfloor">

                  </tbody>
                </table>
                <div class="pagination" style="position: relative;bottom: 35px;"><?php echo ($Page); ?></div>
            </div>
        </form>

            </div>

        </div>
    </div>
</div>
<link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
<script src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>

<script>

    layui.use(['layer'], function(){
        var layer = layui.layer;
    });
    function addRoom(id) {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '分配班级宿舍',
                btn: ['提交', '关闭'],
                area: ['700px', '500px'],

                content: "<?php echo U('Dormitory/dormitory_room_class');?>?floorid="+id+"&classid="+<?php echo ($classid); ?>,
                yes: function(index, layero) {
                    var ibody = layer.getChildFrame('body', index);//获取iframe页面body
                    var iframeWin = window[layero.find('iframe')[0]['name']];//获得iframe页的窗口对象
                    //提交
                    iframeWin.jy();
                    return;
                },
                shade: 0.8,
                shadeClose: true,
                success: function(layero, index){
                }
            });
            //layer.full(index);
        });
    }
    function editDormitory(id) {
        layui.use(['layer'], function() {
            var $ = layui.jquery,
                layer = layui.layer;

            var index = layer.open({
                type: 2,
                id	: 1,
                title: '修改班级宿舍',
                btn: ['提交', '关闭'],
                area: ['700px', '500px'],

                content: "<?php echo U('Dormitory/dormitory_room_class_bed');?>?roomid="+id+"&classid="+<?php echo ($classid); ?>,
                yes: function(index, layero) {
                    var ibody = layer.getChildFrame('body', index);//获取iframe页面body
                    var iframeWin = window[layero.find('iframe')[0]['name']];//获得iframe页的窗口对象
                    //提交
                    iframeWin.jy();
                    return;
                },
                shade: 0.8,
                shadeClose: true,
                success: function(layero, index){
                }
            });
            //layer.full(index);
        });
    }
    function changeBuilding(id) {
        $("#tbodyfloor").empty();
        if(!id){
            return false;
        }
        $.ajax({
            url : "<?php echo u('Dormitory/dormitory_select_buildinfo_student');?>",
            type: "post",
            dataType : "json",
            data:{
                buildingId:id,
                classid:<?php echo ($classid); ?>
            },
            beforeSend: function () {
                var index = layer.load(1, {
                    shade: [0.1,'#000'] //0.1透明度的白色背景
                });
            },
            success: function(data) {
                layer.closeAll('loading');
                if(data.status == "success"){
                    //楼栋信息
                    var count = data.data.count;
                    //层信息
                    var floorIds = data.data.floor;

                        var html = '';
                        for(var i = 0 ; i < count;i++ ){
                            html += '<tr><td style="text-align: center;">'+floorIds[i].floor+'</td><td style="text-align: center;">'+floorIds[i].sex+'</td><td style="text-align: center;">'+floorIds[i].roomnum+'</td><td style="text-align: center;">'+floorIds[i].nullbed+'</td><td style="text-align: center;">'+floorIds[i].classbed+'</td><td style="text-align: center;"><a onclick="addRoom('+floorIds[i].id+')">分配</a></td></tr>';
                        }

                        $("#tbodyfloor").append(html);

                }else if(data.status == "error"){
                    layer.msg(data.data);
                }
            },
            error:function(e){
                layer.msg(e.message);
            }
        });
    }

</script>
    </body></html>