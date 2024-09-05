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

    $searchQuery = '';

    if (isset($_GET['q'])) {
      $searchQuery = normalize($_GET['q']);
    }

    $tags = Tag::all();
    $expenses = Expense::all([
      'q' => $searchQuery
    ]);

    View::make("expenses", [
      "tags" => $tags,
      "expenses" => $expenses
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

    return redirect("/expenses");
  }

  public static function destroy()
  {
    if (! isAuth()) {
      return redirect("/login");
    }
    
    $id = normalize($_GET["id"]);
    
    $result = Expense::delete($id);

    return redirect("/expenses");
  }

  public static function edit()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $id = normalize($_POST['expense_id']);

    $expenseUpdate = [
      'title' => normalize($_POST['expense_title']),
      'price' => normalize($_POST['expense_price']),
      'description' => normalize($_POST['expense_descr']),
      'category_id' => normalize($_POST['expense_category'])
    ];

    Expense::update($id, $expenseUpdate);

    return redirect("/expenses");
  }
}