<?php
namespace YonArifin29\Belajar\PHP\MVC\Service;

use PHPUnit\Framework\TestCase;
use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Model\UserRegisterRequest;
use YonArifin29\Belajar\PHP\MVC\Domain\User;
use YonArifin29\Belajar\PHP\MVC\Exception\ValidationException;

class UserServiceTest extends TestCase{

    private UserService $userService;
    private UserRepository $userRepository;
    
   
    public function setUp():void {
        $connection = Database::getConnection();
        $this->userRepository = new UserRepository($connection);
        $this->userService = new UserService($this->userRepository);
        $this->userRepository->deleteAll();
    }

    public function testRegisterSuccess(): void {
        $request = new UserRegisterRequest();
        $request->setId('Yon123');
        $request->setName('Yon Arifin');
        $request->setPassword('123');

        $response = $this->userService->register($request);

        self::assertEquals($request->getId(), $response->user->getId());
        self::assertEquals($request->getName(), $response->user->getName());
        // self::assertTrue(password_verify($request->getPassword(), $response->user->getPassword()));
    }

    public function testRegisterFailed() {
        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->setId('');
        $request->setName('');
        $request->setPassword('');
        $this->userService->register($request);
    }

    public function testDuplicat() {
        $user = new User();
        $user->setId('Yon124');
        $user->setName('Yon Arifin');
        $user->setPassword('123');

        $this->userRepository->save($user);

        $this->expectException(ValidationException::class);

        $request = new UserRegisterRequest();
        $request->setId('Yon124');
        $request->setName('Yon Arifin');
        $request->setPassword('123');

        $this->userService->register($request);
    }
}