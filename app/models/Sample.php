<?php

class Sample
{

  protected $dbInstance;

  public function __construct()
  {
    global $config;

    $dbConfig = $config->database;

    $dsn = $dbConfig->db_driver . ':host=' . $dbConfig->db_host . ';dbname=' . $dbConfig->db_name . ';charset=utf8';
    return $this->dbInstance = new \Slim\PDO\Database($dsn, $dbConfig->db_username, $dbConfig->db_password);
  }

  public function getAll()
  {
    $selectStatement = $this->dbInstance->select()->from(strtolower(get_class($this)));
    $stmt = $selectStatement->execute();
    return $stmt->fetchAll();
  }

  public function deleteOne($idSample)
  {
    $deleteStatement = $this->dbInstance->delete()->from(strtolower(get_class($this)))
      ->where(strtolower(get_class($this)) . '_id', '=', $idSample);
    return $deleteStatement->execute();
  }


}
