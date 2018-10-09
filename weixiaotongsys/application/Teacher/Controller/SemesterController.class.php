<?php

namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class SemesterController extends TeacherbaseController {

    function _initialize() {
        parent::_initialize();

    }
	public function index(){

		$semester = M('semester')->field("semester,semester_start,semester_end,create_time")->order('semester_start DESC')->select();
		foreach ($semester as &$key) {
			$nowtime = date('Y-m-d');
			$start = $key['semester_start'];
			$end = $key['semester_end'];
			if($nowtime>$start&&$nowtime<$end){
				$key['statu'] = '已开学';
			}elseif($nowtime>$start&&$nowtime>$end)
			{
               $key['statu'] = '已关闭';
			}else{
			
				$key['statu'] = '未开学';
			}
	}
		$this->assign('semester',$semester);
		$this->display();
	}


	public function add(){
		$semester['schoolid'] = $_SESSION['schoolid'];
		$semester['semester'] = I('semestername');
		$semester_name = $semester['semester'];
		$semester['semester_start'] = I('starttime');
		$semester['semester_end'] = I('endtime');
		$semester['create_time'] = time();
		$semester['status'] = 1;
		// if(empty($semester_name)){
		// 	$this->error('请输入学期信息！');
		// }else{
		$semester_add = M('semester')->add($semester);
	// }
		if($semester_add){
			$this->success('添加成功');
		}else{
			$this->error('添加失败');
		}
	}
}