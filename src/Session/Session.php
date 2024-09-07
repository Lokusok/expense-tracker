<?php

declare(strict_types=1);

namespace App\Session;

class Session
{
  const SESSION_KEY = 'auth';

  public static function isAuth(): bool
  {
    if (! isset($_SESSION[self::SESSION_KEY])) {
      return false;
    }

    return (bool)$_SESSION[self::SESSION_KEY];
  }

  public static function authorize(int|string $userId): bool
  {
    $_SESSION[self::SESSION_KEY] = $userId;
    return true;
  }

  public static function logout()
  {
    $params = session_get_cookie_params();

    setcookie(
      session_name(), '', time() - 100,
      $params['path'], $params['domain'],
      $params['secure'], $params['httponly']
    );
    
    session_destroy();

    return redirect("/");
  }

  public static function get(string $key): mixed
  {
    if (!array_key_exists(self::SESSION_KEY, $_SESSION)) {
      return false;
    }

    switch ($key) {
      case "id": {
        return $_SESSION[self::SESSION_KEY];
      }
    }

    return false;
  }
}
