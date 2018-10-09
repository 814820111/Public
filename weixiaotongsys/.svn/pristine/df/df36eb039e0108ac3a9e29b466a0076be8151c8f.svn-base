<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class AlbumsController extends WeixinbaseController {

	//localhost/weixiaotong2016/index.php/weixin/Albums/index
	//班级相册的渲染页面
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    $userid = $_SESSION['userid'];
	    $studentid = $_SESSION['studentid'];
//查询学校的id
        $this->assign("schoolid",$_SESSION['schoolid']);
	    $this->assign("userid",$userid);
	    $this->assign("studentid",$studentid);
	    $this->assign("classid",$_SESSION['classid']);
		$this->display();
	}
	//班级相册
	public function detail(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        if(I("userid")){ //学生ID
            $userid = I("userid");
        }else{
            $userid=$_SESSION['userid'];
        }
        $studentid = $_SESSION['studentid'];
        $this->assign("userid",$userid);
        $id=$_SESSION['userid']; //用户ID

        //获取用户姓名
        $user_info = M("relation_stu_user")->where(array("userid"=> $id,"studentid"=>$studentid))->field("name")->find();
        $info = M("wxtuser")->where(array("id"=> $id))->field("photo")->find();
       // dump($user_info);
        $this->assign("nameuser",$user_info['name']);
        $this->assign("photos",$info['photo']);
        $this->assign("uid",$id);

        //查询学校的id
        $this->assign("schoolid",$_SESSION['schoolid']);
        $this->assign("studentid",$studentid);
        $this->assign("classid",$_SESSION['classid']);

       //该信息的ID
        $mid=I("mid");
        //消息类型
        $types=I("type");
        $this->assign("types",$types);
        $this->assign("mid",$mid);
		$this->display();
	}
	//宝宝相册
	public function indexbaobao(){
        $userid = $_SESSION['userid'];
        $studentid = $_SESSION['studentid'];
        //查询学校的id
        $this->assign("schoolid",$_SESSION['schoolid']);

        $this->assign("userid",$userid);
        $this->assign("studentid",$studentid);
        $this->assign("classid",$_SESSION['classid']);
        $this->assign("type",3);
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$this->display();
	}
	public function fabu(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
		$type=I("type");
	    $this->assign("type",$type);     
//	    $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
//        $signPackage = $jssdk->GetSignPackage();
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->assign('classid',$_SESSION['classid']);
        $this->assign('studentid',$_SESSION['studentid']);
        $this->assign('schoolid',$_SESSION['schoolid']);
        //查找学生姓名
        $user_info = M("student_info")->where(array("userid"=>$_SESSION['studentid']))->field("stu_name")->find();
        $this->assign('send_name',$user_info["stu_name"]);

        $this->assign('userid',$_SESSION['userid']);
		$this->display("fabuxiangce");
	}
    //增加图片
    public function addPhoto()
    {
        if(I("mid")){
            $mid = I("mid");
            $this->assign("mid",$mid);
        }
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
//        $jssdk = new JSSDK("wx7325155f62456567","c379e9768f9faa8865a1db767fc81155");
//        $signPackage = $jssdk->getSignPackage();
        $signPackage = $this->getSignPackage();
        $this->assign('signPackage',$signPackage);
        $this->display();
    }
}


