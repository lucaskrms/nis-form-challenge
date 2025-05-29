<?php

namespace App\Repository;

use App\Entity\Citizen;
use PDO;

class CitizenRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->createTableIfNotExists();
    }

    private function createTableIfNotExists(): void
    {
        $this->pdo->exec("
            CREATE TABLE IF NOT EXISTS citizens (
                nis TEXT PRIMARY KEY,
                name TEXT NOT NULL
            )
        ");
    }

    public function save(Citizen $citizen): void
    {
        $stmt = $this->pdo->prepare("INSERT INTO citizens (nis, name) VALUES (:nis, :name)");
        $stmt->execute([
            ':nis' => $citizen->getNis(),
            ':name' => $citizen->getName()
        ]);
    }

    public function findByNis(string $nis): ?Citizen
    {
        $stmt = $this->pdo->prepare("SELECT * FROM citizens WHERE nis = :nis");
        $stmt->execute([':nis' => $nis]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($data) {
            return new Citizen($data['name'], $data['nis']);
        }

        return null;
    }
}