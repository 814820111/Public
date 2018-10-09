<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
define("APPID", "wx7325155f62456567");
define("APPSECRET","c379e9768f9faa8865a1db767fc81155");
session_start();
class SchoolwebController extends WeixinbaseController {

    function accept(){
        if(I("appid")){
            $id = I("appid");//公众号ID
            $result = M("wxmanage")->where("id = $id")->find();
            $appid = $result["wx_appid"];
            $appsecret = $result["wx_appsecret"];
            $_SESSION["APPID"] = $appid;
            $_SESSION["APPSECRET"] = $appsecret;
        }
        //dump($_SESSION);
        //die();
        //这个链接是获取code的链接 链接会带上code参数
        $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
        $REDIRECT_URI = "$http/index.php/weixin/Schoolweb/getCode";
        $REDIRECT_URI = urlencode($REDIRECT_URI);
        $scope = "snsapi_base";
        $state = md5(mktime());
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$_SESSION["APPID"]."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        header("location:$url");
    }
//用户同意之后就获取code  通过获取code可以获取一切东西了  机智如我
    function getCode(){
        //获取code
        $code = $_GET["code"];
        //用code获取access_yoken
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$_SESSION["APPID"]."&secret=".$_SESSION["APPSECRET"]."&code=".$code."&grant_type=authorization_code";
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

        if($weixin){
            $appid = $_SESSION['APPID'];
            //查找这个微信之前是否扫过特定二维码
            //如果是的话 跳到那个二维码的学校 不是 现在默认的学校

            $query = M("wechat_school_openid")->where(array("openid"=>$weixin,"appid"=>$appid))->find();
            //dump($query);
            if($query["schoolid"]){
                $schoolid = $query["schoolid"];
                $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                header("location:".$http."/index.php/weixin/Schoolweb/index?schoolid=".$schoolid);
            }else{
                $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                header("location:".$http."/index.php/weixin/Schoolweb/index");
            }
        }

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
        if(I("schoolid")){
            $schoolid = I("schoolid");
            $_SESSION['schoolid'] = $schoolid;
            $school = M("school")->where("schoolid = $schoolid")->find();
            $stu_sch_name = $school["school_name"];
            $_SESSION["school_name"] = $stu_sch_name;
            $this->assign("schoolid",$schoolid);
            $this->assign("school_name",$stu_sch_name);
        }else{
            $schoolid = 7;
            $_SESSION['schoolid']=$schoolid;
            $school = M("school")->where("schoolid = $schoolid")->find();
            $stu_sch_name = $school["school_name"];
            $_SESSION["school_name"] = $stu_sch_name;
            $this->assign("schoolid",$schoolid);
            $this->assign("school_name",$stu_sch_name);
        }

        $this->display();


	}
	//园所介绍
	public function Park(){
	    if($_SESSION['schoolid']){
	        $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//教师风采
	public function teachers(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//通知公告
	public function Notice(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//宝秀场
	public function Babyshow(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//校园应聘
	public function Recruitment(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//兴趣班
	public function Interest(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//新闻动态
	public function Journalism(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	//育儿知识
	public function Parenting(){
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign("schoolid",$schoolid);
        }else{
            $schoolid = 7;
            $this->assign("schoolid",$schoolid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
}
?>