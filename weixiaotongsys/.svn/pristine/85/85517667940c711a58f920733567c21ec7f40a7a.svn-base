<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
    class TIndexController extends WeixinbaseController{
        function index(){
            $userid = $_SESSION["userid"];
            //查询学校
            $school = M("teacher_class")->where(array("teacherid"=>$userid))->find();
            $schoolid = $school["schoolid"];
            //查询学校名字
            $school_name = M("school")->where(array("schoolid"=>$schoolid))->find();
            //todo 这里要改的话直接搜索todo就行
            var_dump($school_name);die();
            $school_name= $school_name["school_name"];
            $_SESSION["school_name"] = $school_name;
            $stu_sch_name = $_SESSION["school_name"];
            $this->assign("schoolname",$stu_sch_name);
            $this->display();
        }
    }