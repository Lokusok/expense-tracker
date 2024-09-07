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

    clearFlushMessages(['profile_success_message']);

    $searchQuery = '';
    $currentPage = normalize($_GET['page'] ?? '1');

    if (isset($_GET['q'])) {
      $searchQuery = normalize($_GET['q']);
    }

    $tags = Tag::all();
    $perPage = 5;
    
    [$expenses, $total] = Expense::all([
      "q" => $searchQuery,
      "limit" => $perPage,
      "offset" => ($currentPage - 1) * $perPage
    ]);

    // Если нет записей на текущей странице - уходим на предыдущую
    if (count($expenses) === 0 && $currentPage > 1) {
      $prevPage = $currentPage - 1;
      return redirect("/expenses?page=$prevPage");
    }

    $maxPage = ceil($total / $perPage);

    View::make("expenses", [
      "tags" => $tags,
      "expenses" => $expenses,
      "maxPage" => $maxPage,
      "currentPage" => $currentPage
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
      "category" => $category,
    ]);

    return redirect("/expenses");
  }

  public static function destroy()
  {
    if (! isAuth()) {
      return redirect("/login");
    }
    
    // $from = $_SERVER['HTTP_REFERER'];
    // $fromQuery = parse_url($from, PHP_URL_QUERY);
    // parse_str($fromQuery, $query);

    // $fromPage = $query['page'];

    $id = normalize($_GET["id"]);
    
    $result = Expense::delete($id);

    return redirect($_SERVER['HTTP_REFERER']);
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