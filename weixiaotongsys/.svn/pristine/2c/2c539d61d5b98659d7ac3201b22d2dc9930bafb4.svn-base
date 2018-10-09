<?php

namespace Apps\Controller;
use Common\Controller\AppBaseController;
/**
 * 首页
 */
class RoleController extends AppBaseController {
     
    /**
     *  显示weixin菜单
     * @param array $appcatid 大类的分类ID
     * @param int $type 主题id
     * @param int $location 位置id
     */
	 public function weixin_role($appcatid,$type,$location)
	 {
    
       $menu  =   D("Common/NavApp")->menu_json($appcatid,$type,$location);
      


      return $menu;		


	 }

    

    public function app_role()
    {
       



    }

}