<?php

/**
 * 后台首页  学校管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SchoolManageController extends AdminbaseController {


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


//-----------------------学校管理——--------------------


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
           $wheres["s.province"]=$province;
           $where["province"]=$province;
        $this->assign("province",$province);
       }


      
       if($citys){
           $wheres["s.city"]=$citys;
           $where["city"]=$citys;
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
        $page = $this->page($count, 15);
        $school = $this->school_model
            ->alias('s')
            ->join("".C('DB_PREFIX').'schoolgradetype c ON s.schoolgradetypeid=c.id')
            ->join("".C('DB_PREFIX').'agent a ON s.agent_id=a.id')
            ->join("".C('DB_PREFIX').'city e ON s.area=e.term_id ')
            ->join($join_else)
            ->where($wheres)
            ->Field("a.name as name , e.name as agent_name,c.name as class_name,s.*")
            ->order("s.create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        
        $agent = M('agent')->field("id,name")->select();
        
        $this->assign("agent",$agent);
        $this->assign("school_status",$school_status);
        $this->assign("transfer",$transfer);
        $this->assign("Province",$Province);
        $this->assign("class",$class);
        $this->assign("tegion",$tegion);
        $this->assign("page", $page->show('Admin'));
        $this->assign("school",$school);
        $this->display("schoolmanage");
    }
    //通过区域来找对应的学校
    public function lookup(){
        $type=I("type");
         
        if($type!=""){
            if($type==0){
                $School=$this->school_model->field("school_name,schoolid,schoolgradetypeid")->select();
            }else{
                $School=$this->school_model->where("city=$type")->field("school_name,schoolid,schoolgradetypeid")->select();
            }

        }else{
            $ret = $this->format_ret(0,'参数缺失！');
        }

        echo json_encode(array('data'=>$School,'message'=>'10000'));
    }
    //地级划分
    public function Provinces(){
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
	

    //   function format_ret ($status, $data='') {
    //     if ($status){
    //         //成功
    //         return array('status'=>'success', 'data'=>$data);
    //     }else{
    //         //验证失败
    //         return array('status'=>'error', 'data'=>$data);
    //     }
    // }


	
    public function run(){
        $schoolid = intval($_GET['schoolid']);
        if ($schoolid) {
            $rst = $this->school_model->where(array("schoolid"=>$schoolid,"school_status"=>0))->setField('school_status','2');
            if ($rst) {
                $this->success("学校启用成功！", U("index"));
            } else {
                $this->error('学校启用失败！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function stop(){
        $schoolid = intval($_GET['schoolid']);
        if ($schoolid) {
            $rst = $this->school_model->where(array("schoolid"=>$schoolid,"school_status"=>2))->setField('school_status','0');
            if ($rst) {
                $this->success("学校停用成功！", U("index"));
            } else {
                $this->error('学校停用失败！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function change(){
        $schoolid = intval($_GET['schoolid']);
        if ($schoolid) {
            $rst = $this->school_model->where(array("schoolid"=>$schoolid))->find();
            $str=$this->wxt_agent_model->select();
			
            if ($rst) {
                $this->assign("str",$str);
                $this->assign("school",$rst);
                $this->display("changeSchool");
            } else {
                $this->error('学校数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function change_post(){
        if (IS_POST) {

            $data['schoolid']=$_POST['school_id'];
			if($_POST['school_status']){
				$data['school_status']=$_POST['school_status'];
			}
            if(!empty($_POST['agent_id'])){
                $data['agent_id']=$_POST['agent_id'];
            }
            if(!empty($_POST['school_name'])){
                $data['school_name']=$_POST['school_name'];
            }
            if(!empty($_POST['school_address'])){
                $data['school_address']=$_POST['school_address'];
            }
            if(!empty($_POST['school_user'])){
                $data['school_user']=$_POST['school_user'];
            }
            if(!empty($_POST['school_phone'])){
                $data['school_phone']=$_POST['school_phone'];
            }
            if($this->school_model->save($data)){
                $this->success("保存成功！",U('index'));
            }else{
                $this->error("保存失败！");
            }
//            if ($this->users_model->create()) {
//                $result=$this->users_model->save();
//                if ($result!==false) {
//                    $uid=intval($_POST['id']);
//                    $role_user_model=M("RoleUser");
//                    $role_user_model->where(array("user_id"=>$uid))->delete();
//                    foreach ($role_ids as $role_id){
//                        $role_user_model->add(array("role_id"=>$role_id,"user_id"=>$uid));
//                    }
//                    $this->success("保存成功！");
//                } else {
//                    $this->error("保存失败！");
//                }
//            } else {
//                $this->error($this->users_model->getError());
//            }
        }else {
            $this->error("数据传输错误！");
        }
    }
    // public function addschool_post(){

    // }
    //--waiting for delete
    // public function schoolmanage(){
    //     //学校管理
    //     // $count=$this->school_model->where("school_status =1 or 0 or 2")->count();
    //     // $page = $this->page($count, 20);
    //     // $school = $this->school_model
    //     //     ->where("school_status =1 or 0 or 2")
    //     //     ->order("school_status DESC ,create_time DESC")
    //     //     ->limit($page->firstRow . ',' . $page->listRows)
    //     //     ->select();
    //     // $this->assign("page", $page->show('Admin'));
    //     // $this->assign("school",$school);
    //     // $this->display("schoolmanage");
    // }
    public function addschool(){
        //新增学校

        $agentname=$this->wxt_agent_model->field('name,id')->select();
        $class=M("schoolgradetype")->select();
        $tegion=role_admin();
        $this->assign("class",$class);
        $this->assign("tegion",$tegion);
        $this->assign("agentlist",$agentname);
        $this->display("addschool");
    }
    public function addschool_post(){
        if(IS_POST){
            $this->duty_model = D("Common/duty");
            $this->auth_access_model = D("Common/auth_access");
            $this->school_duty_model = D("Common/school_duty");
            $this->access_app_model = D("Common/auth_access_app");
            $this->school_access_app_model = D("Common/school_authaccess_app");
            $this->school_access_model = D("Common/school_authaccess");
            $this->parent_model = D("Common/duty_parent");
            $this->school_parent = D("Common/school_duty_parent");
            $this->switch = D("Common/switch");
            $this->switch_detail = D("switch_detail");

        

            $school_name=$_POST['school_name'];
            $school_address=$_POST['school_address'];
            $school_user=$_POST['school_user'];
            $school_phone=$_POST['school_phone'];
            $agent_id=$_POST['agent_id'];
            //$introduce=$_POST('introduce');
            $province = $_POST['province'];
            $citys = $_POST['citys'];
            $jiang=$_POST['quyu_id'];
            $types=$_POST['types'];
            if(!$types){
                $this->error("请选择学校的类型");
            }
            if(!$jiang){
                $this->error("请选择学校区域");
            }
            if(!$agent_id){
                $this->error("请选择代理商");
            }
            if(empty($_POST['school_name'])){
                $this->error("请输入学校名称");
            }
            if(empty($_POST['school_address'])){
                $this->error("请输入学校地址");
            }
            if(empty($_POST['school_user'])){
                $this->error("请输入联系人");
            }
            if(empty($_POST['school_phone'])){
                $this->error("请输入联系电话");
            }
            
            $adddata=array(
                'school_name'=>$school_name,
                'school_address'=>$school_address,
                'school_user'=>$school_user,
                'school_phone'=>$school_phone,
                'agent_id'=>$agent_id,
                'schoolgradetypeid'=>$types,
                'province'=>$province,
                'city'=>$citys,
                'area'=>$jiang,
                'create_time'=>time()
            );            
            $schoolid=M('school')->add($adddata);

            $school = M('school')->where("schoolid=$schoolid")->find();

            $typeid = $school['schoolgradetypeid'];

            if($schoolid){
                //添加学校年级段
            	$schoolgradetypename=M("gradedictionary")->where("schooltype=$typeid")->select();
                 foreach ($schoolgradetypename as &$grad) {
            	     $gradenames=$grad['name'];
            	     $gradid=$grad['id'];
            	     $gradtime=time();
            	        $add=array(
            	           'schoolid'=>$schoolid,
            	           'name'=>$gradenames,
            	           'create_time'=>$gradtime,
            	           'gradeid'=>$gradid
            	        );
            	         $graddata=M("school_grade")->add($add);
            	        
                  }



                //增加代理商日志
                  $agent = M("agent")->where("id = $agent_id")->field("name")->find();
                  $agent_data = array(
                   'schoolid'=>$schoolid,
                   'handle'=>1,
                   'newagentid'=>$agent_id,
                   'newagent_name'=>$agent['name'],
                   'handletime'=>date('Y-m-d H:i:s',time()),
                  	);
                  M("school_agent_log")->add($agent_data);


                  //添加开关设置

                $switch = $this->switch->select();

                foreach($switch as $switch_val)
                {
                    $data_switch['schoolid'] = $schoolid;
                    $data_switch['identifier'] = $switch_val['identifier'];
                    $data_switch['name'] = $switch_val['name'];
                    $data_switch['status'] = $switch_val['status'];
                    $data_switch['switchid'] = $switch_val['id'];
                    $alldata[] = $data_switch;
                }
                $this->switch_detail->addAll($alldata);



                //添加学校权限
                $duty = $this->duty_model->select();


                foreach ($duty as $key => $value) {
                      //获取通用角色id
                      $role_id = $value['id'];   

                       $name = $value['name'];
                       $level = $value['level'];
                       $ispower = $value['ispower'];

                       $duty_data = array(
                         'schoolid' => $schoolid,
                         'name' => $name,
                         'level' => $level,
                         'ispower'=>$ispower,
                          'duty_id'=> $role_id
                        );
                      //插入学校职责表
                       $duty_add = $this->school_duty_model->add($duty_data);
                              
                      //查询出该角色被配的app权限
                       $access_app = $this->access_app_model->where(array("role_id"=>$role_id,"type"=>'app_url'))->select();
                  
                       foreach ($access_app as  $val) {
                           $school_app = array(
                             'schoolid' => $schoolid,
                             'role_id'=>$duty_add,
                             'appcatid'=>$val['appcatid'],
                             'rule_name'=>$val['rule_name'],
                             'type'=>$val['type'],
                             'status'=>$val['status'],
                            );
                        //循环插入
                   

                         $result =   $this->school_access_app_model->add($school_app);

                     
                  
                       }

                       //查询出该角色被配的老师后台权限
                       $school_menu = $this->auth_access_model->where(array("type"=>'teacher_url',"role_id"=>$role_id))->select();

                       foreach ($school_menu as  $menu) {
                         $menu_data = array(
                              'role_id'=>$duty_add,
                              'schoolid'=>$schoolid,
                              'rule_name'=>$menu['rule_name'],
                              'type'=>$menu['type'],

                            );
                         $this->school_access_model->add($menu_data);
                       }

                    }    

                    //添加家长权限665
                    $duty_parent = $this->parent_model->select();
          
                    //查询出该角色被配的app权限
                    
                    foreach ($duty_parent as $key => $value) {
                         //获取通用角色id
                      $role_id = $value['id'];   

                       $name = $value['name'];
                       $level = $value['level'];
                       $ispower = $value['ispower'];

                       $parent_data = array(
                         'schoolid' => $schoolid,
                         'name' => $name,
                         'level' => $level,
                         'ispower'=>$ispower,
                         'duty_id'=>$role_id,

                        );
                      //插入学校职责表
                       $parent_add = $this->school_parent->add($parent_data);

                       // $parent_app = $this->access_app_model->where("role_id = $role_id and type = parent_url")->select();
                       $parent_app = $this->access_app_model->where(array("role_id"=>$role_id,"type"=>'parent_url'))->select();
                 
                    foreach ($parent_app as  $val) {
                           $school_app = array(
                             'schoolid' => $schoolid,
                             'role_id'=>$parent_add,
                             'appcatid'=>$val['appcatid'],
                             'rule_name'=>$val['rule_name'],
                             'type'=>$val['type'],
                             'status'=>$val['status'],
                            );
                        //循环插入
                   

                         $result =  $this->school_access_app_model->add($school_app);

                     
                  
                       }



                    }


                $this->success("添加成功!");
            }else {
                $this->error("添加失败！");
            }
        }


    }
    public function schoolcheck(){
//        echo "学校审核";
        //学校管理
        //查询结果分页
        $count=$this->school_model->where("school_status =1 or 0 or 2")->count();
        $page = $this->page($count, 20);
        $school = $this->school_model
            ->where("school_status =1 or 0 or 2")
            ->order("school_status DESC ,create_time DESC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show('Admin'));
        $this->assign("school",$school);
        $this->display("schoolcheck");
    }
    public function schoolcheck_details(){
//        echo "学校审核详情";
        $schoolid = intval($_GET['schoolid']);
        if ($schoolid) {
            $rst = $this->school_model->where(array("schoolid"=>$schoolid))->find();

            if ($rst) {
                $this->assign("school",$rst);
                $this->display("schoolcheck_details");
            } else {
                $this->error('学校数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function passcheck(){
        $this->error('该功能暂时未开启！');
    }

    public function classmanage(){
        //班级管理  班级列表
        $schoolid = intval($_GET['schoolid']);
        $schoolname=I('schoolname');
        if ($schoolid) {
            $count=$this->class_model->where("schoolid = $schoolid")->count();
            $page = $this->page($count, 20);
            $classinfo = $this->class_model
                ->alias("c")
                ->join("wxt_school_grade g ON g.gradeid = c.grade")
                ->where("c.schoolid = $schoolid and g.schoolid = $schoolid")
                ->field("c.*,g.name as gradename")
                ->order("c.listorder ASC,c.create_time desc")
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            foreach ($classinfo as &$class) {
                $classid = $class["id"];
                $admininfo = $this->teacher_class_model
                    ->alias("tc")
                    ->join("wxt_wxtuser u ON tc.teacherid = u.id")
                    ->field("u.name,u.phone")
                    ->where("tc.classid=$classid and type=1")
                    ->select();

                $stu_count=M("class_relationship")->where("classid=$classid")->count();
                $class["admininfo"]=$admininfo;
                $class["stu_count"]=$stu_count;
                unset($class);
            }
            foreach($classinfo as &$teachers){
            
                $classid = $teachers["id"];
                $teacherinfo = $this->teacher_class_model
                    ->alias("tc")
                    ->join("wxt_wxtuser u ON tc.teacherid = u.id")
                    ->field("u.id,u.name,u.phone")
                    ->where("tc.classid=$classid and type=2")
                    ->select();	
					$lastResult = "";				
                   $arr = count($teacherinfo);
				   for ($i = 0; $i < $arr; $i++) {
				   	$last=$teacherinfo[$i][name];
					   $lastResult = $lastResult . $last.",";					  
				   }	
                $teachers["teacherinfo"]=$lastResult;
                unset($teachers);
            }





            $this->assign("page", $page->show('Admin'));
            $this->assign("classinfo",$classinfo);

            $this->assign("schoolid",$schoolid);
            $this->assign("schoolname",$schoolname);
            $this->display("classmanage");
        } else {
            $this->error('数据传入失败！');
        }
    }

//    public function  listorders()
//    {
//        $status = parent::_listorders($this->menu_model);
//        if ($status) {
//            $this->success("排序更新成功！");
//        } else {
//            $this->error("排序更新失败！");
//        }
//    }

    public function classchange(){
        //修改班级资料
        $schoolid = intval($_GET['schoolid']);
        $classid = intval($_GET['id']);
        if ($classid&&$schoolid) {
            $rst = $this->class_model->where(array("id"=>$classid))->find();
            $admininfo = $this->teacher_class_model
                ->alias("tc")
                ->join("wxt_wxtuser u ON tc.teacherid = u.id")
                ->field("u.name,u.phone")
                ->where("tc.classid=$classid and type=1")
                ->find();
            $class["adminname"]=$admininfo["name"];
            $class["adminphone"]=$admininfo["phone"];
            if ($rst) {
                $this->assign("schoolid",$schoolid);
                $this->assign("classinfo",$rst);
                $this->assign("admininfo",$admininfo);
                $this->display("classchange");
            } else {
                $this->error('班级数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function classchange_post(){
        //修改班级资料post
        if(IS_POST){
            $classid = intval($_POST['class_id']);
            $data_c['classname']=$_POST['class_name'];
            $this->class_model->where("id=$classid")->save($data_c);
            // $name=$_POST['user_name'];
            // $phone=$_POST['user_phone'];
            // $user=$this->wxtuser_model->field("id,phone")->where("$name=name")->find();
            // $data_t['teacherid']=$user["id"];
            $this->teacher_class_model->where("classid=$classid and type=1")->save($data_t);

            $this->success("保存成功！");
        }else{
            $this->error("数据传输错误！");
        }
    }

    public function listorders()
    {
        $status = parent::_listorders($this->class_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }


    }
    public function addclass(){
        //添加班级
        $schoolid = intval($_GET['schoolid']);
        $school_gradename=M("school_grade")->where("schoolid=$schoolid")->select();
        $this->assign("school_gradename",$school_gradename);        
        $this->assign("school_id",$schoolid);
        $schoolname=$_GET['schoolname'];
        $this->assign("schoolid",$schoolid);
        $this->assign("schoolname",$schoolname);
        $this->display("addclass");
    }
    public function addclass_post(){
        //添加班级post
        // $this->error('该功能暂时未开启！');
        //接收参数
        $schoolid= intval($_POST['school_id']);
        $classname=$_POST['class_name'];
        $gradename=$_POST['grade_name'];
        $grade_type=I("grade_type");
        if(!$gradename){
            $this->error('请选择年级！');
        }
        if(!$classname){
            $this->error('请填写班级名！');
        }

        if(!$grade_type){
            $this->error('请选择班级类型！');
        }
        if($schoolid){
            $data['schoolid']=$schoolid;
            $data['classname']=$classname;
            $data['grade']=$gradename;
            $data['type']=$grade_type;
            $data['create_time']=time();
            // var_dump($data);
            $classid=$this->class_model->add($data);
            if($classid){
            	
                $this->success("保存成功！");
            }else{
                $this->error('数据传入失败！');
            }
        }else{
            $this->error('数据传入丢失！');
        }
        // die('asdfasd');
    }
    public function class_delect(){
        $id=intval($_GET['id']);
        if($id){
            if($stu_count=M("class_relationship")->where("classid=$id")->count() > 0)
            {
              $this->error("班级业务开通不能删除");
            }

            $rst=$this->class_model->where("id=$id")->delete();
            if($rst){
                $this->success("删除成功！");
            }else{
                $this->error("删除失败！");
            }
        }else{
            $this->error('数据传入失败！');
        }
    }
//-----------------------学校管理 end——--------------------


 //----------------------兴趣班-----------------------------   

 public function interestclass()
 { 
    $schoolid = I('schoolid');
    // var_dump($schoolid);
    $schoolname=$_GET['schoolname'];

   
    $where["schoolid"]=$schoolid;
        $where["type"]=2;
        $class_list=M("school_class")->where($where)->select();
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
        $teachers=M("teacher_class")->alias("t")->join("wxt_wxtuser w ON w.id=t.teacherid")->distinct(true)->where("t.schoolid=$schoolid")->field("w.id,w.name")->select();
        $class_all = M("school_class")->where("schoolid=$schoolid and type =1")->select();

    $this->assign("schoolname",$schoolname);
    $this->assign("teachers",$teachers);
    $this->assign("schoolid",$schoolid);
    $this->assign("class_list",$class_list);
    $this->assign("class_all",$class_all);
    $this->display('interestclass');
 }


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
        //  $data["schoolid"]=$schoolid;
        //  $data["userid"]=$studentid;
        //  $data["classid"]=$class_first;
        //  $data["status"]=1;
        //  $data["create_time"]=time();
        //  $add_first=M("class_relationship")->add($data);
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
        //  $data_second["schoolid"]=$schoolid;
        //  $data_second["userid"]=$studentid_else;
        //  $data_second["classid"]=$class_second;
        //  $data_second["status"]=1;
        //  $data_second["create_time"]=time();
        //  $add_second=M("class_relationship")->add($data_second);
        // }
    }


 //---------------------------------------------


//更换班主任
    public function teachers(){
        $schoolid=I('schoolid');
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

    public function interestchange(){
      // echo "aaaa";

        //修改班级资料
        $schoolid = intval($_GET['schoolid']);
        $classid = intval($_GET['id']);

        if ($classid&&$schoolid) {
            $rst = $this->class_model->where(array("id"=>$classid))->find();
            $admininfo = $this->teacher_class_model
                ->alias("tc")
                ->join("wxt_wxtuser u ON tc.teacherid = u.id")
                ->field("u.name,u.phone")
                ->where("tc.classid=$classid and type=2")
                ->find();
             $class=M('school_class')->where("id=$classid")->find();   
             // var_dump($class);

            $class["adminname"]=$admininfo["name"];
            $class["adminphone"]=$admininfo["phone"];
            if ($rst) {
                $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
                $this->assign("class",$class);
                $this->assign("grade",$grade);
                $this->assign("schoolid",$schoolid);
                $this->assign("classinfo",$rst);
                $this->assign("admininfo",$admininfo);
                $this->display("interestchange");
            } else {
                $this->error('班级数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }

    }


    public function edit_post(){
        $id=I("class_id");
        $grade=I("grade");
        $classname=I("classname");
        $data["classname"]=$classname;
        $data["grade"]=$grade;
        $data["type"]=2;
        $data["create_time"]=time();
        $class_edit=M('school_class')->where("id=$id")->save($data);
        if ($class_edit) {
            $this->success("保存成功");
        } else {
            $this->error("保存失败！");
        } 
    }

    public function interestdelete(){
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








//------------------------年级管理---------------------------------
public function grademanage()
{
       $schoolid = intval($_GET['schoolid']);
        $schoolname=I('schoolname');
        // var_dump($schoolname);
        // var_dump($schoolid);
        // var_dump($schoolname);
    $grade = M('gradedictionary')->select(); 

     
    //var_dump($grade);
     $schoo_grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
     
     for($i = 0; $i<count($grade);$i++)
     {
        for($j =0; $j<count($schoo_grade);$j++)
        {
            if($grade[$i]['id']==$schoo_grade[$j]['gradeid'])
            {
                $schoo_grade[$j]['cname']=$grade[$i]['name'];
            }
        }
     }
   
    
     // var_dump($schoo_grade);

    $this->assign("schoolid",$schoolid);
    $this->assign("schoo_grade",$schoo_grade);
    $this->assign("schoolname",$schoolname);
    $this->display("grademanage");
     // exit();

}


    public function addgrade()
    {
          
       //添加年级
        $schoolid = intval($_GET['schoolid']);
        $schoolname=$_GET['schoolname'];
       
        //   var_dump($schoolid);
        $school = M('school')->where("schoolid=$schoolid")->find();
       // var_dump($school);
        $gradeid = $school['schoolgradetypeid'];
      // var_dump($gradeid);
        $grade = M('gradedictionary')->where("schooltype=$gradeid")->select();

      
       $this->assign("grade",$grade);
        $this->assign("schoolname",$schoolname);

         $this->assign("school_id",$schoolid);
        $this->display('addgrade');

    }
  
    public function addgrade_post()
    {

        $schoolid= intval($_POST['school_id']);
       // var_dump($schooiid);
        $classname=$_POST['class_name'];
        //var_dump($classname);
        $gradename=$_POST['grade_name'];
        //var_dump($gradename);
          
           $data['gradeid']=$gradename;
            $data["schoolid"]=$schoolid;
            $data["name"]=$classname;
            $data["create_time"]=time();
            // $data["type"]=$type;
            $class=M('school_grade')->add($data);
            if($class){
            $this->success("添加成功!");
            
          }else{
            $this->error("添加失败");
          }


    }


    public function gradechange()
    {
        $schoolid = intval($_GET['schoolid']);
       
        $gradeid = intval($_GET['id']);
       
       $grade = M('school_grade')->where("id=$gradeid")->find();
 

        $school = M('school')->where("schoolid=$schoolid")->find();         
       // var_dump($school);
        $gradeid = $school['schoolgradetypeid'];
      // var_dump($gradeid);
        //将学校类型的年级组发送到前台
        $grades = M('gradedictionary')->where("schooltype=$gradeid")->select();
      

        if ($grade) {
                $this->assign("schoolid",$schoolid);
                 $this->assign("grades",$grades);
                $this->assign("grade",$grade);
                $this->display("gradechange");
            } else {
                $this->error('班级数据获取失败，请重试！');
            }
        

    }


        public function gradechange_post(){
        //修改班级资料post
        if(IS_POST){
            $classid = intval($_POST['class_id']);
            $data_c['name']=$_POST['user_name'];
            //exit();
            $data_c['edit_time']=time();
           $grade =  M('school_grade')->where("id=$classid")->save($data_c);
            // $name=$_POST['user_name'];
            // $phone=$_POST['user_phone'];
            // $user=$this->wxtuser_model->field("id,phone")->where("$name=name")->find();
          if($grade){
            $this->success("更新成功！");
          }else{
            $this->error("更新失败");
          }  
            

           
        }else{
            $this->error("数据传输错误！");
        }
    }



   
   public function grade_delete()
   {
    $id=intval($_GET['id']);
        if($id){
            $del=M('school_grade')->where("id=$id")->delete();
            if($del){
                $this->success("删除成功！");
            }else{
                $this->error("删除失败！");
            }
        }else{
            $this->error('数据传入失败！');
        }
   }



//-----------------------学生信息管理-----------------------
    public function informationmanage(){
//        echo "学生信息管理";
        //        if(empty($_GET['classid'])){
        if(false){
            $this->display('stuchangeclass');
        }else{
//            $classid=$_GET['classid'];
            $classid=1;
            $stuinfo = $this->wxtuser_model->where("user_type=0")->select();
            $sex_name=array(0=>'女生',1=>'男生');
            foreach($stuinfo as $key=>$value){
                $sex_type = intval($stuinfo[$key]['sex']);
                $stuinfo[$key]['sex_name']=$sex_name[$sex_type];
            }
            $this->assign("stuinfo",$stuinfo);
            $this->display('studentmanage');
        }
    }
    public function changestudent(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->wxtuser_model->where("id=$id")->select();
            if ($rst) {
                $this->display('changestudent');
            } else {
                $this->error('信息获取失败！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function deletestudent(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->wxtuser_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function addstudent(){
        $this->display('addstudent');
    }
    //-----------------------科室管理-----------------------

    public function departmentmanage(){
        //科室管理  科室列表
        $schoolid = intval($_GET['schoolid']);
        $schoolname=I('schoolname');
        if ($schoolid) {
            $count=$this->department_model->where("schoolid = $schoolid")->count();
            $page = $this->page($count, 20);
            $departmentinfo = $this->department_model
                ->where("schoolid = $schoolid")
                ->order("id ASC")
                ->limit($page->firstRow . ',' . $page->listRows)
                ->select();
            $this->assign("epag", $page->show('Admin'));
            $this->assign("departmentinfo",$departmentinfo);
            $this->assign("schoolid",$schoolid);
            $this->assign("schoolname",$schoolname);
            $this->display("departmentmanage");
        } else {
            $this->error('数据传入失败！');
        }
    }
//-----------------------添加科室--------------------------
    public function adddepartment(){
        //添加科室
        $schoolid = intval($_GET['schoolid']);
        $this->assign("schoolid",$schoolid);
        $schoolname=$_GET['schoolname'];
        $this->assign("schoolname",$schoolname);
        $this->display("adddepartment");
    }
    public function adddepartment_post(){
        if($_POST){
            $name=$_POST['name'];
            //$type=$_POST['type'];
            $schoolid=$_POST['school_id'];

            $status = $_POST['status'];
            if(empty($_POST['name'])){
                $this->error("请输入科室名称");
            }else{
                $data=array(
                    'schoolid'=>$schoolid,
                    'name'=>$name,
                    //'type'=>$type,
                    'status'=>$status,
                    'create_time'=>time()
                );
                $schoolid = M("department")->add($data);
                if($schoolid!=0){
                    $this->success("添加成功!");
                } else {
                    $this->error("添加失败！");
                }
            }
        }
        //添加科室post
        //$this->error('该功能暂时未开启！');
    }
//-----------------------添加分组结束----------------------

//-----------------------修改分组信息----------------------
    public function departmentchange(){
        //修改科室资料
        $schoolid = intval($_GET['schoolid']);
        $id = intval($_GET['id']);
        //var_dump($id);
        if ($id&&$schoolid) {
            $rst = M("department")->where(array("id"=>$id))->find();
            if ($rst) {
                $this->assign("schoolid",$schoolid);
                $this->assign("departmentinfo",$rst);
                $this->display("departmentchange");
            } else {
                $this->error('班级数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function departmentchange_post(){
        $id=$_POST['id'];
        $name=$_POST['name'];
        $type=$_POST['type'];
        if(empty($_POST['name'])){
            $this->error("请输入科室名称");
        }else{
            $data=array(
                'id'=>$id,
                'name'=>$name,
                'type'=>$type,
                'create_time'=>time()
            );
            $result=M("department")->save($data);
            if ($result!=false) {
                $this->success("更新科室信息成功！,U('index')");
            }else{
                $this->error("更新失败！");
            }
        }

        //修改科室资料post
        // $this->error('该功能暂时未开启！');
    }
//------------------------修改科室信息结束------------------

//-----------------------删除科室--------------------------
    public function department_delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = M("department")->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    //$this->error('该功能暂时未开通！');

//-----------------------删除科室结束----------------------



//-----------------------学期管理----------------------

    //学期列表

    public function semester()
    {
       $schoolid = I('schoolid');
       
       $semester = M('semester')->field("id,semester,semester_start,semester_end,create_time")->where("schoolid=$schoolid")->order('semester_start DESC')->select();
        foreach ($semester as &$key) {
            $nowtime = date('Y-m-d');
            $start = $key['semester_start'];
            $end = $key['semester_end'];
            if($nowtime>$start&&$nowtime<$end){
                $key['statu'] = '已开学';
            }else{
            
                $key['statu'] = '未开学';
            }
        }

        // var_dump($semester);
        $this->assign('schoolid',$schoolid);
        $this->assign('semester',$semester);


        $this->display();
    }


  //添加学期页面

   public function addsemester()
   {
     $schoolid = I('schoolid');

     $school = M("school")->where("schoolid = $schoolid")->field("school_name")->find();
      
     $schoolname = $school['school_name'];   
    
     $this->assign("schoolname",$schoolname);
     $this->assign("school_id",$schoolid);
     $this->display();
   }

   //添加学期
   public function semester_post()
   {
       $schoolid = I('school_id');
       $semester = I('semester');
       $begin = I('begin');
       $end =  I('end');

       $data = array(
         'schoolid'=>$schoolid,
         'semester'=>$semester,
         'semester_start'=>$begin,
         'semester_end'=>$end,
        );

       $add = M("semester")->add($data);

       if($add)
       {

        $this->success("添加成功");
       }else{
        $this->error("添加失败");
       }


   }
   
   //修改时间

   public function semester_edit()
   {   
         $id = I('id'); 

         $schoolid = I('schoolid');

         $school = M("school")->where("schoolid = $schoolid")->field("school_name")->find();
          
         $schoolname = $school['school_name'];   

         $semester = M('semester')->where("id = $id")->field("semester,semester_start,semester_end")->find();
       
         
         $semester_name = $semester['semester'];
         $semester_start = $semester['semester_start'];
         $semester_end =  $semester['semester_end'];
    
       
         $this->assign("semester_start",$semester_start);
         $this->assign("semester_end",$semester_end);  
         $this->assign("schoolname",$schoolname);
         $this->assign("semester_name",$semester_name);
         $this->assign("school_id",$schoolid);
         $this->assign("id",$id);
         $this->display();


   }

   public function semester_edit_post()
   {
      $id = I('semesterid');
      
      $semester = I('semester');

      $begin = I('begin');

      $end = I('end');

      if($id)
      {
        
        $data = array(
         'semester'=>$semester,
         'semester_start'=>$begin,
         'semester_end'=>$end,
         'create_time'=>time(),

            );

        $save = M("semester")->where("id = $id")->save($data);

        if($save)
        {
            $this->success("修改成功");
        }else{
            $this->error("修改失败");
        }

      }



   }

   public function semester_delete()
   {
      $id = I('id');
      if ($id) {
            $rst = M('semester')->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }




   }





//-----------------------学生信息管理 end------------------- 



//-----------------------学校科目管理 star------------------

   public function schoolsubject()
   {
        
       $userid=$_SESSION['USER_ID'];
        $schoolid=I('schoolid');


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
       
        //自建科目
        $subject_add = M('default_subject')->where($data)->select();
        //var_dump($subject_add);
        //学校类型科目
        $default = M('default_subject')->where($where)->select();
        // var_dump($default);
        //通用科目
        $currency = M("default_subject")->where($where_c)->select();
        // var_dump($currency);
       // var_dump($subject);
        //发送到前台的集合
        $subject = array_merge($default,$subject_add);

        $subject = array_merge($currency,$subject);
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
        //  $subjectid=$item["id"];
        //  array_push($sub_arr, $subjectid);
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
        //  $subject_id=$item["id"];
        //  array_push($self_arr, $subject_id);
        // }
        //选择年级
        //var_dump($subject);
        $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
        $this->assign("schoolid",$schoolid);
        $this->assign("subject",$subject);
        $this->assign("grade",$grade);
        $this->assign("sub",$sub);
        $this->assign("sub_arr",$sub_arr);
        $this->assign("self_arr",$self_arr);
        $this->display();


   }


   //学校开关设置

    public function switch_index()
    {
        $schoolid = I("schoolid");

        $switch = M("switch_detail")->where("schoolid = $schoolid")->select();

        $this->assign("switch",$switch);
        $this->display();
    }


    public function save_switch()
    {
        $id = I("id");

        $status = I("status");

        $save = M("switch_detail")->where(array("id"=>$id))->save(array("status"=>$status));

        if($save)
        {
            $info['status'] = true;
            $info['msg'] = "更新成功";
        }else{
            $info['status'] = false;
            $info['msg'] = "更新成功";
        }

        echo json_encode($info);



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
        $schoolid=I('schoolid');
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
        $schoolid=I("schoolid");
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
      //        $subject=$subjectids[$i];
      //        //根据id查找数据库,判断是否有值

         //         if($sub[$i]['subjectid']==$subject[$j]['id'])
         //         {
         //             $subject[$j]['statu']=1;
         //             //$schoo_grade[$j]['cid']=$grade[$i]['id'];
         //         }

        // }
       // exit();



       
  //       var_dump($id);
  //      $schoolsubjects = M('subject')->where("subjectid in ($id)")->select();
  //     var_dump($sub);
  //        foreach ($schoolsubjects as &$subject) {
  //            $subject["id"];
        //  $subject_id=$item["id"];
        //  array_push($self_arr, $subject_id);
        // }


      // $datarow = array(

      //  'schoolid'=>$schoolid,
      //  'subjectid'=>$id,

      //    );

     
      //  $rel = M('subject')->add($datarow);
      // exit();
      

       // foreach ($sub as  $value) {
       //   if ($value['subjectid']==$subject) {
       //       echo "dasdsa";
       //   }
       //  } 
      //  var_dump($sub);


        //var_dump($subject);
     


        // $grade=Intval(I("garade_select"));
        // if($subject && $grade){
        //  $where["schoolid"]=$schoolid;
        //  $where["gradeid"]=$grade;
        //  $delete=M("subject")->where($where)->delete();
        //  if($delete){
        //      foreach ($subject as &$subjectid) {
        //          $data["schoolid"]=$schoolid;
        //          $data["subjectid"]=$subjectid;
        //          $data["gradeid"]=$grade;
        //          $subject_add=M("subject")->add($data);
        //          $this->success("成功");
        //      }
        //  }
        // }else{
        //  $this->error("未获取到数据");
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
        }else{  //验证失败
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




//-----------------------学校科目管理 end------------------





//---------------------教师管理----------------------------
    public function teachermanage(){
//        echo "教师管理";
        $count=$this->wxtuser_model->where("user_type = 1")->count();
        $page = $this->page($count, 20);
        $teacher =$this->wxtuser_model
            ->where("user_type = 1")
            ->order("id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //获取所属学校名称

        foreach($teacher as $key=>$value){
            $schoolid = intval($teacher[$key]['schoolid']);
            $teacher[$key]['schoolname']=$this->school_model->where("schoolid = $schoolid")->getField('school_name');
        }
        $this->assign("page", $page->show(''));
        $this->assign("teacher",$teacher);
        $this->display("teachermanage");
    }
    function passwordReset(){
        $id=intval($_GET['id']);
        if ($id) {
            $md5_pass = md5('123456');
            $rst = $this->wxtuser_model->where("id=$id")->setField('password',$md5_pass);
            if ($rst) {
                $this->success("密码重置成功！");
            } else {
                $this->error('密码未改变，或重置失败！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function addteacher(){
        //新增教师
        $this->display("addteacher");
    }
    public function addteacher_post(){
        $this->error('该功能暂时未开启！');
    }
    public function delete_teacher(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->wxtuser_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    function bindingclass(){
        $id=intval($_GET['id']);
        $count=$this->teacher_class_model->where("teacherid = $id AND status = 1")->count();
        $page = $this->page($count, 20);
        $bindclass =$this->teacher_class_model
            ->where("teacherid = $id AND status = 1")
            ->order("classid ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //获取所属学校名称
        foreach($bindclass as $key=>$value){
            $classid = intval($bindclass[$key]['classid']);
            $bindclass[$key]['classname']=$this->class_model->where("id = $classid")->getField('classname');
        }
        $this->assign("teacherid",$id);
        $this->assign("page", $page->show(''));
        $this->assign("bindclass",$bindclass);
        $this->display("bindingclass");
    }
    function addbinding(){
        $id=intval($_GET['id']);
        $teacherinfo = $this->wxtuser_model->where("id = $id")->find();
        $schoolid = intval($teacherinfo['schoolid']);
        $teacherinfo['schoolname']=$this->school_model->where("schoolid = $schoolid")->getField('school_name');
        $this->assign("teacherinfo", $teacherinfo);
        $this->display("addbinding");
    }
    function addbinding_post(){
        $this->error('该功能暂时未开启！');
    }
    function delete_binding(){
        $id=intval($_GET['bindingid']);
        if ($id) {
            $rst = $this->teacher_class_model->where("t_id=$id")->save(array("status"=>0));
            if ($rst) {
                $this->success("解除成功！");
            } else {
                $this->error("解除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
//---------------------教师管理 end---------------------------
//----------------------家长学生账号管理 ----------------------
    public function tea_stu_user(){
        echo "家长学生账号";
    }
    public function parentsuser(){
        $count=$this->wxtuser_model->where("user_type = 2")->count();
        $page = $this->page($count, 20);
        $parentsuser =$this->wxtuser_model
            ->where("user_type = 2")
            ->order("id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //获取所属学校+班级名称
        foreach($parentsuser as $key=>$value){
            $schoolid = intval($parentsuser[$key]['schoolid']);
            $classid = intval($parentsuser[$key]['classid']);
            $parentsuser[$key]['schoolname']=$this->school_model->where("schoolid = $schoolid")->getField('school_name');
            $parentsuser[$key]['classname']=$this->class_model->where("id = $classid")->getField('classname');
        }
        $this->assign("page", $page->show(''));
        $this->assign("parentsuser",$parentsuser);
        $this->display("parentsmanage");
    }
    public function ch_userinfo(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->wxtuser_model->where(array("id"=>$id))->find();
            if ($rst) {
                $this->assign("parentsuser",$rst);
                $this->display("changeuserinfo");
            } else {
                $this->error('用户数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function ch_userinfo_post(){
        $this->error('该功能暂时未开启！');
    }
    public function addparentsuser(){
        //新增教师
        $this->display("addparentsuser");
    }
    public function addparentsuser_post(){
        $this->error('该功能暂时未开启！');
    }
    public function sendmassage(){
        //发送短信
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->wxtuser_model->where(array("id"=>$id))->find();
            if ($rst) {
                $this->assign("parentsuser",$rst);
                $this->display("sendmassage");
            } else {
                $this->error('用户数据获取失败，请重试！');
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
    public function sendmassage_post(){
        $this->error('该功能暂时未开启！');
    }
    function bindingstu(){
        $id=intval($_GET['id']);
        $count=$this->relation_stu_user_model->where("userid = $id")->count();
        $page = $this->page($count, 20);
        $bindstu =$this->relation_stu_user_model
            ->where("userid = $id")
            ->order("id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        //获取绑定的学生姓名  学校  班级
        foreach($bindstu as $key=>$value){
            $stuid = intval($bindstu[$key]['studentid']);
            $bindstu[$key]['name']=$this->wxtuser_model->where("id = $stuid")->getField('name');

            $classid = intval($this->wxtuser_model->where("id = $stuid")->getField('classid'));
            $bindstu[$key]['classname']=$this->class_model->where("id = $classid")->getField('classname');

            $schoolid = intval($this->wxtuser_model->where("id = $stuid")->getField('schoolid'));
            $bindstu[$key]['schoolname']=$this->school_model->where("schoolid = $schoolid")->getField('school_name');
        }
        $this->assign("userid",$id);
        $this->assign("page", $page->show(''));
        $this->assign("bindstu",$bindstu);
        $this->display("bindstu");
    }
    function addbindingstu(){
        $id=intval($_GET['id']);
        $this->assign("userid", $id);
        $this->display("addbindingstu");
    }
    function addbindingstu_post(){
        $this->error('该功能暂时未开启！');
    }
    function delete_bindingstu(){
        $id=intval($_GET['bindid']);
        if ($id) {
            $rst = $this->relation_stu_user_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("解除成功！");
            } else {
                $this->error("解除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
    }
//----------------------家长学生账号管理 end----------------------
    public function dataimport(){
        echo "数据导入状态查询";
    }
//----------------------学生调班  ---------------------
    public function stu_change_class(){
//        if(empty($_GET['classid'])){
        if(false){
            $this->display('stuchangeclass');
        }else{
//            $classid=$_GET['classid'];
            $classid=1;
            $stuinfo = $this->wxtuser_model->where("classid = $classid AND user_type=0")->select();
            $this->assign("stuinfo",$stuinfo);
            $this->display('stuchangeclass');
        }
    }
    public function chclass_post(){
        $this->error('该功能暂时未开启！');
    }
//----------------------学生调班 end----------------------
//----------------------学生转校  ---------------------
    public function stu_change_school(){
        //        if(empty($_GET['classid'])){
        if(false){
            $this->display('stuchangeschool');
        }else{
//            $classid=$_GET['classid'];
            $classid=1;
            $stuinfo = $this->wxtuser_model->where("classid = $classid AND user_type=0")->select();
            $this->assign("stuinfo",$stuinfo);
            $this->display('stuchangeschool');
        }
    }
    public function chschool_post(){
        $this->error('该功能暂时未开启！');
    }
//----------------------学生转校end  ---------------------
//----------------------黑名单管理  ---------------------
    public function blacklist(){
//        echo "黑名单管理";
        $count=$this->wxtuser_model->where("status = 2")->count();
        $page = $this->page($count, 20);
        $user =$this->wxtuser_model
            ->where("status = 2")
            ->order("id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show(''));
        $this->assign("user",$user);
        $this->display("blacklist");
    }
    public function addblackuser(){
        $this->display("addblackuser");
    }
    public function addblackuser_post(){
        $this->error('该功能暂时未开启！');
    }
    public function recover(){
        $this->error('该功能暂时未开启！');
    }
//----------------------黑名单管理  end ---------------------
//----------------------敏感字段设置  ---------------------
    public function sensitivityset(){
//        echo"敏感字段设置";
        $count=M('sensitive_field')->count();
        $page = $this->page($count, 20);
        $sensitive_field =M('sensitive_field')
            ->order("field_id ASC")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
        $this->assign("page", $page->show(''));
        $this->assign("sensitivefield",$sensitive_field);
        $this->display("sensitivefield");
    }
    public function addfield(){
        $this->display("addfield");
    }
    public function addfield_post(){
        $this->error('该功能暂时未开启！');
    }
    public function delete_field(){
        $this->error('该功能暂时未开启！');
    }
//----------------------敏感字段设置 end ---------------------

   
}

