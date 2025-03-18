<?php
use App\Controllers\UserController;
use App\Controllers\RideController;
use App\Controllers\FileController;

$router->get('/users', [UserController::class, 'index']);
$router->post('/users', [UserController::class, 'store']);
$router->get('/users/{id}', [UserController::class, 'show']);
$router->put('/users/{id}', [UserController::class, 'update']);
$router->delete('/users/{id}', [UserController::class, 'destroy']);

$router->post('/upload', [FileController::class, 'upload']);
