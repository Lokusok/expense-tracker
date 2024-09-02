<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;
use App\Http\Models\Expense;
use App\Http\Models\Tag;

class ExpensesController
{
  public static function index()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $tags = Tag::all();

    View::make("expenses", [
      "tags" => $tags
    ]);
  }

  public static function store()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $title = normalize($_POST["expense_title"]);
    $price = normalize($_POST["expense_price"]);
    $descr = normalize($_POST["expense_descr"]);
    $category = normalize($_POST["expense_category"]);

    $id = Expense::create([
      "title" => $title,
      "price" => $price,
      "descr" => $descr,
      "category" => $category
    ]);

    dd($id);
  }
}