<?php

namespace controllers;

use lib\Config;

class AdminController extends DefaultController{

  private $configs=["app","db","data"];

  function actionIndex(){
    echo $this->renderLayout("admin/index",$this->getViewData());
  }

  function actionUpdate(){
    if($_POST["app"]){
      Config::saveJson("app.json",$_POST["app"]);
    }
    if($_POST["db"]){
      Config::saveJson("db.json",$_POST["db"]);
    }
    $this->redirect("admin/index");
  }

  function getViewData(){
    $data=parent::getViewData();
    foreach($this->configs as $config){
      $data[$config]=\lib\Config::getJson("$config.json");
    }
    return $data;
  }

  
}