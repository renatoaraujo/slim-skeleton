<?php


spl_autoload_register(function($className){
    if (file_exists(APPPATH . "/app/models/" . $className . ".php")) {
       require_once APPPATH . "/app/models/" . $className . ".php";
    } elseif (file_exists(APPPATH . "/app/controllers/" . $className . ".php")) {
       require_once APPPATH . "/app/controllers/" . $className . ".php";
    }
});
