<?php

class User
{
    public function __construct(
        public ?int $id = null,
        public string $name,
        public ?string $email,
        public ?string $password,
        public ?string $phone,
        public ?string $cpf,
    ) {
    }
}