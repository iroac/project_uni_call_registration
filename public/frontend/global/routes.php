<?php

// Quando usar o PHP built-in server, a variável $_GET['route'] não estará
//  disponível, então precisamos usar REQUEST_URI para determinar a rota.
// $_GET['route'] é usado quando o servidor é configurado para redirecionar 
// todas as requisições para index.php, como em um ambiente de produção com Apache ou Nginx.
if (isset($_GET['route'])) {
    $route = trim($_GET['route'], '/');
} else {
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $route = trim(str_replace('/public', '', $uri), '/');
}

$publicRoutes = [
    '' => __DIR__ . '/../pages/main/index.html',
    'login' => __DIR__ . '/../pages/login/index.html',
    'cadastro' => __DIR__ . '/../pages/cadastro/index.html',
];

$privateRoutes = [
    'dashboard' => __DIR__ . '/../pages/dashboard/index.html',
];

session_start();

if (array_key_exists($route, $publicRoutes)) {
    $file = $publicRoutes[$route];

    if (file_exists($file)) {

        if (isset($_SESSION['user_id']) && ($route === 'login' || $route === 'cadastro')) {
            header('Location: /dashboard');
            exit;
        }

        include $file;
    } else {
        http_response_code(500);
        echo "Error: Página não encontrada";
    }
} else if (array_key_exists($route, $privateRoutes)) {

    if (isset($_SESSION['user_id'])) {
        $file = $privateRoutes[$route];

        if (file_exists($file)) {
            include $file;
        } else {
            http_response_code(500);
            echo "Error: Página não encontrada";
        }
    } else {
        header('Location: /login');
        exit;
    }
} else if (strpos($route, 'api/') === 0) {
    require_once __DIR__ . '/../Routers/auth.php';
} else {
    http_response_code(404);
    echo "Error: Página não encontrada";
}