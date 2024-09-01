<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class SessionController
{
  public static function index()
  {
    clearFlushMessages(['old_email', 'old_username', 'error_email', 'error_username', 'error_password']);

    View::make("auth/login");
  }
}
