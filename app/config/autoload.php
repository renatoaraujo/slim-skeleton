<?php

function autoloadModel($className) {
    $filename = APPPATH . "/app/models/" . $className . ".php";
    if (file_exists($filename)) {
      require_once $filename;
    }
}

function autoloadController($className) {
    $filename = APPPATH . "/app/controllers/" . $className . ".php";
    if (file_exists($filename)) {
      require_once $filename;
    }
}

spl_autoload_register("autoloadModel");
spl_autoload_register("autoloadController");
