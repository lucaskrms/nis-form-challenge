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