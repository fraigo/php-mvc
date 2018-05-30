<?php

namespace controllers;

class AdminController extends DefaultController{

  function actionIndex(){
    echo $this->renderLayout("admin/list",$this->getViewData());
  }

  function actionUpdate(){
    if($_POST["app"]){
      Config::saveJson("app.json",$_POST["database"]);
    }
    if($_POST["database"]){
      Config::saveJson("database.json",$_POST["database"]);
    }
  }

  function getViewData(){
    $data=parent::getViewData();
    $data["config"]=\lib\Config::getJson("app.json");
    $data["database"]=\lib\Config::getJson("db.json");
    return $data;
  }

  
}