<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class SubjectManageController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }
	public function index(){
		//用户信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];

       // $where['gradetype']=$schoolid;
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
        $data['isdefault'] = 1;
    

        $where_c['gradetype'] = 0;
        $where_c['schoolid'] = 0;
        $where_c['isdefault'] = 0;

        $where_subject=array($where_c,$data,$where,'_logic'=>'or');

        $subject  = M("default_subject")->where($where_subject)->select();


       
        //自建科目TODO6.28改造林
//        $subject_add = M('default_subject')->where($data)->select();
//
//        //var_dump($subject_add);
//        //学校类型科目
//
//        $default = M('default_subject')->where($where)->select();
//        // var_dump($default);
//        //通用科目
//        $currency = M("default_subject")->where($where_c)->select();
//        // var_dump($currency);
//       // var_dump($subject);
//        //发送到前台的集合
//        $subject = array_merge($default,$subject_add);
//
//        $subject = array_merge($currency,$subject);
       // var_dump($subject);

        $sub = M('subject')->field('subjectid,schoolid')->select();
       // var_dump($sub);
        //$cc =[];
         for($i = 0; $i<count($sub);$i++)
         {
	     	for($j =0; $j<count($subject);$j++)
	     	{
	     		if($sub[$i]['subjectid']==$subject[$j]['id'] && $sub[$i]['schoolid']==$schoolid)
	     		{
	     			$subject[$j]['statu']=1;
	     			//$schoo_grade[$j]['cid']=$grade[$i]['id'];
	     		}
	     	}
     	}
   
          


      
  
       








		// var_dump($subject);


        //var_dump($subject);
       

        //2、根据学校id获取学校年段类型
        //课程
		// $subject=M('subject')
		// ->alias("s")
		// ->join("wxt_default_subject d ON d.id=s.subjectid")
		// ->field("d.id,d.subject")
		// ->distinct(true)
		// ->where("s.schoolid=$schoolid")
		// ->select();
		// $sub_arr=array();
		// foreach ($subject as &$item) {
		// 	$subjectid=$item["id"];
		// 	array_push($sub_arr, $subjectid);
		// }
		//获取本校的自增课程
		// $where["s.schoolid"]=$schoolid;
		// $where["d.type"]=0;
		// $add_self=M('subject')
		// ->alias("s")
		// ->join("wxt_default_subject d ON d.id=s.subjectid")
		// ->field("d.id,d.subject")
		// ->distinct(true)
		// ->where($where)
		// ->select();
		// $self_arr=array();
		// foreach ($add_self as &$item) {
		// 	$subject_id=$item["id"];
		// 	array_push($self_arr, $subject_id);
		// }
		//选择年级
		//var_dump($subject);
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		$this->assign("subject",$subject);
		$this->assign("grade",$grade);
		$this->assign("sub",$sub);
		$this->assign("sub_arr",$sub_arr);
		$this->assign("self_arr",$self_arr);
		$this->display();
	}
		public function indexError(){
		//用户信息
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];


       // 2、根据学校id获取学校年段类型课程
		$subject=M('subject')
		->alias("s")
		->join("wxt_default_subject d ON d.id=s.subjectid")
		->field("d.id,d.subject")
		->distinct(true)
		->where("s.schoolid=$schoolid")
		->select();
		$sub_arr=array();
		foreach ($subject as &$item) {
			$subjectid=$item["id"];
			array_push($sub_arr, $subjectid);
		}
		//获取本校的自增课程
		$where["s.schoolid"]=$schoolid;
		$where["d.type"]=0;
		$add_self=M('subject')
		->alias("s")
		->join("wxt_default_subject d ON d.id=s.subjectid")
		->field("d.id,d.subject")
		->distinct(true)
		->where($where)
		->select();
		$self_arr=array();
		foreach ($add_self as &$item) {
			$subject_id=$item["id"];
			array_push($self_arr, $subject_id);
		}
		//选择年级
		$grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		$this->assign("subject",$subject);
		$this->assign("grade",$grade);
		$this->assign("sub",$sub);
		$this->assign("sub_arr",$sub_arr);
		$this->assign("self_arr",$self_arr);
		$this->display();
	}
	//年级和课程的对应的关系
	public function grade_subject(){
		$gradeid=I("grade_id");
		//通过年级获取本年级都有哪些科目
		$sub=M('subject')->field("id,subjectid")->where("gradeid=$gradeid")->select();
		if($sub){
			$ret = $this->format_ret(1,$sub);
		}else{
			$ret = $this->format_ret(0,"error");
		}
		echo json_encode($ret);
        exit;
	}
	//增加科目
	public function subject_add(){
		$userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
		$status=Intval(I("status"));
		$subject_name=I("subject_name");


		$data["subject"]=$subject_name;
		$data["type"]=0;
		$data["create_time"]=time();
		$data["status"]=$status;
		$data["schoolid"]=$schoolid;
		$data["isdefault"] = 1;
		$subjectid=M("default_subject")->add($data);
		if($subjectid){
			$data_id["schoolid"]=$schoolid;
			$data_id["subjectid"]=$subjectid;
			$data_id["gradeid"]=0;
			$subject_add=M("subject")->add($data_id);
			if($subject_add){
				$this->success("添加成功");
			}else{
				$this->error("添加失败");
			}
		}
	}
	//保存学校科目设置
	public function save_subject(){
		$schoolid=$_SESSION['schoolid'];
		$subject=I("subject_id");
		//1.根据schoolid,删除记录
		//2.c插入前台传过来的数据
  //var_dump($subject);
           $del = M('subject')->where("schoolid=$schoolid")->delete(); 
           //如果传递过来的值为空直接保存成功
		  if (empty($subject)){
		  	$this->success("保存成功");
		  	die();
		  }
  	
		
		
        $id =  implode(",", $subject); 

        $where['subjectid'] = array('in',"$id");
        $where['schoolid'] = $schoolid;

       $del = M('subject')->where($where)->delete();
       //var_dump($del);
       //将数据回填循环一次性添加
	    foreach ($subject as $key => $val) {
	    	 $data['subjectid'] = $val;
	    	 $data['schoolid'] = $schoolid;
	    	$alldata[]=$data;
	    	unset($data);
	    }
      
   //  // $data['subjectid'] = $subject;
   //   $data['schoolid'] = $schoolid;
   // var_dump($data);
          $result = M('subject')->addAll($alldata);

 //var_dump($result);


 if ($result) {
 	$this->success("保存成功");
 }else{
 	$this->error("保存失败");
 }
        //$cc =[];
      //    for($i = 0; $i<count($subjectids);$i++){
      //    	$subject=$subjectids[$i];
      //    	//根据id查找数据库,判断是否有值

	     // 		if($sub[$i]['subjectid']==$subject[$j]['id'])
	     // 		{
	     // 			$subject[$j]['statu']=1;
	     // 			//$schoo_grade[$j]['cid']=$grade[$i]['id'];
	     // 		}

     	// }
       // exit();



       
  //       var_dump($id);
  //      $schoolsubjects = M('subject')->where("subjectid in ($id)")->select();
  //     var_dump($sub);
  //  		foreach ($schoolsubjects as &$subject) {
  //  			$subject["id"];
		// 	$subject_id=$item["id"];
		// 	array_push($self_arr, $subject_id);
		// }


      // $datarow = array(

      //  'schoolid'=>$schoolid,
      //  'subjectid'=>$id,

      // 	);

     
      //  $rel = M('subject')->add($datarow);
      // exit();
      

       // foreach ($sub as  $value) {
       //  	if ($value['subjectid']==$subject) {
       //  		echo "dasdsa";
       //  	}
       //  } 
      //  var_dump($sub);


		//var_dump($subject);
     


		// $grade=Intval(I("garade_select"));
		// if($subject && $grade){
		// 	$where["schoolid"]=$schoolid;
		// 	$where["gradeid"]=$grade;
		// 	$delete=M("subject")->where($where)->delete();
		// 	if($delete){
		// 		foreach ($subject as &$subjectid) {
		// 	    	$data["schoolid"]=$schoolid;
		// 	    	$data["subjectid"]=$subjectid;
		// 	    	$data["gradeid"]=$grade;
		// 	    	$subject_add=M("subject")->add($data);
		// 	    	$this->success("成功");
		// 	    }
		// 	}
		// }else{
		// 	$this->error("未获取到数据");
		// }
	}
	//删除科目
	public function delete(){
		$schoolid=$_SESSION['schoolid'];
		$id=I("id");

		if($id){
          
            $default = M('default_subject')->where("id=$id")->find();
           //var_dump($default);
            $type = $default['gradetype'];
          // exit();
           if($type !== '0'){
           	$this->error("不能删除默认课程!");
           	die();
           } 

           $where['schoolid'] = $schoolid;
           $where['gradetype'] = 0;
           $where['id'] = $id; 

			$rst=M('default_subject')->where($where)->delete();
			$ret=M('subject')->where("subjectid=$id")->delete();
			if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败!");
            }
		}else{
			$this->error("未获取到数据");
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




    public function calloff(){
    	$schoolid=$_SESSION['schoolid'];

    	$id = I('id');

    	$where['schoolid'] = $schoolid;
    	$where['subjectid'] = $id;

    	$subject = M('subject')->where($where)->delete();


    	     if ($subject > 0) {
                        $info['status'] = true;
                        $info['msg'] = $subject;
                    } else {
                        $info['status'] = false;
                        $info['msg'] = '404';
               }
             echo json_encode($info); 
    }
}