<?php

require_once __DIR__ . '/../../config/database.php';

class UserRepository
{
    private PDO $pdo;
    private string $table = '"users"';

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function getAllUsers()
    {
        $stmt = $this->pdo->query("SELECT id, name, email FROM {$this->table} ORDER BY id");
        return $stmt->fetchAll();
    }

    public function getUserById($id)
    {
        $stmt = $this->pdo->prepare("SELECT id, name, email FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function createUser($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (name, email) VALUES (:name, :email) RETURNING id, name, email"
        );
        $stmt->execute([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
        ]);

        return $stmt->fetch();
    }
}