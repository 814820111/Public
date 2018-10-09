<?php
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class PlanController extends TeacherbaseController{
    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }


	public function index(){
		$userid=$_SESSION['USER_ID'];
		//var_dump($userid);
        $schoolid=$_SESSION['schoolid'];
        //本校班级
//        $class=M("school_class")->where("schoolid=$schoolid")->select();


        if($this->level!=1  && $this->level!=2)
        {
            $class=M("teacher_class")
                ->alias('t')
                ->join("wxt_school_class s ON t.classid=s.id")
                ->where("t.teacherid=$userid")
                ->field("s.classname,s.id,s.grade")
                ->order("id")->select();


        }else{
            $class=M("school_class")->where("schoolid=$schoolid")->select();
        }





        $this->assign("class",$class);

        // var_dump($class);
		$this->display();
	}
	public function index_post(){
		$userid=$_SESSION['USER_ID'];
		$schoolid=$_SESSION['schoolid'];
		$class_arr=I("class_arr");
		if($class_arr){
			foreach ($class_arr as &$classid) {
				$data["schoolid"]=$schoolid;
				$data["classid"]=$classid;
				$data["userid"]=$userid;
				$data["title"]=I("title");
				$data["monday"]=I("monday");
				$data["tuesday"]=I("tuesday");
				$data["wednesday"]=I("wednesday");
				$data["thursday"]=I("thursday");
				$data["friday"]=I("friday");
				$data["saturday"]=I("saturday");
				$data["sunday"]=I("sunday");
				$data["begintime"]=strtotime(I("begin_time"));
				$data["endtime"]=strtotime(I("end_time"));
				$data["workpoint"]=I("workpoint");
				$data["create_time"]=time();
				$add=M("school_plan")->add($data);
			}
			$this->success('保存成功','lists');
		}else{
			$this->error('保存失败');
		}
	}
	public function lists(){
		$schoolid=$_SESSION['schoolid'];
		$teacherid = $_SESSION['USER_ID'];
		$grade=M("school_grade")->where("schoolid=$schoolid")->order("id")->select();
		// var_dump($grade);
		$class=M("teacher_class")
            ->alias('t')
            ->join("wxt_school_class s ON t.classid=s.id")
            ->where("t.teacherid=$teacherid")
            ->field("s.classname,s.id,s.grade")
            ->order("id")->select();
  

		// foreach ($class as &$item){
		//     $item_gid= $item['grade'];
  //          $grade_item = M("school_grade")->where("id=$item_gid")->select();
  //          array_push($grade,$grade_item);
  //          unset($grade_item);
  //       }

		$where["schoolid"]=$schoolid;
		$g_id=I("school_grade");
	
		$c_id=I("school_class");
		
		if($g_id){
		   $this->assign("gradeinfo",$g_id);   
			if($c_id){
				$where["classid"]=$c_id;
				$this->assign("classinfo",$c_id);
			}else{
				$cla=array();
				$class_arr=M("school_class")->where("grade=$g_id")->field("id")->select();
				foreach ($class_arr as &$classid) {
					$c=$classid["id"];
					array_push($cla, $c);
				}
				$where["classid"]=array("in",$cla);
			}
		}
		$begin_time=strtotime(I("begin_time"));
		if($begin_time){
			$where["begintime"]=array("egt",$begin_time);
		}
		$end_time=strtotime(I("end_time"));
		if($end_time){
			$where["endtime"]=array("elt",$end_time);
		}
		$lists=M("school_plan")->where($where)->order("create_time DESC")->select();
	
		foreach ($lists as &$item) {
			$classname=M("school_class")->where(array("id"=>$item["classid"]))->find();
			$item["classname"]=$classname["classname"];
		}
		
		$this->assign("grade",$grade);
		$this->assign("class",$class);
		$this->assign("lists",$lists);
		$this->display();
	}
	//通过年级选班级
	public function class_json(){
		$grade=I("grade");
		//var_dump($grade);
		$schoolid=$_SESSION['schoolid'];

		$userid = $_SESSION['USER_ID'];
		//var_dump($userid);
//		$all_class=M("school_class")->where("grade=$grade")->order("id")->select();


		$school_grade = M('school_grade')->where("gradeid=$grade and schoolid = $schoolid")->find();
	
        
       if($school_grade)
       {
       	$cc = $school_grade['gradeid'];
  
       	$class_t = M("school_class")->where("schoolid = $schoolid and grade = $cc")->select();
  
       }   
     
		
        // $class_t=M("teacher_class")
        //     ->alias('t')
        //     ->join("wxt_school_class s ON t.classid=s.id AND t.teacherid=$userid")
        //     ->field("s.classname,s.id")
        //     ->order("id")->select();
//        $class = array();
//        foreach ($all_class as &$item){
//            foreach ($class_t as &$cItem){
//                $flag = false;
//                if ($item.id === $cItem.id){
//                    $flag = true;
//                    break;
//                }
//            }
//            if ($flag){
//                array_push($class,$item);
//            }
//        }
            // var_dump($class_t);
		if($class_t){
			$ret = $this->format_ret(1,$class_t);
		}else{
			$ret = $this->format_ret(0,"lost params");
		}
		echo json_encode($ret);
        exit;
	}
	//修改
	public function edit(){
		$id=I("id");
		$plan=M("school_plan")->alias("s")->join("wxt_school_class c ON c.id=s.classid")->where("s.id=$id")->field("s.*,c.classname")->find();
		$this->assign("plan",$plan);
		$this->display();
	}
	public function edit_post(){
		$userid=$_SESSION['USER_ID'];
		$id=I("plan_id");
		if($id){
			foreach ($class_arr as &$classid) {
				$data["userid"]=$userid;
				$data["title"]=I("title");
				$data["monday"]=I("monday");
				$data["tuesday"]=I("tuesday");
				$data["wednesday"]=I("wednesday");
				$data["thursday"]=I("thursday");
				$data["friday"]=I("friday");
				$data["saturday"]=I("saturday");
				$data["sunday"]=I("sunday");
				$data["begintime"]=strtotime(I("begin_time"));
				$data["endtime"]=strtotime(I("end_time"));
				$data["workpoint"]=I("workpoint");
				$data["create_time"]=time();
				$save=M("school_plan")->where("id=$id")->save($data);
			}
		}
	}
	public function delete(){
		$id=I("id");
		$delete=M("school_plan")->where("id=$id")->delete();
		if($delete){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}

	//参数获取(状态，原因)
    function format_ret ($status, $data='') {
        if ($status){	
        //成功
            return array('status'=>'success', 'data'=>$data);
        }else{	
        	//验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
}