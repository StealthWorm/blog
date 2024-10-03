<?php

namespace sistema\Models;

use sistema\Core\Connection;

class Post
{

  // public $id;

  // public $title;

  // public $subtitle;

  // public $content;


  public function findAll(): array
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM posts");

    // var_dump($result);
    return $stmt->fetchAll();
  }

  public function findById(int $id = null): array
  {
    $stmt = Connection::getInstance()->query("SELECT * FROM posts WHERE id = {$id}");

    return $stmt->fetchAll();
  }
}