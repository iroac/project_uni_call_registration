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
        // Include password in the result so callers can verify current password
        $stmt = $this->pdo->prepare("SELECT id, name, email, password, telefone, cpf FROM {$this->table} WHERE id = :id");
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

    public function updateUser($id, $name, $email, $newPassword, $telefone, $cpf)
    {
        $fields = [];
        $params = ['id' => $id];

        if ($name !== null) {
            $fields[] = "name = :name";
            $params['name'] = $name;
        }

        if ($email !== null) {
            $fields[] = "email = :email";
            $params['email'] = $email;
        }

        if ($newPassword !== null) {
            $fields[] = "password = :password";
            $params['password'] = password_hash($newPassword, PASSWORD_DEFAULT);
        }

        if ($telefone !== null) {
            $fields[] = "telefone = :telefone";
            $params['telefone'] = $telefone;
        }

        if ($cpf !== null) {
            $fields[] = "cpf = :cpf";
            $params['cpf'] = $cpf;
        }

        if (empty($fields)) {
            throw new Exception("Nenhum campo para atualizar", 400);
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id = :id RETURNING id, name, email, telefone, cpf";
        try {
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute($params);
            return ["user" => $stmt->fetch(), "message" => "Usuário atualizado com sucesso", "status" => 200];
        } catch (PDOException $e) {
            error_log("Erro interno do servidor: " . $e->getMessage());
            throw new Exception("Erro interno do servidor", 500);
        }
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
                'password' => password_hash($user->password, PASSWORD_DEFAULT),
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