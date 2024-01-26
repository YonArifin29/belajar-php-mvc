<?php

namespace YonArifin29\Belajar\PHP\MVC\App {
    function header(string $value)
    {
        echo $value;
    }
}

// namespace YonArifin29\Belajar\PHP\MVC\Service {
//     function setcookie(string $name, string $value)
//     {
//         echo "$name: $value";
//     }
// }

namespace YonArifin29\Belajar\PHP\MVC\Middleware {
    // use YonArifin29\Belajar\PHP\MVC\Middleware\MustLoginMiddleware;
    use PHPUnit\Framework\TestCase;
    use YonArifin29\Belajar\PHP\MVC\Domain\User;
    use YonArifin29\Belajar\PHP\MVC\Domain\Session;
    use YonArifin29\Belajar\PHP\MVC\Config\Database;
    use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
    use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
    use YonArifin29\Belajar\PHP\MVC\Service\SessionService;

    class MustNotLoginMiddlewareTest extends TestCase
    {
        private MustNotLoginMiddleware $middleware;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;

        protected function setUp(): void
        {
            $this->middleware = new MustNotLoginMiddleware();
            putenv("mode=test");

            $this->userRepository = new UserRepository(Database::getConnection());
            $this->sessionRepository = new SessionRepository(Database::getConnection());

            $this->sessionRepository->deleteAll();
            $this->userRepository->deleteAll();
        }

        public function testBeforeGuest()
        {
            $this->middleware->before();
            $this->expectOutputString("");
        }

        public function testBeforeUser()
        {
            $user = new User();
            $user->setId("yon");
            $user->setName("yon");
            $user->setPassword("rahasia");
            $this->userRepository->save($user);

            $session = new Session();
            $session->setId(uniqid());
            $session->setUserId($user->getId());
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();
            $this->middleware->before();
            $this->expectOutputRegex("[location: /]");
        }
    }
}
