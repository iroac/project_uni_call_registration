<?php

require_once __DIR__ . '/../Services/ChamadoServices.php';

class ChamadoController
{

    private $chamadoServices;

    public function __construct()
    {
        $this->chamadoServices = new ChamadoServices();
    }

    public function getChamados()
    {
        return $this->chamadoServices->getAll();
    }

    public function getChamadosByUserId($userId)
    {
        $chamados = $this->chamadoServices->getAll();
        return array_filter($chamados, fn($chamado) => $chamado['user_id'] == $userId);
    }

    public function getChamado($id)
    {
        return $this->chamadoServices->find($id);
    }

    public function create($titulo, $descricao, $departamento, $responsavel, $regiao, $status, $userId)
    {
        return $this->chamadoServices->create($titulo, $descricao, $departamento, $responsavel, $regiao, $status, $userId);
    }
}