<?php

use Core\Router;

const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . 'Core/router.php';
require BASE_PATH . 'vendor/autoload.php';

session_start();


require BASE_PATH . 'Core/functions.php';

header('Content-Type: text/html; charset=utf-8'); 

require base_path('bootstrap.php');

$router = new Router(); 

$routes = require base_path("routes.php");

$uri = parse_url($_SERVER['REQUEST_URI'])['path'];
$method = $_POST['REQUEST_METHOD'] ?? $_SERVER['REQUEST_METHOD'];

$router->routes($uri, $method);

?>