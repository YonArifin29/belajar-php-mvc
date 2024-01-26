<?php

namespace YonArifin29\Belajar\PHP\MVC\Middleware;

interface Middleware {
    public function before(): void;
}