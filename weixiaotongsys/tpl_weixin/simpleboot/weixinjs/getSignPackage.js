$("document").ready(function() {
    //alert(window.location.href);
    var url = window.location.href;
	//var parameter = window.location.search;

    // if(parameter){
		//url = url.replace(parameter,"");
	// }
	//var b  = url.replace(a,"11")
	//console.log(url);
    
    $.ajax({
        type: "post",
        url: 'http://mp.zhixiaoyuan.net/index.php/Weixin/WeChat/getSignPackage',
        async: false,
        data: {
            url: url
            //parameter:parameter
        },
        dataType: 'json',
        success: function(data) {
            //console.log(data);
            var appId = data.appId;
            var timestamp = data.timestamp;
            var nonceStr = data.nonceStr;
            var signature = data.signature;

            wx.config({
                debug: false,
                appId: appId,
                timestamp: timestamp,
                nonceStr: nonceStr,
                signature: signature,
                jsApiList: [
                    //这里要写调用的api列表
                    'checkJsApi', 'onMenuShareTimeline', 'chooseImage', 'previewImage', 'uploadImage', 'downloadImage','hideMenuItems','hideAllNonBaseMenuItem',
                ]
            });
            wx.ready(function(){
                //批量隐藏功能
                wx.hideMenuItems({
                    menuList: ['menuItem:share:qq',
                        'menuItem:share:weiboApp',
                        'menuItem:favorite',
                        'menuItem:share:facebook',
                        'menuItem:share:QZone',
                        'menuItem:share:timeline',
                        'menuItem:share:appMessage',
                        'menuItem:copyUrl',
                        'menuItem:share:email',
                        'menuItem:openWithQQBrowser',
                        'menuItem:exposeArticle',
                        'menuItem:setFont'

                    ] // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
                });
                wx.hideAllNonBaseMenuItem();
            });
        },
        error:function(data){

        },
    })
})