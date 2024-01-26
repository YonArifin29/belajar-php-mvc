<?php

namespace YonArifin29\Belajar\PHP\MVC\Config;

use YonArifin29\Belajar\PHP\MVC\Config\Database;
use PHPUnit\Framework\TestCase;

class DatabaseTest extends TestCase{

    public function testGetConnection(): void {
        $connection = Database::getConnection();
        self::assertNotNull($connection);
    }

    public function testGetConnectionSingleton() {

        $connection1 = Database::getConnection();
        $connection2 = Database::getConnection();
        self::assertSame(1, 1);
    }
}