<?php

require_once __DIR__ . '/../Repositories/ChamadoRepository.php';

class ChamadoServices
{

    private $chamadoRepository;

    public function __construct()
    {
        $this->chamadoRepository = new ChamadoRepository();
    }

    public function getAll()
    {
        return $this->chamadoRepository->getAll();
    }

    public function find($id)
    {
        return $this->chamadoRepository->find($id);
    }

    public function create($titulo, $descricao, $departamento, $responsavel, $regiao, $status, $userId)
    {
        return $this->chamadoRepository->create($titulo, $descricao, $departamento, $responsavel, $regiao, $status, $userId);
    }

    public function update($id, $titulo = null, $descricao = null, $departamento = null, $responsavel = null, $regiao = null, $status = null)
    {
        return $this->chamadoRepository->update($id, $titulo, $descricao, $departamento, $responsavel, $regiao, $status);
    }
}