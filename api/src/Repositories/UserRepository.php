<?php

require_once "../src/Models/User.php";

class UserRepository
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function getAllUsers()
    {
        return $this->userModel->getAll();
    }

    public function getUserById($id)
    {
        return $this->userModel->findById($id);
    }

    public function createUser($data)
    {
        return $this->userModel->create($data);
    }
}