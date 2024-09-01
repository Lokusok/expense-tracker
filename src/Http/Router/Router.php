<?php

declare(strict_types=1);

namespace App\Http\Router;

class Router
{
  private array $routes = [
    'get' => [],
    'post' => [],
    'delete' => [],
  ];

  public function get(string $path, callable|array $fn): void
  {
    $this->routes['get'][$path] = $fn;
  }

  public function post(string $path, callable|array $fn): void
  {
    $this->routes['post'][$path] = $fn;
  }

  public function delete(string $path, callable|array $fn): void
  {
    $this->routes['delete'][$path] = $fn;
  }

  public function resolve(string $path, string $method): void
  {
    $isCss = str_ends_with($path, ".css");

    if ($isCss) {
      header("Content-Type: text/css;");
      echo file_get_contents(ASSETS_PATH . "/css/style.css");
      return;
    }

    if (isset($this->routes[$method][$path])) {
      call_user_func($this->routes[$method][$path]);
    }
  }
}
