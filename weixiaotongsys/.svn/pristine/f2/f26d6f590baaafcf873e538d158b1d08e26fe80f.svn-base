<?php
namespace Admin\Controller;
use Common\Controller\AppframeController;
header("Content-type: text/html; charset=utf-8"); 
class AdminUtilsController extends AppframeController{

	// public function __construct() {
	// 	$admintpl_path=C("SP_ADMIN_TMPL_PATH").C("SP_ADMIN_DEFAULT_THEME")."/";
	// 	C("TMPL_ACTION_SUCCESS",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_SUCCESS"));
	// 	C("TMPL_ACTION_ERROR",$admintpl_path.C("SP_ADMIN_TMPL_ACTION_ERROR"));
	// 	parent::__construct();
	// 	$time=time();
	// 	$this->assign("js_debug",APP_DEBUG?"?v=$time":"");
	// }
  
   //获取省份
	  public function role_type()
	  {  
	    
	     $province = I("Province");
	   
	     $user_id = $_SESSION['ADMIN_ID'];

	     
	     $city = M("role_user")->alias("ru")->where(array("ru.user_id"=>$user_id))->join("wxt_role r ON r.id=ru.role_id")->getField("r.city");

   
	    
	     
	     if(empty($city))
	     {
	     	$result = M('city')->where(array("parent"=>$province))->select();
	     	
	     	
	     }else{
	     	$result = M('city')->where(array("term_id"=>$city))->select();

	     }
	    

           $ret = $this->format_ret(1,$result);
            echo  json_encode($ret);


	  }
 
  //选择地市
    public function Provinces(){
      $this->Region=D("Common/city");
        $Province=I("Province");
        $Shisheng=$this->Region->where("parent=$Province")->select();
        // var_dump($Shisheng);
         if (!empty($Shisheng)){
           $ret = $this->format_ret(1,$Shisheng);
           echo json_encode($ret);
        }else{
            $ret = format_ret(0,"parms lost");
            echo json_encode($ret);
        }
    }
        //通过区域来找对应的学校
    public function lookup(){

      $user_id = $_SESSION['ADMIN_ID'];



      $this->school_model = D("Common/School");

      $this->role_school = D("Common/role_school");

        $type=I("type");
//        dump($type);


       if($user_id)
       {
           $role = M("role_user")->where("user_id = $user_id")->getField("role_id");
       }



      
       if($type!=""){
         if($role==1)
         {
           $School=$this->school_model->where("area=$type")->field("school_name,schoolid,schoolgradetypeid")->select();
            
         }else{

             $School = $this->role_school->alias("rs")->join("wxt_school s ON s.schoolid = rs.schoolid")->where("rs.area = $type and rs.status = 1 and rs.roleid = $role")->field("s.school_name,s.schoolid,s.schoolgradetypeid")->select();
            
         }
      }else{
        $ret = $this->format_ret(0,'参数缺失！');
      }



        echo json_encode(array('data'=>$School,'message'=>'10000'));
    }
//通过区域来找对应的 人脸识别的学校
    public function face_lookup(){

        $user_id = $_SESSION['ADMIN_ID'];


        $this->school_model = D("Common/School");

        $this->role_school = D("Common/role_school");

        $type=I("type");


        if($user_id)
        {
            $role = M("role_user")->where("user_id = $user_id")->getField("role_id");
        }



        if($type!=""){
            if($role==1)
            {
                $School=$this->school_model->where("area=$type")->field("school_name,schoolid,schoolgradetypeid")->select();
                $face_school = M("face_school")->where(array("state"=>1))->select();
                foreach ($face_school as $schoolidvalue){
                    $schoollist[] = $schoolidvalue["schoolid"];
                }
                foreach ($School as $key => $value){
                    if(in_array($value["schoolid"],array_unique($schoollist))==false){
                        unset($School[$key]);
                    }
                }
                $k = 0;
                foreach ($School as $value){
                    $new_school[$k] =  $value;
                    $k++;
                }
                // $School = asort($School);

            }else{
                $School = $this->role_school->alias("rs")->join("wxt_school s ON s.schoolid = rs.schoolid")->where("rs.area = $type and rs.status = 1 and rs.roleid = $role")->field("s.school_name,s.schoolid,s.schoolgradetypeid")->select();
                $face_school = M("face_school")->where(array("state"=>1))->select();
                foreach ($face_school as $schoolidvalue){
                    $schoollist[] = $schoolidvalue["schoolid"];
                }
                foreach ($School as $key => $value){
                    if(in_array($value["schoolid"],array_unique($schoollist))==false){
                        unset($School[$key]);
                    }
                }
                $k = 0;
                foreach ($School as $value){
                    $new_school[$k] =  $value;
                    $k++;
                }

            }
        }else{
            $ret = $this->format_ret(0,'参数缺失！');
        }



//        echo json_encode(array('data'=>$School,'message'=>'10000'));
        echo json_encode(array('data'=>$new_school,'message'=>'10000'));
    }


     public function roleschool($at_id,$isonelevelrole,$categoryid)
     {

        $user_id = $_SESSION['ADMIN_ID'];


        $roleid = M('role_user')->where("user_id = $user_id")->getField('role_id');



       if(empty($roleid))
       {
       	$roleid = 1;
       }
      
       $role = M("role")->where("id = $roleid")->field("Province,city")->find();



     //如果省份存在 则查出这个省份下的所有城市
       
       if($role['province'])
       {
        $where['province'] = $role['province'];
       	// $where_city['province'] = $role['province'];
          $where['parent'] = $role['province'];
          $pic = M("city")->where($where)->field("term_id as id,parent as parentid,name")->select();

          $city = array();
          //将数组id重新排序
          foreach ($pic as $key => &$value) {
            $value['parentid'] = 0;
            $pp = M("city")->where(array("parent"=>$value['id']))->order("id asc")->field("term_id as id,parent as parentid,name")->select();
      
           array_push($city,$pp);
          }
         
    
        //   // exit();
        // $where_city['parent'] = array("in",rtrim($city,","));

        // var_dump($where_city);
            // $cc = array();
        
        // var_dump($city);

          //将数组降维并合并到一个新数组
           foreach ($city as  $val) {
            foreach ($val as  $v) {
              $arr[] = $v;
            }
           }

          
          $result = array_merge($pic,$arr);
              

       }

     $result = $this->multi_array_sort($result,'id',SORT_ASC);

     //如果失去存在就找出所在的地区
       if($role['city'])
       {
       	$where['city']  = $role['city'];

       	$where_city['parent'] = $role['city'];
//       	dump($where_city);

        $result = M("city")->where($where_city)->field("parent as parentid,name,term_id as id")->select();
       
       }

       //因为超级管理员 什么都为空着查出所有的地区

       if(empty($role['city']) && empty($role['province']))
       {
        $result = M("city")->field("parent as parentid,name,term_id as id")->select();
       }
//        dump($result);
         $at_role = M("role")->where("id = $at_id")->find();

         if($at_role['province'])
         {
             $where_school['province'] = $at_role['province'];
         }

         if($at_role['city'])
         {
             $where_school['city'] = $at_role['city'];
         }


         if($isonelevelrole==1)
         {
              if($categoryid==1)
              {
//                  $where_school['province'] =
//                  $where_school['city'] = $at_role['city'];
              }else{
                  $where_school['agent_id'] = $at_role['agentid'];
              }
         }else{
             $at_role = M("role")->where(array("id"=>$at_role['pid']))->find();

             if($categoryid==1)
             {
//                 $where_school['city'] = $at_role['city'];
             }else{
                 $where_school['agent_id'] = $at_role['agentid'];
             }
          }

//       dump($where_school);
      $school = M("school")->where($where_school)->field("school_name as name,schoolid,area as parentid")->select();
//      dump($school);
//      exit();
      // $result = M("city")->where($where_city)->field("parent as parentid,name,term_id as id")->select();
      // var_dump($result);
     // var_dump($where_city)
     // foreach ($result as $key => &$value) {
     // 	$area = $value['term_id'];
     // 	 // $school = M("school")->where(array("area"=>$area))->field("school_name,area as parentid,schoolid")->select();
     // 	 // var_dump($school);

     // 	 $value['school'] = $school;
     // }
     //
     //
     //
     if($where_city)
     {
      foreach ($result as $key => &$value) {
               $value['parentid'] = 0;
      }
     }
     // var_dump($result);
    //拿出省份最后一个数组的id开始递增赋值给学校     
     $last = $result[count($result)-1]['id'];
//    dump($last);
 
     foreach ($school as $key => &$value) {
      $last++;
       $value['id'] = $last;
     }
 
    $result = array_merge($result,$school);
//dump($result);

       return $result;



    }

    //数组排序
    function multi_array_sort($arr,$shortKey,$short=SORT_DESC,$shortType=SORT_REGULAR)
    {
        foreach ($arr as $key => $data){
            $name[$key] = $data[$shortKey];
        }
        array_multisort($name,$shortType,$short,$arr);
        return $arr;
    }


//查询年级  
    public function showgrade()
    {
        $schoolid = I('schoolid');

        $grade = M("school_grade")->where("schoolid = $schoolid")->field("name,gradeid")->order("gradeid")->select();


          if($grade){
                $ret = $this->format_ret(1,$grade);
            }else{
                $ret = $this->format_ret(0,"lost params");
            }
        echo json_encode($ret);
            exit;

    



    }

   //根据年级来查出班级
     function showclass()
     {
        $schoolid = I('schoolid');
        $gradeid = I('gradeid');

        $where['schoolid'] = $schoolid;
        $where['grade'] = $gradeid;
        $class = M('school_class')->where($where)->field("id,classname")->select();

          if($class){
                    $ret = $this->format_ret(1,$class);
                }else{
                    $ret = $this->format_ret(0,"lost params");
                }
                echo json_encode($ret);
                exit;

     }

     //获取老师职责
     public function teacher_duty()
     {
        $schoolid = I("schoolid");
        $duty = M("school_duty")->where("schoolid = $schoolid")->select();

         if($duty){
                    $ret = $this->format_ret(1,$duty);
                }else{
                    $ret = $this->format_ret(0,"lost params");
                }
                echo json_encode($ret);
                exit;
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
    //根据学校来查出所有班级
    public function schoolclass()
    {
        $schoolid = I("schoolid");
        $school_class = M("school_class")->where("schoolid = $schoolid")->select();

        if($school_class){
            $ret = $this->format_ret(1,$school_class);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);
        exit;

    }
    //根据班级查出学生
    public function schoolstudent()
    {
        $schoolid=I('schoolid');


        $class = I('class');

        $class_relationship = M('class_relationship')
            ->alias("c")
            ->where("c.schoolid = $schoolid and c.classid = $class")
            ->join("wxt_student_info s ON c.userid = s.userid")
            ->field("s.userid,s.stu_name")
            ->order("s.userid")
            ->select();


        // var_dump($class_relationship);


        if($class_relationship){
            $ret = $this->format_ret(1,$class_relationship);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);

    }

   //获取代理商
    public function get_agent()
    {
        $city = I("city");

        if(!$city)
        {
            $ret = $this->format_ret(0,"lost params");
            echo json_encode($ret);
            exit();
        }

        $agent  = M("agent")->where(array("city"=>$city))->select();
        if($agent){
            $ret = $this->format_ret(1,$agent);
        }else{
            $ret = $this->format_ret(0,"lost params");
        }
        echo json_encode($ret);



    }

}