<?php
/* * 
 * 系统权限配置，用户角色管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class TeacherRolesController extends AdminbaseController {

    protected $nav_model;
    protected $navcat_model;
    protected $role_model, $auth_access_model;

    function _initialize() {
        parent::_initialize();
        $this->nav_model = D("Common/Nav");
        $this->navcat_model =D("Common/NavCat");
        $this->role_model = D("Common/Role");
        $this->auth_access_model = D("Common/AuthAccess");
        $this->school_duty_model =D("Common/school_duty");
        $this->school_authaccess_model = D("Common/school_authaccess");
    }

    /**
     * 角色管理，有add添加，edit编辑，delete删除
     */
    public function index()
    {




////        //拉取出学校角色表
//        $school_duty = M("school_duty")->select();
//
//       // 删除学校权限表
//      M("school_authaccess")->where("1=1")->delete();
////
//        foreach($school_duty as $addvalue)
//        {
//
//          $duty_id = $addvalue['duty_id'];
//          $role_id = $addvalue['id'];
//          $schoolid = $addvalue['schoolid'];
//
//          //查询出duty_id对应的权限
//          $authaccess = M("auth_access")->where(array("role_id"=>$duty_id,"type"=>"teacher_url"))->select();
//           if(!$authaccess)
//           {
//               continue;
//           }
//          foreach ($authaccess as $value)
//          {
//              $data['role_id'] =$role_id;
//              $data['schoolid'] =$schoolid;
//              $data['rule_name'] = $value['rule_name'];
//              $data['type'] = $value['type'];
//              M("school_authaccess")->add($data);
//          }
//
//
//          M("school_authaccess")->add($alldata);
//
//
//        }
//          exit();
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
    				$this->success("修改成功！", U('TeacherRoles/index'));
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
        $this->auth_access_model = D("Common/AuthAccess");
        $roleid = intval(I("get.id"));
        if (!$roleid) {
        	$this->error("参数错误！");
        }

        //获取职责名称
        $role_name = M("duty")->where("id = $roleid")->getField("name");

        import("Tree");
        $menu = new \Tree();

        $menu->icon = array('│ ', '├─ ', '└─ ');
        $menu->nbsp = '&nbsp;&nbsp;&nbsp;';

        $array = array();
        $priv_data=$this->auth_access_model->where("role_id=$roleid")->getField("rule_name",true);//获取权限表数据
        //dump($priv_data);exit;
        $navs = $this->navcat_model->field('navcid, name')->select();
        $nav = $this->nav_model->field('id, parentid, name, cid, app, model, action')->select();
        $newNav = $this->make_tree($nav,$pk='id',$pid='parentid',$child='_child',$root=0,$priv_data);
   
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
        // exit();
        //$result = $this->initMenu();
        //$result = $this->nav_model->select();
        //dump($array);exit;
   
        // exit();


//        $newmenus=array();

//        foreach ($result as $m){
//        	$newmenus[$m['id']]=$m;
//        }
//        foreach ($result as $n => $t) {
//        	$result[$n]['checked'] = ($this->_is_checked($t, $roleid, $priv_data)) ? ' checked' : '';
//        	$result[$n]['level'] = $this->_get_level($t['id'], $newmenus);
//        	$result[$n]['parentid_node'] = ($t['parentid']) ? ' class="child-of-node-' . $t['parentid'] . '"' : '';
//        }
//        $str = "<tr id='node-\$id' \$parentid_node>
//                       <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuid[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
//	    			</tr>";
//        //dump($result);
//        //exit;
//        $menu->init($result);
//        //$categorys = $menu->get_tree(0, $str);
//        $categorys = $menu->get_tree(0, $str);

        //dump($array);
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

    	if (IS_POST) {
            $is_all = intval(I("post.is_all"));

    		$roleid = intval(I("post.roleid"));
//    		dump($roleid);
    		//dump($_POST);exit;
    		if(!$roleid){
    			$this->error("需要授权的角色不存在！");
    		}
    		if (is_array($_POST['menuid']) && count($_POST['menuid'])>0) {


    			$menu_model=M("nav");
    			$auth_rule_model=M("AuthRule");



    			foreach ($_POST['menuid'] as $menuid) {
    				$menu=$menu_model->where(array("id"=>$menuid))->field("app,model,action")->find();
    				if($menu){
    					$app=$menu['app'];
    					$model=$menu['model'];
    					$action=$menu['action'];
    					$name=strtolower("$app/$model/$action");
                        $auth_array[] = $name;
                        $data['role_id'] = $roleid;
    					$data['rule_name'] =$name;
    					$data['type'] = "teacher_url";
    					$alldata[] = $data;
    				}
    			}
                //如果需要同步学校
                 if($is_all)
                {
                   $role_auth =  $this->auth_access_model->where(array("role_id"=>$roleid,'type'=>'teacher_url'))->field("rule_name")->select();

                    $this->add_syncschool_auth($roleid,$auth_array,$role_auth);
                }

    			//清空原有权限设置
                $this->auth_access_model->where(array("role_id"=>$roleid,'type'=>'teacher_url'))->delete();
                $this->auth_access_model->addAll($alldata);

    			$this->success("授权成功！", U("TeacherRoles/index"));
    		}else{
    			//当没有数据时，清除当前角色授权
    			$this->auth_access_model->where(array("role_id" => $roleid,'type'=>'teacher_url'))->delete();
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

        //获取要删除的功能
        foreach ($role_auth as $value)
        {
            if(!in_array($value['rule_name'],$auth_array))
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
            if (!in_array($val_del, $dimension)) {
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


        //查询该角色下的所有权限

        //拉取出所有学校的职责
        $school_duty =$this->school_duty_model->where("duty_id = $roleid")->field("id,schoolid")->select();

        foreach($school_duty as $auth)
        {


            $school_roleid = $auth['id'];
            $schoolid = $auth['schoolid'];
            //获取该学校的职责权限
            $school_auth  = $this->school_authaccess_model->where("role_id= $school_roleid and type = 'teacher_url'")->field("rule_name")->select();


            if($arr_add) {
                //转换为一维数组
                $dimension = $this->get_dimension($school_auth);
                foreach ($arr_add as $value) {
                    if (!in_array($value, $dimension)) {
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
                    $data['rule_name'] = $rule_name;
                    $data['type'] = 'teacher_url';

                    $alldata[]=$data;
                    unset($data);
                }
                $result =   $this->school_authaccess_model->addAll($alldata);
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
                    $where_del['type'] = 'teacher_url';

                    $this->school_authaccess_model->where($where_del)->delete();
            }




        }


    }





    private function get_two_dimension($array)
    {

        $newarray = array();
        foreach($array as $a)
        {
            $newarray[] = $a;
        }
    }


    private function get_dimension($array)
    {

        foreach($array as $k => $v){
            $ids[] = $v['rule_name'];

        }
        return $ids;

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

    /**
     * 获取菜单深度
     * @param $id
     * @param $array
     * @param $i
     */
    protected function _get_level($id, $array = array(), $i = 0) {

        //dump($array);
        	if ($array[$id]['parentid']==0 || empty($array[$array[$id]['parentid']]) || $array[$id]['parentid']==$id){
        		return  $i;
        	}else{
        		$i++;
        		return $this->_get_level($array[$id]['parentid'],$array,$i);
        	}
        		
    }
    
    
    public function member(){
    	//TODO 添加角色成员管理

        $this->display();
    }

}

