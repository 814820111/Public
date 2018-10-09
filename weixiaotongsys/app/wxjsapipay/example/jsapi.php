<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "../lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("../logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

if ($_GET["oid"]) {
	$oid = $_GET["oid"];
	setcookie("oid", $oid, time()+1800);
} else {
	$oid = $_COOKIE['oid'];
}
$mysql_server_name      = "123.57.58.205";              //数据库服务器名称
$mysql_username         = "root";                       // 连接数据库用户名
$mysql_password         = "Sp881020";                   // 连接数据库密码
$mysql_database         = "xunpai";                     // 数据库的名字
/*	
$mysql_server_name      = "115.28.37.140";              //数据库服务器名称
$mysql_username         = "xunpai";                       // 连接数据库用户名
$mysql_password         = "123456";                   // 连接数据库密码
$mysql_database         = "xunpai";                     // 数据库的名字
*/
// 连接到数据库
$conn = mysql_connect($mysql_server_name, $mysql_username, $mysql_password);
// 修改订单状态
$os_sql = "select * from x_orders where id = $oid";
$orders_qu = mysql_db_query($mysql_database, $os_sql, $conn);
$orders_row = mysql_fetch_row($orders_qu);
if (!$orders_row) {
	var_dump('订单信息有误！');die;
}
if ($orders_row[6] != 1){
	$this->error('订单状态异常！');
}
if ($orders_row[6] == 1 && ($orders_row[9] + 1800) < time()) {
	$oss_sql = "update x_orders set state=0 where id = $oid";
	mysql_db_query($mysql_database, $oss_sql, $conn);
	$this->error('订单已过期！');
}
if ($orders_row[6] == 0){
	$this->error('订单已过期！');
}
if ($orders_row[6] != 1){
	$this->success('订单已付定金', U("Orders/Myorder/index"));die;
}
$osg_sql = "select * from x_orders_goods where orders_id = " . $oid;
$osg_qu = mysql_db_query($mysql_database, $osg_sql, $conn);
$osg_row = mysql_fetch_row($osg_qu);

$opg_sql = "select * from x_p1_goods where id = " . $osg_row[2];
$opg_qu = mysql_db_query($mysql_database, $opg_sql, $conn);
$opg_row = mysql_fetch_row($opg_qu);

$oc_money = 0;
if ($orders_row[5]) {
	$ocs_sql = "select * from x_orders_coupons where id = " . $orders_row[5];
	$ocoupons_qu = mysql_db_query($mysql_database, $ocs_sql, $conn);
	$ocoupons_row = mysql_fetch_row($ocoupons_qu);
	if ($ocoupons_row['state'] = 2) {
		var_dump('优惠券已被使用');die;
	}
	if ($opg_row[9] != $ocoupons_row[2]) {
		var_dump('非本城市优惠券');die;
	}
	if (($opg_row[7] - $ocoupons_row[5]) < 0) {
		var_dump('优惠券价格不能大于商品价格');die;
	}
	$oc_money = $ocoupons_row[5];
}
$price = $osg_row[4] - $oc_money;
$end_price = $price * 100;
//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
//统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("寻拍-".$opg_row[1]);
$input->SetAttach("寻拍-".$opg_row[1]);
$input->SetOut_trade_no($orders_row[1]);
$input->SetTotal_fee($end_price);
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 1800));
$input->SetGoods_tag($opg_row[1]);
$input->SetNotify_url("http://woyaoxunpai.com/app/wxjsapipay/example/notify.php");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
$jsApiParameters = $tools->GetJsApiParameters($order);
?>

<!DOCTYPE html>
<html id="html">
<head lang="en">
<meta charset="UTF-8">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>微信支付</title>
	<link rel="stylesheet" href="/xunpaiweixin/css/fx_WeiXin.css"/>
	<script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				if (res.err_msg == "get_brand_wcpay_request:ok") {
			                alert("支付成功");
					location.href = "http://woyaoxunpai.com/index.php?g=app&m=orders&a=myorder";
		                }
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	</script>
</head>
<body>
<div id="wrap">
    <div id="title">
        <div class="TitleBox">
             <p>请在提交订单后<span>30</span>分钟内支付定金，否则订单会自动取消。</p>
        </div>
    </div>
    <div id="submit">
        <p class="pp">您的订单提交已提交成功!</p>
        <p>订单号:<?php echo $orders_row[1]; ?></p>
        <p class="earnest">应付定金:<span>￥<?php echo $price; ?></span></p>
    </div>
    <div id="detail">
        <h1>订单详情</h1>
        <p><span class="z">服务</span><span class="y"><?php echo $opg_row[1]; ?>产品</span></p>
        <p><span class="z">选择拍摄城市</span><span  class="y">北京</span></p>
        <p><span class="z">数量</span><span class="y">1</span></p>
        <p><span class="z">单价</span><span class="y">￥<?php echo $opg_row[2]; ?></span></p>
        <p class="totle"><span class="z"></span>定金:￥<?php echo $opg_row[7]; ?>+尾款:￥<?php echo $opg_row[8]; ?></p>
    </div>
    <div id="bottom"></div>
    <div id="btn">
        <a href="javascript:;" onclick="callpay()" ><button>微信支付</button></a>
    </div>

</div>
<script src="/xunpaiweixin/js/jquery-1.9.1.min.js"></script>
<script src="/xunpaiweixin/js/fx_WeiXin.js"></script>
</body>
</html>
