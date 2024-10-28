<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$pdo = Alura\Pdo\Infrascruture\Persistence\ConnectionCreator::CreateConnection();

$statement = $pdo->query('SELECT * FROM students;');
$studentDataList = $statement->fetchAll(fetch_style: PDO::FETCH_ASSOC);

foreach($studentDataList as $studentData) {
  $studentList[] = new Student($studentData['id'], $studentData['nome'], new DateTimeImmutable($studentData['birth_date']));
}
var_dump($studentList);