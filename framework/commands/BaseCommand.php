<?php

namespace commands;

class BaseCommand {


    function __construct(){
        
    }

    function run($app,$params){
        die("Method run() Not implemented");
    }

}
