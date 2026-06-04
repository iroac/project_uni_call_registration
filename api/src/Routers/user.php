<?php

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : $uri;

$userController = new UserController();

if ($method === 'GET' && $route === 'api/users') {
    $users = $userController->getUsers();
    echo json_encode(["users" => $users]);
    return;
}

if ($method === 'GET' && $route === 'api/users/me') {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(["error" => "Não autenticado"]);
        return;
    }

    $user = $userController->getUser($_SESSION['user_id']);
    echo json_encode($user);
    return;
}

if ($method == 'POST' && $route == 'api/users/register') {
    $rawBody = file_get_contents('php://input');
    $payload = json_decode($rawBody, true) ?? $_POST;

    $name = $payload['name'];
    $email = $payload['email'];
    $password = $payload['password'];
    $phone = $payload['telefone'] ?? null;
    $cpf = $payload['cpf'] ?? null;

    try {
        $response = $userController->register($name, $email, $password, $phone, $cpf);
        http_response_code($response['status']);
        echo json_encode(["message" => $response['message'], "user" => $response['user'] ?? null]);
    } catch (Exception $e) {
        http_response_code($e->getCode() ?: 500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}