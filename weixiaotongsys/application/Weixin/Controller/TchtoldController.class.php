<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchtoldController extends WeixinbaseController {
    function _initialize()
    {
        parent::_initialize(); // TODO: Change the autogenerated stub
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
	//教师控制器老师叮嘱
	//localhost/weixiaotong2016/index.php/weixin/Tchtold/index
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION['userid'];
        $this->assign('userid',$userid);
        $schoolid = $_SESSION['schoolid'];
        $this->assign('schoolid',$schoolid);
		$this->display("jiazhangdingzhu");
	}
}
?>