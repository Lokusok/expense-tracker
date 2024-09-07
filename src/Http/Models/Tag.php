<?php

declare(strict_types=1);

namespace App\Http\Models;

use App\Containers\Database\DatabaseContainer;

class Tag extends BasicModel
{
  public static function all(): array
  {
    $db = DatabaseContainer::get('db');

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
