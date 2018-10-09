<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class EvaluationItemsController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->growth_EvaluationItems = D("Common/growth_evaluation_item");
	}

	//评分项目
	function index(){
        $info = $this->growth_EvaluationItems->select();
        //无限极分类

        $this->assign('info', $info);
        $this->display();
	}
	
	function add_info(){
	    if (IS_POST){
            $arr = array(

            );
            $insert = $this->growth_EvaluationItems->add($arr);
            if ($insert){
                $this->success('添加成功', U('index'));
            }
            exit;
        }


        $items = $this->growth_EvaluationItems->where("pid = 0")->select();

        $this->assign('items', $items);
		$this->display();
	}
}