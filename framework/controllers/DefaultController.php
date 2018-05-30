<?php

namespace controllers;

class DefaultController{

  protected $app;
  protected $action;
  protected $route;
  protected $basepath;

  function __construct(){
    
  }

  function route($route,$params=[]){
    list($route,$action)=explode("/",$route);
    if ($route==""){
      $route=$this->route;
    }
    $extra="";
    if (count($params)){
      $extra="?".http_build_query($params);
    }
    return "$this->basepath/$route/$action$extra";
  }

  function setup($app,$route,$action,$basepath){
    $this->app = $app;
    $this->route = $route;
    $this->action = $action;
    $this->basepath = $basepath;
  }

  function actionIndex(){
    echo $this->renderLayout("default/index",$this->getViewData());
  }

  function actionEdit($params=[]){
    echo $this->renderLayout("default/edit",$this->getViewData($params));
  }


  function redirect($route,$params=[]){
    $route=$this->route($route,$params);
    header("Location: $route");
  }

  function renderView($_name,$_data){
    foreach($_data as $key=>$value){
      $$key = $value;
    }
    $controller=$this;
    ob_start();
    include(BASEDIR."/views/$_name.html");
    return ob_get_clean();
  }

  function renderLayout($view,$data){
    $layoutData=\lib\Config::getJson("app.json");
    $layoutData["content"]=$this->renderView($view,$data);
    return $this->renderView("layout/index", $layoutData);
  }

  function getViewData(){
    $data=[];
    return $data;
  }

  
}