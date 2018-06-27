<?php
namespace lib;

class App {

  private $config = [];
  private $databaseConfig;
  private $databases;
  
  function __construct(){
    $this->config = Config::getJson("app.json");
    $this->databaseConfig = Config::getJson("db.json");
    foreach($this->databaseConfig["connections"] as $name=>$db){
      try{
        $this->databases[$name] = Database::connect($this->databaseConfig["connections"][$name]);
      }catch(\Exception $ex){
        echo $ex->getMessage();
        $this->databases[$name] = null;
      }
    }
  }

  function db($name=null){
    $names=array_keys($this->databaseConfig["connections"]);
    if ($name===null){
      $name=$this->databaseConfig["defaultConnection"]?:$names[0];
    }
    return $this->databases[$name];
  }

  function executeController(){
    $pathinfo=explode("/",$_SERVER["PATH_INFO"]);
    list($dummy,$controllerName,$action,$parameters)=$pathinfo;
    $basepath=dirname($_SERVER["SCRIPT_NAME"]);
    
    if ($action==""){
      $action="index";
    }
    $action=ucfirst($action);

    if ($controllerName==""){
      $controllerName = "default";
    }
    $controllerClass=ucfirst($controllerName)."Controller";
    
    $params=$_GET;

    $controllerClass="controllers\\{$controllerClass}";
    $actionMethod="action$action";
    $controller = new $controllerClass();
    $controller->setup($this,$controllerName,$action,$basepath);

    return $controller->$actionMethod($params);
  }

  static function getJson($path,$field=null){
    $data=json_decode(file_get_contents(BASEDIR."/".$path),true);
    if ($field){
      return $data[$field];
    }
    return $data;
  }

  function start(){
    $this->executeController();
  }

  function executeCommand($params){
    $scriptName = array_shift($params);
    $commandName = array_shift($params);
    $commandClass="\\commands\\$commandName";
    $command=new $commandClass();
    $command->run($this,$params);
  }

}