<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class ExamController extends WeixinbaseController {
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

    //学生考试成绩首页
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        //dump($_SESSION);
        $where["b.schoolid"] = $_SESSION["schoolid"];
        $where["a.classid"] = $_SESSION["classid"];
        $exam = M("exam_class as a ")->
        join("wxt_exam as b on a.examid=b.id")->
        join("wxt_semester as c on c.id=b.semester")->where($where)
        ->field("b.*,c.semester,a.classid,a.examid")->select();
        //dump($exam);
        $this->assign("exam",$exam);
		$this->display();
	}

	//学生考试成绩详情
	public  function  details(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
	    //这个考试 这个学生的各个科目的考试成绩
        $examid = I("examid");//考试ID
        $classid = I("classid");//班级ID
        if(I("studentid")){
            $studentid=I("studentid");
        }else{
            $studentid = $_SESSION["studentid"];
        }
        //考试评论
        $comment = M("exam_comment")->where("examid=$examid and classid=$classid and studentid=$studentid")->find();
        $this->assign("comment",$comment);

        $score = M("exam_score as a")->join("wxt_default_subject as b on a.subjectid=b.id")
            ->where("a.examid=$examid and a.classid=$classid and a.studentid=$studentid")
            ->field("a.*,b.subject")->select();
       // dump($score);
        $totalscore=0;
        $key=0;
        foreach ($score as $k=>$value){
        $totalscore+=$value["score"];
        $key++;
        }
        $kscore = $totalscore/$key;
        $this->assign("totalscore",$totalscore);
        $this->assign("kscore",$kscore);
        $this->assign("score",$score);
        $this->display();
    }




}
?>