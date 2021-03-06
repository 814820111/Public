<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
//define("APPID", "wx7325155f62456567");
//define("APPSECRET","c379e9768f9faa8865a1db767fc81155");
//header("Content-type:text/html;charset=utf-8");
class LeaveController extends WeixinbaseController {
    function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
        $type = I("type");
        if($type){
            $id = I("id");
            $stu_id = I("stu_id");
            $school_id = I("school_id");
            $this->check_menu($id,$stu_id,$school_id);
            return;
        }
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
    //在线请假
	//http://localhost/weixiaotong2016/index.php/weixin/Leave/index
    public function loading(){
        $this->login("Leave/addleave");
    }

    //请假列表
    public function index (){
        $stu_sch_name = $_SESSION["school_name"]; //学校名称
        $this->assign("schoolname",$stu_sch_name);
        $this->assign('studentid',$_SESSION['studentid']); //学生ID
        $this->assign('userid',$_SESSION['userid']); //家长ID
        $this->assign('schoolid',$_SESSION['schoolid']); //学校ID
        $this->display();
    }
    //在线请假
    public function addleave(){
        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);

        $signPackage = $this->getSignPackage(); //调用微信相关
        $this->assign('signPackage',$signPackage);
        $this->assign('studentid',$_SESSION['studentid']);//学生ID

        $this->assign('userid',$_SESSION['userid']); //家长ID
        $this->assign('schoolid',$_SESSION['schoolid']); //学校ID
        //获取学生名字
        $student = M("student_info")->where(array('userid'=>$_SESSION['studentid']))->field("stu_name")->find();
        $stu_name = $student['stu_name'];
        $this->assign("name",$stu_name);
    	$this->display("zaixianQingjia");
    	
    }
}


   


