<?php

namespace App\Service;

use App\Entity\Citizen;
use App\Repository\CitizenRepository;

class CitizenService
{
    private CitizenRepository $repository;

    public function __construct(CitizenRepository $repository)
    {
        $this->repository = $repository;
    }

    public function registerCitizen(string $name): Citizen
    {
        $name = trim($name);
    
        if (count(preg_split('/\s+/', $name)) < 2) {
        throw new \InvalidArgumentException("O nome deve conter ao menos dois termos.");
    }
    
        try {
            $nis = $this->generateNis();
            $citizen = new Citizen($name, $nis);
        
            $this->repository->save($citizen);
            return $citizen;
        } catch(\PDOException $e){
            throw new \RuntimeException("Erro ao salvar cidadão.", 0, $e);
        }
    }

    public function findCitizenByNis(string $nis): ?Citizen
    {
        if (!preg_match('/^\d{11}$/', $nis)) {
            throw new \InvalidArgumentException("O NIS deve conter exatamente 11 dígitos numéricos.");
        }

        try {
            return $this->repository->findByNis($nis);
        } catch (\PDOException $e) {
            throw new \RuntimeException("Erro ao buscar cidadão.", 0, $e);
        }
    }

    private function generateNis(): string
    {
        do {
            $nis = str_pad((string)random_int(10000000000, 99999999999), 11, '0', STR_PAD_LEFT);
        } while ($this->repository->findByNis($nis) !== null);

        return $nis;
    }
}