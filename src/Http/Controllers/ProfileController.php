<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Models\User;
use App\Session\Session;
use App\View\View;
use DateInterval;
use DateTime;

class ProfileController
{
  public static function index()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $user = User::find(Session::get('id'));

    return View::make("profile", [
      'user' => $user,
      'isRecoveringPassword' => (bool)$user['password_recover_id']
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

    // Достаём и грузим аватарку
    $fileId = uniqid();
    $fileName = $fileId . ".jpg";
    
    move_uploaded_file($_FILES['avatar']['tmp_name'], ASSETS_IMAGES . "/$fileName");

    User::update($id, [
      'email' => $email,
      'full_name' => $username,
      'avatar_url' => $fileName
    ]);

    return redirect("/profile");
  }

  public static function recoverPassword()
  {
    $date = new DateTime();

    $date->add(DateInterval::createFromDateString('1 day'));

    $passwordRecoverId = uniqid();
    $passwordRecoverExpire = $date->format('Y-m-d H:i:s');

    // dd($passwordRecoverId, $passwordRecoverExpire);

    User::setPasswordRecovering((string)Session::get('id'), [
      'password_recover_id' => $passwordRecoverId,
      'password_recover_expire' => $passwordRecoverExpire, 
    ]);

    return redirect("/profile");
  }
}
