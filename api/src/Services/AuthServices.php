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

        if ($user && password_verify($password, $user['password'])) {

            if (session_status() !== PHP_SESSION_ACTIVE) {
                session_start();
            }

            session_regenerate_id(true);
            $_SESSION['user_id'] = $user['id'];
        } else {
            throw new Exception("Credenciais inválidas", 400);
        }

        return ["message" => "Login bem-sucedido!"];
    }
}