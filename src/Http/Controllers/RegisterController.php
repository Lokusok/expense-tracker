<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\View\View;

class RegisterController
{
  public static function index()
  {
    View::make("auth/register");
  }

  public static function store()
  {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (! $isEmailValid) {
      redirect('/register');
      return;
    }

    $isPasswordsEquals = strcmp($password, $passwordConfirmation);

    if (! $isPasswordsEquals) {
      redirect('/register');
      return;
    }

    dd("All ok", [
      'email' => $email,
      'password' => $password,
      'password_confirmation' => $passwordConfirmation
    ]);
  }
}
