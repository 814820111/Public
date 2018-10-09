<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');
class ChangeSessionController extends WeixinbaseController
{
    //切换身份
    public function index()
    {
        //绑定是不是统一公众号还是自己的公众号
       // dump($_SESSION);
        //die();
        $appid = $_SESSION["APPID"];
        $result = M("wxmanage")->where(array("wx_appid"=>$appid))->field("is_public")->find();

//        dump($result);
//        die();
        if($result["is_public"]==1) //表示统一公众号
        {
            $openid = $_SESSION["user"]["weixin"];
            //从用户表查找是否存在这个用户
            $appid = $_SESSION["APPID"];
            $manage_id = $_SESSION["manage_id"];
            $res = M("xctuserwechat")->where("weixin='".$openid."' and appid='$appid'")->select();
//            dump($res);
//            die();
            if(empty($res)){ //表示没有绑定过,直接跳到绑定页
                $headimg = $_SESSION["user"]['headimg'];//微信头像
                $nickname = $_SESSION["user"]['nickname'];//微信昵称
                $this->assign("headimg",$headimg);
                $this->assign("nickname",$nickname);
                $this->display("Binding/build");
                die();
            }
            //查询这个公众号绑定的学校列表
            $appschoolid = M("wxmanage_school as a")->join("wxt_wxmanage as b on a.manage_id=b.id")->field("a.schoolid")->where(array("b.wx_appid"=>$appid))->select();
            foreach ($appschoolid as $schoolidvalue){
                $schoollist[] = $schoolidvalue["schoolid"];
            }

            //dump($appschoolid);
            //die();
            $studentinfo = array();
            $teacherinfo = array();
            foreach($res as $value){
                $userid=$value['userid'];
                //查询家长关系表中是否有这个数据 查到家长学生学校等详细信息
                $stu_real_res = M("relation_stu_user as relation")
                    ->join("wxt_wxtuser as user on relation.studentid = user.id")
                    ->join("wxt_student_info as student on student.userid = user.id")
                    ->join("wxt_school as school on school.schoolid = student.schoollid")
                    //->join("wxt_xctuserwechat as wechat on wechat.userid = relation.userid")
                    ->field("studentid,appellation,school.schoolid,school_name,student.stu_name as name,relation.userid,user.photo")
//                ->where("relation.userid = '$userid' and wechat.weixin='$openid' and wechat.appid='$appid'")
                    ->where("relation.userid = '$userid'")
                    ->select();

//            echo "<pre>";
//            print_r( $stu_real_res);
//            die();
                //去除不在这个公众号的学校数据
                foreach ($stu_real_res as $key=>$studentvalue)
                {
                    if(in_array($studentvalue["schoolid"],array_unique($schoollist))==false){
                        unset($stu_real_res[$key]);
                    }

                }
                //$stuNum = count($stu_real_res);
                if(!empty($stu_real_res)){
                    $studentinfo[] = $stu_real_res;
                }


                //echo $stuNum;
                // echo "<br>";
                $user_stu_rela = M("teacher_info as t")
                    ->join("wxt_wxtuser as w on t.teacherid = w.id")
                    ->join("wxt_school as ws on ws.schoolid = t.schoolid")
                    // ->join("wxt_xctuserwechat as wechat on wechat.userid = w.id")
//                ->field("w.photo,w.name,ws.school_name,t.teacherid")
                    ->field("w.photo,ws.school_name,t.teacherid,t.name,ws.schoolid")
//                ->where("t.teacherid = '$userid' and wechat.weixin='$openid' and wechat.appid='$appid'")
                    ->where("t.teacherid = '$userid'")
                    ->select();


                //去除不在这个公众号的学校数据
                foreach ($user_stu_rela as $key=>$teachervalue)
                {
                    if(in_array($teachervalue["schoolid"],array_unique($schoollist))==false){
                        unset($user_stu_rela[$key]);
                    }

                }

                if(!empty($user_stu_rela)){
                    $teacherinfo[] = $user_stu_rela;
                }


            }
            $stuNum = 0;
            foreach($studentinfo as $studentvalue){
                $stuNum += count($studentvalue);
            }
            $teaNum = 0;
            foreach($teacherinfo as $teachervalue){
                $teaNum += count($teachervalue);
            }

            //如果家长老师的身份和大于2的话就直接映射去列表页面  如果就一个就直接映射到页面
            if ($stuNum + $teaNum >=2){


                $this->assign("teacherinfo",$teacherinfo);
                $this->assign("studentinfo",$studentinfo);
                $this->display();
            }else{
                if ($stuNum ==1 && $teaNum==0){
                    $_SESSION['studentid'] = $studentinfo[0][0]['studentid'];
                    $_SESSION['userid'] = $studentinfo[0][0]['userid'];
                    $schoolid = $studentinfo[0][0]['schoolid']; //学校ID

                    $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                    $url = "$http/index.php/weixin/Index/index?id=".$_SESSION['userid']."&stu_id=".$_SESSION['studentid']."&schoolid=".$schoolid;
                    header("location:$url");
                }
                if ( $teaNum ==1 && $stuNum==0){
                    $_SESSION['userid'] = $teacherinfo[0][0]['teacherid'];
                    $schoolid = $teacherinfo[0][0]['schoolid']; //学校ID

                    $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                    $url = "$http/index.php/weixin/Tindex/index?id=".$_SESSION['userid']."&schoolid=".$schoolid;
                    header("location:$url");


                }
                //如果都等于0 说明 还没有绑定过账号 跳到绑定页面
                if($stuNum==0 && $teaNum==0){

                    $openid =  $_SESSION["user"]['weixin'];
                    $headimg = $_SESSION["user"]['headimg'];//微信头像
                    $nickname = $_SESSION["user"]['nickname'];//微信昵称


                    $this->assign("headimg",$headimg);
                    $this->assign("nickname",$nickname);
                    $this->display("Binding/build");
                }
            }
            die();
        }

        if($result["is_public"]==2)//表示单一公众号
        {
            $openid = $_SESSION["user"]["weixin"];
            //从用户表查找是否存在这个用户
            $appid = $_SESSION["APPID"];
            $schoolid = $_SESSION["schoolid"];
            $res = M("xctuserwechat")->where("weixin='".$openid."' and appid='$appid'")->select();
            if(empty($res)){ //表示没有绑定过,直接跳到绑定页
                $headimg = $_SESSION["user"]['headimg'];//微信头像
                $nickname = $_SESSION["user"]['nickname'];//微信昵称
                $schoolid = $_SESSION["schoolid"]; //学校ID
                $this->assign("schoolid",$schoolid);
                $this->assign("headimg",$headimg);
                $this->assign("nickname",$nickname);
                $this->display("SingleBinding/build");
                die();
            }
            $studentinfo = array();
            $teacherinfo = array();
            foreach($res as $value){
                $userid=$value['userid'];
                //查询家长关系表中是否有这个数据 查到家长学生学校等详细信息
                $stu_real_res = M("relation_stu_user as relation")
                    ->join("wxt_wxtuser as user on relation.studentid = user.id")
                    ->join("wxt_student_info as student on student.userid = user.id")
                    ->join("wxt_school as school on school.schoolid = student.schoollid")
                    ->field("studentid,appellation,school.schoolid,school_name,student.stu_name as name,relation.userid,user.photo")
                    ->where("relation.userid = '$userid'  and student.schoollid='$schoolid'")
                    ->select();

                if(!empty($stu_real_res)){
                    $studentinfo[] = $stu_real_res;
                }

                $user_stu_rela = M("teacher_info as t")
                    ->join("wxt_wxtuser as w on t.teacherid = w.id")
                    ->join("wxt_school as ws on ws.schoolid = t.schoolid")
                    ->field("w.photo,t.name,ws.school_name,t.teacherid,ws.schoolid")
                    ->where("t.teacherid = '$userid'  and t.schoolid='$schoolid'")
                    ->select();

                if(!empty($user_stu_rela)){
                    $teacherinfo[] = $user_stu_rela;
                }


            }


            $stuNum = 0;
            foreach($studentinfo as $studentvalue){
                $stuNum += count($studentvalue);
            }

            $teaNum = 0;
            foreach($teacherinfo as $teachervalue){
                $teaNum += count($teachervalue);
            }

            //如果家长老师的身份和大于2的话就直接映射去列表页面  如果就一个就直接映射到页面
            if ($stuNum + $teaNum >=2){

                $this->assign("teacherinfo",$teacherinfo);
                $this->assign("studentinfo",$studentinfo);
                $this->display();
            }else{
                if ($stuNum ==1 && $teaNum==0){
                    $_SESSION['studentid'] = $studentinfo[0][0]['studentid'];
                    $_SESSION['userid'] = $studentinfo[0][0]['userid'];
                    $schoolid = $studentinfo[0][0]['schoolid']; //学校ID

                    $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;

                    $url = "$http/index.php/weixin/Index/index?id=".$_SESSION['userid']."&stu_id=".$_SESSION['studentid']."&schoolid=".$schoolid;
                    header("location:$url");
                }
                if ( $teaNum ==1 && $stuNum==0){
                    $_SESSION['userid'] = $teacherinfo[0][0]['teacherid'];
                    $schoolid = $teacherinfo[0][0]['schoolid']; //学校ID

                    $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                    $url = "$http/index.php/weixin/Tindex/index?id=".$_SESSION['userid']."&schoolid=".$schoolid;
                    header("location:$url");

                }
                //如果都等于0 说明 还没有绑定过账号 跳到绑定页面
                if($stuNum==0 && $teaNum==0){

                    $headimg = $_SESSION["user"]['headimg'];//微信头像
                    $nickname = $_SESSION["user"]['nickname'];//微信昵称
                    $schoolid = $_SESSION["schoolid"]; //学校ID
                    $this->assign("schoolid",$schoolid);

                    $this->assign("headimg",$headimg);
                    $this->assign("nickname",$nickname);
                    $this->display("SingleBinding/build");
                }
            }
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

     //取消绑定
    public function Unbind()
    {
        //微信openid
        $openid = $_SESSION["user"]["weixin"];
        //公众号ID
        $appid = $_SESSION["APPID"];
        //用户ID
        $userid = $_SESSION["userid"];

        $where["userid"] = $userid;
        $where["weixin"] = $openid;
        $where["appid"] = $appid;
        $res = M("xctuserwechat")->where($where)->delete();
        if($res){
            $ret = format_ret(1, "成功");
            echo json_encode($ret);
        }else{
            $ret = format_ret(0, "失败");
            echo json_encode($ret);
        }
    }

}
