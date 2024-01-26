<?php

namespace YonArifin29\Belajar\PHP\MVC\App {

    class Router
    {
        private static $routers = [];

        public static function add(
            string $method,
            string $path,
            string $controller,
            string $function,
            array $middlewares = []
        ): void {
            self::$routers[] = [
                'method' => $method,
                'path' => $path,
                'controller' => $controller,
                'function' => $function,
                'middleware' => $middlewares
            ];
        }

        public static function run(): void
        {
            $path = "/";
            if (isset($_SERVER['PATH_INFO'])) {
                $path = $_SERVER['PATH_INFO'];
            }

            $method = $_SERVER['REQUEST_METHOD'];

            foreach (self::$routers as $route) {
                $patern = "#^" . $route['path'] . "$#";
                if (preg_match($patern, $path, $variable) && $method == $route['method']) {
                    $controller = new $route['controller'];
                    $function = $route['function'];

                    // call middleware
                    foreach ($route['middleware'] as $middleware) {
                        $instance = new $middleware;
                        $instance->before();
                    }
                    array_shift($variable);
                    call_user_func_array([$controller, $function], $variable);
                }
            }
        }
    }
}
