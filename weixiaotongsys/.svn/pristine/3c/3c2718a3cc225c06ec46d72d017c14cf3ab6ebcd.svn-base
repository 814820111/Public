<?php

/**
 * 后台首页
 */
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
//define("APPID", "wx7325155f62456567");
//define("APPSECRET","c379e9768f9faa8865a1db767fc81155");
header("Content-type:text/html;charset=utf-8");
session_start();
class IndexController extends WeixinbaseController
{

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
    //后台框架首页
    public function index()
    {
       if(I("schoolid")){
           $weixin = $_SESSION["user"]["weixin"];//微信ID
           $appid = $_SESSION["APPID"];
           $schoolid = I("schoolid");
           M("wechat_school_openid")->where(array("openid"=>$weixin,"appid"=>$appid))->save(array("schoolid"=>$schoolid));
        }
       if(I('stu_id')){
           $_SESSION['studentid'] = intval(I('stu_id'));
           $studentid = $_SESSION["studentid"]; //学生ID
       }else{
           $studentid = $_SESSION["studentid"];
       }
       if(I('id')){
           $_SESSION['userid'] = intval(I('id'));
           $userid = $_SESSION['userid']; //家长ID
       }else{
           $userid = $_SESSION['userid'];
       }

       //查询学生所在的班级和学校
        $user_info = M("class_relationship")->where(array('userid'=>$studentid))->find();
        //学生学校
        $stu_school = $user_info["schoolid"];
        $_SESSION['schoolid'] =  $user_info["schoolid"];

        //班级id
        $stu_class = $user_info["classid"];
        $_SESSION['classid'] = $stu_class;
        $stu_school_name = M("school")->where("schoolid = '$stu_school'")->find();
        //学校名字
        //获取学校名字
        //todo 不一定什么时候又要改 这里是存入session的地方
        $stu_sch_name = $stu_school_name["school_name"]; //学校名字
        $_SESSION["school_name"] = $stu_sch_name;
        $this->assign("schoolname",$stu_sch_name);


        //获取学生头像
        $stu_info = M("wxtuser")->where(array('id'=>$studentid))->find();
        //$stu_name = $stu_info['name'];
        $stu_photo = $stu_info['photo'];
        $this->assign("stu_photo",$stu_photo);
        //获取学生名字
        $student = M("student_info")->where(array('userid'=>$studentid))->field("stu_name")->find();
        $stu_name = $student['stu_name'];
        //班级名字
        $stu_cla_name = M("school_class")->where("schoolid = '$stu_school' AND id = '$stu_class'")->select();
        $class_name = $stu_cla_name[0]["classname"];
		
//		 $middle_menu = R('Apps/Role/weixin_role',array(1,1,2));
//
//        foreach ($middle_menu as $key => &$value){
//            $img=explode("|", $value['icon']);
//
//            $value['icon'] = $img[0];
//            $value['icon2'] =  $img[1];
//          }
//
//
//        $this->assign("top_menu",array_chunk(R('Apps/Role/weixin_role',array(1,1,1)),10));
//        $this->assign("middle_menu",$middle_menu);
//        $this->assign("bottom_menu",R('Apps/Role/weixin_role',array(1,1,3)));
		
        $this->assign("stu_name",$stu_name);
        $this->assign("school_name",$stu_sch_name);
        $this->assign("class_name",$class_name);
        $this->assign("studentid",$_SESSION["studentid"]);
        $this->assign("classid",$_SESSION["classid"]);
        $this->assign("schoolid",$_SESSION["schoolid"]);
        $this->display();
    }



    function format_ret($status, $data = '')
    {
        if ($status) {
            //成功
            return array('status' => 'success', 'data' => $data);
        } else {
            //验证失败
            return array('status' => 'error', 'data' => $data);
        }
    }

    //根据地址将图片下载到本地
    function test($url) {
        //$url = 'http://wx.qlogo.cn/mmopen/PiajxSqBRaEKUmIia2JJ9rtp4BMPvbKD8wgmqeEQ5j6m2eoeu5GNaMDbGGWLib8dFdxJaUibSGZ2Vh9Q6mYnpCHpVA/0';
        $header = array("Connection: Keep-Alive", "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8", "Pragma: no-cache", "Accept-Language: zh-Hans-CN,zh-Hans;q=0.8,en-US;q=0.5,en;q=0.3", "User-Agent: Mozilla/5.0 (Windows NT 5.1; rv:29.0) Gecko/20100101 Firefox/29.0");
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, $v);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip,deflate');

        $content = curl_exec($ch);
        $curlinfo = curl_getinfo($ch);
        //echo "string";
        //print_r($curlinfo);
//关闭连接
        curl_close($ch);

        if ($curlinfo['http_code'] == 200) {
            if ($curlinfo['content_type'] == 'image/jpeg') {
                $exf = '.jpg';
            } else if ($curlinfo['content_type'] == 'image/png') {
                $exf = '.png';
            } else if ($curlinfo['content_type'] == 'image/gif') {
                $exf = '.gif';
            }
//存放图片的路径及图片名称  *****这里注意 你的文件夹是否有创建文件的权限 chomd -R 777 mywenjian
            $filename = date("YmdHis") . uniqid() . $exf;//这里默认是当前文件夹，可以加路径的 可以改为$filepath = '../'.$filename

           // $filepath = './uploads/microblog/'.$filename;
            $filepath = "/alidata/www/weixiaotong2016/uploads/microblog/".$filename;

            //$res = file_put_contents($filename, $content);//同样这里就可以改为$res = file_put_contents($filepath, $content);
            $res = file_put_contents($filepath, $content);
            return $filename;
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
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

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
        $data = json_decode($this->get_php_file("./jsapi_ticket.php"));
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
                $this->set_php_file("./jsapi_ticket.php", json_encode($data));
            }
        } else {
            $ticket = $data->jsapi_ticket;
    }

        return $ticket;
    }

    function getAccessToken() {
        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
        $data = json_decode($this->get_php_file("./access_token.php"));
        if ($data->expire_time < time()) {
            // 如果是企业号用以下URL获取access_token
            // $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$this->appId&corpsecret=$this->appSecret";
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
            $res = json_decode($this->httpGet($url));
            $access_token = $res->access_token;
            if ($access_token) {
                $data->expire_time = time() + 7000;
                $data->access_token = $access_token;
                $this->set_php_file("./access_token.php", json_encode($data));
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
        $fp = fopen($filename, "wb");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}