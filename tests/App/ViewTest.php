<?php

namespace YonArifin29\Belajar\PHP\MVC\App;


use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase{
    public function testrender(): void {
        View::render('home/index', [
            "PHP Login Management"
        ]);

        self::expectOutputREgex('[PHP Login Management]');
        self::expectOutputREgex('[body]');
        self::expectOutputREgex('[Login Managemant]');
        self::expectOutputREgex('[Login]');
        self::expectOutputREgex('[Register]');

    }
}