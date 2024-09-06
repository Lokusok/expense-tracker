<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Session\Session;
use App\View\View;

class ProfileController
{
  public static function index()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $user = User::find(Session::get('id'));

    return View::make("profile", [
      'user' => $user
    ]);
  }

  public static function update()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $id = normalize($_GET['id']);
    $email = normalize($_POST['email']);
    $username = normalize($_POST['username']);

    User::update($id, [
      'email' => $email,
      'full_name' => $username
    ]);

    return redirect("/profile");
  }
}
