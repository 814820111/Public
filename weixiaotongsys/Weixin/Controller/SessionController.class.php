<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');
class SessionController extends WeixinbaseController
{
    function index()
    {
//        var_dump(session_id());die();
        // echo $weixin;
        $openid = $_SESSION["user"]["weixin"];
        //从用户表查找是否存在这个用户
        $res = M("wxtuser")->where("weixin = '$openid'")->select();
        if($res){
            $userid = $res[0]['id'];
            $schoolid = $res[0]['schoolid'];
            $_SESSION['schoolid'] = $schoolid;
            $_SESSION["userid"] = $userid;
            $_SESSION["type"] = 1;
        }else {
            //用户的userid
            $userid = 597;
            $_SESSION["userid"] =  $userid;
            $vres = M("wxtuser")->where("id = '$userid'")->find();
            $schoolid = $res[0]['schoolid'];
            $_SESSION['schoolid'] = $vres['schoolid'];
            $_SESSION["type"] = 0;
        }
        //查询家长关系表中是否有这个数据 查到家长学生学校等详细信息
        $stu_real_res = M("relation_stu_user as relation")
                        ->join("wxt_student_info as student on relation.studentid = student.id")
                        ->join("wxt_school as school on school.schoolid = student.schoollid")
                        ->join("wxt_school_class as class on school.schoolid = class.schoolid and student.classid = class.id")
                        ->where("relation.userid = '$userid'")
                        ->select();
                        // var_dump($stu_real_res);
//        var_dump($stu_real_res);die();
    //    echo M("relation_stu_user as relation")->getLastSql();die();
        $stuNum = count($stu_real_res);
        //查询老师跟用户之间的关系数据
        $user_stu_rela = M("teacher_info as t")
            ->join("wxt_wxtuser as w on t.teacherid = w.id")
            ->join("wxt_school as ws on ws.schoolid = t.schoolid")
            ->where("t.teacherid = '$userid'")->select();
        $teaNum = count($user_stu_rela);
        //如果家长老师的身份和大于2的话就直接映射去列表页面  如果就一个就直接映射到页面
        if ($stuNum + $teaNum >=2){
            $this->assign('userid',$_SESSION['userid']);
            $this->assign("teacherinfo",$user_stu_rela);
            //注册老师
            $this->assign("studentinfo",$stu_real_res);
            $this->display();
        }else{
            if ($stuNum ==1 && !$teaNum){
                $this->assign('userid',$_SESSION['userid']);
                $this->assign("studentinfo",$stu_real_res);
                $this->display("Index/index");
            }
            if ( $teaNum ==1 && !$stuNum){
                $this->assign('userid',$_SESSION['userid']);
                $this->assign("teacherinfo",$user_stu_rela);
                $this->display("Tindex/index");

            }
            // if(!$teaNum && !$stuNum){
            //     header("Location:Index/builds");
            // }
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
