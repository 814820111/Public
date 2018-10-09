<?php
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class UserController extends TeacherbaseController{
	protected $users_model,$role_model;
	
	function _initialize() {
		parent::_initialize();
		$this->users_model = D("Common/wxtuser");
		$this->role_model = D("Common/Role");
	}

	function userinfo(){
		$userid=$_SESSION['USER_ID'];
		$user=$this->users_model->where(array("id"=>$userid))->find();
		$this->assign($user);
		$this->display();
	}
	
	function userinfo_post(){
		if (IS_POST) {
			$userid=$_SESSION['USER_ID'];
			$data["nickname"]=I("nickname");
			$data["sex"]=I("sex");
			$data["birthday"]=strtotime(I("birthday"));
			$data["signature"]=I("signature");
			$_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
			$data["photo"]=$_POST['smeta']['thumb'];
			$user_save=$this->users_model->where("id=$userid")->save($data);
			if($user_save){
				$this->success("保存成功", U("user/userinfo"));
			}else{
				$this->error('保存信息未改变');
			}
		}
	}

	function password(){
		$this->display();
	}
	
	function password_post(){
		if (IS_POST) {
			if(empty($_POST['old_password'])){
				$this->error("原始密码不能为空！");
			}
			if(empty($_POST['password'])){
				$this->error("新密码不能为空！");
			}
			$user_obj = D("Common/wxtuser");
			$uid=$_SESSION['USER_ID'];
			$admin=$user_obj->where(array("id"=>$uid))->find();
			$old_password=$_POST['old_password'];
			$password=$_POST['password'];
			if(md5($old_password)==$admin['password']){
				if($_POST['password']==$_POST['repassword']){
					if($admin['password']==md5($password)){
						$this->error("新密码不能和原始密码相同！");
					}else{
						$data['password']=md5($password);
						$data['id']=$uid;
						$r=$user_obj->save($data);
						if ($r!==false) {
							$this->success("修改成功！");
						} else {
							$this->error("修改失败！");
						}
					}
				}else{
					$this->error("密码输入不一致！");
				}
	
			}else{
				$this->error("原始密码不正确！");
			}
		}
	}
	
}