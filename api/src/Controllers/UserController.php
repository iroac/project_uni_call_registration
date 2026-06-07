<?php

require_once __DIR__ . '/../Repositories/UserRepository.php';
require_once __DIR__ . '/../Services/UserServices.php';
require_once __DIR__ . '/../Dtos/RegisterUserDto.php';

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
        $result = $this->userServices->find($id);
        if (is_array($result) && isset($result['password'])) {
            unset($result['password']);
        } elseif (is_object($result) && isset($result->password)) {
            unset($result->password);
        }

        return $result;
    }

    public function update($id, $name, $email, $newPassword, $currentPassword, $telefone, $cpf)
    {
        return $this->userServices->update($id, $name, $email, $newPassword, $currentPassword, $telefone, $cpf);
    }

    public function register($name, $email, $password, $telefone, $cpf)
    {
        $registerUserDto = new RegisterUserDto($name, $email, $password, $telefone, $cpf);
        return $this->userServices->register($registerUserDto);
    }
}