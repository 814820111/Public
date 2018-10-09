<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class HomeWorkController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->class_model = D("Common/school_class");
        $this->wxt_agent_model=D("Common/agent");
        $this->homework_model=D("Common/homework");
        $this->microblog_pic_url_model=D("Common/microblog_picture_url");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($status=1){
        $school_id=0;
        
         $class = I('class');

         $school = I('school');

         if($school)
         {
            $where['schoolid'] = $school;
         }
      

         if($class)
         {
            $where['classid'] = $class;
         }
       


       
   

        $school = M("school")->field("schoolid,school_name")->select();
        // var_dump($school);
        

  
        
       
            
        $count=$this->homework_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
           

            
        $posts=$this->homework_model
        ->field('id,title,userid,subject,classid,photo,content,create_time,status')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("id DESC")->select();
 
        foreach ($posts as &$user) {
             $username=$this->wxtuser_model
            ->alias("user")
            ->join("wxt_microblog_main pic")
            ->where(array("user.id"=>$user['userid']))
            ->field('name')
            ->find();
          
            $classid = $user['classid'];
            $classname = M('school_class')->where("id = $classid")->field("classname")->find();

            $user['classname'] = $classname['classname'];

            $user["username"]=$username["name"];
            unset($user);
        }
        //  foreach ($posts as &$class) {
        //      $class_name=$this->class_model
        //     ->alias("cl")
        //     ->join("wxt_microblog_main pic")
        //     ->where(array("cl.schoolid"=>$class['classid']))
        //     ->field('classname')
        //     ->find();

        //     $class["class_name"]=$class_name["classname"];
        //     unset($class);
        // }
        $this->assign("school",$school);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("posts",$posts);
    }

    //---------------布置作业----------------
    function add()
    {  
       $school = M("school")->field("schoolid,school_name")->select();
    
       
       $this->assign("school",$school); 
       $this->display(); 
    }

  function  subject()
  {
      $schoolid = I('schoolid');


        $where['schoolid'] = $schoolid;
        
        $where['schoolid'] = 0;

       // $where['gradetype'] =
   
        $school = M('school')->where("schoolid=$schoolid")->find();

        $gradetype = $school['schoolgradetypeid'];
        //var_dump($gradetype);
        $where['gradetype'] =$gradetype;
       
        //var_dump($school);


        $data['gradetype'] = 0;
        $data['schoolid'] = $schoolid;

        $where_c['gradetype'] = 0;
        $where_c['schoolid'] = 0;
        $where_c['isdefault'] = 0;

        $subject_add = M('default_subject')->where($data)->select();
        //var_dump($subject_add);

        $default = M('default_subject')->where($where)->select();

        //通用科目
        $currency = M("default_subject")->where($where_c)->select();

        $subject = array_merge($default,$subject_add);
       
        $subject = array_merge($currency,$subject);
     

        if ($subject){
            $ret = format_ret(1,$subject);
            echo json_encode($ret);
        }else{
            $ret = format_ret(0,"parms lost");
            echo json_encode($ret);
        }


  }


  function teacher()
  {
       
     $class = I('classid');

     $teacher_class = M('teacher_class')->alias("t")->join("wxt_wxtuser u ON  u.id = t.teacherid")->field("u.name,u.id")->where("t.classid = $class")->select();

    if ($teacher_class){
            $ret = format_ret(1,$teacher_class);
            echo json_encode($ret);
        }else{
            $ret = format_ret(0,"parms lost");
            echo json_encode($ret);
        }   
       


  }

  function add_post()
  {
      $schoolid = I('school');   
      
      $class = I('class');

      $title = I('title');

      $subject = I('subject');

      $content = I('content'); 

      $time = I('time');

      $teacher = I('teacher');

      $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
  
      if($subject){

        $subject = M('default_subject')->where("id = $subject")->field('subject')->find();

        $subject_name = $subject['subject'];
      }

      $data = array(
           'schoolid'=>$schoolid,
           'title'=>$title,
           'userid'=>$teacher,
           'subject'=>$subject,
           'classid'=>$class,
           'content'=>$content,
           'photo'=>$_POST['smeta']['thumb'],
           'create_time'=>strtotime($time),
           'status'=>1,
           

        );

  $add_work = M('homework')->add($data);

  if($add_work)
  {
    $this->success('布置成功!');
  }else{
    $this->error('布置失败!');
  }
        

  }


      function format_ret ($status, $data='') {
        if ($status){
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }



//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->homework_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }

    //排序
    public function listorders() {
        $status = parent::_listorders($this->job_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }

    private function _getTree(){
		$schoolid=empty($_REQUEST['class'])?0:intval($_REQUEST['class']);
		$result = $this->class_model->field("id ,classname as name")->order(array("id"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['classid']=$r['id'];
			$r['selected']=$id==$r['classid']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
}