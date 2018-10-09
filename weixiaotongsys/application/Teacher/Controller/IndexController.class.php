<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
 header("Content-type: text/html; charset=utf-8");   
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
        $this->assign("SUBMENU_CONFIG_SIX", json_encode(D("Common/Nav")->menu_json(6)));
        $this->assign("SUBMENU_CONFIG_SEVEN", json_encode(D("Common/Nav")->menu_json(7)));

        //获取登录用户的信息
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];


        //学校名称
        $school_info=M("school")->where("schoolid=$schoolid")->field("school_name")->find(); 
        $school_name=$school_info["school_name"];
        //老师姓名
        $teacher_info=M("wxtuser")->where("id=$userid")->field("name")->find();
        $teacher_name=$teacher_info["name"];
        //老师职责
        // $role = M("duty_teacher")->where("teacher_id = $userid")->getField("duty_id");
        $where['t.schoolid'] = $schoolid;
        $where['t.teacher_id'] = $userid;

        $role = M("duty_teacher")->alias("t")->join("wxt_school_duty s ON t.duty_id=s.id")->where($where)->order("s.level ASC")->getField("s.name");



        $this->assign("teacher_name",$teacher_name);
        $this->assign("school_name",$school_name);
        $this->assign("role",$role);
       	$this->display();      
    }

      public function  ursr_quit()
      {
           session(null); 
            echo("<script laguage='javascript'>  var mymessage=confirm('退出账号成功');  
                if(mymessage==true)  
                {  
                    window.parent.location.href='http://up.zhixiaoyuan.net';  
                }else{
                    window.parent.location.href='http://up.zhixiaoyuan.net'; 
                }  </script>");

       } 
    

}

