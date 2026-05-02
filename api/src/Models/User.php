<?php

class User {
    
    private $users = [
        ["id" => 1, "name" => "Vinicius"],
        ["id" => 2, "name" => "Maria"]
    ];

    public function getAll() {
        return $this->users;
    }

    public function findById($id) {
        foreach ($this->users as $user) {
            if ($user['id'] == $id) {
                return $user;
            }
        }
        return null;
    }

    public function create($data) {
        $newUser = [
            "id" => count($this->users) + 1,
            "name" => $data['name'] ?? "Unknown"
        ];

        $this->users[] = $newUser;

        return $newUser;
    }
}