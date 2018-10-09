<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class DailyManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->cookbook_model=D("Common/cookbook");
    }

    public function index() {
               $count=$this->cookbook_model->where("id>=0")->count();
        $page = $this->page($count, 20);
     $schoolid = I('school');

     $grade = I("grade");


     if($schoolid)
     {
        $where['c.schoolid'] = $schoolid;
     } 

     if($grade)
     {
        $where['c.grade'] = $grade;
        $this->assign("grade_int",$grade);
     } 

$daily = $this->cookbook_model
            ->alias("c")
            ->where($where)
            ->join("wxt_school s ON s.schoolid = c.schoolid")
            ->order("c.id DESC ,c.create_time DESC")
            ->field("s.school_name,c.week,c.title,c.content,c.photo,c.grade,c.date,c.id,c.schoolid,c.grade")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
  //TODO数据量过大 以后再改造
   foreach ($daily as &$value) {
       $schoolid = $value['schoolid'];
       $grade = $value['grade'];
     $school_grade = M('school_grade')->where("schoolid = $schoolid and gradeid = $grade")->find();

     $value['grade_name'] = $school_grade['name'];

   }

        foreach ($daily as &$cook) {
        $photo=$cook['photo'];
        $cook['photo']=sp_get_asset_upload_path($photo);
        unset($cook);
        }
            $this->_getTree();
        $this->assign("page", $page->show('Admin'));
       // var_dump($daily);
        $this->assign("daily",$daily);
        $this->display("cookbookmanage");
    }

//------------------增加食谱----------------
    public function addcookbook(){
    	$schools = $this->school_model->order(array("schoolid"=>"asc"))->select();
		// dump($schools);
		$this->assign("schools",$schools);
		$this->display();
    }
    public function addcookbook_post(){
    	if(IS_POST){
    		$school_id=$_POST['school'];
            $_POST['smeta']['thumb'] = sp_asset_relative_url($_POST['smeta']['thumb']);
            var_dump($_POST['smeta']['thumb']);
    		//利用前台传回来的schoolid获取school_name并传入数据库
    		$schoolname=$this->school_model->where("$school_id=schoolid")->getField('school_name');
    		$data['schoolid']=$_POST['school'];
    		//把前端传回来的时间字符串转化为时间戳
    		$time=strtotime($_POST['cook_time']);
    		$data['date']=$time;
    		$data['title']=$_POST['cook_type'];
    		$data['photo']=$_POST['smeta']['thumb'];
    		$data['content']=$_POST['cook_content'];
            $data['create_time']=time();
    		$data['schoolname']=$schoolname;
    		// dump($data);
    		$cookbook=$this->cookbook_model->add($data);
    		if($cookbook){
    			 $this->success('保存成功');
    		}else{
                $this->error("保存失败！");
            }
   
    	}else{
    		$this->error('error!');
    	}

    }
//------------------增加食谱结束----------------

    public function cookbookmanage() {
        $count=$this->cookbook_model->where("id>=0")->count();
        $page = $this->page($count, 20);
      
$daily = $this->cookbook_model
            ->alias("c")
            ->where($where)
            ->join("wxt_school s ON s.schoolid = c.schoolid")
            ->order("c.id DESC ,c.create_time DESC")
            ->field("s.school_name,c.week,c.title,c.content,c.photo,c.grade,c.date,c.id,c.schoolid,c.grade")
            ->limit($page->firstRow . ',' . $page->listRows)
            ->select();
  //TODO数据量过大 以后再改造
   foreach ($daily as &$value) {
       $schoolid = $value['schoolid'];
       $grade = $value['grade'];
     $school_grade = M('school_grade')->where("schoolid = $schoolid and gradeid = $grade")->find();

     $value['grade_name'] = $school_grade['name'];

   }

        foreach ($daily as &$cook) {
        $photo=$cook['photo'];
        $cook['photo']=sp_get_asset_upload_path($photo);
        unset($cook);
        }
            $this->_getTree();
        $this->assign("page", $page->show('Admin'));
       var_dump($daily);
        $this->assign("daily",$daily);
        $this->display("cookbookmanage");
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

    public function school_grade()
    {

      $schoolid = I("schoolid");
      // var_dump($schoolid);

      $school_grade = M("school_grade")->where("schoolid = $schoolid")->select();
     
     // var_dump($school_grade);

        if($school_grade){
                $ret = $this->format_ret(1,$school_grade);
            }else{
                $ret = $this->format_ret(0,"lost params");
            }
             echo json_encode($ret);




    }
  

   function format_ret ($status, $data='') {
        if ($status){   
        //成功
            return array('status'=>'success', 'data'=>$data);
        }else{  
            //验证失败
            return array('status'=>'error', 'data'=>$data);
        }
    }



}