<?php

$mysql_server_name      = "127.0.0.1";              //数据库服务器名称
$mysql_username         = "root";                       // 连接数据库用户名
$mysql_password         = "32ewdscx";                   // 连接数据库密码
$mysql_database         = "zhixiaoyuan";                     // 数据库的名字

include_once './wxBizMsgCrypt.class.php';

// 第三方发送消息给公众平台
$encodingAesKey = "abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG";
$token = "yangyang";
$timeStamp = time();
$nonce = "xxxxxx";
$appId = "wx6e517531101d7d32";

$text = "<xml><ToUserName><![CDATA[oia2Tj我是中文jewbmiOUlr6X-1crbLOvLw]]></ToUserName><FromUserName><![CDATA[gh_7f083739789a]]></FromUserName><CreateTime>1407743423</CreateTime><MsgType><![CDATA[video]]></MsgType><Video><MediaId><![CDATA[eYJ1MbwPRJtOvIEabaxHs7TX2D-HV71s79GUxqdUkjm6Gs2Ed1KF3ulAOA9H1xG0]]></MediaId><Title><![CDATA[testCallBackReplyVideo]]></Title><Description><![CDATA[testCallBackReplyVideo]]></Description></Video></xml>";


$pc = new WXBizMsgCrypt($token, $encodingAesKey, $appId);
$encryptMsg = 'ok';
$errCode = $pc->encryptMsg($text, $timeStamp, $nonce, $encryptMsg);
if ($errCode == 0) {
    print("加密后: " . $encryptMsg . "\n");
} else {
    print($errCode . "\n");
}

$xml_tree = new DOMDocument();
$xml_tree->loadXML($encryptMsg);
$array_e = $xml_tree->getElementsByTagName('Encrypt');
$array_s = $xml_tree->getElementsByTagName('MsgSignature');
$encrypt = $array_e->item(0)->nodeValue;
$msg_sign = $array_s->item(0)->nodeValue;

$format = "<xml><ToUserName><![CDATA[toUser]]></ToUserName><Encrypt><![CDATA[%s]]></Encrypt></xml>";
$from_xml = sprintf($format, $encrypt);

// 第三方收到公众号平台发送的消息
$msg = '';
$errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
if ($errCode == 0) {
    print("解密后: " . $msg . "\n");
} else {
    print($errCode . "\n");
}




?>


