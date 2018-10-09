<?php
/*
 * 年级
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class TeacherGradeController extends TeacherbaseController{


    function _initialize() {
        parent::_initialize();

    }
 
  public function index()
  {
  	$schoolid=$_SESSION['schoolid'];

     $re = M('school')->where("schoolid=$schoolid")->find();

     $type = $re['schoolgradetypeid'];

     $se_grade = M('gradedictionary')->where("schooltype=$type")->select();
   //var_dump($se)
     $grade = M('gradedictionary')->select(); 
     
    // var_dump($grade);
     $schoo_grade=M('school_grade')->where("schoolid=$schoolid")->order("gradeid asc")->select();
     
     for($i = 0; $i<count($grade);$i++)
     {
     	for($j =0; $j<count($schoo_grade);$j++)
     	{
     		if($grade[$i]['id']==$schoo_grade[$j]['gradeid'])
     		{
     			$schoo_grade[$j]['cname']=$grade[$i]['name'];
     			//$schoo_grade[$j]['cid']=$grade[$i]['id'];
     		}
     	}
     }
   
    
   //   var_dump($schoo_grade);
   // var_dump($se_grade);
    
    $this->assign("schoo_grade",$schoo_grade);
    $this->assign("se_grade",$se_grade);
    $this->display();

  }

   //修改年级段
    public function edit()
    {

      $classid = I('classid');
       $classname = I('rel');
       $gradeid = I('cid');

       $data = array(
           'name'=>$classname,
           'gradeid'=>$gradeid,
           'edit_time'=>time(),
       	);
               
        $grade = M('school_grade')->where("id=$classid")->setField($data);

        if ($grade > 0) {
                        $info['status'] = true;
                        $info['msg'] = $grade;
                    } else {
                        $info['status'] = false;
                        $info['msg'] = '404';
               }
             echo json_encode($info);               


    }

    //向模板发送

   public function add(){
		//获取登录用户的信息
		//$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //向模板传送本校的年级信息
		// $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		// var_dump($grade);
   
		$school = M('school')->where("schoolid=$schoolid")->find();
		//var_dump($school);
        $gradeid = $school['schoolgradetypeid'];
       //var_dump($gradeid);
		$grade = M('gradedictionary')->where("schooltype=$gradeid")->select();
		//var_dump($grade);
		// $teachers=M("teacher_class")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
		// $this->assign("teachers",$teachers);
		$this->assign("grade",$grade);
		$this->display();
	}
     
      //添加年级和年级名称
		public function add_post(){
		
      // echo "sadsa";
		if(IS_POST){
			
              

			//获取登录用户的信息
			$schoolid=$_SESSION['schoolid'];
			//获取页面传回的信息
			$grade=intval(I("grade"));

      if(!$grade)
      {
        $this->error("请选择年级!");
      }

			$where['schoolid']=$schoolid;
			$where['gradeid'] = $grade;
           //查询年级是否已经存在 如果存在 直接跳出
			$result = M('school_grade')->where($where)->find();

			if($result)
			{
				$this->error('该年级已经存在!');
				return;
			}

			$classname=I("classname");
			
      if(!$classname)
      {
        $this->error("请输入名称!");
      }
			// var_dump($grade);
			// var_dump($classname);
			// exit();
			$data['gradeid']=$grade;
			$data["schoolid"]=$schoolid;
			$data["name"]=$classname;
			$data["edit_time"]=time();
			// $data["type"]=$type;
			$class=M('school_grade')->add($data);
			if($class){
			$this->success('添加成功');
			
		  }else{
		  	$this->error("添加失败");
		  }
	   }
   }














}