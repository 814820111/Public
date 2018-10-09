<?php

/**
 * 后台首页
 */
namespace Weixin\Controller;
use Apps\Controller\IndexController;
use Common\Controller\WeixinbaseController;
header("Content-type:text/html;charset=utf-8");
class ChengzhangController extends WeixinbaseController {
    function addDiray(){
        $jssdk = new JSSDK("wx7325155f62456567","95ad1f0bd4f4bab0ce4342d22713b3a9");
        $signPackage = $jssdk->GetSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('classid',$_SESSION['classid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
        $this->assign('studentid',$_SESSION['studentid']);
        $this->assign('userid',$_SESSION['userid']);
        $this->display();
    }
    //后台框架首页
    public function index() {
        $_SESSION['weixin']= "oImI6w9zYBcuEdmfv2dEqKpaLQ0Y";
        $weixin = $_SESSION["weixin"];
        //获取usrid
        $userid = M("wxtuser")->where("weixin = '$weixin'")->select();
        //注册变量
        $this->assign("userid",$userid);
        //吧用户id写入SESSION
        $_SESSION['userid'] = $userid;
        //获取学生的信息
        $user_info = M("wxtuser")->where("weixin = '$weixin'")->field("id")->find();
        $myname = $user_info["stu_name"];
        $this->assign("myname",$myname);
        $id = $user_info['id'];
        //查询userid
        $student_info = M("student_info")->where("userid = '$id'")->select();
        //查询学生id
        $studentid = $student_info[0]['id'];
        //学生id 写入session
        $_SESSION["studentid"] = $studentid;
        //班级id
        $classid = $student_info[0]['classid'];
        //把班级id写入session
        $_SESSION["classid"] = $classid;
        //学校id
        $schoollid = $student_info[0]['schoollid'];
        //学校id写入session
        $_SESSION["schoolid"] = $schoollid;
        $babyid = M("baby_grow")->field("babyid")->where("userid = '$userid'")->find();
        $babyid = $babyid['babyid'];
        $_SESSION[' babyid'] = $babyid;
        //获取userid 然后去获取babyid
        $userid = $user_info["id"];
        //拥有userid之后直接查询babyid和growid
        $babyid =M("baby_grow")->field('babyid')->where("userid = '$userid'")->limit(1)->select();
       $babyid = $babyid[0]['babyid'];
       //babyid 写入session
        $_SESSION["babyid"] = $babyid;
        $this->assign("babyid",$babyid);
        $studentid = $_SESSION["studentid"];
        $this->assign("studentid",$studentid);
        $this->display("index");

    }

    function GetFriendsGrow(){
       $studentid = $_SESSION["studentid"];
        $this->assign("studentid",$studentid);
            $this->display();
    }
    //执行下载的函数
    function download(){
        $jssdk = new JSSDK("wx7325155f62456567","95ad1f0bd4f4bab0ce4342d22713b3a9");
        $serverId = I("serverId");
        $access_token = $jssdk->getAccessToken();

        //根据微信JS接口上传了图片,会返回上面写的images.serverId（即media_id），填在下面即可
        $str = "https://api.weixin.qq.com/cgi-bin/media/get?access_token=".$access_token."&media_id=".$serverId."";

        //获取微信“获取临时素材”接口返回来的内容（即刚上传的图片）
        $a = file_get_contents($str);
        //定义文件所在的目录
        //文件命名
        $name = rand(1000,9999);
        //以读写方式打开一个文件，若没有，则自动创建
        $date =  date('Y-m-d H:i:s',time());
        $date = str_replace("-","",$date);
        $date = str_replace(":","",$date);
        $date = str_replace(" ","",$date);
        $array['date'] = $date;
        $array['name'] = $name;
        $jpg =  implode($array);
		//echo $load;
		$savepath = "./uploads/microbloghub/";
        $resource = fopen($savepath.$jpg.".jpg" , 'w+');
        //将图片内容写入上述新建的文件
        fwrite($resource, $a);
        //关闭资源
        fclose($resource);
        echo json_encode($jpg);

    }//download  end
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
        //时间戳为当前时间
        $timestamp = time();
        //nonceStr = 方法创建
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
