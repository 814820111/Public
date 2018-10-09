<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;       
class AdminRoleController extends AdminbaseController {


    protected $role_model, $auth_access_model;
    



    function _initialize() {
        parent::_initialize();
        $this->role_model = D("Common/Role");
    }

    /**
     * 角色管理，有add添加，edit编辑，delete删除
     */
    public function index() {
        $user_id = $_SESSION['ADMIN_ID'];
       
        $categoryid = I('categoryid');

        $role_name = I("role_name");

        $Province = I("province");

        $city = I("city");

        if ($Province) {
            $where_child['Province'] = $Province;
            $this->assign('pp',$Province);
        }


        
       if($city)
       {
        $where_child['city'] = $city;
        $this->assign("citys",$city);
       }

 

        $role = M("role_user")->where("user_id = $user_id")->getField("role_id");

          if(empty($role))
          {
            $role = 1;
          }

          if($categoryid)
          {
            $where_child['categoryid'] = $categoryid;
            $this->assign("categoryid",$categoryid);
          }

          if($role_name)
          { 
                $this->assign("rolename",$role_name);
                if($role_name=='role_name')
                {

                $name = I("keyname");
                $where_child['name'] = array("LIKE","%".$name."%");
                $this->assign("name",$name);
                 }
          }

          //获取当前角色省份省份

       $result = role_admin();


         // $where_parent['id'] = $role;
         $where_child['pid|id'] = $role; 

         

         $count = $this->role_model->order()->where($where_child)->count();
         $page = $this->page($count, 15);
     
         $data = $this->role_model->order()->limit($page->firstRow . ',' . $page->listRows)->where($where_child)->select();
       // var_dump($data);
       // exit();
        // $data  = $self_data + $data;
        // var_dump($data);


        $this->assign("Page", $page->show('Admin'));
        $this->assign("Province",$result);
        $this->assign("role",$role);
        $this->assign("roles", $data);
        $this->display();
    }

    /**
     * 添加角色
     */
    public function roleadd() {





      $user_id = $_SESSION['ADMIN_ID'];


   
      $role = M('role_user')->alias("ru")->where("ru.user_id = $user_id")->join("wxt_role r ON r.id=ru.role_id")->field('role_id,r.name,r.pid,r.Province,r.city')->find();

      $leves = access_level($role['role_id']);

      if($leves!=1)
      {
          $this->error("不是一级子账号不能添加角色！");
      }

      if($role['role_id']==1 || empty($role))
      {
        $role_name = '超级管理员';
        //超级管理员pid
        $role_id =$_SESSION['ADMIN_ID'];
        $parent = '九五至尊';
         $Province = M('city')->where(array("parent"=>0))->select();
 
      }else{
           
        //省份
        $Province = M('city')->where(array("term_id"=>$role['province']))->select();


        $role_id = $role['role_id'];
      //登录角色名称
       $role_name = $role['name'];
       $category = gain_category($role_id);
       $parent = M("role")->where(array("id"=>$role['pid']))->getField('name'); 

      }
      


      //父角色
      // $parent = M("role")->where(array("id"=>$role['pid']))->getField('name'); 
      
        $agent = M("agent")->select();
        if($category)
        {

            $this->assign('category',$category);
        }
        $this->assign("agent",$agent);
        $this->assign("Province",$Province);
        $this->assign("parent",$parent); 
        $this->assign('role_name',$role_name); 
        $this->assign("role",$role_id);

        $this->display();
    }
    
    /**
     * 添加角色
     */
    public function roleadd_post() {
        $user_id = $_SESSION['ADMIN_ID'];
        $role = M("role_user")->where("user_id = $user_id")->getField("role_id");


        //省份
        $Province = I("province");
        //是否是一级
         $isonelevelrole = M("role")->where("id = $role")->find();
         //大类
         $categoryid = I("categoryid");
        //代理商
        $agentid = I("agentid");
           if($isonelevelrole['isonelevelrole']!=1)
           {
            $this->error("不是一级账号不能添加角色");
           }

           if($categoryid==2)
           {

            if(!$Province)
            {
                $this->error("请选择省份");
            }
           }
            $city = I("city");

           if($categoryid==2)
           {

            if(!$city)
            {
                $this->error("请选择地市");
            }
           }

       
        if (IS_POST) {


            if($categoryid==2 && $agentid==0 && $role==1)
            {
                $this->error("请选择代理商");
            }



            if($agentid)
            {
            $rel = M("role")->where("agentid = $agentid")->select();
            }
             if($rel)
            {
                $this->error("代理商已存在!");
            }

            if ($this->role_model->create()) {
                if ($this->role_model->add()!==false) {
                    $add_roleid =$this->role_model->getLastInsID();


                    if($role==1)
                    {
                        //如果是超级管理员添加的角色,则将权限自动分配
                        if($categoryid==1)
                        {
                            //如果是内部管理员
                            $school = M("school")->where(array("city"=>$city))->field('province,city,area,schoolid')->select();
                        }else{
                            //代理商
                            $school = M("school")->where(array("agent_id"=>$agentid))->field('province,city,area,schoolid')->select();
                        }
                        foreach ($school as $val)
                        {
                            $data['roleid'] = $add_roleid;
                            $data['province'] = $val['province'];
                            $data['city'] = $val['city'];
                            $data['area'] = $val['area'];
                            $data['schoolid'] = $val['schoolid'];
                            $alldata[]=$data;
                            unset($data);
                        }
                        M('role_school')->addAll($alldata);
                    }
                    $this->success("添加角色成功",U("AdminRole/index"));
                } else {
                    $this->error("添加失败！");
                }
            } else {
                $this->error($this->role_model->getError());
            }
        }
    }

    /**
     * 删除角色
     */
    public function roledelete() {
        $id = intval(I("get.id"));
        if ($id == 1) {
                 $this->error("超级管理员角色不能被删除！");
        }
        $role_user_model=M("RoleUser");
        $count=$role_user_model->where("role_id=$id")->count();
        if($count){
            $this->error("该角色已经有用户！");
        }else{
            $status = $this->role_model->delete($id);
            if ($status!==false) {
                $this->success("删除成功！", U('AdminRole/index'));
            } else {
                $this->error("删除失败！");
            }
        }
        
    }

    /**
     * 编辑角色
     */
    public function roleedit() {
        $id = intval(I("get.id"));

        $user_id = $_SESSION['ADMIN_ID'];

        // var_dump($user_id);

        $role = M('role_user')->alias("ru")->where("ru.role_id = $user_id")->join("wxt_role r ON r.id=ru.role_id")->field('role_id,r.name,r.pid,r.Province,r.city')->find();


        if ($id == 0) {
            $id = intval(I("post.id"));
        }
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        $data = $this->role_model->where(array("id" => $id))->find();
        // var_dump($data);
        if (!$data) {
            $this->error("该角色不存在！");
        }

        if($role['role_id']==1 || empty($role))
        { 
           $role = 1; 
           $role_id = $_SESSION['ADMIN_ID'];
           $parent = '超级管理员';
            $Province = M('city')->where(array("parent"=>0))->select();
              $this->assign("id",$role);
        }else{
            //省份
           $Province = M('city')->where(array("term_id"=>$role['province']))->select();
             
           $parent = M("role")->where(array("id"=>$role['pid']))->getField('name'); 

           $role_id = $role['role_id'];
        }





        
     
         $this->assign("role",$role_id);
      
        $this->assign("Province",$Province);
        $this->assign("citys",$data['city']);
         $this->assign("Proce",$data['province']);
        $this->assign("parent",$parent);
        $this->assign("roletype",$data['roletype']);
        $this->assign("data", $data);
        $this->assign("categoryid",$data['categoryid']);
        $this->display();
    }
    
    /**
     * 编辑角色
     */
    public function roleedit_post() {
        $id = intval(I("get.id"));
        if ($id == 0) {
            $id = intval(I("post.id"));
        }
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        if (IS_POST) {
            $data = $this->role_model->create();
            if ($data) {
                if ($this->role_model->save($data)!==false) {
                    $this->success("修改成功！", U('Rbac/index'));
                } else {
                    $this->error("修改失败！");
                }
            } else {
                $this->error($this->role_model->getError());
            }
        }
    }

    /**
     * 角色授权
     */
    public function authorize() {
        $this->auth_access_model = D("Common/AuthAccess");
       //角色ID
        $roleid = intval(I("get.id"));
        // var_dump($roleid);
        if (!$roleid) {
            $this->error("参数错误！");
        }
        import("Tree");
        $menu = new \Tree();
       // var_dump($menu);
        $menu->icon = array('│ ', '├─ ', '└─ ');
        $menu->nbsp = '&nbsp;&nbsp;&nbsp;';
  
        $result = M("menu")->select();

     
         $user_id = $_SESSION['ADMIN_ID'];

         $role = M('role_user')->where("user_id = $user_id")->field('role_id')->find();



         
        $newmenus=array();

       $priv_data=$this->auth_access_model->where(array("role_id"=>$role['role_id']))->getField("rule_name",true);//获取权限表数据
   
         $priv_data_role=$this->auth_access_model->where(array("role_id"=>$roleid,"status"=>1))->getField("rule_name",true);//获取权限表数据
         

   if($role['role_id']!=1)
   { 
     
      $aa = array();

        foreach ($result as $key => $value) {
            $ama = $value['app'].'/'.$value['model'].'/'.$value['action'];
            // var_dump($ama);


                foreach ($priv_data as $val) {
                    if(strtolower($ama)==$val)
                    {
                        array_push($aa,$result[$key]);
                    }
                }
             
        }
      $result = $aa;

   }
       //新加的
    
       // var_dump($priv_data);


  
 foreach ($result as $m){
         $newmenus[$m['id']]=$m;
        }
     foreach ($result as $n => $t) {
         $result[$n]['checked'] = ($this->_is_checked($t, $roleid, $priv_data_role)) ? ' checked' : '';
         $result[$n]['level'] = $this->_get_level($t['id'], $newmenus);
         $result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-' . $t['parentid'] . '"' : '';

         if($result[$n]['status']==0)
         {
             $result[$n]['name'] = $result[$n]['name']."(功能)";
         }

        }

        $str = "<tr id='node-\$id' \$parentid_node>
                       <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
                    </tr>";

             
        $menu->init($result);

        $categorys = $menu->get_tree(0, $str);
   
     // var_dump($categorys);

        //以前的
       
        // foreach ($result as $m){
        //  $newmenus[$m['id']]=$m;
        // }
        // var_dump($newmenus);
        // foreach ($result as $n => $t) {
        //  $result[$n]['checked'] = ($this->_is_checked($t, $roleid, $priv_data)) ? ' checked' : '';
        //  $result[$n]['level'] = $this->_get_level($t['id'], $newmenus);
        //  $result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-' . $t['parentid'] . '"' : '';
        // }
        // $str = "<tr id='node-\$id' \$parentid_node>
        //                <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
                    // </tr>";
        // $menu->init($result);
        // $categorys = $menu->get_tree(0, $str);

        
        $this->assign("categorys", $categorys);
        //var_dump($categorys);
   
        $this->assign("roleid", $roleid);
        // var_dump($roleid);
        $this->display();
    }
    
    /**
     * 角色授权
     */
    public function authorize_post() {



     $user_id = $_SESSION['ADMIN_ID'];
     $role = M("role_user")->where("user_id = $user_id")->getField("role_id");

     $isonelevelrole = M("role")->where("id = $role")->getField("isonelevelrole");
       if($isonelevelrole!=1 && $role!=1)
       {
        $this->error("不是超级管理员和一级账户不能授权!");
       }


        $this->auth_access_model = D("Common/AuthAccess");
        if (IS_POST) {
            $roleid = intval(I("post.roleid"));
            if(!$roleid){
                $this->error("需要授权的角色不存在！");
            }
         // $result =  $this->auth_access_model->where(array("role_id"=>$roleid,'type'=>'admin_url'))->select();
         // var_dump($result);
         // exit();
       

                $menu_model=M("Menu");
                $auth_rule_model=M("AuthRule");
             if($role==$roleid)
             {  
                   
                if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {

                   
                 
                   $result =  $this->auth_access_model->where(array("role_id"=>$roleid,'type'=>'admin_url'))->save(array("status"=>'2'));

                  
                    foreach ($_POST['menuid'] as $menuid) {
                      
                    $menu=$menu_model->where(array("id"=>$menuid))->field("app,model,action")->find();
                    if($menu){
                        $app=$menu['app'];
                        $model=$menu['model'];
                        $action=$menu['action'];
                        $name=strtolower("$app/$model/$action");
                        $this->auth_access_model->where(array("role_id"=>$roleid,"rule_name"=>$name,'type'=>'admin_url'))->save(array("status"=>1));
                    }
                  }
                   $this->success("授权成功！", U("AdminRole/index"));
                   die();  
                }else{
                   $result =  $this->auth_access_model->where(array("role_id"=>$roleid,'type'=>'admin_url'))->save(array("status"=>2));
                   $this->error("没有接收到数据，执行清除授权成功！");
                   die();
                }
          

             }

            if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {
                
               

                $this->auth_access_model->where(array("role_id"=>$roleid,'type'=>'admin_url'))->delete();
                foreach ($_POST['menuid'] as $menuid) {
                    $menu=$menu_model->where(array("id"=>$menuid))->field("app,model,action")->find();
                    if($menu){
                        $app=$menu['app'];
                        $model=$menu['model'];
                        $action=$menu['action'];
                        $name=strtolower("$app/$model/$action");
                        $this->auth_access_model->add(array("role_id"=>$roleid,"rule_name"=>$name,'type'=>'admin_url'));
                    }
                }

    
                $this->success("授权成功！", U("AdminRole/index"));
            }else{
                //当没有数据时，清除当前角色授权
                $this->auth_access_model->where(array("role_id" => $roleid,'type'=>'admin_url'))->delete();
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        }
    }
    public function school_post() {
        
     $user_id = $_SESSION['ADMIN_ID'];
     $role = M("role_user")->where("user_id = $user_id")->getField("role_id");

     $isonelevelrole = M("role")->where("id = $role")->getField("isonelevelrole");
       if($isonelevelrole!=1 && $role!=1)
       {
        $this->error("不是超级管理员和一级账户不能授权!");
       }
        $this->roleschool = D("role_school");

        $school_model=M("school");
                $auth_rule_model=M("AuthRule");

        if (IS_POST) {
            $roleid = intval(I("post.roleid"));
            if(!$roleid){
                $this->error("需要授权的角色不存在！");
            }

             //如果是登录角色给自己选择功能则执行下面
//             if($role==$roleid)
//             {
//
//                if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {
//                $result = $this->roleschool->where(array("roleid"=>$roleid))->select();
//
//
//                   $aa =  $this->roleschool->where(array("roleid"=>$roleid))->save(array("status"=>'2'));
//                   dump($aa);
//
//
//                    foreach ($_POST['menuid'] as $schoolid) {
//                           if(!empty($schoolid))
//                            {
//
//                                 $school=$school_model->where(array("schoolid"=>$schoolid))->field("province,city,area")->find();
//                                 var_dump($school);
//
//                            if($school){
//                                $province=$school['province'];
//                                $city=$school['city'];
//                                $area=$school['area'];
//                                // $name=strtolower("$app/$model/$action");
//$this->roleschool->where(array("roleid"=>$roleid,'schoolid'=>$schoolid))->save(array("status"=>'1'));
//
//                            }
//                      }
//                  }
//                   $this->success("授权学校成功！", U("AdminRole/index"));
//                   die();
//                }else{
//                  $this->roleschool->where(array("roleid"=>$roleid))->save(array("status"=>'2'));
//                   $this->error("没有接收到学校数据，执行清除授权成功！");
//                   die();
//                }
//
//
//             }




            if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {
                
             
                $this->roleschool->where(array("roleid"=>$roleid))->delete();
                foreach ($_POST['menuid'] as $schoolid) {
                    if(!empty($schoolid))
                    {
                        
                         $school=$school_model->where(array("schoolid"=>$schoolid))->field("province,city,area")->find();
                   
                    if($school){
                        $province=$school['province'];
                        
                        $city=$school['city'];
                        $area=$school['area'];
                        // $name=strtolower("$app/$model/$action");
                      $re =   $this->roleschool->add(array("roleid"=>$roleid,"province"=>$province,'city'=>$city,'area'=>$area,'schoolid'=>$schoolid));
                      
                    }
              }
                    
                    // $school=$school_model->where(array("schoolid"=>$schoolid))->field("province,city,area")->find();
                    // var_dump($school);
                    // if($school){
                    //     $province=$menu['province'];
                    //     $city=$menu['city'];
                    //     $area=$menu['area'];
                    //     // $name=strtolower("$app/$model/$action");
                    //   $re =   $this->roleschool->add(array("roleid"=>$roleid,"province"=>$province,'city'=>$city,'area'=>$area,'schoolid'=>$schoolid));
                    //   var_dump($re);
                    // }
                }
    
                $this->success("授权成功！", U("AdminRole/index"));
            }else{
                //当没有数据时，清除当前角色授权
                $this->roleschool->where(array("roleid" => $roleid))->delete();
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        }
    }


  /**
     * 学校设置
     */

      public function roleschool() {
        $this->auth_access_model = D("Common/AuthAccess");
        $this->roleschool = D("role_school");

        //区分是否是代理商
        $categoryid = I("categoryid");

        //区分是否是一级账号
        $isonelevelrole = I("isonelevelrole");




       //角色ID
        $roleid = intval(I("get.id"));
   
        if (!$roleid) {
            $this->error("参数错误！");
        }
        import("Tree");
        $menu = new \Tree();
       // var_dump($menu);
        $menu->icon = array('│ ', '├─ ', '└─ ');
        $menu->nbsp = '&nbsp;&nbsp;&nbsp;';

          //传递两个参数

      //拿出所有的学校

      $result = R("AdminUtils/roleschool",array($roleid,$isonelevelrole,$categoryid));
//      dump($result);
   

      $user_id = $_SESSION['ADMIN_ID'];
          $role = M('role_user')->where("user_id = $user_id")->field('role_id')->find();
      if($role['role_id']!=1)
      {
          $chekcedbox = '<input type=\'checkbox\' name=\'menuid[]\' value=\'$schoolid\' level=\'$level\' $checked onclick=\'javascript:checknode(this);\'>';
      }

      $at_role = M("role")->where(array("id"=>$role['role_id']))->find();


      $level = access_level($role['role_id']);
//      dump($level);

      

     $priv_data=$this->roleschool->where(array("roleid"=>$role['role_id']))->getField("schoolid",true);

//echo "<hr>";
     $priv_data_role=$this->roleschool->where(array("roleid"=>$roleid,'status'=>1))->getField("schoolid",true);



if($level!=1 && $role['role_id']!=1)
{


      $aa = array();

        foreach ($result as $key => $value) {
           $schoolid = $value['schoolid'];

           if(!empty($schoolid)){
               // echo "aaa";

             if($priv_data){
                 foreach ($priv_data as $val) {
                    if($schoolid==$val)
                    {

                        array_push($aa,$result[$key]);
                    }
                 }
               }

           }else{
            array_push($aa,$result[$key]);
           }



        }
      $result = $aa;

   }





      foreach ($result as $m){
         $newmenus[$m['id']]=$m;
        }
     foreach ($result as $n => $t) {
   
         $result[$n]['checked'] = ($this->school_is_checked($t, $roleid, $priv_data_role)) ? ' checked' : '';
         $result[$n]['level'] = $this->school_get_level($t['id'], $newmenus);
         $result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-' . $t['parentid'] . '"' : '';
        }
     $menu->init($result);
    // var_dump($result);
 $str = "<tr id='node-\$id' \$parentid_node>
                       <td style='padding-left:30px;'>\$spacer$chekcedbox\$name</td>
                    </tr>";
        $categorys = $menu->get_tree(0, $str);

       
    // var_dump($result);
        
        $this->assign("categorys", $categorys);
        //var_dump($categorys);
   
        $this->assign("roleid", $roleid);
        // var_dump($roleid);
        $this->display();
    }


    /**
     *  检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param int $roleid 需要检查的角色ID
     */
    private function _is_checked($menu, $roleid, $priv_data) {
        
        $app=$menu['app'];
        $model=$menu['model'];
        $action=$menu['action'];
        $name=strtolower("$app/$model/$action");
        if($priv_data){
            if (in_array($name, $priv_data)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
        
    }

 /**
     *  检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param int $roleid 需要检查的角色ID
     */
    private function school_is_checked($menu, $roleid, $priv_data) {
        
        $schoolid=$menu['schoolid'];
       
        // $name=strtolower("$app/$model/$action");
        if($priv_data){
            if (in_array($schoolid, $priv_data)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
        
    }


    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function _get_level($id, $array = array(), $i = 0) {
        
            if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
                return  $i;
            }else{
                $i++;
                return $this->_get_level($array[$id]['parentid'],$array,$i);
            }
                
    }

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function school_get_level($id, $array = array(), $i = 0) {
            // var_dump($array);
            // exit();
            if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
                return  $i;
            }else{
                $i++;
                return $this->school_get_level($array[$id]['parentid'],$array,$i);
            }
                
    } 
    
    
    public function member(){
        //TODO 添加角色成员管理

        $this->display();
    }
}

