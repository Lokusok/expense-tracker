<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;
use App\Http\Models\User;
use App\Session\Session;

class RegisterController
{
  public static function index()
  {
    clearFlushMessages([
      'old_login_email',
      'error_login_email',
      'error_login_password'
    ]);

    if (Session::isAuth()) {
      redirect("/");
      return;
    }

    View::make("auth/register");
  }

  public static function store()
  {
    $email = normalize($_POST['email']);
    $username = normalize($_POST['username']);
    $password = normalize($_POST['password']);
    $passwordConfirmation = normalize($_POST['password_confirmation']);

    $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (! $isEmailValid) {
      setFlushMessages([
        'old_register_email' => $email,
        'old_register_username' => $username,
        'error_register_email' => 'Неккоректная почта',
      ]);

      redirect('/register');
      return;
    }

    $isUsernameSmall = strlen($username) < 5;

    if ($isUsernameSmall) {
      setFlushMessages([
        'old_register_email' => $email,
        'old_register_username' => $username,
        'error_register_username' => 'Имя должно быть больше 5 символов!'
      ]);

      redirect('/register');
      return;
    }
    
    $isPasswordSmall = strlen($password) < 6;

    if ($isPasswordSmall) {
      setFlushMessages([
        'old_register_email' => $email,
        'old_register_username' => $username,
        'error_register_password' => 'Пароль должен быть сложнее (от 7 символов)'
      ]);

      redirect('/register');
      return;
    }

    $isPasswordsEquals = strcmp($password, $passwordConfirmation);

    if ($isPasswordsEquals !== 0) {
      setFlushMessages([
        'old_register_email' => $email,
        'old_register_username' => $username,
        'error_register_password' => 'Пароли не равны'
      ]);

      redirect('/register');
      return;
    }

    $userId = User::create([
      'email' => $email,
      'full_name' => $username,
      'password' => password_hash($password, PASSWORD_BCRYPT),
      'avatar_url' => 'default-avatar.jpg'
    ]);

    if (gettype($userId) === "boolean") {
      setFlushMessages([
        'old_register_email' => $email,
        'old_register_username' => $username,
        'error_register_email' => 'Ошибка при создании пользователя',
        'error_register_username' => 'Ошибка при создании пользователя'
      ]);

      redirect("/register");
      return;
    }

    redirect("/login");
  }
}
