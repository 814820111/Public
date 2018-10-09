<?php
namespace Apps\Controller;
use Common\Controller\AppBaseController;

class getUseinfoController extends AppBaseController{
    function check(){
        //先判断是否绑定过
        $openid = $this->getOpenid();
        $result = M("wxtusers")->where("$openid = weixin")->find();
        if ($result){
            $this->readinfo();
        }else{
            $this->building();
        }
    }
    function auto(){
        //静默授权 获取code
        $REDIRECT_URI = "";
        $scope = "scopr_base";
        $state = md5(mktime());
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        $HTTP = new WeChatController();
        $res= $HTTP->https_request($url);
    }
    function getOpenid(){
        //获取用户openid
        $tmpArr = $this->getCode();
        $openid = $tmpArr["openid"];
        return $openid;
    }
    function getAccess_token(){
        //获取access_token
        $tmpArr = $this->getCode();
        $access_token = $tmpArr["access_token"];
        return $access_token;
    }
    function getCode(){
        //获取code 来交换access_token
        $code = $_GET["code"];
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".APPID."&secret=".APPSECRET."&code=".$code."&grant_type=authorization_code";
        $HTTP = new WeChatController();
        $res= $HTTP->https_request($url);
        $res= json_decode($res,true);
        return $res;
    }
    function getUser_info(){
        //获取用户详细信息
        $access_token = $this->getAccess_token();
        $openid = $this->getOpenid();
        $url = "https://api.weixin.qq.com/cgi-bin/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
        $HTTP = new WeChatController();
        $res= $HTTP->https_request($url);
        return $res;
    }
    //读取用户信息
    function readinfo(){
        $res = $this->getUser_info();
        //头像
        $headimgurl = $res["headimgurl"];
        $weixin = $res["openid"];
        //获取id 跟学生关联
        $userid = M("wxtusers")
            ->where("$weixin = wexin")
            ->find("id");
        //学生姓名
        $stu_name = M("student_info")
            ->where("$userid = userid")
            ->find("stu_name");
        //学校id
        $schoollid = M("student_info")
            ->where("$userid = userid")
            ->find("schoollid");
        //学校 名字
        $choolname = M("school as c")
            ->join("tudent_info as s on c.schoolid = s.schoollid")
            ->where("$schoollid = schoollid")
            ->find("school_name");
        //班级名字
        $classid =  M("student_info")
            ->where("$userid = userid")
            ->find("classid");
        //获取班级id
        $classid = M("school_class as c")
            ->join("student_info as s on c.id = s.classid")
            ->where("s.classid = $classid")
            ->find("classname");
    }
    //用户绑定
    function building($result){
        $res = $this->getUser_info();
        $headimgurl = $res["headimgurl"];
        //触发短信发送机制
        $result = json_decode($result,true);
        $phone = $result["phone"];
        $term = M("wxtusers")->where("$phone = phone")->find();
        if($term){
            return true;
        }else{
            return
                "<script> alert('手机号码不存在');</script>";
            die();
        }
        $data["weixin"] = $res["openid"];
        $tmpRes = M("wxtusers")->where("$phone = phone")->sava($data);
    }
}