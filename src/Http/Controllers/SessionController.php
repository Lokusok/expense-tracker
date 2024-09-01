<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;
use App\Http\Models\User;
use App\Session\Session;

class SessionController
{
  public static function index()
  {
    clearFlushMessages([
      'old_register_email',
      'old_register_username',
      'error_register_email',
      'error_register_username',
      'error_register_password'
    ]);

    if (Session::isAuth()) {
      redirect("/");
      return;
    }

    View::make("auth/login");
  }

  public static function login()
  {
    $email = normalize($_POST['email']);
    $password = normalize($_POST['password']);
    
    $user = User::findByEmail($email);

    if (! $user) {
      setFlushMessages([
        'old_login_email' => $email,
        'error_login_email' => 'Ошибка при входе'
      ]);

      redirect("/login");
      return;
    }

    $isCorrectPassword = password_verify($password, $user['password']);

    if (! $isCorrectPassword) {
      setFlushMessages([
        'old_login_email' => $email,
        'error_login_email' => 'Ошибка при входе'
      ]);

      redirect("/login");
      return;
    }

    Session::authorize($user['id']);

    redirect("/");
  }

  public static function logout()
  {
    if (! Session::isAuth()) {
      return redirect("/");
    }

    Session::logout();
  }
}
