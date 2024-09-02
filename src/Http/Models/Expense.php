<?php

declare(strict_types=1);

namespace App\Http\Models;

use App\Session\Session;

class Expense extends BasicModel
{
  public static function create(array $attrs): int|bool
  {
    $db = new \PDO("mysql:host=172.21.0.1;port=4422;dbname=full", "root", "");

    $db->beginTransaction();

    try {
      $statement = $db->prepare("INSERT INTO expenses (title, description, price, tag_id, user_id) VALUES (:title, :description, :price, :category_id, :user_id)");
      $statement->execute([
        ':title' => $attrs['title'],
        ':description' => $attrs['descr'],
        ':price' => $attrs['price'],
        ':category_id' => (int)$attrs['category'],
        ':user_id' => Session::get('id')
      ]);

      $id = $db->lastInsertId();

      $db->commit();

      return (int)$id;
    } catch (\Exception $e) {
      dd($e);
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return false;
  }
}