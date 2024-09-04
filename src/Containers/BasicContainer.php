<?php

declare(strict_types=1);

namespace App\Containers;

abstract class BasicContainer
{
  private static array $attrs;

  abstract public static function get(string $key);
  abstract public static function set(string $key, mixed $val);
}