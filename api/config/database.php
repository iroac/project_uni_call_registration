<?php

declare(strict_types=1);

function getPDO(): PDO
{
    $host = 'localhost';
    $port = 5433;
    $dbName = 'db_chamados';
    $user = 'postgres';
    $password = 'A';

    $dsn = "pgsql:host={$host};port={$port};dbname={$dbName}";

    $pdo = new PDO($dsn, $user, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);

    return $pdo;
}
