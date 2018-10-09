<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class PrincipalOperationController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->ad_model = D("Common/Ad");
	}

	//学校信息
	function index(){
		$this->display();
	}
	
	function add_info(){
		$this->display();
	}

	//考评设置
	public function evaluation_setting()
    {
        $this->display();
    }
    public function add_evaluation_setting()
    {
        $this->display();
    }

    //书本设置
    public function book_setting()
    {
        $this->display();
    }
    public function add_book_setting()
    {
        $this->display();
    }

    //书本查看
    public function look_book()
    {
        $this->display();
    }
}