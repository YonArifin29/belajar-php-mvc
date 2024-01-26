<?php

namespace YonArifin29\Belajar\PHP\MVC\Domain;

class Session {

    private string $id;
    private string $userId;

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }

    public function setUserId($userId) {
        $this->userId = $userId;
    }

    public function getUserId() {
        return $this->userId;
    }


}