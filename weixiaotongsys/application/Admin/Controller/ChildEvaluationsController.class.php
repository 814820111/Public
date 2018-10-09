<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ChildEvaluationsController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->ad_model = D("Common/Ad");
	}

	//考评设置
	public function index()
    {
        $this->display('evaluation_setting');
    }
    public function add_evaluation_setting()
    {
        $this->display();
    }
}