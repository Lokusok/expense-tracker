<?php

declare(strict_types=1);

namespace App\Http\Models;

class Tag extends BasicModel
{
  public static function create(array $attrs)
  {

  }

  public static function all(): array
  {
    $db = new \PDO("mysql:host=172.21.0.1;port=4422;dbname=full", "root", "");

    $db->beginTransaction();

    $result = [];

    try {
      $statement = $db->prepare("SELECT id, title FROM tags ORDER BY ID ASC");
      $statement->execute();

      $result = $statement->fetchAll();

      $db->commit();
    } catch (\Exception $e) {
      if ($db->inTransaction()) {
        $db->rollBack();
      }
    }

    return $result;
  }
}
