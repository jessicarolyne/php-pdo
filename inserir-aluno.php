<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$pdo = Alura\Pdo\Infrascruture\Persistence\ConnectionCreator::CreateConnection();

$student = new Student(
  null,
  "Jessica', ''); DROP TABLE students; -- Dias",
  new \DateTimeImmutable('1999-01-11')
);

$sqlInsert = "INSERT INTO students (nome, birth_date) VALUES (:name, :birth_date);";
$statement = $pdo->prepare($sqlInsert);
$statement->bindValue(':name', $student->name());
$statement->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));

if ($statement->execute()) {
  echo "Aluno incluido!"; 
}
