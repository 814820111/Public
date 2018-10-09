<?php

/**
 * 后台首页
 */
namespace Teacher\Controller;
use Common\Controller\TeacherbaseController;
class OverTimeController extends TeacherbaseController {
    function _initialize() {
        parent::_initialize();

    }
	public function overtime(){
		$this->display();
	}
}