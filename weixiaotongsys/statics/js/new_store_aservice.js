$(document).ready(function(){
    $('#shop_store_box').click(function(){
        $("#img_index").val('');
        $('input[name="img_file"]').trigger('click');
    });
});
KindEditor.ready(function(K) {
    uploadFile(K, 'upload_logo', 'img_file', "index.php?g=Product&m=product&a=uploadImg_aservice");
});
function uploadFile(obj, button, fieldName, uploadUrl){
    var uploadImg = obj.uploadbutton({
        button : $('#'+button)[0],
        fieldName : fieldName,
        url : uploadUrl,
        afterUpload : function(data){
             if (data.error === 0) {
                url=data.url;
                var temp = $("#img_index").val();
                var imgHtml = '<img src="'+url+'" style="width:100px;height:100px;" id="img" alt="">';
                if(temp == ''){
                    addLaunchBody(obj, imgHtml, url);
                }else{
                    editLaunchBody(temp, imgHtml);
                }
            }else{
                alert(data.errMsg);
            }
        },
        afterError : function(s) {
            alert('自定义错误信息: ' + s);
        }
    });
    uploadImg.fileBox.change(function(e) {
        uploadImg.submit();
    });
}
function addLaunchBody(obj, body, url){
    var html = '<li class="launch_dom">'+
    '<div class="launch_content">'+body+'</div>'+
    //'<div class="msg_card_mask"><span></span>'+
    //'<a class="js_edit" href="javascript:void(0);">&nbsp;</a><a class="js_del" href="javascript:void(0);">&nbsp;</a>'+
    //'</div>'+
    '<input type="hidden"  name="url[]" value="'+url+'">'+
    '</li>';
    $('#launch_body').append(html);
    bodyAction(obj);
    //checklaunchBody();
}
function editLaunchBody(bodyIndex, body){
    $('.launch_dom:eq('+bodyIndex+') .launch_content').html(body);
}
function bodyAction(obj){
    $('.js_edit').off().on('click', function(){
        var bodyObj = $(this).parent().parent()
        var bodyIndex = bodyObj.index();
        $("#img_index").val(bodyIndex);
        $('input[name="img_file"]').trigger('click');
    });
    $('.js_del').off().on('click', function(){
        var thisObj = $(this).parent().parent().remove();
    });
}
