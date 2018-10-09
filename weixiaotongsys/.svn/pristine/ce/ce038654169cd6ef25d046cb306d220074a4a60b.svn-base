<?php
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class GradeController extends TeacherbaseController {


    function _initialize() {
        parent::_initialize();

    }
	//学校年段管理
	public function index(){
		 $schoolid=$_SESSION['schoolid'];
		 $grade=M('school_grade')->where("schoolid=$schoolid")->order("id asc")->select();
		 $this->assign("grade",$grade);
		 $this->display();
	}
	//学校年段修改
	public function edit(){
		$schoolid=I("school");
		$student_name=I("student_name");
		$data["id"]=$schoolid;
		$data["grade"]=$student_name;
		 if(!$schoolid){
                $this->error("请选择你要修改的年级");
            }
            if(!$student_name){
                $this->error("请填写你要修改的名字");
            }
		$User = M("school_grade")->save($data);	
		if($User){
			$this->success("修改成功");
		}else{
			$this->error("参数流失");
		}
			
	}
}
?>