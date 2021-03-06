<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta http-equiv="x-ua-compatible" content="IE=8;IE=9;IE=10">
    <link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
    <script src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <title>添加床位页面</title>
    <style>
        body{overflow-x: hidden;}
        .float_l{float:left;}
        .float_r{float:right;}
        .buildBlcok,.floorBlock{width:96%;margin:0 auto;}
        .leftBlock,.rightBlock{width:50%;}
        .layui-table th,.layui-table td{text-align: center;}
        .marginleft0{margin-left: 0;}
        .buildBlcok{position: relative;}
        .mask{position: absolute;width: 117%;height: 112%;z-index: 100;left: -10%;top: -10%;background: rgba(0,0,0,0.1);display: none;}
        .layui-form-label{width:90px;}
        .layui-input-block{margin-left: 120px;}
    </style>
<body>
<form class="layui-form" action="" style="margin:20px;">
    <div class="buildBlcok">
        <div class="mask"></div>
        <div class="layui-clear">
            <div class="leftBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">楼栋名称</label>
                    <div class="layui-input-block">
                        <select name="buildingId" id="buildingId" lay-search="" lay-filter="buildSearch">
                            <option value="qxz">直接选择或搜索选择</option>

                            <?php if(is_array($build)): foreach($build as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["buildname"]); ?></option><?php endforeach; endif; ?>

                        </select>

                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">床位号</label>
                    <div class="layui-input-block">
                        <input type="text" name="bedname" id="bedIndex" lay-verify="required|nothundred" autocomplete="off" placeholder="请输入床位号" class="layui-input">
                    </div>
                </div>
            </div>
            <div class="rightBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">寝室号</label>
                    <div class="layui-input-block">
                        <select name="roomid" id="dormitoryId" lay-search="" lay-filter="dormitoryCodeSearch">

                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">床位是否保留</label>
                    <div class="layui-input-block">
                        <select name="keep" lay-filter="status">
                            <option value="0" selected="">否</option>
                            <option value="1">是</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a id="render" style="display:none;"></a>
    <input type="hidden" id="maxBedIndex" value="6">
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
                url : "<?php echo u('Dormitory/dormitory_post_add_bed');?>",
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
                url : "<?php echo u('Dormitory/dormitory_select_code_roomlist');?>",
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
                        $("#dormitoryId").empty();
                        var dormitoryCodeLists = data.data;
                        var html = ' <option value="">直接选择或搜索选择寝室号</option>';
                        for(var i = 0 ; i < dormitoryCodeLists.length;i++){
                            html += '<option value="'+dormitoryCodeLists[i].roomid+'">'+dormitoryCodeLists[i].roomname+'</option>';
                        }
                        $("#dormitoryId").append(html);
                        $("#render").click();

                        var value = $("#dormitoryId option:eq(1)").val();
                        var update=$(".rightBlock");
                        update.find("dd[lay-value="+value+"]").click();//将下拉列表value为value-i-need的项选中
                    }else if(data.status == "error"){
                        layer.msg(data.data);
                    }
                },
                error:function(e){
                    layer.msg(e.message);
                }
            });
        });
        //选择
        form.on('select(dormitoryCodeSearch)', function(data){
            //这是核心的代码。
            $.ajax({
                url : "<?php echo u('Dormitory/dormitory_select_code_bed');?>",
                type: "post",
                dataType : "json",
                data:{
                    dormitoryId:data.value
                },
                beforeSend: function () {
                    var index = layer.load(1, {
                        shade: [0.1,'#000'] //0.1透明度的白色背景
                    });
                },
                success: function(data) {
                    layer.closeAll('loading');
                    if(data.status == "success"){
                        //床位信息
                        var maxBedIndex = data.data;
                        if(maxBedIndex != undefined && maxBedIndex != ""){
                            $("#maxBedIndex").val(maxBedIndex);
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

        // 默认选中第一栋楼
        var value = $("#buildingId option:eq(1)").val();
        var update=$(".leftBlock");
        update.find("dd[lay-value="+value+"]").click();//将下拉列表value为value-i-need的项选中

        //重新渲染表单
        $("#render").click(function(){
            form.render(); //更新全部
        });
        $("#bedIndex").click(function(){
            //tips层-上
            layer.tips($("#maxBedIndex").val() == "" ? "请选择寝室" : "当前楼层最大床位编码   "+$("#maxBedIndex").val(), '#bedIndex', {
                tips: [4, '#0FA6D8'] //还可配置颜色
            });
        });
    });
    //提交
    function jy(){
        $("#submited").click();
    }

</script>

<div class="layui-layer-move"></div></body></html>