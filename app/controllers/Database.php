<?php

class Database
{
  public function getRecords()
  {
    $sampleModel = new Sample();

    return $sampleModel->getAll();
  }

  public function deleteRecord($idRecord)
  {
    $sampleModel = new Sample();

    return $sampleModel->deleteOne($idRecord);
  }
}
