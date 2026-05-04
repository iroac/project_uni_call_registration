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

if ($method === 'GET' && preg_match('#^api/users/(\d+)$#', $route, $matches)) {
    $user = $userController->getUser($matches[1]);

    if (!$user) {
        http_response_code(404);
        echo json_encode(["error" => "Usuário não encontrado"]);
        return;
    }

    echo json_encode($user);
    return;
}