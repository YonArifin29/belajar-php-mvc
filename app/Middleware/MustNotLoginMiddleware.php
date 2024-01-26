<?php

namespace YonArifin29\Belajar\PHP\MVC\Middleware;

use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
use YonArifin29\Belajar\PHP\MVC\Service\SessionService;
use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\App\View;

class MustNotLoginMiddleware implements Middleware
{
    private SessionService $sessionService;

    public function __construct()
    {
        $sessionRepository = new SessionRepository(Database::getConnection());
        $userRepository = new UserRepository(Database::getConnection());
        $this->sessionService = new SessionService($sessionRepository,  $userRepository);
    }
    public function before(): void
    {
        $user = $this->sessionService->current();
        if ($user != null) {
            view::redirect('/');
        }
    }
}
