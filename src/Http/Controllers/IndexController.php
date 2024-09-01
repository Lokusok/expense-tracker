<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class IndexController
{
  public static function index()
  {
    if (! isAuth()) {
      redirect("/login");
    }

    View::make("index");
  }
}