<?php

namespace controllers;

class AdminController extends DefaultController{

  function actionIndex(){
    echo $this->renderLayout("admin/list",$this->getViewData());
  }

  function getViewData(){
    $data=parent::getViewData();
    $data["config"]=\lib\Config::getJson("app.json");
    $data["db"]=\lib\Config::getJson("db.json");
    return $data;
  }

  
}