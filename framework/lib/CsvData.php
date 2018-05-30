<?php

namespace lib;

class CsvData{

    public static function parse($path,$header=[]){
        $data=[];
        $filename=Config::fileName($path);
        $f=fopen($filename,"r");
        if(count($header)==0){
            $header=fgetcsv($f,0,",");
        }
        while($csvrow=fgetcsv($f,0,",")){
            $row=[];
            foreach($csvrow as $index=>$value){
                $row[$header[$index]?:"field$index"]=$value;
            }
            $data[]=$row;
        }
        return $data;
    }


}