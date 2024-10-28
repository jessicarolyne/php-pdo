<?php

use Alura\Pdo\Domain\Model\Student;

require_once 'vendor/autoload.php';

$student = new Student(
    null,
    'Jessica Caroline',
    new \DateTimeImmutable('1996-10-19')
);

echo $student->age();
