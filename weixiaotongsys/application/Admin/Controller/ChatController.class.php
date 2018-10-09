<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ChatController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        // $this->teacher_model=D("Common/teacherinfo");
        $this->chatlist_model=D("Common/chat_group");
        $this->linkman_model=D("Common/chat_linkman");
    }
    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
    public function chat(){
        $this->_chatlist();
        $this->display();
    }
    private  function _chatlist($status=1){
        $school_id=0;
        if(!empty($_REQUEST["school_id"])){
            $school_id=intval($_REQUEST["school_id"]);
            $this->assign("school_id",$school_id);
            $_GET['school_id']=$school_id;
        }
        $where_ands=empty($school_id)?array(""):array("school_id = $school_id");
        $fields=array(
                'start_time'=> array("field"=>"post_date","operator"=>">"),
                'end_time'  => array("field"=>"post_date","operator"=>"<"),
                'keyword'  => array("field"=>"post_title","operator"=>"like"),
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
        $where= join(" and ", $where_ands);
        $count=$this->chatlist_model
        ->where($where)
        ->count();
        $page = $this->page($count, 20);
        $posts=$this->chatlist_model
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("create_time DESC")->select();
        foreach ($posts as &$chat) {
            //获取创建人的信息

            $userwhere['id']=$chat['send_uid'];
            // var_dump($userwhere);
            $user=M('wxtuser')->where($userwhere)->find();
            if($user){
                $chat['username']=$user['name'];
            }else{
                $chat['username']='系统';
            }
            $schoolname=$this->school_model
            ->alias("school")
            ->where(array("schoolid"=>$user['schoolid']))
            ->field('school_name')
            ->find();
            $chat["schoolname"]=$schoolname["school_name"];
            $chat['last_content']=$this->urlsafe_b64decode($chat['last_content']);
            //获取联系人列表
            $linkwhere['chatid']=$chat['id'];
            $linkman=M('chat_linkman')
            ->distinct(true)
            ->alias('c')
            ->join(' wxt_wxtuser u on c.userid=u.id')
            ->field('u.name')
            // ->limit(5)
            ->select();
            $chat['linkman']=$linkman;
            //获取聊天内容
            $chatwhere['c.receive_uid']=$chat['id'];
            $chatwhere['c.recive_type']=2;
            $chatcontent=M('chat')
            // ->distinct(true)
            ->alias('c')
            // ->join('wxt_wxtuser u on c.send_uid')
            ->field('c.id,c.send_uid,c.content,c.create_time,c.send_type')
            ->where($chatwhere)
            ->select();
            foreach ($chatcontent as &$ccontent) {
                $uwhere['id']=$ccontent['send_uid'];
                
                $user=M('wxtuser')->where($uwhere)->find();
                // var_dump($user);
                $ccontent['name']=$user['name'];
                $realcontent=$this->urlsafe_b64decode($ccontent['content']);
                $ccontent['content']=$realcontent;
                unset($ccontent);
            }
            $chat['chatcontent']=$chatcontent;
            unset($chat);
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("school_name",$school_name);
        $this->assign("lists",$posts);
    }
    private  function _lists($status=1){
        $school_id=0;
        if(!empty($_REQUEST["school_id"])){
            $school_id=intval($_REQUEST["school_id"]);
            $this->assign("school_id",$school_id);
            $_GET['school_id']=$school_id;
        }
        $where_ands=empty($school_id)?array(""):array("school_id = $school_id");
        
        $fields=array(
                'start_time'=> array("field"=>"post_date","operator"=>">"),
                'end_time'  => array("field"=>"post_date","operator"=>"<"),
                'keyword'  => array("field"=>"post_title","operator"=>"like"),
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
        $where= join(" and ", $where_ands);
        $count=$this->chatlist_model
        ->where($where)
        ->count();
        $page = $this->page($count, 20);
        $posts=$this->chatlist_model
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("create_time DESC")->select();
        foreach ($posts as &$chat) {
            //获取创建人的信息

            $userwhere['id']=$chat['send_uid'];
            // var_dump($userwhere);
            $user=M('wxtuser')->where($userwhere)->find();
            if($user){
                $chat['username']=$user['name'];
            }else{
                $chat['username']='系统';
            }
            $schoolname=$this->school_model
            ->alias("school")
            ->where(array("schoolid"=>$user['schoolid']))
            ->field('school_name')
            ->find();
            $chat["schoolname"]=$schoolname["school_name"];
            $chat['last_content']=$this->urlsafe_b64decode($chat['last_content']);
            //获取联系人列表
            $linkwhere['chatid']=$chat['id'];
            $linkman=M('chat_linkman')
            ->distinct(true)
            ->alias('c')
            ->join(' wxt_wxtuser u on c.userid=u.id')
            ->field('u.name')
            // ->limit(5)
            ->select();
            $chat['linkman']=$linkman;
            //获取聊天内容
            $chatwhere['c.receive_uid']=$chat['id'];
            $chatwhere['c.recive_type']=2;
            $chatcontent=M('chat')
            // ->distinct(true)
            ->alias('c')
            // ->join('wxt_wxtuser u on c.send_uid')
            ->field('c.id,c.send_uid,c.content,c.create_time,c.send_type')
            ->where($chatwhere)
            ->select();
            foreach ($chatcontent as &$ccontent) {
                $uwhere['id']=$ccontent['send_uid'];
                
                $user=M('wxtuser')->where($uwhere)->find();
                // var_dump($user);
                $ccontent['name']=$user['name'];
                $realcontent=$this->urlsafe_b64decode($ccontent['content']);
                $ccontent['content']=$realcontent;
                unset($ccontent);
            }
            $chat['chatcontent']=$chatcontent;
            unset($chat);
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("school_name",$school_name);
        $this->assign("lists",$posts);
    }
    //解码
    function urlsafe_b64decode($string) {
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
       $data .= substr('====', $mod4);
    }
    return base64_decode($data);
    }
//------------------增加校园招聘----------------
  function add(){
        $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $schoolid = intval(I("get.school"));
        $this->_getTree();
        $teacher=$this->teacher_model->where("schoolid=$schoolid")->find();
        $this->assign("author","1");
        $this->assign("teacher",$teacher);
        $this->assign("school_name",$school_name);
        $this->display();
    }
    
    function add_post(){
        if (IS_POST) {
            if(empty($_POST['school'])){
                $this->error("请至少选择一个学校！");
            }
            if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
                foreach ($_POST['photos_url'] as $key=>$url){
                    $photourl=sp_asset_relative_url($url);
                    $_POST['smeta']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
                }
            }
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
             
            $_POST['post']['post_date']=date("Y-m-d H:i:s",time());
           //$_POST['post']['post_author']=get_current_admin_id();
            $teacher=I("post.post");
            $teacher['schoolid']=$_POST['school'];
            // $schoolname=$this->school_model->where("$school_id=schoolid")->getField('school_name');

            $teacher['smeta']=json_encode($_POST['smeta']);
            $teacher['post_content']=htmlspecialchars_decode($teacher['post_content']);
            $result=$this->teacher_model->add($teacher);
            if ($result) {
                
                // foreach ($_POST['school'] as $mschool_id){
                //     $this->job_model->add(array("schoolid"=>intval($mschool_id)));
                // }
                
                $this->success("添加成功！");
            } else {
                $this->error("添加失败！");
            }
             
        }
    }
//------------------增加校园招聘结束----------------

//------------------更新校园招聘开始----------------
    public function edit(){
        $id=  intval(I("id"));
        //var_dump($id);
        $schoolid = intval(I("get.school"));
        $this->_getTree();
         $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $teacher = $this->teacher_model->where(array("id"=>$id))->find();
        //$this->_getTermTree($term_relationship);
        //$terms=$this->terms_model->select();
        //$post=$this->posts_model->where("id=$id")->find();
        $this->assign("teacher",$teacher);
        $this->assign("smeta",json_decode($post['smeta'],true));
        $this->assign("school_name",$school_name);
        // $this->assign("term",$term_relationship);
        $this->display();
    }
    
    public function edit_post(){
        if (IS_POST) {
            $where['id']=intval(I("teacher_id"));
            if(empty($_POST['school'])){
                $this->error("请至少选择一个分类栏目！");
            }
            //$post_id=intval($_POST['post']['id']);
            
            //$this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>array("not in",implode(",", $_POST['term']))))->delete();
            // foreach ($_POST['term'] as $mterm_id){
            //     $find_term_relationship=$this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>$mterm_id))->count();
            //     if(empty($find_term_relationship)){
            //         $this->term_relationships_model->add(array("term_id"=>intval($mterm_id),"object_id"=>$post_id));
            //     }else{
            //         $this->term_relationships_model->where(array("object_id"=>$post_id,"term_id"=>$mterm_id))->save(array("status"=>1));
            //     }
            // }
            
            if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
                foreach ($_POST['photos_url'] as $key=>$url){
                    $photourl=sp_asset_relative_url($url);
                    $_POST['smeta']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
                }
            }
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
            $_POST['post']['post_date']=date("Y-m-d H:i:s",time());
            //unset($_POST['post']['post_author']);
            $teacher=I("post.post");
            //$job['schoolid']=$_POST['school'];
            $teacher['smeta']=json_encode($_POST['smeta']);
            $teacher['post_content']=htmlspecialchars_decode($teacher['post_content']);
            $result=$this->teacher_model->where($where)->save($teacher);
            if ($result!==false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }
   
//------------------更新校园招聘结束----------------

//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->job_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }

    //排序
    public function listorders() {
        $status = parent::_listorders($this->job_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
//-------------------------审核-------------------------
    function check(){
        if(isset($_POST['ids']) && $_GET["check"]){
            $data["post_status"]=1;
            
            $tids=join(",",$_POST['ids']);
            $objectids=$this->job_model->field("id")->where("id in ($tids)")->select();
            $ids=array();
            foreach ($objectids as $id){
                $ids[]=$id["id"];
            }
            $ids=join(",", $ids);
            if ( $this->job_model->where("id in ($ids)")->save($data)!==false) {
                $this->success("审核成功！");
            } else {
                $this->error("审核失败！");
            }
        }
        if(isset($_POST['ids']) && $_GET["uncheck"]){
            
            $data["post_status"]=0;
            $tids=join(",",$_POST['ids']);
            $objectids=$this->job_model->field("id")->where("id in ($tids)")->select();
            $ids=array();
            foreach ($objectids as $id){
                $ids[]=$id["id"];
            }
            $ids=join(",", $ids);
            if ( $this->job_model->where("id in ($ids)")->save($data)) {
                $this->success("取消审核成功！");
            } else {
                $this->error("取消审核失败！");
            }
        }
    }

    private function _getTree(){
		$schoolid=empty($_REQUEST['school'])?0:intval($_REQUEST['school']);
		$result = $this->school_model->field("schoolid ,school_name as name")->order(array("schoolid"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['schoolid'];
			$r['selected']=$schoolid==$r['id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
}