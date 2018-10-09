<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class MessageController extends TeacherbaseController {
	
	
	function _initialize() {
		// die('asdfasdf');
		parent::_initialize();
		$this->initMenu();
	}
    //后台框架首页
    public function index() {
        $list=M('homework')->order("create_time DESC")->select();
        $this->assign("list",$list);
       	$this->display("homework");
        
    }
    public function lists() {

        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];
        //年级信息查询
        $grades = M('school_grade')->where("schoolid = $schoolid")->field("gradeid,name")->order("id")->select();
      //     var_dump($grades);
      //  exit();
        //班级信息查询
        $class=M('school_class')->field("id,classname")->where("schoolid=$schoolid")->order("id")->select();
        //var_dump($class);


        $where_sub['schoolid'] = $schoolid;
        
        $where_sub['schoolid'] = 0;

       // $where['gradetype'] =
   
        $school = M('school')->where("schoolid=$schoolid")->find();

        $gradetype = $school['schoolgradetypeid'];
        //var_dump($gradetype);
        $where_sub['gradetype'] =$gradetype;     
        //var_dump($school);

        $data['gradetype'] = 0;
        $data['schoolid'] = $schoolid;

         $where_c['gradetype'] = 0;
        $where_c['schoolid'] = 0;
        $where_c['isdefault'] = 0;

 
        
        //自建
        $subject_add = M('default_subject')->where($data)->select();
        //var_dump($subject_add);
        
        //学校类型科目
        $default = M('default_subject')->where($where_sub)->select();
        
       //通用科目
        $currency = M("default_subject")->where($where_c)->select();
        //将学科结果合并发送到前台
        $subject = array_merge($default,$subject_add);

        $subject = array_merge($currency,$subject);


     


        //学科信息查询
        // $subject=M('default_subject')->field("id,subject")->order("id")->select();
        //获取查询条件
        $gradeli = I("grades");
        //var_dump($gradeli);
        $classli=I('class');
        //var_dump($classli); 
        $subli=I('subjectname');
        $search=I('guanjianzi');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        //判断查询条件并添加到where数组中
        if($gradeli){
            $where["grade"] = $gradeli;
            $this->assign("gradeinfo",$gradeli);
            //$where["schoolid"] = $schoolid;
            $join="wxt_school_class c ON c.id=h.classid";
           // $join = "wxt_school_grade g NO g.id"
          $where['h.schoolid'] = $schoolid;
        }else{
            $where["schoolid"] = $schoolid;
        }

        if($classli){
            $where["classid"]=$classli;
            $this->assign("classinfo",$classli);
        }
        if($subli){
            $sub_s=M('default_subject')->field("subject")->where("id=$subli")->find();
            $where["subject"]=$sub_s["subject"];
        }
        if($search){
            $where["title"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        // var_dump($where);
        // var_dump($join);
        // exit();

       // $where['schoolid'] = $schoolid;

        if($level!=1  && $level!=2)
        {

            $where['userid'] = $userid;

        }


        //数据条数
        $count=M('homework')->alias("h")->where($where)->join($join)->count();
        //分页    
        $page = $this->page($count, 20);
        //数据列表
        $list=M('homework')
        ->alias("h")
        ->join($join)
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("h.create_time DESC")
        ->select();

        foreach ($list as &$item) {
            $classid=$item["classid"];
            $userid=$item["userid"];
            $classinfo=M('school_class')->field("classname")->where("id=$classid")->find();
            $item["classname"]=$classinfo["classname"];
            //年级
            $grade=M("school_class")->alias("c")->join("wxt_school_grade s ON s.gradeid=c.grade")->where("c.id=$classid")->field("s.name")->find();
            //var_dump($grade);
            $item["grade"]=$grade["name"];
            $userinfo =M('teacher_info')->field('name')->where("teacherid=$userid")->find();
            $item["name"]=$userinfo["name"];
        }
       // var_dump($list);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        $this->assign("list",$list);
        $this->assign("grade",$grades);
        $this->assign("class",$class);
        $this->assign("subject",$subject);
        $this->display();
         
    }
    public function homework(){


        //用户信息
        $userid=$_SESSION['USER_ID'];

        $schoolid=$_SESSION['schoolid'];

        $level= $_SESSION['level'];


        $where['schoolid'] = $schoolid;
        
        $where['schoolid'] = 0;


   
        $school = M('school')->where("schoolid=$schoolid")->find();

       //如果老师带的科目为空的话就展示所有科目,否则展示所带的科目

        $subject = M('teacher_subject')
                  ->alias("t")
                  ->join("wxt_default_subject d ON d.id=t.subjectid")
                  ->distinct(true)
                  ->where("t.schoolid = $schoolid and t.teacherid = $userid")
                  ->field("d.id,d.subject")
                  ->select();

       if(!$subject)
       {
          $subject = get_subject($schoolid);

       }







        if($level!=1  && $level!=2)
        {

            $class = get_teacher_class($userid);

        }else{
            $class=M('school_class')->where("schoolid=$schoolid")->field("id,classname")->order("id")->select();
        }




       // var_dump($class);

        
        
        //var_dump($subject);
        $classli=I('cl_a');
        $subli=I('sub_a');
        $search=I('search');
        $begintime=I("begintime");
        $endtime=I("endtime");
        $begin=strtotime($begintime);
        $end=strtotime($endtime);
        if($classli){
            $where["classid"]=$classli;
        }
        if($subli){
            $sub_s=M('subject')->field("subjectid")->where("id=$subli")->find();
            $where["subject"]=$sub_s["subject"];
        }
        if($search){
            $where["title"]=array('LIKE',"%".$search."%");
        }
        if($begintime && $endtime){
            $where["create_time"]=array(array('EGT',$begin),array('ELT',$end));
        }
        $count=M('homework')->where($where)->count();    
        $page = $this->page($count, 20);
        $list=M('homework')
        ->alias("h")
        ->where($where)
        ->field("h.*")
        ->order("create_time DESC")
        ->select();
        foreach ($list as &$item) {
            $classid=$item["classid"];
            $userid=$item["userid"];
            $classinfo=M('school_class')->field("classname")->where("id=$classid")->find();
            $item["classname"]=$classinfo["classname"];
            $userinfo=M('wxtuser')->field("name")->where("id=$userid")->find();
            $item["name"]=$userinfo["name"];
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->assign("class",$class);
        $this->assign("subject",$subject);
    	$this->display();
    }
    public function homework_post(){
         $schoolid = $_SESSION['schoolid'];

        if (IS_POST) {
            $class =Intval(I("post.cl"));
            $subject =Intval(I("post.sub"));
            $homework_userid = $_SESSION['USER_ID'];
            $title=I("title");
            $time=I("time");
            $teachername=I('teachername');
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
            if(empty($class)){
                $this->error("请选择班级");
            }
            if(empty($subject)){
                $this->error("请选择科目");
            }
            $sub_name=M('default_subject')->field("subject")->where("id=$subject")->find();
            if($teachername){
                $content=$_POST['content']."-".$teachername;
            }else{
                $content=$_POST['content'];
            }
            $data=array(
                'classid'=>$class,
                'userid'=>$homework_userid,
                'subject'=>$sub_name['subject'],
                'title'=>$title,
                'content'=>$content,
                'photo'=>$_POST['smeta']['thumb'],
                'finish_time'=>$time,
                'schoolid'=>$schoolid,
                'create_time'=>time()
                );
            $homework_add=M('homework')->add($data);
          
           
            if($_POST['smeta']['thumb']){
               $pic  = explode('|',$_POST['smeta']['thumb']);
           
               foreach ($pic as  &$value) {
        
                $arr=explode("/", $value);
         
               $value = $arr[count($arr)-1];
      
              
               $pic_add = M("homework_pic")->add(array("homework_id"=>$homework_add,"picture_url"=>$value));
              }
          }

            $studentlist=M('class_relationship')->field("userid")->where("classid=$class")->select();
    
            // exit()
            //循环插入
            foreach ($studentlist as &$re) {
                $data_re['homework_id']=$homework_add;
                $data_re['receiverid']=$re["userid"];
                $data_re['classid'] = $class;   
                $receive=M('homework_receive')->add($data_re); 
            
            }
            //$receive=M('homework_receive')->add($data_re);
            if($homework_add&&$receive){
                $this->success("添加成功！");
            }else{
                $this->error("添加失败！");
            }
        }
    }


}

