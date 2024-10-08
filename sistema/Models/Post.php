<?php

namespace sistema\Models;

use sistema\Core\Connection;

class Post
{
  public function findAll(): array
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM posts");

    return $stmt->fetchAll();
  }

  public function findById(int $id = null): object | bool
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM posts WHERE id = {$id}");

    return $stmt->fetch();
  }

  public function findByTitle(string $title = null): array
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM posts WHERE title = '{$title}'");

    return $stmt->fetchAll();
  }
}