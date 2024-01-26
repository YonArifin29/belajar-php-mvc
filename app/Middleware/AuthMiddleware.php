<?php

namespace YonArifin29\Belajar\PHP\MVC\Middleware;

class AuthMiddleware implements Middleware {
    function before(): void
    {
        session_start();
        if(!isset($_SESSION['user'])) {
            header('Location: /users/login');   
            exit;
        }
    }
}