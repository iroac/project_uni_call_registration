<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : $uri;

if ($method == 'POST' && $route == 'api/auth/login') {
    usleep(10000000);
    echo json_encode(["message" => "Login bem-sucedido!"]);
    return;

}