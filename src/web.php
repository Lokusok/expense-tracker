<?php

define("ASSETS_PATH", __DIR__ . "/resources");

require __DIR__ . "/functions.php";

use App\Http\Router\Router;
use App\View\View;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\IndexController;

$router = new Router();

$router->get("/", [IndexController::class, 'index']);

$router->get("/about", function() {
  View::make("about");
});


$router->get("/login", [SessionController::class, 'index']);
$router->post("/login", [SessionController::class, 'login']);

$router->get("/register", [RegisterController::class, 'index']);
$router->post("/register", [RegisterController::class, 'store']);

$router->resolve($_SERVER["REQUEST_URI"], strtolower($_SERVER["REQUEST_METHOD"]));
