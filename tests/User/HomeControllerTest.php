<?php
namespace YonArifin29\Belajar\PHP\MVC\App{

    function header(string $value) {
        echo "$value";
    }
}

namespace YonArifin29\Belajar\PHP\MVC\Service{

    function setcookie(string $name, string $value) {
        echo "$name: $value";
    }
}
namespace YonArifin29\Belajar\PHP\MVC\Controller {
    use PHPUnit\Framework\TestCase;
    use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
    use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
    use YonArifin29\Belajar\PHP\MVC\Config\Database;
    use YonArifin29\Belajar\PHP\MVC\Domain\Session;
    use YonArifin29\Belajar\PHP\MVC\Domain\User;
    use YonArifin29\Belajar\PHP\MVC\Service\SessionService;
    class HomeControllerTest extends TestCase {
        private HomeController $homeController;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;
    
        protected function setUp(): void {
            $this->homeController = new HomeController();
            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();
        }
        public function testGuest() {
            $this->homeController->index();
            $this->expectOutputRegex("[Yon's Store]");
        }
        public function testUserLogin(){
            $user = new User();
            $user->setId('yon');
            $user->setName('Yon');
            $user->setPassword('rahasia');
            $this->userRepository->save($user);
    
            $session = new Session();
            $session->setId(uniqid());
            $session->setUserId($user->getId());
            $this->sessionRepository->save($session);
            
            $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();
            $this->homeController->index();
            $this->expectOutputRegex("[Hi Yon]");
            $this->expectOutputRegex("[Yon's Store]");
        }
    }
}