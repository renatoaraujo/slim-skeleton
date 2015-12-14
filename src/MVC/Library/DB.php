<?php

namespace Library;

use \Slim\PDO\Database;

class DB
{

  public static function instance()
  {
    global $config;
    $dbConfig = $config->database;

    $dsn = $dbConfig->db_driver . ':host=' . $dbConfig->db_host . ';dbname=' . $dbConfig->db_name . ';charset=utf8';
    return new Database($dsn, $dbConfig->db_username, $dbConfig->db_password);
  }
}
