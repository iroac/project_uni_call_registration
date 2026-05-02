<?php

require_once '../src/Models/User.php';

class UserController {

    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function getUsers() {
        return $this->userModel->getAll();
    }

    public function getUser($id) {
        return $this->userModel->findById($id);
    }

    public function createUser($data) {
        return $this->userModel->create($data);
    }
}