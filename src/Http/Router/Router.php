<?php

declare(strict_types=1);

namespace App\Http\Router;

class Router
{
  private array $routes = [];

  public function get(string $path, callable $fn)
  {
    $this->routes[$path] = $fn;
  }

  public function resolve(string $path)
  {
    $isCss = str_ends_with($path, ".css");
    
    if ($isCss) {
      header("Content-Type: text/css;");
      echo file_get_contents(ASSETS_PATH . "/css/style.css");
      return;
    }

    if (isset($this->routes[$path])) {
      call_user_func($this->routes[$path]);
    }
  }
}
