<?php
use App\Controllers\AuthController;
use App\Controllers\UserController;
use Core\Auth;

$router->post('/register', [AuthController::class, 'register']);
$router->post('/login', [AuthController::class, 'login']);

// Routes sécurisées (nécessitent un token JWT)
$router->get('/users', function() {
    Auth::checkAuth(); // Vérification du token avant d’accéder à la ressource
    (new UserController())->index();
});
