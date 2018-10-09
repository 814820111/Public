<?php
/**
 * Created by PhpStorm.
 * User: 10987
 * Date: 2017/3/10
 * Time: 16:03
 */
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class UsercenterController extends WeixinbaseController
{
    function Userinfo(){
        $studentid = $_SESSION['studentid'];
        $this->assign("studentid",$studentid);
        $this->index();
    }
    function index(){
        $_SESSION['userid'] = 793;
        $userid = $_SESSION['userid'];
        $userinfo = M("wxtuser")->where("id = '$userid'")->find();
        $headimg = $userinfo["photo"];
        $name = $userinfo["name"];
        $_SESSION["name"] = $name;
        $sex = $userinfo["sex"];
        if ($sex == 1){
            $sex = "男";
        }else{
            $sex = "女";
        }
        if ($headimg ==null){
            $headimg = "/wxt_webhome/uploads/microbloghub/1475.png";
        }else{
            $headimg = "__ROOT__/uploads/microbloghub".$headimg;
        }

        $phone = $userinfo["phone"];
        $this->assign("name",$name);
        $this->assign("sex",$sex);
        $this->assign("phone",$phone);
        $this->assign("headimg",$headimg);
        $this->display();
    }
    function Invitefamily(){
        //预先定义一个session
        $userid = $_SESSION["userid"];
        //查到学生的信息
        $stu_name = M("student_info")->where("userid = '$userid'")->find();
        //查到学生的名字
        $stu_name = $stu_name["stu_name"];
        //查询学生的关系表
        $result = M("relation_stu_user as s")->join("wxt_student_info as w on w.userid = s.userid")->where("w.userid = '$userid'")->select();
        //获取学生跟用户的关系
        $relation = $result["appellation"];
        //注册变量
        $this->assign("relation",$relation);
        //查询用户的信息(这里的用户是与学生有关系的用户)
        $user_info = M("wxtuser")->where("id = '$userid'")->find();
        //用户的手机号码
        $phone = $user_info["phone"];
        //头像
        $photo = $phone["photo"];
        //注册变量到smarty模板
        //名字
        $this->assign("name",$relation);
        //手机号码
        $this->assign("phone",$phone);
        //头像
        $this->assign("photo",$photo);
        //学生姓名
        $this->assign("stu_name",$stu_name);
        //输出到页面
        $this->display();
    }
    function yaoqing(){
        $this->display();
    }
    function ChangeBaby(){
//        $userid = $_GET["userid"];
        $userid = 793;
        $Babys = M("student_info")->where("userid = '$userid'")->select();
        $Babys = $Babys;
        echo "<pre>";
        var_dump($Babys);die();
        $this->assign("baby_info",$Babys);
        $this->display();
    }
    function Board(){

        $Board = M("guestbook")->select();

        echo json_encode($Board);
    }
    function MessageBoard(){
        $jssdk = new JSSDK("wx7325155f62456567","02e05630f28c9a54f11f17c788995ac5");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('classid',$_SESSION['classid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
        $this->assign('studentid',$_SESSION['studentid']);
        $this->assign('userid',$_SESSION['userid']);
        $this->display();
    }
    function getSelfMessage()
    {
        $userid = $_SESSION["userid"];
        $this->assign("userid",$userid);
        $this->display();
    }
    function SystermMessage(){
        $this->display();
    }
    function resetPwd(){
        $userid = $_SESSION["userid"];
        $this->assign("userid",$userid);
        $this->display();
    }
}
class JSSDK {
    private $appId;
    private $appSecret;
    //自动运行的函数
    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }
    //获取签名的组
    public function getSignPackage() {
        //获取jsapiticket
        $jsapiTicket = $this->getJsApiTicket();
        $url = "http://$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";
        //戳为当前时间
        $timestamp = time();
        //nceStr = 方法创建
        $nonceStr = $this->createNonceStr();
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);
        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
    //创建noncestr
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
    //获取jsapiticket
    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("jsapi_ticket.json"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $fp = fopen("jsapi_ticket.json", "w+");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }
        return $ticket;
    }
    //获取access_token
    function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode(file_get_contents("access_token.json"));
        if ($data->expire_time < time()) {
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $fp = fopen("access_token.json", "w+");
                fwrite($fp, json_encode($data));
                fclose($fp);
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }
    //定义一个https发送方法
    function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }
}
