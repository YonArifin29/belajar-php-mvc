<?php

namespace YonArifin29\Belajar\PHP\MVC\Domain;

class User {
    private string $id;
    private string $name;
    private string $password;

    public function setId(string $id) {
        $this->id = $id;
    }

    public function getId(): string {
        return $this->id;
    }

    public function setName(string $name) {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }
}