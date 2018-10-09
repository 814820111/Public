$(function () {

    //阻止事件冒泡
    $('.temp_right').click(function (e) {
        e.stopPropagation();
    });

    //封面与底面的模板选择
    $('.img_list').click(function () {
        var isHaveClass = $(this).find('div').hasClass('active');
        if (isHaveClass){
            $(this).find('div').removeClass('active');
        } else {
            $(this).find('div').addClass('active');
        }
    });

    //添加书本页数
    $('.img_list1').click(function () {
        var isHaveClass = $(this).find('div').hasClass('active1');
        if (isHaveClass){
            $(this).find('div').removeClass('active1');
        } else {
            $(this).find('div').addClass('active1');
        }
    });

    //修改每一页的标题名称
    $('#settings_name').keyup(function () {
       var value = $(this).val();
       $('#big_img_title').html(value);

    })

    //上下移动
    $('.up').click(function (e) {
        var oDiv = $(this).parent().parent().parent();
        var id = oDiv.attr('id');
        var newDiv = oDiv.clone(true);
        var index = id.split('_')[1];
         //判断是否为首页
        var is = $('#id_'+index).prev().attr('id');
        if(is){
            newDiv.insertBefore($('#id_'+index).prev());
            //删除原来的
            oDiv.remove();
        }else{
            alert("已经到顶部了");
        }
         e.stopPropagation();
    });
    $('.down').click(function (e) {
        var oDiv = $(this).parent().parent().parent();
        var id = oDiv.attr('id');
        var newDiv = oDiv.clone(true);
        var index = id.split('_')[1];
        //判断是否为首页
        var is = $('#id_'+index).next().attr('id');
        if(is){
            newDiv.insertAfter($('#id_'+index).next());
            //删除原来的
            oDiv.remove();
        }else{
            alert("已经到顶部了");
        }
        e.stopPropagation();
    });
    //计算页数
    countPages();

    //点击选中图片
    $(".photo_list img").on("click", function () {
        var imgSrcUrl = $(this).attr("src");
        Myclick(imgSrcUrl);
    });

    //点击要上传的图片位置，显示绿色块
    $('.imgbox').click(function () {
        $(this).siblings().css('backgroundColor', 'none');
        $(this).siblings().removeClass('select_bg')
        $(this).css('backgroundColor', 'rgb(2, 196, 146)');
        $(this).addClass('select_bg');
    });

    //鼠标悬停样式
    // $('.album > span').hover(function () {
    //     //alert(1)
    //     $(this).css({'backgroundColor': '#02c492', 'border': '1px solid #02c492', 'color': '#fff'});
    // }, function (e) {
    //     //判断是否为选中状态
    //     if(!$(this).hasClass('active')){
    //         $(this).css({'backgroundColor': 'inherit', 'border': '1px solid #ccc', 'color': 'inherit'});
    //     }
    // });
    //切换右侧图片设置的小标题
    $('.album span').click(function () {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

});
var imgpath;
//存储与显示图片信息函数
function Myclick(url) {
    var img = new Image();
    img.src = url;
    img.onload = function () {
        var width = img.width;
        var height = img.height;
        var kW = $(".select_bg").width();
        var kH = $(".select_bg").height();
        if (height * kW / width > kH) {
            // 上下移动
            var styleImg = "width:100%; height:auto";
        } else {
            // 左右移动
            var styleImg = "height:100%;width:auto";
        }
        $(".select_bg").html('<img style="' + styleImg + '" src="' + url + '" ondragstart="return false"/>')
        $(".select_bg").attr("data-imgurl", url);

        var photolistarr = [];
        var isfinish = true;
        $(".imgbox").each(function () {
            var imgobj = {};
            imgobj.LayoutXyabUid = $(this).attr("data-layoutxyabuid");
            imgobj.position =  $(this).attr("data-id");
            imgobj.Url = $(this).find("img").attr("src");
            if (imgobj.Url == undefined || imgobj.Url == "") {
                isfinish = false;
            }
            //imgobj.OffsetValue = 0;
            imgobj.PageInstanceUid = $(".temp_list_active").attr("data-pageuid");
            photolistarr.push(imgobj);
        })

        $(".temp_list_active").attr("data-photolist", JSON.stringify(photolistarr));
        //如果有修改，新增
        $(".temp_list_active").attr("data-change", "Y");
        //该学生是否有修改
        $(".student_select").parent().attr("data-change", "Y");
        if (isfinish == false) {
            $(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("hide");
        } else {
            $(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("show");
        }
    }
}

//右侧设置tab切换
function setActive(obj, index) {
    $('.settings').each(function (k, v) {
        $(this).removeClass('active');
    });
    $(obj).addClass('active');

    $('.settings_list').each(function (k, v) {
        $(this).css('display', 'none');
    })
    $('.settings_' + (index)).css('display', 'block');
}

//选择页数选中函数
function selectMode(obj, index) {

    $('.temp_select_list').removeClass('temp_list_active');
    $(obj).addClass('temp_list_active');

    //显示图片tab按钮
    getImg(obj);
    //判断是否存在图片
    var data = $(obj).attr('data-photolist');
    if (data){
        //用户已经上传了图片
        var photoPosition = JSON.parse($(obj).attr("data-photoposition"));
        var photos = JSON.parse(data);
        var newArray = [];
        for (var i = 0; i < photos.length; i++){
            for (var j = 0; j < photoPosition.length; j++){
                if (photoPosition[j]['id'] == photos[i]['position']){
                    var msg = {};
                    msg.id = photoPosition[j]['id'];
                    msg.width = photoPosition[j]['width'];
                    msg.height = photoPosition[j]['height'];
                    msg.left = photoPosition[j]['left'];
                    msg.top = photoPosition[j]['top'];
                    msg.url = photos[i]['Url'];
                    newArray.push(msg);
                }
            }
        }
        $('.img_box_wrap').html('');
        var html ='';
        for (var k = 0; k < newArray.length; k++){
            var w = newArray[k]['width'] * (380/646);
            var h = newArray[k]['height'] * (536 / 910);
            var l = newArray[k]['left'] * (380/646);
            var t = newArray[k]['top'] * (536 / 910);
            html += '<div data-id="'+newArray[k]['id']+'"  ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" class="imgbox imgbox'+k+'" id="box'+k+'" style="position: absolute; overflow: hidden; background: url('+imgurl+'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);z-index=0;';
            html += 'width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px; transform: rotate(0deg); border-radius: 0%;">';
            html += '<img style="" draggable="false" src="'+newArray[k]['url']+'"/>';
            html += '</div>';
            html += '<div onclick="selectDiv(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px;z-index: 1;"></div>';
        }
        $('.img_box_wrap').html(html);
    } else {
        //用户没有上次一张图片
        getTempInfos(index);
    }
}
function getImg(obj) {
    //获取图片路径
    var data = $(obj).find("img").eq(0).data();
    $('.mask').css('background', 'url('+data.imgpath+') no-repeat 0% 0% / 100% 100%');
    imgurl = data.imgpath.substring(0, data.imgpath.lastIndexOf('/'));
    //设置标题
    $('#big_img_title').html(data.title);
    $('#settings_name').val(data.title);

    //是否锁定
    if (parseInt(data.lock)){
        $('#main_content_master').show();
    }else{
        $('#main_content_master').hide();
    }
    console.log(data)
    //设置设置显示
    if (parseInt(data.isimg) && !parseInt(data.istext)){
        $('#settings2').show();
    }else{
        if (parseInt(data.istext)){
            $('#settings3').show()
        }else{
            $('#settings2').hide();
            $('#settings1').removeClass('active');

            $('#settings1').addClass('active');
            $('.settings_1').show();
            $('.settings_2').hide();
            $('.settings_3').hide();
            $('#settings2').removeClass('active');
        }
    }
}

//获取模板的填写图片的信息
function getTempInfos(id) {
    imgurl = imgurl.substring(0, imgurl.lastIndexOf('/')+1);
    $.ajax({
        type: 'post',
        url: 'tempAjax',
        data: {id: id},
        dataType: 'json',
        success: function (res) {
            var html ='';
            for (var i = 0; i < res.length; i++){
                var w = res[i]['width'] * (380/646);
                var h = res[i]['height'] * (536 / 910);
                var l = res[i]['left'] * (380/646);
                var t = res[i]['top'] * (536 / 910);
                html += '<div data-id="'+res[i]['id']+'"  ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" class="imgbox imgbox0" id="box'+i+'" style="position: absolute; overflow: hidden; background: url('+imgurl+'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);z-index=0;';
                html += 'width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px; transform: rotate(0deg); border-radius: 0%;">';
                html += '</div>';
                html += '<div onclick="selectDiv(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px;z-index: 1;"></div>';
            }
            $('.img_box_wrap').html(html);
        },
        error: function () {
            alert("错误");
        }
    });
}

//选择div块
function selectDiv(obj, e) {
    //设置选项卡为图片选择
    //判断当前是否选择图片选项卡
    var isImg = $('#settings2').hasClass('active');
    if (!isImg){
        //判断哪一个选中
        if($('#settings1').hasClass('active')){
            //选择的是设置
            $('.settings_1').hide();
            $('#settings1').removeClass('active');
        }
        //选择的是文字
        if ($('#settings3').hasClass('active')){
            $('.settings_3').hide();
            $('#settings3').removeClass('active');
        }
        //为图片tab添加选中样式
        $('#settings2').addClass('active');
        $('.settings_2').show();
    }
    //改变背景颜色
    $('.imgbox').css('background', 'url('+imgurl+'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238)');
    $(obj).siblings().removeClass('select_bg')
    $(obj).prev().addClass('select_bg');
    $(obj).prev().css('backgroundColor', 'rgb(2, 196, 146)');
}

function setRight(obj, index) {
    alert(index);

    return false;
}

function closeDialog() {

    $('.img_list').find('div').removeClass('active');
    $('.img_list1').find('div').removeClass('active1');
    $('.temp_first_dialog').hide();
    $('.temp_first_dialog1').hide();
}

function setRightFirstOrEnd(obj) {
    var name = $(obj).parent().prev().html();
    $('#dialog_title').html(name);
    $('.temp_first_dialog').show();
}

function deletes(obj, index) {

    $('.deletePages').show();
    $('.deletePages').find('span').eq(0).attr('id', index);
}
function deletePagesOk(obj) {
    var id = $(obj).attr('id');
    //判断是否为选中状态
    var isActive = $('#id_'+id).hasClass('temp_list_active');
    if (isActive){
        //重新选择一个页面
        $('#id_'+id).next().addClass('temp_list_active');
        getImg($('#id_'+id).next());
    }
    $('#id_'+id).remove();
    $('.deletePages').hide();
    countPages();
}

function addPages() {
    $('.temp_first_dialog1').show();
}

function closeDeletePages() {
    $('.deletePages').css('display', 'none');
}


function addOk() {
    //获取所有的有active1的模板
    $('.img_list1 div.active1').each(function (k,v) {
        var html = '';
        var data = $(this).prev().data();
        var imgpath = $(this).prev().attr('src');
        var imgurl = imgpath.substring(0, imgpath.lastIndexOf('/') + 1);
        html += '<div id="id_'+data.id+'" onclick="selectMode(this, '+data.id+')" class="temp_select_list"><span class="new_add hide"></span><div class="temp_title">'+data.title+'</div>';
        html += '<div class="temp_action"><div class="temp_left left"><div class="up" onclick="up(this,'+data.id+')"></div><div onclick="down(this, '+data.id+')" class="down"></div> </div>';
        html += '<div class="temp_center left"><div class="temp_select hide"></div>';
        html += '<img src="'+imgpath+'" alt="" data-id="'+data.id+'" data-lock="'+data.lock+'" data-isImg="'+data.isimg+'" data-isText="'+data.istext+'"  data-title="'+data.title+'"  ondragstart="return false" data-imgpath="'+imgpath+'">'
        html += '<div class="temp_mask"></div></div><div class="temp_right left"  onclick="deletes(this, '+data.id+')"><img style="width: 30px;height: 30px;margin-left: 8px;margin-top: -15px" src="'+imgurl+'del_temp.png" alt=""> </div></div></div>';
        $(html).insertAfter($('.temp_select_list').eq(0));
    });
    closeDialog();
    countPages();
    //上下移动
    $('.up').click(function (e) {
        var oDiv = $(this).parent().parent().parent();
        var id = oDiv.attr('id');
        var newDiv = oDiv.clone(true);
        var index = id.split('_')[1];
        //判断是否为首页
        var is = $('#id_'+index).prev().attr('id');
        if(is){
            newDiv.insertBefore($('#id_'+index).prev());
            //删除原来的
            oDiv.remove();
        }else{
            alert("已经到顶部了");
        }
        e.stopPropagation();
    });
    $('.down').click(function (e) {
        var oDiv = $(this).parent().parent().parent();
        var id = oDiv.attr('id');
        var newDiv = oDiv.clone(true);
        var index = id.split('_')[1];
        //判断是否为首页
        var is = $('#id_'+index).next().attr('id');
        if(is){
            newDiv.insertAfter($('#id_'+index).next());
            //删除原来的
            oDiv.remove();
        }else{
            alert("已经到底部了");
        }
        e.stopPropagation();
    });
}

//计算总页页数
function countPages() {
    var all = $('.temp_select_list').length;
    $('.temp_one_1').html("共"+all+"页");

    //老师页数
    var lao = $('.temp_mask').length;
    $('.temp_one_3').find('p').eq(1).html(lao+"页");
}

//图片拖拽---开始
function dragIt(target, e) {
    console.log(target);
    e.dataTransfer.setData('imgSrc', target.src);
}

//图片拖拽---结束
function dropIt(target, e) {

    //判断图片列表中是否存在该图片
    var data = $(".temp_list_active").attr("data-photolist");
    if (data){
        var photoList = JSON.parse(data);
        var flag = 0;
        for (var i = 0; i < photoList.length; i++){
            if (photoList[i]['Url'] != e.dataTransfer.getData('imgSrc')){
                flag = 1;
                break;
            }
        }
        if (flag){
            photoList.push({"Url": e.dataTransfer.getData('imgSrc')});
        }
    }
    Myclicks(e.dataTransfer.getData('imgSrc'));

    $(target).prev().html('');
    var html = '<img style="" draggable="false" src="'+e.dataTransfer.getData('imgSrc')+'"/>';
    $('.imgbox').css('background', 'url('+imgurl+'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238)');
    $(target).prev().html(html);
    e.preventDefault();
    e.stopPropagation();

}

function Myclicks(url) {
    var img = new Image();
    img.src = url;
    img.onload = function () {
        var photolistarr = [];
        var isfinish = true;
        $(".imgbox").each(function () {
            var imgobj = {};
            imgobj.LayoutXyabUid = $(this).attr("data-layoutxyabuid");
            imgobj.Url = $(this).find("img").attr("src");
            imgobj.position =  $(this).attr("data-id");
            if (imgobj.Url == undefined || imgobj.Url == "") {
                isfinish = false;
            }
            //imgobj.OffsetValue = 0;
            imgobj.PageInstanceUid = $(".temp_list_active").attr("data-pageuid");
            photolistarr.push(imgobj);
        })
        $(".temp_list_active").attr("data-photolist", JSON.stringify(photolistarr));
        //如果有修改，新增
        $(".temp_list_active").attr("data-change", "Y");
        //该学生是否有修改
        $(".student_select").parent().attr("data-change", "Y");
        if (isfinish == false) {
            $(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("hide");
        } else {
            $(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("show");
        }
    }
}

//获取班级
function selectClass(id) {
    $.ajax({
        type: 'post',
        url: 'classAjax',
        data: {id: id},
        dataType: 'json',
        success: function (res) {
            var html ='';
            for (var i = 0; i < res.length; i++){
                html += '<option value="'+res[i]['id']+'">'+res[i]['classname']+'</option>'
            }
            $('.img_box_wrap').html(html);
        },
        error: function () {
            alert("错误");
        }
    });
}