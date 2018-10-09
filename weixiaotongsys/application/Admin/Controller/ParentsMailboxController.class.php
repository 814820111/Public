<?php

/**
 * 后台首页  家长信箱
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ParentsMailboxController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->comment_model = D("Common/teacher_comment");
        $this->message_model = D("Common/user_message");
        $this->wxtuser_model = D("Common/wxtuser");
      //  $this->users_model=D(("Common/users"));
        $this->users_model = D("Common/Users");
        $this->school_model = D("Common/school");
    }
    //家长信箱首页
    public function index()
    {


    }
    public function remarkbaseManage(){
        // echo "评语库管理：评语类别、添加修改评语"
        $count=$this->comment_model->where("comment_status = 1 or 0")->count();
        $page = $this->page($count, 20);
        $comment = $this->comment_model
            ->where("comment_status =1")
            ->order("comment_id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        foreach ($comment as $key => $value) {
            $teacher_id = intval($comment[$key]['teacher_id']);
            $studentid = intval($comment[$key]['studentid']);
            $comment[$key]['teacher_name'] = $this->wxtuser_model->where("id= $teacher_id")->getField('name');
            $comment[$key]['student_name'] = $this->wxtuser_model->where("id = $studentid")->getField('name');


        }
        $this->assign("page", $page->show());
       $this->assign("teacher_comment",$comment);

        $this->display("remarkbaseManage");



    }
    public function changeremark(){
        $comment_id = intval($_GET['comment_id']);
        if ($comment_id) {
            $rst = $this->comment_model->where(array("comment_id"=>$comment_id))->find();
         if ($rst) {
               $this->assign("teacher_comment",$rst);
                $this->display("changeremark");
            } else {
                $this->error('评论数据获取失败，请重试！');
            }
        }
        else {
            $this->error('数据传入失败！');
        }

    }
    public function changeremark_post(){
        if (IS_POST) {

            $data['comment_id']=$_POST['comment_id'];
            if(!empty($_POST['teacher_id'])){
                $data['teacher_id']=$_POST['teacher_id'];
            }
            if(!empty($_POST['studentid'])){
                $data['studentid']=$_POST['studentid'];
            }

            if(!empty($_POST['comment_content'])){
                $data['comment_content']=$_POST['comment_content'];
            }
            if($this->comment_model->save($data)){
                $this->success("保存成功！");
            }else{
                $this->error("保存失败！");
            } }else {
            $this->error("数据传输错误！");
        }
    }
    public function  newaddremark(){

        $comment=$this->comment_model
            ->field("comment_id,teacher_id,studentid,comment_time,comment_status,comment_content")
            ->where("comment_status=1")->select();
        $this->assign("teacher_comment",$comment);
        $this->display();
    }
    public function newaddremark_post()
    {

        if (IS_POST) {

            if($this->comment_model->create()){
                $teacher_comment['teacher_id']=$_POST['teacher_id'];

                $teacher_comment['studentid']=$_POST['studentid'];
                $teacher_comment['comment_time']=time();


                 $teacher_comment['comment_status']=1;
                  $teacher_comment['comment_content']=$_POST['comment_content'];
                     if($this->comment_model->add($teacher_comment)){
                         $this->success('添加成功');
                     }

                else{          $this->error('添加失败');
                }      }else{        $this->error($this->comment_model->getError());         }

        }
    }





    public function delete_comment(){
        $comment_id=intval($_GET['comment_id']);
        if ($comment_id) {
            $rst = $this->comment_model->where("comment_id=$comment_id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }
    public function messageManage(){
        $count=$this->message_model->where("message_type = 1 or 2 or 3 ")->count();
        $page = $this->page($count, 20);
        $user_message = $this->message_model
            ->where("message_type = 1 or 2 or 3")
            ->order("message_id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        foreach ($user_message as $key => $value) {
            $send_user_id = intval($user_message[$key]['send_user_id']);
            $receive_user_id = intval($user_message[$key]['receive_user_id']);
            $user_message[$key]['send_user_name'] = $this->wxtuser_model->where("id =$send_user_id")->getField('name');
            $user_message[$key]['receive_user_name'] = $this->wxtuser_model->where("id =$receive_user_id")->getField('name');


        }
        $this->assign("page", $page->show());
        $this->assign("user_message",$user_message);

        $this->display("messageManage");



    }


    public function  newaddmessage(){

        $user_message=$this->message_model
            ->field("message_id,send_user_id,receive_user_id,message_content,message_time,message_type")
            ->where("message_type=1 or 2 or 3")->select();
        $this->assign("user_message",$user_message);
        $this->display();
    }
    public function newaddmessage_post()
    {

        if (IS_POST) {

            if($this->message_model->create()){
                $user_message['message_id']=$_POST['message_id'];

                $user_message['send_user_id']=$_POST['send_user_id'];
                $user_message['receive_user_id']=$_POST['receive_user_id'];
                $user_message['message_content']=$_POST['message_content'];
                $user_message['message_time']=time();
                $user_message['message_type']=$_POST['message_type'];

                if($this->message_model->add( $user_message)){
                    $this->success('添加成功');
                }

                else{          $this->error('添加失败');
                }      }else{        $this->error($this->message_model->getError());         }

        }
    }

    public function changemessage(){

        $message_id = intval($_GET['message_id']);
        if ($message_id) {
            $rst = $this->message_model->where(array("message_id"=>$message_id))->find();
            if ($rst) {
                $this->assign("user_message",$rst);
                $this->display("changemessage");
            } else {
                $this->error('评论数据获取失败，请重试！');
            }
        }
        else {
            $this->error('数据传入失败！');
        }

    }
    public function changemessage_post(){
        if (IS_POST) {

            $data['message_id']=$_POST['message_id'];
            if(!empty($_POST['send_user_id'])){
                $data['send_user_id']=$_POST['send_user_id'];
            }
            if(!empty($_POST['receive_user_id'])){
                $data['receive_user_id']=$_POST['receive_user_id'];
            }

            if(!empty($_POST['message_content'])){
                $data['message_content']=$_POST['message_content'];
            }
            if(!empty($_POST['message_type'])){
                $data['message_type']=$_POST['message_type'];
            }
            if($this->message_model->save($data)){
                $this->success("保存成功！");
            }else{
                $this->error("保存失败！");
            } }else {
            $this->error("数据传输错误！");
        }
    }

    public function delete_message(){
        $message_id=intval($_GET['message_id']);
        if ($message_id) {
            $rst = $this->message_model->where("message_id=$message_id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        }
    }

   


    public function teacherInteraction(){
        echo "与老师互动：发送留言，留言历史；留言信息显示学校所属的代理商跟规模；留言区分有能力处理投诉的学校跟有总部处理的学校";
    }
    public function noticeManage(){
        echo "公告管理：公告发布，公告查询";
    }
    public function parentsInteraction(){
        echo "与家长互动：发送留言，电脑留言历史";
    }
    public function messageSet(){
        echo "短信设置：学校短信监控设置(老师群发信息,园长及校长关键人的可以收到 老师群发的内容)；短信下发需要后台配置开关，权限到学校，对每个学校下发短信开关";
    }
    public function FutureTXT(){
        echo "定时短信监控：定时短信，历史定时短信；定期下发天气预报、可以从第三方系统取天气预报";
    }
    public function upmessageManage(){
        echo "上行短信管理：用户上线后，短信网关可以根据上行的号码转到哪个老师手机上";
    }
    public function messageSelect(){
        echo "信息查询功能：教师发出信息查询，教师收到的信息，家校互动短信明细查询，家校互动历史短信查询";
    }
    public function ToBeconfirm(){
        echo "待确认短信：前台待确认短信，OA待确认短信";
    }
    public function parentsInteractionLog(){
        echo "家长互动日志";
    }
    public function messageTemplate(){
        echo "短信模板设置：老师前台发送的模板在这里配置";
    }
    public function releaseSelect(){
        echo "内容信息发布查询：课堂动态 0课、班级圈 2次、宝宝作品 0人次、主题活动 0次、育儿知识 0篇";
    }

}

