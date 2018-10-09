<?php
namespace Apps\Controller;
use Admin\Controller\MailBoxController;
use Common\Controller\WeixinbaseController;

//信息模板的推送
class SendTplController extends WeixinbaseController
{

    //教师发给教师的群发
    function school_notice()
    {
        $content = I("content");
        $tuserid = $_SESSION['userid'];
        $tinfo = M("wxtuser")->where("id = '$tuserid'")->find();
        $tname = $tinfo['name'];
        $uisid = I('uisid');
//        $uisid = "793,795";
        $stulist = explode(",", $uisid);
//        var_dump($stulist);die();
        $stulist = array_filter($stulist);
        for ($i = 0; $i < count($stulist); $i++) {
            $userid = $stulist[$i];
            $weixin = M("wxtuser")->where("id = '$userid'")->find();
            $touser = $weixin['weixin'];
            $schoolid = $weixin['schoolid'];
            $schoolname = M("wxtuser")->where("schoolid = '$schoolid'")->find();
            $schoolname = $schoolname['school_name'];
            $tpl = array(
                //接收者
                "touser" => $touser,
                "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                "url" => $url,
                "topcolor" => "#436EEE",
                "data" => array(
                    "first" => array(
                        "value" => "您好，您有一条学校通知,请尽快查看：",
                        "color" => "#436EEE"
                    ),
                    "keyword1" => array(
                        "value" => $schoolname,
                        "color" => "#436EEE"
                    ),
                    "keyword2" => array(
                        "value" => $tname,
                        "color" => "#436EEE"
                    ),
                    "keyword3" => array(
                        "value" => date("Y-m-d H:i:s", mktime()),
                        "color" => "#436EEE"
                    ),
                    "keyword4" => array(
                        "value" => $content,
                        "color" => "#436EEE"
                    ),
                    "remark" => array(
                        "value" => "点击查看详情",
                        "color" => "#436EEE"
                    )
                )
            );
            $res = $this->sendTemplate($tpl);
        }

    }
}

    //学校通知  待接确认
    function school_notice(){
        $content = I("content");
        $tuserid  = $_SESSION['userid'];
        $userid= $_SESSION['userid'];
        $tinfo = M("wxtuser")->where("id = '$userid'")->find();
        $tname = $tinfo['name'];
        $uisid = I('uisid');
//        $uisid = "793,795";
        $stulist = explode(",",$uisid);
//        var_dump($stulist);die();
        $stulist = array_filter($stulist);
        for ($i=0;$i<count($stulist);$i++){
            $stu_userid = $stulist[$i];
            //获取学生的id
            $studeng_info = M("student_info")->where("userid = $stu_userid")->find();
            $studentname = $studeng_info['stu_name'];
            $schoolid =$studeng_info['schoollid'];
            //获取学校姓名
            $schoolname = M("school")->where("schoolid = '$schoolid'")->find();
            $schoolname = $schoolname['school_name'];
            //学生的d
            $stu_id = $studeng_info['id'];
            //获取家长的userid
            $parents = M("relation_stu_user")->where("studentid = '$stu_id'")->select();
//            var_dump($parents);die();
            $parents = $parents[$i];
            $userid = $parents['userid'];
            $puserid = M("wxtuser")->where("id = '$userid'")->find();
            $touser = $puserid['weixin'];
            echo $touser;
            $tpl = array(
                //接收者
                "touser" => $touser,
                "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                "url" => $url,
                "topcolor" => "#436EEE",
                "data" => array(
                    "first" => array(
                        "value" => "您好，您有一条学校通知,请尽快查看：",
                        "color" => "#436EEE"
                    ),
                    "keyword1" => array(
                        "value" => $schoolname,
                        "color" => "#436EEE"
                    ),
                    "keyword2" => array(
                        "value" => $tname,
                        "color" => "#436EEE"
                    ),
                    "keyword3" => array(
                        "value" => date("Y-m-d H:i:s",mktime()),
                        "color" => "#436EEE"
                    ),
                    "keyword4" => array(
                        "value" => $content,
                        "color" => "#436EEE"
                    ),
                    "remark" => array(
                        "value" =>"点击查看详情",
                        "color" => "#436EEE"
                    )
                )
            );
            $res = $this->sendTemplate($tpl);
        }

    }
    //发布班级通知
    function classNotice()
    {
        $createid = $_SESSION['userid'];
        $createinfo = M("wxtuser")->where("id = $createid")->find();
        $createname = $createinfo['name'];
        $remark = "您有一条未读通知,点击查看吧";
        $content = I("content");
        $url = I("url");
        $studentid = $_SESSION['studentid'];
        //获取学生的学校id
        $stu_info = M("student_info")->where("id= '$studentid'")->find();
        $schoolid = $stu_info['schoollid'];
        //通过学生的userid 去获取家长的id
            //拿到学生id
        $stu_id = $stu_info["id"];
        //学生班级id
        $stu_classid = $stu_info["classid"];
        //获取班级名字
        $class_name = M("school_class")->where("schoolid = '$schoolid' and id = '$stu_classid'")->find();
        //班级名字
        $classname = $class_name["classname"];
        //查询班主任名字
        $Headmaster = M("teacher_class")->where("schoolid = '$schoolid' and classid = '$stu_classid'")->find();
        $Headmaster = $Headmaster['teacherid'];
    //查询教师姓名
        $Headmaster_name = M("wxtuser")->where("id = '$Headmaster'")->find();
        $Headmaster_name = $Headmaster_name['name'];
        //学生姓名
        $stu_name = $stu_info['stu_name'];
            //去关系表拿到家人的userid
            $userid = M("relation_stu_user")->where("studentid = '$stu_id'")->select();

//            $userid = $userid[0]
            for ($i=0;$i<count($userid);$i++){
                $fid = $userid[$i]['userid'];
                $userweixin = M("wxtuser")->where("id= '$fid'")->find();
                //查到家长的微信
                $touser = $userweixin["weixin"];

                $tpl = array(
                    //接收者
                    "touser" => $touser,
                    "template_id" => "0_kRD40sZCX53gc7QrCBcCnOoSntcbS92oGVi9itnhw",
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
                            "value" => "您好，亲爱的".$stu_name."家长",
                            "color" => "#436EEE"
                        ),
                        "keyword1" => array(
                            "value" => $classname,
                            "color" => "#436EEE"
                        ),
                        "keyword2" => array(
                            "value" => $createname,
                            "color" => "#436EEE"
                        ),
                        "keyword3" => array(
                            "value" => date("Y-m-d H:i:s",mktime()),
                            "color" => "#436EEE"
                        ),
                        "keyword4" => array(
                            "value" => $content,
                            "color" => "#436EEE"
                        ),
                        "remark" => array(
                            "value" => $remark,
                            "color" => "#436EEE"
                        )
                    )
                );
                $res = $this->sendTemplate($tpl);
            }

        //var_dump($res);die();
	//echo $res;
    }//模板发送结束


    //家长请假
    function Leave(){
        $url = I("url");
        $userid = I("userid");
        $name = I("name");
        //教师id
        $receive = I("receiveid");
        $btime = I("begintime");
        $endtime = I("endtime");
        $receiveid = explode(",",$receive);
        $receiveid = array_filter($receiveid);
        for ($i=0;$i<count($receive);$i++){
            $teacherid = $receiveid[$i];
            $teauser = M("wxtuser")->where("id = '$teacherid'")->select();
            $touser = $teacherid[0]["weixin"];
            if ($touser){
                $tpl = array(
                    //接收者
                    "touser" => $touser,
                    "template_id" => "G9F7TPuq0njukTCYthsd0DqB-Tgm50uO9n1LnwjC42s",
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
                            "value" => "您好，您有一个新的请假申请",
                            "color" => "#436EEE"
                        ),
                        "keyword1" => array(
                            "value" => $name,
                            "color" => "#436EEE"
                        ),
                        "keyword2" => array(
                            "value" => date("Y-m-d H:i:s",$btime),
                            "color" => "#436EEE"
                        ),
                        "keyword3" => array(
                            "value" => date("Y-m-d H:i:s",$endtime),
                            "color" => "#436EEE"
                        ),

                        "remark" => array(
                            "value" => "家长正等着您的反馈，请点击详情进行确认。",
                            "color" => "#436EEE"
                        )
                    )
                );
// var_dump($tpl);die();
                $res = $this->sendTemplate($tpl);
            }else{
                    $ret = $this->format_ret(0,"该教师没有绑定微信");
                    echo json_encode($ret);
            }

        }
    }
    function accept_leave(){
        $url = I("url");
        $userid = I("userid");
        $stu_name = I("stu_name");
        $laeve_time = I("time");
        $result = I("result");
        $userinfo = M("wxtuser")->where("id = '$userid'")->find();
        $touser = $userinfo['weixin'];
        $lteacher = I("teachername");
            $tpl = array(
                //接收者
                "touser" => $touser,
                "template_id" => "zHCK6meBX_D1yj7OMttLVzGhkjhCSQLkeDTWfNsHkPs",
                "url" => $url,
                "topcolor" => "#436EEE",
                "data" => array(
                    "first" => array(
                        "value" => "您好，".$lteacher."教师已回复您的请假申请",
                        "color" => "#436EEE"
                    ),
                    "keyword1" => array(
                        "value" => $stu_name,
                        "color" => "#436EEE"
                    ),
                    "keyword2" => array(
                        "value" => $result,
                        "color" => "#436EEE"
                    ),
                    "keyword3" => array(
                        "value" => $lteacher,
                        "color" => "#436EEE"
                    ),

                    "remark" => array(
                        "value" => "查看明细内容请点击 “详情”",
                        "color" => "#436EEE"
                    )
                )
            );
// var_dump($tpl);die();
            $res = $this->sendTemplate($tpl);
    }
    //学校给所有学生发送信息的接口
    /*
     * @param content  发送的内容
     * @param schoolid 学校id
     */
//     function schoolNotice(){
//        $url = I("url");
//        $content = I("content");
//        $schoolid = I("schoolid");
//        //获取学校名字
//         $school_name = M("school")->where("schoolid = '$schoolid'")->find();
//         $school_name = $school_name["school_name"];
//         $receive_users = M("wxtuser")->where("schoolid = '$schoolid'")->select();
//         //过滤掉微信字段为空的数组
//         $receive_users =array_values(array_filter($receive_users,function($t){return $t['weixin'];}));
//         $receive_users  = $receive_users[0];
//         //过滤完之后就去查询
//            for ($i=0;$i<count($receive_users );$i++){
//                //家长userid
//                $userid = $receive_users['id'];
//                $weixin = $receive_users['weixin'];
//                $stu_id = M("relation_stu_user")->where("userid = '$userid'")->select();
//                $stu_id = $stu_id[0];
//                //查到学生的姓名
//            }
//             $tpl = array(
//                 //接收者
//                 "touser" => $touser,
//                 "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
//                 "url" => $url,
//                 "topcolor" => "#436EEE",
//                 "data" => array(
//                     "first" => array(
//                         "value" => "您好，您收到了一条学校信息,请及时查看",
//                         "color" => "#436EEE"
//                     ),
//                     "keyword1" => array(
//                         "value" => $school_name,
//                         "color" => "#436EEE"
//                     ),
//                     "keyword2" => array(
//                         "value" => $stu_name,
//                         "color" => "#436EEE"
//                     ),
//                     "keyword3" => array(
//                         "value" => date("Y-m-d"),
//                         "color" => "#436EEE"
//                     ),
//                     "keyword4" => array(
//                         "value" => $content,
//                         "color" => "#436EEE"
//                     ),
//                     "remark" => array(
//                         "value" => "查看明细内容请点击 “详情”",
//                         "color" => "#436EEE"
//                     )
//                 )
//             );
//// var_dump($tpl);die();
//             $res = $this->sendTemplate($tpl);
//     }
    function ReachSchool(){
        $time = I("time");
        //获取最新的刷卡时间写入数据库用
        $ymtime = substr($time,0,6);//20160707
        $hitime = substr($time,8,4);//时分
        //根据studentid 获取 学生姓名 班级 学校 这里的userid是传过来的
        $stu_userid = I("userid");
        //获取学生信息
        $studentinfo = M("student_info")->where("userid = '$stu_userid'")->select();
        //学生id
        $studentid = $studentinfo["id"];
        //学生姓名
        $stu_name = $studentinfo['stu_name'];
        //学生班级id
        $classid  = $studentinfo['classid'];
        //学生学校id
        $schoolid = $studentinfo['schoolid'];

        //判断学生的最新刷卡时间
        $lasttime = M("device_log")->where("studentId = '$studentid'")->order("attTime desc")->limit(0,1)->find();
        //获取到了之后就计算跟当前的时间差
        $timeLast = $lasttime['atttime'];
        //最后一次打卡的时间戳
        $timeLast = strtotime($timeLast);
        //计算传过来的时间戳
        $gettime = strtotime($time);
        if($gettime-$timeLast <=120){
            //入库
            echo "刷卡时间太小";
            die();
        }
        //获得当前时间，算出周几
        $weekarray=array("7","1","2","3","4","5","6");
        //计算今天周几
        $week = $weekarray[date('w')];
        $set['schoolid'] =1;
        $set['classid'] = 1;
        $set['week'] =1;
//        $set['classid'] = $classid;
//        $set['week'] = $week;
        //$newtime = date("Hi",mktime());
        $time = "1000";
        //查询设置表里面的值
        $setRes = M("attendancesetting")->where("classid = 1 and schoolid = 1 and week = 1 and '$time' between begintime and endtime")->select();
        if(!$setRes){
            $setRes = M("attendancesetting")->where("classid = 1 and schoolid = 1 and week = 1 and '$time' between endtime and latetime")->select();
        }
        if(!$setRes){
            //如果都没找到的话就是考勤异常
            $resset = M("attendancesetting")->where($set)->field('sendtype,type')->find();
            if($resset['sendtype'] = 1){
                //发送为1就执行发送模板消息 先发送老师
                $tres = M("teacher_class")->where("schoolid =1 and classid =1 and type = 1")->find();
                //查询学校名字
                $school_info = M("school")->where("schoolid = '$schoolid'")->select();
                $school_name = $school_info['school_name'];
                $teacherid = $tres["teacherid"];
                //查询老师的userid
                $ures = M("wxtuser")->where("id = '$teacherid'")->find();
                $touser = $ures['weixin'];
                //知道老师的touser之后就可以给他发送信息了
                //给老师发送模板消息
                $tpl = array(
                    //接收者
                    "touser" => $touser,
                    "template_id" => "OPENTM206962483",
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
                            "value" => "老师您好，您的学生今日考勤异常情况，请进行考勤异常补录！",
                            "color" => "#436EEE"
                        ),
                        "keyword1" => array(
                            "value" => $school_name,
                            "color" => "#436EEE"
                        ),
                        "keyword2" => array(
                            "value" => $stu_name,
                            "color" => "#436EEE"
                        ),
                        "keyword3" => array(
                            "value" => date("Y-m-d"),
                            "color" => "#436EEE"
                        ),

                        "remark" => array(
                            "value" => "查看明细内容请点击 “详情”",
                            "color" => "#436EEE"
                        )
                    )
                );
                $res = $this->sendTemplate($tpl);
            }
        }

    }
    function sendTemplate($tpl)
    {
        $json_template = json_encode($tpl);
        $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
        $access_token  = $jssdk->getAccessToken();
        $url           = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
        $res = json_decode($this->http_request($url,$json_template),true);
        if ($res["errcode"] == 0){
            $ret = $this->format_ret(1,"发送成功");
        }else{
            echo json_encode($res);
        }
    }
    function http_request($url, $data = array())
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
// post数据
        curl_setopt($ch, CURLOPT_POST, 1);
// 把post的变量加上
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    }
    //参数获取(状态，原因)
    function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
}//class end
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

