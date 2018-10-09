<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
namespace Portal\Controller;
use Common\Controller\HomeBaseController; 
/**
 * 首页
 */
class PageFirstController extends HomeBaseController {
	
    //首页
	public function first() {
    	$this->display(":first");
    }
    public function about_us() {
        $this->display(":about_us");
    }
    public function down() {
        $this->display(":down");
    }
    public function join_us() {
        $this->display(":join_us");
    }
    public function product_presentation() {
        $this->display(":product_presentation");
    }
}


