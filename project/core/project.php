<?php

namespace core;
header("Content-type: text/html; charset=utf-8");
class project
{

    public static $classMap = array();
    public $assign;
    static public function run()
    {
//        p('ok');
//        var_dump($classMap);

        \core\lib\log::init();
        \core\lib\log::log($_SERVER,"server");
        $route = new \core\lib\route();

        var_dump($route);

        $ctrlClass = $route->ctrl;
        $action = $route->action;
        $ctrlfile = APP.'/ctrl/'.$ctrlClass.'Ctrl.php';

        $cltrlClass = '\\'.MODULE . '\ctrl\\'.$ctrlClass.'Ctrl';


//        p($ctrlfile);
        if(is_file($ctrlfile))
        {
            include $ctrlfile;
         $ctrl =  new $cltrlClass();
         $ctrl->$action();
         \core\lib\log::log('ctrl:'.$ctrlClass.'     '.'action:'.$action);
        }else{
            throw new \Exception('找不到控制器'.$ctrlClass);
        }
//          p($route);
    }
    static public function load($class)
    {
        //自动加载
        // new \core\route();
        //$class = '\core\route';
//        PROJECT.'/core/route.php'


//    p($class);
//    echo "<br>";
//    p(PROJECT.$class.'.php');

     if(isset($classMap[$class]))
     {
         return true;
     }else{
         $class =  str_replace('\\','/',$class);
         $file = PROJECT.$class.'.php';


         if(is_file($file))
         {
             include $file;

             self::$classMap[$class] = $class;
         }else{

             return false;
         }
      }

    }

    public function assign($name,$value)
    {
        $this->assign[$name] = $value;

    }

    public function display($file)
    {
        $file = APP.'/views/'.$file;
        if(is_file($file))
        {
            extract($this->assign);
             //  p($this->assign);
            include $file;
        }

    }
}