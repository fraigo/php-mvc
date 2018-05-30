<?php

namespace models;

class DataModel extends BaseModel {

    private $data;
    private $header;

    function __construct(){

    }

    function setData($data,$header=null){
        $this->data=$data;
    }

}