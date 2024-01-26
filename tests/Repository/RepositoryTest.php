<?php

namespace YonArifin29\Belajar\PHP\MVC\Repository;

use PHPUnit\Framework\TestCase;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Domain\User;
use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;

class RepositoryTest extends TestCase
{

    private UserRepository $userRepository;
    private SessionRepository $sessionRepository;

    protected function setUp(): void
    {
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->userRepository->deleteAll();
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->sessionRepository->deleteAll();
    }

    // public function testSaveSuccess(): void
    // {
    //     $user = new User();

    //     $user->setId('Yon123');
    //     $user->setName('Yon Arifin');
    //     $user->setPassword('123');

    //     $this->userRepository->save($user);

    //     $result = $this->userRepository->findById($user->getId());

    //     self::assertEquals($user->getId(), $result->getId());
    //     self::assertEquals($user->getName(), $result->getName());
    //     self::assertEquals($user->getPassword(), $result->getPassword());
    // }

    // public function testFindByIdNotFound()
    // {
    //     $user = $this->userRepository->findById("notfound");
    //     self::assertNull($user);
    // }

    public function testUpdate()
    {
        $user = new User();

        $user->setId('Yon123');
        $user->setName('Yon Arifin');
        $user->setPassword('123');

        $this->userRepository->save($user);

        $user->setName('Yon ucok');
        $this->userRepository->update($user);

        $result = $this->userRepository->findById($user->getId());

        self::assertEquals($user->getId(), $result->getId());
        self::assertEquals($user->getName(), $result->getName());
        self::assertEquals($user->getPassword(), $result->getPassword());
    }
}
