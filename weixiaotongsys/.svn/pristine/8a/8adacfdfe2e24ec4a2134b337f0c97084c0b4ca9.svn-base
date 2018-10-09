    function tmies(tmiec) {

    	var timeStr = tmiec; //时间戳你自已取的值
    	var tim = new Date(parseInt(timeStr) * 1000); //如果时间戳是后端生成 要 * 1000
    	var year = tim.getFullYear(); //年
    	var month = tim.getMonth() + 1; //月
    	month = month < 10 ? '0' + month : month;
    	var day = tim.getDate(); //日
    	day = day < 10 ? '0' + day : day;
    	var Hours = tim.getHours(); //时
    	Hours = Hours < 10 ? '0' + Hours : Hours;
    	var Minutes = tim.getMinutes(); //分
    	Minutes = Minutes < 10 ? '0' + Minutes : Minutes;
    	var aler = year + '-' + month + '-' + day + '&nbsp;&nbsp;' + Hours + '&nbsp;:' + Minutes;

    	return aler;

    }
    //
    function tmiess(tmiec) {

    	var timeStr = tmiec; //时间戳你自已取的值
    	var tim = new Date(parseInt(timeStr) * 1000); //如果时间戳是后端生成 要 * 1000
    	var year = tim.getFullYear(); //年
    	var month = tim.getMonth() + 1; //月
    	month = month < 10 ? '0' + month : month;
    	var day = tim.getDate(); //日
    	day = day < 10 ? '0' + day : day;

    	var aler = year + '-' + month + '-' + day;
    	var er = aler.replace("-", "");
    	var character = er.replace("-", "");
    	return character;

    }

    //把当前时间转换成时间戳的方法  
    var getWeek = function(year, month) {
    	//1.根据年度和月份，创建日期
    	//应该先对year,month进行整数及范围校验的。
    	var d = new Date();
    	d.setYear(year);
    	d.setMonth(month - 1);
    	d.setDate(1);
    	console.log(d);
    	//获得周几
    	var weeks = ['7', '1', '2', '3', '4', '5', '6'];
    	return weeks[d.getDay()];
    }

    //把当前时间转换成时间搓      
    function transdate(endTime) {
    	var date = new Date();
    	date.setFullYear(endTime.substring(0, 4));
    	date.setMonth(endTime.substring(5, 7) - 1);
    	date.setDate(endTime.substring(8, 10));
    	date.setHours(endTime.substring(11, 13));
    	date.setMinutes(endTime.substring(14, 16));
    	date.setSeconds(endTime.substring(17, 19));
    	return Date.parse(date) / 1000;
    }




    //  var w1 = getMyDay(new Date("2017-3-21"));调用的方法
    //校园食谱封装的方法
    //时间减法
  			function cc(dd, dadd) {
				//可以加上错误处理
				var a = new Date(dd)
				a = a.valueOf()
				a = a - dadd * 24 * 60 * 60 * 1000
				a = new Date(a)
				var r=a.getMonth() + 1;
			    if(r!=1){
			    	var r="0"+r;
			    }
				var shi = a.getFullYear() + "-" + r + "-" + a.getDate();
				return shi;
			}
//时间加法
			function sd(dd, dadd) {
				//可以加上错误处理
				var a = new Date(dd)
				a = a.valueOf()
				a = a + dadd * 24 * 60 * 60 * 1000
				a = new Date(a)
				var r=a.getMonth() + 1;
                // if(r!=1){
			    	// var r="0"+r;
                // }
              if(r==10 || r==11 || r==12){
                	var r = r;
			  }else if(r!=1){
                  var r="0"+r;
			  }
				var shi = a.getFullYear() + "-" + r + "-" + a.getDate();
				return shi;
				//return r;
			}
//这是日期处于星期几
			function getMyDay(date) {
				var week;
				if(date.getDay() == 0) week = "7"
				if(date.getDay() == 1) week = "1"
				if(date.getDay() == 2) week = "2"
				if(date.getDay() == 3) week = "3"
				if(date.getDay() == 4) week = "4"
				if(date.getDay() == 5) week = "5"
				if(date.getDay() == 6) week = "6"
				return week;
			}
			function getNowFormatDate() {
    var date = new Date();
    var seperator1 = "-";
    var seperator2 = ":";
    var month = date.getMonth() + 1;
    var strDate = date.getDate();
    if (month >= 1 && month <= 9) {
        month = "0" + month;
    }
    if (strDate >= 0 && strDate <= 9) {
        strDate = "0" + strDate;
    }
    var currentdate = date.getFullYear() + seperator1 + month + seperator1 + strDate
            + " " + date.getHours() + seperator2 + date.getMinutes()
            + seperator2 + date.getSeconds();
    return currentdate;
} 
function shijianzhuan(){
	var myDate = new Date(); //实例一个时间对象；
				var nian = myDate.getFullYear(); //获取当前的年
				var yue = myDate.getMonth() + 1; //获取当前的月份
				var dangqian = myDate.getDate(); //当前的日
				var heji = nian + "/" + yue + "/" + dangqian;
				var sign_date = new Date(heji).getTime() / 1000;
				 return sign_date;
}
function shijianzhuansd(){
	var myDate = new Date(); //实例一个时间对象；
				var nian = myDate.getFullYear(); //获取当前的年
				var yue = myDate.getMonth() + 1; //获取当前的月份
				var jiangs = String(new Date(nian, yue, 0)); //2009年6月的第0天，也就是2009年5月的最后一天 
				var ids = parseFloat(jiangs.substring(8, 10)) ;
				var heji = nian + "/" + yue + "/" + ids;
				var sign_date = new Date(heji).getTime() / 1000;
				 return sign_date;
}



function showMsg(text, position) {
				var show = $('.show_msg').length
				if(show > 0) {

				} else {
					var div = $('<div></div>');
					div.addClass('show_msg');
					var span = $('<span></span>');
					span.addClass('show_span');
					span.appendTo(div);
					span.text(text);
					$('body').append(div);
				}
				$(".show_span").text(text);

				$(".show_msg").css('bottom', '70%');

				$('.show_msg').hide();
				$('.show_msg').fadeIn(500);
				$('.show_msg').fadeOut(3000);
			}
	    		
