// // 验证账号是否存在-家长
// var bBtn = false;
// //当账号输入框获得焦点时
// $('#parent_user').bind('focus',function(){
//     bBtn=true;
// })
// //当账号输入框失去焦点时
//     .bind('blur',function(){
//         //如果输入框有内容
//         if($(this).val().length && bBtn){
//             $.ajax(
//                 {
//                     type: 'post',
//                     url: 'index.php?g=apps&m=index&a=applogin',
//                     data: {
//                         'phone': $('#parent_user').val(),
//                         'password': 1,
//                         'user_type' : $('#parent_type').val()
//                     },

//                     success: function (data) {
//                         var data = JSON.parse(data);
//                         console.log(data);
//                         console.log(data.data);
//                         //如果返回用户名不存在，则先检测清空上次的输出内容   重新输出账号不存在，若存在，则只清空
//                         if (data.data == '用户不存在') {
//                             bBtn=false;
//                             $('#parent_user').parent().find($('.error')).text('');
//                             $('#parent_user').parent().append('<span class="error">'+'* '+data.data+'</span>');
//                         } else {
//                             $('#parent_user').parent().find($('.error')).text('');
//                         }
//                     }
//                 }
//             );
//         }else{
//             $('#parent_user').parent().find($('.error')).text('');
//         }
//     });
// //登陆验证-家长
// $('#parent_from').validate({
//     submitHandler : function (form) {

//         $('#parent_from .login_verification').show('slow');

//         $.ajax({
//             type : 'post',
//             url : 'index.php?g=apps&m=index&a=applogin',
//             data : {
//                 'phone' : $('#parent_user').val(),
//                 'password' : $('#parent_password').val(),
//             },
//             success : function(data){
//                 var data = JSON.parse(data);
//                 // console.log(data);
//                 // console.log(data.data);
//                 // console.log(data_arr);
//                 //如果登陆成功
//                 if(data.status=="success"){
//                     $('#parent_from .verification_text').text('登陆成功！');
//                     $('#parent_from .verification_text').css('color','#5cc2e2');
//                     //写入sesson
//                     var userid = data.data.id;
//                     // console.log(userid);
//                     $.ajax({
//                         type: 'post',
//                         url: 'index.php?g=User&m=Login&a=write_sesson',
//                         data : {
//                         'userid' : userid,
//                         },
//                         success: function(data){
//                             // console.log(data);
//                             setTimeout(function(){window.location.href= '/index.php?g=User&m=Center&a=index';},1000)
//                         }
                        
//                     });
                    
//                 }else{
//                     $('#parent_from .verification_text').text(data.data);
//                     $('#parent_from .verification_text').css('color','red');
                    
//                     $('#parent_from .login_verification').delay(1000).hide('slow');
//                 }

//             }
//         });
//     },
//     rules : {
//         phone : {required :false},
//         password : {required : false},
//     },
//     errorClass : 'error',
//     errorElement : "span",
//     errorPlacement: function(error, element) {
//         $(element).parent().append(error);
//     },
//     messages: {
//         phone: {
//             required: "请输入账号",
//         },
//         password: {
//             required: "请输入密码",
//             minlength: "密码太短",
//         }
//     }
// });
//兼容IE8的空console对象  
window.console = window.console || {  
    log: $.noop,  
    debug: $.noop,  
    info: $.noop,  
    warn: $.noop,  
    exception: $.noop,  
    assert: $.noop,  
    dir: $.noop,  
    dirxml: $.noop,  
    trace: $.noop,  
    group: $.noop,  
    groupCollapsed: $.noop,  
    groupEnd: $.noop,  
    profile: $.noop,  
    profileEnd: $.noop,  
    count: $.noop,  
    clear: $.noop,  
    time: $.noop,  
    timeEnd: $.noop,  
    timeStamp: $.noop,  
    table: $.noop,  
    error: $.noop  
};  

// 验证账号是否存在-教师
var bBtn_tea = false;
//当账号输入框获得焦点时
$('#teacher_user').bind('focus',function(){
    bBtn_tea=true;
})
//当账号输入框失去焦点时
    .bind('blur',function(){
        //如果输入框有内容
        if($(this).val().length && bBtn_tea){
            $.ajax(
                {
                    type: 'post',
                    url: 'index.php?g=apps&m=Teacher&a=teacher_login',
                    data: {
                        'phone': $('#teacher_user').val(),
                        'password': 1
                    },

                    success: function (data) {
                        var data = JSON.parse(data);                                          
                        //如果返回用户名不存在，则先检测清空上次的输出内容   重新输出账号不存在，若存在，则只清空
                        if (data.data == '用户不存在') {
                            bBtn_tea=false;
                            $('#teacher_user').parent().find($('.error')).text('');
                            $('#teacher_user').parent().append('<span class="error">'+'* '+data.data+'</span>');
                        } else {
                            bBtn_tea=true;
                            $('#teacher_user').parent().find($('.error')).text('');
                        }
                    }
                }
            );
        }else{
            $('#teacher_user').parent().find($('.error')).text('');
        }
    });
//登陆验证-教师



  $('.tijiao').click(function(){
     
    


      // console.log('dsadsa');
        
         var schoolid =  $("input[type='radio']:checked").val();
         var userid = $("input[type='radio']:checked").attr('data-id');
     

        if(!$("input[type='radio']:checked").val())
        {
            alert('选择学校不能为空!');
            return false;
        }

               $.ajax({
                         type : 'post',
                            //将用户信息写入session会话
                            url : 'index.php?g=user&m=Login&a=write_user_session',
                            data : {
                                'userid' : userid,
                                'schoolid' : schoolid
                            },
                          success : function(){
                                setTimeout(function(){window.location.href= 'index.php?g=Teacher&a=index';},1000)
                    }
                 });

  })

     
   



$('#teacher_from').validate({
    submitHandler : function (form) {
        $('#teacher_from .login_verification').show('slow');
        var obj = $('.numberic');
        $.ajax({
            type : 'post',
            url : '?g=apps&m=Teacher&a=teacher_login_pc',
            data : {
                'phone' : $('#teacher_user').val(),
                'password' : $('#teacher_password').val(),
                'verify': $('#verrify').val()
            },
            success : function(data){
                 //如果账号密码验证成功
                 //解析返回的json数据
                $('#teacher_from .verification_text').css('color','red');
                $('#teacher_from .verification_text').text('验证成功!');

                var data = JSON.parse(data);
                if(data.status=="success"){
                    if(data.password_change==1){
                        alert("您的密码为初始密码,请您尽快修改密码!");
                    }
                    //如果账号密码验证成功，此处返回status，userid，以及对应得array学校信息
                    var schoollist = data.data;
                    var schoollist_length = schoollist.length;
                    //判断绑定的学校情况，如果未绑定学校，则返回账户未绑定学校，登录失败！
                    // console.log(schoollist_length);
                    if(schoollist_length == 0){
                        $('#teacher_from .verification_text').text('此账户未绑定学校！');
                        $('#teacher_from .verification_text').css('color','red');
                    }
                    //只绑定了一个，则直接进入
                    else if(schoollist_length == 1){
                      console.log("学校就有一个");
                        var schoolid = schoollist[0]['schoolid'];
                        var userid = data.userid;
                        //console.log('只绑定了一个，直接进入。获取到的学校id是'+schoolid+'userid是'+userid);
                        $.ajax({
                            type : 'post',
                            //将用户信息写入session会话
                            url : 'index.php?g=user&m=Login&a=write_user_session',
                            data : {
                                'userid' : userid,
                                'schoolid' : schoolid
                            },
                            success : function(){
                                setTimeout(function(){window.location.href= 'index.php?g=Teacher&a=index';},1000)
                            }
                        });
                    }else if(schoollist_length > 1){
					//学校有多个
                      $('.daitan').css('display','block');   

                        for (var i =0;i<schoollist.length;i++){
                             obj.append('<span class="dbzr" style="margin-right: 15px; cursor: pointer;"><input type=radio style="vertical-align: -2px; " data-id="'+data.userid+'" value='+schoollist[i]['schoolid']+' name="school">'+schoollist[i]['schoolname']+'</span>');

                        }
                    }
                }else{
                     $('#teacher_from .verification_text').text(data.data);
                     $('#teacher_from .verification_text').css('color','red');
                    
                     $('#teacher_from .login_verification').delay(1000).hide('slow');
                 }
                
                //绑定了多个学校，跳转到选择学校页面

                //如果登陆成功
                // if(data.=="success"){
                //     $('#teacher_from .verification_text').text('登陆成功！');
                //     $('#teacher_from .verification_text').css('color','#5cc2e2');
                //     //写入sesson
                //     var userid = data.data.id;
                //     // console.log(userid);
                //     $.ajax({
                //         type: 'post',
                //         url: 'index.php?g=User&m=Login&a=write_sesson',
                //         data : {
                //         'userid' : userid,
                //         },
                //         success: function(data){
                //             // console.log(data);
                //             setTimeout(function(){window.location.href= '/index.php?g=User&m=Center&a=index';},1000)
                //         }
                        
                //     });
                    
                // }else{
                //     $('#teacher_from .verification_text').text(data.data);
                //     $('#teacher_from .verification_text').css('color','red');
                    
                //     $('#teacher_from .login_verification').delay(1000).hide('slow');
                // }

            }
        });
    },
    rules : {
        phone : {required :false},
        password : {required : false}
    },
    errorClass : 'error',
    errorElement : "span",
    errorPlacement: function(error, element) {
        $(element).parent().append(error);
    },
    messages: {
        phone: {
            required: "请输入账号"
        },
        password: {
            required: "请输入密码",
            minlength: "密码太短"
        }
    }
});


// // 验证账号是否存在-教师
// var bBtn = false;
// //当账号输入框获得焦点时
// $('#teacher_user').bind('focus',function(){
//     bBtn=true;
// })
// //当账号输入框失去焦点时
//     .bind('blur',function(){
//         //如果输入框有内容
//         if($(this).val().length && bBtn){
//             $.ajax(
//                 {
//                     type: 'post',
//                     url: $('#teacher_from').attr('action'),
//                     data: {
//                         'phone': $('#teacher_user').val(),
//                         'password': 1,
//                         'user_type' : $('#teacher_type').val()
//                     },
//                     success: function (data) {
//                         console.log(data);
//                         //如果返回用户名不存在，则先检测清空上次的输出内容   重新输出账号不存在，若存在，则只清空
//                         if (data.data == '用户不存在') {
//                             bBtn=false;
//                             $('#teacher_user').parent().find($('.error')).text('');
//                             $('#teacher_user').parent().append('<span class="error">'+'* '+data.data+'</span>');
//                         } else {
//                             $('#teacher_user').parent().find($('.error')).text('');
//                         }
//                     }
//                 }
//             );
//         }else{
//             $('#teacher_user').parent().find($('.error')).text('');
//         }
//     });
// //登陆验证-教师
// $('#teacher_from').validate({
//     submitHandler : function (form) {

//         $('#teacher_from .login_verification').show('slow');

//         $.ajax({
//             type : 'post',
//             url : $(form).attr('action'),
//             data : {
//                 'phone' : $('#teacher_user').val(),
//                 'password' : $('#teacher_password').val(),
//                 'user_type' : $('#teacher_type').val()
//             },
//             success : function(data){
//                 console.log(data);
//                 $('#teacher_from .verification_text').text(data.data);

//                 //如果登陆成功
//                 if(data.status){
//                     $('#teacher_from .verification_text').css('color','#5cc2e2');
//                     setTimeout(function(){window.location.href= '/index.php?g=User&m=Center&a=index';},1000);
                    
//                 }else{
//                     $('#teacher_from .verification_text').css('color','red');
//                     $('#teacher_from .login_verification').delay(1000).hide('slow');
//                 }

//             }
//         });
//     },
//     rules : {
//         phone : {required :false},
//         password : {required : false},
//     },
//     errorClass : 'error',
//     errorElement : "span",
//     errorPlacement: function(error, element) {
//         $(element).parent().append(error);
//     },
//     messages: {
//         phone: {
//             required: "请输入账号",
//         },
//         password: {
//             required: "请输入密码",
//             minlength: "密码太短",
//         }
//     }

// });


















