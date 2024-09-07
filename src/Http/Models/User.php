<?php

declare(strict_types=1);

namespace App\Http\Models;

use App\Containers\Database\DatabaseContainer;

class User
{
  public static function create(array $attrs): int|bool
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    try {
      $statement = $db->prepare("INSERT INTO users (email, full_name, password, avatar_url) VALUES (:email, :full_name, :password, :avatar_url)");
      $statement->execute([
        ':email' => $attrs['email'],
        ':full_name' => $attrs['full_name'],
        ':password' => $attrs['password'],
        ':avatar_url' => 'default-avatar.jpg'
      ]);

      $id = $db->lastInsertId();

      $db->commit();
      
      return (int)$id;
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return false;
  }

  public static function find(string|int $id): array|bool
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();
    $result = [];

    try {
      $query = "SELECT * FROM users WHERE id = :id";

      $statement = $db->prepare($query);
      $statement->execute([
        ':id' => $id
      ]);

      $result = $statement->fetch();

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return $result;
  }

  public static function findByEmail(string $email): array|bool
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    $result = false;

    try {
      $statement = $db->prepare("SELECT * FROM users WHERE email = :email");
      $statement->execute([
        ':email' => $email
      ]);

      $result = $statement->fetch();

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return $result;
  }

  public static function update(string|int $id, array $attrs)
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    try {
      $query = "update users
                set full_name = :full_name, email = :email, avatar_url = :avatar_url
                where id = :id";

      $statement = $db->prepare($query);
      $statement->execute([
        ':id' => $id,
        ':full_name' => $attrs['full_name'],
        ':email' => $attrs['email'],
        ':avatar_url' => $attrs['avatar_url'],
      ]);

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }
  }

  public static function setPassword(string|int $id, string $password)
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    try {
      $query = "update users
                set password = :password
                where id = :id";

      $statement = $db->prepare($query);
      $statement->execute([
        ':id' => $id,
        ':password' => $password
      ]);

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }
  }

  public static function setPasswordRecovering(string|int $id, array $attrs)
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    try {
      $query = "update users
                set password_recover_id = :password_recover_id,
                    password_recover_expire = :password_recover_expire
                where id = :id";

      $statement = $db->prepare($query);
      $statement->execute([
        ':id' => $id,
        ':password_recover_id' => $attrs['password_recover_id'],
        ':password_recover_expire' => $attrs['password_recover_expire'],
      ]);

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }
  }
}