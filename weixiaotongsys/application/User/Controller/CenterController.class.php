<?php

/**
 * 会员中心
 */
namespace User\Controller;
use Common\Controller\MemberbaseController;
class CenterController extends MemberbaseController {
	
	protected $users_model;
	function _initialize(){
		parent::_initialize();
		$this->users_model=D("Common/Users");
	}
    //会员中心
	public function index() {

		// $userid=sp_get_current_userid();
		// $user=$this->users_model->where(array("id"=>$userid))->find();
		// $this->assign($user);
		$userinfo = $_SESSION['user'];
		$this->assign('userinfo',$userinfo);
    	$this->display(':center');
    }
    //退出
    public function user_exit(){
    	session_unset();
    	if(empty($_SESSION['user'])){
    		$this->success("退出成功！",__ROOT__."/");
    	}else{
    		$this->error("发生未知错误，退出失败！",U('/User/Center/index'));
    	}
    }
	//博客
	public function blogs() {
		// $userid=sp_get_current_userid();
		// $user=$this->users_model->where(array("id"=>$userid))->find();
		// $this->assign($user);
		$this->display(':blog');
	}
	//家校沟通
	public function new_message(){
		//当前用户已收信息
		$userid=sp_get_current_userid();
		
		$this->display('/message/new-message');
	}
	public function send_message(){

		$this->display('/message/send-message');
	}
	function sail_go_message(){
		//用户已发消息
		//调用获取当前用户已发消息接口
		$data['userid']=$_SESSION["user"]['id'];;
			$message_url = $_SERVER['HTTP_HOST']."/index.php?g=Apps&m=Message&a=get_send_message";
			$message_info_json = request_post($message_url,$data);
			$message_info_arr = json_decode($message_info_json,true);
			if($message_info_json && $message_info_arr['status']=="success"){
				$message_data_all = $message_info_arr['data'];
				//查询结果分页
        		$count= count($message_data_all);
        		$page = $this->page($count, 1);
        		
        		$message_data_page = array_slice($message_data_all,$page->firstRow,$page->listRows);
        		$this->assign("page", $page->show());
				$this->assign('message_data',$message_data_page);
			}
			// dump($message_data);
		$this->display('/message/sail-go-message');
	}
	public function parents_reply(){
		$this->display('/message/parents-reply');
	}
	public function parents_warn(){
		$this->display('/message/parents_warn');
	}
	public function notice_message(){
		$this->display('/message/notice_message');
	}
	public function backlog_message(){
		$this->display('/message/backlog_message');
	}
	public function teacher_message(){
		$this->display('/message/teacher_message');
	}
	public function system_message(){
		$this->display('/message/system_message');
	}
	public function new_notice(){
		$this->display('/message/new_notice');
	}
	public function new_backlog(){
		$this->display('/message/new_backlog');
	}
	public function class_check(){
		$this->display('/check/class_check');
	}
	public function online(){
		$this->display('/check/online');
	}
	public function teacher_check(){
		$this->display('/check/teacher_check');
	}
	public function safe_confirm(){
		$this->display('/check/safe_confirm');
	}
	public function spatial_dynamics(){
		$this->display('/zone/spatial_dynamics');
	}
	public function teacher(){
		$this->display('/work/teacher');
	}
	public function parents(){
		$this->display('/work/parents');
	}
	//教师端—家校互联
	public function relation(){
		$this->display(':relation');
	}

}
