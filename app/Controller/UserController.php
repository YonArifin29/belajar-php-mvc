<?php
namespace YonArifin29\Belajar\PHP\MVC\Controller;

use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Service\UserService;
use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
use YonArifin29\Belajar\PHP\MVC\App;
use YonArifin29\Belajar\PHP\MVC\App\View;
use YonArifin29\Belajar\PHP\MVC\Domain\Session;
use YonArifin29\Belajar\PHP\MVC\Model\UserRegisterRequest;
use YonArifin29\Belajar\PHP\MVC\Exception\ValidationException;
use YonArifin29\Belajar\PHP\MVC\Model\UserLoginRequest;
use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
use YonArifin29\Belajar\PHP\MVC\Service\SessionService;

class UserController {
    private UserService $userService;
    private SessionService $sessionService;
    public function __construct()
    {
        $connection = Database::getConnection();
        $userRepository = new UserRepository($connection);
        $this->userService = new UserService($userRepository);
        
        $sessionRepository = new SessionRepository($connection);
        $this->sessionService = new SessionService($sessionRepository, $userRepository);

    }
    public function register() {
        View::render('User/register', 
        [
            "title" => "Registrasi"
        ]);
    }

    public function postRegister() {

        try {
            $request = new UserRegisterRequest();
            $request->setId($_POST['id']);
            $request->setName($_POST['name']);
            $request->setPassword($_POST['password']);

            $response = $this->userService->register($request);
            $this->sessionService->create($response->user->getId());
            View::redirect('login');
        } catch(ValidationException $exception) {
            View::render('User/register', 
            [
                "title" => "Registrasi",
                "error" => $exception->getMessage()
            ]);
        }
    }

    public function login(): void {
        View::render('User/login', []);
    }

    public function loginPost() {
        $loginRequest = new UserLoginRequest();
        $loginRequest->setId($_POST['id']);
        $loginRequest->setPassword($_POST['password']);

        try {
            $response = $this->userService->login($loginRequest);
            $this->sessionService->create($response->user->getId());
            View::redirect('/');
        } catch(ValidationException $exception) {
            View::render(
                'User/login', 
            [
                "title" => "Login",
                "error" => $exception->getMessage()
            ]);
        }
    }
    public function logout(): void {
        $this->sessionService->destroy();
        View::redirect('/');
    }
}

