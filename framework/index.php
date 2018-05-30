<?php

error_reporting(E_ALL & ~E_NOTICE);

define("BASEDIR",realpath(dirname(__FILE__)));
define("APPDIR",realpath(BASEDIR."/../app/"));

function class_to_path($class_name){
  $parts=explode("\\",$class_name);
  $path=(implode("/",$parts));
  return $path;
}

spl_autoload_register(function ($class_name) {
  $path=BASEDIR."/".class_to_path($class_name).".php";
  require_once($path);
});


$app = new \lib\App();