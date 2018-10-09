<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');  
class BatchaddController extends WeixinbaseController
{
    public function add()
    {   
          $schoolid = I("schoolid");

          $teacher_id = I("teacher_id");

       if(!$schoolid)
       {
           $this->error("学校不存在！");
       }

        // //根据穿过来的学校id来查找学校 
         $school_name = M("school")->where("schoolid = $schoolid")->getField("school_name");


         $grade = M("school_grade")->where("schoolid = $schoolid")->select();
//         $signPackage = $this->getSignPackage();
        $this->assign('grade',$grade);
//         $this->assign('signPackage',$signPackage);
        $this->assign("school_name",$school_name);
        $this->display();
    }

    public function add_post()
    {


    }

}