<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
session_start();
header( 'Content-Type:text/html;charset=utf-8 ');
class ChatController extends WeixinbaseController
{
    function _initialize() {

        $this->wxtuser = D("Common/wxtuser");
        $this->chat = D("Common/chat");
        $this->chat_list = D("Common/chat_list");
        $this->chat_group =D("Common/chat_group");
        $this->chat_group_person = D("Common/chat_group_person");

    }
    //先做
   public function index()
   {
     //根据userid  获取huanxinid   todo得加上schoolid  teacherid  来区分，这个先稍等以后的问题

       $userid = I("userid");

       $huanxinid  = $this->wxtuser->where(array("id"=>$userid))->field("id,huanxinid")->find();


       $chat_list  = $this->xcGetChatListData($userid);


       foreach ($chat_list['data'] as &$value)
       {
           //群消息因为表限制 暂时做不了有几条未读的消息
           $chat_uid = $value['chat_uid'];
           if($value['type']!=1)
           {

               //获取该用户所发的信息

               $value['unread_message'] = $this->chat->where(array("send_uid"=>$chat_uid,"receive_uid"=>$value['uid'],"status"=>1))->count();

               $value['from_huainxin'] = $this->wxtuser->where(array("id"=>$chat_uid))->getField("huanxinid");

           }else{
               $value['unread_message'] = $this->chat->where(array("send_uid"=>$chat_uid,"status"=>1))->count();

               $value['from_huainxin'] = $this->chat_group->where(array("id"=>$chat_uid))->getField("hx_groupid");

           }



       }




       $this->assign("huanxinid",$huanxinid['huanxinid']);
       $this->assign("chat_list",$chat_list['data']);
       $this->display();
   }




   //聊天页面    点击来之后要将该用户下的所有信息改为已读
   public function chat()
   {
       //接收者状态 todo 此时的聊天对象已发生该表,接收者发送时,成为发送者,发送者为接收者
       $send_uid = I('send_uid');//拉的时候send_uid永远是自己的

       $receive_uid = I('chat_uid');

       $huanxin = $this->wxtuser->where(array("id"=>$send_uid))->getField("huanxinid");

       //接收者状态 todo 此时的聊天对象已发生该表,接收者发送时,成为发送者,发送者为接收者
       $receive_type = I("receive_type");
       //发送者状态
       $send_type = I("send_type");

       $receiver_type=intval(I('type'));

       //聊天页面    点击来之后要将该用户下的所有信息改为已读


       if($receiver_type==1)
       {
           $this->edit_chat_read($receive_uid,$send_uid);
       }else{
           $this->edit_chat_read($send_uid,$receive_uid);
       }



      //获取对象聊天
       $receive_name = $this->get_receive_name($receive_uid,$receiver_type);
       //获取聊天记录
       $result = $this->xcGetChatData($send_uid,$receive_uid,'',$receiver_type);


       $this->assign("receive_type",$send_type);
       $this->assign("huanxin",$huanxin);
       $this->assign("send_type",$receive_type);
       $this->assign("type",$receiver_type);
       $this->assign("receive_name",$receive_name);
       $this->assign("receive_uid",$receive_uid);
       $this->assign("send_uid",$send_uid);
       $this->assign("chat_record",$result);
       $this->display();
   }




   //获取聊天对象名称

    public function get_receive_name($receive_uid,$receiver_type)
    {
         if($receiver_type==1)
         {
             $name = $this->chat_group->where("id = $receive_uid")->getField("title");

         }else{
             $name = M("wxtuser")->where("id = $receive_uid")->getField("name");
         }

        return $name;
    }

    function urlsafe_b64decode($string) {
        $data = str_replace(array('-','_'),array('+','/'),$string);
        $mod4 = strlen($data) % 4;
        if ($mod4) {
            $data .= substr('====', $mod4);
        }
        return base64_decode($data);
    }

    //拉取聊天信息
    public function xcGetChatData($send_uid,$receive_uid,$index,$receiver_type){




//        $send_uid = I('send_uid');//拉的时候send_uid永远是自己的
//        $receive_uid = I('receive_uid');
//        $receiver_type=intval(I('type'));
//        $index = I('index');
        $res = $this->getChatData($send_uid,$receive_uid,$index,$receiver_type);

        if ($res){
            // $receiveUserData = $this->getUserDataById($receive_uid);
            $ids = array();
            foreach ($res as &$val){
                $sendUserData = $this->getUserDataById($val['send_uid']);
                $val['send_face'] = @$sendUserData['photo'];
                $val['send_nickname'] = @$sendUserData['name'];

                if($val['recive_type']==2){
                    //群聊,获取群聊的内容
                    $groupData = $this->getGroupDataById($val['receive_uid']);
                    $val['receive_face'] = 'chatdefault.png';//@$receiveUserData['photo'];
                    $val['receive_nickname'] = @$groupData['title'];

                }else{
                    // var_dump($val['chat_uid']);
                    $receiveUserData = $this->getUserDataById($val['receive_uid']);
                    $val['receive_face'] = @$receiveUserData['photo'];
                    $val['receive_nickname'] = @$receiveUserData['name'];

                }
                if ($send_uid != $val['send_uid']){
                    $ids[] = $val['id'];
                }
                unset($val);
            }
            //更新状态为已经拉取过了
            if (!empty($ids)){
                // $this->mApi->updateChatStatusByIds($ids,2);
                // $this->mApi->updateChatListStatusByLastChatIds($ids,2);
            }
        }
       return $res;
    }

    //获取聊天信息
    function getChatData($uid, $chat_uid, $index,$type=0){


        if($type==1){
            $where='(receive_uid = '.$chat_uid.')';
            // var_dump($where);

        }else{
            $where='(send_uid='.$uid .' and receive_uid = '.$chat_uid.') or (send_uid='.$chat_uid .' and receive_uid = '.$uid.')';

        }

        $data = M('chat')->where($where)->order('id desc')->select();
        if ($data) {
            foreach ($data as &$chat) {
                //content的解码
                $realcontent=$this->urlsafe_b64decode($chat['content']);
                if(!empty($realcontent)){
                    $chat['content']=$realcontent;
                }
                unset($chat);
            }
            usort($data, function($a,$b){
                if ($a['create_time'] == $b['create_time']) {
                    return 0;
                }
                return ($a['create_time'] < $b['create_time']) ? -1 : 1;
            });
        }

        return $data;
    }

    public function xcGetChatListData($uid){
        $Message =  A('Apps/Message');
//        $res = $Message->getChatListData($uid);
        $res = $this->getChatListData($uid);


        if ($res){
            foreach ($res as &$val){
                $sendUserData = $Message->getUserDataById($val['uid']);

                $readstatus =$Message->getLastChatReadState($val['uid'],$val['chat_uid']);
                //content的解码
                $realcontent=$this->urlsafe_b64decode($val['last_content']);
                if(!empty($realcontent)){
                    $val['last_content']=$realcontent;
                }
                // var_dump($sendUserData);
                $val['my_face'] = @$sendUserData['photo'];
                $val['my_nickname'] = @$sendUserData['name'];
                if($val['type']==1){
                    //群聊,获取群聊的内容
                    $groupData = $this->getGroupDataById($val['chat_uid']);
                    $val['other_face'] = 'chatdefault.png';//@$receiveUserData['photo'];
                    $val['other_nickname'] = @$groupData['title'];

                }else{
                    $receiveUserData = $this->getUserDataById($val['chat_uid']);

                    $val['other_face'] = @$receiveUserData['photo'];
                    $val['other_nickname'] = @$receiveUserData['name'];

                }


                $time = time() -  $val['create_time'];
                $day = $time/86400;
                if ($day < 1){
                    $hour = round($time/3600);
                    if ($hour >=1){
                        $val['create_time'] = $hour.'小时前';
                    }else{
                        $second = round($time/60);
                        if($second>=1){

                            $val['create_time'] = $second.'分钟前';
                        }else{
                            $val['create_time'] = '刚刚';
                        }
                    }
                }else{
                    $val['create_time'] = round($day).'天前';
                }
                unset($val);
            }
            $ret = $this->format_ret(1,$res);
        }else{
            $ret = $this->format_ret(0,'您没有私聊数据');
        }
      return $ret;
    }

    function getChatListData($uid){
        $data = array();
        $where = array(
            'uid'=>$uid
        );
        $query=M('chat_list')->alias('c')
            ->join("".C("Pre"))->where($where)->order('last_chat_id desc')->select();

        foreach ($query as &$chat) {

            if(!$chat['type'])
            {
                $where = array(
                    'uid'=>$chat['chat_uid'],
                    'chat_uid'=>$chat['uid'],
                    'type'=>0
                );
                $chat_content=M('chat_list')->alias('c')
                    ->join("".C("Pre"))->where($where)->order('last_chat_id desc')->find();

                if($chat_content['create_time'] > $chat['create_time'])
                {
                    $chat['content'] = $chat_content['content'];
                }

            }
            //content的解码
            $realcontent=$this->urlsafe_b64decode($chat['content']);
            if(!empty($realcontent)){
                $chat['content']=$realcontent;
            }
            unset($chat);
        }

        return $query;
    }


    //根据ID获取群聊的资料
    function getGroupDataById($id){
        $where = array('id'=>$id);
        $query =M('chat_group')->where($where)->find();// $this->db->get_where($this->_user,$where);
        return $query;
    }
    //根据id获取用户资料
    function getUserDataById($id){

        $where = array('id'=>$id);
        $query =M('wxtuser')->where($where)->find();// $this->db->get_where($this->_user,$where);
        // $data = array();
        // if ($query->num_rows () > 0) {
        //     $data = $query->row_array ();
        // }
        return $query;
    }

    //发送消息
    public function send_message()
    {
        $Message =  A('Apps/Message');
        //发送者者id
        $send_uid = I("send_uid");
        //接收者id
        $receive_uid = I("receive_uid");
       //发送者者状态
        $send_type = I("send_type");
        //接收者者状态
        $receive_type = I("receive_type");

        $type = I("type");
        //内容
        $content = $Message->urlsafe_b64encode((I('content')));

        //插入聊天表
        $res = $this->insertChatData($send_uid,$receive_uid, $content,$send_type,$receive_type,$type);

        if($res)
        {
         $info['status'] =true;
         $info['msg'] ='发送成功';
         //调用环信推送接口
         $this->hx_send($send_uid,$receive_uid,$content,$type);

        }else{
            $info['status'] =false;
            $info['msg'] ='发送失败';
        }
      echo json_encode($info);

    }

    //插入聊天信息
    function insertChatData($uid=0, $chat_uid=0, $content="",$send_type=1,$recive_type=1,$type){
        if($uid && $chat_uid){
            $data = array(
                'send_uid' => $uid,
                'receive_uid' => $chat_uid,
                'send_type' => $send_type,
                'recive_type' => $recive_type,
                'content' => $content,
                'create_time' => time()
            );
            $lastChatId= M('chat')->add($data);
            if($lastChatId){
                //插入聊天列表或者更新最后一条信息
                $lastwhere['send_uid']=$uid;
                $lastwhere['receive_uid']=$chat_uid;
                // var_dump($lastwhere);
                // var_dump($lastChatId);
                // $lastChat=  M('chat')->where($lastwhere)->field('id')->order('id desc')->limit(1)->find;
                // $lastChatId=$lastChat['id'];
                // var_dump($lastChat);
                // die($lastChatId);
//                $this->updateChatList($uid, $chat_uid, $content, $lastChatId,$send_type,$recive_type,$type);
                 $this->updateChatList($chat_uid, $uid, $content, $lastChatId,$type);
                $realcontent=$this->urlsafe_b64decode($data['content']);
                if(!empty($realcontent)){
                    $data['content']=$realcontent;
                }
                return $data;
            }
        }
        return false;
    }
    function updateChatList($chatUid,$uid,$content,$lastChatId,$type){

        //如果有这个信息 就更新最后一条内容和状态为未读就可以了
        $query = M('chat_list')->where(array('uid'=>$uid, 'chat_uid'=>$chatUid))->order('create_time desc')->find();//$this->db->get_where($this->_chatList , array('uid'=>$uid, 'chat_uid'=>$chatUid) );

        if ($query) {
            // $data = $query->row_array();
            $id = $query['id'];
            // var_dump($query);
            // $this->db->where('id',$id);


            if($type==1)
            {
                $insertwhere['chat_uid']=$chatUid;
            }else{
                $insertwhere['id']=$id;
            }

            M('chat_list')->where($insertwhere)->save(array('last_content'=>$content,'last_chat_id'=>$lastChatId,'create_time'=>time(),'status'=>1));
            // $this->db->update($this->_chatList, array('last_content'=>$content,'last_chat_id'=>$lastChatId,'status'=>1) );
        }else{
            //如果没有，那么插入
            $insert = array(
                'uid' => $uid,
                'chat_uid' => $chatUid,
                'last_content' => $content,
                'last_chat_id' => $lastChatId,
                'create_time' => time()
            );
            M('chat_list')->add($insert);
            // $this->db->insert($this->_chatList, $insert);
        }
    }
    //环信接口

    public function hx_send($send_uid,$receive_uid,$content,$type)
    {
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
        if($type==1)
        {
            $target_type = "chatgroups";
            $receiver = $this->chat_group->where(array("id"=>$receive_uid))->getField("hx_groupid");

            //获取接收者的环信id
            $sender = $this->wxtuser->where(array("id"=>$send_uid))->getField("huanxinid");

        }else{
          //如果为单聊的话
             //获取发送者者的环信id
            $sender = $this->wxtuser->where(array("id"=>$send_uid))->getField("huanxinid");

            //获取接收者的环信id
            $receiver = $this->wxtuser->where(array("id"=>$receive_uid))->getField("huanxinid");
            $target_type = "users";

        }
        

        $Hxcall->hx_send($sender,$receiver,$this->urlsafe_b64decode($content),$target_type);

    }


    //获取环信id

    public function hx_id()
    {
        $id = I("id");

        $type = I("type");

        if($type!=1)
        {

            $hx_id = $this->wxtuser->where(array("id"=>$id))->getField("huanxinid");

        }else{

            $hx_id = $this->chat_group->where(array("hx_groupid"=>$id))->getField("hx_groupid");
        }

        if($hx_id)
        {
            $res = $this->format_ret(1,$hx_id);
        }else{
            $res = $this->format_ret(0,'获取失败');
        }
        echo json_encode($res);
    }
    //修改信息
    public function edit_chat_read($send_uid = "",$receive_uid = "")
    {

        if(!$send_uid && !$receive_uid)
        {

            //发送者id
            $send_hx = I("send_hx");

            $receive_hx = I("receive_hx");

            //区分是群聊还是单聊
            $type = I("type");

            //获取发送者环信id
            $send_uid = $this->wxtuser->where(array("huanxinid"=>$send_hx))->getField("id");

            if($type==1)
            {
                $receive_uid = $this->chat_group->where(array("hx_groupid"=>$receive_hx))->getField("id");
            }else{
                $receive_uid = $this->wxtuser->where(array("huanxinid"=>$receive_hx))->getField("id");
            }
            //将聊天信息修改为已接收
            $this->chat->where(array("send_uid"=>$send_uid,"receive_uid"=>$receive_uid))->save(array("status"=>2));
            //将会话列表页修改为已读
            $this->chat_list->where(array("uid"=>$send_uid,"chat_uid"=>$receive_uid))->save(array("status"=>2));
        }


        //将聊天信息修改为已接收
        $this->chat->where(array("send_uid"=>$receive_uid,"receive_uid"=>$send_uid))->save(array("status"=>2));
        //将会话列表页修改为已读
        $this->chat_list->where(array("uid"=>$send_uid,"chat_uid"=>$receive_uid))->save(array("status"=>2));


        $info['status'] ='success';
        echo json_encode($info);
    }

    public function get_user_chat()
    {
        //发送者id

        $send_hx = I("send_hx");


        $receive_hx = I("receive_hx");
        if($send_hx && $receive_hx)
        {
            $send_content =  $this->wxtuser->where(array("huanxinid"=>$send_hx))->field("id,huanxinid,name,photo")->find();

            $receive_uid = $this->wxtuser->where(array("huanxinid"=>$receive_hx))->getField("id");

            $chat_list = $this->chat_list->where(array("uid"=>$receive_uid,"chat_uid"=>$send_content['id']))->find();

            $chat_list['from_huainxin'] = $send_hx;
            $chat_list['other_nickname'] = $send_content['name'];
            $chat_list['my_face'] = $send_content['photo'];

            if($chat_list)
            {
                $res = $this->format_ret(1,$chat_list);
            }else{
                $res = $this->format_ret(0,'error');
            }

            echo json_encode($res);
        }else{
            echo "数据有误！";
        }

    }

    //获取群组聊天
    public function get_group_chat()
    {

        //接收者
        $userid = "2433";
        //环信群id
        $receive_hx = I("receive_hx");
        if($receive_hx)
        {
//            $send_content =  $this->wxtuser->where(array("huanxinid"=>$userid))->field("id,huanxinid,name,photo")->find();

            $receive_uid = $this->chat_group->where(array("huanxinid"=>$receive_hx))->field("id,title")->find();

            $chat_list = $this->chat_list->where(array("uid"=>$receive_uid['id'],"chat_uid"=>$userid))->find();

            $chat_list['other_nickname'] = $receive_uid['title'];

            if($chat_list)
            {
                $res = $this->format_ret(1,$chat_list);
            }else{
                $res = $this->format_ret(0,'error');
            }

            echo json_encode($res);
        }else{
            echo "数据有误！";
        }
    }

    public function create()
    {

        $userid = "2433";

        $group_type = I("group_type");

        $huanxinid = I("huanxinid");

        $this->assign("group_type",$group_type);
        $this->assign("huanxinid",$huanxinid);
        $this->display();
    }

    public function create_post()
    {
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
       //先写死
        $userid = "2433";
        $schoolid = 7;

        $option = I("option");

        if($option['public']==1)
        {
            $option['public'] = true;
        }else{
            $option['public'] = false;
        }
        if($option['approval']==1)
        {
            $option['approval'] = true;
        }else{
            $option['approval'] = false;
        }

        //0为家长群 1为教师群
        $type = I("type");


        //调用环信添加群组接口
        $add_group  =  json_decode($Hxcall->createGroups($option));
        //将对象转换成数组
        $groupid = get_object_vars($add_group->data);

        if($groupid)
        {
            $data['send_uid'] =$userid;
            $data['send_type'] = $type;
            $data['title'] = $option['groupname'];
            $data['schoolid'] = $schoolid;
            $data['hx_groupid'] = $groupid['groupid'];
            $data['create_time'] = time();

            $add_post = $this->chat_group->add($data);


            $res = $this->format_ret(1,$groupid);

        }else{
            $res = $this->format_ret(0,"创建分组失败");
        }

       echo json_encode($res);
    }
    //群详情页
    public function createdetail()
    {
        //$schoolid = $_SESSION['schoolid'];
        $schoolid = 7;
        //群组id
        $groupid = I("groupid");


        $group = $this->chat_group->where(array("id"=>$groupid))->find();
         //查询出群组老师
        $teacher_group = $this->chat_group_person
                       ->alias("person")
                       ->join("wxt_teacher_info info ON info.teacherid=person.personid")
                       ->where(array("info.schoolid"=>$schoolid,"person.type"=>1,"person.groupid"=>$groupid))
                       ->field("info.teacherid,info.name")
                       ->select();
        //查询出群组学生
        $student_group = $this->chat_group_person
            ->alias("person")
            ->join("wxt_student_info info ON info.userid=person.personid")
            ->where(array("info.schoollid"=>$schoolid,"person.type"=>0,"person.groupid"=>$groupid))
            ->field("info.userid,info.stu_name")
            ->select();
        $this->assign("teacher_group",$teacher_group);
        $this->assign("student_group",$student_group);
        $this->assign("type",$group['send_type']);
        $this->assign("group_name",$group['title']);
        $this->assign("count",$this->chat_group_person->where(array("groupid"=>$groupid))->count());
        $this->assign("groupid",$groupid);
        $this->display();
    }

    //修改群名称
    public function group_name()
    {
        $groupid = I("groupid");

        $group_name = $this->chat_group->where(array("id"=>$groupid))->getField("title");



        $this->assign("group_name",$group_name);
        $this->assign("groupid",$groupid);
        $this->display();
    }

    public function group_name_post()
    {
        $groupid = I("groupid");
        $group_name = I("group_name");


        $edit = $this->chat_group->where(array("id"=>$groupid))->save(array("title"=>$group_name));

      echo  "<script type='text/javascript'>window.location.assign('createdetail.php?groupid=$groupid');
            confirm('修改成功');
        </script>";


    }

    //增加群聊人员
    public function addPerson()
    {
        //先写死测试用的,上传时获取的是session里的schoolid
        $schoolid = 7;

        $groupid = I("groupid");

        $type = I("type");

        if($type==1)
        {
            //如果为老师
            //根据群组id和状态查询出人员
            $person = $this->get_group_person($groupid,$type);
            //拉取出该学校的所有老师
            $detail = M("teacher_info")->where(array("schoolid"=>$schoolid))->field("teacherid,name")->select();
            foreach($detail as &$value)
            {
                $value['_is_checked'] = $this->_is_checked($value['teacherid'],$person);
            }

        }else{
            //如果为学生
            $detail = $this->get_class_student();

            $person = $this->get_group_person($groupid,$type);

            foreach($detail as &$value)
            {
                $i = 0;
                foreach($value['student'] as &$val) {
                        $is_is_checked = $this->_is_checked($val['userid'],$person);
                        $val['_is_checked'] = $is_is_checked;
                        if($is_is_checked)
                        {
                            $i++;
                        }
                    }
                if($i==count($value['student']) && count($value['student'])!=0)
                {
                    $value['_is_checked'] = true;
                }
            }

        }
        $this->assign("groupid",$groupid);
        $this->assign("type",$type);
        $this->assign("detail",$detail);
        $this->display();

    }

    public function edit_group_person()
    {
        $type = I("type");
        $groupid = I("groupid");


        $userid = I("personid");
        //如果为老师
        if($type==1)
        {
            //查出原来的数据来比较
          //删除原有的
            $person = $this->get_group_person($groupid,$type);

            $del = $this->get_auth_del($userid,$person,$groupid,$type);

            $add = $this->get_auth_arr($userid,$person,$groupid,$type);

        }else{
        //为学生
            $person = $this->get_group_person($groupid,$type);

            $del = $this->get_auth_del($userid,$person,$groupid,$type);

            $add = $this->get_auth_arr($userid,$person,$groupid,$type);
        }
        $res = $this->format_ret(1,$groupid);
        echo json_encode($res);
    }


    //获取群组人员
    private function get_group_person($groupid,$type)
    {

       if($groupid)
       {
           $person =  $this->chat_group_person->where(array("groupid"=>$groupid,"type"=>$type))->field("personid")->select();

           foreach($person as $val)
           {
               $arr[] = $val['personid'];
           }
       }else{
           return false;
       }
       return $arr;
    }
    //获取要删除用户
    private function  get_auth_del($userid,$person,$groupid,$type)
    {
        if(!$userid && !$person)
        {
            return false;
        }
        $arr_del= array();
        //获取要删除的功能
        foreach ($person as $value)
        {
            if(!in_array($value,$userid))
            {
                array_push($arr_del,$value);
            }
        }
       if($arr_del)
       {
           //删除 该用户的所有消息会话以及退出环信群组
                   $this->out_group_chat($arr_del,$groupid,$type);
       }
    }
    //删除 该用户的所有消息会话以及退出环信群组
    private function out_group_chat($personid,$groupid,$type)
    {
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
        $hx_groupid = $this->chat_group->where(array("id"=>$groupid))->getField("hx_groupid");
        if($type!=1)
        {
           //如果为学生
            $teacher_user  = implode(",",$this->get_parentid($personid));
        }else{
            $teacher_user  = implode(",",$personid);
        }





        $where['id'] = array("in",rtrim($teacher_user, ","));

        $huanxin = $this->wxtuser->where($where)->field("huanxinid")->select();


        $teacher_huanxin = $this->dir_array($huanxin);


        $user_huanxin  = implode(",",$teacher_huanxin);
        //调用环信群组接口移除用户
        $result =  $Hxcall->delGroupsUser($hx_groupid,$user_huanxin);
        //删除群组明细表
        if($type!=1)
        {
            $where_detail['personid'] = array("in",implode(",",$personid));
        }else{
            $where_detail['personid'] = array("in",$teacher_user);
        }
        $where_detail['groupid'] = $groupid;
        $where_detail['type'] = $type;

        $this->chat_group_person->where($where_detail)->delete();
        //删除会话列表
        $where_list['uid'] = array("in",$teacher_user);
        $where_list['chat_uid'] = $groupid;
        $this->chat_list->where($where_list)->delete();
    }
    //获取要增加用户
    private function  get_auth_arr($userid,$person,$groupid,$type)
    {
     dump($groupid);
        if(!$userid && !$person)
        {
            return false;
        }

        $arr_add = array();

        foreach ($userid as $val_del)
        {
            if (!in_array($val_del, $person)) {
                array_push($arr_add, $val_del);
            }
        }

        if($arr_add)
        {
            //删除 该用户的所有消息会话以及退出环信群组
            $this->add_group_chat($arr_add,$groupid,$type);
        }

    }

    private function add_group_chat($personid,$groupid,$type)
    {
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
        $hx_groupid = $this->chat_group->where(array("id"=>$groupid))->getField("hx_groupid");

        if($type!=1)
        {
            //如果为学生

//            $personid = $this->get_parentid($personid);

            $teacher_user  = implode(",",$this->get_parentid($personid));
        }else{
            $teacher_user  = implode(",",$personid);
        }


        $where['id'] = array("in",rtrim($teacher_user, ","));

        $huanxin = $this->wxtuser->where($where)->field("huanxinid")->select();


        $users_huanxin = $this->dir_array($huanxin);


        //加入环信群组
           $result =  json_decode($Hxcall->addGroupsUser($hx_groupid,$users_huanxin));

           if($type!=1)
           {
               $this->add_person_list(array_unique($this->get_parentid($personid)),$hx_groupid);
           }else{
               //插入回话列表群
               $this->add_person_list($personid,$hx_groupid);
           }
            //插入教师
            $this->add_person_detail($personid,$hx_groupid,$type);

    }


    public function addTeacher()
    {
        //先写死
        $schoolid = 7;
        //环信群标识
        $groupid = I("groupid");
        //拉取出该学校的老师
        $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->select();

        $this->assign("groupid",$groupid);
        $this->assign("teacher",$teacher);
        $this->display();
    }
    public function addParent()
    {
        //先写死
        $schoolid = 7;
        //环信群标识
        $groupid = I("groupid");
        //拉取出该学校的老师
        $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->select();

        $class = $this->get_class_student();


        $this->assign("groupid",$groupid);
        $this->assign("teacher",$teacher);
        $this->assign("class",$class);
        $this->display();
    }



    private function get_class_student($class = "")
    {

        if($class)
        {

        }else{
            //先写死
            $schoolid = 7;
            $class = M("school_class")->where("schoolid = $schoolid")->field("id,classname")->select();
            foreach($class as &$value)
            {
              $value['student']= M("class_relationship")
                          ->alias("rel")
                          ->join("wxt_student_info info ON info.userid=rel.userid")
                          ->where(array("rel.classid"=>$value["id"]))
                          ->field("info.userid,info.stu_name")
                          ->select();
            }
        }

        return $class;

    }

    function object_array($array) {
        if(is_object($array)) {
            $array = (array)$array;
        } if(is_array($array)) {
            foreach($array as $key=>$value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }

    public function  add_teacher_person()
    {
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
        $schoolid = 7;

       $groupid =I("groupid");

        $personid = I("personid");

        //环信接口一次最多添加60个用户
        if(count($personid) > 60)
        {
            $res = $this->format_ret(0,"一次最多添加60人!");
            echo json_encode($res);
            exit();
        }

//        if(!$this->show_group_admin($personid,$groupid))
//        {
//            $res = $this->format_ret(0,"群主已经存在该群,请勿重复添加");
//            echo json_encode($res);
//            exit();
//        }

        //如果为所有老师
       if(I("allteacher"))
       {
          $personid = $this->get_school_teacher();
       }
       $teacher_user  = implode(",",$personid);

       $where['id'] = array("in",rtrim($teacher_user, ","));
       $huanxin = $this->wxtuser->where($where)->field("huanxinid")->select();

        $users_huanxin = $this->dir_array($huanxin);


        //加入环信群组
        $result =  json_decode($Hxcall->addGroupsUser($groupid,$users_huanxin));


       $is_addmember = get_object_vars($result->data);

;
       if($is_addmember['action']=="add_member")
       {
           //插入回话列表群
           $this->add_person_list($personid,$groupid);

           //插入群组群
           $this->add_person_detail($personid,$groupid,1);

           $res = $this->format_ret(1,"创建成功");
       }else{
           $res = $this->format_ret(0,"创建失败");
       }
        echo json_encode($res);

    }

    //群主已经存在该群,不能重复添加
    private function show_group_admin($personid,$groupid)
    {
      //获取群组id
      $userid = $this->chat_group->where(array("hx_groupid"=>$groupid))->getField("send_uid");

      if (in_array($userid, $personid)) {
            return false;
      }else{
          return true;
      }
    }

    //加入环信群组
    private function add_hx_group($personid)
    {

    }

     //家长群创建
    public function  add_parent_person()
    {
        vendor('Hxcall','','.class.php');
        $Hxcall = new \Hxcall();//实例化，注意加\
        $groupid =I("groupid");
        $schoolid = 7;
        $teacherid = I("teacherid");

        $studentid = I("student");


       if(!$teacherid )
       {
           $res = $this->format_ret(0,"请选择老师");
           echo json_encode($res);
           exit();
       }
        if(!$studentid )
        {
            $res = $this->format_ret(0,"请选择学生");
            echo json_encode($res);
            exit();
        }
        $count = $teacherid + $studentid;

        if(count($count) > 60)
        {
            $res = $this->format_ret(0,"一次最多添加60人!");
            echo json_encode($res);
            exit();
        }

        if($studentid)
        {
            $parentid = $this->get_parentid($studentid);
        }



        $userid =  implode(",",$count);


        $where['id'] = array("in",$userid);

        $huanxin = $this->wxtuser->where($where)->field("huanxinid")->select();

        $users_huanxin = $this->dir_array($huanxin);


        //加入环信群组
        $result =  json_decode($Hxcall->addGroupsUser($groupid,$users_huanxin));


        $is_addmember = get_object_vars($result->data);


        if($is_addmember['action']=="add_member")
        {
            //插入回话列表群
            $this->add_person_list($count,$groupid);
            //插入教师
            $this->add_person_detail($teacherid,$groupid,1);
            //插入学生
            $this->add_person_detail($studentid,$groupid,0);

            $res = $this->format_ret(1,"创建成功");

        }else{
            $res = $this->format_ret(0,"创建失败");
        }
        echo json_encode($res);

    }

    private function add_person_detail($personid,$groupid,$type)
    {

        if($personid && $groupid)
        {
            //根据环信id找出数据库群组自增id
            $group_id = $this->chat_group->where(array("hx_groupid"=>$groupid))->getField("id");
            foreach($personid as $val)
            {
                $data['groupid'] = $group_id;
                $data['personid'] = $val;
                $data['type'] = $type;
                $alldata[] = $data;
                unset($data);
            }

            $this->chat_group_person->addAll($alldata);
        }

    }
    //回去需要添加的家长成员
    private function get_parentid($studentid)
    {
       $student = implode(",",$studentid);

       $where['studentid'] = array("in",$student);
       $where['type'] = 1;

       $parent_id = M("relation_stu_user")->where($where)->field("userid")->select();

       foreach($parent_id as $value)
       {
           $arr[] = $value['userid'];
       }

       return $arr;

    }
   //将群消息添加到会话列表
    private function add_person_list($personid,$groupid)
    {
       $group_id = $this->chat_group->where(array("hx_groupid"=>$groupid))->getField("id");

        foreach($personid as $value)
        {
            $data['uid'] = $value;
            $data['chat_uid'] = $group_id;
            $data['type'] = 1;
            $data['last_content'] = $this->urlsafe_b64encode('邀请你加入群');
            $data['last_chat_id'] = 0;
            $data['create_time'] = time();
            $alldata[] = $data;
            unset($data);
        }
        $this->chat_list->addAll($alldata);
    }

    function urlsafe_b64encode($string) {
        $data = base64_encode($string);
        $data = str_replace(array('+','/','='),array('-','_',''),$data);
        return $data;
    }


    //获取有环信的人;
    private  function dir_array($huanxin)
    {
        if(!$huanxin)
        {
            $arr = $this->format_ret(0,"数据不存在！");


           return $arr;
        }

        foreach($huanxin as $value)
        {
            if($value['huanxinid'])
            {
                $arr[] = $value['huanxinid'];
            }
        }


        return $arr;
    }

    //获取所有老师
    public function get_school_teacher()
    {

        //先写死
        $schoolid = 7;
         //先获取teacherid     以后应该要改成  teacher_info里的id
        $teacher = M("teacher_info")->where(array("schoolid"=>$schoolid))->field("teacherid")->select();

       foreach ($teacher as $value)
       {
           $arr[] = $value['teacherid'];
       }
        return $arr;

    }
   //检查是否已经存在
    private function _is_checked($teacherid,$person) {

            if (in_array($teacherid, $person)) {
                return true;
            } else {
                return false;
            }


    }


    //参数获取(状态，原因)
    function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }

}