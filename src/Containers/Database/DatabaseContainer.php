<?php

declare(strict_types=1);

namespace App\Containers\Database;

use App\Containers\BasicContainer;

class DatabaseContainer extends BasicContainer
{
  private static array $attrs;

  public static function get(string $key)
  {
    return self::$attrs[$key];
  }

  public static function set(string $key, mixed $val)
  {
    self::$attrs[$key] = $val;
  }
}
