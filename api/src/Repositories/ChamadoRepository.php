<?php

class ChamadoRepository
{

    private PDO $pdo;
    private string $table = '"chamados"';

    public function __construct()
    {
        $this->pdo = getPDO();
    }

    public function getAll()
    {
        $stmt = $this->pdo->query("SELECT id_chamado, titulo, descricao, departamento, responsavel, regiao, status, id_usuario FROM {$this->table} ORDER BY id_chamado DESC");
        return $stmt->fetchAll();
    }

    public function find($id)
    {
        $stmt = $this->pdo->prepare("SELECT id_chamado, titulo, descricao, departamento, responsavel, regiao, status, id_usuario FROM {$this->table} WHERE id_chamado = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function create($titulo, $descricao, $departamento, $responsavel, $regiao, $status, $userId)
    {
        $stmt = $this->pdo->prepare("INSERT INTO {$this->table} (titulo, descricao, departamento, responsavel, regiao, status, id_usuario) VALUES (:titulo, :descricao, :departamento, :responsavel, :regiao, :status, :id_usuario)");
        return $stmt->execute([
            'titulo' => $titulo,
            'descricao' => $descricao,
            'departamento' => $departamento,
            'responsavel' => $responsavel,
            'regiao' => $regiao,
            'status' => $status,
            'id_usuario' => $userId
        ]);
    }
}