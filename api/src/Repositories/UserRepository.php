<?php

require_once __DIR__ . '/../../config/database.php';

class UserRepository
{
    private PDO $pdo;
    private string $table = '"usuarios"';

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

    public function getByEmail($email)
    {
        $stmt = $this->pdo->prepare("SELECT id, name, email, password FROM {$this->table} WHERE email = :email");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        return $user ?: null;
    }

    public function createUser(User $user)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO {$this->table} (name, email, password, telefone, cpf) VALUES (:name, :email, :password, :telefone, :cpf) RETURNING id, name, email"
        );
        try {

            $stmt->execute([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
                'telefone' => $user->phone,
                'cpf' => $user->cpf,
            ]);

            $user = $stmt->fetch();
            return $user ? ["user" => $user, "message" => "Usuário criado com sucesso", "status" => 201] : ["message" => "Erro ao criar usuário", "status" => 400];
        } catch (PDOException $e) {
            error_log("Erro interno do servidor: " . $e->getMessage());
            throw new Exception("Erro interno do servidor", 500);
        }
    }
}