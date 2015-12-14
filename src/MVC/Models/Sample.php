<?php

namespace Models;

use \Slim\PDO\Database;

class Sample
{

  protected $dbInstance;

  public function __construct()
  {
    global $config;

    $dbConfig = $config->database;

    $dsn = $dbConfig->db_driver . ':host=' . $dbConfig->db_host . ';dbname=' . $dbConfig->db_name . ';charset=utf8';
    return $this->dbInstance = new Database($dsn, $dbConfig->db_username, $dbConfig->db_password);
  }

  public function getAll()
  {
    $selectStatement = $this->dbInstance->select()->from('sample');
    $stmt = $selectStatement->execute();
    return $stmt->fetchAll();
  }

  public function deleteOne($idSample)
  {
    $deleteStatement = $this->dbInstance->delete()->from('sample')
      ->where('sample_id', '=', $idSample);
    return $deleteStatement->execute();
  }

  public function getOne($idSample)
  {
    $selectStatement = $this->dbInstance->select()->from('sample')
      ->where('sample_id', '=', $idSample);
    $stmt = $selectStatement->execute();
    return $stmt->fetch();
  }


}
