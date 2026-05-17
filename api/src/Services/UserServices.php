<?php

require_once __DIR__ . '/../Models/User.php';
require_once __DIR__ . '/../Repositories/UserRepository.php';

class UserServices
{
    public function __construct(private UserRepository $userRepository)
    {

    }

    public function getAll()
    {
        return $this->userRepository->getAllUsers();
    }

    public function find($id)
    {
        return $this->userRepository->getUserById($id);
    }

    public function register($registerUserDto)
    {
        if ($registerUserDto->name == "") {
            throw new Exception("Nome inválido", 400);
        }

        if (strlen($registerUserDto->name) > 100) {
            throw new Exception("Total de caracteres para nome ultrapassado", 400);
        }

        if ($registerUserDto->email == "") {
            throw new Exception("Email inválido", 400);
        }

        if (strlen($registerUserDto->email) > 100) {
            throw new Exception("Total de caracteres para email ultrapassado", 400);
        }

        if (strlen($registerUserDto->password) > 100) {
            throw new Exception("Total de caracteres para senha ultrapassado", 400);
        }

        $existingUser = $this->userRepository->getByEmail($registerUserDto->email);

        if ($existingUser) {
            throw new Exception("Email já registrado", 400);
        }

        $user = new User(
            null,
            $registerUserDto->name,
            $registerUserDto->email,
            $registerUserDto->password,
            $registerUserDto->telefone,
            $registerUserDto->cpf
        );

        return $this->userRepository->createUser($user);
    }
}