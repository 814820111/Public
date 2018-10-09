<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class AppRoleController extends AdminbaseController {

    // protected $nav_model;
    // protected $navcat_model;
    // protected $role_model, $auth_access_model;

    function _initialize() {
        parent::_initialize();
        $this->nav_app_model = D("Common/NavApp");
        $this->auth_access_app = D("Common/auth_access_app");
        $this->school_authaccess_app = D("Common/school_authaccess_app");
        $this->school_duty_model =D("Common/school_duty");
        // $this->navcat_model =D("Common/NavCat");
        // $this->role_model = D("Common/Role");
    }
    /**
     * 角色管理，有add添加，edit编辑，delete删除
     */

        public function index() {

        $data = M("duty")->order(array("id" => "desc"))->select();
        $this->assign("roles", $data);
        $this->display();
    }
      /**
     * 添加角色
     */
    public function roleadd() {
        $this->display();
    }
    
    /**
     * 添加角色
     */
    public function roleadd_post() {
    	if (IS_POST) {
    		if (M('duty')->create()) {
    			if ($id = M('duty')->add()!==false) {
    			    //M('role_user')->add(array('role_id'=>$id, 'user_id'=>));
    				$this->success("添加角色成功",U("TeacherRoles/index"));
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
        $count=M('duty_teacher')->where("duty_id=$id")->count();
        if($count){
        	$this->error("该角色已经有用户！");
        }else{
        	$status = M('duty')->delete($id);
        	if ($status!==false) {
        		$this->success("删除成功！", U('TeacherRoles/index'));
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
        if ($id == 0) {
            $id = intval(I("post.id"));
        }
        if ($id == 1) {
            $this->error("超级管理员角色不能被修改！");
        }
        $data = M('duty')->where(array("id" => $id))->find();
        if (!$data) {
          $this->error("该角色不存在！");
        }
        $this->assign("data", $data);
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
    		$data = M('duty')->create();
    		if ($data) {
    			if (M('duty')->save($data)!==false) {
    				$this->success("修改成功！", U('AppRole/index'));
    			} else {
    				$this->error("修改失败！");
    			}
    		} else {
    			$this->error(M('duty')->getError());
    		}
    	}

    }

      public function getTree($arr, $pid = 0, $level = 1){
        static $tree = array();
        foreach ($arr as $v){
            if ($v['parentid'] == $pid){
                $v['level'] = $level;
                $tree[] = $v;
                $this->getTree($arr, $v['id'], $level++);
            }
        }
        return $tree;

    }

    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pk 自增字段（栏目id）
     * @param string $pid parent标记字段
     * @return array
     * @author dqs <1696232133@qq.com>
     */
    function make_tree($list,$pk='id',$pid='parentid',$child='_child',$root=0, $priv_data){
        $tree=array();
        $packData=array();
        foreach ($list as  $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key =>$val){
            if($val[$pid]==$root){//代表跟节点
                $tree[]=& $packData[$key];
            }else{
                //找到其父类
                $res = $this->_is_checked($val, $priv_data);
                if ($res){
                    $packData[$key]['is_checked'] = true;
                }else{
                    $packData[$key]['is_checked'] = false;
                }
                $packData[$val[$pid]][$child][]=& $packData[$key];
            }
        }
        return $tree;
    }

    /**
     * 角色授权
     */
    public function authorize() {
//        $this->auth_access_app = D("Common/auth_access_app");
        $roleid = intval(I("get.id"));

        if (!$roleid) {
        	$this->error("参数错误！");
        }

        import("Tree");
        $menu = new \Tree();

        //获取职责名称
        $role_name = M("duty")->where("id = $roleid")->getField("name");

    

        $array = array();
        $priv_data=$this->auth_access_app->where("role_id=$roleid and appcatid = 2")->field("status,rule_name")->select();//获取权限表数据

        //是否选中
      foreach ($priv_data as $key => $v) {  
       $check[$key] = $v['rule_name'];  
    }  
  


        // $navs = $this->navcat_model->field('navcid, name')->select();
        $result = $this->nav_app_model->field('id, parentid, name, appcatid, app, model, action,ischecked')->where("appcatid = 2 and location!=0")->select();
  ;
     //是否是必选中
        foreach ($result as $key => &$val) {  
         $app=$val['app'];
        $model=$val['model'];
        $action=$val['action'];
        $name=strtolower("$app/$model/$action");
       foreach ($priv_data as  $va) {
          if($name==$va['rule_name'])
          {
            $val['status'] = $va['status'];
          }
       }
    }


 $html = '';
   $html.="<tr><th style=' text-align: center;     font-size: 16px;' colspan=3 aligin=>教师端</th></tr>";
   $html.="<tr><th style='    padding-right: 92px;'>应用名称</th><th>是否必选</th></tr>";
        foreach ($result as $key => $value) {
   
       
         $html.="<tr><td style='padding-left:30px;'>&nbsp;&nbsp;&nbsp;";
         
         $required = $this->_is_required($value['status']);

         if($required)
         {
            $res = "<input type=checkbox checked name='status[]' value=".$value['id']." style='    vertical-align: -1px;'>";
         }else{
            $res = "<input type=checkbox  name='status[]' value=".$value['id']." style='    vertical-align: -1px;'>";
         }
        $checked = $this->_is_checked($value,$roleid,$check);

        if($checked)
        {

          
         $html.="<input  type='checkbox'   style='vertical-align: -1px;' checked name='menuid[]' value='".$value['id']."'  onclick='javascript:checknode(this);'>".$value['name']."&nbsp&nbsp&nbsp</td><td style='padding-left: 22px;'><span style='color:red'>".$res."</span></td>";
        }else{
         $html.="<input  type='checkbox' style='vertical-align: -1px;' name='menuid[]' value='".$value['id']."'  onclick='javascript:checknode(this);'>".$value['name']."&nbsp&nbsp</td><td style='padding-left: 22px;'><span style='color:red'>".$res."</span></td>";
        }
         
         

         $html .= "</tr>";
        }

     
        $this->assign("categorys", $html);

        $this->assign("role_name",$role_name);
        $this->assign("roleid", $roleid);
        // var_dump($roleid);
        $this->display();
    }

    /**
     * 角色授权
     */
    public function authorize_post() {

    	$this->auth_access_app = D("Common/auth_access_app");
    	if (IS_POST) {
    		$roleid = intval(I("post.roleid"));
            $is_all = intval(I("post.is_all"));

            $menuid = $_POST['menuid'];
            $status = $_POST['status'];
       


         foreach($menuid as $key => $value)
          {
              foreach ($status as $v2)
              {
              if ($value == $v2)
              {
                  unset($menuid[$key]);
                  $menuid[$value]=1;
                    break;
              }else{
               unset($menuid[$key]);
                  $menuid[$value]=2;
              }
              
            }
         
          }
          if(empty($status))
          {
            $menuid = array_flip($menuid);

            $sta = 2;
          }

    		if(!$roleid){
    			$this->error("需要授权的角色不存在！");
    		}
    		if (is_array($menuid) && count($menuid)>0) {

    			foreach ($menuid as $key => $status) {
    				$menu=$this->nav_app_model->where(array("id"=>$key))->field("app,model,action")->find();
    				if($menu){
                      if($sta)
                      {
                        $status = 2;
                      }
    					$app=$menu['app'];
    					$model=$menu['model'];
    					$action=$menu['action'];
    					$name=strtolower("$app/$model/$action");
                        $com_arr['rule_name'] = $name;
                        $com_arr['status'] = $status;
    					$data['role_id'] = $roleid;
    					$data['rule_name'] = $name;
    					$data['type'] = 'app_url';
    					$data['status'] = $status;
    					$data['appcatid'] = 2;
                        $auth_array[] =$com_arr;
                        $alldata[] = $data;
                        unset($com_arr);
                        unset($data);
//    					$this->auth_access_app->add(array("role_id"=>$roleid,"rule_name"=>$name,'type'=>'app_url','appcatid'=>2,"status"=>$status));
    				}
    			}


                if($is_all)
                {
                    $role_auth =  $this->auth_access_app->where(array("role_id"=>$roleid,'type'=>'app_url',"appcatid"=>"2"))->field("rule_name")->select();


                    $this->add_syncschool_auth($roleid,$auth_array,$role_auth);
                }


                $this->auth_access_app->where(array("role_id"=>$roleid,'type'=>'app_url',"appcatid"=>"2"))->delete();
                $this->auth_access_app->addAll($alldata);

    			$this->success("授权成功！", U("AppRole/index"));
    		}else{
    			//当没有数据时，清除当前角色授权
    			$this->auth_access_app->where(array("role_id" => $roleid,'type'=>'app_url',"appcatid"=>"2"))->delete();
    			$this->error("没有接收到数据，执行清除授权成功！");
    		}
    	}
    }

    //获取要删除的功能
    private function  get_auth_del($auth_array,$role_auth)
    {
        if(!$auth_array && !$role_auth)
        {
            return false;
        }



        $arr_del= array();
        $dimension = $this->get_dimension($auth_array);
       

        //获取要删除的功能
        foreach ($role_auth as $value)
        {
            if(!in_array($value['rule_name'],$dimension))
            {

                array_push($arr_del,$value['rule_name']);
            }
        }

        return $arr_del;
    }

    //获取要增加的功能

    private function  get_auth_arr($auth_array,$role_auth)
    {

        if(!$auth_array && !$role_auth)
        {
            return false;
        }


        $arr_add = array();
        $dimension = $this->get_dimension($role_auth);



        foreach ($auth_array as $val_del)
        {

            if (!in_array($val_del['rule_name'], $dimension)) {

                array_push($arr_add, $val_del);
            }
        }

        return $arr_add;

    }

    private function add_syncschool_auth($roleid,$auth_array,$role_auth)
    {

        if(!$roleid)
        {
            $this->error("角色不存在！");
            exit();
        }

        //获取新增的功能
        $arr_add = $this->get_auth_arr($auth_array,$role_auth);



        //获取要删除的功能
        $arr_del= $this->get_auth_del($auth_array,$role_auth);





        //拉取出所有学校的职责
        $school_duty =$this->school_duty_model->where("duty_id = $roleid")->field("id,schoolid")->select();

        foreach($school_duty as $auth)
        {


            $school_roleid = $auth['id'];
            $schoolid = $auth['schoolid'];
            //获取该学校的职责权限
            $school_auth  = $this->school_authaccess_app->where("role_id= $school_roleid and appcatid = 2 and type = 'app_url'")->field("rule_name")->select();

            if($arr_add) {
                //转换为一维数组
                $dimension = $this->get_dimension($school_auth);

                foreach ($arr_add as $value) {
                    if (!in_array($value['rule_name'], $dimension)) {
                        $school_add[] = $value;
                    }
                }
            }




            if($school_add)
            {
                foreach($school_add as $rule_name)
                {
                    $data['role_id'] = $school_roleid;
                    $data['schoolid'] = $schoolid;
                    $data['rule_name'] = $rule_name['rule_name'];
                    $data['type'] = 'app_url';
                    $data['appcatid'] = 2;
                    $data['status'] = $rule_name['status'];

                    $alldata[]=$data;
                    unset($data);
                }
                $result =   $this->school_authaccess_app->addAll($alldata);
                unset($alldata);
                unset($school_add);
            }

            if($arr_del)
            {
                $del_rule = '';
                foreach ($arr_del as $rule_del) {
                    $del_rule = $rule_del.",".$del_rule;
                }
                $where_del['role_id'] = $school_roleid;
                $where_del['schoolid'] = $schoolid;
                $where_del['rule_name'] = array("in",rtrim($del_rule, ","));
                $where_del['type'] = 'app_url';
                $where_del['appcatid'] = 2;

                $this->school_authaccess_app->where($where_del)->delete();
            }




        }


    }




    private function get_dimension($array)
    {

        if($array){

            foreach($array as $k => $v){
                $ids[] = $v['rule_name'];

            }
           return $ids;
        }


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

            // foreach ($priv_data as $key => $value) {

            //    if(in_array(needle, haystack))
            //    {                           
            //     return true;       
               
            //    }else{
            //     return false;
            //    }
            // }
            if (in_array($name, $priv_data)) {
                return true;
            } else {
                return false;
            }
        }else{
            return false;
        }
        
    }

 
//检查是否是必选项

private function _is_required($status)
{
   
   // $array = array("1");
   // var_dump($array);
   //  var_dump($status);
     
 
        if($status==1){
          
            return true;
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


}