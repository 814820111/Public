<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class EntrustController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->class_model = D("Common/school_class");
        $this->wxt_agent_model=D("Common/agent");
        $this->entrust_model=D("Common/entrust");
        $this->microblog_pic_url_model=D("Common/microblog_picture_url");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($status=1){
        $user_id=0;
        if(!empty($_REQUEST["user"])){
            $user_id=intval($_REQUEST["user"]);
            //$this->assign("school_id",$school_id);
            //$_GET['school_id']=$school_id;
        }
        
        $where_ands=empty($user_id)?array(""):array("userid = $user_id");
        $fields=array(
                // 'start_time'=> array("field"=>"post_date","operator"=>">"),
                // 'end_time'  => array("field"=>"post_date","operator"=>"<"),
                'keyword'  => array("field"=>"content","operator"=>"like"),
        );

        if(IS_POST){
            
            foreach ($fields as $param =>$val){
                if (isset($_POST[$param]) && !empty($_POST[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_POST[$param];
                    $_GET[$param]=$get;
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }else{
            foreach ($fields as $param =>$val){
                if (isset($_GET[$param]) && !empty($_GET[$param])) {
                    $operator=$val['operator'];
                    $field   =$val['field'];
                    $get=$_GET[$param];
                    if($operator=="like"){
                        $get="%$get%";
                    }
                    array_push($where_ands, "$field $operator '$get'");
                }
            }
        }
        
        $where= join(" ", $where_ands);
            
        $count=$this->entrust_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $posts=$this->entrust_model
        ->field('id,studentid,photo,teacherid,userid,content,create_time,feedback,feed_time,status')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("id DESC")->select();

        foreach ($posts as &$name) {
             $studentname=$this->wxtuser_model
            ->where(array("id"=>$name['studentid']))
            ->field('name')
            ->find();
            $name["studentname"]=$studentname["name"];
            unset($name);
        }
        foreach ($posts as &$user) {
             $username=$this->wxtuser_model
            ->alias("user")
            ->join("wxt_microblog_main pic")
            ->where(array("user.id"=>$user['userid']))
            ->field('name')
            ->find();

            $user["username"]=$username["name"];
            unset($user);
        }
         foreach ($posts as &$teacher) {
             $teacher_name=$this->wxtuser_model
            ->where(array("id"=>$teacher['teacherid']))
            ->field('name')
            ->find();

            $teacher["teacher_name"]=$teacher_name["name"];
            unset($teacher);
        }
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("posts",$posts);
    }
//------------------增加班级相册----------------
//   function add(){
//         $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
//         $class_name = $this->class_model->order(array("id"=>"asc"))->select();
//         $schoolid = intval(I("get.school"));
//         $this->_getTree();
//         $pic=$this->microblog_main_model->where("schoolid=$schoolid")->find();
//         $this->assign("author","1");
//         $this->assign("pic",$pic);
//         $this->assign("school_name",$school_name);
//         $this->assign("class_name",$class_name);
//         $this->display();
//     }
    
//     function add_post(){
//         if (IS_POST) {
//             if(empty($_POST['school'])){
//                 $this->error("请至少选择一个学校！");
//             }
//              if(empty($_POST['class'])){
//                 $this->error("请至少选择一个班级！");
//             }
            
//             $data['schoolid']=$_POST['school'];
//             $data['classid']=$_POST['class'];
//             //$data['userid']=$_POST['userid'];
//             $data['content']=$_POST['content'];
//             $data['schoolname']=$schoolname;
//             $data['write_time']=time();
//             $data['type']="2";
//             // dump($data);
//             $info=$this->microblog_main_model->add($data);
//             $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
//             $pic_data['pictureurl']=$_POST['smeta']['thumb'];
//             $pic_data['microblogid']=$info;
//             $pic=$this->microblog_pic_url_model->add($pic_data);
//             if($info&&$pic){
//                  $this->success('保存成功');
//             }else{
//                 $this->error("保存失败！");
//             }
//         }else{
//             $this->error('error!');
//         }
//     }
// //------------------增加班级相册结束----------------

// //------------------更新班级相册开始----------------
//     public function edit(){
//         $id=  intval(I("id"));
//         //var_dump($id);
//         $schoolid = intval(I("get.school"));
//         $classid = intval(I("get.class"));
//         $this->_getTree();
//         $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
//         $class_name = $this->class_model->order(array("id"=>"asc"))->select();
//         $pic = $this->microblog_main_model->where(array("mid"=>$id))->find();
//         $this->assign("pic",$pic);
//         $this->assign("smeta",json_decode($post['smeta'],true));
//         $this->assign("school_name",$school_name);
//         $this->assign("class_name",$class_name);
//         $this->display();
//     }
    
//     public function edit_post(){
//         if (IS_POST) {
//             $mid=$_POST['pic_id'];

//             if(empty($_POST['school'])){
//                 $this->error("请至少选择一个学校！");
//             }
//             if(empty($_POST['class'])){
//                 $this->error("请至少选择一个班级！");
//             }
//             if(!empty($_POST['photos_alt']) && !empty($_POST['photos_url'])){
//                 foreach ($_POST['photos_url'] as $key=>$url){
//                     $photourl=sp_asset_relative_url($url);
//                     $_POST['smeta']['photo'][]=array("url"=>$photourl,"alt"=>$_POST['photos_alt'][$key]);
//                 }
//             }
            
//             // $pic['schoolid']=$_POST['school'];
//             // $pic['classid']=$_POST['class'];
//             // $pic['userid']="600";
//             // $pic['content']=$_POST['content'];
//             // $pic['write_time']=time();
//             // $pic['type']="2";
//             // $info=$this->microblog_main_model->where("mid=$mid")->save($pic);
//             $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
//             $pic_data['pictureurl']=$_POST['smeta']['thumb'];
//             $result=$this->microblog_pic_url_model->where("microblogid=$mid")->save($pic_data);
//             if ($result) {
//                 $this->success("保存成功！");
//             } else {
//                 $this->error("保存失败！");
//             }
//         }
//     }
   
//------------------更新班级相册结束----------------

//------------------删除信息------------------------
    function delete(){
         $id=intval($_GET['id']);
        //var_dump($id);
        if ($id) {
            $rst = $this->entrust_model->where("id=$id")->delete();
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