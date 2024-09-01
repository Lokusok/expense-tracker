<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class ExpensesController
{
  public static function index()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    View::make("expenses");
  }
}