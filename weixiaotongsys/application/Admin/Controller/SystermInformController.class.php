<?php

/**
 * 后台首页  系统通知
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class SystermInformController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
    }
    //系统通知首页
    public function index() {
        echo "系统通知";
    }
}

