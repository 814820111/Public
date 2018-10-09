<?php

/**
 * 会员
 */
namespace User\Controller;
use Common\Controller\AdminbaseController;
class IndexadminController extends AdminbaseController {
/*
 * 用户组-老师
 * */
    function index(){
		$users_model=M("wxtuser");
		//count()  统计数量
		$count=$users_model->where(array("user_type"=>1))->count();
		//page()方法--分页方法    用page方法你不需要计算每个分页数据的起始位置，page方法内部会自动计算
		$page = $this->page($count, 20);
		$lists = $users_model
			->join("wxt_teacher_class ON wxt_teacher_class.teacherid = wxt_wxtuser.id")
			->where(array("user_type"=>1))
			->order("time DESC")
			->group('wxt_wxtuser.id')
			//->group_concat('wxt_wxtuser.id')
			->limit($page->firstRow . ',' . $page->listRows)            //用page()方法进行分页
			->select();
		$this->assign('lists', $lists);		// 赋值分页输出
		$this->assign("page", $page->show('Admin'));	// 分页显示输出
		var_dump($lists);
		echo "教师页面没写完";
		//$this->display(":patriarch");				// 输出模板
    }
	    



    function ban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Users")->where(array("id"=>$id,"user_type"=>2))->setField('user_status','0');
    		if ($rst) {
    			$this->success("会员拉黑成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员拉黑失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
    
    function cancelban(){
    	$id=intval($_GET['id']);
    	if ($id) {
    		$rst = M("Users")->where(array("id"=>$id,"user_type"=>2))->setField('user_status','1');
    		if ($rst) {
    			$this->success("会员启用成功！", U("indexadmin/index"));
    		} else {
    			$this->error('会员启用失败！');
    		}
    	} else {
    		$this->error('数据传入失败！');
    	}
    }
/*
 * 用户组-家长
 * */
	function patriarch(){
		$users_model=M("wxtuser");
		//count()  统计数量
		$count=$users_model->where(array("user_type"=>2))->count();
		//page()方法--分页方法    用page方法你不需要计算每个分页数据的起始位置，page方法内部会自动计算
		$page = $this->page($count, 20);
		$lists = $users_model
			->where(array("user_type"=>2))
			->order("time DESC")
			->limit($page->firstRow . ',' . $page->listRows)            //用page()方法进行分页
			->select();
		$this->assign('lists', $lists);		// 赋值分页输出
		$this->assign("page", $page->show('Admin'));	// 分页显示输出

		$this->display(":patriarch");				// 输出模板
	}
/*
 * 添加新用户
 * */
	function addnewuser(){
		$this->display(":addnewuser");				//输出模板
	}
	//添加
	function addnewuser_post(){
		//如果在add之前已经创建数据对象的话（例如使用了create或者data方法），add方法就不需要再传入数据了。
		if(IS_POST){
			//判断数据是否有为空
			if($_POST['phone']!=''&&$_POST['schoolid']!=''&&$_POST['classid']!=''&&$_POST['user_type']!=''){
				//增加创建时间
				$_POST['time'] = time();
				// 实例化wxtUser对象
				$users_model = M('wxtuser');
				// 根据表单提交的POST数据创建数据对象
				if ($users_model->create()){
					// 写入数据到数据库
					if ($users_model->add()!==false) {
						$this->success("添加成功！", U("indexadmin/patriarch"));
					} else {
						$this->error("添加失败！");
					}
				} else {
					$this->error("插入失败！");
				}

			}else{
				$this->error("有数据为空！");
			}
		 }
	 }

/*
 * 用户组   密码重置
 * */
	function passwordReset(){
		$id=intval($_GET['id']);
		if ($id) {
			$md5_pass = md5('123456');
			$rst = M("wxtuser")->where("id=$id")->setField('password',$md5_pass);
			if ($rst) {
				$this->success("密码重置成功！", U("indexadmin/patriarch"));
			} else {
				$this->error('密码重置失败！');
			}
		} else {
			$this->error('数据传入失败！');
		}
	}
	function userlist(){
        $result = M("users as user")->
        join("wxt_agent as agent on agent.user_id = user.id")
            ->where("1=1")->select();
        $this->assign("agent",$result);
        $this->display();
    }

    // public function default()
    // {
     
    //  echo '66666';

    // }
	 public function default()
	  { 
	  	$this->display(); 
	    
	  	exit();
	  }



}
