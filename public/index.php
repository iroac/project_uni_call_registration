<?php

header("Access-Control-Allow-Origin: *");

// Quando usar o PHP built-in server, a variável $_GET['route'] não estará
//  disponível, então precisamos usar REQUEST_URI para determinar a rota.
if (isset($_GET['route'])) {
    $route = trim($_GET['route'], '/');
} else {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = trim(str_replace('/public', '', $uri), '/');
}

if (str_contains($route, 'api')) {
    header("Content-Type: application/json");
    require_once __DIR__ . "/../api/src/Routers/routes.php";
    return;
}

require_once __DIR__ . "/frontend/global/routes.php";


