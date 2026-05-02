<?php

require_once "../src/Controllers/UserController.php";

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

$userController = new UserController();

if ($method === 'GET' && $uri === '/users') {
    $users = $userController->getUsers();
    echo json_encode(["users" => $users]);
    return;
}

if ($method === 'GET' && preg_match('#^/users/(\d+)$#', $uri, $matches)) {
    $user = $userController->getUser($matches[1]);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["error" => "Usuário não encontrado"]);
        return;
    }

    echo json_encode($user);
    return;
}

if ($method === 'GET' && $uri === '/') {
    echo json_encode(["message" => "API is running"]);
    return;
}


http_response_code(404);
echo json_encode(["error" => "Endpoint não encontrado"]);