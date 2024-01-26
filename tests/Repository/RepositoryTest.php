<?php

namespace YonArifin29\Belajar\PHP\MVC\Repository;

use PHPUnit\Framework\TestCase;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Domain\User;

class RepositoryTest extends TestCase {

    private UserRepository $userRepository;

    protected function setUp(): void {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
    }

    public function testSaveSuccess(): void {
        $user = new User();

        $user->setId('Yon123');
        $user->setName('Yon Arifin');
        $user->setPassword('123');

        $this->userRepository->save($user);

        $result = $this->userRepository->findById($user->getId());

        self::assertEquals($user->getId(), $result->getId());
        self::assertEquals($user->getName(), $result->getName());
        self::assertEquals($user->getPassword(), $result->getPassword());
    }

    public function testFindByIdNotFound() {
        $user = $this->userRepository->findById("notfound");
        self::assertNull($user);
    }
}