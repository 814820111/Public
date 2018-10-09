<?php
namespace Admin\Controller;
use Common\Controller\AppframeController;
header("Content-type: text/html; charset=utf-8"); 
class ShareController extends AppframeController{

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

         $role = M("role_user")->where("user_id = $user_id")->getField("role_id");
      
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


     public function roleschool($roleid)
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
         
           // $city = '';
          $city = array();
          //将数组id重新排序
          foreach ($pic as $key => &$value) {
            $value['parentid'] = 0;
            $pp = M("city")->where(array("parent"=>$value['id']))->field("term_id as id,parent as parentid,name")->select();
      
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
       // var_dump($result);
        // $cc = array();
        // 
       //  var_dump($city);
       // foreach ($city as  $value) {
       //  foreach ($value as  $val) {
       //    $arr[] = $val;
       //  }
       // }
      // $result = array_merge($pic,$arr);
     

     //如果失去存在就找出所在的地区
       if($role['city'])
       {
       	$where['city']  = $role['city'];

       	$where_city['parent'] = $role['city'];

        $result = M("city")->where($where_city)->field("parent as parentid,name,term_id as id")->select();
       
       }

       //因为超级管理员 什么都为空着查出所有的地区

       if(empty($role['city']) && empty($role['province']))
       {
        $result = M("city")->field("parent as parentid,name,term_id as id")->select();
       }
 
      


      $school = M("school")->field("school_name as name,schoolid,area as parentid")->select();


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
     // ex
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
 
 
     foreach ($school as $key => &$value) {
      $last++;
       $value['id'] = $last;
     }
 
    $result = array_merge($result,$school);


       return $result;



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

}