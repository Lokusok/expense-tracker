<?php

declare(strict_types=1);

namespace App\Http\Models;

abstract class BasicModel
{
  public function __get($name)
  {
    dd($name);
  }

  abstract public static function create(array $attrs);
}