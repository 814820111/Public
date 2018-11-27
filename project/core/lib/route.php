<?php

namespace core\lib;
use core\lib\conf;
class route
{

    public $ctrl;
    public $action;
   public function __construct ()
   {

       //
      //p('route ok');
       /**
        * 1.隐藏index.php\
        * 2.获取url
        * 3返回对应控制器和方法
        */
//       p($_SERVER);

       if(isset($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI'] != '/')
       {
           //   /index/index
           $path = $_SERVER['REQUEST_URI'];
           $patharr =  explode('/',trim($path,"/"));

           if(isset($patharr[0]))
           {
               $this->ctrl = $patharr[0];
           }
           unset($patharr[0]);
           if(isset($patharr[1]))
           {
               $this->action = $patharr[1];
               unset($patharr[1]);
           }else{
               $this->action = conf::get('ACTION','route');
           }
           $count = count($patharr) + 2;
           $i= 2;
           while($i< $count)
           {
               if(isset($patharr[$i + 1]))
               {
                   $_GET[$patharr[$i]] = $patharr[$i + 1];
               }


             $i = $i + 2;
           }

           //url多余部分转换为get参数
           //index/index/id
//           p($patharr);
       }else{
          $this->ctrl = conf::get('CTRL','route');
          $this->action = conf::get('ACTION','route');
       }
   }
}