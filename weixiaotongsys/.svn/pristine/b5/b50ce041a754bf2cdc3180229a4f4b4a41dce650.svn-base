<?php

/**
 * 后台首页 
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class GroupController extends TeacherbaseController{

    function _initialize() {
        parent::_initialize();

    }

	public function index(){
		$schoolid=$_SESSION['schoolid'];
		$department=M("department")->where("schoolid=$schoolid and status = 2")->order("id")->select();
		foreach ($department as &$item) {
			$de_id=$item["id"];
			$member=M("department_teacher")->alias("t")->join("wxt_teacher_info w ON w.teacherid=t.teacher_id")->where("t.department_id=$de_id")->field("w.id,w.name")->select();
			$item["member"]=$member;
			$count=M("department_teacher")->where("department_id=$de_id")->count();
			$item["count"]=$count;
		}
		$where["d.schoolid"]=$schoolid;
//		$teacher=M("teacher_info")->alias("d")->join("wxt_wxtuser w ON w.id=d.teacherid")->where($where)->field("w.id,d.name")->distinct(true)->select();
		$teacher=M("teacher_info")->alias("d")->where("d.schoolid = $schoolid")->field("d.id,d.name")->distinct(true)->select();

		$this->assign("department",$department);

		$this->assign("teacher",$teacher);

		$this->display();
	}
	//获取本科室都有哪些老师
	public function department_teacher(){
		$department_id=I("department_id");
		$teachers=M("department_teacher")->where("department_id=$department_id")->field("teacher_id")->select();
		if($teachers){
            $ret = $this->format_ret(1,$teachers);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
	}
	//搜索老师
	public function teacher_search(){
		$schoolid=$_SESSION['schoolid'];
		$teacher_name=I("teacher_name");
		$where["d.name"]=array("LIKE","%".$teacher_name."%");
		$where["d.schoolid"]=$schoolid;
		$teacher_info=M("teacher_info")->alias("d")->join("wxt_wxtuser w ON w.id=d.teacherid")->where($where)->field("d.id,d.name")->distinct(true)->select();
		if($teacher_info){
            $ret = $this->format_ret(1,$teacher_info);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
	}
	//通过科室id获取本科室都有哪些老师
    public function teacher_in(){
        $de_id=I("de_id");
        $teacher=M("department_teacher")->where("department_id=$de_id")->field("teacher_id")->select();
        if($teacher){
            $ret = $this->format_ret_else(1,$teacher);
        }else{
            $ret = $this->format_ret_else(0,"lost params");
        }
        echo json_encode($ret);
        exit;
    }
    //保存老师所在部门设置
    public function save_relation(){
        $schoolid=$_SESSION['schoolid'];
        $department_id=I("department_id");
        $teacher_arr=I("teacher_arr");
        //先把原有对应的部门关系删除,然后再加
        $delete=M("department_teacher")->where("department_id=$department_id")->delete();
        foreach ($teacher_arr as &$teacherid) {
            $data["teacher_id"]=$teacherid;
            $data["school_id"]=$schoolid;
            $data["department_id"]=$department_id;
            $add=M("department_teacher")->add($data);
        }  
        if($delete){
            $this->success("保存成功");
        }else{
            $this->error("保存失败");
        }
    }
    //新增分组
    public function save_de(){
    	$data["schoolid"]=$_SESSION['schoolid'];
    	$data["name"]=I("dep_name");
    	$data["number"]=I("dep_id");
        $data['status'] = I("status");
    	$data["create_time"]=time();
    	$add=M("department")->add($data);
    	if($add){
    		$this->success("成功");
    	}else{
    		$this->error("失败");
    	}
    }
    //删除部门
    public function delete(){
    	$id=I("id");
    	$delete=M("department")->where("id=$id")->delete();
    	if($delete){
    		$this->success("成功");
    	}else{
    		$this->error("失败");
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
    //参数获取(状态，原因)
    function format_ret_else ($statues, $date='') {
        if ($statues){   
        //成功
            return array('statues'=>'success', 'date'=>$date);
        }else{  
            //验证失败
            return array('statues'=>'error', 'date'=>$date);
        }
    }
   
   //获取学生分组
    public function list_info()
    {
         $schoolid=$_SESSION['schoolid'];
		$department=M("department")->where("schoolid=$schoolid and status = 1")->order("id")->select();

		foreach ($department as &$item) {
			$de_id=$item["id"];
			$member=M("department_teacher")->alias("t")->join("wxt_student_info w ON w.userid=t.teacher_id")->where("t.department_id=$de_id")->field("w.id,w.stu_name as name")->select();
			$item["member"]=$member;
			$count=M("department_teacher")->where("department_id=$de_id")->count();
			$item["count"]=$count;
		}
		$where["schoollid"]=$schoolid;
		$student=M("student_info")->where($where)->field("userid,stu_name")->distinct(true)->select();

    
		$this->assign("department",$department);
  
		$this->assign("teacher",$student);
		$this->display();
     

    }
  
  public function student_search(){
		$schoolid=$_SESSION['schoolid'];
		$teacher_name=I("teacher_name");
		$where["stu_name"]=array("LIKE","%".$teacher_name."%");
		$where["schoollid"]=$schoolid;
		$teacher_info=M("student_info")->where($where)->field("userid,stu_name")->distinct(true)->select();
		if($teacher_info){
            $ret = $this->format_ret(1,$teacher_info);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
	}


}