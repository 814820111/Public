<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class ChildBooksController extends AdminbaseController{
	protected $ad_model;
	
	function _initialize() {
		parent::_initialize();
		$this->ad_model = D("Common/Ad");
	}

    //书本设置
    public function index()
    {
        $this->display('book_setting');
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