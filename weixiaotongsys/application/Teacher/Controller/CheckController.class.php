<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class CheckController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();


    }

    public function messageinfo(){
       $schoolid = $_SESSION['schoolid'];
      

        $class=M('school_class')->field("id,classname")->order("id")->select();
        $search=I('search');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        if($search){
            $where["b.name"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["s.create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }


     $where['s.schoolid'] = $schoolid;

        $count=M('user_message')
         ->alias("s")
        ->join("wxt_teacher_info b ON s.send_user_id=b.teacherid")
        ->where($where)
        ->count();
       
    

        $page = $this->page($count, 20); 
        $list=M('user_message')       
        ->alias("s")
        ->join("wxt_teacher_info b ON s.send_user_id=b.teacherid")
        ->limit($page->firstRow . ',' . $page->listRows)
        ->where($where)
        ->field("s.*,b.name as username")
        ->select();

          
        $page = $this->page($count, 20);
        $this->assign("class",$class);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display();
    }
    public function notice(){
        $search=I('search');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        if($search){
            $where["title"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        $list=M('notice')->where($where)->order("id")->select();
        foreach ($list as &$item) {
            $userid=$item["userid"];

            $user_name=M('teacher_info')->field("name")->where("teacherid=$userid")->find();

            $item["user_name"]=$user_name["name"];
        }
        $count=M('homework')->where($where)->count();    
        $page = $this->page($count, 20);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display();
    }
}

