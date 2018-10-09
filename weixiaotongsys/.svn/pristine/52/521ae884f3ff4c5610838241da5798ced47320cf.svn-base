<?php

/**
 * 兴趣班管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class PlayGroupController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();
        $this -> userid =$_SESSION['USER_ID'];
        $this -> schoolid =$_SESSION['schoolid'];
        $this -> level =$_SESSION['level'];


    }
	public function index(){
		//获取登录用户的信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //搜索
        $search_grade=I("search_grade");
		//获取班级的相关信息
		$where["c.schoolid"]=$schoolid;
		$where["c.type"]=2;
        if($this->level!=1  && $this->level!=2)
        {
            $where['teacher.schoolid'] = $schoolid;
            $where['teacher.teacherid'] = $userid;
            $join_duty = 'wxt_teacher_class teacher ON c.id=teacher.classid';


        }
		$class_list=M("school_class")->alias("c")->join($join_duty)->where($where)->select();
		//var_dump($class_list);
		foreach ($class_list as &$item) {
			$classid=$item["id"];
			//获取本校老师供班主任设置
			$teacher_name=M('teacher_class')->alias("t")->join("wxt_wxtuser w ON t.teacherid=w.id")->distinct(true)->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
			$item["teacher_name"]=$teacher_name;
			//获取年级
			$grade_id=$item["grade"];
			$grade_info=M("school_grade")->field("name")->where("id=$grade_id")->find();
			$item["grade"]=$grade_info["name"];
			//获取班主任
		    $where_cap["t.classid"]=$classid;
		    $where_cap["t.type"]=1;
		    $captain=M("teacher_class")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where($where_cap)->field("w.id,w.name")->     find();
		    $item["captain"]=$captain["id"];
			//获取班级学生人数
			$classid=$item["id"];
			$stu_count=M("class_relationship")->where("classid=$classid")->count();
			$item["stu_count"]=$stu_count;
		}
		//获取全校老师传入弹出框供用户选择
		$teachers=M("teacher_info")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->distinct(true)->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
		// var_dump($teachers);	
     // var_dump($class_list); 


       $class_all = M("school_class")->where("schoolid=$schoolid and type = 1")->select();
       //var_dump($class_all);

		$this->assign("teachers",$teachers);

		$this->assign("class_list",$class_list);

		$this->assign("class_all",$class_all);
		//var_dump($class_list);
		$this->assign("grade",$grade);
		$this->assign("captain",$captain);
		$this->display();
	}
	//弹框保存带班老师
	public function teachers(){
		$schoolid=$_SESSION['schoolid'];
		$classid=I("c_id");
		$teachers=I("teachers");
		//判断这个班级有没有班主任,如果有就更新,没有就添加
		$where["classid"]=$classid;
		$where["type"]=1;
		$teacher_info=M('teacher_class')->where($where)->find();
		$data["schoolid"]=$schoolid;
		$data["teacherid"]=$teachers;
		$data["classid"]=$classid;
		$data["type"]=1;
		if($teacher_info){
			$teacher_save=M('teacher_class')->where($where)->save($data);
		}else{
			$teacher_add=M('teacher_class')->add($data);
		}
	}
	//获取班级内学生
	public function get_student(){
		$classid=I("classid");
		$student_info=M("class_relationship")
		->alias("c")
		->join("wxt_wxtuser w ON c.userid=w.id")
		->where("c.classid=$classid")
		->field("w.id,w.name")
		->distinct(true)
		->select();
		if($student_info){
			$ret = $this->format_ret(1,$student_info);
		}else{
			$ret = $this->format_ret(0,"error");
		}
		echo json_encode($ret);
        exit;
	}
	//班级内学生变动
	public function student_change(){
		$schoolid=$_SESSION['schoolid'];
		//获取左边班级id和学生数组
		$class_first=I("class_first");
		$check_first=I("check_first");
		var_dump($class_first);
		var_dump($check_first);
		//echo "Dasdsa";
		//从新改造的左边

		 //循环获取到的班级ID分别去查询  如果不存则执行插入 存在则不插入
      foreach ($check_first as $key => $val) {
      	$check_data['userid'] = $val;
      	$check_data['classid'] = $class_first;
      	$class_re = M("class_relationship")->where($check_data)->find();
      	//var_dump($class_re);
      	if(!$class_re){
      		$data['schoolid'] = $schoolid;
      		$data['userid'] = $val;
      		$data["classid"] = $class_first;
      		$data['create_time']=time();

      		$add_first=M("class_relationship")->add($data);
      	}

      }

		//exit();
		
	    //TODO 以前写的左边

		//$delete_first=M("class_relationship")->where("classid=$class_first")->delete();
		// foreach ($check_first as &$studentid) {
		// 	$data["schoolid"]=$schoolid;
		// 	$data["userid"]=$studentid;
		// 	$data["classid"]=$class_first;
		// 	$data["status"]=1;
		// 	$data["create_time"]=time();
		// 	$add_first=M("class_relationship")->add($data);
		// }
         //从新改造的右边
        $class_second=I("class_second");
		$check_second=I("check_second");
     //循环获取到的班级ID分别去查询  如果不存则执行插入 存在则不插入
      foreach ($check_second as $key => $value) {
      	$second_data['userid'] = $value;
      	$second_data['classid'] = $class_second;
      	$class_se = M("class_relationship")->where($second_data)->find();
      	//var_dump($class_se);
      	if(!$class_se){
      		$data_se['schoolid'] = $schoolid;
      		$data_se['userid'] = $value;
      		$data_se["classid"] = $class_second;
      		$data_se['create_time']=time();

      		$add_second=M("class_relationship")->add($data_se);
      	}

      }
  


        //TODO 以前写的右边

		//获取右边班级id和学生数组
		// $class_second=I("class_second");
		// $check_second=I("check_second");
		// //$delete_second=M("class_relationship")->where("classid=$class_second")->delete();
		// foreach ($check_second as &$studentid_else){
		// 	$data_second["schoolid"]=$schoolid;
		// 	$data_second["userid"]=$studentid_else;
		// 	$data_second["classid"]=$class_second;
		// 	$data_second["status"]=1;
		// 	$data_second["create_time"]=time();
		// 	$add_second=M("class_relationship")->add($data_second);
		// }
	}
	public function add(){
		//获取登录用户的信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //向模板传送本校的年级信息
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		// var_dump($grade);
		// $teachers=M("teacher_class")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->distinct(true)->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
		$teachers=M("teacher_info")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
		// var_dump($teachers);
		$this->assign("teachers",$teachers);
		$this->assign("grade",$grade);
		$this->display();
	}
	//添加班级
	public function add_post(){
		if(IS_POST){
			//获取登录用户的信息
			$schoolid=$_SESSION['schoolid'];
			//获取页面传回的信息
			$grade=intval(I("grade"));
			$classname=I("classname");
			$captain=intval(I("captain"));
			$teacherid=I("teacher");

			$type=2;
			$data["schoolid"]=$schoolid;
			$data["classname"]=$classname;
			$data["grade"]=$grade;
			$data["create_time"]=time();
			$data["type"]=$type;
			$class=M('school_class')->add($data);
			if($class){
				

              	if($captain){
				$data_cap["schoolid"]=$schoolid;
				$data_cap["teacherid"]=$captain;
				$data_cap["classid"]=$class;
				$data_cap["type"]=1;
				$captain_add=M('teacher_class')->add($data_cap);
			         }
			     if($teacherid){
			    	foreach ($teacherid as  $value) {
			    	$data_tea["schoolid"]=$schoolid;
					$data_tea["teacherid"]=$value;
					$data_tea["classid"]=$class;
					$data_tea["type"]=2;
					$teacher_add=M('teacher_class')->add($data_tea);
			    	  
			    	}
				
			    }

				
				if($captain_add){
					$this->success("添加成功");
				}else{
					$this->error("添加失败");
				}
			}else{
				$this->error("添加有问题");
			}
		}
	}
	//修改班级信息
	public function edit(){
		//获取传回来的信息id
		$id=intval(I("id"));
		//获取登录用户的信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //向模板传送本校的年级信息
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		//var_dump($grade);
		//班级信息
		$class=M('school_class')->where("id=$id")->find();
		$this->assign("class",$class);
		//var_dump($class);
		$this->assign("grade",$grade);
		$this->display();
	}
	public function edit_post(){
		$id=I("class_id");
		$grade=I("grade");
		$classname=I("classname");
		$type=I("type");
		$data["classname"]=$classname;
		$data["grade"]=$grade;
		$data["type"]=$type;
		$data["create_time"]=time();
		$class_edit=M('school_class')->where("id=$id")->save($data);
		if ($class_edit) {
            $this->success("保存成功");
        } else {
            $this->error("保存失败！");
        } 
	}
	public function delete(){
        $id = intval($_GET['id']);
        if($id){
            $rst=M('school_class')->where("id=$id")->delete();
             if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            } 
        }else{
                $this->error('数据传入失败！');
        }
    }
    //参数获取(状态，原因)
    function format_ret ($status, $data='') {
        if ($status){	
            //成功
            return array('status'=>'success', 'data'=>$data);
        }else{	//验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
}