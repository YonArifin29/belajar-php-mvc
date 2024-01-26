<?php

namespace YonArifin29\Belajar\PHP\MVC\Service;

use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Exception\ValidationException;
use YonArifin29\Belajar\PHP\MVC\Model\UserRegisterRequest;
use YonArifin29\Belajar\PHP\MVC\Model\UserLoginRequest;
use YonArifin29\Belajar\PHP\MVC\Model\UserLoginResponse;
use YonArifin29\Belajar\PHP\MVC\Model\UserRegisterResponse;
use YonArifin29\Belajar\PHP\MVC\Domain\User;
use YonArifin29\Belajar\PHP\MVC\Repository\UserRepository;


class UserService {
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function register(UserRegisterRequest $request): UserRegisterResponse {
        $this->validateUserRegistrationRequest($request);
        
        try {
            Database::beginTransaction();
            $user = $this->userRepository->findById($request->getId()); 
            if($user != null) {
                throw new ValidationException('user already exsist');
            }
            $user = new User();
            $user->setId($request->getId());
            $user->setName($request->getName());
            $user->setPassword(password_hash($request->getPassword(), PASSWORD_BCRYPT));

            $this->userRepository->save($user);

            $response = new UserRegisterResponse();
            $response->user = $user;
            Database::commitTransaction();
            return $response;
  
        } catch(\Exception $exception) {
            Database::rollBackTransaction();

            throw $exception;
        }
    }

    private function validateUserRegistrationRequest($request) {
        if($request->getId() == null || $request->getName() == null || $request->getPassword() == null || trim($request->getId()) == "" || trim($request->getName()) == "" || trim($request->getPassword()) == "" ) {
            throw new ValidationException('all field can not blank');
        }
    }

    public function login(UserLoginRequest $request): UserLoginResponse{
        $this->validateUserLoginRequest($request);

        $user = $this->userRepository->findById($request->getId());

        if($user == null) {
            throw new ValidationException('username or password is wrong');
        }

        if(password_verify($request->getPassword(), $user->getPassword())) {
            $response = new UserLoginResponse();
            $response->user = $user;
            return $response;
        } else {
            throw new ValidationException("username or password is wrong");
        }

    }

    private function validateUserLoginRequest($request) {
        if($request->getId() == null  || $request->getPassword() == null || trim($request->getId()) == "" || trim($request->getPassword()) == "" ) {
            throw new ValidationException('all field can not blank');
        }
    }
}