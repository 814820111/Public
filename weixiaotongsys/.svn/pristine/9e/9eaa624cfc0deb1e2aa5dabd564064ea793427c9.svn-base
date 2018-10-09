<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ParentAppRoleController extends AdminbaseController {

    // protected $nav_model;
    // protected $navcat_model;
    // protected $role_model, $auth_access_model;

    function _initialize() {
        parent::_initialize();
        $this->nav_app_model = D("Common/NavApp");
        $this->only_code = strtolower(MODULE_NAME).'_'.strtolower(CONTROLLER_NAME);
        // $this->navcat_model =D("Common/NavCat");
        // $this->role_model = D("Common/Role");
    }
    /**
     * 角色管理，有add添加，edit编辑，delete删除
     */

        public function index() {

        $schoolid = I("schoolid");
       

            $Province=role_admin();
          $province = I("province");
  
        $citys = I('citys');
        $message_type = I('message_type');
      if($province && $citys && $message_type && $schoolid)
       {
                //写入缓存
         write_condition($province,$citys,$message_type,$schoolid,$this->only_code);

      }

      if($schoolid)
      {
        $this->assign("schoolid",$schoolid);
      }


       if($province)
       {
        $this->assign("province",$province);
       }
      
       if($citys){
        $this->assign("citys",$citys);
       }
       if($message_type)
       {

        $this->assign("new_message_type",$message_type);
       }
   if($schoolid)
   {
 
     $data = M("school_duty_parent")->order(array("id" => "ASC"))->where("schoolid = $schoolid")->select();
   }else{
     
   }
         


        
        $this->assign("Province",$Province);
        $this->assign("roles", $data);
        $this->display();
    }







      /**
     * 添加角色
     */
    public function roleadd() {

        $schoolid = I("schoolid");
        if(!$schoolid)
        {
            $this->error("请先搜索要添加的学校!");
        }
        $this->assign("only_code",$this->only_code);
        $this->assign("schoolid",$schoolid);
        $this->display();
    }
    
    /**
     * 添加角色
     */
    public function roleadd_post() {
    	if (IS_POST) {
    		if (M('school_duty_parent')->create()) {
    			if ($id = M('school_duty_parent')->add()!==false) {
    			    //M('role_user')->add(array('role_id'=>$id, 'user_id'=>));
    				$this->success("添加角色成功",U("ParentAppRole/index"));
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
        $data = M('school_duty_parent')->where(array("id" => $id))->find();
        if (!$data) {
          $this->error("该角色不存在！");
        }
        $this->assign("only_code",$this->only_code);
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
    		$data = M('school_duty')->create();
    		if ($data) {
    			if (M('school_duty_parent')->save($data)!==false) {
    				$this->success("修改成功！", U('ParentAppRole/index'));
    			} else {
    				$this->error("修改失败！");
    			}
    		} else {
    			$this->error(M('school_duty_parent')->getError());
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
        $this->school_access_app = D("Common/school_authaccess_app");
        $roleid = intval(I("get.id"));
        $province = I("get.province");
        $citys = intval(I("get.citys"));
        $isdefault = I("isdefault");
        $new_message_type = intval(I("get.new_message_type"));;

        $schoolid = intval(I("get.schoolid"));
       
        if (!$roleid) {
        	$this->error("参数错误！");
        }

        import("Tree");
        $menu = new \Tree();



        $array = array();

        $priv_data=$this->school_access_app->where("role_id=$roleid and appcatid = 1 and type='parent_url'")->field("status,rule_name")->select();//获取权限表数据
       
        // $navs = $this->navcat_model->field('navcid, name')->select();
        $result = $this->nav_app_model->field('id, parentid, name, appcatid, app, model, action,ischecked')->where("appcatid = 1 and location!=0")->select();

          //是否是必选中
        foreach ($result as $key => &$val) {  
         $app=$val['app'];
        $model=$val['model'];
        $action=$val['action'];
        $name=strtolower("$app/$model/$action");
       foreach ($priv_data as  $v) {
          if($name==$v['rule_name'])
          {
            $val['status'] = $v['status'];
          }
       }
    }   

         //是否选中
      foreach ($priv_data as $key => $v) {  
       $check[$key] = $v['rule_name'];  
    }   
      
        // exit();
 $html = '';
        $html.="<td><input  type='checkbox'  style='vertical-align: -1px;' name='checkalls' onclick='javascript:checkall();' />全选</td>";
        foreach ($result as $key => $value) {

    
         $html.="<tr><td style='padding-left:30px;'>&nbsp;&nbsp;&nbsp;";
         
         $required = $this->_is_required($value['status']);

         if($required)
         {
            $res = "disabled=disabled";
          
         }else{
            $res = "";
            // $color="";
         }

        $checked = $this->_is_checked($value,$roleid,$check);

        if($checked)
        {
          
         $html.="<input  type='checkbox'  ".$res." style='vertical-align: -1px;' checked name='menuid[]' value='".$value['id']."'  onclick='javascript:checknode(this);'>".$value['name']."</td>";
        }else{
         $html.="<input  type='checkbox' ".$res." style='vertical-align: -1px;' name='menuid[]' value='".$value['id']."'  onclick='javascript:checknode(this);'>".$value['name']."</td>";
        }
         
         

         $html .= "</tr>";
        }


        $this->assign("only_code",$this->only_code);
        $this->assign("categorys", $html);
        $this->assign("isdefault",$isdefault);
        $this->assign("schoolid",$schoolid);
        $this->assign("province",$province);
        $this->assign("citys",$citys);
        $this->assign("new_message_type",$new_message_type);    
        $this->assign("roleid", $roleid);
        // var_dump($roleid);
        $this->display();
    }

    /**
     * 角色授权
     */
    public function authorize_post() {
    	$this->school_access_app = D("Common/school_authaccess_app");
    	if (IS_POST) {
    		$roleid = intval(I("post.roleid"));
        $province =I("province");
        $citys =I("citys");
        $new_message_type =I("new_message_type");
        $schoolid =I("schoolid");
        
            $isdefault = I("isdefault");

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






    		//dump($_POST);exit;
    		if(!$roleid){
    			$this->error("需要授权的角色不存在！");
    		}
    		if (is_array($menuid) && count($menuid)>0) {

    			$this->school_access_app->where(array("role_id"=>$roleid,'type'=>'parent_url',"appcatid"=>"1"))->delete();
    			
    			foreach ($menuid as $key=>$status) {
    				$menu=$this->nav_app_model->where(array("id"=>$key))->field("app,model,action")->find();
    				if($menu){
                if($isdefault==2 || $sta)
               {
                $status = 2;
                }
    					$app=$menu['app'];
    					$model=$menu['model'];
    					$action=$menu['action'];
    					$name=strtolower("$app/$model/$action");
    					$this->school_access_app->add(array("role_id"=>$roleid,"rule_name"=>$name,'schoolid'=>$schoolid,'type'=>'parent_url','appcatid'=>1,"status"=>$status));
    				}
    			}

    			$this->success("授权成功！", U("ParentAppRole/index",array("province"=>$province,"city"=>$citys,"message_type"=>$new_message_type,'schoolid'=>$schoolid)));
    		}else{
    			//当没有数据时，清除当前角色授权
    			$this->school_access_app->where(array("role_id" => $roleid,'type'=>'parent_url',"appcatid"=>"1"))->delete();
    			$this->error("没有接收到数据，执行清除授权成功！");
    		}
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
   
 

 
	 if($status==1)
	 {
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