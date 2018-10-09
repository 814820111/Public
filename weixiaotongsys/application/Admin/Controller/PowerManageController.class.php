<?php

/**
 * 后台首页  权限管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class PowerManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
    }
    //积分管理首页
    public function index() {
        echo "权限管理";
    }
}

