<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/HelloController.php';
require __DIR__ . '/controllers/AlunniController.php';

$app = AppFactory::create();

//$app->get('/hello', "HelloController:hello");

//$app->get('/hello/{name}', "HelloController:hello_with_name");

//$app->get('/json/{name}', "HelloController:json_name");

$app->get('/alunni', "AlunniController:index");

$app->get('/alunni/{id}', "AlunniController:getAlunni");

$app->post('/alunno', "AlunniController:createAlunno");

$app->put('/alunno/{id}', "AlunniController:updateAlunno");

$app->delete('/alunno/{id}', "AlunniController:deleteAlunno");


$app->run();
