<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class ProfileController
{
  public static function index()
  {
    return View::make("profile");
  }
}
