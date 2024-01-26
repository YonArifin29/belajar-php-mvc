<?php
namespace YonArifin29\Belajar\PHP\MVC {

use PHPUnit\Framework\TestCase;

class RegexTest extends TestCase {
    public function testRegex() : void{
        $path = "/product/123/category/hp";
        $patern = "#^/product/([0-9a-zA-Z]*)/category/([0-9a-zA-Z]*)$#";

        $result = preg_match($patern, $path, $variable);

        self::assertEquals(1, $result);

        array_shift($variable);
        var_dump($variable);
     }
}
}
