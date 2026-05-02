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

$routes = [
    '' => __DIR__ . '/../pages/main/index.html',
    'login' => __DIR__ . '/../pages/login/index.html',
    'cadastro' => __DIR__ . '/../pages/cadastro/index.html',
];

if (array_key_exists($route, $routes)) {
    $file = $routes[$route];

    if (file_exists($file)) {
        include $file;
    } else {
        http_response_code(500);
        echo "Error: File not found";
    }
} else {
    http_response_code(404);
    echo "Error: Page not found";
}