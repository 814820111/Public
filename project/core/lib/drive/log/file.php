<?php
namespace core\lib\drive\log;
use core\lib\conf;
class file
{
    public $path;//日志存储位置
    public function __construct()
    {
        $conf = conf::get('OPTION','log');
        $this->path = $conf['PATH'];
    }

    public function log($message,$file = 'log')
    {
      /**
       * 1.确定文件的存储位置
       *  新建目录
       * 2.写入日志
       */
      p($this->path);
       if(!is_dir($this->path.date("YmdH")))
       {
          echo   mkdir($this->path.date("YmdH"),'0777',true);

       }

      return  file_put_contents($this->path.date("YmdH").'/'.$file.'.php',date("Y-m-d H:i:s").json_encode($message).PHP_EOL,FILE_APPEND);

    }
}