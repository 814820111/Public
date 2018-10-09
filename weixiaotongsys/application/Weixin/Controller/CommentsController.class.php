<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class CommentsController extends WeixinbaseController {
    function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
//        $type = I("type");
//        if($type){
//            $id = I("id");
//            $stu_id = I("stu_id");
//            $school_id = I("school_id");
//            $this->check_menu($id,$stu_id,$school_id);
//            return;
//        }
        $userid = I("userid");
        //获取微信的openid
        $openid  = I("openid");
        //获取学生的id
        $studentid = I("studentid");
        $schoolid = I("schoolid");//学校ID
        $appid = I("appid");//获取公众号的appid
        $appsecret = I("appsecret");//获取公众号的appsecret
        //判断是否有空
        if(empty($userid) || empty($openid) || empty($studentid)||empty($appid) ||empty($schoolid) ||empty($appsecret)){
            unset($userid);
            unset($openid);
            unset($studentid);
            unset($appid);
            unset($appsecret);
            unset($schoolid);
        }else{
            $_SESSION["APPID"] = $appid;
            $_SESSION["APPSECRET"] = $appsecret;
            $_SESSION["user"]["weixin"] = $openid;
            //$res = M("wxtuser")->where(array("id"=>$userid,"weixin"=>$openid))->find();
            $res = M("xctuserwechat")->where(array("userid"=>$userid,"weixin"=>$openid))->find();
            if ($res){
                $_SESSION["userid"] = $userid;
                $_SESSION["studentid"] = $studentid;
                //顺带查出来学校id 学校名字 学生班级
                $sch_info = M("school")->where(array('schoolid' => $schoolid))->find();
                if ($sch_info){
                    $_SESSION["school_name"] = $sch_info["school_name"];
                    $_SESSION["schoolid"] = $sch_info["schoolid"];
                }
            }
//            }
        }

    }
//	localhost/weixiaotong2016/index.php/Weixin/Comments/index
//老师点评
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->assign("studentid",$_SESSION['studentid']);
		$this->assign("schoolid",$_SESSION['schoolid']);
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