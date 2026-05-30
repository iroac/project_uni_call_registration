<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : $uri;


$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

if ($origin) {
    header("Access-Control-Allow-Origin: $origin");
} else {
    header('Access-Control-Allow-Origin: *');
}
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json; charset=utf-8');

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($method == 'POST' && $route == 'api/auth/login') {
    require_once __DIR__ . "/../Controllers/AuthController.php";
    $authController = new AuthController();

    $rawBody = file_get_contents('php://input');
    $payload = json_decode($rawBody, true) ?? $_POST;

    $email = $payload['email'] ?? '';
    $password = $payload['password'] ?? '';

    echo json_encode($authController->login($email, $password));
}

if ($method == 'POST' && $route == 'api/auth/logout') {
    session_start();
    session_destroy();
    header('Location: /login');
    echo json_encode(["message" => "Logout bem-sucedido"]);
    exit;
}

