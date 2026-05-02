<?php

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

    public function create($data)
    {
        return $this->userRepository->createUser($data);
    }
}