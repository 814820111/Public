<?php
	namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchActivityController extends WeixinbaseController {
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
//        $this->check_session();//查看session 是否过期
        $userid = I("userid");//获得用户ID
        $openid  = I("openid");//获取微信的openid
        $schoolid  = I("schoolid");//获得学校ID
        $appid = I("appid");//获取公众号的appid
        $appsecret = I("appsecret");//获取公众号的appsecret
//        判断有没有空
        if (empty($userid) || empty($openid)||empty($appid) ||empty($schoolid) ||empty($appsecret) ){
            unset($userid);
            unset($openid);
            unset($appid);
            unset($appsecret);
            unset($schoolid);
        }else {
            $_SESSION["APPID"] = $appid;
            $_SESSION["APPSECRET"] = $appsecret;
            $_SESSION["user"]["weixin"] = $openid;
            //开始写session
            $_SESSION["userid"] = $userid;
            //查询学校id 学校名字
            $sch_info = M("school")->where(array('schoolid' => $schoolid))->find();
            if ($sch_info) {
                $_SESSION["schoold_name"] = $sch_info["school_name"];
                $_SESSION["schoolid"] = $sch_info["schoolid"];
            }

        }
    }

	//教师端班级活动
	//localhost/weixiaotong2016/index.php/weixin/TchActivity/index
	public function index(){
//        dump($_SESSION);
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $this->assign("userid",$_SESSION['userid']);
        $this->assign("schoolid",$_SESSION['schoolid']);
		$this->display("banjiHuodong");
	}
	//以报名的人数
	
	//已读未读
	public function details(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->assign("userid",$_SESSION['userid']);
		$id=I("aid");
	    $type=I("types");
		$this->assign("id",$id);
		$this->assign("type",$type);
		$this->display("yidu");
	}
	public function Qing(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$id=I("id");
		$this->assign("userid",$_SESSION['userid']);
		$this->assign("id",$id);
        $this->assign("schoolid",$_SESSION['schoolid']);
		$this->display("huodongxiangqing");
	}

	//发布班级活动
	public function  Addnswer(){
	    $userid = $_SESSION["userid"];
	    $schoolid = $_SESSION["schoolid"];
	    if($userid){
            $res = M("wxtuser")->where(array("id"=>$userid))->find();//查找老师信息
            $teacher = M("teacher_info")->where(array("teacherid"=>$userid,"schoolid"=>$schoolid))->field("name")->find();//查找老师信息
            $name = $teacher["name"];//老师名字
            $phone = $res["phone"];//老师电话
            $this->assign('name',$name);
            $this->assign('phone',$phone);
        }
        $stu_sch_name = $_SESSION["school_name"]; //学校名称
        $this->assign("schoolname",$stu_sch_name);

        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('userid',$_SESSION['userid']);
        $this->assign('schoolid',$_SESSION["schoolid"]);
		$this->display("Answer_Parent");
	}
}
