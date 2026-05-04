<?php

require_once __DIR__ . "/../Repositories/AuthRepository.php";
require_once __DIR__ . "/../Repositories/UserRepository.php";

class AuthService
{
    private $authRepository;
    private $userRepository;

    public function __construct()
    {
        $this->authRepository = new AuthRepository();
        $this->userRepository = new UserRepository();
    }

    public function login($email, $password)
    {

        if ($email == "") {
            throw new Exception("Email inválido", 400);
        }

        if (strlen($email) > 100) {
            throw new Exception("Total de caracteres para email ultrapassado", 400);
        }

        if (strlen($password) > 100) {
            throw new Exception("Total de caracteres para senha ultrapassado", 400);
        }

        $user = $this->userRepository->getByEmail($email);

        if (!$user) {
            throw new Exception("Usuário não encontrado", 404);
        }

        if ($user['password'] !== $password) {
            throw new Exception("Senha incorreta", 400);
        }

        return $this->authRepository->login($email, $password);
    }
}