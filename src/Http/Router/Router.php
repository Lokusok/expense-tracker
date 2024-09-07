<?php

declare(strict_types=1);

namespace App\Http\Router;

class Router
{
  private array $routes = [
    'get' => [],
    'post' => [],
    'delete' => [],
    'put' => [],
    'patch' => []
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

  public function put(string $path, callable|array $fn): void
  {
    $this->routes['put'][$path] = $fn;
  }

  public function patch(string $path, callable|array $fn): void
  {
    $this->routes['patch'][$path] = $fn;
  }

  public function resolve(string $path, string $method): void
  {
    $isCss = str_ends_with($path, ".css");
    $isImage = str_ends_with($path, ".jpg");
    $isFavicon = str_ends_with($path, ".ico");

    $splittedPath = explode("/", $path);
    $assetName = $splittedPath[count($splittedPath) - 1];

    if ($isCss) {
      header("Content-Type: text/css;");
      echo file_get_contents(ASSETS_PATH . "/css/$assetName");
      return;
    }

    if ($isImage) {
      header("Content-Type: image/jpg;");
      echo file_get_contents(ASSETS_PATH . "/images/$assetName");
      return;
    }

    if ($isFavicon) {
      header("Content-Type: image/ico;");
      echo file_get_contents(ASSETS_PATH . "/images/$assetName");
      return;
    }

    if (isset($this->routes[$method][$path])) {
      call_user_func($this->routes[$method][$path]);
    }
  }
}
