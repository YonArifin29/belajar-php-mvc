<?php

namespace YonArifin29\Belajar\PHP\MVC\Repository;

use YonArifin29\Belajar\PHP\MVC\Domain\User;

class UserRepository
{

    public function __construct(private \PDO $connection)
    {
    }

    public function save(User $user): User
    {
        $statement = $this->connection->prepare("INSERT INTO users (id, name, password) VALUES(?, ?, ?)");

        $statement->execute([
            $user->getId(), $user->getName(), $user->getPassword()
        ]);
        return $user;
    }

    public function update(User $user): User
    {

        $stetment = $this->connection->prepare("UPDATE users SET name = ?, password = ? WHERE id = ?");
        $stetment->execute([
            $user->getName(), $user->getPassword(), $user->getId()
        ]);
        return $user;
    }

    public function findById(string $id): ?User
    {
        $statement = $this->connection->prepare("SELECT id, name, password FROM users WHERE id = ?");
        $statement->execute([$id]);

        try {
            if ($row = $statement->fetch()) {
                $user = new User();
                $user->setId($row['id']);
                $user->setName($row['name']);
                $user->setPassword($row['password']);
                return $user;
            } else {
                return null;
            }
        } finally {
            $statement->closeCursor();
        }
    }

    public function deleteAll(): void
    {
        $this->connection->exec("DELETE FROM users");
    }
}
