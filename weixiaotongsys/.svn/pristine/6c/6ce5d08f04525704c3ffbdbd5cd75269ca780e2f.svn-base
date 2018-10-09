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


        if(I("schoolid")){
            $weixin = $_SESSION["user"]["weixin"];//微信ID
            $appid = $_SESSION["APPID"];
            $schoolid = I("schoolid");
            $_SESSION["schoolid"] = $schoolid;
            //修改学校粉丝
            M("wechat_school_openid")->where(array("openid"=>$weixin,"appid"=>$appid))->save(array("schoolid"=>$schoolid));
        }else{
            $schoolid = $_SESSION["schoolid"];
        }

        if(I('id')){
            $userid = I('id');//老师ID
            $_SESSION['userid'] = $userid;
        }else{
            $userid = $_SESSION['userid'];//老师ID
        }
        $_SESSION["studentid"]="";
        //获取登录用户的信息
        $userinfo = M("wxtuser")->where("id = '$userid'")->field("photo,name,schoolid")->find();

        $photo = $userinfo["photo"];
        $headimg = str_replace(",","",$photo);
        if ($headimg ==null){
//            $headimg = __ROOT__."/uploads/microblog/weixiaotong.png";//默认头像
            $headimg = SR."weixiaotong.png";//默认头像
        }elseif(strpos($headimg,"ttp://")){
            $headimg =$headimg;//微信绑定的头像
        }
        else{
//            $headimg = __ROOT__."/uploads/microblog/".$headimg;//自己上传的头像
            $headimg = SR.$headimg;//自己上传的头像
        }
        $this->assign("headimg",$headimg);

//        $schoolid = $teacherinfo["schoolid"];
//        $_SESSION['schoolid'] = $schoolid;
        //学校名称
        $school_info=M("school")->where("schoolid='$schoolid'")->field("school_name")->find();
        $school_name=$school_info["school_name"];
        $_SESSION["school_name"] = $school_name;
        $this->assign("schoolname",$school_name);
        //老师姓名
       // $teacher_name=$userinfo["name"];
        //查到老师带的班级都有哪些
        //学校班级表的id 是老师的classid
        $class = M("teacher_class as class")
            ->distinct(true)
            ->join("wxt_school_class as schoolclass on class.schoolid = schoolclass.schoolid and schoolclass.id = class.classid")
            ->where("class.schoolid = '$schoolid' and teacherid = '$userid'")
            ->field("class.classid,schoolclass.classname")
            ->select();
        if(empty($_SESSION["classid"])){
            $_SESSION["classid"] = $class[0]['classid'];
        }

        foreach( $class as $k => &$v){
            if( !$v["classname"] || empty($v["classname"]) || $v["classname"]=="")
                unset( $class[$k] );
        }
		
//	   $middle_menu = R('Apps/Role/weixin_role',array(2,1,2));
//
//
//      foreach ($middle_menu as $key => &$value){
//          $img=explode("|", $value['icon']);
//
//          $value['icon'] = $img[0];
//          $value['icon2'] =  $img[1];
//
//      }
//
//       $this->assign("top_menu",array_chunk(R('Apps/Role/weixin_role',array(2,1,1)),10));
//       $this->assign("middle_menu",$middle_menu);
//       $this->assign("bottom_menu",R('Apps/Role/weixin_role',array(2,1,3)));

        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);

        $this->assign("class",$class);
        $this->assign("schoolid",$schoolid);
        //$this->assign("teacher_name",$teacher_name);
        $this->assign("classid",$_SESSION["classid"]);
        $this->assign("school_name",$school_name);
        //print_r($_SESSION);
        $this->display('Tindex/index');
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
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
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

    //成长档案
    function Growtharchives(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $teacherid = $_SESSION['userid'];
        $this->assign("teacherid", $teacherid);
        
        $this->display();
    }
    //好友成长日记
    public function GrowthDiary(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION["userid"];
        $this->assign("userid",$userid);
        $studentid = $_SESSION['studentid'];
        $info = M("wxtuser")->where(array("id"=>$userid))->find();//查找自己的信息
        $this->assign("username",$info['name']);//自己的姓名

        //获取学生姓名
        $stu_info = M("wxtuser")->where(array("id"=>$studentid))->find();
        $this->assign("name",$stu_info['name']);
        $this->assign("classid",$_SESSION['classid']);
        $this->assign("schoolid",$_SESSION['schoolid']);
        $sid = I('sid');//好友学生id
        $this->assign("studentid",$sid);
//        $this->assign("studentid",$studentid);
        $this->display("Growthdiary");
    }
}

