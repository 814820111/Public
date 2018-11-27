<?php

function p($val)
{
  echo "<pre>";
  print_r($val);
  echo "<pre>";
}


//截取某个字符前的所有字符串
function strsize($class,$str)
{
    return  substr($class,0,strrpos($class,$str));

}