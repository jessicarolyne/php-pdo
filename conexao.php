<?php
$caminhoBanco = __DIR__ . '/banco.sqlite';
$pdo = new PDO('sqlite:' . $caminhoBanco);
echo 'Conecteiiiii';

$pdo->exec(statement: 'CREATE TABLE students (id INTEGER PRIMARY KEY, nome TEXT, birth_date TEXT);');