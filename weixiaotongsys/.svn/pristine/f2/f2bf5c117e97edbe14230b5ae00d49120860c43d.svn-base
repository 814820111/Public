<?php

/**
 *   教学办公-》工作事务-》待办事宜
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

 header("Content-type: text/html; charset=utf-8"); 
class ToduScheduleController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }






    function index_find()
	{
    
    $schoolid = $_SESSION['schoolid'];


		$title=I('title');
		$username=I('username');
		$status=I('status');//因为0传不过来所以用2，1已完成，0（2）办理中

		$start_time=I('start_time');
        $end_time=I('end_time');
        $start_time_unix=strtotime($start_time);//将任何英文文本的日期或时间描述解析为 Unix 时间戳
        $end_time_unix=strtotime($end_time);


		$schedule=M('schedule');
		$wxtuser =  M('wxtuser'); 

		
		
		$where=array();
		if($status==1)
		{
			$where['s.status']= '1';
		}
		else if($status==2)
		{
			$where['s.status']= '0';
		}
		$this->assign("status",$status);
        if(!empty($username))
        {
             array_push($where, "u.name like '%$username%' ");
             $this->assign("username",$username);
        }

		if(!empty($title))
        {
            array_push($where, "s.title like '%$title%' ");
            $this->assign("title",$title);
        }

        if($start_time && $end_time){
            $where["s.create_time"]=array(array('EGT',$start_time_unix),array('ELT',$end_time_unix));
        }

		$field="s.id as s_id,s.userid,s.schoolid,s.title,s.content,s.create_time,s.status,u.name as author_name";

        if($this->level!=1  && $this->level!=2)
        {


            $where['s.userid'] = $this->userid;


        }


  $where['s.schoolid'] = $schoolid;

		$count=$schedule
		->alias('s')
		->where($where)
		->join("wxt_wxtuser u ON u.id = s.userid")
		->field($field)
		->count();
		$page = $this->page($count, 20);


		$lists=$schedule
		->alias('s')
		->join("wxt_wxtuser u ON u.id = s.userid")
		->field($field)
		->where($where)
		->order("create_time Desc")
		->limit($page->firstRow . ',' . $page->listRows)   // 添加分页
		->select();

        
        $this->assign("lists", $lists);
        $this->assign("Page", $page->show('Admin'));   // 添加分页

		$this->display("index_find");

	}


	function add()
	{

       $schoolid = $_SESSION['schoolid'];

       $teachers = M('teacher_info')
                  ->alias("t") 
                  ->where("t.schoolid = $schoolid")
                  ->join("wxt_wxtuser u ON t.teacherid=u.id")
                  ->field("u.id,u.name")
                  ->select();
              

           $this->assign("teachers", $teachers);        


		$this->display("add");
	}

	function add_post()
	{   
        $schoolid = $_SESSION['schoolid'];
        //var_dump($schoolid); 

		$userid=$_SESSION['USER_ID'];
		//var_dump($userid);

		$title = I('title');
		//var_dump($title);

		$content = I('content');
		//var_dump($content);

		$teacherid = I('teacher');
		//var_dump($teacherid);
		
		$schedule_add = array(
                'userid'=> $userid,
                'schoolid'=>$schoolid,
                'title'=>$title,
                'content'=>$content,
                'create_time'=>time(),
                'status'=> 0


			);
       
        $schedule = M('schedule')->add($schedule_add);
        
        if($schedule)
        { 
            
          $add_1 = array(
                'previousid' => 0,
                'scheduleid' =>$schedule,
                'userid'=>$teacherid,
                'receiverid'=>$userid,
                'feedback' =>$content,
                'finish'=>1,
                'read_time'=>time(),
                'do_time'=>time(),
                'create_time'=>time()-1,

          	);

          $add_one = M('schedule_reception')->add($add_1);
          if($add_one)
          {
          	$add_2 = array(
               'previousid' => $add_one,
                'scheduleid' =>$schedule,
                'userid'=>0,
                'receiverid'=>$teacherid,
                'finish'=>0,
                'create_time'=>time(),
          		);

          	$add_two = M('schedule_reception')->add($add_2);

          }
		}

    if($add_two)
    {
      $this->success('发送成功','index_todo');
    }
	}


	function index_todo()
	{
		$schedule=M('schedule');
		$wxtuser =  M('wxtuser'); 
   




       $userid=$_SESSION['USER_ID'];
       $schoolid = $_SESSION['schoolid'];

     $teachers = M('teacher_info')
               ->alias("s") 
               ->where("s.schoolid=$schoolid")
               ->join("wxt_wxtuser u ON s.teacherid=u.id")
               ->field("u.id,s.name")
               ->select();
        
        $where['sr.receiverid'] = $userid;
        $where['sr.finish'] = 0;
         
        $count = M('schedule_reception')
        ->alias('sr')
        ->where($where)
        ->join("wxt_schedule s ON sr.scheduleid = s.id")
        ->join("wxt_wxtuser u ON u.id=s.userid")
        ->field("sr.receiverid,s.userid,sr.finish,u.name as s_name,sr.previousid,s.content,s.id,sr.scheduleid,s.title")
        ->count();
   $page = $this->page($count, 20);


        $reception = M('schedule_reception')
        ->alias('sr')
        ->where($where)
        ->join("wxt_schedule s ON sr.scheduleid = s.id")
        ->join("wxt_wxtuser u ON u.id=s.userid")
        ->limit($page->firstRow . ',' . $page->listRows) 
        ->field("sr.receiverid,s.userid,sr.finish,u.name as s_name,sr.previousid,s.content,s.id,sr.scheduleid,s.title,sr.id,sr.read_time,s.create_time")
        ->select();
        // var_dump($reception);


     
      foreach ($reception as &$value) {
           
        $scheduleid = $value['scheduleid'];



        $re = M('schedule_reception')->where("scheduleid = $scheduleid")->select();
        // var_dump($re);
        

        for ($i=0; $i < count($re) ; $i++) { 
        	
        }
         $value['step'] = '第'.$i.'步';

        $next_id = $value['previousid'];

        $next = M('schedule_reception')->field("receiverid,id,feedback")->where("id=$next_id")->find();
       // var_dump($next);
        
        $userid = $next['receiverid'];
        $sr_id = $next['sr_id'];

       $value['feedback'] = $next['feedback'];
        $re = M("wxtuser")->where("id=$userid")->field("name")->find();

        $value['next_name'] = $re['name'];

         // var_dump($next);
      

      }
   // var_dump($reception);
       
     
       // var_dump($lists);
        $this->assign("teachers",$teachers);
        $this->assign("lists", $reception);
        $this->assign("Page", $page->show('Admin'));   // 添加分页
		$this->display("index_todo");
	}
    

  function show_t()
  {
     $scheduleid = I('id');

     $result = M('schedule_reception')
            ->alias("sr")
            ->where("sr.scheduleid = $scheduleid")
            ->join("wxt_wxtuser u ON  sr.receiverid = u.id")
            ->order('sr.create_time')
            ->field("u.name,sr.feedback,sr.id,sr.scheduleid,sr.read_time,sr.do_time,sr.finish,sr.receiverid,sr.create_time")
            ->select();
   
    $i = 1;
   foreach ($result as &$value) {
    
     $value['create_time'] = date('Y-m-d H:i:s',$value['create_time']);

     $value['read_time'] = date('Y-m-d H:i:s',$value['read_time']);

     $value['do_time'] = date('Y-m-d H:i:s',$value['do_time']);

     if($value['finish']==1)
     {
      $value['status'] = '已完结';
     }else{
      $value['status'] = '办理中';
     }    


    $value['step'] = '第'.$i.'步';

     $i++;

   }

      if ($result){
              $info['status'] = true;
             $info['msg'] = $result;
              }else{
                $info['status'] = false;
                 $info['msg'] = '404';
             }
               echo json_encode($info);     
   



  }


  function banli()
  {
    $id = I('id');

    $schedule_reception = M('schedule_reception')->where("id=$id")->save(array("read_time"=>time()));
   if ($schedule_reception > 0){
              $info['status'] = true;
             $info['msg'] = $result;
              }else{
                $info['status'] = false;
                 $info['msg'] = '404';
           }
       echo json_encode($info);  

  }

  function work_post()
  {
    $type = I('todo');

    $id = I('schedule');
    
    $next_id = I('next_id');

    $content = I('content');
 
    // exit();
    
    
    if ($type == 1) {
       $teachers = I('teachers');

      $old_sched = M('schedule_reception')->where("id=$id")->save(array('finish'=>1,'feedback'=>$content,'do_time'=>time()));
         if($old_sched > 0)
         {
            $data = array(
                'previousid'=>$id,
                'scheduleid'=>$next_id,
                'receiverid'=>$teachers,
                // 'feedback'=>$content,
                'finish' => 0,
                'create_time'=>time(),  

              );

            $reception = M('schedule_reception')->add($data);
         }
      
   
    
    }else{
      
     
       $old_sched = M('schedule_reception')->where("id=$id")->save(array('finish'=>1,'feedback'=>$content,'do_time'=>time()));

         if($old_sched > 0)
         {
          $schedule = M('schedule')->where("id=$next_id")->save(array('status'=>1));
          // var_dump($schedule);
         }

    }

  
    $this->success('成功'); 

  }


	function index_done()
	{
		$schedule=M('schedule');
		$wxtuser =  M('wxtuser'); 

		$schoolid = $_SESSION['schoolid'];

		$userid=$_SESSION['USER_ID'];

    $where['receiverid'] = $userid;
    $where['finish'] = 1;



  $reception = M('schedule_reception')
        ->alias('sr')
        ->where($where)
        ->group("scheduleid")
        ->field("scheduleid")
        ->select();


$list = array();
$i = 1;
foreach ($reception as $key => $value) {
   $scheduleid = $value['scheduleid'];
   

   $schedule = M('schedule')->alias('s')->where("s.id=$scheduleid")->join('wxt_wxtuser u ON u.id=s.userid')->field("s.title,s.content,s.create_time,u.name,s.status")->find();

   $where_re['scheduleid'] = $scheduleid;

  $result = M('schedule_reception')->where($where_re)->select();

  
  
 $i = 1;


  foreach ($result as  &$val) {
    $val['step'] = "第".$i."步";
    $val['title'] = $schedule['title'];
    $val['content'] = $schedule['content'];
    $val['create_time'] = $schedule['create_time'];
    $val['one_name'] = $schedule['name'];
    $val['status'] = $schedule['status'];
    $list[] = $val;

    $i++;
  }
    
     

}

$arr = array();

foreach ($list as $key => $va) {
  if($va['receiverid']==$userid)
  {
       $arr[] = $va;
  }
}




    $this->assign("lists", $arr);
		$this->display("index_done");

	}




}