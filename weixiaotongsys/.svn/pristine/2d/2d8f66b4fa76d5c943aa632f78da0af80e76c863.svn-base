$(function () {

    //阻止事件冒泡
    $('.temp_right').click(function (e) {
        e.stopPropagation();
    });

    //封面与底面的模板选择
    $('.img_list').click(function () {
        var isHaveClass = $(this).find('div').hasClass('active');
        if (isHaveClass) {
            $(this).find('div').removeClass('active');
        } else {
            $(this).find('div').addClass('active');
        }
    });

    //添加书本页数
    $('.img_list1').click(function () {
        var isHaveClass = $(this).find('div').hasClass('active1');
        if (isHaveClass) {
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
        var is = $('#id_' + index).prev().attr('id');
        if (is) {
            newDiv.insertBefore($('#id_' + index).prev());
            //删除原来的
            oDiv.remove();
        } else {
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
        var is = $('#id_' + index).next().attr('id');
        if (is) {
            newDiv.insertAfter($('#id_' + index).next());
            //删除原来的
            oDiv.remove();
        } else {
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

    //切换右侧图片设置的小标题
    $('.album span').click(function () {
        $(this).siblings().removeClass('active');
        $(this).addClass('active');
    });

    //获取年纪id和档案id
    var gradeid = $('#gradeid').val();
    var archivesid = $('#archivesid').val();
    //学生发送tab1
    $('.tab1 .student_list').click(function () {

        //判断当前学生是否修改数据
        $('.temp_select_list').each(function () {
            var change = $(this).attr("data-change");
            if (change == 'Y') {
                //保持到数据库
                if (confirm("是否保存当前学生的数据")) {
                    //保存数据
                    save();
                }
            }
        });
        //初始化
        $('.temp_select_list').each(function () {
            $(this).attr("data-change", '');
        })

        $(this).siblings().removeClass('student_select');
        $(this).addClass('student_select');
        var studentId = $(this).attr('data-studentid');

        //alert(studentId)
        //ajax获取该学生的数据
        getStudentInfos(studentId, gradeid, archivesid, 1);
    });
    //学生发送tab2
    $('.tab2 .student_list').click(function () {
        $(this).siblings().removeClass('student_select');
        $(this).addClass('student_select');
        var studentId = $(this).attr('data-studentid');
        //alert(studentId)
        //ajax获取该学生的数据
        getStudentInfos(studentId, gradeid, archivesid, 2);
    });

    //获取当前选中的学生信息
    var studentId = $('.student_select').attr('data-studentid');
    getStudentInfos(studentId, gradeid, archivesid, 1);

    //获取班级相册
    getClassPic(gradeid, archivesid, 2, 1);


});

//获取项目名称
function getPath() {
    var pathName = document.location.pathname;
    var index = pathName.substr(1).indexOf("/");
    var result = pathName.substr(0, index + 1);
    return result;
}

var file = getPath();

//alert(file + '/index.php/Teacher/GrowthArchives/getStudentPageInfo');

//班级相册与宝宝相册tab
function picTabBar(obj, index) {
    $(obj).siblings().removeClass('active');
    $(obj).addClass('active');
    var aClassId = $('.pic_tab_' + index + ' > .album > span.active').attr('data-classid');
    if (index == 1) {
        $('.pic_tab_2').hide();
        //获取当前选中的图片列表
        getNowClassPic(aClassId, 2, index);
    } else {
        $('.pic_tab_1').hide();
        //获取当前选中学生的的图片列表
        var studentId = $('.student_select').attr('data-studentid');
        //alert(studentId);
        getBabyPic(studentId, index);
    }
    $('.pic_tab_' + index).show();
}

//获取个人图片
function getBabyPic(sid, index) {
    $.ajax({
        type: 'get',
        //url: file + '/index.php/Teacher/GrowthArchives/getNowBabyPic',
        url: root + '/Teacher/GrowthArchives/getNowBabyPic',
        data: {sid: sid},
        dataType: 'json',
        success: function (res) {
            var html = '';
            for (var i = 0; i < res.length; i++) {
                html += '<div class="photo_list"><img src="' + imgUrls + res[i]['pictureurl'] + '" alt="" draggable="true" ondragstart="dragIt(this, event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false"> </div>';
            }
            //alert(html);
            $('.pic_tab_' + index + ' > .photo_list_container').html(html);
            //点击选中图片
            $(".photo_list img").on("click", function () {
                var imgSrcUrl = $(this).attr("src");
                Myclick(imgSrcUrl);
            });
        },
        error: function () {
            alert("错误");
        }
    });
}

//获取班级信息
function getClassPic(gid, aid, type, index) {
    $.ajax({
        type: 'get',
        //url: file + '/index.php/Teacher/GrowthArchives/getClassPic',
        url: root + '/Teacher/GrowthArchives/getClassPic',
        data: {gid: gid, aid: aid},
        dataType: 'json',
        success: function (res) {
            console.log(res);
            var html = '<span class="active" data-classid="' + res[0]['classid'] + '" onclick="getNowClassPic('+res[0]['classid']+', 2, 1)">' + res[0]['classname'] + '</span>';
            for (var i = 1; i < res.length; i++) {
                html += '<span class="" data-classid="' + res[i]['classid'] + '" onclick="getNowClassPic('+res[i]['classid']+', 2, 1)">' + res[i]['classname'] + '</span>'
            }
            //alert("html="+html);
            $('.pic_tab_' + index + ' > .album').html(html);
            $('.album span').click(function () {
                $(this).siblings().removeClass('active');
                $(this).addClass('active');
            });
            //获取当前选中的班级下的图片
            getNowClassPic(res[0]['classid'], type, index);
        },
        error: function () {
            alert("错误");
        }
    });
}

//获取当前选中的班级的所有图片
function getNowClassPic(cid, type, index) {
    //alert("cid="+cid)
    $.ajax({
        type: 'get',
        //url: file + '/index.php/Teacher/GrowthArchives/getNowClassPic',
        url: root + '/Teacher/GrowthArchives/getNowClassPic',
        data: {cid: cid, type: type},
        dataType: 'json',
        success: function (res) {
            var html = '';
            for (var i = 0; i < res.length; i++) {
                //alert(imgUrls);
                //alert(file+'/uploads/microbog/'+res[i]['pictureurl']);
                html += '<div class="photo_list"><img src="' + imgUrls + res[i]['pictureurl'] + '" alt="" draggable="true" ondragstart="dragIt(this, event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false"> </div>';
            }

            $('.pic_tab_' + index + ' > .photo_list_container').html(html);
            //点击选中图片
            $(".photo_list img").on("click", function () {
                var imgSrcUrl = $(this).attr("src");
                Myclick(imgSrcUrl);
            });
        },
        error: function () {
            alert("错误");
        }
    });
}
//alert(imgUrls)
function initCommon(obj) {
    var data = obj.data();
    $('#settings2').removeClass('active');
    $('#settings3').removeClass('active');
    $('#settings1').addClass('active');

    $('#settings1').show();
    $('#settings2').hide();
    $('#settings3').hide();

    if (parseInt(data.isimg) && !parseInt(data.istext)) {
        $('#settings2').show();
    }
    if (!parseInt(data.isimg) && parseInt(data.istext)) {
        $('#settings3').show();
    }
    if (parseInt(data.isimg) && parseInt(data.istext)) {
        $('#settings2').show();
        $('#settings3').show();
    }
    $('.settings_1').show();
    $('.settings_2').hide();
    $('.settings_3').hide();
}

function getStudentInfos(sid, gradeid, archivesid, index) {
    //初始化所有的状态
    var obj = $('.temp_list_active').find("img").eq(0);
    initCommon(obj);

    //初始化相册按扭
    $('.settings_2 span').eq(0).siblings().removeClass('active');
    $('.settings_2 span').eq(0).addClass('active');
    $('.pic_tab_1').show();
    $('.pic_tab_2').hide();

    if (index == 1) {
        //alert(sid)
        //返回的数据是该学生已经填写好的页的数据,如果没有，则为空
        $.ajax({
            type: 'get',
            //url: ''
            //url: file + '/index.php/Teacher/GrowthArchives/getStudentPageInfo',
            url: root + '/Teacher/GrowthArchives/getStudentPageInfo',
            data: {sid: sid, gid: gradeid, aid: archivesid},
            dataType: 'json',
            success: function (res) {
                //分发数据
                for (var i = 0; i < res.length; i++) {
                    if (res[i]['is_finish']) {
                        $('#id_' + res[i]['id']).find('div.temp_select').show();
                    } else {
                        $('#id_' + res[i]['id']).find('div.temp_select').hide();
                    }

                    var pid = $('.temp_list_active').attr("id");
                    var attr = '#id_' + res[i]['id'];
                    if (res[i]['content']) {
                        $(attr).attr("data-photolist", res[i]['content']);
                        $(attr).attr("data-textlist", res[i]['text']);
                    } else {
                        $('#id_' + res[i]['id']).attr("data-photolist", '');
                        $('#id_' + res[i]['id']).attr("data-textlist", '');
                    }
                    if (pid) {
                        if (('#' + pid) == attr) {
                            //修改选择页的详细内容
                            PageCommon($('.temp_list_active'), res[i]['content'], res[i]['text']);
                        }
                    }
                }
            },
            error: function () {
                alert("错误");
            }
        });
    }
    else if (index == 2) {
        //alert(sid)
    }
}
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
        var isfinish_1 = true;
        $(".imgbox").each(function () {
            var imgobj = {};
            imgobj.LayoutXyabUid = $(this).attr("data-layoutxyabuid");
            imgobj.position = $(this).attr("data-id");
            imgobj.url = $(this).find("img").attr("src");
            if (imgobj.url == undefined || imgobj.url == "") {
                isfinish_1 = false;
            }
            //imgobj.OffsetValue = 0;
            imgobj.PageInstanceUid = $(".temp_list_active").attr("data-pageuid");
            photolistarr.push(imgobj);
        })

        $(".temp_list_active").attr("data-photolist", JSON.stringify(photolistarr));

        var isfinish_2 = true;
        //获取文字xinx
        var textPos = $(".temp_list_active").attr('data-textposition');
        var text = $(".temp_list_active").attr('data-textlist');
        if (textPos){
            if (text){
                var pl = JSON.parse(textPos).length;
                var tl = JSON.parse(text).length;
                if (pl == tl){
                    isfinish_2 = true;
                }else{
                    isfinish_2 = false;
                }
            }
        }
        //如果有修改，新增
        $(".temp_list_active").attr("data-change", "Y");
        //alert("Myclicks"+isfinish);
        //该学生是否有修改
        $(".student_select").parent().attr("data-change", "Y");
        if (isfinish_1 == false || isfinish_2 == false) {
            $(".temp_list_active .temp_select").css('display', 'none');
            //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("hide");
        } else {
            $(".temp_list_active .temp_select").css('display', 'block');
            //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("show");
        }
    }
}

function imgPageCommon(obj, data) {
    var photoPosition = JSON.parse(obj.attr("data-photoposition"));
    var photos = JSON.parse(data);
    var newArray = [];
    for (var i = 0; i < photos.length; i++) {
        for (var j = 0; j < photoPosition.length; j++) {
            if (photos.length < photoPosition.length) {
                if (photoPosition[j]['id'] == photos[i]['position']) {
                    var msg = {};
                    msg.id = photoPosition[j]['id'];
                    msg.width = photoPosition[j]['width'];
                    msg.height = photoPosition[j]['height'];
                    msg.left = photoPosition[j]['left'];
                    msg.top = photoPosition[j]['top'];
                    msg.url = photos[i]['url'];
                    newArray.push(msg);
                } else {
                    var msg = {};
                    msg.id = photoPosition[j]['id'];
                    msg.width = photoPosition[j]['width'];
                    msg.height = photoPosition[j]['height'];
                    msg.left = photoPosition[j]['left'];
                    msg.top = photoPosition[j]['top'];
                    msg.url = null;
                    newArray.push(msg);
                }
            } else {
                if (photoPosition[j]['id'] == photos[i]['position']) {
                    var msg = {};
                    msg.id = photoPosition[j]['id'];
                    msg.width = photoPosition[j]['width'];
                    msg.height = photoPosition[j]['height'];
                    msg.left = photoPosition[j]['left'];
                    msg.top = photoPosition[j]['top'];
                    msg.url = photos[i]['url'];
                    newArray.push(msg);
                }
            }
        }
    }
    $('.img_box_wrap').html('');
    var html = '';
    for (var k = 0; k < newArray.length; k++) {
        //alert(newArray[k]['url'])
        var w = newArray[k]['width'] * (380 / 646);
        var h = newArray[k]['height'] * (536 / 910);
        var l = newArray[k]['left'] * (380 / 646);
        var t = newArray[k]['top'] * (536 / 910);
        if (newArray[k]['url'] != null) {
            html += '<div data-id="' + newArray[k]['id'] + '"  ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" class="imgbox imgbox' + k + '" id="box' + k + '" style="position: absolute; overflow: hidden; background: url(' + imgurl + 'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);z-index=0;';
            html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
            html += '<img style="width:100%; height:100%" draggable="false" src="' + newArray[k]['url'] + '"/>';
            html += '</div>';
            html += '<div onclick="selectDiv(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;z-index: 5;"></div>';
        } else {
            imgurl = imgurl.substring(0, imgurl.lastIndexOf('/') + 1);
            html += '<div data-id="' + newArray[k]['id'] + '"  ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" class="imgbox imgbox0" id="box' + k + '" style="position: absolute; overflow: hidden; background: url(' + imgurl + 'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);z-index=0;';
            html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
            html += '</div>';
            html += '<div data-id="' + newArray[k]['id'] + '" onclick="selectDiv(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;z-index: 5;"></div>';
        }
    }
    $('.img_box_wrap').html(html);
}

function textPageCommon(obj, dataText) {
    var textPosition = JSON.parse(obj.attr("data-textposition"));
    //alert("textPosition="+$(obj).attr("data-textposition"));
    //获取文字信息
    var textdata = JSON.parse(dataText);
    //alert("text="+dataText);
    var newArray = [];
    for (var i = 0; i < textdata.length; i++) {
        for (var j = 0; j < textPosition.length; j++) {
            if (textPosition[j]['id'] == textdata[i]['id']) {
                var msg = {};
                msg.id = textPosition[j]['id'];
                msg.width = textPosition[j]['width'];
                msg.height = textPosition[j]['height'];
                msg.left = textPosition[j]['left'];
                msg.top = textPosition[j]['top'];
                msg.text = textdata[i]['text'];
                newArray.push(msg);
            }
        }
    }
    //alert("newArray="+newArray);
    $('.desc_box_wrap').html('');
    var html = '';
    for (var k = 0; k < newArray.length; k++) {
        var w = newArray[k]['width'] * (380 / 646);
        var h = newArray[k]['height'] * (536 / 910);
        var l = newArray[k]['left'] * (380 / 646);
        var t = newArray[k]['top'] * (536 / 910);
        html += '<div id="' + newArray[k]['id'] + '"  ondrop="dropItText(this, event)" ondragenter="return false" ondragover="return false" class="textbox textbox' + i + '" style="position: absolute; overflow: hidden; background: rgb(238, 238, 238);z-index=0;';
        html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
        html += '<textarea onkeyup="getTexts(this,' + newArray[k]['id'] + ')" onclick="selectText(this,event)"  id="texts" style="width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;border:none;background-color:transparent;resize:none;color:#8f5731;font-size:16px;font-family:微软雅黑,Helvetica" draggable="false" placeholder="请从右侧拖入文字...">' + newArray[k]['text'] + '</textarea>';
        html += '</div>';
        //html += '<div onclick="selectText(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px;z-index: 1;"></div>';
    }
    //alert("html=" + html)
    $('.desc_box_wrap').html(html);
}

//获取数据后显示每一页的详细信息
function PageCommon(obj, data, dataText) {
    //alert(data)
    if (data) {
        //用户已经上传了图片
        imgPageCommon(obj, data);
    } else {
        //获取图片的位置信息
        var imgPos = obj.attr('data-photoposition');
        var res = JSON.parse(imgPos);
        var html = '';
        for (var i = 0; i < res.length; i++) {
            var w = res[i]['width'] * (380 / 646);
            var h = res[i]['height'] * (536 / 910);
            var l = res[i]['left'] * (380 / 646);
            var t = res[i]['top'] * (536 / 910);
            html += '<div data-id="' + res[i]['id'] + '"  ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" class="imgbox imgbox0" id="box' + i + '" style="position: absolute; overflow: hidden; background: url(' + imgurl + 'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);z-index=0;';
            html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
            html += '</div>';
            html += '<div data-id="' + res[i]['id'] + '" onclick="selectDiv(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;z-index: 5;"></div>';
        }
        //alert(html)
        $('.img_box_wrap').html(html);
    }

    if (dataText) {
        //获取文字位置
        textPageCommon(obj, dataText);
    } else {
        var textPos = obj.attr('data-textposition');
        var res = JSON.parse(textPos);
        var html = '';
        for (var i = 0; i < res.length; i++) {
            var w = res[i]['width'] * (380 / 646);
            var h = res[i]['height'] * (536 / 910);
            var l = res[i]['left'] * (380 / 646);
            var t = res[i]['top'] * (536 / 910);
            html += '<div id="' + res[i]['id'] + '"  ondrop="dropItText(this, event)" ondragenter="return false" ondragover="return false" class="textbox textbox' + i + '" style="position: absolute; overflow: hidden; background: rgb(238, 238, 238);z-index=0;';
            html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
            html += '<textarea onkeyup="getTexts(this, ' + res[i]['id'] + ')" onclick="selectText(this,event)"  id="texts" style="width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;border:none;background-color:transparent;resize:none;color:#8f5731;font-size:16px;font-family:微软雅黑,Helvetica" draggable="false" placeholder="请从右侧拖入文字..."></textarea>';
            html += '</div>';
            //html += '<div data-id="'+res[i]['id']+'" onclick="selectText(this,event)" ondrop="dropItText(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px;z-index: 1;"></div>';
        }
        //alert(html)
        $('.desc_box_wrap').html(html);
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
function selectMode(obj, index, pid) {

    $('.temp_select_list').removeClass('temp_list_active');
    $(obj).addClass('temp_list_active');

    //显示图片tab按钮
    getImg(obj);
    //判断是否存在图片
    var data = $(obj).attr('data-photolist');
    if (data) {
        //用户已经上传了图片
        imgPageCommon($(obj), data);
    } else {
        //用户没有上次一张图片
        getTempInfos(index, pid);
    }
    //判断是否有文字
    var dataText = $(obj).attr('data-textlist');
    //alert(dataText);
    if (dataText) {
        //获取文字位置
        textPageCommon($(obj), dataText);
    } else {
        //用户没有填写文字
        getTempText(index, pid);
    }

    var type = $(obj).attr('data-writen');
    if (type == 1){
        $('#teacher').attr('selected', true);
    }
    if(type == 2){
        $('#homes').attr('selected', true);
    }
}
function getImg(obj) {
    //获取图片路径
    initCommon($(obj).find("img").eq(0));
    var data = $(obj).find("img").eq(0).data();
    $('.mask').css('background', 'url(' + data.imgpath + ') no-repeat 0% 0% / 100% 100%');
    imgurl = data.imgpath.substring(0, data.imgpath.lastIndexOf('/'));
    //设置标题
    $('#big_img_title').html(data.title);
    $('#settings_name').val(data.title);

    //是否锁定
    if (parseInt(data.lock)) {
        $('#main_content_master').show();
    } else {
        $('#main_content_master').hide();
    }
    //console.log(data);
}

function getTempText(id, pid) {
    var studentId = $('.student_select').attr('data-studentid');
    $('.desc_box_wrap').html('');
    //获取年纪id和档案id
    var gradeid = $('#gradeid').val();
    var archivesid = $('#archivesid').val();
    $.ajax({
        type: 'get',
        url: root + '/Teacher/GrowthArchives/tempAjax',
        data: {id: pid, type: 0, gid: gradeid, aid: archivesid, sid: studentId},
        dataType: 'json',
        success: function (res) {
            if (res) {
                var html = '';
                for (var i = 0; i < res.length; i++) {
                    var w = res[i]['width'] * (380 / 646);
                    var h = res[i]['height'] * (536 / 910);
                    var l = res[i]['left'] * (380 / 646);
                    var t = res[i]['top'] * (536 / 910);
                    html += '<div id="' + res[i]['id'] + '"  ondrop="dropItText(this, event)" ondragenter="return false" ondragover="return false" class="textbox textbox' + i + '" style="position: absolute; overflow: hidden; background: rgb(238, 238, 238);z-index=0;';
                    html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
                    html += '<textarea onkeyup="getTexts(this, ' + res[i]['id'] + ')" onclick="selectText(this,event)"  id="texts" style="width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;border:none;background-color:transparent;resize:none;color:#8f5731;font-size:16px;font-family:微软雅黑,Helvetica" draggable="false" placeholder="请从右侧拖入文字..."></textarea>';
                    html += '</div>';
                    //html += '<div data-id="'+res[i]['id']+'" onclick="selectText(this,event)" ondrop="dropItText(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px;z-index: 1;"></div>';
                }
                //alert(html)
                $('.desc_box_wrap').html(html);
            }
        },
        error: function () {
            alert("错误");
        }
    });
}

function getTexts(obj, id) {
    //获取数据
    var text = $(obj).val();
    $('.temp_select_list').each(function () {
        var textp = $(this).attr("data-textposition");
        if (textp){
            var data = JSON.parse(textp);
            //alert(data)
            for (var i = 0; i < data.length; i++) {
                if (parseInt(data[i]['id']) == id) {
                    if (text){
                        var arr = [];
                        var msg = {
                            id: id,
                            text: text
                        }
                        arr.push(msg);
                        $(this).attr("data-textlist", JSON.stringify(arr));
                    }else{
                        $(this).attr("data-textlist", '');
                    }
                }
            }
        }
    });
    //判断当页是否完成
    var isfinish = true;
    var photoPos = $(".temp_list_active").attr('data-photoposition');
    var photo = $(".temp_list_active").attr('data-photolist');
    if (photoPos){
        var pl = JSON.parse(photoPos).length;
        var tl = JSON.parse(photo).length;
        if (pl == tl){
            isfinish = true;
        }else{
            isfinish = false;
        }
    }
    //获取文字xinx
    var textPos = $(".temp_list_active").attr('data-textposition');
    var text = $(".temp_list_active").attr('data-textlist');
    if (textPos){
        if (text){
            var pl = JSON.parse(textPos).length;
            var tl = JSON.parse(text).length;
            if (pl == tl){
                isfinish = true;
            }else{
                isfinish = false;
            }
        }else{
            isfinish = false;
        }
    }
    $('.temp_list_active').attr("data-change", 'Y');
    //alert(isfinish)
    if (isfinish == false) {
        //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("hide");
        $(".temp_list_active .temp_select").css('display', 'none');
    } else {
        //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("show");
        $(".temp_list_active .temp_select").css('display', 'block');
    }
}

//获取模板的填写图片的信息
function getTempInfos(id, pid) {
    imgurl = imgurl.substring(0, imgurl.lastIndexOf('/') + 1);
    var gradeid = $('#gradeid').val();
    var archivesid = $('#archivesid').val();
    var studentId = $('.student_select').attr('data-studentid');
    $.ajax({
        type: 'get',
        url: root + '/Teacher/GrowthArchives/tempAjax',
        data: {id: pid, type: 1, gid: gradeid, aid: archivesid, sid: studentId},
        dataType: 'json',
        success: function (res) {
            var html = '';
            for (var i = 0; i < res.length; i++) {
                var w = res[i]['width'] * (380 / 646);
                var h = res[i]['height'] * (536 / 910);
                var l = res[i]['left'] * (380 / 646);
                var t = res[i]['top'] * (536 / 910);
                html += '<div data-id="' + res[i]['id'] + '"  ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" class="imgbox imgbox0" id="box' + i + '" style="position: absolute; overflow: hidden; background: url(' + imgurl + 'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);z-index=0;';
                html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
                html += '</div>';
                html += '<div data-id="' + res[i]['id'] + '" onclick="selectDiv(this,event)" ondrop="dropIt(this, event)" ondragenter="return false" ondragover="return false" style="position: absolute;width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;z-index: 5;"></div>';
            }
            //alert(html)
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
    if (!isImg) {
        //判断哪一个选中
        if ($('#settings1').hasClass('active')) {
            //选择的是设置
            $('.settings_1').hide();
            $('#settings1').removeClass('active');
        }
        //选择的是文字
        if ($('#settings3').hasClass('active')) {
            $('.settings_3').hide();
            $('#settings3').removeClass('active');
        }
        //为图片tab添加选中样式
        $('#settings2').addClass('active');
        $('.settings_2').show();
    }
    //改变背景颜色
    $('.imgbox').css('background', 'url(' + imgurl + 'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238)');
    $(obj).siblings().removeClass('select_bg')
    $(obj).prev().addClass('select_bg');
    $(obj).prev().css('backgroundColor', 'rgb(2, 196, 146)');
}

function selectText(obj, e) {
    var isText = $('#settings3').hasClass('active');
    if (!isText) {
        //判断哪一个选中
        if ($('#settings1').hasClass('active')) {
            //选择的是设置
            $('.settings_1').hide();
            $('#settings1').removeClass('active');
        }
        //选择的是图片
        if ($('#settings2').hasClass('active')) {
            $('.settings_2').hide();
            $('#settings2').removeClass('active');
        }
        //为图片tab添加选中样式
        $('#settings3').addClass('active');
        $('.settings_3').show();
    }
}


//=========================================================================
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
    var isActive = $('#id_' + id).hasClass('temp_list_active');
    if (isActive) {
        //重新选择一个页面
        $('#id_' + id).next().addClass('temp_list_active');
        getImg($('#id_' + id).next());
    }
    $('#id_' + id).remove();
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
    $('.img_list1 div.active1').each(function (k, v) {
        var html = '';
        var data = $(this).prev().data();
        var imgpath = $(this).prev().attr('src');
        var imgurl = imgpath.substring(0, imgpath.lastIndexOf('/') + 1);
        html += '<div id="id_' + data.id + '" onclick="selectMode(this, ' + data.id + ')" class="temp_select_list"><span class="new_add hide"></span><div class="temp_title">' + data.title + '</div>';
        html += '<div class="temp_action"><div class="temp_left left"><div class="up" onclick="up(this,' + data.id + ')"></div><div onclick="down(this, ' + data.id + ')" class="down"></div> </div>';
        html += '<div class="temp_center left"><div class="temp_select hide"></div>';
        html += '<img src="' + imgpath + '" alt="" data-id="' + data.id + '" data-lock="' + data.lock + '" data-isImg="' + data.isimg + '" data-isText="' + data.istext + '"  data-title="' + data.title + '"  ondragstart="return false" data-imgpath="' + imgpath + '">'
        html += '<div class="temp_mask"></div></div><div class="temp_right left"  onclick="deletes(this, ' + data.id + ')"><img style="width: 30px;height: 30px;margin-left: 8px;margin-top: -15px" src="' + imgurl + 'del_temp.png" alt=""> </div></div></div>';
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
        var is = $('#id_' + index).prev().attr('id');
        if (is) {
            newDiv.insertBefore($('#id_' + index).prev());
            //删除原来的
            oDiv.remove();
        } else {
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
        var is = $('#id_' + index).next().attr('id');
        if (is) {
            newDiv.insertAfter($('#id_' + index).next());
            //删除原来的
            oDiv.remove();
        } else {
            alert("已经到底部了");
        }
        e.stopPropagation();
    });
}
//计算总页页数
function countPages() {
    var all = $('.temp_select_list').length;
    $('.temp_one_1').html("共" + all + "页");

    //老师页数
    var lao = $('.temp_mask').length;
    $('.temp_one_3').find('p').eq(1).html(lao + "页");
}
//=========================================================================


//图片拖拽---开始
function dragIt(target, e) {
    //console.log(target);
    e.dataTransfer.setData('imgSrc', target.src);
}

//图片拖拽---结束
function dropIt(target, e) {
    //判断图片列表中是否存在该图片
    var data = $(".temp_list_active").attr("data-photolist");
    if (data) {
        var photoList = JSON.parse(data);
        var flag = 0;
        for (var i = 0; i < photoList.length; i++) {
            if (photoList[i]['url'] != e.dataTransfer.getData('imgSrc')) {
                flag = 1;
                break;
            }
        }
        if (flag) {
            photoList.push({"url": e.dataTransfer.getData('imgSrc')});
        }
    }
    Myclicks(e.dataTransfer.getData('imgSrc'));

    $(target).prev().html('');
    var html = '<img style="width: 100%;height: auto" draggable="false" src="' + e.dataTransfer.getData('imgSrc') + '"/>';
    $('.imgbox').css('background', 'url(' + imgurl + 'add_pic.png) center center / 100px no-repeat rgb(238, 238, 238)');
    $(target).prev().html(html);
    e.preventDefault();
    e.stopPropagation();

}

//拖拽文字开始
function dragItText(target, e) {
    var value = target.innerHTML.replace(/(^\s*)|(\s*$)/g, '');
    e.dataTransfer.setData('text', value);
}
//拖拽文字结束
function dropItText(target, e) {
    //alert(1)
    $('.temp_list_active').attr('data-textlist', '');
    var text = e.dataTransfer.getData('text');
    $('#texts').val(text);
    var arr = [];
    arr.push({"id": target.id, "text": text});
    $('.temp_list_active').attr('data-textlist', JSON.stringify(arr));

    //判断当页是否完成
    var isfinish = true;
    var photoPos = $(".temp_list_active").attr('data-photoposition');
    var photo = $(".temp_list_active").attr('data-photolist');
    if (photoPos){
        var pl = JSON.parse(photoPos).length;
        var tl = JSON.parse(photo).length;
        if (pl == tl){
            isfinish = true;
        }else{
            isfinish = false;
        }
    }
    var isfinish_2 = true;
    //获取文字xinx
    var textPos = $(".temp_list_active").attr('data-textposition');
    var text = $(".temp_list_active").attr('data-textlist');
    if (textPos){
        var pl = JSON.parse(textPos).length;
        var tl = JSON.parse(text).length;
        if (pl == tl){
            isfinish_2 = true;
        }else{
            isfinish_2 = false;
        }
    }
    if (isfinish == false || isfinish_2 == false) {
        //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("hide");
        $(".temp_list_active .temp_select").css('display', 'none');
    } else {
        //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("show");
        $(".temp_list_active .temp_select").css('display', 'block');
    }
    //$('#'+target.id).children.html(text);
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
            imgobj.url = $(this).find("img").attr("src");
            imgobj.position = $(this).attr("data-id");
            if (imgobj.url == undefined || imgobj.url == "") {
                isfinish = false;
            }
            //imgobj.OffsetValue = 0;
            imgobj.PageInstanceUid = $(".temp_list_active").attr("data-pageuid");
            photolistarr.push(imgobj);
        })


        $(".temp_list_active").attr("data-photolist", JSON.stringify(photolistarr));

        var photoPos = $(".temp_list_active").attr('data-photoposition');
        var photo = $(".temp_list_active").attr('data-photolist');
        if (photoPos){
            var pl = JSON.parse(photoPos).length;
            var tl = JSON.parse(photo).length;
            if (pl == tl){
                isfinish = true;
            }else{
                isfinish = false;
            }
        }
        var isfinish_2 = true;
        //获取文字xinx
        var textPos = $(".temp_list_active").attr('data-textposition');
        var text = $(".temp_list_active").attr('data-textlist');
        if (textPos){
            var pl = JSON.parse(textPos).length;
            var tl = JSON.parse(text).length;
            if (pl == tl){
                isfinish_2 = true;
            }else{
                isfinish_2 = false;
            }
        }
        //如果有修改，新增
        $(".temp_list_active").attr("data-change", "Y");
        //该学生是否有修改
        $(".student_select").parent().attr("data-change", "Y");
        //alert("Myclicks"+isfinish);
        if (isfinish == false || isfinish_2==false) {
            //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("hide");
            $(".temp_list_active .temp_select").css('display', 'none');
        } else {
            //$(".temp_list_active .temp_select").removeClass("show").removeClass("hide").addClass("show");
            $(".temp_list_active .temp_select").css('display', 'block');
        }
    }
}

//获取班级
function selectClass(id) {
    $.ajax({
        type: 'post',
        url: '/Teacher/GrowthArchives/classAjax',
        data: {id: id},
        dataType: 'json',
        success: function (res) {
            var html = '';
            for (var i = 0; i < res.length; i++) {
                html += '<option value="' + res[i]['id'] + '">' + res[i]['classname'] + '</option>'
            }
            $('.img_box_wrap').html(html);
        },
        error: function () {
            alert("错误");
        }
    });
}

//保持数据
function save() {
    var gradeid = $('#gradeid').val();                 //年级id
    var archivesid = $('#archivesid').val();           //档案id
    var studentId = $('.student_select').attr('data-studentid');  //学生id
    var arr = [];   //
    var isOk = [];  //
    var student_temple = []; //
    var imgTextId = [];
    //alert(studentId);
    $(".temp_select_list").each(function () {
        //alert(1)
        var data = $(this).attr('data-photolist');
        var dataText = $(this).attr('data-textlist');
        var textPosition = $(this).attr('data-textposition');
        var photoPosition = $(this).attr('data-photoposition');
        //alert(photoPosition)
        //============================================================
        //temple_page id
        var id = $(this).attr('data-id');
        var pageid = $(this).attr('data-pageid');
        var msg = {}
        msg.sid = studentId;
        msg.aid = archivesid;
        msg.gid = gradeid;
        msg.pid = pageid;
        student_temple.push(msg);
        //===============================================================
        //获取所有的img_text_id
        // if (textPosition) {
        //     var textData = JSON.parse(textPosition);
        //     for (var i = 0; i < textData.length; i++) {
        //         var obj = {};
        //         obj.imgTextId = textData[i]['id'];
        //         obj.pageid = pageid;
        //         imgTextId.push(obj);
        //     }
        //     //alert(textData.length)
        // }
        //
        // if (photoPosition) {
        //     var imgData = JSON.parse(photoPosition);
        //     for (var i = 0; i < imgData.length; i++) {
        //         var obj = {};
        //         obj.imgTextId = imgData[i]['id'];
        //         obj.pageid = pageid;
        //         imgTextId.push(obj);
        //     }
        // }

        //图片
        if (data) {
            var imgDatas = JSON.parse(data);
            for (var i = 0; i < imgDatas.length; i++) {
                if (imgDatas[i]['url']) {
                    var obj = {};
                    obj.id = imgDatas[i]['position'];
                    obj.url = imgDatas[i]['url'];
                    obj.pid = pageid;
                    obj.type = 1;
                    arr.push(obj);
                }
            }
        }

        if (textPosition){
            if (dataText) {
                var textDatas = JSON.parse(dataText);
                for (var i = 0; i < textDatas.length; i++) {
                    if (textDatas[i]['text']) {
                        var obj = {};
                        obj.id = textDatas[i]['id'];
                        obj.url = textDatas[i]['text'];
                        obj.pid = pageid;
                        obj.type = 0;
                        arr.push(obj);
                    }
                }
            }else{
                var textData = JSON.parse(textPosition);
                for (var i = 0; i < textData.length; i++) {
                    var obj = {};
                    obj.id = textData[i]['id'];
                    obj.url = '';
                    obj.pid = pageid;
                    obj.type = 0;
                    arr.push(obj);
                }
            }
        }
        //文字
        // if (dataText) {
        //     var textDatas = JSON.parse(dataText);
        //     for (var i = 0; i < textDatas.length; i++) {
        //         if (textDatas[i]['text']) {
        //             var obj = {};
        //             obj.id = textDatas[i]['id'];
        //             obj.url = textDatas[i]['text'];
        //             obj.pid = pageid;
        //             obj.type = 0;
        //             arr.push(obj);
        //         }
        //     }
        // }else{
        //     alert("kong")
        //     if (textPosition){
        //         var textData = JSON.parse(textPosition);
        //         for (var i = 0; i < textData.length; i++) {
        //             if (textData[i]['text']) {
        //                 var obj = {};
        //                 obj.id = textData[i]['id'];
        //                 obj.url = '';
        //                 obj.pid = pageid;
        //                 obj.type = 0;
        //                 arr.push(obj);
        //             }
        //         }
        //     }
        //
        // }

        //判断当前页是否完成
        var flag = false;
        var tag = false;
        //alert("pohotop="+photoPosition)
        if (photoPosition != '') {
            if (data){
                var imgData = JSON.parse(photoPosition);
                var imgDatas = JSON.parse(data);
                var count = 0;
                for (var i = 0; i < imgDatas.length; i++){
                    if (imgDatas[i]['url']){
                        count++;
                    }
                }
                if (imgData.length == count) {
                    flag = true;
                } else {
                    flag = false;
                }
            }else{
                flag = false;
            }
        }else{
            flag = true;
        }
        //alert("img_flag_"+pageid+"="+flag)
        //alert("textp="+textPosition)
        if (textPosition != ''){
            //alert("dataText"+dataText);
            if (dataText){
                var textDatas = JSON.parse(dataText);
                var textData = JSON.parse(textPosition);
                var count = 0;
                for (var i = 0; i < textDatas.length; i++){
                    //alert(imgDatas[i]['text'])
                    if (textDatas[i]['text']){
                        count++;
                    }
                }
                //alert("count="+count);
                if (count == textData.length) {
                    tag = true;
                } else {
                    tag = false;
                }
            }else{
                tag = false;
            }
        }else{
            tag = true;
        }
        var obj = {};
        obj.archivesid = archivesid;
        obj.studentid = studentId;
        obj.pageid = pageid;
        obj.writen = $(this).attr('data-writen');
        //alert("text_flag_"+pageid+"="+tag)
        if (flag && tag) {
            //alert(1)
            obj.finish = 1;
        }else{
            //alert(0)
            obj.finish = 0;
        }
        isOk.push(obj);
    });
    console.log(arr);
    //ajax
    $.ajax({
        type: 'post',
        //url: file+"/index.php/Teacher/GrowthArchives/addImgAjax",
        url: root + "/Teacher/GrowthArchives/addImgAjax",
        //data: {data: arr, studentTemple: student_temple, imgTextId: imgTextId, isFinish: isOk},
        data: {data: arr, studentTemple: student_temple, isFinish: isOk},
        dataType: 'json',
        success: function (res) {
            if (res['status'] == 200) {
                alert("保存成功");
                //window.history.back();
                //是否存在已完成的页
                //var pages = $("#student_" + studentId).html();
                //var newpages = parseInt(pages) + res['count'];
                //alert(newpages);
                $("#student_" + studentId).html(res['count']);
                $('.temp_select_list').each(function (k,v) {
                    $(this).attr('data-change', '');
                })
            }
        },
        error: function () {
            alert("错误");
        }
    });
}

//发送tab
function sendStudent(obj, index) {
    $('.student_header span').removeClass('active');
    $('.student_header span').eq(index - 1).addClass('active');
    if (index == 1) {
        $('.tab' + index).show();
        $('.tab2').hide();
    } else {
        $('.tab' + index).show();
        $('.tab1').hide();
    }
}