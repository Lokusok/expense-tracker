<?php

declare(strict_types=1);

namespace App\Http\Models;

use App\Session\Session;

use App\Containers\Database\DatabaseContainer;

class Expense extends BasicModel
{
  public static function create(array $attrs): int|bool
  {
    $db = DatabaseContainer::get('db');

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
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return false;
  }

  public static function all(array $params): array
  {
    $db = DatabaseContainer::get('db');
    $db->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

    $userId = Session::get('id');

    $db->beginTransaction();

    $result = [];

    try {
      // Получение записей
      $query = "select expenses.id as expense_id, expenses.title, expenses.description, price, tags.title as category_title, tags.id as category_id from expenses
                right join tags on expenses.tag_id = tags.id
                where user_id = :user_id";

      if (isset($params['q'])) {
        $query .= " and expenses.title like :query";
      }

      $query .= " limit :limit offset :offset";

      $statement = $db->prepare($query);

      $statement->execute([
        ':user_id' => $userId,
        ':query' => "%{$params['q']}%",
        ':limit' => (int)$params['limit'],
        ':offset' => (int)$params['offset']
      ]);

      $result[] = $statement->fetchAll();

      // Получение тотального количества записей
      $query = "select count(id) as total from expenses
                where user_id = :user_id";

      if (isset($params['q'])) {
        $query .= " and title like :query";
      }

      $statement = $db->prepare($query);
      $statement->execute([
        ':user_id' => $userId,
        ':query' => "%{$params['q']}%"
      ]);

      $result[] = $statement->fetch()['total'];

      $db->commit();
    } catch (\Exception $e) {
      dd($e);

      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return $result;
  }

  public static function delete(string|int $id): bool
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    $result = false;

    try {
      $statement = $db->prepare("DELETE FROM expenses WHERE id = :id");
      $statement->execute([
        ':id' => $id
      ]);

      $result = (bool)($statement->rowCount());

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return $result;
  }

  public static function update(string $id, array $attrs)
  {
    $db = DatabaseContainer::get('db');

    $db->beginTransaction();

    try {
      $db->commit();

      $query = "update expenses
                set title = :title, description = :description,
                    price = :price, tag_id = :category_id
                where id = :expense_id";

      $statement = $db->prepare($query);
      $statement->execute([
        ':expense_id' => $id,
        ':title' => $attrs['title'],
        ':description' => $attrs['description'],
        ':price' => $attrs['price'],
        ':category_id' => $attrs['category_id']
      ]);

    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }
  }
}