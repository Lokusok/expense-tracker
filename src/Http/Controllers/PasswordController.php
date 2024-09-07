<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Containers\Email\EmailContainer;
use App\Http\Models\User;
use App\Session\Session;
use App\View\View;

use DateInterval;
use DateTime;

class PasswordController
{
  public static function recoverPassword()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $date = new DateTime();

    $date->add(DateInterval::createFromDateString('1 day'));

    $passwordRecoverId = uniqid();
    $passwordRecoverExpire = $date->format('Y-m-d H:i:s');

    User::setPasswordRecovering((string)Session::get('id'), [
      'password_recover_id' => $passwordRecoverId,
      'password_recover_expire' => $passwordRecoverExpire, 
    ]);

    $user = User::find((string)Session::get('id'));
    $recoverUrl = getCurrentUrl() . "/profile/recover?token=$passwordRecoverId";

    // Отправка сообщения
    try {
      $smtpClient = EmailContainer::get('smtp');
  
      $smtpClient->setFrom('expense@tracker.com', 'ExpTracker');
      $smtpClient->addAddress($user['email']);
  
      $smtpClient->isHTML(true);
      $smtpClient->Subject = 'Change password';
      $smtpClient->Body = "Для смены пароля, пройдите по следующей ссылке: $recoverUrl";
  
      $smtpClient->send();
      echo "Message has been sent";
    } catch (\Exception $e) {
      echo "Message could not be sent. Mailer Error: {$smtpClient->ErrorInfo}";
    }

    return redirect("/profile");
  }

  public static function recover()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $urlToken = normalize($_GET['token']);
    $user = User::find((string)Session::get('id'));

    // Неверный токен восстановления
    if ($user['password_recover_id'] !== $urlToken) {
      return redirect("/profile");
    }

    $currentDate = new DateTime();
    $expireDate = new DateTime($user['password_recover_expire']);

    $isExpire = $currentDate > $expireDate;

    // Срок восстановления пароля истёк
    if ($isExpire) {
      User::setPasswordRecovering(Session::get('id'), [
        'password_recover_id' => '',
        'password_recover_expire' => $currentDate, 
      ]);

      return redirect("/profile");
    }

    return View::make("password-recover", [
      "user" => $user
    ]);
  }

  public static function changePassword()
  {
    if (! isAuth()) {
      return redirect("/login");
    }

    $password = normalize($_POST['password']);

    $isPasswordSmall = strlen($password) < 6;

    if ($isPasswordSmall) {
      setFlushMessages([
        'error_recover_password' => 'Пароль должен быть сложнее (от 7 символов)'
      ]);

      redirect($_SERVER['HTTP_REFERER']);
      return;
    }

    // Меням пароль на новый
    $user = User::find((string)Session::get('id'));

    User::setPassword($user['id'], password_hash($password, PASSWORD_BCRYPT));

    User::setPasswordRecovering($user['id'], [
      'password_recover_id' => null,
      'password_recover_expire' => $user['password_recover_expire']
    ]);

    setFlushMessages([
      'profile_success_message' => 'Пароль успешно изменён'
    ]);

    return redirect("/profile");
  }
}
