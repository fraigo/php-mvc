<?
namespace lib;

class App {

  private $config = [];
  private $databaseConfig;
  private $databases;
  
  function __construct(){
    $this->config = Config::getJson("app.json");
    $this->databaseConfig = Config::getJson("db.json");
    foreach($this->databaseConfig["connections"] as $name=>$db){
      $this->databases[$name] = Database::connect($this->databaseConfig["connections"][$name]);
    }
  }

  function db($name=null){
    $names=array_keys($this->databaseConfig["connections"]);
    if ($name===null){
      $name=$this->databaseConfig["default"]?:$names[0];
    }
    return $this->databases[$name];
  }

  function executeController(){
    list($dummy,$controller,$action,$parameters)=explode("/",$_SERVER["PATH_INFO"]);
    
    if ($action==""){
      $action="index";
    }
    $action=ucfirst($action);

    if ($controller==""){
      $controller = "default";
    }
    $controller=ucfirst($controller);
    
    $params=$_GET;

    $controllerClass="controllers\\{$controller}Controller";
    $actionMethod="action$action";
    $controller = new $controllerClass();
    $controller->setApp($this);

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

}