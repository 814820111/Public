<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta http-equiv="x-ua-compatible" content="IE=8;IE=9;IE=10">
    <link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
    <script src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <title>添加寝室页面</title>
    <style>
        body{overflow-x: hidden;}
        .float_l{float:left;}
        .float_r{float:right;}
        .buildBlcok,.roomBlock{width:96%;margin:0 auto;}
        .leftBlock,.rightBlock{width:50%;}
        .layui-table th,.layui-table td{text-align: center;}
        .marginleft0{margin-left: 0;}
        .buildBlcok{position: relative;}
        .mask{position: absolute;width: 117%;height: 112%;z-index: 100;left: -10%;top: -10%;background: rgba(0,0,0,0.1);display: none;}
        .bordernone{border:none;}
    </style>

<body>
<form class="layui-form" action="" style="margin:20px;">
    <div class="mask"></div>
    <div class="buildBlcok">

        <div class="layui-clear">
            <div class="leftBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">楼栋名称</label>
                    <div class="layui-input-block">
                        <select name="buildingId" id="buildingId" lay-filter="buildSearch">
                            <option value="qxz">请选择</option>
                            <?php if(is_array($build)): foreach($build as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["buildname"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">楼栋层数</label>
                    <div class="layui-input-block">
                        <input type="text" name="floorNum" id="floorNum" lay-verify="required" autocomplete="off" value="" class="layui-input bordernone" disabled="disabled">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否含0层</label>
                    <div class="layui-input-block">
                        <input type="text" name="zeroExist" lay-verify="required" autocomplete="off" value="否" class="layui-input bordernone" disabled="disabled">
                    </div>
                </div>
            </div>
            <div class="rightBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">




                        <input type="text" name="buildSex" id="buildSex" lay-verify="required" autocomplete="off" value="混住" class="layui-input bordernone" disabled="disabled">


                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">起始层</label>
                    <div class="layui-input-block">
                        <input type="text" name="startFloor" id="startFloor" lay-verify="required" autocomplete="off" value="" class="layui-input bordernone" disabled="disabled">
                    </div>
                </div>

                <div class="layui-form-item">
                    <label class="layui-form-label">班级</label>
                    <div class="layui-input-block">
                        <select name="classid" id="class" lay-verify="required">
                            <option value="0">请选择</option>
                            <?php if(is_array($class)): foreach($class as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["classname"]); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="roomBlock">

        <div class="layui-clear">
            <div class="leftBlock float_l" id="dormitoryBlock">
                <div class="layui-form-item">
                    <label class="layui-form-label">层号</label>
                    <div class="layui-input-block">
                        <select name="floorId" id="floorId" lay-filter="floorSelect">



                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">床位数</label>
                    <div class="layui-input-block">
                        <input type="text" name="bedNum" id="bedNum" lay-verify="required|nothundred" autocomplete="off" placeholder="请输入床位数" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">收费</label>
                    <div class="layui-input-block">
                        <input type="text" name="charge" id="charge" lay-verify="required" autocomplete="off" placeholder="请输收费金额" class="layui-input">
                    </div>
                </div>
            </div>

            <div class="rightBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">寝室编号</label>
                    <div class="layui-input-block">
                        <input type="text" name="dormitoryCode" id="dormitoryCode" lay-verify="required" autocomplete="off" placeholder="选择楼层后自动生成" class="layui-input" disabled="disabled">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">寝室号</label>
                    <div class="layui-input-block">
                        <input type="text" name="dormitoryCodes" id="dormitoryCodes" lay-verify="required" autocomplete="off" placeholder="选择楼层后自动生成" class="layui-input" >
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">
                        <input type="text" name="sex" id="sex" lay-verify="required" autocomplete="off" value="男" class="layui-input bordernone" disabled="disabled">
                    </div>
                </div>

            </div>
        </div>
        <div class="blcokContent">
            <div class="layui-form-item layui-form-text">
                <label class="layui-form-label">备注</label>
                <div class="layui-input-block">
                    <textarea name="remark" placeholder="请输入内容" class="layui-textarea"></textarea>
                </div>
            </div>
        </div>
    </div>
    <a id="render" style="display:none;"></a>
    <input type="hidden" id="maxCode" value="210">
    <input type="hidden" id="bedNumm" value="10">
    <input type="hidden" id="chargee" value="2000.0">
    <button id="submited" class="layui-btn" lay-submit="" lay-filter="go" style="display: none"></button>
</form>
<script type="text/javascript" src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){
        var form = layui.form
            ,layer = layui.layer
            ,layedit = layui.layedit
            ,laydate = layui.laydate;
        //校验
        layui.form.verify({
            nothundred: function (value, item) {
                if (value.length > 2) {
                    return '最大为99';
                }
            }
        });
        //监听提交
        form.on('submit(go)', function(data){
            var object = data.field;
            //这是核心的代码。
            $.ajax({
                url : "<?php echo u('Dormitory/dormitory_post_add_room');?>",
                type: "post",
                dataType : "json",
                data:{
                    data:object
                },
                beforeSend: function () {
                    var index = layer.load(1, {
                        shade: [0.1,'#000'] //0.1透明度的白色背景
                    });
                },
                success: function(data) {
                    layer.closeAll('loading');
                    if(data.status == "success"){
                        layer.msg("添加成功",{time:1000},function(){
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);
                            parent.window.location.reload();
                        });
                    }else if(data.status == "error"){
                        layer.msg(data.data);
                    }
                },
                error:function(e){
                    layer.msg(e.message);
                }
            });
            return false;
        });
        //选择楼栋
        form.on('select(buildSearch)', function(data){

            //这是核心的代码。
            $.ajax({
                url : "<?php echo u('Dormitory/dormitory_select_buildinfo');?>",
                type: "post",
                dataType : "json",
                data:{
                    buildingId:data.value
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
                        var building = data.data.Buiding;
                        //层信息
                        var floorIds = data.data.floorIds;
                        if(building != undefined && building != ""){
                            //sex
                            if("2" == building.sex){
                                $("#buildSex").val("混住");
                            }else{
                                $("#buildSex").val(building.sex == "0" ? "男" : "女");
                            }
                            //层
                            $("#floorNum").val(building.floorNum);
                            //起始层
                            $("#startFloor").val(building.startFloor);
                            //含0层
                            $("#zeroExist").val(building.zeroExist == "0" ? "否" : "是");
                            //层数
                            var floors = building.floorNum;
                            var html = '';
                            for(var i = 0 ; i < floors;i++ ){
                                html += '<option value="'+floorIds[i].id+'">'+floorIds[i].floor+'层</option>';
                            }
                            $("#floorId").html(html);
                            form.render(); //更新全部
                            selectFloor($("#floorId").val());
                        }
                    }else if(data.status == "error"){
                        layer.msg(data.data);
                    }
                },
                error:function(e){
                    layer.msg(e.message);
                }
            });
        });
        //选择层
        form.on('select(floorSelect)', function(data){
            selectFloor(data.value);
        });
        $("#dormitoryCode").click(function(){
            //tips层-上
            layer.tips($("#maxCode").val() == "" ? "请选择楼层" : "当前楼层最大寝室编码   <span style='color:#d41f1f;font-size:16px;'> "+$("#maxCode").val()+"</span>", '#dormitoryCode', {
                tips: [4, '#0FA6D8'] //还可配置颜色
            });
        });
        $("#bedNum").click(function(){
            //tips层-上
            layer.tips($("#bedNumm").val() == "" ? "请选择楼层" : "参考床位数   <span style='color:#d41f1f;font-size:16px;'>"+$("#bedNumm").val()+"</span>", '#bedNum', {
                tips: [4, '#0FA6D8'] //还可配置颜色
            });
        });
        $("#charge").click(function(){
            //tips层-上
            layer.tips($("#chargee").val() == "" ? "请选择楼层" : "参考收费   <span style='color:#d41f1f;font-size:16px;'>"+$("#chargee").val()+"</span>", '#charge', {
                tips: [4, '#0FA6D8'] //还可配置颜色
            });
        });

        // 默认选中第一栋楼
        var value = $("#floorId option:eq(1)").val();
        var update=$("#dormitoryBlock");
        update.find("dd[lay-value="+value+"]").click();//将下拉列表value为value-i-need的项选中
    });
    //提交
    function jy(){
        $("#submited").click();
    }
    //切换楼栋
    function selectFloor(id){
        //这是核心的代码。
        $.ajax({
            url : "<?php echo u('Dormitory/dormitory_select_floorinfo');?>",
            type: "post",
            dataType : "json",
            data:{
                floorId:id,
                buildingId:$("#buildingId").val()
            },
            beforeSend: function () {
                var index = layer.load(1, {
                    shade: [0.1,'#000'] //0.1透明度的白色背景
                });
            },
            success: function(data) {
                layer.closeAll('loading');
                if(data.status == "success"){
                    //最大寝室号
                    var maxCode = data.data.maxCode;

                    $("#maxCode").val( maxCode );
                    maxCode = Number(maxCode)+1;

                    $("#dormitoryCode").val(maxCode);
                    $("#dormitoryCodes").val(maxCode);
                    var bedNum = data.data.bedNum;
                    $("#bedNumm").val(bedNum);
                    //性别
                    var sex = data.data.sex;
                    $("#sex").val(sex == "0" ? "男" : "女");
                    //收费
                    var charge = data.data.charge;
                    $("#chargee").val(charge);
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

<div class="layui-layer-move"></div></body></html>