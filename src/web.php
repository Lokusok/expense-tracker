<?php

define("ASSETS_PATH", __DIR__ . "/resources");

require __DIR__ . "/functions.php";

use App\Http\Router\Router;

use App\Http\Controllers\SessionController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ExpensesController;

use App\Containers\Database\DatabaseContainer;
use App\Http\Controllers\ProfileController;

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dsn = "mysql:host={$_ENV['DB_HOST']};port={$_ENV['DB_PORT']};dbname={$_ENV['DB_NAME']}";

DatabaseContainer::set('db', new \PDO($dsn, $_ENV['DB_USER'], $_ENV['DB_PASSWORD']));

$router = new Router();

$router->get("/", [IndexController::class, 'index']);

$router->get("/expenses", [ExpensesController::class, 'index']);
$router->post("/expenses", [ExpensesController::class, 'store']);
$router->delete("/expenses/delete", [ExpensesController::class, 'destroy']);
$router->put("/expenses/edit", [ExpensesController::class, 'edit']);

$router->get("/profile", [ProfileController::class, 'index']);

$router->get("/login", [SessionController::class, 'index']);
$router->post("/login", [SessionController::class, 'login']);
$router->delete("/logout", [SessionController::class, 'logout']);

$router->get("/register", [RegisterController::class, 'index']);
$router->post("/register", [RegisterController::class, 'store']);


$method = $_SERVER["REQUEST_METHOD"];
$url = explode("?", $_SERVER["REQUEST_URI"])[0];

if (isset($_POST["_method"])) {
  $method = $_POST["_method"];
}

$router->resolve($url, strtolower($method));
