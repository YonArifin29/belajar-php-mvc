<?php
namespace YonArifin29\Belajar\PHP\MVC\App {
    class View {
        public static function render(string $view, array $model) :void{
            require __DIR__."/../view/header.php";
            require __DIR__."/../View/".$view.".php";
            require __DIR__."/../View/footer.php";
        }

        public static function redirect(string $url) {
            header("location: $url");
            if(getenv("mode") != "test") {
                exit();
            }
        }
    }
}

