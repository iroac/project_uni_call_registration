<?php

require_once __DIR__ . "/../Controllers/ChamadoController.php";

$method = $_SERVER['REQUEST_METHOD'];
$uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
$route = isset($_GET['route']) ? trim($_GET['route'], '/') : $uri;

$chamadoController = new ChamadoController();

if ($method === 'GET' && $route === 'api/chamados') {
    $userId = isset($_GET['user_id']) ? $_GET['user_id'] : null;
    $chamados = $chamadoController->getChamadosByUserId($userId);
    echo json_encode(["chamados" => $chamados]);
    return;
}

if ($method === 'POST' && $route === 'api/chamados') {
    $rawBody = file_get_contents('php://input');
    $payload = json_decode($rawBody, true) ?? $_POST;

    $titulo = $payload['titulo'];
    $descricao = $payload['descricao'];
    $departamento = $payload['departamento'];
    $responsavel = $payload['responsavel'];
    $regiao = $payload['regiao'];
    $status = $payload['status'];
    $userId = $_SESSION['user_id'] ?? null;

    if (!$userId) {
        http_response_code(401);
        echo json_encode(["error" => "Não autenticado"]);
        return;
    }

    try {
        $chamado = $chamadoController->create($titulo, $descricao, $departamento, $responsavel, $regiao, $status, $userId);
        http_response_code(201);
        echo json_encode(["message" => "Chamado criado com sucesso", "chamado" => $chamado]);
    } catch (Exception $e) {
        http_response_code($e->getCode() ?: 500);
        echo json_encode(["error" => $e->getMessage()]);
    }
}
