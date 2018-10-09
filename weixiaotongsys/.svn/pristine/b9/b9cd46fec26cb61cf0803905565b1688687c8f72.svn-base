<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');
class MenusessionController extends WeixinbaseController
{
    public function index()
    {
        $action = I("action");//跳转的地址
        $type = I("type");//类型
      
        $res = $this->controller_name($action);

        $paraction = $res["paraction"]; //家长跳转地址
        $tchaction = $res["tchaction"]; //老师跳转地址

        $manage_id = $_SESSION["manage_id"];
        $openid = $_SESSION["user"]["weixin"];
        $appid = $_SESSION["APPID"];
        $res = M("xctuserwechat")->where("weixin='".$openid."' and appid='$appid'")->select(); //查询用户的数据

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
        $studentinfo = array();
        $teacherinfo = array();
        foreach($res as $value){
            $userid=$value['userid'];
            //查询家长关系表中是否有这个数据 查到家长学生学校等详细信息
            $stu_real_res = M("relation_stu_user as relation")
                ->join("wxt_wxtuser as user on relation.studentid = user.id")
                ->join("wxt_student_info as student on student.userid = user.id")
                ->join("wxt_school as school on school.schoolid = student.schoollid")
               // ->join("wxt_xctuserwechat as wechat on wechat.userid = relation.userid")
                ->field("studentid,appellation,school.schoolid,school_name,student.stu_name as name,relation.userid,user.photo")
//                ->where("relation.userid = '$userid' and wechat.weixin='$openid' and wechat.appid='$appid'")
                ->where("relation.userid = '$userid'")
                ->select();

            //去除不在这个公众号的学校数据
            foreach ($stu_real_res as $key=>$studentvalue)
            {
                if(in_array($studentvalue["schoolid"],array_unique($schoollist))==false){
                    unset($stu_real_res[$key]);
                }

            }
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
        //$stuNum = count($studentinfo);//确认下怎么计算???????????????????????????

        $teaNum = 0;
        foreach($teacherinfo as $teachervalue){
            $teaNum += count($teachervalue);
        }
        //$teaNum = count($teacherinfo);

        //如果家长老师的身份和大于2的话就直接映射去列表页面  如果就一个就直接映射到页面
        if ($stuNum + $teaNum >=2){


            $this->assign("action",$paraction);//家长跳转地址
            $this->assign("tchaction",$tchaction);//教师跳转地址
            $this->assign("teacherinfo",$teacherinfo);
            $this->assign("studentinfo",$studentinfo);


            $this->assign("type",$type);
           //$this->assign("menutype",$menutype);
            //
            $this->display("Menusession");
        }else{
            if ($stuNum ==1 && $teaNum==0){ // 表示为家长

                $id =$studentinfo[0][0]['userid'];  //家长ID;
                $stu_id = $studentinfo[0][0]['studentid']; //学生ID;
                $schoolid = $studentinfo[0][0]['schoolid']; //学生ID;

                $action = $paraction;//家长跳转地址

                $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;

                $url = $http."/index.php/weixin/".trim($action)."?school_id=".$schoolid .'&type=' . $type.'&id='.$id .'&stu_id='.$stu_id;
                header("location:$url");


            }
            if ($teaNum ==1 && $stuNum==0){
                $id = $teacherinfo[0][0]['teacherid']; //老师ID
                $schoolid = $teacherinfo[0][0]['schoolid']; //学校ID
                $stu_id = 0;//学生ID

                $taction = $tchaction;//教师跳转地址

                $http = "http://".$_SERVER['HTTP_HOST'].__ROOT__;
                $url = $http."/index.php/weixin/".trim($taction)."?school_id=".$schoolid .'&type=' . $type.'&id='.$id .'&stu_id='.$stu_id;
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

    //控制器名 方法名
    public function controller_name($action){
        switch($action)
        {
            case "Notice":
                $paraction = "Notice/index";
                $tchaction = "Tchnotice/index";
                break;
            case "Homework":
                $paraction = "Homework/index";
                $tchaction = "TchHomework/index";
                break;
            case "Mobilephone":
                $paraction = "Mobilephone/index";
                $tchaction = "Tchmobilephone/index";
                break;
            case "Exam":
                $paraction = "Exam/index";
                $tchaction = "TchExam/index";
                break;
            case "SignIn":
                $paraction = " SignIn/index";
                $tchaction = "Tchattendance/index";
                break;
            case "Activity":
                $paraction = "Activity/index";
                $tchaction = "TchActivity/index";
                break;
            case "Leave":
                $paraction = "Leave/index";
                $tchaction = "Tchleave/index";
                break;
            case "Usercenter":
                $paraction = "Usercenter/index";
                $tchaction = "Tusercenter/index";
                break;
            default:
                $event='-';
                break;
        }
        $array = array("paraction"=>$paraction,"tchaction"=>$tchaction);
        return $array;
    }


}
