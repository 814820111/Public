<?php

/**
 * 入口文件
 *
 *
 */
//定义项目文件
define('PROJECT',realpath(' /'));
define('CORE',PROJECT.'/core');
define('APP',PROJECT.'app');
define('MODULE','app');
//开启错误报告
define('DEBUG',true);

include "vendor/autoload.php";
if(DEBUG)
{
    $whoops = new \Whoops\Run;
    $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    ini_set('display_error','On');
}else{
    ini_set('display_error','off');
}


include CORE.'/common/function.php';
include CORE.'/project.php';
$p = "PROJECT";
$is1 = defined($p);






spl_autoload_register('\core\project::load');

\core\project::run();
//P('heiheihei');
