<?php

namespace Models;

use Library\DB;

class Sample
{

  protected $dbInstance;

  public function __construct()
  {
    return $this->dbInstance = DB::instance();
  }

  /**
   * Function to get all records from table
   * @access public
   * @return array Records
   */
  public function getAll()
  {
    $selectStatement = $this->dbInstance->select()->from('sample');
    $stmt = $selectStatement->execute();
    return $stmt->fetchAll();
  }

  /**
   * Method to logical delete of table
   * @access public
   * @param int $idSample Identifier of the table
   */
  public function deleteOne($idSample)
  {
    $updateStatement = $this->dbInstance->update(array('sample_regstatus' => 0))
                       ->table('sample')
                       ->where('sample_id', '=', $idSample);
    return $updateStatement->execute();
  }

  public function getOne($idSample)
  {
    $selectStatement = $this->dbInstance->select()->from('sample')
      ->where('sample_id', '=', $idSample);
    $stmt = $selectStatement->execute();
    return $stmt->fetch();
  }


}
