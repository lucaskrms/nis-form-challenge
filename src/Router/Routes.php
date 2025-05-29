<?php

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

match (true) {
    $method === 'POST' && $path === '/citizen/register' => $controller->register($_POST),
    $method === 'GET'  && $path === '/citizen/search'   => $controller->search($_GET),
    default => $controller->index()
};