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
    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordConfirmation = $_POST['password_confirmation'];

    $isEmailValid = filter_var($email, FILTER_VALIDATE_EMAIL);

    if (! $isEmailValid) {
      setFlushMessages([
        'old_email' => $email,
        'old_username' => $username,
        'error_email' => 'Неккоректная почта',
      ]);

      redirect('/register');
      return;
    }

    $isUsernameSmall = strlen($username) < 5;

    if ($isUsernameSmall) {
      setFlushMessages([
        'old_email' => $email,
        'old_username' => $username,
        'error_username' => 'Имя должно быть больше 5 символов!'
      ]);

      redirect('/register');
      return;
    }
    
    $isPasswordSmall = strlen($password) < 6;

    if ($isPasswordSmall) {
      setFlushMessages([
        'old_email' => $email,
        'old_username' => $username,
        'error_password' => 'Пароль должен быть сложнее (от 7 символов)'
      ]);

      redirect('/register');
      return;
    }

    $isPasswordsEquals = strcmp($password, $passwordConfirmation);

    if ($isPasswordsEquals !== 0) {
      setFlushMessages([
        'old_email' => $email,
        'old_username' => $username,
        'error_password' => 'Пароли не равны'
      ]);

      redirect('/register');
      return;
    }

    $db = new \PDO("mysql:host=172.21.0.1;port=4422;dbname=full", "root", "");

    $db->beginTransaction();

    try {
      $statement = $db->prepare("INSERT INTO users (email, full_name, password, avatar_url) VALUES (:email, :full_name, :password, :avatar_url)");
      $statement->execute([
        ':email' => $email,
        ':full_name' => $username,
        ':password' => password_hash($password, PASSWORD_BCRYPT),
        ':avatar_url' => 'https://fastly.picsum.photos/id/29/200/300'
      ]);

      $id = $db->lastInsertId();

      $db->commit();
      
      dd($id, 'OK');
      return;
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    dd("All ok", [
      'email' => $email,
      'password' => $password,
      'password_confirmation' => $passwordConfirmation
    ]);
  }
}
