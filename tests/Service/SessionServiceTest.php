<?php
namespace YonArifin29\Belajar\PHP\MVC\Service;

use PHPUnit\Framework\TestCase;

use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Domain\Session;
use YonArifin29\Belajar\PHP\MVC\Service\SessionService;
use YonArifin29\Belajar\PHP\MVC\Domain\User;
function setcookie(string $name, string $value) {
    echo "$name: $value";
}

class SessionServiceTest extends TestCase {
    private SessionService $sessionService;
    private SessionRepository $sessionRepository;
    private UserRepository $userRepository;
    
    protected function setUp(): void {
        $this->sessionRepository = new SessionRepository(Database::getConnection());
        $this->userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($this->sessionRepository, $this->userRepository);
        $this->sessionRepository->deleteAll();
        $this->userRepository->deleteAll();

        $user = new User();
        $user->setId('yon');
        $user->setName("yon");
        $user->setPassword("rahasia");

        $this->userRepository->save($user);
    }

    public function testCreate() {
        $session = $this->sessionService->create("yon");
        $this->expectOutputRegex("[X-YON-SESSION: ".$session->getId()."]");

        $result = $this->sessionRepository->findById($session->getId());
        self::assertEquals("yon", $result->getUserId());


    }

    public function testDestroy() {
       
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("yon");
        $this->sessionRepository->save($session);

        $sessionId = $_COOKIE[sessionService::$COOKIE_NAME] =  $session->getId();
        $this->sessionRepository->deleteById($sessionId);

       $this->sessionService->destroy();

        $this->expectOutputRegex("[X-YON-SESSION: ]");

        $result = $this->sessionRepository->findById($session->getId());
    }

    public function testCurrent() {
        $session = new Session();
        $session->setId(uniqid());
        $session->setUserId("yon");
        $this->sessionRepository->save($session);

       $_COOKIE[sessionService::$COOKIE_NAME] =  $session->getId();
        $user = $this->sessionService->current();
        self::assertEquals($session->getUserId(), $user->getId());
    }
}