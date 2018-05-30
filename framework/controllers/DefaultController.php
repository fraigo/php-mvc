<?php

namespace controllers;

class DefaultController{

  protected $app;
  protected $action;
  protected $route;
  protected $basepath;

  function __construct(){
    
  }

  function route($route){
    return "$this->basepath/$route";
  }

  function setup($app,$route,$action,$basepath){
    $this->app = $app;
    $this->route = $route;
    $this->action = $action;
    $this->basepath = $basepath;
  }

  function actionIndex(){
    echo $this->renderLayout("default/list",$this->getViewData());
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
    return $this->renderView("layout/index",[
      "content"=>$this->renderView($view,$data)
    ]);
  }

  function getViewData(){
    $data=[];
    return $data;
  }

  
}