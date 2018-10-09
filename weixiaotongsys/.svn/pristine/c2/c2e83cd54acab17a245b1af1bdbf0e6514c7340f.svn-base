<?php
/**
 * APP(菜单管理)
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
header("Content-type: text/html; charset=utf-8");        
class AppMenuController extends AdminbaseController {


	protected $app_nav_model;
	protected $app_cat_model;

   	function _initialize() {
		parent::_initialize();
		$this->app_nav_model = D("Common/nav_app");
		$this->app_cat_model =D("Common/nav_app_cat");
	}
   
   	/**
	 *  显示菜单
	 */
	  public function index()
	  {
	   	
     	if(empty($_REQUEST['cid'])){
			$navcat=$this->app_cat_model->field("id")->find();
			$cid=$navcat['id'];
		}else{
			$cid=$_REQUEST['cid'];
		}
		// var_dump($cid);
        $result = $this->app_nav_model->where("appcatid=$cid")->order(array("listorder" => "ASC"))->select();
		import("Tree");
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $n=> $r) {
        	
        	// $result[$n]['level'] = $this->_get_level($r['id'], $newmenus);
        	$result[$n]['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . '"' : '';
        	
            $result[$n]['str_manage'] = '<a href="' . U("AppMenu/add", array("cid"=>$r['appcatid'],"parentid" => $r['id'], "menuid" => $_GET['menuid'])) . '">添加子菜单</a> | <a target="_blank" href="' . U("AppMenu/edit", array("id" => $r['id'],"cid"=>$r['appcatid'],"type"=>$r['type'], "menuid" => $_GET['menuid'],"parentid"=>$r['parentid'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("AppMenu/delete", array("id" => $r['id'], "menuid" => I("get.menuid")) ). '">删除</a> ';
            $result[$n]['status'] = $r['status'] ? "显示" : "隐藏";
            if(APP_DEBUG){
            	$result[$n]['app']=$r['app']."/".$r['model']."/".$r['action'];
            }
        }

        $tree->init($result);
        $str = "<tr id='node-\$id' \$parentid_node>
					<td style='padding-left:20px;'><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input input-order'></td>
					<td>\$id</td>
        			<td>\$app</td>
					<td>\$spacer\$name</td>
				    <td>\$status</td>
					<td>\$str_manage</td>
				</tr>";
        $categorys = $tree->get_tree(0, $str);
	
		$cats=$this->app_cat_model->select();
      $this->assign("categorys", $categorys);
      $this->assign("navcats",$cats);
		$this->assign("navcid",$cid);
		$this->display();
	  }

	/**
	 *  添加
	 */
	public function add() {
		$cid=$_REQUEST['cid'];
		$result = $this->app_nav_model->where("appcatid=$cid")->order(array("listorder" => "ASC"))->select();
		import("Tree");
		$tree = new \Tree();
		$tree->icon = array('&nbsp;│ ', '&nbsp;├─ ', '&nbsp;└─ ');
		$tree->nbsp = '&nbsp;';
		$parentid=I("get.parentid");
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("Menu/add", array("parentid" => $r['id'])) . '">添加子菜单</a> | <a href="' . U("Menu/edit", array("id" => $r['id'])) . '">修改</a> | <a class="J_ajax_del" href="' . U("Menu/delete", array("id" => $r['id'])) . '">删除</a> ';
			$r['status'] = $r['status'] ? "显示" : "隐藏";
			$r['selected'] = $r['id']==$parentid?"selected":"";
			$array[] = $r;
		}
			
		$tree->init($array);
		$str = "<tr>
				<td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='input'></td>
				<td>\$id</td>
				<td >\$spacer\$label</td>
			    <td>\$status</td>
				<td>\$str_manage</td>
			</tr>";
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$nav_trees = $tree->get_tree(0, $str);
		$this->assign("nav_trees", $nav_trees);		
		$cats=$this->app_cat_model->select();
		$this->assign("navcats",$cats);
		$this->assign('navs', $this->_select());
		$this->assign("navcid",$cid);
		$this->display();
	}

	/**
	 *  添加
	 */
	public function add_post() {



		if (IS_POST) {

                $pic1 = getimg($_POST['smeta']['thumb']);
          
          $pic2 = getimg($_POST['smeta3']['thumb']); 


           $icon = rtrim($pic1."|".$pic2,"|");



			$parentid=I("parentid");
			$navcats=I("cid");
			$name=I("name");
			$app=I("app");
			$model=I("model");
            $location = I("location");
			$action=I("action");
			$status=I("status");
			$type=I("type");
		   if(!$navcats){
		   	  $this->error("请选择菜单分类！");
		   } 
           if(!$name){
           	  $this->error("菜单栏的名称不能为空！");
           }
           if(!$app){
           	$this->error("应用不能为空！");
           }
           if(!$model){
           	$this->error("模块不能为空！");
           }
           if(!$action){
           	$this->error("方法不能为空！");
           }
			$data["parentid"]=$parentid;
			$data["appcatid"]=$navcats;
			$data["name"]=$name;
			$data["app"]=$app;
			$data["model"]=$model;
			$data["action"]=$action;
			$data["status"]=$status;
			$data["type"]=$type;
			$data["icon"] = $icon;
			$data["location"] = $location;
		$result=	$this->app_nav_model->add($data);
		if($result){
			$this->success("添加成功！", U("AppMenu/index"));
		}
			
//			$data['href']=htmlspecialchars_decode($data['href']);
//			if ($this->nav_model->create($data)) {
//				$result=$this->nav_model->add();
//				if ($result!==false) {
//					$parentid = $_POST['parentid']==0?"0":$_POST['parentid'];
//					if(empty($parentid)){
//						$data['path']="0-$result";
//					}else{
//						$parent=$this->nav_model->where("id=$parentid")->find();
//						$data['path']=$parent[path]."-$result";
//					}
//					$data['id']=$result;
//					$this->nav_model->save($data);
//					$this->success("添加成功！", U("nav/index"));
//				} else {
//					$this->error("添加失败！");
//				}
//			} else {
//				$this->error($this->nav_model->getError());
//			}
		}
	}
    /**
     *  编辑
     */
    public function edit() {
	$cid=intval($_REQUEST['cid']);
	$type = I("type");
		$id=intval(I("get.id"));
		$result = $this->app_nav_model->where("appcatid=$cid ")->order(array("listorder" => "ASC"))->select();

		import("Tree");
		$tree = new \Tree();
		$tree->icon = array('&nbsp;│ ', '&nbsp;├─ ', '&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$parentid= I("get.parentid");

		foreach ($result as $r) {
		
 
			$r['selected'] = $r['id'] == $parentid ? 'selected' : '';
        	$array[] = $r;
    	}
   
		
		$tree->init($array);
		$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
		$nav_trees = $tree->get_tree(0, $str);
	$this->assign("nav_trees", $nav_trees);
	
		
		
		$cats=$this->app_cat_model->select();
		$this->assign("navcats",$cats);
			
		$nav=$this->app_nav_model->where("id=$id")->find();

		$nav['hrefold'] = stripslashes($nav['href']);
		$href = unserialize($nav['hrefold']);
		if(empty($href)){
			if($nav['hrefold'] == "home"){
				$href = __ROOT__."/";
			}else{
				$href = $nav['hrefold'];
			}
		}else{
			$default_app = strtolower(C("DEFAULT_GROUP"));
			$href = U($href['action'],$href['param']);
			$g = C("VAR_GROUP");
			$href = preg_replace("/\/$default_app\//", "/",$href);
			$href = preg_replace("/$g=$default_app&/", "",$href);
		}
			
		$nav['href'] = $href;

   if($nav['location']==2)
   {
   	$icon = explode("|", $nav['icon']);
    $nav['icon']  = $icon[0];
	$nav['icon2'] = $icon[1];
   }		

    
    

	
        $this->assign("type",$type); 
		$this->assign('data',$nav);
		// var_dump($nav);
		$this->assign('navs', $this->_select());
		$this->assign("navcid",$cid);
		$this->display();
    }

	/**
	 *  编辑
	 */
	public function edit_post() {
		
		if (IS_POST) {
			// $parentid=empty($_POST['parentid'])?"0":$_POST['parentid'];
			// if(empty($parentid)){
			// 	$_POST['path']="0-".$_POST['id'];
			// }else{
			// 	$parent=$this->nav_model->where("id=$parentid")->find();
					
			// 	$_POST['path']=$parent['path']."-".$_POST['id'];
			// }
			
			// $data=I("post.");
			// var_dump($data);
			// $data['href']=htmlspecialchars_decode($data['href']);
             if($_POST['parentid']==$_POST['id'])
             {
             	$this->error("不能换到自己下面哦！");
             }

             

                $pic1 = getimg($_POST['smeta']['thumb']);
          
                $pic2 = getimg($_POST['smeta3']['thumb']); 


              $icon = rtrim($pic1."|".$pic2,"|");

              $_POST['icon'] = $icon;



			if ($this->app_nav_model->create()) {
				if ($this->app_nav_model->save() !== false) {
					$this->success("保存成功！", U("AppMenu/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->app_nav_model->getError());
			}
		}

	}

		/**
	 *  删除
	 */
	public function delete() {
		$id = intval(I("get.id"));;
		$count = $this->app_nav_model->where(array("parentid" => $id))->count();
		if ($count > 0) {
			$this->error("该菜单下还有子菜单，无法删除！");
		}
		if ($this->app_nav_model->delete($id)!==false) {
			$this->success("删除菜单成功！");
		} else {
			$this->error("删除失败！");
		}
	}







    	/**
	 * 排序
	 */
	public function listorders() {
		$status = parent::_listorders($this->app_nav_model);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}


	/**
	 * select nav
	 */
	
	private function _select(){
		$apps=sp_scan_dir(SPAPP."*");
		$navs=array();
		foreach ($apps as $a){
		
			if(is_dir(SPAPP.$a)){
				if(!(strpos($a, ".") === 0)){
					$navfile=SPAPP.$a."/nav.php";
					$app=$a;
					if(file_exists($navfile)){
						$navgeturls=include $navfile;
						foreach ($navgeturls as $url){
							$nav= file_get_contents(U("$app/$url",array(),false,true));
							$nav=json_decode($nav,true);
							$navs[]=$nav;
						}
					}
					
				}
			}
		}
		return $navs;
	}



}