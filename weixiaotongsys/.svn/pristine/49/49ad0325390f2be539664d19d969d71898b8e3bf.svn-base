var tabsSwiper;
//获取项目名称
function getPath() {
    var pathName = document.location.pathname;
    var index = pathName.substr(1).indexOf("/");
    var result = pathName.substr(0, index + 1);
    return result;
}

var file = getPath();
var mobile = {
    init: function () {
        //自适应设置
        mobile.rem();
        //设置body高
        mobile.setBodyHeight();
    },
    setBodyHeight: function () {
        var bodyHeight = document.documentElement.clientHeight || document.body.clientHeight;
        var oDiv = document.getElementById("container");
        oDiv.style.height = bodyHeight + 'px';
    },
    rem: function () {
        var w = document.documentElement.clientWidth;
        if (w / 1 > 640) {
            w = 640;
        }
        var rems = (w / 320) * 10;   //1rem=10px
        document.documentElement.style.fontSize = rems + 'px';
    },
    slide: function () {
        tabsSwiper = new Swiper('.swiper-container', {
            speed: 0,
            onSlideChangeEnd: function (swiper) {
                //alert(swiper.activeIndex) //切换结束时，告诉我现在是第几个slide
                $('#nowPage').html(swiper.activeIndex + 1)
                //console.log(swiper);
            },
            observer: true,//修改swiper自己或子元素时，自动初始化swiper
            observeParents: true,//修改swiper的父元素时，自动初始化swiper
            preventLinksPropagation: true,

        });
        mobile.totalPage();
        //var result = mobile.getUrlParams();
        if(mobile.getCookie('wxt_img')){
            //var page = mobile.getCookie('wxt_page');
            //alert(page);
            mobile.selectClassPhoto(tabsSwiper, mobile.getCookie('wxt_id'), mobile.getCookie('wxt_img'), mobile.getCookie('wxt_page'));
        }
    },
    totalPage: function () {
        $('#allPage').html($('.swiper-slide').length);
    },
    pagePrev: function () {
        $('#footer .prev').click(function () {
            tabsSwiper.slidePrev();
        })
    },
    pageNext: function () {
        $('#footer .next').click(function () {
            tabsSwiper.slideNext();
        })
    },
    pageContent: function () {

        var cid = $('#classid').val();
        var sid = $('#studentid').val();
        var gid = $('#gradeid').val();
        var aid = $('#archivesid').val();
        //ajax获取数据
        $.ajax({
            type: 'get',
            //url: file+'/index.php/weixin/TchGrowtharchives/studentPageList',
            url: root + '/weixin/Growtharchives/showstudentPageList',
            data: {cid: cid, sid: sid, gid: gid, aid: aid},
            dataType: 'json',
            success: function (arr) {
                console.log(arr);
                var pageWidth = $('.swiper-wrapper').css('width');
                var pageHeight = $('.swiper-wrapper').css('height');
                var html = '';
                for (var i = 0; i < arr.length; i++) {
                    if (i == 0) {
                        html += "<div data-pid='" + arr[i]['pid'] + "' data-textcount='" + arr[i]['text_count'] + "' data-imgcount='" + arr[i]['img_count'] + "' class='swiper-slide swiper-slide-visible swiper-slide-active'>";
                    } else {
                        html += "<div  data-pid='" + arr[i]['pid'] + "' data-textcount='" + arr[i]['text_count'] + "' data-imgcount='" + arr[i]['img_count'] + "' class='swiper-slide'>";
                    }
                    if (arr[i]['img_count']) {
                        //alert(1);
                        html += '<div style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;" class="img_box_wrap">';
                        var res = arr[i]['content'];
                        for (var j = 0; j < res.length; j++) {

                            if (res[j]['type'] == 1) {
                                var wR = parseFloat(pageWidth) / 646;
                                var hR = parseFloat(pageHeight) / 910;
                                var w = res[j]['width'] * wR;
                                var h = res[j]['height'] * hR;
                                var l = res[j]['left'] * wR;
                                var t = res[j]['top'] * hR;
                                //alert(res[j]['img'])
                                //html += '<div data-id="' + res[j]['id'] + '" class="imgbox imgbox0" id="box' + res[j]['id'] + '" style="position: absolute; overflow: hidden; background: url(/statics/image/add_pic.png) center center / 100px no-repeat rgb(238, 238, 238);';
                                html += '<div data-id="' + res[j]['id'] + '" class="imgbox imgbox0" id="box' + res[j]['id'] + '" style="position: absolute; overflow: hidden; ';
                                html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;" data-imgurl="">';
                                //alert(res[j]['img'])
                                if (res[j]['img']) {
                                    html += '<img style="width:100%; height:100%"  src="' + res[j]['img'] + '">';
                                }
                                html += '</div>';
                                // html += '<div onclick="mobile.selectPhoto(this, '+res[j]['id']+')" data-id="' + res[j]['id'] + '" class="img_click" id="img_click_'+ res[j]['id'] +'"  style="position: absolute;width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;z-index: 5;"></div>';
                                html += '<div  data-id="' + res[j]['id'] + '" class="img_click" id="img_click_'+ res[j]['id'] +'"  style="position: absolute;width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;z-index: 5;"></div>';
                                //html += '<div class="img_click"  style="position: absolute;width: '+w+'px; height: '+h+'px;left: '+l+'px;top: '+t+'px;z-index: 5;"></div>';
                                //
                            }
                        }
                        html += '</div>';
                    }

                    if (arr[i]['text_count']) {
                        var res = arr[i]['content'];
                        html += '<div style="position: absolute;top: 0;left: 0;width: 100%;height: 100%;z-index: 1;" class="desc_box_wrap">';
                        for (var j = 0; j < res.length; j++) {
                            if (res[j]['type'] == 0) {
                                var wR = parseFloat(pageWidth) / 646;
                                var hR = parseFloat(pageHeight) / 910;
                                var w = res[j]['width'] * wR;
                                var h = res[j]['height'] * hR;
                                var l = res[j]['left'] * wR;
                                var t = res[j]['top'] * hR;
                                html += '<div data-id="' + res[j]['id'] + '" id="box' + res[j]['id'] + '" class="textbox textbox0" style="position: absolute; overflow: hidden; background: rgb(238, 238, 238);'
                                html += 'width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px; transform: rotate(0deg); border-radius: 0%;">';
                                html += '<textarea readonly id="texts" style="width: ' + w + 'px; height: ' + h + 'px;left: ' + l + 'px;top: ' + t + 'px;border:none;background-color:transparent;resize:none;color:#8f5731;font-size:16px;font-family:微软雅黑,Helvetica" draggable="false" placeholder="请从输入文字...">';
                                if (res[j]['text']) {
                                    html += res[j]['text'];
                                }
                                html += '</textarea></div>'
                            }

                        }
                        html += '</div>';
                    }
                    html += '<div class="mask" style="background: rgba(0, 0, 0, 0) url(' + arr[i]['img'] + ') scroll 0% 0% / 100% 100% no-repeat;"></div>';
                    html += '</div>';
                }
                //alert(html)
                $(".swiper-container").find('.swiper-wrapper').html(html);
                mobile.slide();
                //计算总页数
                mobile.totalPage();
            },
            eror: function () {

            }
        });
    },
    pageWidth: function () {
        var width = $('.swiper-wrapper').css('width');
        return width;
    },
    pageHeight: function () {
        var height = $('.swiper-wrapper').css('height');
        return height;
    },
    selectPhoto: function (obj, id) {
        //上传动画
        $('#select_photo').animate({bottom: 0}, 300);
        $('.edit_bg').css('display', 'block');
        $('.edit_bg').animate({opacity: .5}, 300);

        //去除所有的select_bg
        $('.imgbox').each(function (k,v) {
            if($(this).hasClass('select_bg')){
                $(this).removeClass('select_bg');
            }
        });
        $('#box'+id).addClass('select_bg');

        $('#select_id').val(id);

        //var page = tabsSwiper.activeIndex;
        //文件上传
        //mobile.uploadClient(obj, id);
    },
    hideSelectPhoto: function (obj) {
        $('#select_photo').animate({bottom: "-13rem"}, 300);
        $('.edit_bg').css('display', 'none');
        $('.edit_bg').animate({opacity: 0}, 300);
    },
    uploadClient: function () {
        mobile.hideSelectPhoto();
        mobile.show();
        //alert("开始")
        var upload = document.getElementById('capture');
        //alert(typeof upload);
        /*上传照片*/
        var fileReader;
        var _img = new Image();
        //alert("_img="+_img)
        //获取用户所选的文件
        var formData = '';
        //解决上传相同文件不触发onchange事件
        var clone = upload.cloneNode(true);
        clone.onchange = arguments.callee; //克隆不会复制动态绑定事件

        var file = upload.files[0];
        //alert('file='+file)
        var files = upload.files;
        //判断是否为图片文件
        for (var k = 0; k < files.length; k++) {
            if (!/image\/\w+/.test(files[k].type)) {
                alert(files[k].name + "不是图像文件!");
            }
        }

        fileReader = new FileReader();
        if (file) {
            // var reader = new FileReader();
            // reader.onload = function(evt){
            //     alert(evt.target.result);
            // }
            // reader.readAsDataURL(file);
            var w = $('.select_bg').css('width');
            var h = $('.select_bg').css('height');
            formData = new FormData();
            //formData.append("file", file);
            formData.append("file", file);
            formData.append('width', parseInt(w));
            formData.append('height', parseInt(h));
            //alert(parseInt(w));
            //console.log('formData='+file)
        }
        mobile.uploadServer( formData, tabsSwiper.activeIndex);
    },
    // uploadClient: function (obj, id) {
    //     /*上传照片*/
    //     var fileReader;
    //     var fileName;
    //     var _img = new Image();
    //     //获取用户所选的文件
    //     var upload = document.getElementById('capture');
    //     var formData = '', file = '';
    //     upload.addEventListener('change', function () {
    //         //解决上传相同文件不触发onchange事件
    //         var clone = upload.cloneNode(true);
    //         clone.onchange = arguments.callee; //克隆不会复制动态绑定事件
    //
    //         file = upload.files[0];
    //         var files = upload.files;
    //         //判断是否为图片文件
    //         for (var k = 0; k < files.length; k++) {
    //             if (!/image\/\w+/.test(files[k].type)) {
    //                 alert(files[k].name + "不是图像文件!");
    //             }
    //         }
    //
    //         fileReader = new FileReader();
    //         if (file) {
    //             // fileReader.onload = function () {  //显示用户所选的缩略图
    //             //     _img.src = this.result;
    //             //     _img.style.height = '100%';
    //             //     _img.style.width = '100%';
    //             //     $('.select_bg').html(_img);
    //             //     mobile.hideSelectPhoto();
    //             // }
    //             // fileReader.readAsDataURL(file); //获取api异步读取的文件数据
    //             formData = new FormData();
    //             //formData.append("file", file);
    //             formData.append("file", file);
    //         }
    //         mobile.uploadServer(obj, formData, id, tabsSwiper.activeIndex);
    //     }, false);
    // },
    uploadServer: function (file, page){
        $.ajax({
            url: root + "/weixin/TchGrowtharchives/upload",
            type: "POST",
            data: file,
            cache: false,
            processData: false,  // 告诉jQuery不要去处理发送的数据
            contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
            dataType: "json",
            success: function (res) {
                if (res.img) {
                    var id = $('#select_id').val();
                    var img = imgSrcInHost + res.img;
                    //alert(img);
                    //从cookie中获取数据
                    var value = mobile.getCookie('photolist');
                    if (value == null){
                        var arr = [];
                        var obj = {};
                        obj.page = page;
                        obj.id=id;
                        obj.img = img;
                        arr.push(obj);
                        //设置cookie
                        mobile.setCookie('photolist',JSON.stringify(arr));
                    }else{
                        //判断是否存在相同的数据
                        var data = JSON.parse(value);
                        for (var i = 0; i < data.length; i++){
                            if (data[i]['id'] == id){
                                data[i]['img'] = img;
                            }else{
                                var obj = {};
                                obj.page = page;
                                obj.id=id;
                                obj.img = img;
                                data.push(obj);
                            }
                        }
                        mobile.setCookie('photolist', JSON.stringify(data));
                    }
                    var value = mobile.getCookie('photolist');
                    var data = JSON.parse(value);
                    for (var i = 0;i < data.length; i++){
                        var html = '<img src="'+data[i]['img']+'" style="width: 100%;height: 100%"/>';
                        $('#box'+data[i]['id']).html(html);
                        $('#box'+data[i]['id']).attr("data-imgurl", data[i]['img']);
                    }
                    var html = '';
                    html += '<img src="' + img + '" style="width: 100%;height: 100%;"/>';
                    //alert(html);
                    $('.select_bg').html(html);
                    $('.select_bg').attr("data-imgurl", img);
                    $('.select_bg').parent().parent().attr('data-change', 'Y');
                }else{
                    alert("上传图片出错");
                }
                mobile.hide();
            },
            error: function () {
                alert("错误");
                mobile.hide();
                mobile.hideSelectPhoto();
            }
        });
    },
    show: function () {
        $('#caseViolette').show();
        $('.edit_bg').css('display', 'block');
        $('.edit_bg').animate({opacity: .5}, 0);
    },
    hide: function () {
        $('#caseViolette').hide();
        $('.edit_bg').css('display', 'none');
        $('.edit_bg').animate({opacity: 0}, 0);
    },
    save: function () {
        $('#save').click(function () {
            if (confirm("你确定要保存吗？")) {
                var gradeid = $('#gradeid').val();                 //年级id
                var archivesid = $('#archivesid').val();           //档案id
                var studentId = $('#studentid').val();  //学生id
                var img = [];
                var text = [];
                var isOk = [];
                $('.swiper-slide').each(function (k, v) {
                    if ($(this).attr('data-change') == '') {
                        return true;
                    }
                    //获取图片的数量
                    var imgCount = $(this).attr("data-imgcount");
                    //获取文字的数量
                    var textCount = $(this).attr("data-textcount");
                    //用户上传的图片数量
                    var imgLen = $(this).find('img').length;
                    var textlen = $(this).find('textarea').length;
                    //获取当前页
                    var pid = $(this).attr("data-pid");

                    //该页存在图片
                    if (imgCount && imgLen) {

                        for (var i = 0; i < imgLen; i++) {
                            var objImg = {};
                            objImg.pid = pid;
                            objImg.sid = studentId;
                            objImg.aid = archivesid;
                            objImg.gid = gradeid;
                            var oImg = $(this).find('img').eq(i);
                            //alert("id="+oImg.parent().attr('data-id')+"img="+oImg.attr('src'))
                            objImg.id = oImg.parent().attr('data-id');
                            objImg.type = 1;
                            objImg.content = oImg.attr('src');
                            //console.log(img);
                            img.push(objImg);
                        }
                    }
                    if (textCount && textlen) {
                        var obj = {};
                        obj.pid = pid;
                        obj.sid = studentId;
                        obj.aid = archivesid;
                        obj.gid = gradeid;
                        for (var i = 0; i < textlen; i++) {
                            var oText = $(this).find('textarea').eq(i);
                            obj.id = oText.parent().attr('data-id');
                            obj.type = 0;
                            obj.content = oText.val();
                            text.push(obj);
                        }
                    }

                    var flag_1 = false;
                    var flag_2 = false;
                    console.log(imgCount);
                    //判断当前页是否完成
                    if (imgCount == imgLen) {
                        flag_1 = true;
                    } else {
                        flag_1 = false
                    }
                    if (textCount != 0) {
                        var num = 0;
                        for (var j = 0; j < textlen; j++) {
                            var oText = $(this).find('textarea').eq(j);
                            if (oText.val()) {
                                num++;
                            }
                        }
                        if (textCount == num) {
                            flag_2 = true;
                        } else {
                            flag_2 = false;
                        }
                    }else{
                        flag_2 = true;
                    }
                    var obj = {};
                    obj.archivesid = archivesid;
                    obj.studentid = studentId;
                    obj.pageid = pid
                    if (flag_1 && flag_2) {
                        obj.finish = 1;
                    } else {
                        obj.finish = 0;
                    }
                    console.log(obj);
                    isOk.push(obj);

                });
                console.log(img);
                mobile.saveAjax(img, text, isOk);
            }
        });
    },
    saveAjax: function (img, text, isOk) {
        console.log(isOk);
        $.ajax({
            url: root + "/weixin/Growtharchives/save",
            type: "POST",
            data: {img: img, text: text, isFinish: isOk},
            dataType: "json",
            success: function (res) {
                if (res.status == 200) {
                    alert("保存成功");
                    mobile.deleteCookie('wxt_page');
                    mobile.deleteCookie('wxt_id');
                    mobile.deleteCookie('photolist');
                    mobile.deleteCookie('wxt_img');
                    location.href = root+"/weixin/Growtharchives/studentPage?cid="+cid+"&sid="+sid+"&gid="+gid+"&aid="+aid;
                } else {
                    alert("保存失败");
                }
            },
            error: function () {
                alert("错误");
            }
        });
    },
    getUrlParams: function () {
        var url = location.href;
        var paraString = url.substring(url.indexOf("?")+1,url.length).split("&");
        //alert(paraString)
        var paraObj = {}
        for (i=0; i < paraString.length; i++){
            paraObj[paraString[i].substring(0,paraString[i].indexOf("=")).toLowerCase()] = paraString[i].substring(paraString[i].indexOf("=")+1,paraString[i].length);
        }
        return paraObj;
    },
    selectClassPhoto: function (tabsSwiper, id, img, page) {
        //alert(page);
        //从cookie中获取数据
        var value = mobile.getCookie('photolist');
        //cookie中没有数据
        if (value == null){
            var arr = [];
            var obj = {};
            obj.page = page;
            obj.id=id;
            obj.img = img;
            arr.push(obj);
            //设置cookie
            mobile.setCookie('photolist',JSON.stringify(arr));
        }else{
            //判断是否存在相同的数据
            var data = JSON.parse(value);
            for (var i = 0; i < data.length; i++){
                if (data[i]['id'] == id){
                    data[i]['img'] = img;
                }else{
                    var obj = {};
                    obj.page = page;
                    obj.id=id;
                    obj.img = img;
                    data.push(obj);
                }
            }
            //数据分发
            for (var i = 0;i < data.length; i++){
                var html = '<img src="'+data[i]['img']+'" style="width: 100%;height: 100%"/>';
                //alert(tabsSwiper.slides.length);
                $('#box'+data[i]['id']).html(html);
            }

            mobile.setCookie('photolist', JSON.stringify(data));
        }
        //alert(page);
        var html = '<img src="'+img+'" style="width: 100%;height: 100%"/>';
        $('#box'+id).html(html);
        $('#nowPage').html((parseInt(page)));
        tabsSwiper.slideTo((parseInt(page) - 1), 0, false);//切换到第一个slide，速度为1秒
    },
    setCookie: function (name, value) {
        var Days = 30;
        var exp = new Date();
        exp.setTime(exp.getTime() + Days*24*60*60*1000);
        document.cookie = name + "="+ value + ";expires=" + exp.toGMTString() + ";path=/";
    },
    getCookie: function (name) {
        var arr,reg=new RegExp("(^| )"+name+"=([^;]*)(;|$)");
        if(arr=document.cookie.match(reg))
            return arr[2];
        else
            return null;
    },
    deleteCookie: function (name) {
        var exp = new Date();
        exp.setTime(exp.getTime() - 1);
        var cval=mobile.getCookie(name);
        if(cval!=null){
            document.cookie= name + "="+cval+";expires="+exp.toGMTString()+";path=/";
        }
    },
    getActiveStudentPic: function () {
        alert(1)
        var studentid = $('#personal_left .active').attr("data-id");
        $.ajax({
            type: 'post',
            url: root+'/weixin/Growtharchives/getNowBabyPic',
            data: {sid: studentid},
            dataType: 'json',
            success: function (res) {
                var html = '';
                html += '<div id="box'+res[0]['studentid']+'" class="student_photo">';
                for (var i = 0; i < res.length; i++){
                    html +='<div class="photo_list"><div class=""></div>';
                    html +='<img src="'+res[i]['pictureurl']+'" alt="" style="width: 100%;height: 100%"></div>';
                }
                html += '</div>';
                alert(html);
                $('#content_box').html(html);
            },
            error: function () {
                alert("错误");
            }
        });
    }
};



//初始化项目
mobile.init();
window.onload = function () {
    mobile.pageContent();
    mobile.pagePrev();
    mobile.pageNext();

    $('.edit_bg').click(function () {
        var isShow = $('#caseViolette').css('display');
        if (isShow != 'block'){
            mobile.hideSelectPhoto(this);
        }
    });

    $('#select_photo > .cancel').click(function () {
        mobile.hideSelectPhoto(this);
    });
    mobile.save();
}

