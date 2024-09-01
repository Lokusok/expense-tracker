<?php

declare(strict_types=1);

namespace App\View;

class View
{
  public static function make(string $path, ?array $attrs = null): void
  {
    if (is_array($attrs)) {
      foreach ($attrs as $toExpose => $value) {
        $$toExpose = $value;
      }
    }

    $filename = str_ends_with($path, ".php") ? $path : $path . ".view.php";

    $fullPath = ASSETS_PATH . "/" . $filename;
    require $fullPath;
  }
}
