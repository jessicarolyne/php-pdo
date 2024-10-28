<?php

namespace Alura\Pdo\Infrascruture\Persistence;
use PDO;
class ConnectionCreator
{
  public static function CreateConnection(): PDO
  {
    $databasePath = __DIR__ . '/../../../sqlite:banco.sqlite';
    return new PDO(dsn: 'sqlite:' . $databasePath);
  }
}
