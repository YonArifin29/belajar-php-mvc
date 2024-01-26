<?php
require_once __DIR__ . "/../vendor/autoload.php";

use YonArifin29\Belajar\PHP\MVC\App\Router;
use YonArifin29\Belajar\PHP\MVC\Controller\HomeController;
use YonArifin29\Belajar\PHP\MVC\Controller\ProductController;
use YonArifin29\Belajar\PHP\MVC\Middleware\AuthMiddleware;
use YonArifin29\Belajar\PHP\MVC\Controller\UserController;
use YonArifin29\Belajar\PHP\MVC\Config\Database;
use YonArifin29\Belajar\PHP\MVC\Middleware\MustLoginMiddleware;
use YonArifin29\Belajar\PHP\MVC\Middleware\MustNotLoginMiddleware;

Database::getConnection('prod');
// Router::add('GET', '/product/([0-9a-zA-Z]*)/category/([0-9a-zA-Z]*)', ProductController::class, 'category');
// Router::add('GET', '/', HomeController::class, 'index', [AuthMiddleware::class]);

// Home
Router::add('GET', '/', HomeController::class, 'index');
Router::add('GET', '/about', HomeController::class, 'about');

//User
Router::add('GET', '/users/register', UserController::class, 'register', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/register', UserController::class, 'postRegister', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/login', UserController::class, 'login', [MustNotLoginMiddleware::class]);
Router::add('POST', '/users/login', UserController::class, 'loginPost', [MustNotLoginMiddleware::class]);
Router::add('GET', '/users/logout', UserController::class, 'logout', [MustLoginMiddleware::class]);
Router::run();
