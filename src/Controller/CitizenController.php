<?php

namespace App\Controller;

use App\Service\CitizenService;

class CitizenController
{
    private CitizenService $service;

    public function __construct(CitizenService $service)
    {
        $this->service = $service;
    }

    public function index(): void
    {
        require __DIR__ . '/../View/form.php';
    }

    public function register(array $data): void
    {
        $name = trim($data['name'] ?? '');

        if ($name === '') {
            $message = "Nome inválido.";
        } else {
            try {
                $citizen = $this->service->registerCitizen($name);
                $message = "Cidadão cadastrado com sucesso! NIS: " . $citizen->getNis();
            } catch (RuntimeException $e) {
                $message = "Erro ao cadastrar cidadão: " . $e->getMessage();
            }
        }

        $this->render('result', ['message' => $message]);
    }

    public function search(array $data): void
    {
        $nis = trim($data['nis'] ?? '');

        if ($nis === '') {
            $message = "NIS não informado.";
        } else {
            try {
                $citizen = $this->service->findCitizenByNis($nis);
                $message = $citizen
                    ? "Cidadão encontrado: {$citizen->getName()} (NIS: {$citizen->getNis()})"
                    : "Cidadão não encontrado.";
            } catch (RuntimeException $e) {
                $message = "Erro ao buscar cidadão: " . $e->getMessage();
            }
        }

        $this->render('result', ['message' => $message]);
    }

    private function render(string $view, array $params = []): void
    {
        extract($params);
        require __DIR__ . "/../View/{$view}.php";
    }
}