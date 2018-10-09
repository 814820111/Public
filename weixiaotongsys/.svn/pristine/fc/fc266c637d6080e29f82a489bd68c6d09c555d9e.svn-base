<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');
class SessionController extends WeixinbaseController
{
    function index()
    {
//
//       $openid = $_SESSION["user"]["weixin"];
//        //从用户表查找是否存在这个用户
//        $appid = $_SESSION["APPID"];
//        $manage_id = $_SESSION["manage_id"];
        $manage_id = 2;
       $openid = "123456789";
       $appid = "wx7325155f62456567";
       $res = M("xctuserwechat")->where("weixin='".$openid."' and appid='$appid'")->select();
       if(empty($res)){ //表示没有绑定过,直接跳到绑定页
           $headimg = $_SESSION["user"]['headimg'];//微信头像
           $nickname = $_SESSION["user"]['nickname'];//微信昵称
           $this->assign("headimg",$headimg);
           $this->assign("nickname",$nickname);
           $this->display("Binding/build");
           die();
       }
       //查询这个公众号绑定的学校列表
       $appschoolid = M("wxmanage_school")->where(array("manage_id"=>$manage_id))->select();
       foreach ($appschoolid as $schoolidvalue){
           $schoollist[] = $schoolidvalue["schoolid"];
       }

        if($res){
            //如果存在就直接读取用户
            $_SESSION["type"] = 1;
        }else {
            //如果不存在就用默认的
            //用户的userid
            $_SESSION["type"] = 0;
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
        //$teaNum = count($teacherinfo);

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


}
