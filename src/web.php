<?php

define("ASSETS_PATH", __DIR__ . "/resources");

require __DIR__ . "/functions.php";

use App\Http\Router\Router;
use App\View\View;

$router = new Router();

$router->get("/", function() {
  View::make("index.view", [
    "description" => "Lorem ipsum"
  ]);
});

$router->get("/about", function() {
  View::make("about.view");
});

$router->resolve($_SERVER["REQUEST_URI"]);
