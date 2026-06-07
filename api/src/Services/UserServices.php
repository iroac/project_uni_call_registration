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

    public function update($id, $name, $email, $newPassword, $currentPassword, $telefone, $cpf)
    {
        $user = $this->userRepository->getUserById($id);
        $existingUser = $this->userRepository->getByEmail($user->email);

        if ($name !== null && strlen($name) > 100) {
            throw new Exception("Total de caracteres para nome ultrapassado", 400);
        }

        if ($email !== null && strlen($email) > 100) {
            throw new Exception("Total de caracteres para email ultrapassado", 400);
        }

        if ($newPassword !== null && strlen($newPassword) > 100) {
            throw new Exception("Total de caracteres para senha ultrapassado", 400);
        }

        if ($email !== null && $email !== $user->email) {

            if ($existingUser !== null && $existingUser->email !== $user->email) {
                throw new Exception("Email já registrado", 400);
            }

        }

        if ($currentPassword !== null) {

            if (!$user) {
                throw new Exception("Usuário não encontrado", 404);
            }

            // Extract password hash from the user record returned by getUserById
            $passwordHash = null;
            if (is_array($user)) {
                $passwordHash = $user['password'] ?? null;
            } elseif (is_object($user)) {
                $passwordHash = $user->password ?? null;
            }

            if ($passwordHash === null) {
                throw new Exception("Senha do usuário indisponível para verificação", 500);
            }

            if (!password_verify($currentPassword, $passwordHash)) {
                throw new Exception("Senha atual incorreta", 400);
            }

            if ($newPassword !== null) {
                if ($newPassword === $currentPassword || password_verify($newPassword, $passwordHash)) {
                    throw new Exception("A nova senha deve ser diferente da atual", 400);
                }
            }
        }


        return $this->userRepository->updateUser($id, $name, $email, $newPassword, $telefone, $cpf);
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