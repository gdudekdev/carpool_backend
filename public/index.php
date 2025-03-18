<!-- Point d'entrée, redirection via le router -->
<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../core/Router.php';

use Core\Router;

$router = new Router();
require_once __DIR__ . '/../routes/api.php'; // Inclusion des routes

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);