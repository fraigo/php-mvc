<?php

namespace controllers;

use lib\Config;
use lib\CsvData;

class CategoryController extends DefaultController{

    function getViewData($params=[]){
        $data=parent::getViewData();
        $data["items"]=CsvData::parse("data/categories.csv");
        $data["item"]=$data["items"][$params["id"]];
        return $data;
    }

}