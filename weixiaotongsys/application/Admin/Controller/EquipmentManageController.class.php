<?php

/**
 * 后台首页  设备管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class EquipmentManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
    }
    //设备管理首页
    public function index() {
        echo "设备管理";
    }
}

