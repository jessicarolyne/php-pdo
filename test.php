<?php

use Alura\Pdo\Domain\Repository\StudentRepository;

function enviaEmailParaAniversariante(StudentRepository $studentRepository)
{
  $studentList = $studentRepository->studentBirthAt(new \DateTimeImmutable('1996-10-19'));
  foreach($studentList as $student) {
    echo $student['nome'] . PHP_EOL;
  }
}