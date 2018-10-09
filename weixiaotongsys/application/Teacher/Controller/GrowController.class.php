<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class GrowController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }
    public function index(){

         $microblog_like=M('microblog_like');
        $microblog_comment=M('microblog_comment');
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $where['mm.schoolid']= $schoolid;



        $search=I('search');
        $class_c=I('class_c');
         $studentname=I('studentname');       
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);

        if($search){
            // $where["title"]=array('LIKE',"%".$search."%");
            array_push($where, "content like '%$search%' ");
        }
        if($begintime && $endtime){
            $where["write_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        if(!empty($class_c))
        {
            $where['classid']= $class_c;
        }
         if(!empty($studentname))
        {
             $where['wxt_teacher_info.name']= $studentname;
        }
        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);
            $where['mm.userid'] = $userid;

        }else{
            $class=M('school_class')->where("schoolid=$schoolid")->field("id,classname")->order("id")->select();
        }
        $where["mm.type"]=7;

        $where['mm.schoolid'] = $schoolid;
         // 添加分页
        $count=M('microblog_main')
        ->alias("mm")
        ->join("wxt_teacher_info ON wxt_teacher_info.teacherid=mm.userid")
        ->join("wxt_school_class ON wxt_school_class.id=mm.classid")
        ->where($where)
        ->order("write_time DESC")
        ->count();
        $page = $this->page($count, 10);

        session_start();
        $userid_session=$_SESSION["USER_ID"];



        $list=M('microblog_main')
         ->alias("mm")
        ->join("wxt_teacher_info ON wxt_teacher_info.teacherid=mm.userid")
        ->join("wxt_school_class ON wxt_school_class.id=mm.classid")
        ->where($where)
        ->field('mid,userid,wxt_teacher_info.name as name,content,classid,write_time,wxt_teacher_info.schoolid as schoolid,mm.status as status,wxt_school_class.classname,wxt_school_class.grade as grade,wxt_school_class.id as cid')
        ->order("write_time Desc")
        ->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
        ->select();
        //var_dump($list);
        foreach ($list as &$item) {
            $userid=$item["userid"];
            $username=M('teacher_info')->field("name")->where("teacherid=$userid")->find();
            $item["username"]=$username["name"];


            $mid=$item['mid'];
            $count_like=$microblog_like->where(array("microblogid"=>$mid))->count();
            $item['count_like']=$count_like;

             $like_find=$microblog_like->where(array("microblogid"=>$mid,"userid"=>$userid_session))->find();
             if($like_find)
             {
                 $item['like_status']=1;//该用户点过赞则为1
             }
             else
             {
                 $item['like_status']=0;
             }
            $count_comment=$microblog_comment->where(array("microblog_c_id"=>$mid))->count();
            $item['count_comment']=$count_comment;

        }
        $this->assign("class_c",$class_c);
        $this->assign("begintime",$begintime);
        $this->assign("endtime",$endtime);
        $this->assign("search",$search);
        $this->assign("studentname",$studentname);
        $this->assign("class",$class);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display("index");
    }


    public function grow(){
        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        $wxtuser =  M('wxtuser'); 
        $school_class=M('school_class');
        $microblog_main =  M('microblog_main'); 
        $microblog_main_id=$microblog_main
        ->join("wxt_wxtuser ON wxt_wxtuser.id=wxt_microblog_main.userid")
        ->join("wxt_school_class ON wxt_school_class.id=wxt_microblog_main.classid")
        ->where($where)
        ->field('userid,wxt_wxtuser.name as name,content,classid,write_time,wxt_wxtuser.schoolid as schoolid,wxt_microblog_main.status as status,wxt_school_class.classname,wxt_school_class.grade as grade,wxt_school_class.id as cid')
        ->select();
        if($level!=1  && $level!=2)
        {

            $school_class_id = get_teacher_class($userid);


        }else{
            $school_class_id=$school_class->where("schoolid=$schoolid")->field('classname,grade,id')->select();
        }


        $this->assign("categorys",$school_class_id);
        $this->assign("posts", $microblog_main_id);
         $this->display();
    }


    function add_post()
    {   
       $schoolid=$_SESSION['schoolid']; 
        $wxtuser =  M('wxtuser'); 
        $school_class=M('school_class');
        $microblog_main =  M('microblog_main'); 
       // $grade=I('grade');
        $class=I('class');
        $see=I('see');
        $title=I('title');
        $content=I('content');
        // if(empty($grade))
        // {
        //      $this->error("请选择年级");
        // }
        if(empty($class))
        {
             $this->error("请选择班级");
        }
         else
        {
           session_start();
           $userid_session=$_SESSION["USER_ID"];

            $data['content']=$content;
            $data['schoolid']=$schoolid;
            $data['classid']=$class;
            $data['userid']=$userid_session;
            // $data['status']=$see;
            $data['type']=7;
            $data['write_time']=time();

            $result=$microblog_main->add($data);
          
            if ($result) {
            /*
若用 $this->success 则报错 模板不存在:tpl_teacher/simpleboot/Teacher/tpl_admin/simpleboot/Teacher/success.html.html 
            */ 
                $this->error("添加成功！");
            } else {
                $this->error("添加失败！");
            }


        }

    }


    function dianzan()
    {
        session_start();
        $mid=I('mid');
        $type=I('type');
        $userid=$_SESSION["USER_ID"];
        $microblog_like=M('microblog_like');
        if($type=="1")
        {

            $microblog_like_del=$microblog_like
            ->where(array("userid"=>$userid,"microblogid"=>$mid))
            ->delete();
        }
        else if($type=="0")
        {
            $microblog_like_add=$microblog_like
            ->add(array("userid"=>$userid,"microblogid"=>$mid,"liketime"=>time()));
        }

// $this->assign("mid",$mid);
// $this->display();
         $this->index();
    }




    function pinglun()
    {
        session_start();
        $mid=I('mid');//接受动态的id
        $userid=$_SESSION["USER_ID"];
        $wxtuser =  M('wxtuser'); 
        $microblog_comment=M('microblog_comment');

          $microblog_comment_sel=  $microblog_comment
          ->alias("mm")
          ->join("wxt_wxtuser as wwu ON mm.userid=wwu.id")
          ->where(array("microblog_c_id"=>$mid))
          ->order("mm.comment_time Desc")
          ->field("mm.comment_id,mm.microblog_c_id,mm.userid,mm.comment_content,mm.comment_time,wwu.name,mm.status")
          ->select();


          $this->assign("posts", $microblog_comment_sel);
          $this->assign("mid", $mid);//传递动态的id
          $this->display("pinglun");


    }


    function add_pinglun()
    {
        $mid=I('mid');

        $this->assign("mid", $mid);
        $this->display();
    }


    function add_pinglun_post()
    {
         session_start();
         $userid=$_SESSION["USER_ID"];
         $mid=I('mid');
         $comment_content=I('content');
         $comment_time=time();
         $status=1;
         $microblog_comment=M('microblog_comment');
         $data['microblog_c_id']=$mid;
         $data['userid']=$userid;
         $data['comment_content']=$comment_content;
         $data['comment_time']=$comment_time;
         $data['status']=$status;

         $microblog_comment_add=$microblog_comment->add($data);


        $this->pinglun();
      
    }


}

