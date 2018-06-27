<?php

namespace commands;

class Schema extends BaseCommand {


    function __construct(){
        
    }

    function getFieldName($field){
        return $field["name"];
    }

    function getFieldType($field){
        $types["string"]="varchar(255)";
        $types["text"]="text";
        $types["integer"]="int";
        return $types[$field["type"]]?:$types["string"];
    }

    function run($app,$params){
        $entities=\lib\Config::getJson("data.json")["entities"];
        foreach($entities as $entity=>$data){
            $fields=[];
            if ($data["autoincrement"]){
                $fields[]="id int AUTO_INCREMENT";
            }
            foreach($data["fields"] as $pos=>$field){
                $fields[]=$this->getFieldName($field)." ".$this->getFieldType($field);
            }
            $fieldList=implode(", ",$fields);
            $sql="CREATE TABLE $entity ( $fieldList )";
            $app->db()->query($sql);
        }
    }

}
