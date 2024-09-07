<?php

declare(strict_types=1);

namespace App\Containers;

abstract class BasicContainer
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