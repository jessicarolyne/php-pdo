<?php
$caminhoBanco = __DIR__ . 'sqlite:banco.sqlite';
$pdo = new PDO(dsn: 'sqlite:' . $caminhoBanco);
echo 'Conecteiiiii';

$pdo->exec(statement: 'CREATE TABLE students (id INTEGER PRIMARY KEY, nome TEXT, birth_date TEXT);');