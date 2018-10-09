<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class NoticeController extends WeixinbaseController {

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
	//http://   localhost/weixiaotong2016/index.php/weixin/Notice/index
	//通知公告渲染控制器
	public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);//学校名称
		$this->assign('userid',$_SESSION['studentid']);//学生ID
		$this->assign('schoolid',$_SESSION['schoolid']);//学校ID
		$this->display();
		
	}

    //公告详情
    public function details(){

        $receiverid = I("receiverid"); //接收人ID
        $noticeid = I("noticeid"); //公告ID
        $schoolid = $_SESSION["schoolid"]; //学校ID
        //调用APPS详情接口
        $array=$this->get_receive_notice_details($receiverid,$noticeid,$schoolid);
       //$array=R("Apps/School/get_receive_notice_details",array("receiverid"=>$receiverid,"noticeid"=>$noticeid));
        $result = json_decode($array,true);
//        echo "<pre>";
//        print_r($result);
//        die();
        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);

        $title = $result["data"][0]["notice_info"][0]["title"];//通知标题
        $content = $result["data"][0]["notice_info"][0]["content"];//通知内容
        $name = $result["data"][0]["notice_info"][0]["name"];//通知人名称
        $photo = $result["data"][0]["notice_info"][0]["photo"];//通知人头像
        $Tmie = date('Y-m-d H:i:s',$result["data"][0]["notice_info"][0]["create_time"]);//通知时间
        $user = $receiverid; //接收人ID
        $create_time = $result["data"][0]["create_time"]; //有没有读取

        $readarray = $result["data"][0]["receiv_list"];
        $h=0;
        foreach($readarray  as $k=>$v){
            if($v["create_time"]>0){
                $h++;
            }
        }
        $zongshu = count($readarray); //总数
        $yushu = $h; //已读
        $weidu=$zongshu-$h;//未读

        $subContent = $result["data"][0]['pic'];//图片
        if(count($subContent)==0){
            $sub=1;
        }else{
            $subContent=$subContent;
            $sub=0;
        }

        $this->assign("sub",$sub);
        $this->assign("create_time",$create_time);
        $this->assign("user",$user);
        $this->assign("photo",$photo);
        $this->assign("nanm",$name);

        $this->assign("title",$title);
        $this->assign("content",$content);
        $this->assign("subContent",$subContent);
        $this->assign("Tmie",$Tmie);
        $this->assign("noticeid",$noticeid);
        $this->assign("zongshu",$zongshu);
        $this->assign("yushu",$yushu);
        $this->assign("weidu",$weidu);
        $this->display();
    }

    //家长端 获取公告 详情
    public function get_receive_notice_details($receiverid,$noticeid,$schoolid){
        //获取参数
        if($receiverid){
            $notice_where["r.receiverid"] = $receiverid;
        }else{
            $ret = $this->format_ret(0,'lost params');
            echo json_encode($ret);
            exit;
        }
        if($noticeid){
            $notice_where["r.noticeid"] = $noticeid;
        }
        if($schoolid){
            $notice_where["r.schoolid"] = $schoolid;
            $info_where["teacher.schoolid"] = $schoolid;
            $info_where["n.send_type"] = 1;
            $info_where["n.schoolid"] = $schoolid;
        }


        $notice_model=M('notice');
        $receive_model=M('notice_receiverid');
        $pic_model = M('notice_photo');
        $user_model=M('wxtuser');
        //在接收人表中通过传入的receiverid获取到对应的信息
        $receive_info=$receive_model
            ->alias("r")
//                ->where("r.receiverid=$receiverid and r.noticeid=$noticeid")
            ->where($notice_where)
            ->select();
        //foreach循环获取剩余所需信息
        foreach ($receive_info as &$notice) {
            $id=$notice['noticeid'];
            $info_where["n.id"] = $id;
            //在公告信息表中通过查询到的对应主键id获取到对应的公告信息,两表联查在user表中查询发布人的姓名等信息
            $notice_info=$notice_model
                ->alias("n")
                ->join("wxt_wxtuser w ON n.userid=w.id")
                ->join("wxt_teacher_info teacher ON n.userid=teacher.teacherid")
//                    ->where("n.id=$id")
                ->where($info_where)
                ->field("teacher.name,w.photo,n.id,n.userid,n.title,n.type,n.content,n.create_time")
                ->select();
            $notice['notice_info']=$notice_info;
            //在接收人表中通过查询到的对应主键id获取到所有收到这条信息的人
            $receiv_list=$receive_model
                ->alias("e")
                ->join("wxt_wxtuser u ON e.receiverid=u.id")
                ->field("u.name,u.photo,u.phone,e.*")
                ->where("e.noticeid=$noticeid")
                ->select();
            $notice['receiv_list']=$receiv_list;
            //获取图片
            $pic=$pic_model->field("photo,width,height")->where("noticeid=$noticeid")->select();
            $notice['pic']=$pic;
            for ($j=0; $j < count($pic); $j++) {
                $notice['pic'][$j]["picturewidth"]=$pic[$j]["width"];
                $notice['pic'][$j]["pictureheight"]=$pic[$j]["height"];
            }
            unset($notice);
        }
        $ret = $this->format_ret(1,$receive_info);

        return json_encode($ret);
    }
}
?>