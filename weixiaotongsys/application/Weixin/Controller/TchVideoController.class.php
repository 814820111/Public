<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class TchVideoController extends WeixinbaseController {
	/*
	 * 添加视屏页面
	 */
    public function index(){
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);
        $userid = $_SESSION["userid"];
        if($_SESSION['schoolid']){
            $schoolid = $_SESSION['schoolid'];
            $this->assign('schoolid',$_SESSION['schoolid']); //学校ID
        }else{
            $schoolid = M("teacher_class")->where("teacherid = '$userid'")->find();

        }
        //老师所在班级
        $class = M("teacher_class as class")
            ->distinct(true)
            ->join("wxt_school_class as schoolclass on class.schoolid = schoolclass.schoolid and schoolclass.id = class.classid")
            ->where("class.schoolid = '$schoolid' and teacherid = '$userid'")
            ->field("class.classid,schoolclass.classname")
            ->select();
        // dump($class);
        $this->assign("class",$class);
        $this->display();
    }

	/*
	 *上传视屏
	 */
    public function upload(){
        if ($_FILES){
            $array['date'] = date('YmdHis', mktime());
            $array['name'] = rand(1000, 9999);
            $name = implode($array);//定义一个命名规则

            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     20971520;// 设置附件上传大小 3MB
            //$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->exts      =     array('mp4','wmv',"rmvb");// 设置附件上传类型
            $upload->rootPath  =     './uploads/'; // 设置附件上传根目录
            $upload->savePath  =     '/video/'; // 设置附件上传（子）目录
            $upload->saveName  =     $name;//图片名字
            $upload->autoSub = false;
            // 上传文件
            $info   =   $upload->upload();

            if(!$info) {// 上传错误提示错误信息
                $error = $upload->getError();
                echo json_encode(array('success'=>2,"date"=>$error));
                //$this->error($upload->getError());
            }else{// 上传成功
                foreach($info as $file){
                    $filename = $file['savename'];
                }
                //$_SESSION["filename"] =  $filename;
                echo json_encode(array('success'=>1,"date"=>"上传成功","name"=>$filename));
            }

        }else{
            echo json_encode(array('success'=>2,"date"=>"上传失败"));

        }


    }






    /*
	 *视频列表
	 */
    public function videoIndex()
    {
        $stu_sch_name = $_SESSION["school_name"];
        $this->assign("schoolname",$stu_sch_name);//学校名称
        $classid = I("classid");//班级ID
        $userid = $_SESSION['userid']; //用户ID

        $schoolid = $_SESSION['schoolid'];
        $videolist = M("teacher_class as a")->
        join("wxt_school_video as b on a.classid=b.classid")->
        where("a.teacherid = $userid and a.schoolid=$schoolid")->field("b.*")->select();
//        $videolist = M("school_video")
//            ->where("classid=$classid and schoolid=$schoolid")->select();
//        //dump($videolist);
        $count = count($videolist);
        $this->assign('videolist',$videolist);
        $this->assign('count',$count);
        $this->assign('classid',$classid);
        $this->display();
    }

    /*
    *发布视频
    */
    public function addVideo()
    {
        $token=R("Apps/QiNiu/getToken");
        $this->assign('token',$token);

        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);
        $classid = I("classid");//班级ID
        $this->assign('classid',$classid);
        $userid = $_SESSION['userid']; //用户ID
        if($_SESSION['schoolid']){
            $this->assign('schoolid',$_SESSION['schoolid']); //学校ID
        }else{
            $schoolid = M("teacher_class")->where("teacherid = '$userid'")->find();
            $this->assign('schoolid',$schoolid['schoolid']);
        }

        $this->assign('userid',$_SESSION['userid']);
        $this->display();
    }

    /*
   *提交
   */
    public function video_post()
    {
        $class = I("classid");//班级ID
        $classlist = array_filter(explode(",",$class));
        $user_id = I("user_id");//用户ID
        $title = I("title");//视频名称
        $schoolid = I("schoolid");//学校ID
        $contents = I("contents");//视频描述
        $video = I("videoname");//视频
        $videolist = array_filter(explode(",",$video));
        foreach ($classlist as $value) {
            $classid =$value;//班级ID
            foreach ($videolist as $v) {
               $videoname = $v;//视频
                $dataarray = array(
                    'title'=>$title,
                    'userid'=>$user_id,
                    'content'=>$contents,
                    'videoname'=>$videoname,
                    'classid'=>$classid,
                    'schoolid'=>$schoolid,
                    'create_time'=>time()
                );
                $result = M("school_video")->add($dataarray);
            }
        }

        if($result){
            echo json_encode(array('success'=>1,"date"=>"上传成功"));
        }else{
            echo json_encode(array('success'=>2,"date"=>"上传失败"));
        }

    }

    /*
      *视频监控,视频列表
      */
    public function class_video()
    {
        $stu_sch_name = $_SESSION["school_name"];//学校名称
        $this->assign("schoolname",$stu_sch_name);

        $userid = $_SESSION["userid"];
        $post_data = "?&id=".$userid."&type=1";
        $this_header = array("application/x-www-form-urlencoded; charset=gbk");
        $url = 'http://up.zhixiaoyuan.net/index.php/Apps/Test/getVideoListWebByClassId';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this_header);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($ch);
       // echo $result;

        //dump(json_decode($result,true));
        $video = json_decode($result,true);

        if($video["status"]=="success"){
            $videolist = $video["data"]["device"]; //视频列表
            //dump($videolist);
            $this->assign('videolist',$videolist);

            $start_time = strtotime(date("Y-m-d",intval(time()))." ".$video["data"]["start_time"])*1000;
            $end_time = strtotime(date("Y-m-d",intval(time()))." ".$video["data"]["end_time"])*1000;
            $days = $video["data"]["days"];
            $this->assign('start_time',$start_time);
            $this->assign('end_time',$end_time);
            $this->assign('etime',$video["data"]["end_time"]);
            $this->assign('stime',$video["data"]["start_time"]);
            $this->assign('days',$days);
            //$this->assign('video',$video);
        }

        $this->display();


}

    /*
     *监控详情
     */
    public function video_details()
    {
        $videoname = I("videoname");//视频地址
        $name = I("name");//视频名称
        $start_time = I("start_time");//视频开始时间
        $end_time = I("end_time");//视频结束时间
        $this->assign('videoname',$videoname);
        $this->assign('name',$name);
        $this->assign('start_time',$start_time);
        $this->assign('end_time',$end_time);
        $this->display("videojs");
    }

    public function video_detailsss()
    {
        $videoname = I("videoname");//视频地址
        $this->assign('videoname',$videoname);
        $this->display("gfdemo");
    }
}
?>