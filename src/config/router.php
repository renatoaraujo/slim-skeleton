<?php

use Controllers\Database;

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'home.html');
})->setName('home');

$app->get('/database', function ($request, $response, $args) {
  $database = new Database;
  $records = $database->getRecords();
  return $this->view->render($response, 'database.html', [
      'records' => $records,
      'pageTitle' => 'Sample List',
  ]);
})->setName('database');

$app->get('/database/new', function ($request, $response, $args) {
  $database = new Database;
  $records = $database->getRecords();
  return $this->view->render($response, 'new_database.html', [
      'pageTitle' => 'New Sample',
  ]);
})->setName('database');

$app->post('/database/new', function ($request, $response) {
  $database = new Database;

  echo '<pre>';
  print_r($request);
  exit;
});

$app->get('/database/{id}', function($request, $response, $args) {
  $database = new Database;
  $record = $database->getRecord($args['id']);
  if(empty($record)) {
    $return = $response->withStatus(404);
  } else {
    $return = $this->view->render($response, 'view_database.html', [
      'record' => $record,
    ]);
  }
  return $return;
})->setName('viewDatabase');

$app->delete('/database/{id}', function($request, $response, $args) {
  $database = new Database;
  $deleteSample = $database->deleteRecord($args['id']);
  if(!$deleteSample) {
    $response = $response->withStatus(404);
  }
  return $response;
});
