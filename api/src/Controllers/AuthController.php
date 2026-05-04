<?php

require_once __DIR__ . "/../Services/AuthServices.php";

class AuthController
{
    private $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function login($email, $password)
    {
        return $this->authService->login($email, $password);
    }
}