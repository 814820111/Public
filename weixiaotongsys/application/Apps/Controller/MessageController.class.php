<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class MessageController extends AppBaseController {

   //获取用户发送的消息
    public function user_send_message(){
        $paging = $_GET["paging"];
        //$paging = 1;
        $num = 20;//每页显示记录条数
        $start_page = $num*($paging-1);// 每页第一条记录编号
        $send_user_id=0;
        if(!empty($_REQUEST["send_user_id"])){
            $send_user_id=$_REQUEST["send_user_id"];
        }
        //获取到的type值和发送人id
        $where_ands=empty($send_user_id)?array(""):array("a.send_user_id = $send_user_id");
        $fields=array(
                'start_time'=> array("field"=>"a.message_time","operator"=>">"),
                'end_time'  => array("field"=>"a.message_time","operator"=>"<"),
                // 'reception_user_name'  => array("field"=>"r.reception_user_name","operator"=>"like"),
        );
        if(IS_POST){
            
            foreach ($fields as $param =>$val){
                if (isset($_POST[$param]) && !empty($_POST[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_POST[$param];
                    $_GET[$param]=$get;
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }else{
            foreach ($fields as $param =>$val){
                if (isset($_GET[$param]) && !empty($_GET[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_GET[$param];
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }
        if(empty($_REQUEST['reception_user_name'])){
            //不限制接收人,获取到的reception_user_name为空
            $where= join(" and ", $where_ands);
            //如果不限制接收人
            // $count=M('user_message')
            // ->alias("a")
            // ->where($where)
            // ->count();
            // $page = $this->page($count, 20);
            $messages=M('user_message')
                ->alias("a")
                ->where($where)
//                ->limit($page->firstRow . ',' . $page->listRows)
                ->limit($start_page . ',' .$num)
                ->order("a.message_time DESC")
                ->select();
        }else{
            //如果限制接收人,获取到接收人姓名
            $reception_user_name = $_REQUEST['reception_user_name'];
            //将与获取到的名字相似的接收人姓名存到$where_ands数组中
            array_push($where_ands, "r.receiver_user_name like '%$reception_user_name%'");
            $where= join(" and ", $where_ands);
            $messages=M('user_message')
            ->alias("a")
            ->join("wxt_user_message_reception r ON a.id=r.message_id")//信息表id=接收信息人表message_id
            ->where($where)
            ->field('a.id,a.send_user_name,a.message_content,a.message_time')
           // ->limit($page->firstRow . ',' . $page->listRows)
            ->limit($start_page . ',' .$num)
            ->order("a.message_time DESC")
            ->select();
        }
        //获取接收人列表
        foreach ($messages as &$messageinfo) {
             $receiver=M('user_message_reception')
            ->alias("m")
            ->join("wxt_wxtuser r ON m.receiver_user_id=r.id")
            ->where(array("m.message_id"=>$messageinfo['id']))
            ->field('receiver_user_id,receiver_user_name,read_time,photo,phone')
            ->select();
            $messageinfo["receiver"]=$receiver;
            //赋值接收人数量
            $messageinfo["receiver_num"] = count($receiver);
            unset($messageinfo);
        }
        //获取图片列表
        foreach ($messages as &$messageinfo) {
             $picture=M('user_message')
            ->alias("m")
            ->join("wxt_user_message_pic p ON m.id=p.message_id")
            ->where(array("p.message_id"=>$messageinfo['id']))
            ->field('picture_url')
            ->select();
            $messageinfo["picture"]=$picture;
            for ($j=0; $j < count($picture); $j++) { 
                # code...
//                $imagesize = getimagesize("./uploads/microblog/".$picture[$j]["picture_url"]);
                $imagesize = getimagesize("/alidata/www/weixiaotong2016/uploads/microbloghub/".$picture[$j]["picture_url"]);
                $messageinfo["picture"][$j]["picturewidth"]=$imagesize["0"];
                $messageinfo["picture"][$j]["pictureheight"]=$imagesize["1"];
            }

            unset($messageinfo);
        }
        if($messages){
            $ret = $this->format_ret(1,$messages);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
    exit;     
    }
	 //获取用户发送的消息详情
    public function user_send_message_details(){
        $send_user_id=0;
        $message_id = I("message_id");
        if(!empty($_REQUEST["send_user_id"])){
            $send_user_id=$_REQUEST["send_user_id"];
        }
        //获取到的type值和发送人id
        $where_ands=empty($send_user_id)?array(""):array("a.send_user_id = $send_user_id and a.id=$message_id");
        $fields=array(
            'start_time'=> array("field"=>"a.message_time","operator"=>">"),
            'end_time'  => array("field"=>"a.message_time","operator"=>"<"),
            // 'reception_user_name'  => array("field"=>"r.reception_user_name","operator"=>"like"),
        );
        if(IS_POST){

            foreach ($fields as $param =>$val){
                if (isset($_POST[$param]) && !empty($_POST[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_POST[$param];
                    $_GET[$param]=$get;
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }else{
            foreach ($fields as $param =>$val){
                if (isset($_GET[$param]) && !empty($_GET[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_GET[$param];
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }
        if(empty($_REQUEST['reception_user_name'])){
            //不限制接收人,获取到的reception_user_name为空
            $where= join(" and ", $where_ands);
            //如果不限制接收人
            // $count=M('user_message')
            // ->alias("a")
            // ->where($where)
            // ->count();
            // $page = $this->page($count, 20);
            $messages=M('user_message')
                ->alias("a")
                ->where($where)
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order("a.message_time DESC")
                ->select();
        }else{
            //如果限制接收人,获取到接收人姓名
            $reception_user_name = $_REQUEST['reception_user_name'];
            //将与获取到的名字相似的接收人姓名存到$where_ands数组中
            array_push($where_ands, "r.receiver_user_name like '%$reception_user_name%'");
            $where= join(" and ", $where_ands);
            $messages=M('user_message')
                ->alias("a")
                ->join("wxt_user_message_reception r ON a.id=r.message_id")//信息表id=接收信息人表message_id
                ->where($where)
                ->field('a.id,a.send_user_name,a.message_content,a.message_time')
                ->limit($page->firstRow . ',' . $page->listRows)
                ->order("a.message_time DESC")
                ->select();
        }
        //获取接收人列表
        foreach ($messages as &$messageinfo) {
            $receiver=M('user_message_reception')
                ->alias("m")
                ->join("wxt_wxtuser r ON m.receiver_user_id=r.id")
                ->where(array("m.message_id"=>$messageinfo['id']))
                ->field('receiver_user_id,receiver_user_name,read_time,photo,phone')
                ->select();
            $messageinfo["receiver"]=$receiver;
            //赋值接收人数量
            $messageinfo["receiver_num"] = count($receiver);
            unset($messageinfo);
        }
        //获取图片列表
        foreach ($messages as &$messageinfo) {
            $picture=M('user_message')
                ->alias("m")
                ->join("wxt_user_message_pic p ON m.id=p.message_id")
                ->where(array("p.message_id"=>$messageinfo['id']))
                ->field('picture_url')
                ->select();
            $messageinfo["picture"]=$picture;
            for ($j=0; $j < count($picture); $j++) {
                # code...
//                $imagesize = getimagesize("./uploads/microblog/".$picture[$j]["picture_url"]);
                $imagesize = getimagesize("/alidata/www/weixiaotong2016/uploads/microbloghub/".$picture[$j]["picture_url"]);
                $messageinfo["picture"][$j]["picturewidth"]=$imagesize["0"];
                $messageinfo["picture"][$j]["pictureheight"]=$imagesize["1"];
            }

            unset($messageinfo);
        }
        if($messages){
            $ret = $this->format_ret(1,$messages);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
        return json_encode($ret);
    }
    //获取用户已接收的信息
public function user_reception_message(){
        //$paging = isset($_REQUEST['paging'])?$_REQUEST['paging']:'';
       $paging = $_GET["paging"];
        //$paging = 1;
        $num = 20;//每页显示记录条数
        $start_page = $num*($paging-1);// 每页第一条记录编号

        $receiver_user_id=Intval(I('receiver_user_id'));
        $receive=M('user_message_reception')
            ->alias("a")
            ->field("a.id,a.message_id,a.receiver_user_id,a.receiver_user_name,a.message_type,a.read_time")
            //->where("receiver_user_id=$receiver_user_id")
            ->where("receiver_user_id=$receiver_user_id")
            ->limit($start_page . ',' .$num)
            //->order("a.id DESC")
            ->order("a.id desc,a.read_time asc")
            ->select();
        foreach ($receive as &$send){
            $refid=$send['message_id'];
            $send_message=M('user_message')
                ->alias("u")
                ->join("wxt_wxtuser w ON w.id=u.send_user_id")
                ->field("u.id,u.schoolid,u.send_user_id,u.send_user_name,u.message_content,u.message_time,w.photo")
                //->where("u.id=$refid")
                ->where("u.id=$refid and u.send_type=1") //已发送
                ->order("message_time DESC")
                ->select();
            $send["send_message"]=$send_message;
            unset($send);
        }
        foreach ($receive as &$res_info) {
            $receiverid=$res_info['message_id'];
            $mes=M('user_message_reception')
                ->alias("u")
                ->join("wxt_wxtuser e ON u.receiver_user_id=e.id")
                ->field("message_id,receiver_user_id,receiver_user_name,read_time,photo,phone")
                ->where("u.message_id=$receiverid")
                ->select();
            $res_info['receiver']=$mes;
            //获取图片
            $pic=M('user_message_pic')->field("picture_url")->where("message_id=$receiverid")->select();
            $res_info['pic']=$pic;
            for ($j=0; $j < count($pic); $j++) {
                # code...
//                $imagesize = getimagesize("./uploads/microbloghub/".$pic[$j]["picture_url"]);
                $imagesize = getimagesize("/alidata/www/weixiaotong2016/uploads/microbloghub/".$pic[$j]["picture_url"]);
                $res_info['pic'][$j]["picturewidth"]=$imagesize["0"];
                $res_info['pic'][$j]["pictureheight"]=$imagesize["1"];
            }
            unset($res_info);
        }
        if($receive){
            $ret = $this->format_ret(1,$receive);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
        echo json_encode($ret);
        exit;
    }
	 //获取用户已接收的信息详情
    public function user_reception_message_details(){
        $receiver_user_id=Intval(I('receiver_user_id')); //用户ID
        $message_id = I('message_id'); //消息ID
        $receive=M('user_message_reception')
            ->alias("a")
            ->field("a.id,a.message_id,a.receiver_user_id,a.receiver_user_name,a.message_type,a.read_time")
            ->where("receiver_user_id=$receiver_user_id and message_id=$message_id")
            ->limit($page->firstRow . ',' . $page->listRows)
            //->order("a.id DESC")
//            ->order("a.id desc,a.read_time asc")
            ->select();
        foreach ($receive as &$send) {
            $refid=$send['message_id'];
            $send_message=M('user_message')
                ->alias("u")
                ->join("wxt_wxtuser w ON w.id=u.send_user_id")
                ->field("u.id,u.schoolid,u.send_user_id,u.send_user_name,u.message_content,u.message_time,w.photo")
                ->where("u.id=$refid")
                ->order("message_time DESC")
                ->select();
            $send["send_message"]=$send_message;
            unset($send);
        }
        foreach ($receive as &$res_info) {
            $receiverid=$res_info['message_id'];
            $mes=M('user_message_reception')
                ->alias("u")
                ->join("wxt_wxtuser e ON u.receiver_user_id=e.id")
                ->field("message_id,receiver_user_id,receiver_user_name,read_time,photo,phone")
                ->where("u.message_id=$receiverid")
                ->select();
            $res_info['receiver']=$mes;
            //获取图片
            $pic=M('user_message_pic')->field("picture_url")->where("message_id=$receiverid")->select();
            $res_info['pic']=$pic;
            for ($j=0; $j < count($pic); $j++) {
                # code...
//                $imagesize = getimagesize("./uploads/microbloghub/".$pic[$j]["picture_url"]);
                $imagesize = getimagesize("/alidata/www/weixiaotong2016/uploads/microbloghub/".$pic[$j]["picture_url"]);
                $res_info['pic'][$j]["picturewidth"]=$imagesize["0"];
                $res_info['pic'][$j]["pictureheight"]=$imagesize["1"];
            }
            unset($res_info);
        }
        if($receive){
            $ret = $this->format_ret(1,$receive);
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }
//        echo json_encode($ret);
        return json_encode($ret);
    }
    public function send_message(){
        //获取发送表中所需的字段值
        $data_send['send_user_id']=I('send_user_id');
        $data_send['schoolid']=I('schoolid');
        $data_send['send_user_name']=I('send_user_name');
        $data_send['message_content']=I('message_content');
        $data_send['message_time']=time();
        $usertype=Intval(I('usertype'));
        $send_ret=M('user_message')->add($data_send);
        //获取接收表中所需字段值,因获取到的是多个receiver_user_id,所以用explode函数拆分开
        $receive_user_id = I('receiver_user_id');
        $receiveid_arr=explode(",",$receive_user_id);
        //去掉数组中的空格位置
        $receiveid_arr = array_filter($receiveid_arr);
        //将拆分后的id用foreach和settype函数转换为单个int值
        foreach ($receiveid_arr as &$receiverid) {
            $receiver_id_info=$receiverid;
            $receiver_id=settype($receiver_id_info,"integer");
            //通过receive_user_id在user表中获取到对应的name
            $receivername=M('wxtuser')
                ->where("id=$receiver_id_info")
                ->field("name")
                ->find();
            $receiverinfo=$receivername;
            //将获取到的name数组通过foreach转换为字符串
            foreach ($receiverinfo as $re_name) {
                $rename=$re_name;
            }
            //将接收人id和姓名存入表中
            $data_re['message_id']=$send_ret;
            $data_re['receiver_user_id']=$receiver_id_info;
            $data_re['receiver_user_name']=$rename;
            $receive_ret=M('user_message_reception')->add($data_re);
        }
        //图片存入表中
        $pic_model=M('user_message_pic');
        $pic=I('picture_url');
        $pic_arr=explode(",",$pic);
        //去掉数组中的空格位置
        $pic_arr = array_filter($pic_arr);
        for ($i=0; $i < count($pic_arr); $i++) {
            $pic_model->add(array("message_id"=>$send_ret,"picture_url"=>$pic_arr[$i]));
        }
        if($send_ret){
//            $ret = $this->format_ret(1,'成功');
//           $ret = $this->format_ret($send_ret,'成功');
            $ret = array("id"=>$send_ret,"成功");
            //推送功能,判断推送给家长端还是教师端
            if($usertype == 1){
                $rs = $this->tjiguang("您收到一条新的消息,请注意查收!","message",$receiveid_arr,'',0);
            }else{
                $rs = $this->pjiguang("您收到一条新的消息,请注意查收!","message",$receiveid_arr,'',0);
            }
        }else{
            //$ret = $this->format_ret(0,'未获取到数据');
            $ret = array("id"=>0,"失败");
        }
        echo json_encode($ret);
        exit;
    }
    //用户读取消息时间
    public function read_message(){
        $message_id=I('message_id');
        $receiver_user_id=I('receiver_user_id');
        $data['read_time']=time();
        $new_time=M('user_message_reception')->where("message_id=$message_id AND receiver_user_id=$receiver_user_id")->save($data);
         if($new_time){
            $ret = $this->format_ret(1,'成功');
        }else{
            $ret = $this->format_ret(0,'未获取到数据');
        }  
        echo json_encode($ret);
    exit; 
    }
    public function jiguang(){
        $userid=I('userid');
        $umsg=I('content');
        $sound=I('sound');
        $key=I('key');
        $usertype=intval(I('usertype'));
        $userid_array = explode(',',$userid);
        //去掉数组中的空格位置
        $userid_array = array_filter($userid_array);
        if(!empty($userid)){
            $receive = array();
            foreach ($userid_array as $key => $value) {
                $receive['alias'][$key] = $value;
            }
        }else{
            $receive="";
        }
        if($usertype==1){
            $rs=$this->tjiguang($umsg,'system',$userid_array,$umsg,0);
        }else{
            $rs=$this->pjiguang($umsg,'system',$userid_array,$umsg,0);
        }
        
        if($rs){
            $ret="success";
        }else{
            $ret="error";
        }
        var_dump($ret);
        return $ret;

    }
    //教师端推送
    function tjiguang($content = "",$m_type='',$receive="",$m_value="",$m_usertype = 0){
        //查找用户对应的registrationid
        $recivelist = array();
        $ishave=0;
        foreach ($receive as &$userid) {
            $where['id']=$userid;
            $u=M('wxtuser')->where($where)->field('xgtoken')->find();
            if(!empty($u['xgtoken'])){
               $recivelist[]=$u['xgtoken']; 
               $ishave=1;
           }
       }
        if($ishave==1){
            $receiver = array('registration_id'=>$recivelist);
            $rs=tjpush($content,$m_type,$receiver,$m_value,0,$m_usertype);
            if($rs){
                $ret="success";
            }else{
                $ret="error";
            }
        }else{
            $ret="error";
        }
        return $ret;
    }
    //家长端推送
    function pjiguang($content = "",$m_type='',$receive="",$m_value="",$isparent = 0){
        $recivelist = array();
        $ishave=0;
        foreach ($receive as &$userid) {
            if($isparent){
                $where['id']=$userid;
                $u=M('wxtuser')->where($where)->field('xgtoken')->find();
                if(!empty($u['xgtoken'])){
                   $recivelist[]=$u['xgtoken']; 
                   $ishave=1;
                }
            }else{
                $plists=$this->GetParentTokenByStudentid($userid);
                if($plists){
                    foreach ($plists as &$parent) {
                        if(!empty($parent['xgtoken'])){
                           $recivelist[]=$parent['xgtoken']; 
                           $ishave=1;
                       }
                    }
                }
            }
            
        }
        if($ishave==1){
            $receiver = array('registration_id'=>$recivelist);
            $rs=ujpush($content,$m_type,$receiver,$m_value,1);
            if($rs){
                $ret="success";
            }else{
                $ret="error";
            }
        }else{
            $ret="error";
        }
        return $ret;
    }
    function GetParentTokenByStudentid($studentid)
    {
        if($studentid){
            $parent_model=M('wxtuser');

            $appellation_model=M('relation_stu_user');
            $lists=$appellation_model
            ->alias('a')
            ->join('wxt_wxtuser u on u.id=a.userid')
            ->field("u.xgtoken")
            ->where("a.studentid=$studentid")
            // ->fetchsql(true)
            ->select();
            return $lists;
        }else{
            return "";
        }
        return "";
    }
     function urlsafe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
    }
    function urlsafe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    return base64_decode($data);
    }
    public function UpdateGroupTitle(){
        $send_uid = I('uid');
        $groupid=I('groupid');
        $title = I('title'); 
        if(!$send_uid ){
            $ret = $this->format_ret(0,'参数错误');
            echo json_encode($ret);
            exit;
        }
        if(!$groupid ){
            $ret = $this->format_ret(0,'参数错误');
            echo json_encode($ret);
            exit;
        }
        if(empty($title)){
            $ret = $this->format_ret(0,'参数错误');
            echo json_encode($ret);
            exit;
        }
        $where['id']=$groupid;
        $where['send_uid']=$send_uid;
        $data['title'] =$title;
        $up=M('chat_group')->where($where)->save($data);
        if($up){
            $ret = $this->format_ret(1,$up);
        }else{
            $ret = $this->format_ret(0,'更新失败'); 
        }
        echo json_encode($ret);
        exit;

    }
    //创建群聊信息
    public function CreateGroupChat(){
        $send_uid = I('send_uid');
        $send_type=I('send_type');
        $title = I('title');
        if(!$send_uid ){
            $ret = $this->format_ret(0,'参数错误');
            echo json_encode($ret);
            exit;
        }
        $data = array(
            'send_uid' => $send_uid,
            'send_type' => $send_type,
            'title' => $title,
            'create_time' => time()
        );

        $lastChatId= M('chat_group')->add($data);
        if($lastChatId){
            $content='创建了群:'.$title;
            //添加会话列表
            $insert = array(
                'uid' => $send_uid,
                'chat_uid' => $lastChatId,
                'type' => 1,
                'last_content' => $this->urlsafe_b64encode($content),
                'last_chat_id' => 0,
                'create_time' => time()
            );
            M('chat_list')->add($insert);
            //添加群聊联系人
            $res = $this->insertChatLinkMan($send_uid,$send_type,$send_uid,$lastChatId,$send_type);
            if ($res){
                $ret = $this->format_ret(1,$res);
            }else{
                $ret = $this->format_ret(0,'创建失败');
            }
        }else{
            $ret = $this->format_ret(0,'创建失败');
        }
        echo json_encode($ret);
        exit;
    }
    //发送聊天信息
    public function SendChatData(){
        $send_uid = I('send_uid');//605
        $receive_uid = I('receive_uid');
        $send_type=I('send_type');
        $genre=Intval(I('usertype'));//0:家长，1:教师;2:群聊
        $studentid=I('studentid');
        if(!$send_uid || !$receive_uid){
            $ret = $this->format_ret(0,'参数错误');
            echo json_encode($ret);
            exit;
        }
        if($send_uid == $receive_uid){
            $ret = $this->format_ret(0,'不能和自己聊天');
            echo json_encode($ret);
            exit;
        }
        $realcontent=I('content');
        $content = $this->urlsafe_b64encode((I('content')));;
        if (!$content){
            $ret = $this->format_ret(0,'请输入发送内容');
        }
        $res = $this->insertChatData($send_uid,$receive_uid, $content,$send_type,$genre);
        if ($res){
            // $receiver = array('alias'=>$userid_array);
            //推送功能,判断推送给家长端还是教师端
            $userid_array = explode(',',$receive_uid);
            //去掉数组中的空格位置
            $userid_array = array_filter($userid_array);
            if($genre==2){
                //群聊
                //查找群聊中的群成员列表
                $chatid = I('chatid');
                $linkmanlist = $this->getChatLinkMan($receive_uid);

                if($linkmanlist){
                    $teacherlist=array();
                    $parentlist=array();
                    $hasteacher=0;
                    $hasparent=0;
                    foreach ($linkmanlist as &$linkman){
                        // echo($linkman['userid'].'-'.$linkman['user_type'].'<br>');
                        if($linkman['user_type']){
                            if($linkman['userid']!=$send_uid){
                                $teacherlist[]=$linkman['userid'];
                                $hasteacher=1;

                            }
                        }else{
                            if($linkman['userid']!=$send_uid){
                                // echo('ddddd'."<br>");
                                $parentlist[]=$linkman['userid'];
                                $hasparent=1;
                            }
                        }
                    }
                    
                    if($hasparent){
                        // echo('parent-');
                        // var_dump($parentlist);
                        $rs = $this->pjiguang($realcontent,"qchat",$parentlist,$receive_uid,1,1);
                    }
                    if($hasteacher){
                        // echo('teahcer-');
                        // var_dump($teacherlist);
                         //推送给教师
                        $rs = $this->tjiguang($realcontent,"qchat",$teacherlist,$receive_uid);
                    }
                }
            }
            if($genre == 1){
                //推送给教师
                $rs = $this->tjiguang($realcontent,"chat",$userid_array,$send_uid,1);
            }else{
                //推送给家长
                // $puserid_array = explode(',',$studentid);
                // $rs = $this->pjiguang("您收到一条新的群发消息,请注意查收!","message",$receiveid_arr,'',0);
                $rs = $this->pjiguang($realcontent,"chat",$userid_array,$send_uid,1);
            }
            $ret = $this->format_ret(1,$res);
        }else{
            $ret = $this->format_ret(0,'发送消息失败');
        }
        echo json_encode($ret);
        exit;
    }
    //拉取聊天信息
    public function xcGetChatData(){
        $send_uid = I('send_uid');//拉的时候send_uid永远是自己的
        $receive_uid = I('receive_uid');
        $receiver_type=intval(I('type'));
        $index = I('index');
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
        $ret = $this->format_ret(1,$res);
        echo json_encode($ret);
        exit;
    }
    //私聊列表
    public function xcGetChatListData(){
        $uid = I('uid');
        $res = $this->getChatListData($uid);
        if ($res){
            foreach ($res as &$val){
                $sendUserData = $this->getUserDataById($val['uid']);
                
                $readstatus =$this->getLastChatReadState($val['uid'],$val['chat_uid']);
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
                $val['status'] = $readstatus;
 
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
        echo json_encode($ret);
        exit;
    }
    public function xcGetLastChatData(){
        $send_uid = @$_REQUEST['send_uid'];//拉的时候send_uid永远是自己的
        $receive_uid = @$_REQUEST['receive_uid'];
        $res = $this->mApi->getLastChatData($send_uid, $receive_uid);
        if ($res){
            $sendUserData = $this->getUserDataById($send_uid);
            $receiveUserData = $this->getUserDataById($receive_uid);
            $ids = array();
            foreach ($res as &$val){
                $val['send_face'] = @$sendUserData['photo'];
                $val['send_nickname'] = @$sendUserData['name'];
                $val['receive_face'] = @$receiveUserData['photo'];
                $val['receive_nickname'] = @$receiveUserData['name'];
                if ($send_uid != $val['send_uid']){
                    @error_log($send_uid,3,'/data/log/api_send.log');
                    $ids[] = $val['id'];
                }
                unset($val);
            }
            //更新状态为已经拉取过了
            if (!empty($ids)){

                $this->mApi->updateChatStatusByIds($ids,2);
            }
        }
        $ret = $this->format_ret(1,$res);
        echo json_encode($ret);
        exit;
    }
    public function xcAddChatLinkMan(){
        $chatid = I('chatid');
        $userid=I('userid');
        $usertype=I('usertype');
        $inviterid=I('inviterid');
        $inviter_type=I('invitertype');
        //获取接收表中所需字段值,因获取到的是多个receiver_user_id,所以用explode函数拆分开
        // $receive_user_id = $userid;
        $receiveid_arr=explode(",",$userid);
        //去掉数组中的空格位置
        $receiveid_arr = array_filter($receiveid_arr);
        //将拆分后的id用foreach和settype函数转换为单个int值
        foreach ($receiveid_arr as &$receiverid) {
            $res =$this->insertChatLinkMan($inviterid,$invitertype,$receiverid,$chatid,$usertype);
        }
        // $res = $this->insertChatLinkMan($inviterid,$invitertype,$userid,$chatid,$usertype);
        if ($res){
            $ret = $this->format_ret(1,$res);
        }else{
            $ret = $this->format_ret(0,'邀请失败');
        }
        echo json_encode($ret);
        exit;
    }
    public function xcDeleteChatLinkMan(){
        $chatid = I('chatid');
        $userid=I('userid');
        $usertype=I('usertype');
        $inviterid=I('inviterid');
        $res = $this->deleteChatLinkMan($userid,$chatid,$usertype);
        if ($res){
            $ret = $this->format_ret(1,$res);
        }else{
            $ret = $this->format_ret(0,'删除失败');
        }
        echo json_encode($ret);
        exit;
    }
    //私聊列表
    public function xcGetChatLinkManList(){
        $uid = I('uid');
        $chatid = I('chatid');
        $res = $this->getChatLinkMan($chatid);
        if ($res){
            foreach ($res as &$val){
                $sendUserData = $this->getUserDataById($val['userid']);
                $val['my_face'] = @$sendUserData['photo'];
                $val['my_nickname'] = @$sendUserData['name'];
                unset($val);
            }
            $ret = $this->format_ret(1,$res);
        }else{
            $ret = $this->format_ret(0,'没有联系人');
        }
        echo json_encode($ret);
        exit;
    }
    function insertChatLinkMan($inviterid=0,$inviter_type=1,$uid=0,$chat_id=0,$user_type=1){
        if($uid ){
            if($chat_id==0){
                $chat_id=$this->nInsertChatData($inviterid,'创建了群',$inviter_type);
            }
            if($chat_id){
                $data = array(
                    'chatid' => $chat_id,
                    'userid' => $uid,
                    'user_type' => $user_type,
                    'inviter_uid' => $inviterid,
                    'create_time' => time()
                );
                $linkId= M('chat_linkman')->add($data);
            }
            if($linkId){
                //更新到会话列表里
                if($inviterid!=$uid){
                    $content='邀请你加入群';
                $insert = array(
                    'uid' => $uid,
                    'chat_uid' => $chat_id,
                    'type' => 1,
                    'last_content' => $this->urlsafe_b64encode($content),
                    'last_chat_id' => 0,
                    'create_time' => time()
                );
                M('chat_list')->add($insert);

                }
                //添加会话列表
                
                //邀请成功1、发送推送信息；2、更新群聊的人数
            }
            return $data;
        }
        return false;
    }
    function deleteChatLinkMan($uid=0,$chat_id=0,$user_type=1){
        if($uid && $chatid){
            $where = array(
                'chatid' => $chat_id,
                'userid' => $uid,
                'user_type' => $user_type
            );
            $linkId= M('chat_linkman')->where($where)->delete();
            if($linkId){
                //删除成功1、发送推送信息；2、更新群聊的人数
            }
            return $data;
        }
        return false;
    }
    function getChatLinkMan($chat_id=0){
        if($chat_id){
            $where = array(
                'chatid' => $chat_id
            );
            $linkData= M('chat_linkman')->where($where)->select();
            return $linkData;
        }
        return false;
    }
     //创建聊天信息
    //兼容群聊信息
    function nInsertChatData($uid=0, $content="创建了群",$send_type=1){
        if($uid){
        $data = array(
            'send_uid' => $uid,
            'send_type' => $send_type,
            'content' => $content,
            'create_time' => time()
        );
        $lastChatId= M('chat')->add($data);
        if($lastChatId){
            return $lastChatId;
        }
    }
        return false;
    }
     //插入聊天信息
    function insertChatData($uid=0, $chat_uid=0, $content="",$send_type=1,$recive_type=1){
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
            $this->updateChatList($uid, $chat_uid, $content, $lastChatId,$send_type,$recive_type);
            // $this->updateChatList($chat_uid, $uid, $content, $lastChatId);
            $realcontent=$this->urlsafe_b64decode($data['content']);
            if(!empty($realcontent)){
                $data['content']=$realcontent;
            }
            return $data;
        }
    }
        return false;
    }
    //获取聊天信息
    function getChatData($uid, $chat_uid, $index,$type=0){
        // $sql = "select * from chat where (send_uid=$uid and receive_uid = $chat_uid) or (send_uid=$chat_uid and receive_uid = $uid) order by id desc ";

        // $num = 10;
        // if ($index){
        //     $index = $index*10;
        //     $sql .= "limit $index,$num";
        // }else{
        //     $sql .= "limit $num";
        // }

        // $query = $this->db->query($sql);
        // $insert = $this->db->last_query();
        // @error_log($insert,3,'/data/log/sql_test.log');
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
    function getChatListData($uid){
        $data = array();
        $where = array(
                'uid'=>$uid
        );
        $query=M('chat_list')->alias('c')
        ->join("".C("Pre"))->where($where)->order('last_chat_id desc')->select();
        foreach ($query as &$chat) {
            //content的解码
            $realcontent=$this->urlsafe_b64decode($chat['content']);
            if(!empty($realcontent)){
                $chat['content']=$realcontent;
            }
            unset($chat);
        }

        return $query;
    }
    function updateChatList($uid,$chatUid,$content,$lastChatId){

        //如果有这个信息 就更新最后一条内容和状态为未读就可以了
        $query = M('chat_list')->where(array('uid'=>$uid, 'chat_uid'=>$chatUid))->order('create_time desc')->find();//$this->db->get_where($this->_chatList , array('uid'=>$uid, 'chat_uid'=>$chatUid) );

        if ($query) {
            // $data = $query->row_array();
            $id = $query['id'];
            // var_dump($query);
            // $this->db->where('id',$id);
            $insertwhere['id']=$id;
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
        function getLastChatReadState($other_uid, $other_uid){
            $where[]=array(
                'send_uid'=>$other_uid,
                'receive_uid'=>$other_uid,
                'status'=>1);

            // $sql = "select * from chat where (send_uid=$other_uid and receive_uid = $other_uid and status = 1) ";
            $query = M('chat')->where($where)->select();//$this->db->query($sql);
            foreach ($query as &$chat) {
                //content的解码
                $realcontent=$this->urlsafe_b64decode($chat['content']);
                if(!empty($realcontent)){
                    $chat['content']=$realcontent;
                }
                unset($chat);
            }

            $result = 2 ;
            if ($query) {
                $result = 1 ;
            }
            return $result;
        }
    function getChatDataByReceiveUid($receive_uid){
        $data = array();
        $where = array(
                'receive_uid'=>$receive_uid,
                'status'=>1
        );
        $query=M('chat')->where($where)->order('id desc')->select();
        foreach ($query as &$chat) {
            //content的解码
            $realcontent=$this->urlsafe_b64decode($chat['content']);
            if(!empty($realcontent)){
                $chat['content']=$realcontent;
            }
            unset($chat);
        }
        // $this->db->order_by('id','desc');
        // $query = $this->db->get_where( $this->_chat , $where );
        // if ($query->num_rows () > 0) {
        //     $data = $query->row_array ();
        // }
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
    //根据ID获取群聊的资料
    function getGroupDataById($id){
        $where = array('id'=>$id);
        $query =M('chat_group')->where($where)->find();// $this->db->get_where($this->_user,$where);
        return $query;
    }
    function updateChatStatusByIds($ids,$status){
        $this->db->where_in('id', $ids);
        $this->db->update($this->_chat,array('status'=>$status));
    }

    function updateChatListStatusByLastChatIds($ids,$status){
        $this->db->where_in('last_chat_id', $ids);
        $this->db->update($this->_chatList,array('status'=>$status));
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