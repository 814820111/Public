<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ChildSchoolInfosController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->growth_schoolinfo = D("Common/growth_schoolinfo");
	}

	//学校信息
	function index(){
        $info = $this->growth_schoolinfo->alias('gs')->join('wxt_school as s on gs.school_id = s.schoolid')->field('gs.*, s.school_name as name')->select();

        $this->assign('info', $info);
        $this->display();
	}
	
	function add_info(){
	    if (IS_POST){
            $imgs = addslashes($_POST['smeta']['thumb']);
            $arr = array(
                'img'=>$imgs,
                'school_id'=>I('school_id'),
                'info'=>addslashes($_POST['post']['post_content'])
            );

            $insert = $this->growth_schoolinfo->add($arr);
            if ($insert){
                $this->success('添加成功', U('index'));
            }
            exit;
        }
        $school = M('school')->select();

        $this->assign('school', $school);
		$this->display();
	}
}