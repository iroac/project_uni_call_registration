<?php

require_once __DIR__ . "/../Controllers/UserController.php";

try {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $route = isset($_GET['route']) ? trim($_GET['route'], '/') : $uri;

    // Endpoint para helth check
    if ($method === 'GET' && $route === 'api') {
        echo json_encode(["message" => "API funcionando!"]);
        return;
    }

    // Rotas separadas por funcionalidade
    if (str_contains($route, "users")) {
        require_once __DIR__ . "/user.php";
        return;
    }

    if (str_contains($route, "auth")) {
        require_once __DIR__ . "/auth.php";
        return;
    }

    // Default para rotas não encontradas
    http_response_code(404);
    echo json_encode(["error" => "Endpoint não encontrado"]);
} catch (Throwable $e) {
    $status = $e->getCode();
    if (!is_int($status) || $status < 400 || $status > 599) {
        $status = 500;
    }

    http_response_code($status);
    echo json_encode(["error" => $e->getMessage()]);
}