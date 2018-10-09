<?php

/**
 * 后台首页  信息审核
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class MessageModerationController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->microblog_model = D("Common/microblog_main");
        $this->school_model = D("Common/school");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->message_model = D("Common/user_message");
    }
    //信息审核首页
    public function index() {
        echo "信息审核";
    }
    public function blogCheck(){
//        echo "家校圈审核";
        $count=$this->microblog_model->where("status = 1")->count();
        $page = $this->page($count, 20);
        $microblog =$this->microblog_model
            ->where("status = 1")
            ->order("write_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //获取用户名称  获取学校名称  获取班级名称
        foreach($microblog as $key=>$value){
            $schoolid = intval($microblog[$key]['schoolid']);
            $classid = intval($microblog[$key]['classid']);
            $userid = intval($microblog[$key]['userid']);
            $microblog[$key]['schoolname']=$this->school_model->where("schoolid = $schoolid")->getField('school_name');
            $microblog[$key]['classname']=$this->class_model->where("id = $classid")->getField('classname');
            $microblog[$key]['username']=$this->wxtuser_model->where("id = $userid")->getField('name');
            $microblog[$key]['content']=substr($microblog[$key]['content'],0,30)."...";
        }
        $this->assign("page", $page->show('Admin'));
        $this->assign("microblog",$microblog);
//        dump($microblog);
        $this->display("blogCheck");
    }
    public function deleteblog(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->microblog_model->where("mid=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function blog_detail(){
        $id=intval($_GET['id']);
        $blog = $this->microblog_model->where("mid = $id")->find();

        //获取用户信息
        $userid=intval($blog["userid"]);
        $schoolid=intval($blog["schoolid"]);
        $classid=intval($blog["classid"]);
        $blog['schoolname']=$this->school_model->where("schoolid = $schoolid")->getField('school_name');
        $blog['classname']=$this->class_model->where("id = $classid")->getField('classname');
        $blog['username']=$this->wxtuser_model->where("id = $userid")->getField('name');

        //获取博客图片
        $blog_id=intval($blog["mid"]);
        $blogpic=M('microblog_picture_url')->where("microblogid = $blog_id")->field("pictureurl")->select();
        $this->assign("blog",$blog);
        $this->assign("blogpic",$blogpic);
//        dump($blog);
        $this->display('blog_detail');
    }

    public function blogcontent(){
//        echo "家校圈内容";
        $this->display("release_blog");
    }
    function blogcontent_post(){

    }

//     public function teacherFSendCheck(){
// //        echo "老师群发信息审核";

//         $count=$this->message_model->where("message_type = 5")->count();
//         $page = $this->page($count, 20);
//         $mass_send = $this->message_model->where("message_type = 5")
//             ->order("message_time DESC")
//             ->limit($page->firstRow . ',' . $page->listRows)
//             ->select();
//         //获取发送人信息   和接收人名字
//         foreach ($mass_send as $key=>$value) {
//             $sendid=intval($mass_send[$key]['send_user_id']);
//             $userid_arr=explode(",",$mass_send[$key]['receive_user_id']);
//             //根据用户id获取用户资料
//             $mass_send[$key]['sendname']=$this->wxtuser_model->where("id = $sendid")->getField("name");
//             //获取接收人的名字
//             $mass_send[$key]['receivename']='';
//             foreach($userid_arr as $key2=>$value2){
//                 $resourcename[$key2] = $this->wxtuser_model->where("id = $userid_arr[$key2]")->getField("name");
//                 $mass_send[$key]['receivename']=$mass_send[$key]['receivename'].','.$resourcename[$key2];
//             }
//             $mass_send[$key]['receivename']=ltrim($mass_send[$key]['receivename'],',');
//         }
//         $this->assign("message",$mass_send);
//         $this->display("mass_sendCheck");
// //        dump($mass_send);
//     }
    function deletemess(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->message_model->where("message_id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function onlineResource(){
        echo "在线资源：睡前故事、有声读物、十万个为什么、儿歌精选、成语故事、绕口令、笑话与谜语、家庭；专辑分：儿歌、儿童小说、故事、启蒙、国学、英语等；区分幼儿、中小学，下发所有学校";
    }
    public function growKnowledge(){
        echo "成长知识：区分幼儿、中小学，下发所有学校";
    }
    public function popularize(){
        echo "推广信息";
    }
    public function systemnotice(){
        echo "系统公告：";
    }
    public function teacherFSendCheck(){
        if($_GET['start_time']){
            $data['start_time'] = $_GET['start_time'];
        }
        if($_GET['end_time']){
            $data['end_time'] = $_GET['end_time'];
        }
        $teachermessage_url = $_SERVER['HTTP_HOST']."t_webhome/index.php?g=Apps&m=Message&a=get_mass_message";
        $teachermessage_info_json = request_post($teachermessage_url,$data);
        $teachermessage_info_arr = json_decode($teachermessage_info_json,true);
        if($teachermessage_info_json && $teachermessage_info_arr['status']=="success"){
             $this->assign("teachermessage",$teachermessage_info_arr['data']);
        }
        $this->assign("start_time",$data['start_time']);
        $this->assign("end_time",$data['end_time']);
        $this->display("teacherFSendCheck");
    }
}

