<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class IndexController extends TeacherbaseController {
	
	
	function _initialize() {
		// die('asdfasdf');
		parent::_initialize();
		$this->initMenu();
	}

    //后台框架首页
    public function index() {
    	
        $this->assign("SUBMENU_CONFIG_ONE", json_encode(D("Common/Nav")->menu_json(1)));
        $this->assign("SUBMENU_CONFIG_TWO", json_encode(D("Common/Nav")->menu_json(2)));
        $this->assign("SUBMENU_CONFIG_THREE", json_encode(D("Common/Nav")->menu_json(3)));
        $this->assign("SUBMENU_CONFIG_FIVE", json_encode(D("Common/Nav")->menu_json(5)));
        $this->assign("SUBMENU_CONFIG_SEVEN", json_encode(D("Common/Nav")->menu_json(7)));
        // var_dump(D("Common/Menu")->menu_json());
        //获取登录用户的信息
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //学校名称
        $school_info=M("school")->where("schoolid=$schoolid")->field("school_name")->find();
        $school_name=$school_info["school_name"];
        //老师姓名
        $teacher_info=M("wxtuser")->where("id=$userid")->field("name")->find();
        $teacher_name=$teacher_info["name"];
        $this->assign("teacher_name",$teacher_name);
        $this->assign("school_name",$school_name);
       	$this->display();      
    }

    

}

