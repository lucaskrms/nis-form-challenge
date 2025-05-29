<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controller\CitizenController;
use App\Repository\CitizenRepository;
use App\Service\CitizenService;

$pdo = new PDO("sqlite:" . __DIR__ . "/../storage/database.sqlite");
$repository = new CitizenRepository($pdo);
$service = new CitizenService($repository);
$controller = new CitizenController($service);

require_once __DIR__ . '/../src/Router/Routes.php';