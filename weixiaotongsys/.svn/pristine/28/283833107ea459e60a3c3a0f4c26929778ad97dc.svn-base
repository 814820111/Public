<?php
/**
 * Created by PhpStorm.
 * User: 10987
 * Date: 2017/3/10
 * Time: 16:03
 */
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
header("Content-type:text/html;charset=utf-8");
class UsercenterController extends WeixinbaseController
{
    function Userinfo(){
        $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
        $signPackage = $jssdk->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $studentid = $_SESSION['studentid'];
        $this->assign("studentid",$studentid);
        $this->index();
    }
    function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
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
            $headimg = "__ROOT__/uploads/microblog/weixiaotong.png";
        }else{
            $headimg =$headimg;
        }
    //获取学生id

        $phone = $userinfo["phone"];
        $this->assign("name",$name);
        $this->assign("sex",$sex);
        $this->assign("phone",$phone);
        $this->assign("headimg",$headimg);
        $this->display();
    }
    function Invitefamily(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
        $signPackage = $jssdk->GetSignPackage();
        //预先定义一个session
        $userid = $_SESSION["studentid"];
        $student = M("wxtuser")->where(array('id'=>$userid))->select();
//        var_dump($student);die();
        $studentid = $student[0]["id"];
        $stu_name = $student[0]["name"];
        //查询学生的关系表
        $result = M("relation_stu_user as relation")
            ->join("wxt_wxtuser as user on relation.userid = user.id")
            ->where(array("studentid"=>$userid))
            ->select();
        $this->assign("result",$result);
        $this->assign("signPackage",$signPackage);
        $this->assign("stu_name",$stu_name);
        //输出到页面
        $this->display();
    }
    function yaoqing(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->display();
    }
    function ChangeBaby(){
        $userid = $_SESSION["userid"];
        $stu_real_res = M("relation_stu_user as relation")
            ->join("wxt_wxtuser as user on relation.studentid = user.id")
            ->join("wxt_class_relationship as class on relation.studentid = class.userid")
            ->join("wxt_school_class as sclass on sclass.id = class.classid")
            ->join("wxt_school as school on school.schoolid = sclass.schoolid")
            ->field("studentid,appellation,school_name,classname,user.name,user.photo")
            ->where("relation.userid = '$userid'")
            ->select();
        $this->assign("userid",$_SESSION["userid"]);
        $this->assign("stus",$stu_real_res);
        $this->display();
    }
    function Board(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $Board = M("guestbook")->select();

        echo json_encode($Board);
    }
    function MessageBoard(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
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
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION["userid"];
        $this->assign("userid",$userid);
        $this->display();
    }
    function SystermMessage(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->display();
    }
    function resetPwd(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION["userid"];
        $this->assign("userid",$userid);
        $this->display();
    }
    //修改用户信息
    public function upload(){
        if ($_FILES){
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './uploads/'; // 设置附件上传根目录
            $upload->savePath  =     '/microblog/'; // 设置附件上传（子）目录
            $upload->autoSub = false;
            //定义一个命名规则
            $name = md5(mktime()+rand(1,10000));
            // 上传文件
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
                foreach($info as $file){
                    $data["photo"] = $file['savename'];
                }
            }
            $data["name"] = $_POST["name"];
            $data["sex"] = $_POST["sex"];
            $data["phone"] = $_POST["phone"];
            //入库更新
            array_filter($data);
            $res = M("wxtuser")->where(array("id"=>$_SESSION["userid"]))->save($data);
        }else{
            $data["name"] = $_POST["name"];
            $data["sex"] = $_POST["sex"];
            $data["phone"] = $_POST["phone"];
            //入库更新
            array_filter($data);
            $res = M("wxtuser")->where(array("id"=>$_SESSION["userid"]))->save($data);
        }
        if ($res){
            $this->success("上传成功");
        }else{
            $this->error($upload->getError());
        }

    }
}
class JSSDK {
    private $appId;
    private $appSecret;

    public function __construct($appId, $appSecret) {
        $this->appId = $appId;
        $this->appSecret = $appSecret;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]";

        $timestamp = time();
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
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }

    private function getJsApiTicket() {
        // jsapi_ticket 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("jsapi_ticket.php"));
        if ($data->expire_time < time()) {
            $accessToken = $this->getAccessToken();
            // 如果是企业号用以下 URL 获取 ticket
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket?access_token=$accessToken";
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode($this->httpGet($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $data->expire_time = time() + 7000;
                $data->jsapi_ticket = $ticket;
                $this->set_php_file("jsapi_ticket.php", json_encode($data));
            }
        } else {
            $ticket = $data->jsapi_ticket;
        }

        return $ticket;
    }

    function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("access_token.php"));
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $this->set_php_file("access_token.php", json_encode($data));
            }
        } else {
            $access_token = $data->access_token;
        }
        return $access_token;
    }

    private function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        // 为保证第三方服务器与微信服务器之间数据传输的安全性，所有微信接口采用https方式调用，必须使用下面2行代码打开ssl安全校验。
        // 如果在部署过程中代码在此处验证失败，请到 http://curl.haxx.se/ca/cacert.pem 下载新的证书判别文件。
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);

        $res = curl_exec($curl);
        curl_close($curl);

        return $res;
    }

    private function get_php_file($filename) {
        return trim(substr(file_get_contents($filename), 15));
    }
    private function set_php_file($filename, $content) {
        $fp = fopen($filename, "w");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}

