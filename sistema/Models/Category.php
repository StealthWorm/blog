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

  public function findPosts(int $id = null): array
  {
    $stmt = Connection::getInstance()->query(
      "SELECT * FROM posts WHERE category_id = {$id} 
       AND status = 1 ORDER BY id DESC
      "
    );

    return $stmt->fetchAll();
  }
}
