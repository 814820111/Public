<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchSignInController extends WeixinbaseController {
	//http://localhost/weixiaotong2016/index.php/weixin/TchSignIn/index
	//教师考勤考勤的渲染页面
	
	public function index(){
		$thismonth = date('m');
            $thisyear = date('Y');
             $startDay = $thisyear . '-' . $thismonth . '-1';
               $endDay = $thisyear . '-' . $thismonth . '-' . date('t', strtotime($startDay));
            $b_time  = strtotime($startDay);//当前月的月初时间戳
          $e_time  = strtotime($endDay);//当前月的月末时间戳

		$this->assign("b_time",$b_time);
		$this->assign("e_time",$e_time);
		$this->display();
		
			
		
	}
}
?>