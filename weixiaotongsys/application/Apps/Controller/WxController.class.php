<?php
namespace Apps\Controller;
use Common\Controller\AppBaseController;

class WxController extends AppBaseController
{
    //根据学校id获取该学校的公众号信息
    public function getWxInfoBySchoolId(){
        $schoolid = $_SESSION['schoolid'];
        dump($_SESSION);
       // echo $schoolId;
        $wxInfo = M('wxmanage')->where("schoolid=$schoolid")->field('wx_appid, wx_appsecret')->find();
        return array('appid'=>$wxInfo['wx_appid'], 'appsecret'=>$wxInfo['wx_appsecret']);
    }
}