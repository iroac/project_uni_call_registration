<?php

require_once __DIR__ . '/../Repositories/UserRepository.php';
require_once __DIR__ . '/../Services/UserServices.php';

class UserController
{

    private $userServices;
    private $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->userServices = new UserServices($this->userRepository);
    }

    public function getUsers()
    {
        return $this->userServices->getAll();
    }

    public function getUser($id)
    {
        return $this->userServices->find($id);
    }

    public function createUser($data)
    {
        return $this->userServices->create($data);
    }
}