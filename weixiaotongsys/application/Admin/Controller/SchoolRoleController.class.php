<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SchoolRoleController extends AdminbaseController {

    protected $nav_model;
    protected $navcat_model;
    protected $role_model, $auth_access_model;

    function _initialize() {
        parent::_initialize();
        $this->nav_model = D("Common/Nav");
        $this->navcat_model =D("Common/NavCat");
        $this->role_model = D("Common/Role");
        $this->only_code = strtolower(MODULE_NAME).'_'.strtolower(CONTROLLER_NAME);
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
   
       $data = M("school_duty")->order(array("id" => "ASC"))->where("schoolid = $schoolid")->select();
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
    		if (M('school_duty')->create()) {
    			if ($id = M('school_duty')->add()!==false) {
    			    //M('role_user')->add(array('role_id'=>$id, 'user_id'=>));
    				$this->success("添加角色成功",U("SchoolAppRole/index"));
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
        $data = M('school_duty')->where(array("id" => $id))->find();
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
    			if (M('school_duty')->save($data)!==false) {
    				$this->success("修改成功！", U('SchoolRole/index'));
    			} else {
    				$this->error("修改失败！");
    			}
    		} else {
    			$this->error(M('school_duty')->getError());
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
     * 角色授权 TODO只有四层 后期可以优化
     *
     */
    public function authorize() {
         $this->school_access_model = D("Common/school_authaccess");
        $roleid = intval(I("get.id"));
        $province = I("get.province");
        $citys = intval(I("get.citys"));
        $isdefault = I("isdefault");
        $new_message_type = intval(I("get.new_message_type"));
        $schoolid = intval(I("get.schoolid"));

        if (!$roleid) {
          $this->error("参数错误！");
        }

        import("Tree");
        $menu = new \Tree();

        $menu->icon = array('│ ', '├─ ', '└─ ');
        $menu->nbsp = '&nbsp;&nbsp;&nbsp;';

        $array = array();
        $priv_data=$this->school_access_model->where("role_id=$roleid")->getField("rule_name",true);//获取权限表数据
      
        $navs = $this->navcat_model->field('navcid, name')->select();
        $nav = $this->nav_model->field('id, parentid, name, cid, app, model, action')->select();
     
        $newNav = $this->make_tree($nav,$pk='id',$pid='parentid',$child='_child',$root=0,$priv_data);
//        dump($newNav);
   
        foreach ($navs as $k=>$v){
          
            $array[$k]['navcid'] = $v['navcid'];
            $array[$k]['name'] = $v['name'];
            $array[$k]['level'] = 0;
            $count = 0;
            foreach ($newNav as $ks => $vs){
                // var_dump($newNav);
                // exit();
                if ($v['navcid'] == $vs['cid']){
                    $array[$k]['child'][$count]['id'] = $vs['id'];
                    $array[$k]['child'][$count]['parentid'] = $vs['parentid'];
                    $array[$k]['child'][$count]['name'] = $vs['name'];
                    $array[$k]['child'][$count]['cid'] = $vs['cid'];
                    $array[$k]['child'][$count]['level'] = 1;
                    $res = $this->_is_checked($vs, $priv_data);
                    if ($res){
                        $array[$k]['child'][$count]['is_checked'] = true;
                    }else{
                        $array[$k]['child'][$count]['is_checked'] = false;
                    }
                    if (isset($vs['_child'])){
                        $array[$k]['child'][$count]['_child'] = $vs['_child'];
                    }
                    $count++;
                }
            }
        }


//        dump($array);
        $html = '';
        foreach ($array as $k=>$v){
       
            $html.="<tr><td style='padding-left:30px;'>&nbsp;&nbsp;&nbsp;";
            if($count == $k+1){

                $html .= '└─';
            }else {
                $html .= '├─';
            }
            //判断是否存在子或孙选中
            foreach($v['child'] as $ks=>$vs){
                if ($vs['is_checked']){
                    $flag = true;
                }else{
                    $flag = false;
                }
                foreach($vs['_child'] as $key=>$item){
                    if ($item['is_checked']){
                        $flag = true;
                    }else{
                        $flag = false;
                    }
                }
            }
            if ($flag){
                $html .= "<input checked type='checkbox'  level='".$v['level']."' onclick='javascript:checknode(this);'>".$v['name']."</td>";
            }else{
                $html .= "<input type='checkbox'  level='".$v['level']."' onclick='javascript:checknode(this);'>".$v['name']."</td>";
            }
            //$html .= "<input type='checkbox'  level='".$v['level']."' onclick='javascript:checknode(this);'>".$v['name']."</td>";
            $counts = count($v['child']);
//            dump($counts);
            foreach($v['child'] as $ks=>$vs){

                $html .="<tr><td style='padding-left:60px;'>&nbsp;&nbsp;&nbsp;";
                if($counts == $ks+1){
                    $html .= '└─';
                }else {
                    $html .= '├─';
                }
                if ($vs['is_checked']){
                    $html .= "<input checked type='checkbox' name='menuid[]' value='".$vs['id']."' level='".($vs['level'])."'  onclick='javascript:checknode(this);'>".$vs['name']."</td>";
                }else{
                    $html .= "<input type='checkbox' name='menuid[]' value='".$vs['id']."' level='".($vs['level'])."'  onclick='javascript:checknode(this);'>".$vs['name']."</td>";
                }
                $countss = count($vs['_child']);
//                dump($countss);
                foreach($vs['_child'] as $key=>$item){
                    $html .="<tr><td style='padding-left:90px;'>&nbsp;&nbsp;&nbsp;";
                    if($countss == $key+1){
                        $html .= '└─';
                    }else {
                        $html .= '├─';
                    }
                    if ($item['is_checked']){
                        $html .= "<input checked type='checkbox' name='menuid[]' value='".$item['id']."' level='".($vs['level']+1)."'  onclick='javascript:checknode(this);'>".$item['name']."</td></tr>";
                    }else{
                        $html .= "<input type='checkbox' name='menuid[]' value='".$item['id']."' level='".($vs['level']+1)."'  onclick='javascript:checknode(this);'>".$item['name']."</td></tr>";
                    }
                    $countsss = count($item['_child']);

                    foreach ($item['_child'] as $kes=> $ves)
                    {
//                      dump($ves['level']);

                        $html .="<tr><td style='padding-left:120px;'>&nbsp;&nbsp;&nbsp;";
                        if($countsss == $kes+1){
                            $html .= '└─';
                        }else {
                            $html .= '├─';
                        }
                        if ($ves['is_checked']){
                            $html .= "<input checked type='checkbox' name='menuid[]' value='".$ves['id']."' level='".($ves['level']+3)."'  onclick='javascript:checknode(this);'>".$ves['name']."</td></tr>";
                        }else{
                            $html .= "<input type='checkbox' name='menuid[]' value='".$ves['id']."' level='".($ves['level']+3)."'  onclick='javascript:checknode(this);'>".$ves['name']."</td></tr>";
                        }
                    }
                }
                $html.="</tr>";
            }
            $html .= "</tr>";
        }


//       dump(get_condition_cache());
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
    	$this->school_access_model = D("Common/school_authaccess");
    	if (IS_POST) {
    		$roleid = intval(I("post.roleid"));
        $province =I("province");
        $citys =I("citys");
        $new_message_type =I("new_message_type");
        $schoolid =I("schoolid");
        



    		//dump($_POST);exit;
    		if(!$roleid){
    			$this->error("需要授权的角色不存在！");
    		}
    		if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {
          
          
          $menu_model=M("nav");

    			$this->school_access_model->where(array("role_id"=>$roleid,'type'=>'teacher_url',"schoolid"=>$schoolid))->delete();
    			foreach ($_POST['menuid'] as $menuid) {
    				$menu=$menu_model->where(array("id"=>$menuid))->field("app,model,action")->find();
    				if($menu){
    					$app=$menu['app'];
    					$model=$menu['model'];
    					$action=$menu['action'];
    					$name=strtolower("$app/$model/$action");
    					$this->school_access_model->add(array("role_id"=>$roleid,"rule_name"=>$name,'schoolid'=>$schoolid,'type'=>'teacher_url'));
    				}
    			}

    			$this->success("授权成功！", U("SchoolRole/index",array("province"=>$province,"city"=>$citys,"message_type"=>$new_message_type,'schoolid'=>$schoolid)));
    		}else{
    			//当没有数据时，清除当前角色授权
    			$this->school_access_model->where(array("role_id" => $roleid,'type'=>'teacher_url',"schoolid"=>$schoolid))->delete();
    			$this->error("没有接收到数据，执行清除授权成功！");
    		}
    	}
    }


    






        /**
     *  检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param int $roleid 需要检查的角色ID
     */
    private function _is_checked($menu, $priv_data) {
      
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