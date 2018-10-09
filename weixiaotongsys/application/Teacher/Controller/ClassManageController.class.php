<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class ClassManageController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }

	public function index(){
		//获取登录用户的信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //搜索
        //var_dump($schoolid);
        $search_grade=I("search_grade");
        if($search_grade){
        	$where["grade"]=$search_grade;
        	// var_dump($search_grade);
        	$this->assign("search_grade",$search_grade);
        }
        $search_type=I("search_type");
        if($search_type){
        	$where["type"]=$search_type;
        	
        	$this->assign("search_type",$search_type);
        }
        $search_class=I("search_class");
        if($search_class){
        	$where["classname"]=array('LIKE',"%".$search_class."%");
        }
        //向模板传送本校的年级信息
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
       // var_dump($grade);
		//获取班级的相关信息
		$where["schoolid"]=$schoolid;
		$class_list=M("school_class")->where($where)->select();
		//echo "<pre>";
		//var_dump($class_list);
		//echo "<pre></br>";	
		foreach ($class_list as &$item) {
			//获取年级			
			//$grade_id=$item["grade"];
			$classwhere["schoolid"]=$schoolid;
			$classwhere["schoolid"]=$schoolid;
			$classwhere["gradeid"]=$item["grade"];
//			$grade_id=$item["schoolid"];
			$grade_info=M("school_grade")->field("name,gradeid")->where($classwhere)->find();
			//var_dump($grade_info);
			$item["grade"]=$grade_info["name"];
			$item["gradeid"]=$grade_info["gradeid"];
			//获取班级学生人数
			$classid=$item["id"];
			$stu_count=M("class_relationship")->where("classid=$classid")->count();
			$item["stu_count"]=$stu_count;
			//获取班级教师人数
			$tyishu["schoolid"]=$schoolid;
			$tyishu["classid"]=$classid;
			$tea_count=M("teacher_class")->where($tyishu)->count();
			$item["tea_count"]=$tea_count;
			//获取班主任
			$where_cap["t.classid"]=$classid;
			$where_cap["t.type"]=1;
			$where_cap["t.schoolid"]=$schoolid;
			$captain=M("teacher_class")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where($where_cap)->field("w.id,w.name")->find();
			$item["captain"]=$captain["name"];
			$item["teacher_main"]=$captain["id"];
			//获取任课老师
			$where_tea["t.classid"]=$classid;
			$where_tea["t.type"]=2;
			$where_tea["t.schoolid"]=$schoolid;
			$teacher=M("teacher_class")->alias("t")->join("wxt_teacher_info w ON w.teacherid=t.teacherid")->where($where_tea)->field("t.teacherid as id,w.name")->select();

			//将查出来的老师二维数组转换为字符串
			$teacher_id="";
			$teacher_info="";
			foreach ($teacher as &$itvo) {
				$info=$itvo["name"];
				$infos=$itvo["id"];
				$teacher_info = $info.",".$teacher_info;
				$teacher_id=$infos.",".$teacher_id;
			}
//			$teacher_info=implode(",",$teacher_name);
			$item["teacher_name"]=$teacher_info;
			$item["teacher_id"]=$teacher_id;
		}



		//获取全校老师传入弹出框供用户选择
        $teachers=M("teacher_info")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where("t.schoolid=$schoolid")->field("t.id,t.name")->select();



		$this->assign("teachers",$teachers);
		$this->assign("class_list",$class_list);
		$this->assign("grade",$grade);
		$this->assign("search_class",$search_class);
		$this->display();
	}
    public function indexteacherid_back(){
        //获取登录用户的信息
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //搜索
        //var_dump($schoolid);
        $search_grade=I("search_grade");
        if($search_grade){
            $where["grade"]=$search_grade;
            // var_dump($search_grade);
            $this->assign("search_grade",$search_grade);
        }
        $search_type=I("search_type");
        if($search_type){
            $where["type"]=$search_type;

            $this->assign("search_type",$search_type);
        }
        $search_class=I("search_class");
        if($search_class){
            $where["classname"]=array('LIKE',"%".$search_class."%");
        }
        //向模板传送本校的年级信息
        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
        // var_dump($grade);
        //获取班级的相关信息
        $where["schoolid"]=$schoolid;
        $class_list=M("school_class")->where($where)->select();
        //echo "<pre>";
        //var_dump($class_list);
        //echo "<pre></br>";
        foreach ($class_list as &$item) {
            //获取年级
            //$grade_id=$item["grade"];
            $classwhere["schoolid"]=$schoolid;
            $classwhere["schoolid"]=$schoolid;
            $classwhere["gradeid"]=$item["grade"];
//			$grade_id=$item["schoolid"];
            $grade_info=M("school_grade")->field("name,gradeid")->where($classwhere)->find();
            //var_dump($grade_info);
            $item["grade"]=$grade_info["name"];
            $item["gradeid"]=$grade_info["gradeid"];
            //获取班级学生人数
            $classid=$item["id"];
            $stu_count=M("class_relationship")->where("classid=$classid")->count();
            $item["stu_count"]=$stu_count;
            //获取班级教师人数
            $tyishu["schoolid"]=$schoolid;
            $tyishu["classid"]=$classid;
            $tea_count=M("teacher_class")->where($tyishu)->count();
            $item["tea_count"]=$tea_count;
            //获取班主任
            $where_cap["t.classid"]=$classid;
            $where_cap["t.type"]=1;
            $where_cap["t.schoolid"]=$schoolid;
            $captain=M("teacher_class")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where($where_cap)->field("w.id,w.name")->find();
            $item["captain"]=$captain["name"];
            $item["teacher_main"]=$captain["id"];
            //获取任课老师
            $where_tea["t.classid"]=$classid;
            $where_tea["t.type"]=2;
            $where_tea["t.schoolid"]=$schoolid;
            $teacher=M("teacher_class")->alias("t")->join("wxt_teacher_info w ON w.teacherid=t.teacherid")->where($where_tea)->field("t.teacherid as id,w.name")->select();

            //将查出来的老师二维数组转换为字符串
            $teacher_id="";
            $teacher_info="";
            foreach ($teacher as &$itvo) {
                $info=$itvo["name"];
                $infos=$itvo["id"];
                $teacher_info = $info.",".$teacher_info;
                $teacher_id=$infos.",".$teacher_id;
            }
//			$teacher_info=implode(",",$teacher_name);
            $item["teacher_name"]=$teacher_info;
            $item["teacher_id"]=$teacher_id;
        }



        //获取全校老师传入弹出框供用户选择
        $teachers=M("teacher_info")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where("t.schoolid=$schoolid")->field("t.id,t.name")->select();



        $this->assign("teachers",$teachers);
        $this->assign("class_list",$class_list);
        $this->assign("grade",$grade);
        $this->assign("search_class",$search_class);
        $this->display();
    }
	//模糊查询老师
	public function teacher_chasu(){
		$schoolid=$_SESSION['schoolid'];     
		$classname=I("names");
		$where["t.schoolid"]=$schoolid;
		$where["t.name"]=array('LIKE',"%".$classname."%");
		$teachers=M("teacher_info")->alias("t")
            ->join("wxt_wxtuser w ON w.id=t.teacherid")
		->where($where)
		->field("w.id,t.name")->select();
	if($teachers){
		echo json_encode(array('code'=>$teachers,'message'=>'Data returned successfully'));
	}else{
		echo json_encode(array('code'=>"-1",'message'=>'网络错误请稍后重试'));
	}
		
	}
	//弹框保存班主任
	public function teacher_add(){
		$schoolid=$_SESSION['schoolid'];
		$classid=I("class_id");
		$t_id=I("teachers");		
		$data["classid"]=$classid;
		$data["type"]=1;	
		
		$where["classid"]=$classid;
		$where["type"]=1;
		$where["teacherid"]=$t_id;
		$where["schoolid"]=$schoolid;
			
		$teacher_cha=M('teacher_class')->where($data)->select();
		if($teacher_cha){
			$teacher_gai=M('teacher_class')->where($data)->save($where);				
			}else{
			   $teacher_add=M('teacher_class')->add($where);
		}
				
	}
	//弹框保存带班老师
	public function teachers_add(){
		$schoolid=$_SESSION['schoolid'];
		$classid=I("class_id");
		$tid_arr=I("teacher_arr");
		$where["classid"]=$classid;
	    $where["schoolid"]=$schoolid;
		$where["type"]=2;
		$delete=M("teacher_class")->where($where)->delete();		  
		foreach ($tid_arr as &$teacherid) {
			$data["teacherid"]=$teacherid;
			$data["schoolid"]=$schoolid;
			$data["classid"]=$classid;
			$data["type"]=2;
			$add=M("teacher_class")->add($data);
		}
	}
	//获取本班主任
	public function get_main(){
		$classid=I("classid");
		$where["classid"]=$classid;
		$where["type"]=1;
		$main=M("teacher_class")->where($where)->field("teacherid")->select();
		if($main){
            $ret = $this->format_ret_else(1,$main);
        }else{
            $ret = $this->format_ret_else(0,"lost params");
        }
        echo json_encode($ret);
        exit;
	}
	//获取本班任课教师
	public function get_teachers(){
		$classid=I("classid");
		$where["classid"]=$classid;
		$where["type"]=2;
		$main=M("teacher_class")->where($where)->field("teacherid")->select();
		if($main){
            $ret = $this->format_ret(1,$main);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;
	}
	public function add(){
		//获取登录用户的信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        //向模板传送本校的年级信息
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		//var_dump($grade);
		$teachers=M("teacher_info")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->where("t.schoolid=$schoolid")->field("w.id,t.name")->select();
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
			// var_dump($teacherid);
			// exit();
			$type=intval(I("type"));
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
		$class=M('school_class')->where("id=$id")->find();
		$this->assign("class",$class);
		$this->assign("grade",$grade);
		$this->display();
	}
	public function edit_post(){
		$id=I("classid");
		$grade=I("cid");
		$classname=I("rel");
		$type=I("tid");
		// exit();		
		$data["classname"]=$classname;
		$data["grade"]=$grade;
		$data["type"]=$type;
		$data["create_time"]=time();
		$class_edit=M('school_class')->where("id=$id")->save($data);
		if ($class_edit > 0) {
            $info['status'] = true;
            $info['msg'] = $class_edit;
        } else {
            $info['status'] = false;
            $info['msg'] = '404';
       }
             echo json_encode($info);               

	}
	//TODO删除以后还需要考虑删除哪一些数据
	public function delete(){
        $id = intval($_GET['id']);
        if($id){
            $rst=M('school_class')->where("id=$id")->delete();

            //删除班级关系表
          $class_rela  =  M("class_relationship")->where("classid = $id")->delete();
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
        }else{  
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }
}