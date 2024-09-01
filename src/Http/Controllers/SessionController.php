<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class SessionController
{
  public static function index()
  {
    View::make("auth/login");
  }
}
