<?php

/**
 * 后台首页  日常管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class BabyClassController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
        $this->school_model = D("Common/School");
        $this->class_model = D("Common/school_class");
        $this->wxtuser_model = D("Common/wxtuser");
        $this->wxt_agent_model=D("Common/agent");
        $this->syllabus_model=D("Common/class_syllabus");
        $this->subject_model=D("Common/subject");
    }

    public function index() {
        $this->_lists();
        $this->_getTree();
        $this->display("");
    }
private  function _lists($status=1){
        $school_id=0;
        if(!empty($_REQUEST["class"])){
            $class_id=intval($_REQUEST["class"]);
            //$this->assign("school_id",$school_id);
            //$_GET['school_id']=$school_id;
        }
        
        $where_ands=empty($class_id)?array(""):array("classid = $class_id");
        $fields=array(
                'start_time'=> array("field"=>"post_date","operator"=>">"),
                'end_time'  => array("field"=>"post_date","operator"=>"<"),
                'keyword'  => array("field"=>"post_title","operator"=>"like"),
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
            
        $count=$this->syllabus_model
        ->where($where)
        ->count();
            
        $page = $this->page($count, 20);
            
        $posts=$this->syllabus_model
        ->field('syllabus_id,schoolid,classid,syllabus_no,monday,tuesday,wednesday,thursday,friday,saturday,sunday')
        ->where($where)
        ->limit($page->firstRow . ',' . $page->listRows)
        ->order("syllabus_no ASC")
        ->select();
         $subject_model=M('default_subject');
         $subject_data=$subject_model->field("id,subject")->select();

          foreach($posts as &$iu){
          	foreach($subject_data as &$is){
          		if($iu['monday']==$is['id']){
                    $iu['monday']=$is['subject'];
          		}
				 if($iu['tuesday']==$is["id"]){
                     $iu['tuesday']=$is['subject'];
                 }
                 if($iu['wednesday']==$is['id']){
                 	$iu['wednesday']=$is['subject'];
                 }
				 if($iu['thursday']==$is['id']){
				 	$iu['thursday']=$is['subject'];
				 }
				 if($iu['friday']==$is['id']){
				 	$iu['friday']=$is['subject'];
				 }
				 if($iu['saturday']==$is['id']){
				 	$iu['saturday']=$is['subject'];
				 }
                if($iu['sunday']==$is['id']){
                	   $iu['sunday']=$is['subject'];
                }
				
          	}
          } 
		  
		  
        foreach ($posts as &$plan) {
             $schoolname=$this->school_model
            ->where(array("schoolid"=>$plan['schoolid']))
            ->field('school_name,school_phone')
            ->find();
            $plan["schoolname"]=$schoolname["school_name"];
            $plan["schoolphone"]=$schoolname["school_phone"];
            unset($plan);
        }
        foreach ($posts as &$class) {
             $classname=$this->class_model
            ->where(array("id"=>$class['classid']))
            ->field('classname')
            ->find();

            $class["classname"]=$classname["classname"];
            unset($class);
        }
        // $days=array(array(),array(),array(),array(),array(),array(),array());
        // foreach ($posts as $key => $value) {
        //     $index=$value["syllabus_date"]-1;//得到星期几
        //     $time=$value["syllabus_no"]-1;//得到第几节
        //     $lesson=$value["syllabus_name"];
        //     $days[$index][$time][$lesson]=$key;
        //}
//      echo "<pre>";
//		var_dump($posts);
//		echo "<pre><br>";
        $this->assign("days", $days);
        $this->assign("Page", $page->show('Admin'));
        $this->assign("current_page",$page->GetCurrentPage());
        unset($_GET[C('VAR_URL_PARAMS')]);
        $this->assign("formget",$_GET);
        $this->assign("school_name",$school_name);
        $this->assign("posts",$posts);
    }
//------------------增加周计划----------------
  function add(){
        $school_name = $this->school_model->order(array("schoolid"=>"asc"))->select();
        $class_name = $this->class_model->order(array("id"=>"asc"))->select();
        $lesson_name = $this->subject_model->order(array("id"=>"asc"))->select();
        $classid = intval(I("get.class"));
        $this->_getTree();
        $syllabus=$this->syllabus_model->where("classid=$classid")->find();
        $this->assign("author","1");
        $this->assign("syllabus",$syllabus);
        $this->assign("school_name",$school_name);
        $this->assign("class_name",$class_name);
        $this->assign("lesson_name",$lesson_name);
        $this->display();
    }
    
    function add_post(){
        if (IS_POST) {
            if(empty($_POST['class'])){
                $this->error("请至少选择一个班级！");
            }
            // if(empty($_POST['school'])){
            //     $this->error("请至少选择一个学校！");
            // }
            $data_a['classid']=$_POST['class'];
            $data_a['schoolid']=$_POST['school'];
            $data_a['monday']=$this->subject_model->where(array("id"=>$_POST['mon_fir']))->getField('subject');
            $data_a['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_fir']))->getField('subject');
            $data_a['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_fir']))->getField('subject');
            $data_a['thursday']=$this->subject_model->where(array("id"=>$_POST['th_fir']))->getField('subject');
            $data_a['friday']=$this->subject_model->where(array("id"=>$_POST['fri_fir']))->getField('subject');
            $data_a['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_fir']))->getField('subject');
            $data_a['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_fir']))->getField('subject');
            $data_a['syllabus_no']="1";
            $res_a=$this->syllabus_model->add($data_a);

            $data_b['classid']=$_POST['class'];
            $data_b['schoolid']=$_POST['school'];
            $data_b['monday']=$this->subject_model->where(array("id"=>$_POST['mon_se']))->getField('subject');
            $data_b['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_se']))->getField('subject');
            $data_b['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_se']))->getField('subject');
            $data_b['thursday']=$this->subject_model->where(array("id"=>$_POST['th_se']))->getField('subject');
            $data_b['friday']=$this->subject_model->where(array("id"=>$_POST['fri_se']))->getField('subject');
            $data_b['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_se']))->getField('subject');
            $data_b['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_se']))->getField('subject');
            $data_b['syllabus_no']="2";
            $res_b=$this->syllabus_model->add($data_b);

            $data_c['classid']=$_POST['class'];
            $data_c['schoolid']=$_POST['school'];
            $data_c['monday']=$this->subject_model->where(array("id"=>$_POST['mon_th']))->getField('subject');
            $data_c['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_th']))->getField('subject');
            $data_c['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_th']))->getField('subject');
            $data_c['thursday']=$this->subject_model->where(array("id"=>$_POST['th_th']))->getField('subject');
            $data_c['friday']=$this->subject_model->where(array("id"=>$_POST['fri_th']))->getField('subject');
            $data_c['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_th']))->getField('subject');
            $data_c['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_th']))->getField('subject');
            $data_c['syllabus_no']="3";
            $res_c=$this->syllabus_model->add($data_c);

            $data_d['classid']=$_POST['class'];
            $data_d['schoolid']=$_POST['school'];
            $data_d['monday']=$this->subject_model->where(array("id"=>$_POST['mon_fo']))->getField('subject');
            $data_d['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_fo']))->getField('subject');
            $data_d['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_fo']))->getField('subject');
            $data_d['thursday']=$this->subject_model->where(array("id"=>$_POST['th_fo']))->getField('subject');
            $data_d['friday']=$this->subject_model->where(array("id"=>$_POST['fri_fo']))->getField('subject');
            $data_d['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_fo']))->getField('subject');
            $data_d['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_fo']))->getField('subject');
            $data_d['syllabus_no']="4";
            $res_d=$this->syllabus_model->add($data_d);

            $data_e['classid']=$_POST['class'];
            $data_e['schoolid']=$_POST['school'];
            $data_e['monday']=$this->subject_model->where(array("id"=>$_POST['mon_fi']))->getField('subject');
            $data_e['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_fi']))->getField('subject');
            $data_e['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_fi']))->getField('subject');
            $data_e['thursday']=$this->subject_model->where(array("id"=>$_POST['th_fi']))->getField('subject');
            $data_e['friday']=$this->subject_model->where(array("id"=>$_POST['fri_fi']))->getField('subject');
            $data_e['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_fi']))->getField('subject');
            $data_e['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_fi']))->getField('subject');
            $data_e['syllabus_no']="5";
            $res_e=$this->syllabus_model->add($data_e);

            $data_f['classid']=$_POST['class'];
            $data_f['schoolid']=$_POST['school'];
            $data_f['monday']=$this->subject_model->where(array("id"=>$_POST['mon_si']))->getField('subject');
            $data_f['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_si']))->getField('subject');
            $data_f['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_si']))->getField('subject');
            $data_f['thursday']=$this->subject_model->where(array("id"=>$_POST['th_si']))->getField('subject');
            $data_f['friday']=$this->subject_model->where(array("id"=>$_POST['fri_si']))->getField('subject');
            $data_f['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_si']))->getField('subject');
            $data_f['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_si']))->getField('subject');
            $data_f['syllabus_no']="6";
            $res_f=$this->syllabus_model->add($data_f);

            $data_g['classid']=$_POST['class'];
            $data_g['schoolid']=$_POST['school'];
            $data_g['monday']=$this->subject_model->where(array("id"=>$_POST['mon_seve']))->getField('subject');
            $data_g['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_seve']))->getField('subject');
            $data_g['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_seve']))->getField('subject');
            $data_g['thursday']=$this->subject_model->where(array("id"=>$_POST['th_seve']))->getField('subject');
            $data_g['friday']=$this->subject_model->where(array("id"=>$_POST['fri_seve']))->getField('subject');
            $data_g['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_seve']))->getField('subject');
            $data_g['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_seve']))->getField('subject');
            $data_g['syllabus_no']="7";
            $res_g=$this->syllabus_model->add($data_g);

            $data_h['classid']=$_POST['class'];
            $data_h['schoolid']=$_POST['school'];
            $data_h['monday']=$this->subject_model->where(array("id"=>$_POST['mon_ei']))->getField('subject');
            $data_h['tuesday']=$this->subject_model->where(array("id"=>$_POST['tu_ei']))->getField('subject');
            $data_h['wednesday']=$this->subject_model->where(array("id"=>$_POST['we_ei']))->getField('subject');
            $data_h['thursday']=$this->subject_model->where(array("id"=>$_POST['th_ei']))->getField('subject');
            $data_h['friday']=$this->subject_model->where(array("id"=>$_POST['fri_ei']))->getField('subject');
            $data_h['saturday']=$this->subject_model->where(array("id"=>$_POST['sat_ei']))->getField('subject');
            $data_h['sunday']=$this->subject_model->where(array("id"=>$_POST['sun_ei']))->getField('subject');
            $data_h['syllabus_no']="8";
            $res_h=$this->syllabus_model->add($data_h);
            if ($res_a&&$res_b&&$res_c&&$res_d&&$res_e&&$res_f&&$res_g&&$res_h) {
                $this->success("添加成功");
            } else {
                $this->error("添加失败！");
            }
             
        }
    }
//------------------增加周计划结束----------------

//------------------更新周计划开始----------------
    public function edit(){
        $id=  intval(I("id"));
        $schoolid = intval(I("get.school"));
        $this->_getTree();
        $school = $this->school_model
        ->alias("s")
        ->join("wxt_class_syllabus c ON c.schoolid=s.schoolid")
        ->where(array("syllabus_id"=>$id))
        ->field("school_name")
        ->select();
        $class = $this->class_model
        ->alias("a")
        ->join("wxt_class_syllabus c ON a.id=c.classid")
        ->where(array("syllabus_id"=>$id))
        ->field("classname")
        ->select();

        $syllabus = $this->syllabus_model->order(array("syllabus_id"=>"asc"))->find();

        $syllabus_mon = $this->syllabus_model
        ->alias("d")
        ->join("wxt_default_subject e ON d.monday=e.id")
        ->where(array("syllabus_id"=>$id))
        ->field("e.id")
        ->find();
        foreach ($syllabus_mon as &$lesson_mon) {
            $lesson_a=settype($lesson_mon,"integer");
        }
        
        $syllabus_tu = $this->syllabus_model
        ->alias("h")
        ->join("wxt_default_subject f ON h.tuesday=f.id")
        ->where(array("syllabus_id"=>$id))
        ->field("f.id")
        ->find();
        foreach ($syllabus_tu as &$lesson_tu) {
            $lesson_b=settype($lesson_tu,"integer");
        }

        $syllabus_we = $this->syllabus_model
        ->alias("h")
        ->join("wxt_default_subject f ON h.wednesday=f.id")
        ->where(array("syllabus_id"=>$id))
        ->field("f.id")
        ->find();
        foreach ($syllabus_we as &$lesson_we) {
            $lesson_c=settype($lesson_we,"integer");
        }

        $syllabus_th = $this->syllabus_model
        ->alias("h")
        ->join("wxt_default_subject f ON h.thursday=f.id")
        ->where(array("syllabus_id"=>$id))
        ->field("f.id")
        ->find();
        foreach ($syllabus_th as &$lesson_th) {
            $lesson_d=settype($lesson_th,"integer");
        }

        $syllabus_fri = $this->syllabus_model
        ->alias("h")
        ->join("wxt_default_subject f ON h.friday=f.id")
        ->where(array("syllabus_id"=>$id))
        ->field("f.id")
        ->find();
        foreach ($syllabus_fri as &$lesson_fri) {
            $lesson_e=settype($lesson_fri,"integer");
        }

        $syllabus_sat = $this->syllabus_model
        ->alias("h")
        ->join("wxt_default_subject f ON h.saturday=f.id")
        ->where(array("syllabus_id"=>$id))
        ->field("f.id")
        ->find();
        foreach ($syllabus_sat as &$lesson_sat) {
            $lesson_f=settype($lesson_sat,"integer");
        }

        $syllabus_sun = $this->syllabus_model
        ->alias("h")
        ->join("wxt_default_subject f ON h.sunday=f.id")
        ->where(array("syllabus_id"=>$id))
        ->field("f.id")
        ->find();
        foreach ($syllabus_sun as &$lesson_sun) {
            $lesson_g=settype($lesson_sun,"integer");
        }
        $subject =M("default_subject")->order(array("id"=>"asc"))->select();
//		echo "<pre>";
//		var_dump($subject);
//		echo"</pre><br>";
        echo $lesson_tu;
        $this->assign("lesson_mon",$lesson_mon);	
        $this->assign("lesson_tu",$lesson_tu);
        $this->assign("lesson_we",$lesson_we);
        $this->assign("lesson_th",$lesson_th);
        $this->assign("lesson_fri",$lesson_fri);
        $this->assign("lesson_sat",$lesson_sat);
        $this->assign("lesson_sun",$lesson_sun);
        $this->assign("school",$school);
        $this->assign("class",$class);
        $this->assign("syllabus",$syllabus);
        $this->assign("subject",$subject);
        $this->assign("id",$id);
        $this->display();
    }
    
    public function edit_post(){
        if (IS_POST) {
            $id=intval(I("id"));
            $this->success(I("syllabus_id"));
            $data['monday']=$this->subject_model->where(array("id"=>$_POST['lesson_mon']))->getField('subject');
            $data['tuesday']=$this->subject_model->where(array("id"=>$_POST['lesson_tu']))->getField('subject');
            $data['wednesday']=$this->subject_model->where(array("id"=>$_POST['lesson_we']))->getField('subject');
            $data['thursday']=$this->subject_model->where(array("id"=>$_POST['lesson_th']))->getField('subject');
            $data['friday']=$this->subject_model->where(array("id"=>$_POST['lesson_fri']))->getField('subject');
            $data['saturday']=$this->subject_model->where(array("id"=>$_POST['lesson_sat']))->getField('subject');
            $data['sunday']=$this->subject_model->where(array("id"=>$_POST['lesson_sun']))->getField('subject');
            $result=$this->syllabus_model->where("syllabus_id=$id")->save($data);
            $this->success($data['tuesday']);
            if ($result!==false) {
                $this->success("保存成功！");
            } else {
                $this->error("保存失败！");
            }
        }
    }
   
//------------------更新周计划结束----------------

//------------------删除信息------------------------
    function delete(){
        $id=intval($_GET['id']);
        if ($id) {
            $rst = $this->plan_model->where("id=$id")->delete();
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

    private function _getTree(){
		$classid=empty($_REQUEST['class'])?0:intval($_REQUEST['class']);
		$result = $this->class_model->field("id ,classname as name")->order(array("id"=>"asc"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['classid']=$r['id'];
			$r['selected']=$classid==$r['classid']?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$name</option>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
	}
}