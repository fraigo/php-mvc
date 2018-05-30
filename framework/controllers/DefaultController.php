<?php

namespace controllers;

class DefaultController{

  protected $app;

  function setApp($app){
    $this->app = $app;
  }

  function actionIndex(){
    echo $this->renderLayout("default/list",$this->getViewData());
  }

  function renderView($name,$data){
    foreach($data as $key=>$value){
      $$key = $value;
    }
    $controller=$this;
    ob_start();
    include(BASEDIR."/views/$name.html");
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