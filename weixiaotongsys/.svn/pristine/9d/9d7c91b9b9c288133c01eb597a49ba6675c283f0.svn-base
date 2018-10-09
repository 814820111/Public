<?php

/**
 * 老师填写
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");      
class BindingController extends AdminbaseController {
     
     public function index()
     {
     	
       $schoolid = I("schoolid");


           
      
     	$Province=role_admin();


       // var_dump($class_list);
       // exit();


	    $this->assign("Province",$Province);

	    $this->display("WeChat");
     }

     public function  WeChat()
     {
     	$schoolid = I("schoolid");
      
       $gradeid = I('gradeid');
       
       $classid = I('classid');

       $zui = I('zui');
         $zui=trim( $zui);
       $tiaojian = I('tiaojian');
       if($schoolid || ($tiaojian && $zui))
       {
           if($schoolid)
           {
               $where["c.schoolid"] = $schoolid;
           }
         
	      if($gradeid)
	      {
	      	$where['sc.grade'] = $gradeid;
	      }
	      if($classid)
	      {
	      	$where['sc.id'] =$classid;
	      }
	      if($zui) {
              switch ($tiaojian)  // 通过function_num_args()函数计算传入参数的个数，根据个数来判断接下来的操作
              {
                  case name:
                      $where['info.stu_name'] = array('like', "%$zui%");
                      break;
                  case names:
                      $where['u.NAME'] = array('like', "%$zui%");
                      break;
                  case phone:
                      $where['u.phone'] = array('like', "%$zui%");
                      break;
                  default:
                      ;
              }
          }
//	     $appid = M("wxmanage")->where("schoolid = $schoolid")->getField("wx_appid");



        
 
	  
        //$student_sum = M("class_relationship")->where("schoolid = $schoolid")->select();
           $count = M("class_relationship")
                    ->alias("c")
                    ->join("wxt_school_class sc ON sc.id=c.classid")
                    ->join("wxt_student_info info ON c.userid = info.userid") 
                    ->join("wxt_relation_stu_user rel ON info.userid=rel.studentid")
                    ->join("LEFT JOIN wxt_wxtuser u ON rel.userid = u.id")
                    ->field("info.userid,c.schoolid,c.classid,c.schoolid,info.stu_name,rel.phone,sc.classname,rel.name as parent_name,info.bindingkey,rel.appellation,u.last_login_time")
			        ->where($where)
			        ->count(); 
       $page = $this -> page($count, 20);


        $binding = M("class_relationship")
                    ->alias("c")
                    ->join("wxt_school_class sc ON sc.id=c.classid")
                    ->join("wxt_student_info info ON c.userid = info.userid") 
                    ->join("wxt_relation_stu_user rel ON info.userid=rel.studentid")
                    ->join("LEFT JOIN wxt_wxtuser u ON rel.userid = u.id")
                    ->field("info.userid,c.schoolid,c.classid,c.schoolid,info.stu_name,u.phone,sc.classname,u.name as parent_name,info.bindingkey,rel.appellation,u.last_login_time,rel.userid as parentid,u.app_status,rel.userid as parentid")
			        ->where($where)
			        -> limit($page -> firstRow . ',' . $page -> listRows) 
			        ->select();
           if(!$schoolid)
           {
               //不选中学校时的查询
               $binding = $this->get_parentids($binding);
               foreach ($binding as $key => &$value) {


                   if ($value['appid'] == 1) {
                       $value['appid'] = '已绑定';
                   } else {
                       $value['appid'] = '未绑定';
                   }

                   if ($value['last_login_time']) {
                       $value['last_login_time'] = '已登录';
                   } else {
                       $value['last_login_time'] = '未登录';
                   }

                   if ($value['status'] == 1) {
                       $value['status'] = '已启动';
                   } elseif ($value['status'] == 2) {
                       $value['status'] = '已冻结';

                   } else {
                       $value['status'] = '';
                   }
                   if ($value['app_status'] == 1) {
                       $value['app_status'] = '已启动';
                   } elseif ($value['app_status'] == 2) {
                       $value['app_status'] = '已冻结';

                   }
               }
           }else {
               $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolid")->field("b.wx_appid,b.wx_appsecret")->find();
               //获取家长否绑定微信
               $binding = $this->get_parentid($binding, $wxmanage['wx_appid']);

               foreach ($binding as $key => &$value) {


                   if ($value['appid'] == 1) {
                       $value['appid'] = '已绑定';
                   } else {
                       $value['appid'] = '未绑定';
                   }

                   if ($value['last_login_time']) {
                       $value['last_login_time'] = '已登录';
                   } else {
                       $value['last_login_time'] = '未登录';
                   }

                   if ($value['status'] == 1) {
                       $value['status'] = '已启动';
                   } elseif ($value['status'] == 2) {
                       $value['status'] = '已冻结';

                   } else {
                       $value['status'] = '';
                   }
                   if ($value['app_status'] == 1) {
                       $value['app_status'] = '已启动';
                   } elseif ($value['app_status'] == 2) {
                       $value['app_status'] = '已冻结';

                   }
               }
           }
         
  

			       
	      $Page[] =  $page -> show('Admin');
          $result = array_merge($Page,$binding);

        
			  
	     if (!empty($result)){
           $ret = $this->format_ret_else(1,$result);
          
           echo json_encode($result);
           //echo $Page;
          

           // $this -> assign("Page", $page -> show('Admin'));
           
	        }else{
	            $ret = $this->format_ret_else(0,"parms lost");
	           $this -> assign("Page", $page -> show('Admin'));
	           echo json_encode($ret);
	           
	        }

        exit();

        //查询出要查找的学校
		$class_list=M("school_class")->where($where)->field("id,classname")->select();
        


		
        

		foreach ($class_list as $key => &$value) {
			$classid = $value['id'];

			//获取学生总人数  用select 就不需要再查一遍了
			$student_sum = M("class_relationship")->where("schoolid = $schoolid and classid = $classid")->select();
			$value['student_sum'] = count($student_sum);
             
             $weixin_sum = 0;
            //获取绑定人数
            foreach ($student_sum as  $val) {
            	$studentid = $val['userid'];
            	//查出亲属关系 TODO 还不确定是否要查的是主号码
            	$relation  = M("relation_stu_user")->where("studentid = $studentid")->field("userid")->find();
                 
                 // var_dump($relation);
                 //TODO暂时先用userid 来标识唯一性 以后考虑是否加上appid 
                $res = M("xctuserwechat")->where(array("userid"=>$relation['userid']))->field("id")->find();

                if($res)
                {
                	$weixin_sum  = $weixin_sum + 1;
                } 


            }

            $value['weixin_sum'] = $weixin_sum;

            $value['weixin_not'] = count($student_sum)-$weixin_sum;

		}
           if (!empty($class_list)){
           $ret = $this->format_ret_else(1,$class_list);
           echo json_encode($class_list);
	        }else{
	            $ret = $this->format_ret_else(0,"parms lost");
	           echo json_encode($ret);
	        }

       }
     }


     public function get_parentid($arr,$appid)
     {
         $parentid = '';
         //循环出来用户的信息
         for ($i=0;$i<count($arr);$i++){
             $parentid .= $arr[$i]["parentid"].",";
         }

         $parentid = trim($parentid,",");

         $where['userid'] = array("in",$parentid);
         $where['appid'] = $appid;

         $parent_wx = M("xctuserwechat")->where($where)->select();

         foreach ($arr as &$value)
         {
            foreach ($parent_wx as $val)
            {
                if($value['parentid']==$val['userid'])
                {

                    $value['appid'] = 1;
                    $value['status'] = $val['status'];
                    $value['createtime'] = date('Y-m-d H:i:s',$val['createtime']);
                    break;
                }else{
                    $value['appid'] = 2;
                }
            }
         }


         return $arr;
     }
     //不选择学校时的直接查询
    public function get_parentids($arr)
    {
       foreach ($arr as &$value)
        {
            $where['userid'] = $value["parentid"];
            $schoolids=$value["schoolid"];
            $wxmanage = M('wxmanage_school')->alias("a")->join("wxt_wxmanage b ON a.manage_id = b.id")->where("a.schoolid = $schoolids")->field("b.wx_appid,b.wx_appsecret")->find();
            $where['appid'] =$wxmanage['wx_appid'];
            $parent_wx = M("xctuserwechat")->where($where)->select();

                if($value['parentid']==$parent_wx[0]['userid'])
                {

                    $value['appid'] = 1;
                    $value['status'] = $parent_wx['status'];
                    $value['createtime'] = date('Y-m-d H:i:s',$val['createtime']);
                }else{
                    $value['appid'] = 2;
                }

        }
        return $arr;
    }
     public function show_weixin()
     {
     	$schoolid = I("schoolid");
     	
     	$classid = I("classid");

        $where['schoolid'];
        $where['clasid'];
        //查询出该班级所有信息 
     	



     }

      //----------------------重置密码--------------------------------

// TOODO 修改密码 没加正正则判断
     public function reset_word()
      {
                    $parentid=I("parentid");
             
                     
                    $phone = M('wxtuser')->where("id=$parentid")->getField("phone");

                    $pwd = substr($phone, -6);

                     $rel = M('wxtuser')->where("id=$parentid")->setField('password',md5($pwd));
                     
                        if (false!==$rel) {
                                $info['status'] = true;
                                $info['msg'] = $pwd;
                            } else {
                                $info['status'] = false;
                                $info['info'] = '重置失败';
                            }
                echo json_encode($info);   
          }




 //----------------------重置密码end--------------------------------------
  

  public function status()
  {
  	$parentid = I('parentid');
  	$status = I('status');
  	$type = I('sql_type');
   
   if($type == 1)
   {
   	$sql = 'xctuserwechat';
   	$field = 'status';
   	$where['userid'] = $parentid;
   }elseif($type == 2){
   	$sql = 'wxtuser';
   	$field = 'app_status';
   	$where['id'] = $parentid;
   }

     if($sql)
     {  
     	 //todo  需要完善 根据appid来区分
     	$rel = M($sql)->where($where)->setField($field,$status);

     	      if ($rel > 0) {
                                $info['status'] = true;
                                $info['msg'] = $parentid;
                            } else {
                                $info['status'] = false;
                                $info['info'] = '执行失败';
                            }
                echo json_encode($info);   
     }


  } 

     function format_ret_else ($status, $data='') {
            if ($status){   
            //成功
                return array('status'=>'success', 'data'=>$data);
            }else{  
                //验证失败
                return array('status'=>'error', 'data'=>$data);
            }
        }




}