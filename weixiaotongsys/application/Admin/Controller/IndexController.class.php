<?php

/**
 * 后台首页
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class IndexController extends AdminbaseController {
	
	
	function _initialize() {
		parent::_initialize();
		$this->initMenu();
	}
    //后台框架首页
    public function index() {
	    header('content-type: text/html; charset=utf-8');
	    // D("Common/Nav_app")->menu_json();
        $this->assign("SUBMENU_CONFIG", json_encode(D("Common/Menu")->menu_json()));

       	$this->display();
        
    }

}

