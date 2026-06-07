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

    public function update($id, $titulo = null, $descricao = null, $departamento = null, $responsavel = null, $regiao = null, $status = null)
    {
        $fields = [];
        $params = ['id' => $id];

        if ($titulo !== null) {
            $fields[] = 'titulo = :titulo';
            $params['titulo'] = $titulo;
        }
        if ($descricao !== null) {
            $fields[] = 'descricao = :descricao';
            $params['descricao'] = $descricao;
        }
        if ($departamento !== null) {
            $fields[] = 'departamento = :departamento';
            $params['departamento'] = $departamento;
        }
        if ($responsavel !== null) {
            $fields[] = 'responsavel = :responsavel';
            $params['responsavel'] = $responsavel;
        }
        if ($regiao !== null) {
            $fields[] = 'regiao = :regiao';
            $params['regiao'] = $regiao;
        }
        if ($status !== null) {
            $fields[] = 'status = :status';
            $params['status'] = $status;
        }

        if (empty($fields)) {
            throw new Exception("Nenhum campo para atualizar", 400);
        }

        $sql = "UPDATE {$this->table} SET " . implode(', ', $fields) . " WHERE id_chamado = :id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
}