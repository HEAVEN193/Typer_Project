<?php

use Matteomcr\TyperProject\Controllers\HomeController;
use Matteomcr\TyperProject\Controllers\AuthController;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;



$app->get('/', [HomeController::class, 'showHomePage']);
$app->get('/register', [HomeController::class, 'showRegisterPage']);
$app->get('/login', [HomeController::class, 'showLoginPage']);
$app->get('/user', [HomeController::class, 'showUserPage']);

$app->post('/create-account', [AuthController::class, 'createAccount']);
$app->post('/login-attempt', [AuthController::class, 'login']);






// $app->get('/', function (Request $request, Response $response, $args) {
//     $response->getBody()->write('<p>Bonjour le monde</p>');
//     return $response;
//     });