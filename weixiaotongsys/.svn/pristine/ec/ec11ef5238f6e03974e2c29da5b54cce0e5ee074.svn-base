<?php
namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
define("TOKEN", "xiaochen");
define("APPID", "wx7325155f62456567");
define("APPSECRET", "02e05630f28c9a54f11f17c788995ac5");
class WeChatController extends AppBaseController
{
    //判断是介入还是用户  只有第一次介入的时候才会返回echostr
    function index()
    {
        $echoStr = $_GET["echostr"];
        if ($this->checkSignature()) {
            echo $echoStr;
            exit;
        }
    }

    //验证微信开发者模式接入是否成功
    private function checkSignature()
    {
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce     = $_GET["nonce"];

        $token  = "xiaochen";
        $tmpArr = array(
            $token,
            $timestamp,
            $nonce
        );
        // use SORT_STRING rule
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);

        if ($tmpStr == $signature) {
            echo "1111";
        } else {
            echo "2222";
        }
    }
    //获取 access_token
    function getAccess_token()
    {
        $time = M("weixin")->where("APPID = appid")->find("getAccse_toeknTime");
		//第一次是access_token不存在 就重新获取一个
        if (mktime() - $time > 7200  || empty($time)) {
            //获取token
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
            //获取token
            $ch  = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
            $jsoninfo                   = json_decode($output, true);
            $access_token               = $jsoninfo["access_token"];
            //重新写进 数据库
            $data["getAccse_toeknTime"] = mktime();
            $data["access_token"]       = $access_token;
            $res                        = M("weixin")->where("APPID = appid")->seve($data);
        } else {
            $access_token = M("weixin")->find("access_token");

        }
    }
    //获取自定义菜单
    private function getMenu()
    {
        $appid        = APPID;
        $appsecret    = APPSECRET;
        $access_token = $this->getAccess_token();
        $getMenuurl   = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token=" . $access_token;
        $ch           = curl_init();
        curl_setopt($ch, CURLOPT_URL, $getMenuurl);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $res = json_decode($output, true);
        print_r($res);
    }


    //构建一个发送请求的curl方法  微信的东西都是用这个 直接百度
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
    //设置自定义菜单 前台传值过来 ajax 菜单创建的数据
    function createMenu()
    {
        $access_token = $this->getAccess_token();
        $url          = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=" . $access_token;
        $content      = "";
        $res          = $this->http_request($url, $content);
    }
    //构建模板信息发送方法
    function sendTemplate($tpl)
    {
        $json_template = json_encode($tpl);
        $access_token  = $this->getAccess_token();
        $url           = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token==" . $access_token;
        $tmpArr        = json_decode($json_template, true);
    }
    //这是到学校的通知
    //定义一个方法 直接获取学生的各种信息
    function getInfo($resJson)
    {
        //把接收过来的json转化为数组
        $receive  = json_decode($resJson, true);
        $stu_id   = $receive["id"];
        //通过学生表找到家长的openid
        //获取学生姓名
        $stu_name = M("student_info")->where("$stu_id = id")->find("name");
        //获取学生表的userid
        $userid   = M("student_info")->where("$stu_id = id")->find("userid");
        //通过学生表的userid获取家长的微信openid
        $openid   = M("wxtusers")->where("$userid = id")->find("weixin");
        //获取刷卡地点怎么获取还没搞清楚 暂时定义为$place
        $place    = $receive["place"];
        $info     = array(
            $receive,
            $stu_id,
            $stu_name,
            $userid,
            $openid,
            $place
        );
        return $info;
    }
    function sendReach_school($resJson)
    {
        $tpl = array(
            //接收者
            "touser" => $res[$openid],
            //模板id
            "template_id" => "1d555qPObIhA8tpj6YZzYNA-TEEWvWjR7sEJSvog3aQ",
            //点击跳转的url
            "url" => "http://xct.zjxxt.net.cn/wxt/kaoqin.html",
            //标题颜色
            "topcolor" => "#436EEE",
            //模板的数据了  里面的东西都要和微信的模板一一对应
            "data" => array(
                "first" => array(
                    "value" => "尊敬的" . $res[$stu_name] . "家长，" . $res[$stu_name] . "同学有一条考勤消息：：",
                    "color" => "#436EEE"
                ),
                "keyword1" => array(
                    "value" => $res[$stu_name],
                    "color" => "#436EEE"
                ),
                //                "keyword2" => array("value" => "小一班","color" => "#436EEE"),
                "keyword2" => array(
                    "value" => date('Y-m-d H:i:s', "1487894880"),
                    "color" => "#436EEE"
                ),
                "keyword3" => array(
                    "value" => $res[$place],
                    "color" => "#436EEE"
                ),
                "remark" => array(
                    "value" => $res[$stu_name] . "已平安到校，请您放心",
                    "color" => "#436EEE"
                )
            )
        );
        $res = $this->sendTemplate($tpl);
        if ($res["errcode"] == 0) {
            echo "发送成功";
        } else {
            echo json_encode($res);
        }
    }
    //离校通知
    function Leaveschool()
    {
        $res = $this->getInfo();
        $tpl = array(
            //接收者
            "touser" => "oImI6wwYnHtsz5V4yMkkYuPwIwJw",
            "template_id" => "xpkhD2C-tSMGvdndrc7EWJnbNI8s548QzH87sDgNo5g",
            "url" => "http://xct.zjxxt.net.cn/wxt/kaoqin.html",
            "topcolor" => "#436EEE",
            "data" => array(
                "first" => array(
                    "value" => "尊敬的家长：下面是您的小孩打卡离校的情况：",
                    "color" => "#436EEE"
                ),
                "keyword1" => array(
                    "value" => $res[$stu_name],
                    "color" => "#436EEE"
                ),
                "keyword2" => array(
                    "value" => "小一班",
                    "color" => "#436EEE"
                ),
                "keyword3" => array(
                    "value" => $res[$place],
                    "color" => "#436EEE"
                ),
                "keyword4" => array(
                    "value" => date('Y-m-d H:i:s'),
                    "color" => "#436EEE"
                ),
                "remark" => array(
                    "value" => "请注意小孩的回家时间，谢谢您的查收！",
                    "color" => "#436EEE"
                )
            )
        );
    $this->sendTemplate($tpl);
    }//模板发送结束
    //获取用户列表 全部用户的列表
    function getUserlist(){
        $access_token = $this->getAccess_token();
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$access_token."&next_openid=500";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }


} //classend