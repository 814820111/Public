<?php

/**
 * 后台首页  学校划拨
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
 header("Content-type: text/html; charset=utf-8");   
class SchoolTransferController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
               $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->teacher_class_model= D("Common/teacher_class");
        $this->relation_stu_user_model = D("Common/relation_stu_user");
        $this->wxt_agent_model=D("Common/agent");
        $this->department_model=D("Common/department");
        $this->Region=D("Common/city");
       
    }
        public function index() {
        //查询结果分页
        $user_type=I("type");

        $schooiid=I("schooiid");
        $classname=I("classname");
        $school_status=I("school_status");
        $province = I("province");
         $schoolid = I("school_id");
    
        
        $citys = I('citys');
        
    if($province)
       {
        $this->assign("province",$province);
       }
      
       if($citys){
        $this->assign("new_citys",$citys);
       }
           if($schoolid)
      {
        $this->assign("schoolid",$schoolid);
      }


        if($classname!=""){
            $wheres["s.schoolgradetypeid"]=$classname;
            $this->assign("grade_type",$classname);
        }
        if($user_type!=0){
          
            $wheres["s.area"]=$user_type;
		   $where["atea"]=$user_type;
           $this->assign("new_message_type",$user_type);
        }
        if($schooiid!=""){
            $wheres["s.schoolid"]=$schooiid;
			$where["schoolid"]=$schooiid;
        }
        if($school_status!==""){
            $wheres["s.school_status"]=$school_status;
			$where["school_status"]=$school_status;
     
            $this->assign("status",$school_status);
        }
        //获取角色省份
         $Province=role_admin();
               //获取当前角色id
        $roleid = admin_role();

        if($roleid!=1)
        {
          $join_else = "wxt_role_school rs ON rs.schoolid = s.schoolid";
          $where['rs.roleid'] = $roleid;
          $wheres['rs.roleid'] = $roleid;
       

      

        }

//		$wheres["school_status"]!=1 or 0 or 2;
                $count=$this->school_model->alias("s")
                    ->where($wheres)
             		->join("".C('DB_PREFIX').'schoolgradetype c ON s.schoolgradetypeid=c.id')
          		    ->join("".C('DB_PREFIX').'agent a ON s.agent_id=a.id')
           		    ->join("".C('DB_PREFIX').'city e ON s.area=e.term_id ')                    
                    ->join($join_else)
                    ->count();

        $tegion=$this->Region->select();
       $Province=role_admin();

        $class=M("schoolgradetype")->select();
        $page = $this->page($count, 20);
        $school = $this->school_model
            ->alias('s')
            ->join("".C('DB_PREFIX').'schoolgradetype c ON s.schoolgradetypeid=c.id')
            ->join("".C('DB_PREFIX').'agent a ON s.agent_id=a.id')
            ->join("".C('DB_PREFIX').'city e ON s.area=e.term_id ')
            ->join($join_else)
            ->where($wheres)
            ->Field("a.name as name , e.name as agent_name,c.name as class_name,s.*,a.phone as ag_phone")
            ->order("school_status DESC,s.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
           
        
        $agent = M('agent')->field("id,name")->select();
        
        $this->assign("agent",$agent);
        $this->assign("transfer",$transfer);
        $this->assign("Province",$Province);
        $this->assign("class",$class);
        $this->assign("tegion",$tegion);
        $this->assign("page", $page->show('Admin'));
        $this->assign("school",$school);
        $this->display();
    }

    public function transfer()
    {   
    	$new_agentid = I("new_agentid");
    	$old_agentid = I("old_agentid");
        $agent_newname = I('agent_newname');
        $agent_oldname = I('agent_oldname');
        $ag_schoolid = I("ag_schoolid");

        if($ag_schoolid)
        {
        	$data_del = array(
              "schoolid"=>$ag_schoolid,
              "handle"=>2,
              'oldagentid'=>$old_agentid,
              'oldagent_name'=>$agent_oldname,
              'handletime'=>date('Y-m-d H:i:s',time()),
        		);
        	$agent_del = M("school_agent_log")->add($data_del);

        	if($agent_del)
        	{
            $data_add = array(
              "schoolid"=>$ag_schoolid,
              "handle"=>1,
              'oldagentid'=>$old_agentid,
              'oldagent_name'=>$agent_oldname,
              'newagentid'=>$new_agentid,
              'newagent_name'=>$agent_newname, 
              'handletime'=>date('Y-m-d H:i:s',time()),
        		);
              $agent_add = M("school_agent_log")->add($data_add);

              $school = M("school")->where("schoolid = $ag_schoolid")->setField('agent_id',$new_agentid);

             if($school){
    		   $info['status'] = true;
               $info['msg'] = $add;
                $info['name'] = $agent_newname;
                $info['agent_id'] = $new_agentid;
	    	  }else{
	             $info['status'] = false;
	             $info['info'] = '划拨失败';
	    	 }
	    	  echo json_encode($info); 

        	}

        }
    }

    public function transfer_log()
    {    
  

           //获取角色省份
         $Province=role_admin();
               //获取当前角色id
        $roleid = admin_role();

         $province = I("province");
         $schoolid = I("school_id");
    
        
        $citys = I('citys');
        $user_type=I("type");
      
    	 if($roleid!=1)
        {
          $join_else = "wxt_role_school rs ON rs.schoolid = s.schoolid";
          //$wheres['rs.roleid'] = $roleid;
          $where['rs.roleid'] = $roleid;
       


        }

        if($province)
       {
        $this->assign("province",$province);
       }
      
       if($citys){
        $this->assign("new_citys",$citys);
       }
      if($schoolid)
      {  
      	$where['log.schoolid'] = $schoolid;
        $this->assign("schoolid",$schoolid);
      }

        if($user_type!=0){
          
           $where['s.area'] =  $user_type;
           $this->assign("new_message_type",$user_type);
        }

  $count  = M("school_agent_log")
                     ->alias("log")
                     ->join("wxt_school s ON s.schoolid = log.schoolid")
                     ->join("wxt_city c ON s.area=c.term_id")
                     ->join($join_else)
                     ->where($where)
                     ->field("s.create_time,s.school_name,log.handle,log.oldagent_name,log.newagent_name,log.handletime")
                     ->count();
             
$page = $this->page($count, 15);

      $transfer_log  = M("school_agent_log")
                     ->alias("log")
                     ->join("wxt_school s ON s.schoolid = log.schoolid")
                     ->join("wxt_city c ON s.area = c.term_id")
                     ->join($join_else)
                     ->where($where)
                     ->limit($page->firstRow . ',' . $page->listRows)
                     ->field("s.create_time,s.school_name,log.handle,log.oldagent_name,log.newagent_name,log.handletime,log.schoolid,c.name as area")
                     ->select();
                    

        $this->assign("Province",$Province);
        $this->assign("class",$class);
        $this->assign("tegion",$tegion);
        $this->assign("page", $page->show('Admin'));
        $this->assign("transfer_log",$transfer_log);
        $this->display();
      
      
    }


}