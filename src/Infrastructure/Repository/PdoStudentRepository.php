<?php

namespace Alura\Pdo\Infrastructure\Repository;

use Alura\Pdo\Domain\Model\Student;
use Alura\Pdo\Domain\Repository\StudentRepository;
use PDO;
use RuntimeException;

class PdoStudentRepository implements StudentRepository
{
  private PDO $connection;

  public function __construct(PDO $connection)
  {
    $this->connection = $connection;
  }

  public function allStudents(): array
  {
    $sqlQuery = 'SELECT * FROM students;';
    $stmt = $this->connection->query($sqlQuery);

    return $this->hydrateStudentList($stmt);
  }

  public function studentsBirthAt(\DateTimeInterface $birthDate): array
  {
    $sqlQuery = 'SELECT * FROM students WHERE birth_date = ?;';
    $stmt = $this->connection->prepare($sqlQuery);
    $stmt->bindValue(1, $birthDate->format('Y-m-d'));
    $stmt->execute();
    return $this->hydrateStudentList($stmt);
  }

  private function hydrateStudentList(\PDOStatement $stmt): array
  {
    $studentDataList = $stmt->fetchAll();
    $studentList = [];

    foreach ($studentDataList as $studentData) {
      $studentList[] = new Student(
        $studentData['id'],
        $studentData['nome'],
        new \DateTimeImmutable($studentData['birth_date'])
      );
    }

    return $studentList;
  }

  public function save(Student $student): bool
  {
    if ($student->id() === null) {
      return $this->insert($student);
    }
    return $this->update($student);
  }

  public function insert(Student $student): bool
  {
    $insertQuery = 'INSERT INTO students (nome, birth_date) VALUES (:name, :birth_date)';
    $stmt = $this->connection->prepare($insertQuery);

    $sucess = $stmt->execute([
      ':name' => $student->name(),
      ':birth_date' => $student->birthDate()->format('Y-m-d')
    ]);

    if ($sucess) {
      $student->defineId($this->connection->lastInsertId());
    }

    return $sucess;
  }

  public function update(Student $student): bool
  {
    $updateQuery = 'UPDATE students SET nome = :name, birth_date = :birth_date WHERE id = :id;';
    $stmt = $this->connection->prepare($updateQuery);
    $stmt->bindValue(':name', $student->name());
    $stmt->bindValue(':birth_date', $student->birthDate()->format('Y-m-d'));
    $stmt->bindValue(':id', $student->id(), PDO::PARAM_INT);
    return $stmt->execute();
  }

  public function remove(Student $student): bool
  {
    $stmt = $this->connection->prepare('DELETE FROM students WHERE id = ?;');
    $stmt->bindValue(1, $student->id(), PDO::PARAM_INT);
    return $stmt->execute();
  }
}
