<?php

use PHPUnit\Framework\TestCase;
use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Domain\Session;
use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
use YonArifin29\Belajar\PHP\MVC\Domain\User;
class SessionRepositoryTest extends TestCase{
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;

    protected function setUp():void {
        $this->userRepository = new UserREpository(Database::getConnection());
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        
        $this->userRepository->deleteAll();
        $this->sessionRepository->deleteAll();

        $user = new User();
        $user->setId('yon');
        $user->setName("yon");
        $user->setPassword("rahasia");

        $this->userRepository->save($user);
    }

    public function testSaveSuccess() {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("yon");

        $result = $this->sessionRepository->save($session);

        self::assertEquals($session->getId(), $result->getId());
        self::assertEquals($session->getUserId(), $result->getUserId());

    }
}