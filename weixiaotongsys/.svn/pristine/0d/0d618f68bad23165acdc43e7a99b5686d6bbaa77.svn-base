<?php

/**
 * 后台首页  日常管理
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;

class ArticleManageController extends TeacherbaseController {

    protected $school_column_model;
    protected $school_article_model;

    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->schoolnotice_model=D("Common/schoolnotice");

        $this->school_article_model = M("School_web_article");
        $this->school_column_model = M("School_column");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists(){
        $schoolid=$_SESSION['schoolid'];

        $get_column = I("column");
        $get_keyword = I("keyword");

        if (!empty($get_column)){
            $map["column_id"] = $get_column;
            $map['_logic'] = 'AND';
        }

        if (!empty($get_keyword)){
            $map["post_title"] = array("like","%".$get_keyword."%");
            $map["post_excerpt"] = array("like","%".$get_keyword."%");
            $map['_logic'] = 'OR';
        }



        $article = $this->school_article_model
            ->alias("a")
            ->join("wxt_school_column s ON a.column_id=s.id")
            ->where($map)
            ->field("a.*,s.name")
            ->select();
        //查询该学校所有的栏目
        $column = $this->school_column_model->where("schoolid = $schoolid and column_type=1")->select();
        $this->assign("column",$column);
        $this->assign("articles",$article);
        $this->assign("column",$column);

    }
//------------------增加校园招聘----------------
  function add(){

      $schoolid=$_SESSION['schoolid'];
      $column = $this->school_column_model->where("schoolid = $schoolid and column_type=1")->select();
      $this->assign("column",$column);
      $this->display();
    }
    
    function add_post(){
//      dump($_POST);
//      die();
        if (IS_POST) {
            if(empty($_POST['column'])){
                $this->error("请至少选择一个分类栏目！");
            }
            $notice['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
//            $notice['post']['post_date']=date("Y-m-d H:i:s",time());
            $notice['post_date']=date("Y-m-d H:i:s",time());
            $notice['schoolid']=$_SESSION['schoolid'];
            $notice['userid'] = $_SESSION['USER_ID'];
            if(($_POST['smeta']['thumb'])){
                $notice['smeta']=json_encode($_POST['smeta']);
            }else{
                $notice['smeta']="http://ow3hm6y11.bkt.clouddn.com/img12.png";
            }

            $notice['column_id'] = $_POST['column'];
            $notice['create_time']= time();
            $notice['post_excerpt'] = $_POST['post']['post_excerpt'];
            $notice['post_title'] = $_POST['post']['post_title'];
            $notice['post_content']=htmlspecialchars_decode($_POST['post']['post_content']);
            $notice['post_status'] = $_POST['post']['post_status'];

            $result=$this->school_article_model->add($notice);
//            $this->error("保存失败！".$result.$_SESSION['userid']);
            if ($result!==false) {
                $this->success("保存成功！",U("index"));
            } else {
                $this->error("保存失败！");
            }
        }
    }
//------------------增加校园招聘结束----------------

//------------------更新校园招聘开始----------------
    public function edit(){
        $id=  intval(I("id"));
        $schoolid=$_SESSION['schoolid'];
        $notice = $this->school_article_model->where(array("id"=>$id))->find();
        $this->assign("notice",$notice);
//        $this->assign("smeta",json_decode($post['smeta'],true));
        $column = $this->school_column_model->where("schoolid = $schoolid and column_type=1")->select();
        $this->assign("column",$column);
        // $this->assign("term",$term_relationship);
        $this->display();
    }
    
    public function edit_post(){
        if (IS_POST) {
            $notice['id']=intval(I("notice_id"));
            if(empty($_POST['column'])){
                $this->error("请至少选择一个分类栏目！");
            }
            $notice['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
            $notice['post_date']=date("Y-m-d H:i:s",time());
            $notice['schoolid']=$_SESSION['schoolid'];
            $notice['userid'] = $_SESSION['USER_ID'];
//            $notice['smeta']=json_encode($_POST['smeta']);
            if(($_POST['smeta']['thumb'])){
                $notice['smeta']=json_encode($_POST['smeta']);
            }else{
                $notice['smeta']="http://ow3hm6y11.bkt.clouddn.com/img12.png";
            }
            $notice['column_id'] = $_POST['column'];
            $notice['create_time']= time();
            $notice['post_title'] = $_POST['post']['post_title'];
            $notice['post_status'] = $_POST['post']['post_status'];
            $notice['post_excerpt'] = $_POST['post']['post_excerpt'];
            $notice['post_content']=htmlspecialchars_decode($_POST['post']['post_content']);
//            dump($notice);
//            die();
            $result=$this->school_article_model->save($notice);
            if ($result!==false) {
                $this->success("保存成功！",U("index"));
            } else {
                $this->error("保存失败！");
            }
        }
    }
   
//------------------更新校园招聘结束----------------

//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->school_article_model->where("id=$id")->delete();
            if ($rst) {
                $this->success("删除成功！");
            } else {
                $this->error("删除失败！");
            }
        } else {
            $this->error('数据传入失败！');
        }
        //$this->error('该功能暂时未开通！');
    }

    //排序
    public function listorders() {
        $status = parent::_listorders($this->job_model);
        if ($status) {
            $this->success("排序更新成功！");
        } else {
            $this->error("排序更新失败！");
        }
    }
//-------------------------审核-------------------------
    function check(){
        if(isset($_POST['ids']) && $_GET["check"]){
            $data["post_status"]=1;
            
            $tids=join(",",$_POST['ids']);
            $objectids=$this->job_model->field("id")->where("id in ($tids)")->select();
            $ids=array();
            foreach ($objectids as $id){
                $ids[]=$id["id"];
            }
            $ids=join(",", $ids);
            if ( $this->job_model->where("id in ($ids)")->save($data)!==false) {
                $this->success("审核成功！");
            } else {
                $this->error("审核失败！");
            }
        }
        if(isset($_POST['ids']) && $_GET["uncheck"]){
            
            $data["post_status"]=0;
            $tids=join(",",$_POST['ids']);
            $objectids=$this->job_model->field("id")->where("id in ($tids)")->select();
            $ids=array();
            foreach ($objectids as $id){
                $ids[]=$id["id"];
            }
            $ids=join(",", $ids);
            if ( $this->job_model->where("id in ($ids)")->save($data)) {
                $this->success("取消审核成功！");
            } else {
                $this->error("取消审核失败！");
            }
        }
    }

    private function _getTree(){
		$schoolid=empty($_REQUEST['school'])?0:intval($_REQUEST['school']);
		$result = $this->school_model->field("schoolid ,school_name as name")->order(array("schoolid"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id']=$r['schoolid'];
			$r['selected']=$schoolid==$r['id']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
}