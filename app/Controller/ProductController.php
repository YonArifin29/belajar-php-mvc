<?php

namespace YonArifin29\Belajar\PHP\MVC\Controller {
    class ProductController {
        public function category(string $productId, string $categoryId) {
            echo "CategoriId: $productId, category $categoryId";
        }
    }
}