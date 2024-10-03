<?php

namespace Sistema\Core;

use PDO;
use PDOException;

/**
 * Class Connection
 */
class Connection
{
  private static $instance;

  public static function getInstance(): PDO
  {
    if (empty(self::$instance)) {
      try {
        self::$instance = new PDO(
          'mysql:host=' . DB_HOST .
            ';dbname=' . DB_NAME .
            ';port=' . DB_PORT,
          DB_USER,
          DB_PASS,
          [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // trata toda erro no PDO como uma Exceção
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ, // converte os resultados das consultas em Objetos
            PDO::ATTR_CASE => PDO::CASE_NATURAL, // força nomes de coluna para um case especifico
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
          ]

        );
      } catch (PDOException $e) {
        die('Connection failed: ' . $e->getMessage());
      }

      return self::$instance;
    }
  }

  // essa forma de instancia impede a criação de novas instancias fora da classe
  protected function __construct() {}

  private function  __clone(): void {}
}