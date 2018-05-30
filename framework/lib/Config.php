<?php
namespace lib;

class Config {

  static function fileName($path,$base=null){
    if ($base===NULL){
      $base=APPDIR;
    }
    $path="$base/$path";
    return $path;
  }

  static function getJson($path){
    return json_decode(file_get_contents(Config::filename($path)),true);
  }

  static function saveJson($path,$data){
    file_put_contents(Config::filename($path),json_encode($data,JSON_PRETTY_PRINT));
  }

}