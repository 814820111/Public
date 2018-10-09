<?php

/**
 * 后台首页  公众号管理
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class InvestGamesManageController extends AdminbaseController {


    function _initialize() {
        parent::_initialize();
    }
    //公众号管理首页
    public function index() {
        echo "公众号管理";
    }
}

