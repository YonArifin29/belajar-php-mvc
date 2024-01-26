<?php
namespace YonArifin29\Belajar\PHP\MVC\Model;

class UserRegisterRequest {
    private ?string $id = null;
    private ?string $name = null;
    private ?string $password = null;

    public function setId(string $id): void {
        $this->id = $id;
    }

    public function getId(): string {
        return $this->id;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function getPassword(): string {
        return $this->password;
    }
}