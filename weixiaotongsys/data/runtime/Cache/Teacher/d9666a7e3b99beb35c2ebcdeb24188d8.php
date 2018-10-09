<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml"><head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="Access-Control-Allow-Origin" content="*">
    <meta http-equiv="x-ua-compatible" content="IE=8;IE=9;IE=10">
    <link rel="stylesheet" href="/weixiaotong2016/statics/js/js/layui/css/layui.css" media="all">
    <script src="/weixiaotong2016/statics/js/jquery.min.js"></script>
    <title>添加楼栋页面</title>
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
    </style>
</head>

<body>
<form class="layui-form" action="" style="margin:20px;">
    <div class="buildBlcok">
        <div class="mask"></div>
        <div class="layui-clear">
            <div class="leftBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">楼栋号</label>
                    <div class="layui-input-block">


                        <input type="text" name="code" id="code" lay-onblur="" lay-filter="buildCode" lay-verify="required|number" autocomplete="off" placeholder="楼栋号为数字" class="layui-input">



                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">性别</label>
                    <div class="layui-input-block">


                        <input type="radio" name="buildSex" value="0" title="男" checked=""><div class="layui-unselect layui-form-radio layui-form-radioed"><i class="layui-anim layui-icon"></i><span>男</span></div>
                        <input type="radio" name="buildSex" value="1" title="女"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>女</span></div>
                        <input type="radio" name="buildSex" value="2" title="混住"><div class="layui-unselect layui-form-radio"><i class="layui-anim layui-icon"></i><span>混住</span></div>



                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">是否含0层</label>
                    <div class="layui-input-block">
                        <select name="zeroExist" lay-filter="zeroExist">


                            <option value=""></option>
                            <option value="0" selected="">否</option>
                            <option value="1">是</option>



                        </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="否" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit"><dd lay-value="0" class="layui-this">否</dd><dd lay-value="1" class="">是</dd></dl></div>
                    </div>
                </div>
            </div>

            <div class="rightBlock float_l">
                <div class="layui-form-item">
                    <label class="layui-form-label">楼栋名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="name" id="name" lay-verify="required" autocomplete="off" placeholder="请输入楼栋名称" value="" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">总楼层数</label>
                    <div class="layui-input-block">
                        <select name="floorNum" lay-filter="aihao">


                            <option value=""></option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6" selected="">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>



                        </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="6" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit"><dd lay-value="1" class="">1</dd><dd lay-value="2" class="">2</dd><dd lay-value="3" class="">3</dd><dd lay-value="4" class="">4</dd><dd lay-value="5" class="">5</dd><dd lay-value="6" class="layui-this">6</dd><dd lay-value="7" class="">7</dd><dd lay-value="8" class="">8</dd></dl></div>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">起始层</label>
                    <div class="layui-input-block">
                        <select name="startFloor" id="startFloor">


                            <option value=""></option>
                            <option value="-5">-5层</option>
                            <option value="-4">-4层</option>
                            <option value="-3">-3层</option>
                            <option value="-2">-2层</option>
                            <option value="-1">-1层</option>
                            <option value="1" selected="">1层</option>



                        </select><div class="layui-unselect layui-form-select"><div class="layui-select-title"><input type="text" placeholder="请选择" value="1层" readonly="" class="layui-input layui-unselect"><i class="layui-edge"></i></div><dl class="layui-anim layui-anim-upbit"><dd lay-value="-5" class="">-5层</dd><dd lay-value="-4" class="">-4层</dd><dd lay-value="-3" class="">-3层</dd><dd lay-value="-2" class="">-2层</dd><dd lay-value="-1" class="">-1层</dd><dd lay-value="1" class="layui-this">1层</dd></dl></div>
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

    <div class="layui-clear" style="margin:0 auto;width:96%;">
        <a class="layui-btn float_r next" onclick="next();">下一步</a>
        <a class="layui-btn float_r prev" onclick="prev();" style="display: none;">上一步</a>
    </div>

    <div class="floorBlock">
        <div class="layui-form">
            <table class="layui-table">
                <colgroup>
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="150">
                    <col width="300">
                    <col>
                </colgroup>
                <thead>
                <tr>
                    <th>楼层</th>
                    <th>单层寝室数</th>
                    <th>单个寝室床位数</th>
                    <th>收费标准（元）</th>
                    <th>单层学生性别</th>
                </tr>
                </thead>
                <tbody id="floorTable">

                </tbody>
            </table>
        </div>
    </div>
    <a id="render" style="display:none;"></a>
    <input type="hidden" name="buildingId" value="">
    <button id="submited" class="layui-btn" lay-submit="" lay-filter="go" style="display: none"></button>
</form>
<script type="text/javascript" src="/weixiaotong2016/statics/js/js/layui/layui.js"></script>
<script>
    layui.use(['form', 'layedit', 'laydate'], function(){

        var form = layui.form;
        var layerTips = parent.layer === undefined ? layui.layer : parent.layer;
        var   layer = layui.layer;
        var    layedit = layui.layedit;
        var   laydate = layui.laydate;

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
                url : "<?php echo U('Dormitory/dormitory_add_post_buildlist');?>",
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
                        layer.msg("保存成功",{time:1000},function(){
                            var index = parent.layer.getFrameIndex(window.name); //获取窗口索引
                            parent.layer.close(index);
                            parent.window.location.reload();
                        });
                    }else if(data.status == "error"){
                        layer.msg(data.message);
                    }
                },
                error:function(e){
                    layer.msg(e.message);
                }
            });
            return false;
        });
        form.on('select(zeroExist)', function(data){
            if(data.value == "0"){
                var htm = '<option value="-5">-5层</option>';
                htm += '<option value="-4">-4层</option>';
                htm += '<option value="-3">-3层</option>';
                htm += '<option value="-2">-2层</option>';
                htm += '<option value="-1">-1层</option>';
                htm += '<option value="1" selected="">1层</option>';
                $("#startFloor").html(htm);
                //重新渲染表单
                $("#render").click();
            }else{
                var htm = '<option value="-5">-5层</option>';
                htm += '<option value="-4">-4层</option>';
                htm += '<option value="-3">-3层</option>';
                htm += '<option value="-2">-2层</option>';
                htm += '<option value="-1">-1层</option>';
                htm += '<option value="0" selected="">0层</option>';
                htm += '<option value="1">1层</option>';
                $("#startFloor").html(htm);
                //重新渲染表单
                $("#render").click();
            }
        });
        //重新渲染表单
        $("#render").click(function(){
            form.render(); //更新全部
        });
    });
    //code --默认不能通过
    var flag1 = true;
    //名称 --默认不能通过
    var flag2 = true;
    //下一步
    function next(){
        checkCode();
        if(flag1){
            return false;
        }
        checkName();
        if(flag2){
            return false;
        }
        $(".mask").show();
        $(".next").hide();
        $(".prev").show();
        showFloor();
    }
    //上一步
    function prev(){
        layer.msg('此操作会清空楼层数据,确定要执行吗?', {
            time: 0 //不自动关闭
            ,btn: ['确定', '取消']
            ,yes: function(index){
                layer.close(index);
                $(".mask").hide();
                $(".prev").hide();
                $(".next").show();
                $("#floorTable").html("");
            }
        });
    }
    //显示楼层
    function showFloor(){
        var sex = $(':radio[name="buildSex"]:checked').val();
        var floorNum = $("select[name='floorNum']").val();
        //是否含0层
        var zeroExist = $("select[name='zeroExist']").val();
        var startFloor = $("select[name='startFloor']").val();
        var html = '';
        for(var i = 1 ; i<= floorNum;i++ ){
            html += '<tr>';
            if("1" == zeroExist){
                html += '<td>'+(Number(startFloor)+i-1)+'层</td>';
            }else{
                if(((Number(startFloor)+i-1)) < 0){
                    html += '<td>'+(Number(startFloor)+i-1) +'层</td>';
                }else if(((Number(startFloor)+i-1)) == 0){
                    html += '<td>'+(Number(startFloor)+i) +'层</td>';
                }else{
                    if(Number(startFloor) < 0){
                        html += '<td>'+(Number(startFloor)+i) +'层</td>';
                    }else{
                        html += '<td>'+(Number(startFloor)+i-1) +'层</td>';
                    }
                }
            }
            html += '<td><input type="text" name="dormitoryNum'+i+'" lay-verify="required|number|nothundred" autocomplete="off" placeholder="请输入" class="layui-input"/></td>';
            html += '<td><input type="text" name="bedNum'+i+'" lay-verify="required|number|nothundred" autocomplete="off" placeholder="请输入" class="layui-input"/></td>';
            html += '<td><input type="text" name="charge'+i+'" lay-verify="required|number" autocomplete="off" placeholder="请输入" class="layui-input"/></td>';
            html += '<td>';
            html += '<div class="layui-input-block marginleft0" >';
            if("0" == sex){
                html += '<input type="radio" name="sex'+i+'" value="0" title="男" checked="" />';
                html += '<input type="radio" name="sex'+i+'" value="1" title="女" disabled="" />';
            }else if("1" == sex){
                html += '<input type="radio" name="sex'+i+'" value="0" title="男" disabled="" />';
                html += '<input type="radio" name="sex'+i+'" value="1" title="女" checked="" />';
            }else{
                html += '<input type="radio" name="sex'+i+'" value="0" title="男" checked="" />';
                html += '<input type="radio" name="sex'+i+'" value="1" title="女"/>';
            }
            html += '</div>';
            html += '</td>';
            html += '</tr>';
        }
        $("#floorTable").html(html);
        //重新渲染表单
        $("#render").click();
    }
    //提交
    function jy(){
        if($("#floorTable").html().trim() == ""){
            layer.msg("请点击下一步操作!");
        }else{
            $("#submited").click();
        }
    }
    //检验楼层
    function checkCode(){
        var code =$("#code").val();
        if("" == code){
            layer.msg("楼栋编号不能为空");
            return false;
        }
        var reg = new RegExp("^[0-9]*$");
        if (!reg.test(code)){
            layer.msg("楼栋编号只能是纯数字");
            return false;
        }

        $.ajax({
            url : "<?php echo U('Dormitory/dormitory_buildlist_exisno');?>",
            type: "post",
            dataType : "json",
            async:false,
            data:{
                code:code
            },
            beforeSend: function () {
                var index = layer.load(1, {
                    shade: [0.1,'#000'] //0.1透明度的白色背景
                });
            },
            success: function(data) {
                layer.closeAll('loading');
                if(data.status == "success"){
                    flag1 = false;
                }else{
                    layer.msg(data.data);
                }
            },
            error:function(e){
                layer.msg(e.message);
            }
        });
    }
    //检验名称
    function checkName(){
        var name =$("#name").val();
        if("" == name){
            layer.msg("楼栋名称不能为空");
            return false;
        }
        //核心代码
        $.ajax({
            url : "<?php echo U('Dormitory/dormitory_buildlist_exisname');?>",
            type: "post",
            dataType : "json",
            async:false,
            data:{
                name:name
            },
            beforeSend: function () {
                var index = layer.load(1, {
                    shade: [0.1,'#000'] //0.1透明度的白色背景
                });
            },
            success: function(data) {
                layer.closeAll('loading');
                if(data.status == "success"){
                    flag2 = false;
                }else{
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