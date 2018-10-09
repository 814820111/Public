<?php
namespace Weixin\Controller;
use Apps\Controller\IndexController;
use Common\Controller\WeixinbaseController;
header("Content-type:text/html;charset=utf-8");

class yindaoController extends WeixinbaseController {
    function index(){
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