<?php

declare(strict_types=1);

namespace App\Http\Models;

class User
{
  public static function create(array $attrs): int|bool
  {
    $db = new \PDO("mysql:host=172.21.0.1;port=4422;dbname=full", "root", "");

    $db->beginTransaction();

    try {
      $statement = $db->prepare("INSERT INTO users (email, full_name, password, avatar_url) VALUES (:email, :full_name, :password, :avatar_url)");
      $statement->execute([
        ':email' => $attrs['email'],
        ':full_name' => $attrs['full_name'],
        ':password' => $attrs['password'],
        ':avatar_url' => 'https://picsum.photos/200/300'
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

  public static function findByEmail(string $email): array|bool
  {
    $db = new \PDO("mysql:host=172.21.0.1;port=4422;dbname=full", "root", "");

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
}