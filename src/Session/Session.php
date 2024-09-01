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
    dd("[SESSIOn] LOGOUT");
  }
}
