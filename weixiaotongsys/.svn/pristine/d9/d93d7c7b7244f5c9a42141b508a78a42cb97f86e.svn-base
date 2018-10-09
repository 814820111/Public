<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header("Content-type:text/html;charset=utf-8");
class TindexController extends WeixinbaseController
{
    //后台框架首页
    public function index()
    {
        $userid = $_SESSION['userid'];

        //获取登录用户的信息
        $userinfo = M("wxtuser")->where("id = '$userid'")->field("name,schoolid")->find();

        $schoolid = $userinfo["schoolid"];
        //学校名称
        $school_info=M("school")->where("schoolid='$schoolid'")->field("school_name")->find();
        $school_name=$school_info["school_name"];
        //老师姓名
        $teacher_name=$userinfo["name"];
        //查到老师带的班级都有哪些
        //学校班级表的id 是老师的classid
        $class = M("teacher_class as class")
            ->distinct(true)
            ->join("wxt_school_class as schoolclass on class.schoolid = schoolclass.schoolid and schoolclass.id = class.classid")
            ->where("class.schoolid = '$schoolid'")
            ->field("class.classid,schoolclass.classname")
            ->select();
        $this->assign("class",$class);
        $this->assign("schoolid",$schoolid);
        $this->assign("teacher_name",$teacher_name);
        $this->assign("school_name",$school_name);
        $this->display();
    }
    function miaoshu(){
        $num = 0;
        $classid = I("classid");
        $schoolid = I("schoolid");
        //查询学生总人数
        $stu_num = M("student_info")->where("classid = '$classid' and schoollid = '$schoolid'")->select();
        $stu_num = $stu_num[0];
        for ($i = 0;$i<$stu_num;$i++){
            $stu_id = $stu_num[$i]["id"];
            $result = M("relation_stu_user")->where("studentid = '$stu_id'")->select();
            if ($result){
                $num .=count($result);
            }
        }
        $stu_num = count($stu_num);
        $data['stu_num'] = $stu_num;
        $data['num'] = $num;
        if ($stu_num){
            $ret = $this->format_ret(1,$data);
            echo json_encode($ret);
        }else{
            $ret = $this->format_ret(0,"0");
            echo json_encode($ret);
        }
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
    function tishi(){
        $y = date("Y");
        $m = date("m");
        $d = date("d");
        $weekarray=array("日","一","二","三","四","五","六"); //先定义一个数组
        $w = $weekarray[date("w")];
        $this->assign("y",$y);
        $this->assign("m",$m);
        $this->assign("d",$d);
        $this->assign("w",$w);
        $this->display();
    }
}

