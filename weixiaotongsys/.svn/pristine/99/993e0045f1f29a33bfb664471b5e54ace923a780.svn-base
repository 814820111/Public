<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
define("APPID", "wx7325155f62456567");
define("APPSECRET","c379e9768f9faa8865a1db767fc81155");
session_start();
class SchoolwebController extends WeixinbaseController {
    function accept(){
        //这个链接是获取code的链接 链接会带上code参数
        //$_SESSION['visitor'] = I("schoolid");
        $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
        $REDIRECT_URI = urldecode("$http/index.php/weixin/Schoolweb/getCode");
        $REDIRECT_URI = urlencode($REDIRECT_URI);
        $scope = "snsapi_base";
        $state = md5(mktime());
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        header("location:$url");
    }
//用户同意之后就获取code  通过获取code可以获取一切东西了  机智如我
    function getCode(){
        //获取code
        //$qycode = $_SESSION['visitor'];
        $code = $_GET["code"];
        //用code获取access_yoken
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$code."&grant_type=authorization_code";
        //这里可以获取全部的东西  access_token openid scope
        $res = $this->https_request($url);
        $res  = json_decode($res,true);
        $openid = $res["openid"];
        $access_token = $res["access_token"];
        //这里是获取用户信息
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $res = $this->https_request($url);
        $res = json_decode($res,true);
        //把用户的信息写入session 以备查用
        //openid
        $weixin = $res["openid"];
        //sex
        $sex = $res["sex"];
        //头像
        $headimg = $res["headimgurl"];
        //昵称
        $nickname = $res["nickname"];
        $_SESSION["user"]['weixin'] = $weixin;
        $_SESSION["user"]['sex'] = $sex;
        $_SESSION["user"]['headimg'] = $headimg;
        $_SESSION["user"]['nickname'] = $nickname;
        $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
        header("location:".$http."/index.php/weixin/Schoolweb/");
    }
    function https_request($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
	//校网首页
	public function index(){
        $weixin = $_SESSION['user']['weixin'];
		$userinfo = M("wxtuser")->where("weixin = '$weixin'")->find();
        $schoolid = $userinfo['schoolid'];
		$_SESSION['schoolid'] = $schoolid;
            $this->display();


	}
	//园所介绍
	public function Park(){
		$this->display();
	}
	//教师风采
	public function teachers(){
		$this->display();
	}
	//通知公告
	public function Notice(){
		$this->display();
	}
	//宝秀场
	public function Babyshow(){
		$this->display();
	}
	//校园应聘
	public function Recruitment(){
		$this->display();
	}
	//兴趣班
	public function Interest(){
		$this->display();
	}
	//新闻动态
	public function Journalism(){
		$this->display();
	}
	//育儿知识
	public function Parenting(){
		$this->display();
	}
}
?>