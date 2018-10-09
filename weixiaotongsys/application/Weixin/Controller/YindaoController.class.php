<?php
namespace Weixin\Controller;
use Apps\Controller\IndexController;
use Common\Controller\WeixinbaseController;
header("Content-type:text/html;charset=utf-8");

class yindaoController extends WeixinbaseController {
    function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $ym = date("Y-m");
        $day = date("d");
        $w = date("w");
        $week = array("星期日","星期一","星期二","星期三","星期四","星期五","星期六");
        $this->assign("ym",$ym);
        $this->assign("day",$day);
        $this->assign("w",$week[$w]);
        $this->display();
    }
}