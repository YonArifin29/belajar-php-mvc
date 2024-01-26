<?php
namespace YonArifin29\Belajar\PHP\MVC\Model;

class UserLoginRequest {
    private ?string $id = null;
    private ?string $password = null;

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getId(): string {
        return $this->id;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }
}