<?php

class RegisterUserDto
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public ?string $telefone = null,
        public string $cpf
    ) {
    }
}