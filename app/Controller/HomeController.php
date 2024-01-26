<?php
namespace YonArifin29\Belajar\PHP\MVC\Controller {

    use YonArifin29\Belajar\PHP\MVC\App\View;
    use YonArifin29\Belajar\PHP\MVC\Domain\Session;
    use YonArifin29\Belajar\PHP\MVC\Service\SessionService;
    use YonArifin29\Belajar\PHP\MVC\Config\Database;
    use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
    use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;

    class HomeController {

        private SessionService $sessionService;

        public function __construct()
        {
            $connection = Database::getConnection();
            $sessionRepository = new SessionRepository($connection);
            $userRepository = new UserRepository($connection);
            $this->sessionService = new SessionService($sessionRepository, $userRepository);
        }
        public function index(): void {
            $user = $this->sessionService->current();
            if($user == null) {
                $header= [
                    "title"=> "Halaman Login",
                    "judul" => "Selamat datang di yon's strore"
                ];
                View::render('Home/index', $header);
            }else {
                $header= [
                    "title"=> "Halaman Dashboard",
                    "judul" => "Selamat datang di yon's strore",
                    "user" => [
                        "name" => $user->getName()
                    ]
                ];
                View::render('Home/dashboard', $header);
            }
            // $_SESSION['user'] = true;
            // $header= [
            //     "title"=> "Halaman Home",
            //     "judul" => "Selamat datang di yon's strore"
            // ];
            // View::render('Home/dashboard', $header);
        }
    
        public function about(): void {
            echo "HomeController->about()";
        }
        
    }
}
