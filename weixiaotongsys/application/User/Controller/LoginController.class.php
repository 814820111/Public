<?php
/**
 * 会员注册
 */
namespace User\Controller;
use Common\Controller\HomeBaseController;
class LoginController extends HomeBaseController {
	
	function index(){
		$this->display(":login");
	}
	
	function active(){
		$this->check_login();
		$this->display(":active");
	}
	
	function doactive(){
		$this->check_login();
		$this->_send_to_active();
		$this->success('激活邮件发送成功，激活请重新登录！',U("user/index/logout"));
	}
	
	function forgot_password(){
		$this->display(":forgot_password");
	}
	//写入当前会话用户的基本信息
	function write_sesson(){
		$id = $_POST['userid'];
		$users_model=M("wxtuser");
		if(empty($id)){
			die;
		}else{
			$result = $users_model->where(array('id'=>$id))->find();
			$_SESSION["user"]=$result;
			// echo json_encode(array('status'=>'success', 'data'=>$result));
			exit;
		}
	}
	//教师用户绑定了多个学校时，对学校进行选择
	function selection_school(){
		//获取session会话存入的用户id
		$userid = sp_get_current_userid();
		//获取该用户对应的学校列表
	}
	//教师用户账户验证成功且选择了学校时，写入会话信息  用户信息+学校信息+科室信息+班级信息+职务信息
	function write_user_session(){
		//获取js的传入参数
		// $data['userid'] = $_POST['userid'];
		// $data['schoolid'] = $_POST['schoolid'];
		// if(empty($data['userid'])||empty($data['schoolid'])){
		// 	echo json_encode(array('status'=>'error', 'data'=>'请输入数据'));
		// 	exit;
		// }else{
		// 	//调用获取用户科室信息接口
		// 	$department_url = $_SERVER['HTTP_HOST']."/index.php?g=Apps&m=Teacher&a=get_user_department";
		// 	$department_info_json = request_post($department_url,$data);
		// 	$department_info_arr = json_decode($department_info_json,true);
		// 	if($department_info_json && $department_info_arr['status']=="success"){
		// 		$_SESSION["department"]=$department_info_arr['data'];
		// 	}
		// 	//调用用户基本信息接口
		// 	$userbase_url = $_SERVER['HTTP_HOST']."/index.php?g=Apps&m=Teacher&a=get_user_baseinfo";
		// 	$userbase_info_json = request_post($userbase_url,array('userid'=>$data['userid']));
		// 	$userbase_info_arr = json_decode($userbase_info_json,true);
		// 	if($userbase_info_json && $userbase_info_arr['status']=="success"){
		// 		$_SESSION["user"]=$userbase_info_arr['data'];
		// 	}
		// 	//调用用户职位信息及最高权限等级接口
		// 	$duty_url = $_SERVER['HTTP_HOST']."/index.php?g=Apps&m=Teacher&a=get_user_dutyinfo";
		// 	$duty_info_json = request_post($duty_url,$data);
		// 	$duty_info_arr = json_decode($duty_info_json,true);
		// 	if($duty_info_json && $duty_info_arr['status']=="success"){
		// 		$_SESSION["duty"]=$duty_info_arr['data'];
		// 	}
		// 	//调用获取学校信息id
		// 	$schoolinfo_url = $_SERVER['HTTP_HOST']."/index.php?g=Apps&m=Teacher&a=get_schoolinfo";
		// 	$schoolinfo_info_json = request_post($schoolinfo_url,array('schoolid'=>$data['schoolid']));
		// 	$schoolinfo_info_arr = json_decode($schoolinfo_info_json,true);
		// 	if($schoolinfo_info_json && $schoolinfo_info_arr['status']=="success"){
		// 		$_SESSION["school"]=$schoolinfo_info_arr['data'];
		// 	}
		// 	exit();
		// }
		session_start();

        $userid=I('userid');
        $schoolid=I('schoolid');
        $username=I('username');
        $where['teacher.schoolid'] = $schoolid;
        $where['teacher.teacher_id'] = $userid;
        //查出老师权限等级
        $level = M("duty_teacher")
            ->alias('teacher')
            ->join("wxt_school_duty school_duty ON teacher.duty_id = school_duty.id")
            ->order("school_duty.level ASC")
            ->where($where)
            ->getField('school_duty.level');
        //写入SESSION
        $_SESSION["USER_ID"]=$userid;
        $_SESSION['name']=$username;
        $_SESSION['schoolid']=$schoolid;
        $_SESSION['level']=$level;

        echo('success');
        exit;
		
	}
	function doforgot_password(){
		if(IS_POST){
			if(!sp_check_verify_code()){
				$this->error("验证码错误！");
			}else{
				$users_model=M("Users");
				$rules = array(
						//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
						array('email', 'require', '邮箱不能为空！', 1 ),
						array('email','email','邮箱格式不正确！',1), // 验证email字段格式是否正确
						
				);
				if($users_model->validate($rules)->create()===false){
					$this->error($users_model->getError());
				}else{
					$email=I("post.email");
					$find_user=$users_model->where(array("user_email"=>$email))->find();
					if($find_user){
						$this->_send_to_resetpass($find_user);
						$this->success("密码重置邮件发送成功！",__ROOT__."/");
					}else {
						$this->error("账号不存在！");
					}
					
				}
				
			}
			
		}
	}
	
	protected  function _send_to_resetpass($user){
		$options=get_site_options();
		//邮件标题
		$title = $options['site_name']."密码重置";
		$uid=$user['id'];
		$username=$user['user_login'];
	
		$activekey=md5($uid.time().uniqid());
		$users_model=M("Users");
	
		$result=$users_model->where(array("id"=>$uid))->save(array("user_activation_key"=>$activekey));
		if(!$result){
			$this->error('密码重置激活码生成失败！');
		}
		//生成激活链接
		$url = U('user/login/password_reset',array("hash"=>$activekey), "", true);
		//邮件内容
		$template =<<<hello
		#username#，你好！<br>
		请点击或复制下面链接进行密码重置：<br>
		<a href="http://#link#">http://#link#</a>
hello;
		$content = str_replace(array('http://#link#','#username#'), array($url,$username),$template);
	
		$send_result=sp_send_email($user['user_email'], $title, $content);
	
		if($send_result['error']){
			$this->error('密码重置邮件发送失败！');
		}
	}
	
	
	function password_reset(){
		$this->display(":password_reset");
	}
	
	function dopassword_reset(){
		if(IS_POST){
			if(!sp_check_verify_code()){
				$this->error("验证码错误！");
			}else{
				$users_model=M("Users");
				$rules = array(
						//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
						array('password', 'require', '密码不能为空！', 1 ),
						array('repassword', 'require', '重复密码不能为空！', 1 ),
						array('repassword','password','确认密码不正确',0,'confirm'),
						array('hash', 'require', '重复密码激活码不能空！', 1 ),
				);
				if($users_model->validate($rules)->create()===false){
					$this->error($users_model->getError());
				}else{
					$password=sp_password(I("post.password"));
					$hash=I("post.hash");
					$result=$users_model->where(array("user_activation_key"=>$hash))->save(array("user_pass"=>$password,"user_activation_key"=>""));
					if($result){
						$this->success("密码重置成功，请登录！",U("user/login/index"));
					}else {
						$this->error("密码重置失败，重置码无效！");
					}
					
				}
				
			}
		}
	}
	
	
    //登录验证
    function dologin(){

    	if(!sp_check_verify_code()){
    		$this->error("验证码错误！");
    	}
    	
    	$users_model=M("Users");
    	$rules = array(
    			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
    			array('terms', 'require', '您未同意服务条款！', 1 ),
    			array('username', 'require', '用户名或者邮箱不能为空！', 1 ),
    			array('password','require','密码不能为空！',1),
    	
    	);
    	if($users_model->validate($rules)->create()===false){
    		$this->error($users_model->getError());
    	}
    	
    	extract($_POST);
    	
    	if(strpos($username,"@")>0){//邮箱登陆
    		$where['user_email']=$username;
    	}else{
    		$where['user_login']=$username;
    	}
    	$users_model=M('Users');
    	$result = $users_model->where($where)->find();

    	$ucenter_syn=C("UCENTER_ENABLED");
    		
    	$ucenter_old_user_login=false;
    	
    	$ucenter_login_ok=false;
    	if($ucenter_syn){
    		setcookie("thinkcmf_auth","");
    		include UC_CLIENT_ROOT."client.php";
    		list($uc_uid, $username, $password, $email)=uc_user_login($username, $password);
    	
    		if($uc_uid>0){
    			if(!$result){
    				$data=array(
    						'user_login' => $username,
    						'user_email' => $email,
    						'user_pass' => sp_password($password),
    						'last_login_ip' => get_client_ip(),
    						'create_time' => time(),
    						'last_login_time' => time(),
    						'user_status' => '1',
    				);
    				$id= $users_model->add($data);
    				$data['id']=$id;
    				$result=$data;
    			}
    				
    		}else{
    	
    			switch ($uc_uid){
    				case "-1"://用户不存在，或者被删除
    					if($result){//本应用已经有这个用户
    						if($result['user_pass'] == sp_password($password)){//本应用已经有这个用户,且密码正确，同步用户
    							$uc_uid2=uc_user_register($username, $password, $result['user_email']);
    							if($uc_uid2<0){
    								$uc_register_errors=array(
    										"-1"=>"用户名不合法",
    										"-2"=>"包含不允许注册的词语",
    										"-3"=>"用户名已经存在",
    										"-4"=>"Email格式有误",
    										"-5"=>"Email不允许注册",
    										"-6"=>"该Email已经被注册",
    								);
    								$this->error("同步用户失败--".$uc_register_errors[$uc_uid2]);
    	
    	
    							}
    							$uc_uid=$uc_uid2;
    						}else{
    							$this->error("密码错误！");
    						}
    					}
    						
    					break;
    				case -2://密码错
    					if($result){//本应用已经有这个用户
    						if($result['user_pass'] == sp_password($password)){//本应用已经有这个用户,且密码正确，同步用户
    							$uc_user_edit_status=uc_user_edit($username,"",$password,"",1);
    							if($uc_user_edit_status<=0){
    								$this->error("登陆错误！");
    							}
    							list($uc_uid2)=uc_get_user($username);
    							$uc_uid=$uc_uid2;
    							$ucenter_old_user_login=true;
    						}else{
    							$this->error("密码错误！");
    						}
    					}else{
    						$this->error("密码错误！");
    					}
    	
    					break;
    	
    			}
    		}
    		$ucenter_login_ok=true;
    		echo uc_user_synlogin($uc_uid);
    	}
    	//exit();
    	if($result != null)
    	{
    		if($result['user_pass'] == sp_password($password)|| $ucenter_login_ok)
    		{
    			$_SESSION["user"]=$result;
    			//写入此次登录信息
    			$data = array(
    					'last_login_time' => date("Y-m-d H:i:s"),
    					'last_login_ip' => get_client_ip(),
    			);
    			$users_model->where("id=".$result["id"])->save($data);
    			$redirect=empty($_SESSION['login_http_referer'])?__ROOT__."/":$_SESSION['login_http_referer'];
    			$_SESSION['login_http_referer']="";
    			$ucenter_old_user_login_msg="";
    				
    			if($ucenter_old_user_login){
    				//$ucenter_old_user_login_msg="老用户请在跳转后，再次登陆";
    			}
    				
    			$this->success("登录验证成功！", $redirect);
    		}else{
    			$this->error("密码错误！");
    		}
    	}else{
    		$this->error("用户名不存在！");
    	}
    	 
    }
	function login_post(){
 
		$users_model=M("wxtuser");
		$rules = array(
			//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('phone', 'require', '用户名不能为空！', 1 ),
			array('password','require','密码不能为空！',1),

		);
		if($users_model->validate($rules)->create()===false){
			$this->error($users_model->getError());
		}

		extract($_POST);

		$where['phone']=$phone;
		$where['user_type']=$user_type;
		$users_model=M('wxtuser');
		$result = $users_model->where($where)->find();


		$ucenter_old_user_login=false;

		$ucenter_login_ok=false;


		if($result != null)
		{
			if($result['password'] == md5($password)|| $ucenter_login_ok)
			{
				$_SESSION["user"]=$result;
				//写入此次登录信息
				$data = array(
					'last_login_time' => date("Y-m-d H:i:s"),
					'last_login_ip' => get_client_ip(),
				);
				$users_model->where("id=".$result["id"])->save($data);
				$redirect=empty($_SESSION['login_http_referer'])?__ROOT__."/":$_SESSION['login_http_referer'];
				$_SESSION['login_http_referer']="";
				$ucenter_old_user_login_msg="";

				if($ucenter_old_user_login){
					//$ucenter_old_user_login_msg="老用户请在跳转后，再次登陆";
				}

				$this->success("登录验证成功！", $redirect);
			}else{
				$this->error("密码错误！");
			}
		}else{
			$this->error("用户名不存在！");
		}
	}
	
}