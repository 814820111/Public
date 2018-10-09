<?php

/**
 * 后台首页
 */
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
define("APPID", "wx7325155f62456567");
define("APPSECRET","c379e9768f9faa8865a1db767fc81155");
header("Content-type:text/html;charset=utf-8");
session_start();
class IndexController extends WeixinbaseController
{
	function accept(){
        //如果$_SESSION["user"]['weixin']存在,说明之前已经授权登录过 直接跳到选择页
        $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
        if($_SESSION["user"]['weixin']){
            header("location:".$http."/index.php/weixin/index/build");
            die();
        }
        //这个链接是获取code的链接 链接会带上code参数
        $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
        $REDIRECT_URI = urldecode("$http/index.php/weixin/Index/getCode");
        $REDIRECT_URI = urlencode($REDIRECT_URI);
        $scope = "snsapi_userinfo";
        $state = md5(mktime());
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".APPID."&redirect_uri=".$REDIRECT_URI."&response_type=code&scope=".$scope."&state=".$state."#wechat_redirect";
        header("location:$url");
    }
		//用户同意之后就获取code  通过获取code可以获取一切东西了  机智如我
    function getCode(){
        //获取code
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
        header("location:".$http."/index.php/weixin/index/build");
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
    //后台框架首页
    public function index()
    {

//       if (I()){
//           $_SESSION['studentid'] = intval(I('stu_id'));
//           $studentid = $_SESSION["studentid"];
//       }else{
//           $studentid = $_SESSION["studentid"];
//       }
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

        //获取学生名字
        $stu_info = M("wxtuser")->where(array('id'=>$studentid))->find();
        $stu_name = $stu_info['name'];
        $stu_photo = $stu_info['photo'];//获取学生头像
        $this->assign("stu_photo",$stu_photo);
        //班级名字
        $stu_cla_name = M("school_class")->where("schoolid = '$stu_school' AND id = '$stu_class'")->select();
        $class_name = $stu_cla_name[0]["classname"];
        $this->assign("stu_name",$stu_name);
        $this->assign("school_name",$stu_sch_name);
        $this->assign("class_name",$class_name);
//        echo HAH;
        //print_r($_SESSION);
        $this->display();
    }
    function GetMicroblogById()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $beginid = I('beginid');
        $schoolid = I('schoolid');
        //学校的ID
        $classid = I('classid');
        //班级的ID
        $type = I('type');
        //空间动态
        $uisd = I("userid");
        //用户的ID
        $mids = I("mids");
        //该信息的ID
        $microblig = M('microblog_main');   //博客主表
        $microblig_pic = M('microblog_picture_url');//博客图片表
        $microblig_like = M('likes');//博客点赞表
        $microblig_comment = M('comments');//博客评论表
        if ($school != "" || $classid != "" || $uisd != "" || $mids != "") {
            $where["wxt_microblog_main.schoolid"] = $schoolid;
            $where["wxt_microblog_main.userid "] = $uisd;
            $where["wxt_microblog_main.classid"] = $classid;
            $where["wxt_microblog_main.mid"] = $mids;
            $where["wxt_microblog_main.status"] = 1;
            if ($type != 1) {
                $where["wxt_microblog_main.type"] = $type;
            }
            $user_return = $microblig->join("wxt_wxtuser ON wxt_microblog_main.userid = wxt_wxtuser.id")
                ->where($where)
                ->field('mid,type,wxt_microblog_main.schoolid,wxt_microblog_main.classid,userid,name,content,write_time,photo')
                ->select();
            //为该条微博匹配存入的图片++++++++匹配点赞情况
            for ($i = 0; $i < count($user_return); $i++) {
                //1.获取该微博对应图片数量，名称等信息      2.对应的点赞人id，点赞时间等信息    3.对应评论人，评论内容，评论时间等信息
                $microblogid = $user_return[$i]['mid'];//主表对应的附表中的microblogid

                $pic_return = $microblig_pic->where("microblogid = $microblogid")
                    ->order('id ASC')
                    ->field('pictureurl')
                    ->select();
                //将图片地址信息附给该条微博
                $user_return[$i]['pic'] = $pic_return;

                $where_like["wxt_likes.refid"] = $microblogid;
                //$where_like["wxt_likes.type"]=$type;
                $like_return = $microblig_like->join("wxt_wxtuser ON wxt_likes.userid = wxt_wxtuser.id")
                    ->where($where_like)
                    ->order('likeid ASC')
                    ->field('userid,name')
                    ->select();
                //将点赞人信息附给该条微博
                $user_return[$i]['like'] = $like_return;

                $where_comment["wxt_comments.refid"] = $microblogid;
                //$where_comment["wxt_comments.type"]=$type;
                $comment_return = $microblig_comment
                    ->join("wxt_wxtuser ON wxt_comments.userid = wxt_wxtuser.id")
                    ->where($where_comment)
                    ->order('wxt_comments.add_time DESC')
                    ->field('userid,name,content,wxt_wxtuser.photo as avatar,add_time as comment_time')
                    ->select();
                //将评论人信息及内容附给该条微博
                $user_return[$i]['comment'] = $comment_return;
            }
            $ret = $this->format_ret(1, $user_return);
        } else {
            $ret = $this->format_ret(0, "系统错误请稍后再试！");
        }
        echo json_encode($ret);
        die;

    }
    function builds(){
      $this->accept();

    }
    //跳转家长绑定页面
    function build(){
        $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
        $access_token = $jssdk->getAccessToken();
        $openid =  $_SESSION["user"]['weixin'];
        $headimg = $_SESSION["user"]['headimg'];//微信头像
        $nickname = $_SESSION["user"]['nickname'];//微信昵称
        $this->assign("headimg",$headimg);
        $this->assign("nickname",$nickname);
        $this->display();


    }
    //家长绑定处理
    function buildings()
    {
        //如果没有这个关系 就看user表中是否纯在这个userid
        $stu_name = I("stu_name");
        $name = I("name");
        $phone = I("phone");
        $relation = I("relation");
        $build_number = I("number");
        //判断接受过来的值
        //先查学生表里面有没有这个学生  如果有就继续如果没有就pass
        $stu_res = M("student_info")->where("stu_name = '$stu_name' AND bindingkey = $build_number")->find();
        //判断学生信息是否正确
        if (!$stu_res) {
            $ret = format_ret(0, "学生信息核实失败,请您核实学生姓名/绑定码");
            echo json_encode($ret);
            die();
        }
        $stu_id = $stu_res['userid'];

        //判断学生的这个关系是否被绑定
        $where['studentid'] = $stu_id;
        $where['appellation'] = trim($relation);
        $rel_res = M("relation_stu_user")->where($where)->select();
        if ($rel_res) {
            $ret = format_ret(0, "该关系已经被绑定");
            echo json_encode($ret);
            die();
        }
        $ret = M("relation_stu_user")->where(array("studentid"=>$stu_id))->select();
        $rets = count($ret);
        if ($rets>4){
            $ret = format_ret(0, "绑定名额已经用完");
            echo json_encode($ret);
            die();
        }
        //写一个查询语句  查一下用户是否在用户表中
        $weixin = $_SESSION['user']['weixin'];
        //查询用户是否在用户表中
        $use_res = M("wxtuser")->where(array("weixin"=>$weixin))->select();
        if ($use_res) {
            //如果存在就拿用户的userid
            //用户id
            $userid = $use_res[0]['id'];
            //查找用户是否已经绑定这个关系
            $sereach = M("relation_stu_user")->where("studentid = '$stu_id' AND userid = '$userid' and wechatbuid = 0")->select();
            if ($sereach) {
                //如果有就返回说只能绑定一个
                $ret = format_ret(0, "一个孩子您只能绑定一个关系");
                echo json_encode($ret);
                die();
            }else if(count($sereach)>=5){
                $ret = format_ret(0, "您已经绑定五个孩子了");
                echo json_encode($ret);
            }else{

                $relation_data["userid"] = $userid;
                $relation_data["studentid"] = $stu_id;
                $relation_data['appellation'] = $relation;
                $relation_data["time"] = mktime();
                $rela_add_res = M("relation_stu_user")->add($relation_data);
                //判断是否插入成功如果成功就返回成功 如果失败就返回失败了 请重试
                if ($rela_add_res) {
                    $ret = format_ret(1,"绑定成功");
                    echo json_encode($ret);
                    die();
                } else {
                    $ret = format_ret(0,"请重试");
                    echo json_encode($ret);
                    die();
                }
            }
        }
        $user_data['phone'] = $phone;
        $user_data['name'] = $name;
        $photo = $this->test($_SESSION["user"]['headimg']);
       // $user_data["photo"] = $_SESSION["user"]['headimg'];
        $user_data["photo"] = $photo;
        $user_data["create_time"] = mktime();
        $user_data["weixin"] = $_SESSION["user"]['weixin'];
        $user_data["sex"] = 1;
        $user_data["schoolid"] = $stu_res["schoollid"];
        //user表插入 然后再relation表创建东西
        $user_add_res = M("wxtuser")->add($user_data);
        if ($user_add_res) {
            $_SESSION['userid'] = $user_add_res;
            $relation_data["studentid"] = $stu_id;
            $relation_data["userid"] = $user_add_res;
            $relation_data["appellation"] = $relation;
            $relation_data["time"] = mktime();
            $relation_add_res = M("relation_stu_user")->add($relation_data);
        } else {
            $ret = format_ret(0,"网络不通,请稍后重试");
            echo json_encode($ret);
            die();
        }
        $ret = format_ret(1,"绑定成功");
        echo json_encode($ret);
        die();
    }
    //跳转到老师绑定页面
    function Tbuild(){
        $headimg = $_SESSION["user"]['headimg'];
        $nickname = $_SESSION["user"]['nickname'];
        $this->assign("headimg",$headimg);
        $this->assign("nickname",$nickname);
        $this->display();
    }
//    function Tbuilds(){
//        $stu_sch_name = $_SESSION["school_name"];
//        $this->assign("schoolname",$stu_sch_name);
//        $teacher_name = I("name");
//        $number = I("card");
//        //查询关系表
//        $res = M("wxtuser as user")->join("wxt_teacher_info as teacher on teacher.teacherid = user.id")->where(array("user.phone"=>$teacher_name))->field("user.id")->find();
//        if (!$res){
//            $ret= $this->format_ret(0,"请联系学校为您导入老师数据");
//            echo json_encode($ret);
//        }
//        $data["weixin"] = $_SESSION["user"]["weixin"];
//        $data["photo"] = $_SESSION["user"]["headimg"];
//        $data["create_time"] = mktime();
//        $resn= M("wxtuser")->where(array("id" => $res["id"]))->save($data);
//        if ($resn){
//            $ret = $this->format_ret(1,"绑定成功");
//            echo json_encode($ret);
//        }else{
//            $ret = $this->format_ret(1,"绑定失败");
//            echo json_encode($ret);
//        }
//    }

    //老师绑定处理
    function Tbuilds(){
        $phone = I("name");//手机号码
        $number = I("card");//绑定码
        //根据手机号码在wxtuser表中查找用户是否存在
       $result = M("wxtuser")->where(array('phone'=>$phone))->find();
        if(empty($result)){

            $ret= $this->format_ret(0,"不存在这个手机号码");
            echo json_encode($ret);
            return;
        }
        $userid = $result['id'];//获取用户ID
        $query = M('teacher_info')->where(array("teacherid"=>$userid,"bindingkey"=>$number))->find();
        if(empty($query)){
            $ret= $this->format_ret(0,"绑定码有问题，请联系学校管理员");
            echo json_encode($ret);
            return;
        }
        
        $data["weixin"] = $_SESSION["user"]["weixin"];//微信ID
        if(empty($data["weixin"])){
            $ret = $this->format_ret(0,"绑定失败");
            echo json_encode($ret);
            return;
        }
        $data["photo"] = $_SESSION["user"]["headimg"];//微信头像
        if(empty($data["photo"])){
            $ret = $this->format_ret(0,"绑定失败");
            echo json_encode($ret);
            return;
        }else{
            $photo = $this->test($_SESSION["user"]['headimg']);//将图片下载到本地
            $data["photo"] = $photo;
        }
        $data["create_time"] = mktime();
        $array= M("wxtuser")->where(array("id" => $userid))->save($data);
        if ($array){
            $ret = $this->format_ret(1,"绑定成功");
            echo json_encode($ret);
            return;
        }else{
            $ret = $this->format_ret(0,"绑定失败");
            echo json_encode($ret);
            return;
        }

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