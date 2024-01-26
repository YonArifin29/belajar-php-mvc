<?php

namespace YonArifin29\Belajar\PHP\MVC\App {
    function header(string $value) {
        echo $value;
    }
}
namespace YonArifin29\Belajar\PHP\MVC\Service {
    function setcookie(string $name, string $value) {
        echo "$name: $value";
    }
}
namespace YonArifin29\Belajar\PHP\MVC\Controller {
    use PHPUnit\Framework\TestCase;
    use YonArifin29\Belajar\PHP\MVC\Service\UserService;
    use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
    use YonArifin29\Belajar\PHP\MVC\Config\Database;
    use YonArifin29\Belajar\PHP\MVC\Domain\User;
    use YonArifin29\Belajar\PHP\MVC\Exception\ValidationException;
    use YonArifin29\Belajar\PHP\MVC\Model\UserLoginRequest;
    use YonArifin29\Belajar\PHP\MVC\Controller\UserController;
    use YonArifin29\Belajar\PHP\MVC\Domain\Session;
    use YonArifin29\Belajar\PHP\MVC\Repository\SessionRepository;
    use YonArifin29\Belajar\PHP\MVC\Service\SessionService;

    class UserControllerTest extends TestCase{

        private UserController $userController;
        private UserService $userService;
        private UserRepository $userRepository;
        private SessionRepository $sessionRepository;


        protected function setUp(): void{
            $this->userController = new UserController();

            $this->sessionRepository = new SessionRepository(Database::getConnection());
            $this->sessionRepository->deleteAll();
            $this->userRepository = new UserRepository(Database::getConnection());
            $this->userService = new UserService($this->userRepository);
            // $this->userController = new UserController();
            putenv("mode=test");
            $this->userRepository->deleteAll();
        }

        // public function testRegister(): void {
        //     $this->userController->register();
        //     $this->expectOutputRegex("[Register]");
        //     $this->expectOutputRegex("[Id]");
        //     $this->expectOutputRegex("[Name]");
        //     $this->expectOutputRegex("[Password]");
        // }

        // public function testRegisterPostSuccess(): void {
        //     $_POST['id'] = 'Dewil123';
        //     $_POST['name'] = 'Dewil';
        //     $_POST['password'] = '123';

        // $this->userController->postRegister();
        
        // $this->expectOutputRegex("[login]");
        // }

        // public function testPostValidationError(): void {
        //     $_POST['id'] = '';
        //     $_POST['name'] = '';
        //     $_POST['password'] = ''; 

        //     $this->userController->postRegister();
        //     $this->expectOutputRegex("[Register]");
        //     $this->expectOutputRegex("[Id]");
        //     $this->expectOutputRegex("[Name]");
        //     $this->expectOutputRegex("[Password]");
        //     $this->expectOutputRegex("[all field can not blank]");
            
        // }

        // public function testRegisterDuplicate() {
        //     $user = new User();
        //     $user->setId('melati123');
        //     $user->setName('melati');
        //     $user->setPassword('123');

        //     $this->userRepository->save($user);

        //     $result = $this->userRepository->findById('melati123');

        //     self::assertEquals($user->getId(), $result->getId());
        //     self::assertEquals($user->getName(), $result->getName());
        // }

        // public function testUserLoginNotFound(): Void {
        //     $this->expectException(ValidationException::class);
        //     $loginRequest = new UserLoginRequest();

        //     $loginRequest->setId('yon123');
        //     $loginRequest->setPassword('123');

        //     $this->userService->login($loginRequest);
        // }

        // public function testLoginPasswordWrong(): void {
        //     $user = new User();
        //     $user->setId('yon321');
        //     $user->setPassword(password_hash('Yon123', PASSWORD_BCRYPT));
        //     $this->expectException(ValidationException::class);

        //     $loginRequest = new UserLoginRequest();
        //     $loginRequest->setId('yon321');
        //     $loginRequest->setPassword('salah');

        //     $this->userService->login($loginRequest);

        // }

        // public function testLoginSuccess() {
        //     $user = new User();
        //     $user->setId('dewil');
        //     $user->setName('yonarifin');
        //     $user->setPassword(password_hash('dewil123', PASSWORD_BCRYPT));

        //     $this->userRepository->save($user);

        //     $_POST['id'] = "dewil";
        //     $_POST['password'] = "dewil123";

        //     $this->userController->loginPost();
        //     $this->expectOutputRegex("[location: /]");
        //     $this->expectOutputRegex("[X-YON-SESSION: ]");
    

        // }

        // public function testLoginValidationError() {

        //     $_POST['id'] = "";
        //     $_POST['password'] = "";

        //     $this->userController->loginPost();
        //     $this->expectOutputRegex("[Login]");
        //     $this->expectOutputRegex("[Id]");
        //     $this->expectOutputRegex("[Password]");
        //     $this->expectOutputRegex("[all field can not blank]");

        // }

        // public function testLogin(): void {
        //     $this->userController->login();
        //     $this->expectOutputRegex("[Login]");
        //     $this->expectOutputRegex("[Id]");
        //     $this->expectOutputRegex("[Password]");
        // }

        public function testLogout() {
            $user = new User();
            $user->setId('jeha');
            $user->setName("Hanggini");
            $user->setPassword(password_hash("123", PASSWORD_BCRYPT));  
            $this->userRepository->save($user);

            $session = new Session();
            $session->setId(uniqid());
            $session->setUserId($user->getId());
            $this->sessionRepository->save($session);

            $_COOKIE[SessionService::$COOKIE_NAME] = $session->getId();

            $this->userController->logout();
            $this->expectOutputRegex("[Location: /]");
            $this->expectOutputRegex("[X-YON-SESSION: ]");

        }

    }
}


