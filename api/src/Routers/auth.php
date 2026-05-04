<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : $uri;

if ($method == 'POST' && $route == 'api/auth/login') {
    require_once __DIR__ . "/../Controllers/AuthController.php";
    $authController = new AuthController();

    $rawBody = file_get_contents('php://input');
    $payload = json_decode($rawBody, true) ?? $_POST;

    $email = $payload['email'];
    $password = $payload['password'];

    echo json_encode($authController->login($email, $password));
}