<?php
namespace lib;

class Config {

  static function getJson($path){
    return json_decode(file_get_contents(APPDIR."/$path"),true);
  }

}