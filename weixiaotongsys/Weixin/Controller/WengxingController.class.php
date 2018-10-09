<?php
/**
 * Created by PhpStorm.
 * User: 品丞
 * Date: 2017/2/14
 * Time: 14:07
 */

namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
class WengxingController extends WeixinbaseController {
    public function jiang(){
        echo "维系段开发";
    }
    public function shouye(){
        $this->display("index");
    }
}