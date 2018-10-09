<?php
namespace Apps\Controller;
use Admin\Controller\MailBoxController;
use Common\Controller\WeixinbaseController;
header("Content-type: text/html; charset=utf-8");
//信息模板的推送
class SendTplController extends WeixinbaseController
{
     private $access_token;
     function _initialize()
    {
        parent::_initialize();
        //获取到appid与appsecret
        if(I("APPID")){
            $appid = I("APPID");
            $this->appid = $appid;
        }else{
            $appid = $_SESSION["APPID"] ;
            $this->appid = $appid;
        }

        if(I("APPSECRET")){
            $appsecret = I("APPSECRET");
            $this->appsecret = $appsecret;
        }else{
            $appsecret = $_SESSION["APPSECRET"];
            $this->appsecret = $appsecret;
        }
//        $appid = $_SESSION["APPID"] ;
//        $appsecret = $_SESSION["APPSECRET"] ;
        //获取到appid与appsecret
        $jssdk = new JSSDK($appid, $appsecret);
        $this->access_token = $jssdk->getAccessToken();
        //echo  $this->access_token;
        //die();
    }

    //食谱推送
    function timing_cook()
    {

        if(I("studentid")){

            $studentid = I("studentid"); //年级

        }

        $APPID = I("APPID");
        $APPSECRET = I("APPSECRET");

        $schoolid = I("schoolid");//学校ID


        $content = $this->filter_Emoji(I("content")); //食谱内容
        if(I("userid")){

            $tuserid = I("userid"); //发送者的ID
        }else{
            $tuserid = $_SESSION['userid'];
        }

        //班级id;
        $classid = I('classid');

        $stu_name = I("receiveusername");

        $cook_data = I("date");


        $tinfo = M("wxtuser")->where(array("id"=>$tuserid))->field("name")->find();
        //获取学校的名字
        $sch_info = M("school")->where(array("schoolid"=>$schoolid))->field("school_name")->find();
        $schoolname = $sch_info["school_name"]; //学校名称
        $tname = $tinfo['name']; //老师名字


        //查询该学生下的所有亲属

        $parents = M("relation_stu_user")->where(array("studentid"=>$studentid))->field("userid,appellation")->select();

        foreach ($parents as $key => $value) {

            $userid = $value['userid'];


            $relationship_name = $value['appellation'];//关系名称
            //查到openid

//            $userinfo = M('xctuserwechat')->where("userid = $userid")->field('weixin')->find();
            $userinfo = M('xctuserwechat')->where(array("userid"=>$userid,"appid"=>$APPID))->field('weixin')->find();



            $touser = $userinfo["weixin"]; //微信
            $cont = "亲爱的" .$stu_name .$relationship_name.",您有一条【校园食谱】定时信息,请尽快查看：";
            //
            $url = "http://mp.zhixiaoyuan.net/index.php/Weixin/Cookbook/index?userid=".$value["userid"]."&openid=".$touser."&appsecret=".$APPSECRET."&appid=".$APPID."&studentid=".$studentid."&schoolid=".$schoolid."&classid=".$classid."&date=".$cook_data;
            $tpl = array(
                //接收者
                "touser" => $touser,
                "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                "url" => $url,
                "topcolor" => "#436EEE",
                "data" => array(
                    "first" => array(
                        "value" => $cont,
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

    //食谱推送   2
    function school_cook()
    {
        if(I("grade")){
            $grade = I("grade"); //年级
        }

        $schoolid = I("schoolid");//学校ID

        $content = $this->filter_Emoji(I("content")); //食谱内容
        if(I("userid")){
            $tuserid = I("userid"); //发送者的ID
        }else{
            $tuserid = $_SESSION['userid'];
        }


//        $tinfo = M("wxtuser")->where(array("id"=>$tuserid))->find();
        $tinfo = M("teacher_info")->where(array("teacherid"=>$tuserid))->find();
        //获取学校的名字
        $sch_info = M("school")->where(array("schoolid"=>$schoolid))->find();
        $schoolname = $sch_info["school_name"]; //学校名称
        $tname = $tinfo['name']; //老师名字
        if($grade==0){
            $classlist = M("school_class")->where(array("schoolid"=>$schoolid))->field("id")->select();//查询到该学校的所有班级
        }else{
            $classlist = M("school_class")->where(array("schoolid"=>$schoolid,"grade"=>$grade))->field("id")->select();//查询到年级下的班级
        }
        $template = M("template")->where(array("type"=>2,"appid"=>$this->appid))->find();//查询模板
        $template_id = $template["template_id"];//模板ID

        $date = I("date");
        foreach ($classlist as $value){
            $classid = $value['id'];
            $stulist = M("class_relationship")->where(array("classid"=>$value['id']))->field("userid")->select();//查询到班级下的学生
            foreach ($stulist as $val){
                $stu_userid = $val["userid"]; //学生ID
                //查询亲属关系
                $parents = M("relation_stu_user")->where(array("studentid"=>$stu_userid))->field("userid,studentid,appellation")->select();
//                $stuinfo = M("wxtuser")->where(array('id' => $stu_userid))->field("name")->find();
                $stuinfo = M("student_info")->where(array('userid' => $stu_userid))->field("stu_name")->find();
                $stu_name = $stuinfo['stu_name'];//学生名字
                foreach ($parents as $v){
                    $relationship_name = $v['appellation'];//关系名称
                    $userid = $v["userid"];
                    //查到openid
//                    $userinfo = M("wxtuser")->where(array("id"=>$userid))->find();
//                    $touser = $userinfo["weixin"]; //微信
                    $userinfo = M("xctuserwechat")->where(array("userid"=>$userid,"appid"=>$this->appid))->find();
                    $touser = $userinfo['weixin']; //接收者微信
                    $cont = "亲爱的" .$stu_name .$relationship_name.",您有一条【校园食谱】信息,请尽快查看：";
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Cookbook/index?userid=".$userid."&openid=".$touser."&date=".$date."&studentid=".$stu_userid."&schoolid=".$schoolid."&classid=".$classid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                    if($touser){
                        $tpl = array(
                            //接收者
                            "touser" => $touser,
//                        "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                            "template_id" => $template_id,
                            "url" => $url,
                            "topcolor" => "#436EEE",
                            "data" => array(
                                "first" => array(
                                    "value" => $cont,
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
        }




    }

    //定时食谱推送

    //教师发给教师的群发 2
    function t_notice()
    {
        if(I("message_id")){
            $message_id = I("message_id"); //消息ID
        }
        $content = $this->filter_Emoji(I("content"));
        $type = I("type");
        if(I("userid")){
            $tuserid = I("userid"); //发送者的ID
        }else{
            $tuserid = $_SESSION['userid'];
        }
        $schoolid =I("schoolid");
//        $tinfo = M("teacher_class")->where(array("teacherid" => $tuserid))->find();
//        $schoolid = $tinfo['schoolid'];
        $schoolname = M("school")->where(array('schoolid' => $schoolid))->find();
        $schoolname = $schoolname['school_name']; //学校名称
        $teacher = M("teacher_info")->where(array("teacherid"=>$tuserid,"schoolid"=>$schoolid))->find();
        $tname = $teacher['name'];//老师名字
        $uisid = I('uisid'); //接收者ID
        $stulist = explode(",", $uisid); //做处理
        $stulist = array_filter($stulist);
        $template = M("template")->where(array("type"=>2,"appid"=>$this->appid))->find();//查询模板
        $template_id = $template["template_id"];//模板ID
        for ($i = 0; $i < count($stulist); $i++) {
            $userid = $stulist[$i]; //接收者ID
            $tinfo = M("teacher_info")->where(array("teacherid"=>$userid,"schoolid"=>$schoolid))->find();
            $name = $tinfo['name']; //老师名字
//            $touser = $weixin['weixin']; //接收者微信
            $userinfo = M("xctuserwechat")->where(array("userid"=>$userid,"appid"=>$this->appid))->find();
            $touser = $userinfo['weixin']; //接收者微信
            if ($type ==1){
                //这里代办事宜
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchagency/index?userid=".$userid."&openid=".$touser."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                $title = "亲爱的".$name."老师,您有一条【待办事宜】信息,请尽快查看：";
            }elseif($type ==2){ //老师群发信息
//                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/TchInformation/Huoqu?userid=".$weixin["id"]."&openid=".$touser."schoolid=".$schoolid;
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/TchInformation/details?userid=".$userid."&openid=".$touser."&schoolid=".$schoolid."&message_id=".$message_id."&receiver_user_id=".$userid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                $title = "亲爱的".$name."老师,您有一条【教师群发】信息,请尽快查看：";
            }elseif($type ==3){ //老师群发通告
//                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchnotice?userid=".$weixin["id"]."&openid=".$touser."&schoolid=".$schoolid;
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchnotice/details?userid=".$userid."&openid=".$touser."&schoolid=".$schoolid."&noticeid=".$message_id."&receiverid=".$userid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                $title = "亲爱的".$name."老师,您有一条【教师公告】信息,请尽快查看：";
            }elseif($type ==4){ //转派待办事宜
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchagency/index?userid=".$userid."&openid=".$touser."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                $title = "亲爱的".$name."老师,您有一条【转派事宜】信息,请尽快查看：";
            }
            if($touser){
                $tpl = array(
                    //接收者
                    "touser" => $touser,
//                "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                    "template_id" => $template_id,
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
//                        "value" => "您有一条【教师通知信息】,请尽快查看：",
                            "value" => $title,
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

    //学校通知   老师发给学生的通知 家庭作业 代接 班级活动等  2
    function school_notice()
    {
        if(I("noticeid")){
            $noticeid = I("noticeid"); //新增的通知公告ID
        }
        if(I("homework_id")){
            $homework_id = I("homework_id"); //新增的作业ID
        }
        if(I("activity_id")){
            $activity_id = I("activity_id"); //新增的活动ID
        }
        $content = $this->filter_Emoji(I("content"));
        if(I("userid")){
            $tuserid = I("userid"); //发送者的ID
        }else{
            $tuserid = $_SESSION['userid'];
        }
        $schoolid =I("schoolid");
//        $tinfo = M("teacher_info")->where(array("teacherid"=>$tuserid))->find();
        $tinfo = M("teacher_info")->where(array("teacherid"=>$tuserid,"schoolid"=>$schoolid))->find();
        //获取学校的名字
//        $sch_info = M("school")->where(array("schoolid"=>$tinfo["schoolid"]))->find();
        $sch_info = M("school")->where(array("schoolid"=>$schoolid))->find();
        $schoolname = $sch_info["school_name"];
        $tname = $tinfo['name'];
        $uisid = I('uisid');

        $stulist = explode(",", $uisid);
        $stulist = array_filter($stulist);
        $template = M("template")->where(array("type"=>2,"appid"=>$this->appid))->find();//查询模板
        $template_id = $template["template_id"];//模板ID
        for ($i = 0; $i < count($stulist); $i++) {
            //获取学生的id
            $stu_userid = $stulist[$i];
            $parents = M("relation_stu_user")->where(array("studentid"=>$stu_userid))->field("userid,studentid,appellation")->select();

            $stuinfo = M("student_info")->where(array('userid' => $stu_userid))->field("stu_name")->find();
            $stu_name = $stuinfo['stu_name'];//学生名字

            //拿到关系 开始做循环发送
            for ($j=0;$j<count($parents);$j++){
                $relationship_name = $parents[$j]['appellation'];//关系名称
                $userid = $parents[$j]["userid"];
                //查到openid
                $userinfo = M("xctuserwechat")->where(array("userid"=>$userid,"appid"=>$this->appid))->find();
                $touser = $userinfo['weixin']; //接收者微信
                $type = I("type");
                if ($type ==1){
                    //发给学生
                    $cont = "亲爱的" .$stu_name .$relationship_name.",您有一条【班级公告】信息,请尽快查看：";
//                        $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Notice?userid=".$userinfo["id"]."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"];
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Notice/details?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&receiverid=".$stulist[$i]."&noticeid=".$noticeid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif ($type == 2){
                    $cont = "亲爱的" . $stu_name .$relationship_name.",您有一条【家庭作业】通知,请尽快查看：";
//                        $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Homework?userid=".$userinfo["id"]."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"];
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Homework/details?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&receiverid=".$stulist[$i]."&homework_id=".$homework_id."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif ($type == 3){
                    $cont = "亲爱的" . $stu_name . $relationship_name.",您有一条【成长日记】通知,请尽快查看：";
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Growthdiary?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif ($type == 4){
                    $cont = "亲爱的" . $stu_name . $relationship_name.",您有一条【动态圈】通知,请尽快查看：";
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/MicroBlog?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif($type == 5){//代接模板
                    $cont = "亲爱的" . $stu_name . $relationship_name.",您有一条【代接】通知,请尽快查看：";
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Replace/Handle?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif($type == 6){//代办
                    $cont = "您有一条【代办事宜】通知,请尽快查看：";
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchagency/index?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif($type == 7){//代办
                    $cont = "亲爱的" . $stu_name . $relationship_name.",您有一条【班级活动】通知,请尽快查看：";
//                        $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Activity/index?userid=".$userinfo["id"]."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"];
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Activity/details?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&receiverid=".$stulist[$i]."&activity_id=".$activity_id."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }elseif($type == 8){//老师点评
                    $cont = "亲爱的" . $stu_name . $relationship_name.",您有一条【老师点评】通知,请尽快查看：";
                    $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Comments/index?userid=".$userid."&openid=".$touser."&studentid=".$stulist[$i]."&schoolid=".$tinfo["schoolid"]."&appid=".$this->appid."&appsecret=".$this->appsecret;
                }
                if($touser){
                    $tpl = array(
                        //接收者
                        "touser" => $touser,
//                        "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                        "template_id" => $template_id,
                        "url" => $url,
                        "topcolor" => "#436EEE",
                        "data" => array(
                            "first" => array(
                                "value" => $cont,
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

    }




//发布班级通知 老师发给学生的群发信息  1
    function classNotice()
    {
        //$resource = fopen("./log.txt","w+");
        if(I("message_id")){  //消息ID
            $message_id = I("message_id");
        }
        if(I("userid")){
            $createid = I("userid"); //发送者的ID
        }else{
            $createid = $_SESSION['userid'];
        }

        if(I("send_user_name")){
            $createname = I("send_user_name"); //老师名字
        }else{
//            $createinfo = M("wxtuser")->where(array('id' => $createid))->find();
//            $createname = $createinfo['name'];
            $tinfo = M("teacher_info")->where(array("teacherid"=>$createid))->find();
            $createname= $tinfo['name']; //老师名字
        }

        $classid = I("classid");//班级ID
        $schoolid = I("schoolid");//学校ID
        //班级名称
       if(I("classname")){
           $classname =I("classname");
       }else{
           $class_info = M("school_class")->where(array("schoolid" => $schoolid, 'id' => $classid))->find();
           $classname = $class_info['classname'];
       }

        $remark = "点击查看详情";
        $content = $this->filter_Emoji(I("content"));
        //所有学生ID 例如1,2,3
        $stulist = I("uisid");
        $stu_arr = explode(",", $stulist);
        $template = M("template")->where(array("type"=>1,"appid"=>$this->appid))->find();
        $template_id = $template["template_id"];//模板ID
        for ($i = 0; $i < count($stu_arr); $i++) {
            //查到所有的亲属关系
            $stu_info = M("relation_stu_user")->where(array('studentid' => $stu_arr[$i]))->field("userid,studentid,appellation")->select();
//            $stuinfo = M("wxtuser")->where(array('id' => $stu_arr[$i]))->field("name")->find();
//            $stu_name = $stuinfo['name'];//学生名字
            $stuinfo = M("student_info")->where(array('userid' =>  $stu_arr[$i]))->field("stu_name")->find();
            $stu_name = $stuinfo['stu_name'];//学生名字
//            fwrite($resource, "外面第".$i."次for循环时间结束:".date('Y-m-d H:i:s', time())."\r\n");

            if (!empty($stu_info)){
                for ($j = 0; $j < count($stu_info); $j++) {//给所有的关联亲属发送模板消息

                    $fid = $stu_info[$j]['userid'];//用户ID
                    $relationship_name = $stu_info[$j]['appellation'];//关系名称
                    $studentid = $stu_info[$j]['studentid'];//学生ID
                    $wes_res = M("xctuserwechat")->where(array("userid"=>$fid,"appid"=>$this->appid))->find();
                    $touser = $wes_res['weixin']; //接收者微信

//                    $userweixin = M("wxtuser")->where(array("id" => $fid))->field('weixin')->find();
//                    $touser = $userweixin["weixin"];//查到家长的微信
                    if($touser){
                        $tpl = array(
                            //接收者
                            "touser" => $touser,
//                        "template_id" => "0_kRD40sZCX53gc7QrCBcCnOoSntcbS92oGVi9itnhw",
//                        "template_id" => "7ozEY9pqR8R975hEH_5LqdXhx0ZygYFS8iY39CoWxxA",
                            "template_id" => $template_id,
//
                            "url" => "http://".$_SERVER['HTTP_HOST']."/index.php/Weixin/Message/details?userid=".$fid."&openid=".$touser."&studentid=".$studentid."&schoolid=".$schoolid."&receiver_user_id=".$studentid."&message_id=".$message_id."&appid=".$this->appid."&appsecret=".$this->appsecret,
                            "topcolor" => "#436EEE",
                            "data" => array(
                                "first" => array(
                                    "value" => "亲爱的" . $stu_name . $relationship_name.",您有一条【班级群发】信息,请尽快查看",
                                    "color" => "#436EEE"
                                ),
                                "keyword1" => array(
                                    "value" => $classname,
                                    "color" => "#436EEE"
                                ),
                                "keyword2" => array(
                                    "value" => $createname,
//                                "value" => $message_id,
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
                                    "value" => $remark,
                                    "color" => "#436EEE"
                                )
                            )
                        );
                        $res = $this->sendTemplate($tpl);
                    }

//                    $b = print_r($res,true);
//                    fwrite($resource, $b.date('Y-m-d H:i:s', time())."\r\n");

                }
            }
        }

    }//模板发送结束

//家长叮嘱模板 2
    function Parent_Told()
    {
            $name = I("name");
            $content = $this->filter_Emoji(I("content"));
            $type = I("type");
            $uisid = I('uisid');//传过来的老师ID
            $schoolid= I("schoolid");
//            $tinfo = M("teacher_info")->where(array("teacherid"=>$uisid))->find();
            $tinfo = M("teacher_info")->where(array("teacherid"=>$uisid,"schoolid"=>$schoolid))->find();
            $tname = $tinfo['name']; //老师名字
            //$touser = $tinfo['weixin'];//老师的微信
            $userinfo = M("xctuserwechat")->where(array("userid"=>$uisid,"appid"=>$this->appid))->find();
            $touser = $userinfo['weixin']; //接收者微信

            //$schoolid = $tinfo['schoolid'];
            $school = M("school")->where(array('schoolid' => $schoolid))->find();
            $schoolname = $school['school_name'];//学校名称

            $template = M("template")->where(array("type"=>2,"appid"=>$this->appid))->find();//查询模板
            $template_id = $template["template_id"];//模板ID
            if ($type ==1){
                //这里调用的是家长叮嘱
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchtold?userid=".$uisid."&openid=".$touser."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret;
            }
            if($touser){
                $tpl = array(
                    //接收者
                    "touser" => $touser,
//                "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                    "template_id" => $template_id,
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
                            "value" => "亲爱的".$tname."老师,您有一条【家长叮嘱】通知,请尽快查看：",
                            "color" => "#436EEE"
                        ),
                        "keyword1" => array(
                            "value" => $schoolname,
                            "color" => "#436EEE"
                        ),
                        "keyword2" => array(
                            //"value" => $tname,
                            "value" => $name,
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

    // 老师回复家长叮嘱  1
    function Reply_Told()
    {
        //老师ID
        if(I("teacherid")){
            $teacherid = I("teacherid");
//            $createinfo = M("wxtuser")->where(array('id' => $teacherid))->find();
//            $createname = $createinfo['name'];
            $tinfo = M("teacher_info")->where(array("teacherid"=>$teacherid))->find();
            $createname = $tinfo['name']; //老师名字
        }

        //家长ID
        if(I("parentid")){
            $parentid = I("parentid");
        }

        //学生ID
        if(I("studentid")){
            $studentid = I("studentid");
            $class_info = M("student_info as a")->join("wxt_school_class as b on a.classid= b.id")->
            field("b.classname,a.classid,a.stu_name")->where("a.userid = $studentid")->find();
            $classname = $class_info['classname'];
            $classid = $class_info['classid'];
            $stu_name = $class_info['stu_name'];
        }

        $content = $this->filter_Emoji(I("content"));
        $schoolid = I("schoolid");//学校ID

        $stu_info = M("relation_stu_user")->where(array('studentid' =>$studentid,"userid"=>"$parentid"))->field("userid,studentid,appellation")->find();
        $relationship_name = $stu_info['appellation'];//关系名称
        $wes_res = M("xctuserwechat")->where(array("userid"=>$parentid,"appid"=>$this->appid))->find();
        $touser = $wes_res['weixin']; //接收者微信

        $remark = "点击查看详情";
        $template = M("template")->where(array("type"=>1,"appid"=>$this->appid))->find();
        $template_id = $template["template_id"];//模板ID

        if (!empty($stu_info)){
                    if($touser){
                        $tpl = array(
                            //接收者
                            "touser" => $touser,
//
                            "template_id" => $template_id,
//
                            "url" => "http://".$_SERVER['HTTP_HOST']."/index.php/Weixin/Tell/index?userid=".$parentid."&openid=".$touser."&studentid=".$studentid."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret,
                            "topcolor" => "#436EEE",
                            "data" => array(
                                "first" => array(
                                    "value" => "亲爱的" . $stu_name . $relationship_name.",您有一条【叮嘱回复】信息,请尽快查看",
                                    "color" => "#436EEE"
                                ),
                                "keyword1" => array(
                                    "value" => $classname,
                                    "color" => "#436EEE"
                                ),
                                "keyword2" => array(
                                    "value" => $createname,
//                                "value" => $message_id,
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
                                    "value" => $remark,
                                    "color" => "#436EEE"
                                )
                            )
                        );
                        $res = $this->sendTemplate($tpl);
                    }

//
            }


    }//模板发送结束

    //继续
    //代接回复
    public function Replace_Reply()
    {

        $teachername = I("teachername");//老师名称
        $content = $this->filter_Emoji(I("content"));

        $schoolid = I("schoolid");
        $parentid = I("parentid");

        $teacherid = I('teacherid');//传过来的老师ID
        $studentid = I("studentid");
        if($teachername and $content and $schoolid and $parentid and $teacherid){
            //$pinfo = M("wxtuser")->where(array("id" => $parentid))->find();
            $pinfo = M("relation_stu_user")->where(array("userid" => $parentid,"studentid"=>$studentid))->find();
            $name = $pinfo['name'];//家长名字
            $userinfo = M("xctuserwechat")->where(array("userid"=>$teacherid,"appid"=>$this->appid))->find();
            $touser = $userinfo['weixin']; //接收者微信

            $school = M("school")->where(array('schoolid' => $schoolid))->find();
            $schoolname = $school['school_name'];//学校名称

            $template = M("template")->where(array("type"=>2,"appid"=>$this->appid))->find();//查询模板
            $template_id = $template["template_id"];//模板ID

            $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchanswer/daiJie?userid=".$teacherid."&openid=".$touser."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret;
        }

        if($touser){
            $tpl = array(
                //接收者
                "touser" => $touser,
                "template_id" => $template_id,
                "url" => $url,
                "topcolor" => "#436EEE",
                "data" => array(
                    "first" => array(
                        "value" => "亲爱的".$teachername."老师,您有一条【代接回复】通知,请尽快查看：",
                        "color" => "#436EEE"
                    ),
                    "keyword1" => array(
                        "value" => $schoolname,
                        "color" => "#436EEE"
                    ),
                    "keyword2" => array(
                        //"value" => $tname,
                        "value" => $name,
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


    //家长请假  3
    function Leave()
    {

        $userid = I("userid");
        $name = I("name");
        $schoolid = I("schoolid");
        //教师id
        $receive = I("receiveid");
        $btime = I("begintime");
        $endtime = I("endtime");
        $receiveid = explode(",", $receive);
        $receiveid = array_filter($receiveid);
        $template = M("template")->where(array("type"=>3,"appid"=>$this->appid))->find();//查询模板
        $template_id = trim($template["template_id"]);//模板ID
        for ($i = 0; $i < count($receive); $i++) {
            $teacherid = $receiveid[$i];
//            $teauser = M("wxtuser")->where(array('id' => $teacherid))->find();
            $teauser = M("teacher_info")->where(array('teacherid' => $teacherid))->find();
//            $touser = $teauser["weixin"];
            $userinfo = M("xctuserwechat")->where(array("userid"=>$teacherid,"appid"=>$this->appid))->find();
            $touser = $userinfo['weixin']; //接收者微信
            if ($touser) {
                $url  = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Tchleave?userid=".$teacherid."&openid=".$touser."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret;
                $tpl = array(
                    //接收者
                    "touser" => $touser,
//                    "template_id" => "G9F7TPuq0njukTCYthsd0DqB-Tgm50uO9n1LnwjC42s",
                  // "template_id" => "SNrApxRNvc8SJwXS7909SNCTfOzz1Ux4J8JuNYBvIb8",
                    "template_id" =>$template_id,
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
                            "value" => "亲爱的".$teauser['name']."老师,您好，您有一个新的【请假申请】通知",
                            "color" => "#436EEE"
                        ),
                        "keyword1" => array(
                            "value" => $name,
                            "color" => "#436EEE"
                        ),
                        "keyword2" => array(
                            "value" => date("Y-m-d", $btime),
                            "color" => "#436EEE"
                        ),
                        "keyword3" => array(
                            "value" => date("Y-m-d", $endtime),
                            "color" => "#436EEE"
                        ),

                        "remark" => array(
                            "value" => "家长正等着您的反馈，请点击详情进行确认。",
                            "color" => "#436EEE"
                        )
                    )
                );
                $res = $this->sendTemplate($tpl);
                echo json_encode($res);
            } else {
                $ret = $this->format_ret(0, "该教师没有绑定微信");
                echo json_encode($ret);
            }

        }
    }
//4
    function accept_leave()
    {
        $result = I("status");
        if ($result==1){
            $result = "批准";
        }else{
            $result = "未批准";
        }
        $leaveid = I("leaveid");
        if(I("userid")){
            $teacherid = $_SESSION['userid'];
        }else{
            $teacherid = $_SESSION['userid'];
        }
        $schoolid = I("schoolid");
        //$tech_res = M("wxtuser")->where(array("id"=>$teacherid))->find();
        $tech_res = M("teacher_info")->where(array('teacherid' => $teacherid,"schoolid"=>$schoolid))->find();
//        $touser = $tech_res['weixin'];
        $lteacher = $tech_res['name'];
        $res = M("leave")->where(array('id'=>$leaveid))->find();
        //获取家长ID 微信
        $stu_id = $res['userid'];
//        $stu_info = M("wxtuser")->where(array("id"=>$stu_id))->find();
//        $touser = $stu_info['weixin'];
        $userinfo = M("xctuserwechat")->where(array("userid"=>$stu_id,"appid"=>$this->appid))->find();
        $touser = $userinfo['weixin']; //接收者微信
        //$stu = M("wxtuser")->where(array("id"=>$res['studentid']))->find();
        $stu = M("student_info")->where(array("userid"=>$res['studentid']))->find();
        $stu_name = $stu['stu_name'];//学生姓名
        //获取学生的姓名和id
        $studentid = $res["studentid"];

        $template = M("template")->where(array("type"=>4,"appid"=>$this->appid))->find();//查询模板
        $template_id = trim($template["template_id"]);//模板ID

        $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Leave?userid=".$stu_id."&openid=".$touser."&studentid=".$studentid."&schoolid=".$schoolid."&appid=".$this->appid."&appsecret=".$this->appsecret;
        if($touser){
            $tpl = array(
                //接收者
                "touser" => $touser,
//            "template_id" => "zHCK6meBX_D1yj7OMttLVzGhkjhCSQLkeDTWfNsHkPs",
                //"template_id" => "fX2lLS40DMzeoVP42BKf4-OAm5sqqHTUHQHLKR15B7E",
                "template_id" =>$template_id,
                "url" => $url,
                "topcolor" => "#436EEE",
                "data" => array(
                    "first" => array(
                        "value" => "您好，" . $lteacher . "教师已回复您的【请假申请】",
                        "color" => "#436EEE"
                    ),
                    "keyword1" => array(
                        "value" => $stu_name,
                        "color" => "#436EEE"
                    ),
                    "keyword2" => array(
                        "value" => date("Y-m-d H:i:s"),
                        "color" => "#436EEE"
                    ),
                    "keyword3" => array(
                        "value" => $result,
                        "color" => "#436EEE"
                    ),
                    "keyword4" => array(
                        "value" => $lteacher,
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


    function article_Notice()
    {
        ignore_user_abort(true);

        $schoolid = I("schoolid");
        $articleid = I("articleid");
        $userid = I("userid");
        $column_id = I("column_id");
        $type = I("type");
        $content = I("content");
        $teachername = I("teachername");
        $school_name = I("school_name");
        $title = I("title");
        $urltype = I("urltype");
        $articleurl = I("articleurl");


        $content = $this->filter_Emoji($content);


        $uisid = I('uisid'); //接收者ID
        $stulist = explode(",", $uisid); //做处理
        $stulist = array_unique(array_filter($stulist));

        $template = M("template")->where(array("type"=>2,"appid"=>$this->appid))->find();//查询模板
        $template_id = $template["template_id"];//模板ID

        for ($i = 0; $i < count($stulist); $i++) {
            $userid = $stulist[$i]; //接收者ID

            $userinfo = M("xctuserwechat")->where(array("userid"=>$userid,"appid"=>$this->appid))->find();
            $touser = $userinfo['weixin']; //接收者微信

            if($urltype==1)
            {
                $url = 'http://'.$_SERVER['HTTP_HOST']."/index.php/Weixin/Schoolweb/article_details?user_id=".$userid."&openid=".$touser."&school_id=".$schoolid."&wx_appid=".$this->appid."&wx_appsecret=".$this->appsecret."&id=".$articleid."&type=".$type."&column_id=".$column_id;
            }else{
                $url = $articleurl;
            }


            if($touser){
                $tpl = array(
                    //接收者
                    "touser" => $touser,
//                "template_id" => "yH7_lso4XFgtNAYCqD5LmTobistjEj9vZ-QJYzhDbfA",
                    "template_id" => $template_id,
                    "url" => $url,
                    "topcolor" => "#436EEE",
                    "data" => array(
                        "first" => array(
                            "value" => $title,
                            "color" => "#436EEE"
                        ),
                        "keyword1" => array(
                            "value" => $school_name,
                            "color" => "#436EEE"
                        ),
                        "keyword2" => array(
                            "value" => $teachername,
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


//考勤 5
    function ReachSchool()
    {






        //传过来的时间
        $time = strtotime(I("attTime"));
        // var_dump($time);


        //获取图片

        $APPID = I("APPID");
        $APPSECRET = I("APPSECRET");
 //TODO以前存在服务器上的图片写法,现在改用七牛云
        // $allString = I('pics');

        // $searchString = "addvances/";

        // $newString = strstr($allString, $searchString);
        // $length = strlen($searchString);

        // $pic = substr($newString, $length);
        $pic = I('pics');

        //获取接收过来的的卡号
        $cardNo = I('cardNo');



        file_put_contents('./log/log.txt', print_r($_GET, true));



        //根据studentid 获取 学生姓名 班级 学校 这里的userid是传过来的
        // $stu_userid = I("userid");
        //根据卡号去查持卡人信息
        $card_info = M("student_card")->where("cardNo = $cardNo and handletype = 1")->find();

        //如果为学生
        if($card_info['cardtype']==0)
        {

            $userid = $card_info['personid'];
            // var_dump($userid);
            //获取班级
            $classid = $card_info['classid'];

            $cardtype = $card_info['cardtype'];

           //获取学校id
            $schoolid = $card_info['schoolid'];

            //查询是否有不打卡设置
            $is_Clock =  $this->NoClock($schoolid,$classid,$userid,2,$cardNo,$cardtype,$pic,$APPID,$APPSECRET);

            //如果没有不打卡设置
            if(!$is_Clock)
            {

                $this->attendances($cardNo,$time,$userid,$classid,$pic,$cardtype,$APPID,$APPSECRET);

            }


        }

        //如果為教師
        if($card_info['cardtype']==1)
        {

            $userid = $card_info['personid'];

            $schoolid = $card_info['schoolid'];

            $cardtype = $card_info['cardtype'];

            //查询是否有不打卡设置
            $is_Clock =  $this->NoClock($schoolid,$classid,$userid,1,$cardNo,$cardtype,$pic,$APPID,$APPSECRET);

            if($is_Clock)
            {
                exit();
            }


            $lasttime = M("teacher_attendances")->where("userid = $userid")->order("arrivetime desc")->field('arrivetime')->limit(0, 1)->find();


            if($lasttime){
                //获取到了之后就计算跟当前的时间差
                $gettime = $time;

                $timeLast = $lasttime['arrivetime'];


                //计算传过来的时间戳

                if ($gettime - $timeLast <= 120) {
                    //入库
                    echo "刷卡时间间隔太频繁";
                    die();
                }
            }

            //去考勤人员表里查询
            $teacher_schedule_person = M("teacher_schedule_person")
                                     ->alias("p")
                                     ->join("wxt_teacher_schedule_group g ON p.groupid = g.id")
                                     ->where(array("p.personid"=>$userid,"p.schoolid"=>$schoolid))
                                     ->field("p.personid,p.groupid,g.name,g.type,p.is_att")
                                     ->find();

            //如果该老师没有考勤是否需要推送消息?
             if(!$teacher_schedule_person)
             {
                 $this->teacher_add_attendances($userid,$schoolid,$cardNo,$cardtype,$time,7,$pic,$APPID,$APPSECRET);
                 exit();
             }
             $groupid = $teacher_schedule_person['groupid'];

             $teacherid = $teacher_schedule_person['personid'];

            //如果该老师不需要考勤  也需要推送信息
            if($teacher_schedule_person['is_att']==2)
            {
                $this->teacher_add_attendances($userid,$schoolid,$cardNo,$cardtype,$time,7,$pic,$APPID,$APPSECRET);
                exit();
            }

            $da_time = date('H:i',$time);
            //根据状态来区分是固定班次还是排班制
            if($teacher_schedule_person['type']==1)
            {
                //如果为固定班制
                $this->teacher_fixation($groupid,$teacherid,$schoolid,$cardNo,$cardtype,$time,$pic,$APPID,$APPSECRET);


            }else{
                //如果为排班制

                $this->teacher_Scheduling($groupid,$teacherid,$schoolid,$cardNo,$cardtype,$time,$pic,$APPID,$APPSECRET);
            }

            exit();
            // var_dump($schoolid);
            //获取今天为星期几
//            $week_time=date('w',time());
//
//
//
//            //查出该老师的排班情况
//            $schedule = M('teacher_schedule')->where("teacherid = $userid and schoolid = $schoolid")->find();
//
//            // var_dump($schedule);
//
//
//
//            //判断星期几
//            switch ($week_time) {
//                //如果为星期一 将该老师为星期一的排班取出 下面以此类推
//                case '1':
//                    //班次ID
//                    $orderid = $schedule['monday'];
//                    break;
//                case '2':
//                    $orderid = $schedule['tuesday'];
//                    break;
//                case '3':
//                    $orderid = $schedule['wednesday'];
//
//                    break;
//                case '4':
//                    $orderid = $schedule['thursday'];
//
//                    break;
//                case '5':
//                    $orderid = $schedule['friday'];
//
//                    break;
//                case '6':
//                    $orderid = $schedule['saturday'];
//
//                    break;
//                //星期天会时间戳会转换成0
//                case '0':
//                    $orderid = $schedule['sunday'];
//
//                    break;
//
//            }
//
//
//
//
//            $this->teacher_schedule($cardNo,$userid,$orderid,$schoolid,$time,$pic,$cardtype,$APPID,$APPSECRET);



        }

        //如果為教師
//        if($card_info['cardtype']==1)
//        {
//
//            $userid = $card_info['personid'];
//
//            $schoolid = $card_info['schoolid'];
//
//
//            $cardtype = $card_info['cardtype'];
//
//            //去考勤人员表里查询
////            $teacher_schedule_person = M("teacher_schedule_person")->where(array("personid"=>$userid,"schoolid",))
//
//            // var_dump($schoolid);
//            //获取今天为星期几
//            $week_time=date('w',time());
//
//
//
//            //查出该老师的排班情况
//            $schedule = M('teacher_schedule')->where("teacherid = $userid and schoolid = $schoolid")->find();
//
//            // var_dump($schedule);
//            // var_dump($schedule);
//
//
//
//            //判断星期几
//            switch ($week_time) {
//                //如果为星期一 将该老师为星期一的排班取出 下面以此类推
//                case '1':
//                    //班次ID
//                    $orderid = $schedule['monday'];
//                    break;
//                case '2':
//                    $orderid = $schedule['tuesday'];
//                    break;
//                case '3':
//                    $orderid = $schedule['wednesday'];
//
//                    break;
//                case '4':
//                    $orderid = $schedule['thursday'];
//
//                    break;
//                case '5':
//                    $orderid = $schedule['friday'];
//
//                    break;
//                case '6':
//                    $orderid = $schedule['saturday'];
//
//                    break;
//                //星期天会时间戳会转换成0
//                case '0':
//                    $orderid = $schedule['sunday'];
//
//                    break;
//
//            }
//
//
//
//
//            $this->teacher_schedule($cardNo,$userid,$orderid,$schoolid,$time,$pic,$cardtype,$APPID,$APPSECRET);
//
//
//
//        }
        //如果为家长

        if($card_info['cardtype']==2)
        {
            $userid = $card_info['personid'];
            // var_dump($userid);

            $classid = $card_info['classid'];
            // var_dump($classid);

            $cardtype = $card_info['cardtype'];
            // var_dump($cardtype);

            $this->attendances($cardNo,$time,$userid,$classid,$pic,$cardtype,$APPID,$APPSECRET);

        }


    }

 
/**
 * cardNo 卡号  userid 为老师id  orderid 为班次   schoolid 学校id   time 传递过来的时间 pic为图片  cardtype 为卡类型
 */
    //老师固定班次
    public function teacher_fixation($groupid,$teacherid,$schoolid,$cardNo,$cardtype,$time,$pic,$APPID,$APPSECRET)
    {



        //获取今天为星期几
        $week_time=date('w',time());

        $da_time = date('H:i',$time);

        //查询出当天的班次
        $fixation = M("teacher_schedule_fixation")->where(array("groupid"=>$groupid,"week"=>$week_time))->find();

        $orderid = $fixation['scheduleid'];

       //如果为休息
       if($orderid==0)
       {
           $this->teacher_add_attendances($teacherid,$schoolid,$cardNo,$cardtype,$time,0,$pic,$APPID,$APPSECRET);
           exit();
       }

        $schedule_add  = M('teacher_schedule_detail')->where("orderid = $orderid and schoolid = $schoolid and '$da_time' between ss_time_begintime and ss_time_endtime")->find();;

        $this->teacher_add_attendances($teacherid,$schoolid,$cardNo,$cardtype,$time,$schedule_add['type'],$pic,$APPID,$APPSECRET);


    }

    //老师排班制
    public function teacher_Scheduling($groupid,$teacherid,$schoolid,$cardNo,$cardtype,$time,$pic,$APPID,$APPSECRET)
    {
        $date = date('Y-m-d',$time);

        $date_time = strtotime($date);

        $da_time = date('H:i',$time);


        //查询出当天的班次
        $fixation = M("teacher_schedule_person_detail")->where(array("groupid"=>$groupid,"time"=>$date_time))->find();


        $orderid = $fixation['scheduleid'];


        $schedule_add  = M('teacher_schedule_detail')->where("orderid = $orderid and schoolid = $schoolid and '$da_time' between ss_time_begintime and ss_time_endtime")->find();

        //如果为休息
        if($orderid==0)
        {
            $this->teacher_add_attendances($teacherid,$schoolid,$cardNo,$cardtype,$time,0,$pic,$APPID,$APPSECRET);
            exit();
        }

        $schedule_add  = M('teacher_schedule_detail')->where("orderid = $orderid and schoolid = $schoolid and '$da_time' between ss_time_begintime and ss_time_endtime")->find();


        $this->teacher_add_attendances($teacherid,$schoolid,$cardNo,$cardtype,$time,$schedule_add['type'],$pic,$APPID,$APPSECRET,$da_time,$schedule_add);


    }

    //存入老师考勤记录表
    public function teacher_add_attendances($userid,$schoolid,$cardNo,$cardtype,$time,$type,$pic,$APPID,$APPSECRET,$da_time,$schedule_add)
    {




             $data['userid'] = $userid;
             $data['schoolid'] = $schoolid;
             $data['arrivetime'] = $time;
             $data['cardno'] = $cardNo;
             $data['cardtype'] = $cardtype;
             $data['arrivedate'] = date('Y-m-d',$time);
             $data['leavepicture'] = $pic;
             //默认状态正常
             $data['status'] = 1;
             $data['attendancetype'] = $type;


       if(!empty($schedule_add)){
        //如果时间 大于 老师的上班时间为迟到  以此类推
         if($schedule_add['type']==1 && $da_time > $schedule_add['ss_time'])
         {
                  $data['status'] = 2;
               $data['attendancetype'] = 1;
         }
       //如果时间 小于 老师的下班时间为早退  以此类推
        if($schedule_add['type']==2 && $da_time < $schedule_add['ss_time'])
         {
                  $data['status'] = 3;
                $data['attendancetype'] = 2;
         }

          if($schedule_add['type']==3 && $da_time > $schedule_add['ss_time'])
         {
                  $data['status'] = 2;
                $data['attendancetype'] = 3;
         }

           if($schedule_add['type']==4 && $da_time < $schedule_add['ss_time'])
         {
                  $data['status'] = 3;
                $data['attendancetype'] = 4;
         }

           if($schedule_add['type']==5 && $da_time > $schedule_add['ss_time'])
         {
                  $data['status'] = 2;
                $data['attendancetype'] = 5;
         }
           if($schedule_add['type']==6 && $da_time < $schedule_add['ss_time'])
         {
                  $data['status'] = 3;
                $data['attendancetype'] = 6;
         }
     }else{

               $data['status'] = 7;
               $data['attendancetype'] = 7;
               $att_type = "打卡成功";
               $str = "{老师姓名}老师你好已于{时间}刷卡，卡号为:{卡号}请确认。";
     }
        $attendances = M('teacher_attendances')->add($data);
        switch ($type) {

            case '0':
                $att_type = '休息打卡';
                $str = "今天是休息日,{老师姓名}老师已于{时间}到校，卡号为:{卡号}请确认。";
                break;
              case '1':
                 $att_type = '上午上班打卡';
                 $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                  break;
             case '2':
                 $att_type = '上午下班打卡';
                 $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                  break;
            case '3':
                $att_type = '下午上班打卡';
                $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                break;
            case '4':
                $att_type = '下午下班打卡';
                $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                break;
            case '5':
                $att_type = '晚上上班打卡';
                $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                break;
            case '6':
                $att_type = '晚上下班打卡';
                $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                break;
            case '7':
                $att_type = '打卡成功';
                $str = "{老师姓名}老师已于{时间}到校打卡，卡号为:{卡号}请确认。";
                break;
         }


         //查询老师
         $teacher_info=M("teacher_info")
        ->where("id = $userid")
        ->field("id,teacherid as userid,name")
        ->find();


        //查询学校
        $school_info = M("school")->where("schoolid = '$schoolid'")->find();

        $school_name = $school_info['school_name'];

        $send_time = date('Y-m-d',$time);
        $now_time  = date("Y-m-d");

        //老师名字
        $teacher_name = $teacher_info['name'];

        $teacher_id = $teacher_info['userid'];

        //查出微信绑定码
         $weixin = M('xctuserwechat')->where("userid =  $teacher_id and appid = '$APPID'")->field('weixin')->find();

         $touser = $weixin['weixin'];

        $content = strtr($str,array("{老师姓名}" => $teacher_name,"{时间}" => date('Y-m-d H:i:s',$time),"{卡号}"=>$cardNo));
         if($touser)
         {

           $this->teacher_message($touser,$content,$att_type,$userid,$teacher_name,$schoolid,$school_name,$APPID,$APPSECRET,$time);
         }


    }





//  public function teacher_schedule($cardNo,$userid,$orderid,$schoolid,$time,$pic,$cardtype,$APPID,$APPSECRET)
//  {
//
//          $re = A('UploadBaseImage');
//
//          $da_time = date('H:i',$time);
//
//
//
//
//
//
//            //判断老师的最新刷卡时间
//
//
//            $lasttime = M("teacher_attendances")->where("userid = $userid")->order("arrivetime desc")->field('arrivetime')->limit(0, 1)->find();
//            // var_dump($lasttime);
//
//          if($lasttime){
//            //获取到了之后就计算跟当前的时间差
//            $gettime = $time;
//
//            $timeLast = $lasttime['arrivetime'];
//
//
//            //计算传过来的时间戳
//
//            if ($gettime - $timeLast <= 120) {
//                //入库
//                echo "刷卡时间间隔太频繁";
//                die();
//            }
//        }
//
//         if(empty($orderid))
//        {
//            $orderid = 0;
//        }else{
//            $orderid = $orderid;
//        }
//         //如果图片不为空
//
//
//
//          //根据传过来的班次 学校id 时间去查询
//         $schedule_add  = M('teacher_schedule_add')->where("orderid = $orderid and schoolid = $schoolid and '$da_time' between ss_time_begintime and ss_time_endtime")->find();
//         // var_dump($schedule_add);
////           $data['leavepicture'] = $aa;
//             $data['userid'] = $userid;
//             $data['schoolid'] = $schoolid;
//             $data['arrivetime'] = $time;
//             $data['cardno'] = $cardNo;
//             $data['cardtype'] = $cardtype;
//             $data['arrivedate'] = date('Y-m-d',$time);
//             $data['leavepicture'] = $pic;
//             //默认状态正常
//             $data['status'] = 1;
//             $data['attendancetype'] = $schedule_add['type'];
//
//    if(!empty($schedule_add)){
//        //如果时间 大于 老师的上班时间为迟到  以此类推
//         if($schedule_add['type']==1 && $da_time > $schedule_add['ss_time'])
//         {
//                  $data['status'] = 2;
//               $data['attendancetype'] = 1;
//         }
//       //如果时间 小于 老师的下班时间为早退  以此类推
//        if($schedule_add['type']==2 && $da_time < $schedule_add['ss_time'])
//         {
//                  $data['status'] = 3;
//                $data['attendancetype'] = 2;
//         }
//
//          if($schedule_add['type']==3 && $da_time > $schedule_add['ss_time'])
//         {
//                  $data['status'] = 2;
//                $data['attendancetype'] = 3;
//         }
//
//           if($schedule_add['type']==4 && $da_time < $schedule_add['ss_time'])
//         {
//                  $data['status'] = 3;
//                $data['attendancetype'] = 4;
//         }
//
//           if($schedule_add['type']==5 && $da_time > $schedule_add['ss_time'])
//         {
//                  $data['status'] = 2;
//                $data['attendancetype'] = 5;
//         }
//           if($schedule_add['type']==6 && $da_time < $schedule_add['ss_time'])
//         {
//                  $data['status'] = 3;
//                $data['attendancetype'] = 6;
//         }
//     }else{
//
//               $data['status'] = 0;
//               $data['attendancetype'] = 0;
//               $att_type = "非正常时段打卡";
//               $str = "{老师姓名}老师你好已于{时间}刷卡，卡号为:{卡号}请确认。";
//     }
//
//
//
//        $attendances = M('teacher_attendances')->add($data);
//
//
//           switch ($schedule_add['type']) {
//              case '1':
//                 $att_type = '早上到校';
//                  $message_type = 1;
//                 $str = "{老师姓名}老师已于{时间}到校，卡号为:{卡号}请确认。";
//
//                  break;
//             case '2':
//                 $att_type = '早上离校';
//                  $message_type = 2;
//                 $str = "{老师姓名}老师已于{时间}离校，卡号为:{卡号}请确认。";
//                  break;
//            case '3':
//                $att_type = '下午到校';
//                 $message_type = 3;
//                 $str = "{老师姓名}老师已于{时间}到校，卡号为:{卡号}请确认。";
//
//                  break;
//            case '4':
//                $att_type = '下午离校';
//                 $message_type = 4;
//                 $str = "{老师姓名}老师已于{时间}离校，卡号为:{卡号}请确认。";
//
//                  break;
//            case '5':
//                $att_type = '晚上到校';
//                 $message_type = 5;
//                 $str = "{老师姓名}老师已于{时间}到校，卡号为:{卡号}请确认。";
//
//                  break;
//            case '6':
//                $att_type = '晚上离校';
//                 $message_type = 6;
//                 $str = "{老师姓名}老师已于{时间}离校，卡号为:{卡号}请确认。";
//                  break;
//         }
//        //查询学校
//        $school_info = M("school")->where("schoolid = '$schoolid'")->find();
//
//        $school_name = $school_info['school_name'];
//
//        $send_time = date('Y-m-d',$time);
//        $now_time  = date("Y-m-d");
//
//         //查询老师
//         $teacher_info=M("teacher_info")
//        ->alias("d")
//        ->join("wxt_wxtuser w ON d.teacherid=w.id")
//        ->where("d.teacherid=$userid")
//        ->field("w.id,w.name,w.weixin")
//        ->find();
//
//
//        //老师名字
//        $teacher_name = $teacher_info['name'];
//
//        $teacher_id = $teacher_info['id'];
//
//        //查出微信绑定码
//         $weixin = M('xctuserwechat')->where("userid =  $teacher_id and appid = '$APPID'")->field('weixin')->find();
//
//         $touser = $weixin['weixin'];
//
//         //微信绑定
//
//         $content = strtr($str,array("{老师姓名}" => $teacher_name,"{时间}" => date('Y-m-d H:i:s',$time),"{卡号}"=>$cardNo));
//        //如果班次id不存在则将考勤时段设为7即为未设置考勤
//        // if(!$orderid)
//        // {
//        //   $message_type = 7;
//        // }
//
//        //  $att_message['parentid'] = $parentid;
//        //  $att_message['studentid'] = $userid;
//        //  $att_message['schoolid'] = $schoolid;
//        //  $att_message['attendancetype'] = $message_type;
//        //  $att_message['content'] = $content;
//        //  $att_message['cardNo'] = $cardNo;
//        //  $att_message['status'] = 3;
//        //  $att_message['type'] =2;
//        //  $att_message['time'] = $time;
//        //  $message_add =  M("attendances_message")->add($att_message);
//
//
//        if($now_time!=$send_time)
//        {
//            //  M("attendances_message")->where("id = $message_add")->save(array("status"=>4));
//               exit();
//         }
//
//         if($touser)
//         {
//
//           $this->teacher_message($touser,$content,$att_type,$teacher_id,$teacher_name,$schoolid,$school_name,$APPID,$APPSECRET,$time);
//         }
//
//      }






    /**
     * cardNo为卡号  time传递过来的时间   userid 为持卡人id  classid 为班级  pic为图片 cardtype为卡类型
     */

    public function attendances($cardNo,$time,$userid,$classid,$pic,$cardtype,$APPID,$APPSECRET)
    {

        $re = A('UploadBaseImage');

        $da_time = date('H:i',$time);


        //获取当前是星期几

        $week_time=date('w',time());

        //因为时间戳 星期日为0 所以这里如果为0直接设置为7
        if($week_time==0)
        {
            $week_time = 7;
        }


        //根据传过来userid去查学生信息表
        $student_info = M('student_info')->where("userid=$userid")->field('schoollid,in_residence,stu_name')->find();
        //学校ID
        $schoolid = $student_info['schoollid'];

        //学生姓名
        $stu_name = $student_info['stu_name'];

        //查询学校名字用于短信发送
        $school_info = M("school")->where("schoolid = '$schoolid'")->field('school_name')->find();


        $school_name = $school_info['school_name'];
        //是否為住宿
        $stay = $student_info['in_residence'];
        if($stay==0)
        {
            //不住宿
            $stay = 2;
        }else{
            //住宿
            $stay = 1;
        }

        //查出班级
        $school_class = M('school_class')->where("id=$classid")->field('grade')->find();

        //根据班级所在的年级
        $grade = $school_class['grade'];

        $where['schoolid'] = $schoolid;
        $where['gradeid'] = $grade;
        //查出年级ID
        //$school_grade = M('school_grade')->where($where)->field('gradeid')->find();
        if(empty($school_class))
        {
            $gradeid = '';
        }else{
            $gradeid = $grade;
        }



        //判断学生的最新刷卡时间
        $lasttime = M("attendances")->where("userid = $userid")->order("arrivetime desc")->limit(0, 1)->field('arrivetime')->find();

        //var_dump($lasttime);

        if($lasttime){
            //获取到了之后就计算跟当前的时间差
            $timeLast = $lasttime['arrivetime'];
            //计算传过来的时间戳
            $gettime = $time;
           
            if ($gettime - $timeLast <= 120) {
                //入库
                echo "刷卡时间间隔太频繁";
                die();
            }
        }



        //如果
        $attend = M('attendancesetting')->where("gradeid = $gradeid and stay = $stay and schoolid = $schoolid and week = $week_time and '$da_time' between begintime and endtime")->find();
        



        $data['userid'] = $userid;
        $data['schoolid'] = $schoolid;
        $data['classid'] =  $classid;
        $data['arrivetime'] = $time;
        $data['cardno'] = $cardNo;
        $data['cardtype'] = $cardtype;
        $data['create_time '] = time();
        $data['arrivedate'] = date('Y-m-d',$time);
        $data['leavepicture'] = $pic;
        //默认状态正常
        $data['status'] = 1;
        $data['attendancetype'] = $attend['type'];
        //如果没有查到直接判定为考勤异常
        if(!empty($attend))
        {
            //时间大于上午考勤时间判断为迟到 下面以此类推
            if($attend['type'] == 1 && $da_time > $attend['latetime'])
            {

                $data['status'] = 2;
                $data['attendancetype'] = 1;

            }
            //时间如果小于考勤时间判断为早退 下面以此类推
            if($attend['type'] == 2 && $da_time < $attend['latetime'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 2;
            }

            if($attend['type'] == 3 && $da_time > $attend['latetime'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 3;
            }

            if($attend['type'] == 4 && $da_time < $attend['latetime'])
            {
             
                $data['status'] = 3;
                $data['attendancetype'] = 4;
            }
            if($attend['type'] == 5 && $da_time > $attend['latetime'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 5;
            }
            if($attend['type'] == 6 && $da_time < $attend['latetime'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 6;
            }

        }else{
            $data['status'] = 0;
            $data['attendancetype'] = 0;
            $str = "{学生姓名}的{家长}，您好，现在是{时间}，您的小孩{学生姓名}正在刷卡,卡号为:{卡号}请注意。“智校园”提醒您关怀孩子每一天";
            $att_type = "非考勤时段打卡";
            $message_type = 0;

        }


        $attendances = M('attendances')->add($data);
        if($cardtype==2)
        {
            $set['type'] = 3;
            $stay = 3;
        }else{
            $set['type'] = $stay;
        }

        $set['schoolid'] = $schoolid;
        //根据状态和学校去查出该学校的信息模板
        $resset = M("infotemplateset_wb")->where($set)->find();

        if(!$resset)
        {
            $resset = M("infotemplateset_wb")->where("type = $stay and schoolid = 0")->find();
        }



        //判断考勤类型来选择发送模板
        switch ($attend['type']) {
            case '1':
                $str = $resset['morn_school'];
                $message_type = 1;
                $att_type = "上午上学";
                break;
            case '2':
                $str = $resset['morn_leave'];
                $message_type = 2;
                $att_type = "上午放学";
                break;
            case '3':
                $str = $resset['after_school'];
                $message_type = 3;
                $att_type = "下午上学";
                break;
            case '4':
                $str = $resset['after_leave'];
                $message_type = 4;
                $att_type = "下午放学";
                break;
            case '5':
                $str = $resset['night_school'];
                $message_type = 5;
                $att_type = "晚上上学";
                break;
            case '6':
                $str = $resset['night_leave'];
                $message_type = 6;
                $att_type = "晚上放学";
                break;

        }

        //查出学生名字



        //查出学生有几个亲属 依次发送短信
        $student = M('relation_stu_user')->where("studentid=$userid")->field('userid,appellation')->select();

        $user = M("wxtuser")->where("id = $userid")->field("name")->find();

        $student_name = $user['name'];

        $thismonth = date('m');
        $thisyear = date('Y');
        $startDay = $thisyear . '-' . $thismonth . '-1';
        $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
        $b_time  = strtotime($startDay);//当前月的月初时间戳
        $e_time  = strtotime($endDay);//当前月的月末时间戳

        
        $send_time = date('Y-m-d',$time);
        $now_time  = date("Y-m-d");  
        foreach($student as &$value)
        {

            $parent_name = $value['appellation'];

            $parentid = $value['userid'];
            

            $parent_name = $value['appellation'];
            //根据家张ID查出家长绑定的微信
            $parent = M('xctuserwechat')->where("userid = $parentid and appid = '$APPID'")->field('weixin')->find();
            // $parent = M('xctuserwechat')->where(array("userid"=>$parentid,"appid"=>'$APPID'))->field('weixin')->find();
           
            $touser = $parent['weixin'];
           
            $content = strtr($str,array("{学生姓名}" => $student_name, "{家长}"=>$parent_name,"{时间}" => date('Y-m-d H:i:s',$time),"{卡号}"=>$cardNo));
           
           
             $att_message['parentid'] = $parentid;
             $att_message['studentid'] = $userid;
             $att_message['schoolid'] = $schoolid;
             $att_message['classid'] = $classid;
             $att_message['attendancetype'] = $message_type;
             $att_message['content'] = $content;
             $att_message['cardNo'] = $cardNo;
             $att_message['leavepicture'] = $pic;
             $att_message['status'] = 3;
             $att_message['type'] = 1;
             $att_message['time'] = $time;
          
             $message_add =  M("attendances_message")->add($att_message);

           
             //如果传过来的日期和当前日期不符则不发送
            if($now_time!=$send_time)
            { 
                 M("attendances_message")->where("id = $message_add")->save(array("status"=>4));
                continue;
            }   
            if($touser)
            {
              $this->message($touser,$content,$att_type,$student_name,$parentid,$userid,$schoolid,$b_time,$e_time,$classid,$message_type,$cardNo,$APPID,$APPSECRET,$message_add,$time);
            }

        }

 



    }



    //短信发送
    /**
     * touser 接收者  conetnt 接收信息  school_name为学校名字  stu_name为学生名字  parentid 家长id userid 学生id schoolid  学校id   b_time 月初  e_time 月末
     */
    public function message($touser,$content,$att_type,$student_name,$parentid,$userid,$schoolid,$b_time,$e_time,$classid,$message_type,$cardNo,$APPID,$APPSECRET,$message_add,$time)
    {
       
        
        $template = M("template")->where(array("type"=>5,"appid"=>$APPID))->find();
        $template_id = $template["template_id"];//模板ID

        //知道老师的touser之后就可以给他发送信息了
        //给老师发送模板消息
        $tpl = array(
            //接收者
            "touser" => $touser,
            // "template_id" =>"dWdvgt5Kmy4xYh95_A0nidvuRQbIm19YMG2rZaq3_1o",
            "template_id" =>$template_id,
            "url" => "http://mp.zhixiaoyuan.net/index.php/Weixin/SignIn?userid="."$parentid"."&openid=".$touser."&studentid="."$userid"."&schoolid="."$schoolid"."&b_time="."$b_time"."&e_time="."$e_time"."&appid=".$APPID."&appsecret=".$APPSECRET,
            "topcolor" => "#436EEE",
            "data" => array(
                "first" => array(
                    "value" => $content,
                    "color" => "#436EEE"
                ),
                "childName" => array(
                    "value" => $student_name,
                    "color" => "#436EEE"
                ),
                "time" => array(
                    "value" => date("Y-m-d H:i:s"),
                    "color" => "#436EEE"
                ),
                "status" => array(
                    "value" => $att_type,
                    "color" => "#436EEE"
                ),
                "remark" => array(
                    "value" => "查看明细内容请点击 “详情”",
                    "color" => "#436EEE"
                )
            )
        );
        // var_dump($tpl);
        $res = $this->sendTemplate($tpl);

       
  
     //如果消息发送成功  存入考勤信息表
        if ($res["errcode"] == 0) {
           
            M("attendances_message")->where("id = $message_add")->save(array("status"=>1,"errcode"=>$res["errcode"],"return_time"=>time()));

        }else{
            M("attendances_message")->where("id = $message_add")->save(array("status"=>2,"errcode"=>$res["errcode"],"return_time"=>time()));
        }


    }

   public function teacher_message($touser,$content,$att_type,$teacherid,$teacher_name,$schoolid,$school_name,$APPID,$APPSECRET,$time)
    {

        $thismonth = date('m');
        $thisyear = date('Y');
        $startDay = $thisyear . '-' . $thismonth . '-1';
        $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
        $b_time  = strtotime($startDay);//当前月的月初时间戳
        $e_time  = strtotime($endDay);//当前月的月末时间戳

        $template = M("template")->where(array("type"=>6,"appid"=>$APPID))->find();

        dump($template);

        $template_id = $template["template_id"];//模板ID

        $tpl = array(
            //接收者
            "touser" => $touser,
            // "template_id" =>"dWdvgt5Kmy4xYh95_A0nidvuRQbIm19YMG2rZaq3_1o",
            "template_id" =>$template_id,
            "url" => "http://mp.zhixiaoyuan.net/index.php/Weixin/TchSignIn/index?userid="."$teacherid"."&openid=".$touser.""."&schoolid="."$schoolid"."&b_time="."$b_time"."&e_time="."$e_time"."&appid=".$APPID."&appsecret=".$APPSECRET,
            "topcolor" => "#436EEE",
            "data" => array(
                "first" => array(
                    "value" => $content,
                    "color" => "#436EEE"
                ),
                "keyword1" => array(
                    "value" => date("Y-m-d H:i:s"),
                    "color" => "#436EEE"
                ),
                "keyword2" => array(
                    "value" => $school_name,
                    "color" => "#436EEE"
                ),
                "keyword3" => array(
                    "value" => $att_type,
                    "color" => "#436EEE"
                ),

                "remark" => array(
                    "value" => "查看明细内容请点击 “详情”",
                    "color" => "#436EEE"
                )
            )
        );
        // var_dump($tpl);
        $res = $this->sendTemplate($tpl);





    }

   /*
    *
    * 不打卡设置
    */
    private function NoClock($schoolid,$classid = "",$userid,$att_type,$cardNo,$cardtype,$pic,$APPID,$APPSECRET)
    {

        //获取当天的时间戳
        $day_time = time();
        //根据当天时间戳和学校去查询今天是否有设置
        $Clock = M('no_clock')->where("schoolid = $schoolid and type = 1 and att_type = $att_type and '$day_time' between begin and end")->find();

        if(!$Clock)
        {
            return false;
        }

        //获取人员列表
        $arr_user = $this->Clock_User($Clock['id'],$schoolid,$att_type);
         //判断该人员是否在这个人员列表集合中
        if(in_array($userid,$arr_user))
        {
            //查询是否有刷卡记录
            $Clock_Card = $this->Clock_Card($Clock['id'],$day_time);
            if($att_type==1)
            {
            //如果为老师
                //判断学生最新刷卡时间
                $lasttime = M("teacher_attendances")->where("userid = $userid")->order("arrivetime desc")->field('arrivetime')->limit(0, 1)->find();


                if($lasttime){
                    //获取到了之后就计算跟当前的时间差
                    $gettime = $day_time;

                    $timeLast = $lasttime['arrivetime'];

                    //计算传过来的时间戳

                    if ($gettime - $timeLast <= 120) {
                        //入库
                        echo "刷卡时间间隔太频繁";
                        die();
                    }
                }

                $data['userid'] = $userid;
                $data['schoolid'] = $schoolid;
                $data['arrivetime'] = $day_time;
                $data['cardno'] = $cardNo;
                $data['cardtype'] = 1;
                $data['arrivedate'] = date('Y-m-d',$day_time);
                $data['leavepicture'] = $pic;
                //默认状态正常
                $data['status'] = 1;
                $data['attendancetype'] = 8;
                $attendances = M('teacher_attendances')->add($data);


                $this->teacher_mange($userid,$schoolid,$cardNo,$Clock_Card,$day_time,$APPID,$APPSECRET);

            }else{
            //如果为学生

                //判断学生的最新刷卡时间
                $lasttime = M("attendances")->where("userid = $userid")->order("arrivetime desc")->limit(0, 1)->field('arrivetime')->find();


                if($lasttime){
                    //获取到了之后就计算跟当前的时间差
                    $timeLast = $lasttime['arrivetime'];
                    //计算传过来的时间戳
                    $gettime = $day_time;

                    if ($gettime - $timeLast <= 120) {
                        //入库
                        echo "刷卡时间间隔太频繁";
                        die();
                    }
                }

                //存入考勤表
                $data['userid'] = $userid;
                $data['schoolid'] = $schoolid;
                $data['classid'] =  $classid;
                $data['arrivetime'] = $day_time;
                $data['cardno'] = $cardNo;
                $data['cardtype'] = $cardtype;
                $data['create_time '] = time();
                $data['arrivedate'] = date('Y-m-d',$day_time);
                $data['leavepicture'] = $pic;
                //默认状态正常
                $data['status'] = 1;
                $data['attendancetype'] = 7;

                $attendances = M('attendances')->add($data);

                //查出学生有几个亲属 依次发送短信
                $student = M('relation_stu_user')->where("studentid=$userid")->field('userid,appellation')->select();



                $this->student_mange($student,$userid,$schoolid,$classid,7,$pic,$cardNo,$day_time,$Clock_Card,$APPID,$APPSECRET);

            }

        }else{
            return false;

        }

        //如果存在查询出不打卡详细表

        return true;


    }


    private  function student_mange($student,$userid,$schoolid,$classid,$message_type,$pic,$cardNo,$day_time,$ClockContent,$APPID,$APPSECRET)
    {
        $student_name = M("student_info")->where("schoollid = $schoolid and userid = $userid")->getField("stu_name");

        foreach($student as &$value)
        {

            $parent_name = $value['appellation'];

            $parentid = $value['userid'];


            $parent_name = $value['appellation'];
            //根据家张ID查出家长绑定的微信
            $parent = M('xctuserwechat')->where("userid = $parentid and appid = '$APPID'")->field('weixin')->find();
            // $parent = M('xctuserwechat')->where(array("userid"=>$parentid,"appid"=>'$APPID'))->field('weixin')->find();

            $touser = $parent['weixin'];

//            $content = strtr($str,array("{学生姓名}" => $student_name, "{家长}"=>$parent_name,"{时间}" => date('Y-m-d H:i:s',$day_time),"{卡号}"=>$cardNo));
            $content = $student_name.$parent_name.",您好,"."现在是".date('Y-m-d H:i:s',$day_time).",".$ClockContent;

            $att_message['parentid'] = $parentid;
            $att_message['studentid'] = $userid;
            $att_message['schoolid'] = $schoolid;
            $att_message['classid'] = $classid;
            $att_message['attendancetype'] = $message_type;
            $att_message['content'] = $content;
            $att_message['cardNo'] = $cardNo;
            $att_message['leavepicture'] = $pic;
            $att_message['status'] = 3;
            $att_message['type'] = 1;
            $att_message['time'] = $day_time;

            $message_add =  M("attendances_message")->add($att_message);

            $thismonth = date('m');
            $thisyear = date('Y');
            $startDay = $thisyear . '-' . $thismonth . '-1';
            $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
            $b_time  = strtotime($startDay);//当前月的月初时间戳
            $e_time  = strtotime($endDay);//当前月的月末时间戳


            $send_time = date('Y-m-d',$day_time);
            $now_time  = date("Y-m-d");


            //如果传过来的日期和当前日期不符则不发送
            if($now_time!=$send_time)
            {
                M("attendances_message")->where("id = $message_add")->save(array("status"=>4));
                continue;
            }
            if($touser)
            {
                $this->message($touser,$content,'特殊活动日',$student_name,$parentid,$userid,$schoolid,$b_time,$e_time,$classid,$message_type,$cardNo,$APPID,$APPSECRET,$message_add,$day_time);
            }

        }
    }

    private function teacher_mange($userid,$schoolid,$cardNo,$ClockContent,$day_time,$APPID,$APPSECRET)
    {


        $teacher_info=M("teacher_info")
            ->alias("d")
            ->join("wxt_wxtuser w ON d.teacherid=w.id")
            ->where("d.teacherid=$userid")
            ->field("w.id,w.name,w.weixin")
            ->find();

        //查询学校
        $school_info = M("school")->where("schoolid = '$schoolid'")->find();

        $school_name = $school_info['school_name'];

        $send_time = date('Y-m-d',$day_time);
        $now_time  = date("Y-m-d");

        //老师名字
        $teacher_name = $teacher_info['name'];

        $teacher_id = $teacher_info['id'];

        //查出微信绑定码
        $weixin = M('xctuserwechat')->where("userid =  $teacher_id and appid = '$APPID'")->field('weixin')->find();


        $touser = $weixin['weixin'];


        $content = $teacher_name."老师".",您好,"."现在是".date('Y-m-d H:i:s',$day_time).",".$ClockContent;

        if($touser)
        {

            $this->teacher_message($touser,$content,"特殊活动日",$teacher_id,$teacher_name,$schoolid,$school_name,$APPID,$APPSECRET,$time);
        }
    }

    //获取人员
    private function Clock_User($Clockid,$schoolid,$att_type)
    {

        $clock_detail = M("no_clock_detail")->field("g_id")->where(array("activity_id"=>$Clockid))->select();

        $g_id = "";

        foreach ($clock_detail as $v)
        {
            $g_id = $v['g_id'].",".$g_id;
        }

        $g_id  = trim($g_id, ",");

        //如果为老师
        if($att_type==1)
        {
            $user = M("teacher_schedule_person")->field("personid as userid")->where("groupid in ($g_id)")->select();
        }else{
            $user = M("class_relationship")->field("userid")->where("classid in ($g_id)")->select();
        }


        foreach($user as $k=>$v){
            foreach($v as $key=>$val){
                $arr2[$k]=$val;
            }
        }

        return $arr2;

    }

    private function Clock_Card($Clockid,$day_time)
    {

        $CardRecord = M("no_clock_card")->where("clockid = $Clockid and'$day_time' between card_begin_total and card_end_total")->find();


        if($CardRecord)
        {
                $CardRecord['content'] = $CardRecord['content']?:"今天是不需要打卡日";

                return $CardRecord['content'];

        }else{
            return false;
        }

    }




        //成绩通知
    /**
     * $studentid 学生ID  $examid 考试ID  $classid 班级ID  $content发送的内容
     *   $appid  $appsecret  $schoolid 学校ID  $teachername老师名字  $classname 班级名称
     */
    public function scoreNotice()
    {
        $studentid= I("studentid");
        $examid= I("examid");
        $classid= I("classid");
        $content= I("content");
        $appid= I("APPID");
        $appsecret= I("APPSECRET");
        $schoolid= I("schoolid");
        $teachername= I("teachername");
        $classname= I("classname");

        //班级名称
        $remark = "点击查看详情";
        $template = M("template")->where(array("type"=>1,"appid"=>$this->appid))->find();
        $template_id = $template["template_id"];//模板ID
            //查到所有的亲属关系
        $stu_info = M("relation_stu_user")->where(array('studentid' => $studentid))->field("userid,studentid,appellation")->select();
        $stuinfo = M("wxtuser")->where(array('id' => $studentid))->field("name")->find();
        $stu_name = $stuinfo['name'];//学生名字

            if (!empty($stu_info)){
                for ($j = 0; $j < count($stu_info); $j++) {//给所有的关联亲属发送模板消息
                    $fid = $stu_info[$j]['userid'];//用户ID
                    $relationship_name = $stu_info[$j]['appellation'];//关系名称
                    $studentid = $stu_info[$j]['studentid'];//学生ID
                    $wes_res = M("xctuserwechat")->where(array("userid"=>$fid,"appid"=>$appid))->find();
                    $touser = $wes_res['weixin']; //接收者微信
                    if($touser){
                        $tpl = array(
                            //接收者
                            "touser" => $touser,
                            "template_id" => $template_id,
//
                            "url" => "http://mp.zhixiaoyuan.net/index.php/Weixin/Exam/details?userid=".$fid."&openid=".$touser."&classid=".$classid."&examid=".$examid."&studentid=".$studentid."&schoolid=".$schoolid."&appid=".$appid."&appsecret=".$appsecret,
                            "topcolor" => "#436EEE",
                            "data" => array(
                                "first" => array(
                                    "value" => "亲爱的" . $stu_name . $relationship_name.",您有一条【考试成绩】信息,请尽快查看",
                                    "color" => "#436EEE"
                                ),
                                "keyword1" => array(
                                    "value" => $classname,
                                    "color" => "#436EEE"
                                ),
                                "keyword2" => array(
                                    "value" => $teachername,
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
                                    "value" => $remark,
                                    "color" => "#436EEE"
                                )
                            )
                        );
                       echo  $res = $this->sendTemplate($tpl);
                    }



                }
            }


    }


    //学生微信推送
    public function face_student_attendances()
    {
        $time = I("time");
        $APPID = I("APPID");
        $APPSECRET = I("APPSECRET");
        $pic = I("pic");
        $user_type = I("user_type");
        $classid = I("classid");
        $userid = I("userid");

        $da_time = date('H:i',$time);


        //获取当前是星期几

        $week_time=date('w',time());

        //因为时间戳 星期日为0 所以这里如果为0直接设置为7
        if($week_time==0)
        {
            $week_time = 7;
        }


        //根据传过来userid去查学生信息表
        $student_info = M('student_info')->where("userid=$userid")->field('schoollid,in_residence,stu_name')->find();
        //学校ID
        $schoolid = $student_info['schoollid'];

        //学生姓名
        $stu_name = $student_info['stu_name'];

        //查询学校名字用于短信发送
        $school_info = M("school")->where("schoolid = '$schoolid'")->field('school_name')->find();


        $school_name = $school_info['school_name'];
        //是否為住宿
        $stay = $student_info['in_residence'];
        if($stay==0)
        {
            //不住宿
            $stay = 2;
        }else{
            //住宿
            $stay = 1;
        }

        //查出班级
        $school_class = M('school_class')->where("id=$classid")->field('grade')->find();

        //根据班级所在的年级
        $grade = $school_class['grade'];

        $where['schoolid'] = $schoolid;
        $where['gradeid'] = $grade;
        //查出年级ID
        //$school_grade = M('school_grade')->where($where)->field('gradeid')->find();
        if(empty($school_class))
        {
            $gradeid = '';
        }else{
            $gradeid = $grade;
        }



        //判断学生的最新刷卡时间
        $lasttime = M("attendances")->where("userid = $userid")->order("arrivetime desc")->limit(0, 1)->field('arrivetime')->find();

        //var_dump($lasttime);

        if($lasttime){
            //获取到了之后就计算跟当前的时间差
            $timeLast = $lasttime['arrivetime'];
            //计算传过来的时间戳
            $gettime = $time;

            if ($gettime - $timeLast <= 120) {
                //入库
                echo "刷卡时间间隔太频繁";
                die();
            }
        }



        //如果
        $attend = M('attendancesetting')->where("gradeid = $gradeid and stay = $stay and schoolid = $schoolid and week = $week_time and '$da_time' between begintime and endtime")->find();




        $data['userid'] = $userid;
        $data['schoolid'] = $schoolid;
        $data['classid'] =  $classid;
        $data['arrivetime'] = $time;
//        $data['cardno'] = $cardNo;
        $data['cardno'] = 0;
//        $data['cardtype'] = $cardtype;
        $data['cardtype'] = 0;
        $data['create_time '] = time();
        $data['arrivedate'] = date('Y-m-d',$time);
        $data['leavepicture'] = $pic;
        //默认状态正常
        $data['status'] = 1;
        $data['attendancetype'] = $attend['type'];
        //如果没有查到直接判定为考勤异常
        if(!empty($attend))
        {
            //时间大于上午考勤时间判断为迟到 下面以此类推
            if($attend['type'] == 1 && $da_time > $attend['latetime'])
            {

                $data['status'] = 2;
                $data['attendancetype'] = 1;

            }
            //时间如果小于考勤时间判断为早退 下面以此类推
            if($attend['type'] == 2 && $da_time < $attend['latetime'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 2;
            }

            if($attend['type'] == 3 && $da_time > $attend['latetime'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 3;
            }

            if($attend['type'] == 4 && $da_time < $attend['latetime'])
            {

                $data['status'] = 3;
                $data['attendancetype'] = 4;
            }
            if($attend['type'] == 5 && $da_time > $attend['latetime'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 5;
            }
            if($attend['type'] == 6 && $da_time < $attend['latetime'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 6;
            }

        }else{
            $data['status'] = 0;
            $data['attendancetype'] = 0;
            $str = "{学生姓名}的{家长}，您好，现在是{时间}，您的小孩{学生姓名}正在刷卡,请注意。“智校园”提醒您关怀孩子每一天";
            $att_type = "非考勤时段打卡";
            $message_type = 0;

        }


        $attendances = M('attendances')->add($data);
//        if($cardtype==2)
//        {
//            $set['type'] = 3;
//            $stay = 3;
//        }else{

        $set['type'] = $stay;
//        }

        $set['schoolid'] = $schoolid;
        //根据状态和学校去查出该学校的信息模板
        $resset = M("infotemplateset_wb")->where($set)->find();

        if(!$resset)
        {
            $resset = M("infotemplateset_wb")->where("type = $stay and schoolid = 0")->find();
        }



        //判断考勤类型来选择发送模板
        switch ($attend['type']) {
            case '1':
                $str = $resset['morn_school'];
                $message_type = 1;
                $att_type = "上午上学";
                break;
            case '2':
                $str = $resset['morn_leave'];
                $message_type = 2;
                $att_type = "上午放学";
                break;
            case '3':
                $str = $resset['after_school'];
                $message_type = 3;
                $att_type = "下午上学";
                break;
            case '4':
                $str = $resset['after_leave'];
                $message_type = 4;
                $att_type = "下午放学";
                break;
            case '5':
                $str = $resset['night_school'];
                $message_type = 5;
                $att_type = "晚上上学";
                break;
            case '6':
                $str = $resset['night_leave'];
                $message_type = 6;
                $att_type = "晚上放学";
                break;

        }

        //查出学生名字



        //查出学生有几个亲属 依次发送短信
        $student = M('relation_stu_user')->where("studentid=$userid")->field('userid,appellation')->select();

        $user = M("wxtuser")->where("id = $userid")->field("name")->find();

        $student_name = $user['name'];

        $thismonth = date('m');
        $thisyear = date('Y');
        $startDay = $thisyear . '-' . $thismonth . '-1';
        $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
        $b_time  = strtotime($startDay);//当前月的月初时间戳
        $e_time  = strtotime($endDay);//当前月的月末时间戳


        $send_time = date('Y-m-d',$time);
        $now_time  = date("Y-m-d");
        foreach($student as &$value)
        {

            $parent_name = $value['appellation'];

            $parentid = $value['userid'];


            $parent_name = $value['appellation'];
            //根据家张ID查出家长绑定的微信
            $parent = M('xctuserwechat')->where("userid = $parentid and appid = '$APPID'")->field('weixin')->find();
            // $parent = M('xctuserwechat')->where(array("userid"=>$parentid,"appid"=>'$APPID'))->field('weixin')->find();

            $touser = $parent['weixin'];

//            $content = strtr($str,array("{学生姓名}" => $student_name, "{家长}"=>$parent_name,"{时间}" => date('Y-m-d H:i:s',$time),"{卡号}"=>$cardNo));
            $content = strtr($str,array("{学生姓名}" => $student_name, "{家长}"=>$parent_name,"{时间}" => date('Y-m-d H:i:s',$time)));


            $att_message['parentid'] = $parentid;
            $att_message['studentid'] = $userid;
            $att_message['schoolid'] = $schoolid;
            $att_message['classid'] = $classid;
            $att_message['attendancetype'] = $message_type;
            $att_message['content'] = $content;
            $att_message['cardNo'] = 0;
            $att_message['leavepicture'] = $pic;
            $att_message['status'] = 3;
            $att_message['type'] = 1;
            $att_message['time'] = $time;

            $message_add =  M("attendances_message")->add($att_message);
            //如果传过来的日期和当前日期不符则不发送
            if($now_time!=$send_time)
            {
                M("attendances_message")->where("id = $message_add")->save(array("status"=>4));
                continue;
            }
            if($touser)
            {
                $this->face_message($touser,$content,$att_type,$student_name,$parentid,$userid,$schoolid,$b_time,$e_time,$classid,$message_type,0,$APPID,$APPSECRET,$message_add,$time);
            }

        }
    }

    //老师微信推送
    public function face_teacher_attendances()
    {
        $userid = I("userid");
        $orderid = I("orderid");
        $schoolid = I("schoolid");
        $time = I("time");
        $pic = I("pic");
        $APPID = I("APPID");
        $APPSECRET = I("APPSECRET");
        $da_time = date('H:i',$time);

        //判断老师的最新刷卡时间


        $lasttime = M("teacher_attendances")->where("userid = $userid")->order("arrivetime desc")->field('arrivetime')->limit(0, 1)->find();
        // var_dump($lasttime);

        if($lasttime){
            //获取到了之后就计算跟当前的时间差
            $gettime = $time;

            $timeLast = $lasttime['arrivetime'];


            //计算传过来的时间戳

            if ($gettime - $timeLast <= 120) {
                //入库
                echo "刷卡时间间隔太频繁";
                die();
            }
        }

        if(empty($orderid))
        {
            $orderid = 0;
        }else{
            $orderid = $orderid;
        }
        //如果图片不为空



        //根据传过来的班次 学校id 时间去查询
        $schedule_add  = M('teacher_schedule_add')->where("orderid = $orderid and schoolid = $schoolid and '$da_time' between ss_time_begintime and ss_time_endtime")->find();
        $a =  M("teacher_schedule_add")->getLastSql();

//        $resource = fopen("./log.txt","w+");
////                                $a =print_r($schedule_add,true);
//                                fwrite($resource,  $a.date('Y-m-d H:i:s', time())."\r\n");

        $data['userid'] = $userid;
        $data['schoolid'] = $schoolid;
        $data['arrivetime'] = $time;
        $data['cardno'] = 0;
        $data['cardtype'] = 1;
        $data['arrivedate'] = date('Y-m-d',$time);
        $data['leavepicture'] = $pic;
        //默认状态正常
        $data['status'] = 1;
        $data['attendancetype'] = $schedule_add['type'];

        if(!empty($schedule_add)){
            //如果时间 大于 老师的上班时间为迟到  以此类推
            if($schedule_add['type']==1 && $da_time > $schedule_add['ss_time'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 1;
            }
            //如果时间 小于 老师的下班时间为早退  以此类推
            if($schedule_add['type']==2 && $da_time < $schedule_add['ss_time'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 2;
            }

            if($schedule_add['type']==3 && $da_time > $schedule_add['ss_time'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 3;
            }

            if($schedule_add['type']==4 && $da_time < $schedule_add['ss_time'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 4;
            }

            if($schedule_add['type']==5 && $da_time > $schedule_add['ss_time'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 5;
            }
            if($schedule_add['type']==6 && $da_time < $schedule_add['ss_time'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 6;
            }
        }else{

            $data['status'] = 0;
            $data['attendancetype'] = 0;
            $att_type = "非正常时段打卡";
            $str = "{老师姓名}老师你好已于{时间}刷卡。";
        }



        $attendances = M('teacher_attendances')->add($data);


        switch ($schedule_add['type']) {
            case '1':
                $att_type = '早上到校';
                $message_type = 1;
                $str = "{老师姓名}老师已于{时间}到校。";

                break;
            case '2':
                $att_type = '早上离校';
                $message_type = 2;
                $str = "{老师姓名}老师已于{时间}离校。";
                break;
            case '3':
                $att_type = '下午到校';
                $message_type = 3;
                $str = "{老师姓名}老师已于{时间}到校。";

                break;
            case '4':
                $att_type = '下午离校';
                $message_type = 4;
                $str = "{老师姓名}老师已于{时间}离校。";

                break;
            case '5':
                $att_type = '晚上到校';
                $message_type = 5;
                $str = "{老师姓名}老师已于{时间}到校";

                break;
            case '6':
                $att_type = '晚上离校';
                $message_type = 6;
                $str = "{老师姓名}老师已于{时间}离校。";
                break;
        }
        //查询学校
        $school_info = M("school")->where("schoolid = '$schoolid'")->find();

        $school_name = $school_info['school_name'];

        $send_time = date('Y-m-d',$time);
        $now_time  = date("Y-m-d");

        $teacher_info=M("teacher_info")
            ->alias("d")
            ->where("d.teacherid=$userid and d.schoolid=$schoolid")
            ->find();
        //老师名字
        $teacher_name = $teacher_info['name'];

        $teacher_id = $teacher_info['teacherid'];

        //查出微信绑定码
        $weixin = M('xctuserwechat')->where("userid =  $teacher_id and appid = '$APPID'")->field('weixin')->find();

        $touser = $weixin['weixin'];

        //微信绑定

        $content = strtr($str,array("{老师姓名}" => $teacher_name,"{时间}" => date('Y-m-d H:i:s',$time)));
        //如果班次id不存在则将考勤时段设为7即为未设置考勤


        if($now_time!=$send_time)
        {
            exit();
        }

        if($touser)
        {

            $this->face_teacher_message($touser,$content,$att_type,$teacher_id,$teacher_name,$schoolid,$school_name,$APPID,$APPSECRET,$time);
        }

    }

    //家长微信推送
    public function face_parent_attendances()
    {
        $time = I("time");
        $APPID = I("APPID");
        $APPSECRET = I("APPSECRET");
        $pic = I("pic");
        $classid = I("classid");
        $userid = I("userid");

        $da_time = date('H:i',$time);


        //获取当前是星期几

        $week_time=date('w',time());

        //因为时间戳 星期日为0 所以这里如果为0直接设置为7
        if($week_time==0)
        {
            $week_time = 7;
        }


        //根据传过来userid去查学生信息表
        $student_info = M('student_info')->where("userid=$userid")->field('schoollid,in_residence,stu_name')->find();
        //学校ID
        $schoolid = $student_info['schoollid'];

        //学生姓名
        $stu_name = $student_info['stu_name'];

        //查询学校名字用于短信发送
        $school_info = M("school")->where("schoolid = '$schoolid'")->field('school_name')->find();


        $school_name = $school_info['school_name'];
        //是否為住宿
        $stay = $student_info['in_residence'];
        if($stay==0)
        {
            //不住宿
            $stay = 2;
        }else{
            //住宿
            $stay = 1;
        }

        //查出班级
        $school_class = M('school_class')->where("id=$classid")->field('grade')->find();

        //根据班级所在的年级
        $grade = $school_class['grade'];

        $where['schoolid'] = $schoolid;
        $where['gradeid'] = $grade;
        //查出年级ID
        //$school_grade = M('school_grade')->where($where)->field('gradeid')->find();
        if(empty($school_class))
        {
            $gradeid = '';
        }else{
            $gradeid = $grade;
        }



        //判断学生的最新刷卡时间
        $lasttime = M("attendances")->where("userid = $userid")->order("arrivetime desc")->limit(0, 1)->field('arrivetime')->find();

        //var_dump($lasttime);

        if($lasttime){
            //获取到了之后就计算跟当前的时间差
            $timeLast = $lasttime['arrivetime'];
            //计算传过来的时间戳
            $gettime = $time;

            if ($gettime - $timeLast <= 120) {
                //入库
                echo "刷卡时间间隔太频繁";
                die();
            }
        }



        //如果
        $attend = M('attendancesetting')->where("gradeid = $gradeid and stay = $stay and schoolid = $schoolid and week = $week_time and '$da_time' between begintime and endtime")->find();




        $data['userid'] = $userid;
        $data['schoolid'] = $schoolid;
        $data['classid'] =  $classid;
        $data['arrivetime'] = $time;
        $data['cardno'] = 0;
        $data['cardtype'] = 0;
        $data['create_time '] = time();
        $data['arrivedate'] = date('Y-m-d',$time);
        $data['leavepicture'] = $pic;
        //默认状态正常
        $data['status'] = 1;
        $data['attendancetype'] = $attend['type'];
        //如果没有查到直接判定为考勤异常
        if(!empty($attend))
        {
            //时间大于上午考勤时间判断为迟到 下面以此类推
            if($attend['type'] == 1 && $da_time > $attend['latetime'])
            {

                $data['status'] = 2;
                $data['attendancetype'] = 1;

            }
            //时间如果小于考勤时间判断为早退 下面以此类推
            if($attend['type'] == 2 && $da_time < $attend['latetime'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 2;
            }

            if($attend['type'] == 3 && $da_time > $attend['latetime'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 3;
            }

            if($attend['type'] == 4 && $da_time < $attend['latetime'])
            {

                $data['status'] = 3;
                $data['attendancetype'] = 4;
            }
            if($attend['type'] == 5 && $da_time > $attend['latetime'])
            {
                $data['status'] = 2;
                $data['attendancetype'] = 5;
            }
            if($attend['type'] == 6 && $da_time < $attend['latetime'])
            {
                $data['status'] = 3;
                $data['attendancetype'] = 6;
            }

        }else{
            $data['status'] = 0;
            $data['attendancetype'] = 0;
            $str = "{学生姓名}的{家长}，您好，现在是{时间}，您的小孩{学生姓名}正在刷卡,请注意。“智校园”提醒您关怀孩子每一天";
            $att_type = "非考勤时段打卡";
            $message_type = 0;

        }


        $attendances = M('attendances')->add($data);


        $set['type'] = 3; //表示家长


        $set['schoolid'] = $schoolid;
        //根据状态和学校去查出该学校的信息模板
        $resset = M("infotemplateset_wb")->where($set)->find();

        if(!$resset)
        {
            $resset = M("infotemplateset_wb")->where("type = $stay and schoolid = 0")->find();
        }



        //判断考勤类型来选择发送模板
        switch ($attend['type']) {
            case '1':
                $str = $resset['morn_school'];
                $message_type = 1;
                $att_type = "上午上学";
                break;
            case '2':
                $str = $resset['morn_leave'];
                $message_type = 2;
                $att_type = "上午放学";
                break;
            case '3':
                $str = $resset['after_school'];
                $message_type = 3;
                $att_type = "下午上学";
                break;
            case '4':
                $str = $resset['after_leave'];
                $message_type = 4;
                $att_type = "下午放学";
                break;
            case '5':
                $str = $resset['night_school'];
                $message_type = 5;
                $att_type = "晚上上学";
                break;
            case '6':
                $str = $resset['night_leave'];
                $message_type = 6;
                $att_type = "晚上放学";
                break;

        }

        //查出学生名字



        //查出学生有几个亲属 依次发送短信
        $student = M('relation_stu_user')->where("studentid=$userid")->field('userid,appellation')->select();

        $user = M("wxtuser")->where("id = $userid")->field("name")->find();

        $student_name = $user['name'];

        $thismonth = date('m');
        $thisyear = date('Y');
        $startDay = $thisyear . '-' . $thismonth . '-1';
        $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
        $b_time  = strtotime($startDay);//当前月的月初时间戳
        $e_time  = strtotime($endDay);//当前月的月末时间戳


        $send_time = date('Y-m-d',$time);
        $now_time  = date("Y-m-d");
        foreach($student as &$value)
        {

            $parent_name = $value['appellation'];

            $parentid = $value['userid'];


            $parent_name = $value['appellation'];
            //根据家张ID查出家长绑定的微信
            $parent = M('xctuserwechat')->where("userid = $parentid and appid = '$APPID'")->field('weixin')->find();
            // $parent = M('xctuserwechat')->where(array("userid"=>$parentid,"appid"=>'$APPID'))->field('weixin')->find();

            $touser = $parent['weixin'];

            $content = strtr($str,array("{学生姓名}" => $student_name, "{家长}"=>$parent_name,"{时间}" => date('Y-m-d H:i:s',$time)));


            $att_message['parentid'] = $parentid;
            $att_message['studentid'] = $userid;
            $att_message['schoolid'] = $schoolid;
            $att_message['classid'] = $classid;
            $att_message['attendancetype'] = $message_type;
            $att_message['content'] = $content;
            $att_message['cardNo'] = 0;
            $att_message['status'] = 3;
            $att_message['type'] = 1;
            $att_message['time'] = $time;

            $message_add =  M("attendances_message")->add($att_message);
            //如果传过来的日期和当前日期不符则不发送
            if($now_time!=$send_time)
            {
                M("attendances_message")->where("id = $message_add")->save(array("status"=>4));
                continue;
            }
            if($touser)
            {
                $this->face_message($touser,$content,$att_type,$student_name,$parentid,$userid,$schoolid,$b_time,$e_time,$classid,$message_type,0,$APPID,$APPSECRET,$message_add,$time);
            }

        }
    }

//短信发送
    /**
     * touser 接收者  conetnt 接收信息  school_name为学校名字  stu_name为学生名字  parentid 家长id userid 学生id schoolid  学校id   b_time 月初  e_time 月末
     */
    public function face_message($touser,$content,$att_type,$student_name,$parentid,$userid,$schoolid,$b_time,$e_time,$classid,$message_type,$cardNo,$APPID,$APPSECRET,$message_add,$time)
    {


        $template = M("template")->where(array("type"=>5,"appid"=>$APPID))->find();
        $template_id = $template["template_id"];//模板ID

        //知道老师的touser之后就可以给他发送信息了
        //给老师发送模板消息
        $tpl = array(
            //接收者
            "touser" => $touser,
            // "template_id" =>"dWdvgt5Kmy4xYh95_A0nidvuRQbIm19YMG2rZaq3_1o",
            "template_id" =>$template_id,
            "url" => "http://mp.zhixiaoyuan.net/index.php/Weixin/SignIn?userid="."$parentid"."&openid=".$touser."&studentid="."$userid"."&schoolid="."$schoolid"."&b_time="."$b_time"."&e_time="."$e_time"."&appid=".$APPID."&appsecret=".$APPSECRET,
            "topcolor" => "#436EEE",
            "data" => array(
                "first" => array(
                    "value" => $content,
                    "color" => "#436EEE"
                ),
                "childName" => array(
                    "value" => $student_name,
                    "color" => "#436EEE"
                ),
                "time" => array(
                    "value" => date("Y-m-d H:i:s"),
                    "color" => "#436EEE"
                ),
                "status" => array(
                    "value" => $att_type,
                    "color" => "#436EEE"
                ),
                "remark" => array(
                    "value" => "查看明细内容请点击 “详情”",
                    "color" => "#436EEE"
                )
            )
        );
        // var_dump($tpl);
        $res = $this->sendTemplate($tpl);



        //如果消息发送成功  存入考勤信息表
        if ($res["errcode"] == 0) {

            M("attendances_message")->where("id = $message_add")->save(array("status"=>1,"errcode"=>$res["errcode"],"return_time"=>time()));

        }else{
            M("attendances_message")->where("id = $message_add")->save(array("status"=>2,"errcode"=>$res["errcode"],"return_time"=>time()));
        }


    }
    public function face_teacher_message($touser,$content,$att_type,$teacherid,$teacher_name,$schoolid,$school_name,$APPID,$APPSECRET,$time)
    {

        $thismonth = date('m');
        $thisyear = date('Y');
        $startDay = $thisyear . '-' . $thismonth . '-1';
        $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
        $b_time  = strtotime($startDay);//当前月的月初时间戳
        $e_time  = strtotime($endDay);//当前月的月末时间戳


        $template = M("template")->where(array("type"=>6,"appid"=>$APPID))->find();

        $template_id = $template["template_id"];//模板ID

        $tpl = array(
            //接收者
            "touser" => $touser,
            // "template_id" =>"dWdvgt5Kmy4xYh95_A0nidvuRQbIm19YMG2rZaq3_1o",
            "template_id" =>$template_id,
            "url" => "http://mp.zhixiaoyuan.net/index.php/Weixin/TchSignIn/index?userid="."$teacherid"."&openid=".$touser.""."&schoolid="."$schoolid"."&b_time="."$b_time"."&e_time="."$e_time"."&appid=".$APPID."&appsecret=".$APPSECRET,
            "topcolor" => "#436EEE",
            "data" => array(
                "first" => array(
                    "value" => $content,
                    "color" => "#436EEE"
                ),
                "keyword1" => array(
                    "value" => date("Y-m-d H:i:s"),
                    "color" => "#436EEE"
                ),
                "keyword2" => array(
                    "value" => $school_name,
                    "color" => "#436EEE"
                ),
                "keyword3" => array(
                    "value" => $att_type,
                    "color" => "#436EEE"
                ),

                "remark" => array(
                    "value" => "查看明细内容请点击 “详情”",
                    "color" => "#436EEE"
                )
            )
        );
        // var_dump($tpl);
        $res = $this->sendTemplate($tpl);



    }
    function sendTemplate($tpl)
    {
        $json_template = json_encode($tpl);
//        $jssdk = new JSSDK("wx7325155f62456567", "c379e9768f9faa8865a1db767fc81155");
//        $access_token = $jssdk->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$this->access_token";
//        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
        $res = json_decode($this->http_request($url, $json_template), true);
       
        return $res;
//        if ($res["errcode"] == 0) {
//            $ret = $this->format_ret(1, "发送成功");
//        } else {
//           echo json_encode($res);
//
//        }
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

//    function getAccessToken() {
//        // access_token 应该全局存储与更新，以下代码以写入到文件中做示例
//        $data = json_decode($this->get_php_file("access_token.php"));
//        if ($data->expire_time < time()) {
//            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$this->appId&secret=$this->appSecret";
//            $res = json_decode($this->httpGet($url));
////            var_dump($res);
//            $access_token = $res->access_token;
//            if ($access_token) {
//                $data->expire_time = time() + 7000;
//                $data->access_token = $access_token;
//                $this->set_php_file("access_token.php", json_encode($data));
//            }
//        } else {
//            $access_token = $data->access_token;
//        }
//        return $access_token;
//    }
    function getAccessToken()
    {
        $appid = $this->appId;
        $appsecret = $this->appSecret;

        $result = M("wxmanage")->where("wx_appid = '$appid'")->find(); //令牌刷新时间

        $time = $result["token_expire_int"]; //令牌过期时间
        //第一次是access_token不存在 就重新获取一个
        if (time()>$time  || empty($time)) {
            //获取token
//            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . APPID . "&secret=" . APPSECRET;
            $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $appid . "&secret=" . $appsecret;
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
            $data["token_expire_timeint"] = time();
            $data["authorizer_access_token"]       = $access_token;
            $data["token_expire_int"]       = time()+6500;
            $data["token_refresh_timeint"]       = time();
            $res   = M("wxmanage")->where("wx_appid = '$appid'")->save($data);
        } else {
            $arr = M("wxmanage")->where("wx_appid = '$appid'")->find();
            $access_token = $arr["authorizer_access_token"];
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
        $fp = fopen($filename, "w+");
        fwrite($fp, "<?php exit();?>" . $content);
        fclose($fp);
    }
}

