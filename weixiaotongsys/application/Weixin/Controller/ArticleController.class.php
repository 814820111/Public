<?php
namespace Weixin\Controller;
use Common\Controller\WeixinbaseController;
header("Content-type:text/html;charset=utf-8");
class ArticleController extends WeixinbaseController
{


    //文章
    public function index(){
        $id = I("id");
        $Article = M("wechat_material")->where("id=$id")->find();
        $clicks = $Article["clicks"]+1;
        M("wechat_material")->where("id=$id")->save(array("Clicks"=>$clicks));
        //dump($Article);
        $this->assign("Article",$Article);
        $this->display();
    }
}

