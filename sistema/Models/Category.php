<?php

namespace sistema\Models;

use sistema\Core\Connection;

class Category
{
  public function findAll(): array
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM categorias WHERE status = 1 ORDER BY titulo ASC");

    return $stmt->fetchAll();
  }

  public function findById(int $id = null): object | bool
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM categorias WHERE id = {$id}");

    return $stmt->fetch();
  }

  public function findByTitle(string $title = null): array
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM categorias WHERE title = '{$title}'");

    return $stmt->fetchAll();
  }
}