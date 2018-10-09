<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class EntrustController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

    public function index() {
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];

//		$map["b.schoolid"]=$schoolid;
		$map["e.schoolid"]=$schoolid;
        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);
            $map['e.userid'] = $userid;

        }else{
            $class=M('school_class')->field("id,classname")->where("schoolid=$schoolid")->order("id")->select();
        }


        $search=I('search');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $state=I("state");     
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        $classid=I("classid"); 
        if($state!=""){
        	$map["e.status"]=$state;
        }      
        if($classid){
            $userid_c=M('class_relationship')->field("userid")->where("classid=$classid and schoolid=$schoolid")->select();
            $id_arr_c=array();
            foreach ($userid_c as &$itvo) {
                foreach ($itvo as &$co) {
                    array_push($id_arr_c,$co);
                }
            }
            $map["e.studentid"]=array("in",$id_arr_c);
        }
        if($search){
//            $map["b.name"]=array('LIKE',"%".$search."%");
            $map["b.stu_name"]=array('LIKE',"%".$search."%");

        }
        if($begintime && $endtime){
//            $map["create_time"]=array(array('EGT',$begin),array('ELT',$end));
            $map["e.create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        $count=M('entrust')
        ->alias("e")
       // ->join("wxt_wxtuser b ON e.studentid=b.id")
        ->join("wxt_student_info b ON e.studentid=b.userid")
        ->where($map)
        ->count();
        $page = $this->page($count, 20);
 
        $list=M('entrust')
        ->alias("e")
//        ->join("wxt_wxtuser b ON e.studentid=b.id")
        ->join("wxt_student_info b ON e.studentid=b.userid")
        ->limit($page->firstRow . ',' . $page->listRows)
//        ->field("e.* , b.name")
        ->field("e.* , b.stu_name as name")
        ->where($map)
        ->order("e.create_time DESC")
        ->select();


        foreach ($list as &$item) {
            $studentid=$item["studentid"]; 
            $classname=M('school_class')
            ->alias("s")
            ->join("wxt_class_relationship c ON s.id=c.classid")
            ->where("c.userid=$studentid")
            ->field("s.classname")
            ->find();
            $item["classname"]=$classname["classname"];
        }
        
        $this->assign("classid",$classid);
        $this->assign("search",$search);
        $this->assign("begintime",$begintime);
        $this->assign("endtime",$endtime);
        $this->assign("class",$class);
        $this->assign("list",$list);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("teacher",$teacher);
       	$this->display();  
    }
    //修改信息的状态
    public function declareis(){
    	$state=I("state");
    	$data["status"]=$state;
    	$stataid=I("stataid");
    	
    	if($stataid){
    		$User=M("entrust")->where("id=$stataid")->save($data);
    	}
    }
}
