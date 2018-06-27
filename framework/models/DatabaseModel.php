<?php

namespace models;

class DataBaseModel extends DataModel {

    var $table;

    function __construct($table){
        $this->table = $table;
    }

    public static function find($id){
        $row=App::db()->row("SELECT * from $this->table WHERE id=$id");
        return $row;
    }

}