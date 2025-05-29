<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Before;

use App\Repository\CitizenRepository;
use App\Entity\Citizen;

class CitizenRepositoryTest extends TestCase
{
    private CitizenRepository $repository;

    #[Before]
    public function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('CREATE TABLE citizens (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, nis TEXT)');
        $this->repository = new CitizenRepository($pdo);
    }

    #[Test]
    public function saveAndFindCitizen(): void
    {
        $citizen = new Citizen('João da Silva', '12345678901');
        $this->repository->save($citizen);

        $found = $this->repository->findByNis('12345678901');

        $this->assertNotNull($found);
        $this->assertEquals('João da Silva', $found->getName());
        $this->assertEquals('12345678901', $found->getNis());
    }

    #[Test]
    public function findByNisReturnsNullIfNotFound(): void
    {
        $found = $this->repository->findByNis('00000000000');
        $this->assertNull($found);
    }
}