<?php
	namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchcommentController extends WeixinbaseController {
	//教师端老师点评
	//localhost/weixiaotong2016/index.php/weixin/Tchcomment/index
	public function Tiaoshu (){
        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);
	    $this->assign('userid',$_SESSION['userid']);//老师ID
	    $this->assign('schoolid',$_SESSION['schoolid']);
		$name=I("name");
		$id=I("id");//学生id
		$this->assign("id",$id);
		$this->assign("name",$name);
		$this->display("laoshidianping");
	}
	//老师添加渲染页面
	public function xuAnz(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->assign('userid',$_SESSION['userid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
		$this->display("xuanzexuesheng");
	}
	//老师点评列表页面
	public function LeiBao(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $this->assign('userid',$_SESSION['userid']);
        $this->assign('schoolid',$_SESSION['schoolid']);

        $endtime=I("endtime");//结束的时间戳
		$id=I("id");//学生ID;
		$begintime=I("begintime");//开始的时间戳
		$chang=I("chang");//数组的长度
		$this->assign("chang",$chang);
		$this->assign("endtime",$endtime);
		$this->assign("id",$id);
		$this->assign("begintime",$begintime);
		$this->display("laoshidianpingleibao");
		
	}
	//点评的条数
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $this->assign('userid',$_SESSION['userid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
		$this->display("dianping_child");
	}
}
?>