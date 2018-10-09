<?php
namespace Common\Model;
use Common\Model\CommonModel;
class NavModel extends CommonModel {
	//自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '菜单名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('app', 'require', '应用不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('model', 'require', '模块名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('action', 'require', '方法名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('app,model,action', 'checkAction', '同样的记录已经存在1！', 1, 'callback', CommonModel:: MODEL_INSERT   ),
    	array('id,app,model,action', 'checkActionUpdate', '同样的记录已经存在2！', 1, 'callback', CommonModel:: MODEL_UPDATE   ),
        array('parentid', 'checkParentid', '菜单只支持四级！', 1, 'callback', 1),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    );

    //验证菜单是否超出三级
    public function checkParentid($parentid) {
        $find = $this->where(array("id" => $parentid))->getField("parentid");
        if ($find) {
            $find2 = $this->where(array("id" => $find))->getField("parentid");
            if ($find2) {
                $find3 = $this->where(array("id" => $find2))->getField("parentid");
                if ($find3) {
                    return false;
                }
            }
        }
        return true;
    }

    //验证action是否重复添加
    public function checkAction($data) {
        //检查是否重复添加
        $find = $this->where($data)->find();
        if ($find) {
            return false;
        }
        return true;
    }
    //验证action是否重复添加
    public function checkActionUpdate($data) {
    	//检查是否重复添加
    	$id=$data['id'];
    	unset($data['id']);
    	$find = $this->field('id')->where($data)->find();
    	if (isset($find['id']) && $find['id']!=$id) {
    		return false;
    	}
    	return true;
    }
    

    /**
     * 按父ID查找菜单子项
     * @param integer $parentid   父菜单ID  
     * @param integer $with_self  是否包括他自己
     */
    public function admin_menu($cid,$parentid, $with_self = false) {

        //父节点ID
        $parentid = (int) $parentid;

        $result = $this->where(array('cid'=>$cid,'parentid' => $parentid,'status' => 1))->order(array("listorder" => "ASC"))->select();

        if ($with_self) {

            $result2[] = $this->where(array('id' => $parentid))->find();
            $result = array_merge($result2, $result);
        }
//
        //权限检查
        //if (session("roleid") == 1) {
            //如果角色为 1 直接通过
            return $result;
        //}
        //dump($result);exit;
        $array = array();

        foreach ($result as $v){
            $app=$v['app'];
            $model=$v['model'];
            $action=$v['action'];
            $name=strtolower("$app/$model/$action");
            //echo $name."<br>";
            if (in_array($name, $priv)){
                $array[] = $v;
            }
        }
        return $array;
    }

    /**
     * 获取菜单 头部菜单导航
     * @param $parentid 菜单id
     */
    public function submenu($parentid = '', $big_menu = false) {
        $array = $this->admin_menu($parentid, 1);
        $numbers = count($array);
        if ($numbers == 1 && !$big_menu) {
            return '';
        }
        return $array;
    }

    /**
     * 菜单树状结构集合
     */
    public function menu_json($cid = 1) {
        
        //获取当前用户的角色id对应下的所有的权限
        $userid=$_SESSION['USER_ID'];
        $schoolid=$_SESSION['schoolid'];
        $where['dt.schoolid'] = $schoolid;
        $where['dt.teacher_id'] = $userid;
        $where['a.type'] = 'teacher_url';
     
        $ids = M('school_duty')
            ->alias('d')
            ->where($where)
            ->order("d.level ASC")
            ->join('wxt_duty_teacher as dt on d.id=dt.duty_id')
            ->join('wxt_school_authaccess as a on a.role_id = d.id')
            ->field('a.rule_name')
            ->select();

 
        foreach ($ids as $v){
            $url[] = $v['rule_name'];
        }

        $data = $this->get_tree($cid,0, '', 1);

        $authData = array();
        foreach ($data as $k=>$v){
            //判断是否存在
            if (in_array($v['auth'], $url)){
                $authData[$k]['icon'] = $v['icon'];
                $authData[$k]['id'] = $v['id'];
                $authData[$k]['name'] = $v['name'];
                $authData[$k]['parent'] = $v['parent'];
                $authData[$k]['url'] = $v['url'];
                if (!empty($v['items'])) {
                    foreach ($v['items'] as $ks => $vs){
                        //dump($vs);exit;
                        //判断是否存在
                        if (in_array($vs['auth'], $url)){
                            $authData[$k]['items'][$ks] = $vs;
                        }
                    }
                }
            }
        }

        return $authData;
    }

    //取得树形结构的菜单
    public function get_tree($cid,$myid, $parent = "", $Level = 1) {

        $data = $this->admin_menu($cid,$myid, false);

        //exit;
        $Level++;
        if (is_array($data)) {
            foreach ($data as $a) {
                $id = $a['id'];
                $name = ucwords($a['app']);
                $model = ucwords($a['model']);
                $action = $a['action'];
                //附带参数
              $fu = "";
                if ($a['data']) {
                    $fu = "?" . htmlspecialchars_decode($a['data']);
                }
                $array = array(
                    "icon" => $a['icon'],
                    "id" => $id . $name,
                    "name" => $a['name'],
                    "parent" => $parent,
                    "url" => U("{$name}/{$model}/{$action}{$fu}", array("menuid" => $id)),
                    "auth"=> strtolower($name).'/'.strtolower($model).'/'.strtolower($action)
                ); 


                
                $ret[$id . $name] = $array;
                $child = $this->get_tree($a['cid'], $id, $Level);
                //由于后台管理界面只支持三层，超出的不层级的不显示
                if ($child && $Level <= 3) {
                    $ret[$id . $name]['items'] = $child;
                }
            }

            return $ret;
        }
       
        return false;
    }

    /**
     * 更新缓存
     * @param type $data
     * @return type
     */
    public function menu_cache($data = null) {
        if (empty($data)) {
            $data = $this->select();
            F("Menu", $data);
        } else {
            F("Menu", $data);
        }
        return $data;
    }

    /**
     * 后台有更新/编辑则删除缓存
     * @param type $data
     */
    public function _before_write(&$data) {
        parent::_before_write($data);
        F("Menu", NULL);
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->_before_write($data);
    }
    
    public function menu($parentid, $with_self = false){
    	//父节点ID
    	$parentid = (int) $parentid;
    	$result = $this->where(array('parentid' => $parentid))->select();
    	if ($with_self) {
    		$result2[] = $this->where(array('id' => $parentid))->find();
    		$result = array_merge($result2, $result);
    	}
    	return $result;
    }
    /**
     * 得到某父级菜单所有子菜单，包括自己
     * @param number $parentid 
     */
    public function get_menu_tree($parentid=0){
    	$menus=$this->where(array("parentid"=>$parentid))->order(array("listorder"=>"ASC"))->select();
    	
    	if($menus){
    		foreach ($menus as $key=>$menu){
    			$children=$this->get_menu_tree($menu['id']);
    			if(!empty($children)){
    				$menus[$key]['children']=$children;
    			}
    			unset($menus[$key]['id']);
    			unset($menus[$key]['parentid']);
    		}
    		return $menus;
    	}else{
    		return $menus;
    	}
    	
    }
	
}