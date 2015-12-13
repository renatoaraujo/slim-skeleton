<?php

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'home.html');
})->setName('home');

$app->get('/database', function ($request, $response, $args) {

  $database = new Database();
  $records = $database->getRecords();

  return $this->view->render($response, 'database.html', [
      'records' => $records,
      'pageTitle' => 'Sample List',
  ]);
})->setName('database');

$app->delete('/database/{id}', function($request, $response, $args) {
  $database = new Database();
  $deleteSample = $database->deleteRecord($args['id']);

  if(!$deleteSample) {
    $response = $response->withStatus(400);
  }

  return $response;
});
