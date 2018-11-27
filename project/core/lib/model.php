<?php
namespace core\lib;
use core\lib\conf;

class model extends \medoo
{
    public function __construct()
    {
        $option  =conf::all('database');

       parent::__construct($option);

//      $database = conf::all('database');
//      p($database);
//        try{
//          parent::__construct($database['DSN'],$database['USERNAME'],$database['PASSWD']);
//        }catch(\PDOException $e){
//            p($e->getMessage());
//
//        }
    }

}