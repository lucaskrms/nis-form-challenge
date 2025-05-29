<?php

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Before;
use App\Service\CitizenService;
use App\Repository\CitizenRepository;
use App\Entity\Citizen;

class CitizenServiceTest extends TestCase
{
    private CitizenService $service;

    #[Before]
    protected function setUp(): void
    {
        $pdo = new PDO('sqlite::memory:');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->exec('CREATE TABLE citizens (id INTEGER PRIMARY KEY AUTOINCREMENT, name TEXT, nis TEXT)');
        $repository = new CitizenRepository($pdo);
        $this->service = new CitizenService($repository);
    }

    #[Test]
    public function findCitizenByNis(): void
    {
        $citizen = $this->service->registerCitizen('Carlos Teste');
        $found = $this->service->findCitizenByNis($citizen->getNis());

        $this->assertNotNull($found);
        $this->assertEquals($citizen->getName(), $found->getName());
    }

    #[Test]
    public function findCitizenWithInvalidNisThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->findCitizenByNis('123');
    }

    #[Test]
    public function findCitizenByNisThrowsRuntimeExceptionOnPdoError(): void
    {
        $mockRepo = $this->createMock(CitizenRepository::class);
        $mockRepo->method('findByNis')->willThrowException(new \PDOException("Erro no banco"));

        $service = new CitizenService($mockRepo);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Erro ao buscar cidadão.");

        $service->findCitizenByNis('12345678901');
    }

    #[Test]
    public function registerCitizen(): void
    {
        $citizen = $this->service->registerCitizen('Maria Souza');

        $this->assertInstanceOf(Citizen::class, $citizen);
        $this->assertEquals('Maria Souza', $citizen->getName());
        $this->assertMatchesRegularExpression('/^\d{11}$/', $citizen->getNis());
    }

    #[Test]
    public function registerCitizenWithInvalidNameThrowsException(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->service->registerCitizen('joao');
    }

    #[Test]
    public function registerCitizenThrowsRuntimeExceptionOnPdoError(): void
    {
        $mockRepo = $this->createMock(CitizenRepository::class);
        $mockRepo->method('save')->willThrowException(new \PDOException("Erro de banco"));

        $service = new CitizenService($mockRepo);

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage("Erro ao salvar cidadão.");

        $service->registerCitizen('João Silva');
    }
}