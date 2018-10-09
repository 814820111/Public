<?php
/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class DynamicController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

	  public function index(){
          //用户信息
          $userid=$_SESSION['USER_ID'];

          $schoolid=$_SESSION['schoolid'];

          $level= $_SESSION['level'];
        $where['wxt_teacher_info.schoolid']= $schoolid;
        $wxtuser =  M('wxtuser'); 
        $school_class=M('school_class');
        $microblog_main =  M('microblog_main');  //microblog_main表中    高德江 681
        $microblog_like=M('microblog_like');
        $microblog_comment=M('microblog_comment');
        
        $grade=I('grade');
        $class=I('class');
        $keyword=I("keyword");
        $issuer=I('issuer');
        $start_time=I('start_time');
        $end_time=I('end_time');
        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);


         if(!empty($grade))
        {
            $where['wxt_school_class.grade']= $grade;
            $this->assign("gradeinfo",$grade);
        }
        if(!empty($keyword)){
        	   $where["mm.content"]=array('like', "%$keyword%");
        }
        
        if(!empty($class))
        {
            $where['classid']= $class;
            $this->assign("classinfo",$class);
        }
        if(!empty($issuer))
        {
            $where['wxt_teacher_info.name']= array('like', "%$issuer%");
        }
        if($start_time && $end_time){
            $where["write_time"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
        }
//        $where['mm.type']=1;
        $where['mm.schoolid'] = $schoolid;
  

        $school_class_id=$school_class->where("schoolid=$schoolid")->field('classname,grade,id')->select();//获取学校的年级
        $school_grade=M("school_grade")->where("schoolid=$schoolid")->field("name,gradeid")->select();


          if($level!=1  && $level!=2)
          {

              $where['teacher.schoolid'] = $schoolid;
              $where['teacher.teacherid'] = $userid;
              $join_duty = 'wxt_teacher_class teacher ON mm.classid=teacher.classid';

          }
        // 添加分页
         $count=$microblog_main
        ->alias("mm")
        ->join("wxt_teacher_info ON wxt_teacher_info.teacherid=mm.userid")
        ->join("wxt_school_class ON wxt_school_class.id=mm.classid")
        ->join($join_duty)
        ->where($where)
        ->order("write_time Desc")
        ->count();


        $page = $this->page($count, 10);
        $microblog_main_id=$microblog_main
        ->alias("mm")
        ->join("wxt_teacher_info ON wxt_teacher_info.teacherid=mm.userid")
        ->join("wxt_school_class ON wxt_school_class.id=mm.classid")
        ->where($where)
        ->field('mid,userid,wxt_teacher_info.name as name,content,classid,write_time,wxt_teacher_info.schoolid as schoolid,mm.status as status,wxt_school_class.classname,wxt_school_class.grade as grade,wxt_school_class.id as cid')
        ->order("write_time Desc")
        ->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
        ->select();

        //var_dump($microblog_main_id);
         session_start();
         $userid=$_SESSION["USER_ID"];
        foreach ($microblog_main_id as &$val) {
            $mid=$val['mid'];
            $grade=$val["grade"];
            $like_select=$microblog_like->where(array("microblogid"=>$mid))->count();
            $val['count_like']=$like_select;

             $like_find=$microblog_like->where(array("microblogid"=>$mid,"userid"=>$userid))->find();
             if($like_find)
             {
                 $val['like_status']=1;//该用户点过赞则为1
             }
             else
             {
                 $val['like_status']=0;
             }
            $count_comment=$microblog_comment->where(array("microblog_c_id"=>$mid))->count();
            $val['count_comment']=$count_comment;
            $gradename=M("school_grade")->where("gradeid=$grade")->field("name")->select();
            $gradeti=$gradename["0"]["name"];
            $val["gradename"]=$gradeti;
        }
        $this->assign("keyword",$keyword);
        $this->assign("end_time",$end_time);
        $this->assign("start_time",$start_time);
        $this->assign("issuer",$issuer);
        $this->assign("school_grade",$school_grade);
        $this->assign("categorys",$school_class_id);
        $this->assign("posts", $microblog_main_id);
       //var_dump($microblog_main_id);
        $this->assign("Page", $page->show('Admin'));   // 添加分页
        $this->display("index");
   }
    function add()
    {
       $schoolid=$_SESSION['schoolid']; 
        $wxtuser =  M('wxtuser'); 
        $school_class=M('school_class');
        $microblog_main =  M('microblog_main');  //microblog_main表中    高德江 681
        $microblog_main_id=$microblog_main
        ->join("wxt_wxtuser ON wxt_wxtuser.id=wxt_microblog_main.userid")
        ->join("wxt_school_class ON wxt_school_class.id=wxt_microblog_main.classid")
        ->where($where)
        ->field('userid,wxt_wxtuser.name as name,content,classid,write_time,wxt_wxtuser.schoolid as schoolid,wxt_microblog_main.status as status,wxt_school_class.classname,wxt_school_class.grade as grade,wxt_school_class.id as cid')
        ->select();
        $school_class_id=$school_class->where("schoolid=$schoolid")->field('classname,grade,id')->select();
        $seach_grade=M("school_grade")->where("schoolid=$schoolid")->field("name,gradeid")->select();
    
        $this->assign("seach_grade",$seach_grade);
        $this->assign("categorys",$school_class_id);
        $this->assign("posts", $microblog_main_id);
         $this->display("add");

    }


    function add_post()
    {
      $schoolid=$_SESSION['schoolid'];
        $wxtuser =  M('wxtuser'); 
        $school_class=M('school_class');
        $microblog_main =  M('microblog_main');  //microblog_main表中    高德江 681
        $content=I('content');
        $grade=I('grade');
        $class=I('class');
        $see=I('see');
        $title=I('title');
        if(empty($grade))
        {
             $this->error("请选择年级");
        }
         else if(empty($class))
        {
             $this->error("请选择班级");
        }
        else if(empty($title))
        {
             $this->error("请输入标题");
        }
        else
        { session_start();
          $userid=$_SESSION["USER_ID"];

            $data['content']=$content;
            $data['schoolid']=$schoolid;
            $data['classid']=$class;
             $data['userid']=$userid;
            // $data['status']=$see;
            $data['type']=1;
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

         // $this->index();
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