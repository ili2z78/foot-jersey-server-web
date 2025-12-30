<?php

class HomeController {

    protected $productModel;

    public function __construct() {
        if (!class_exists('Product')) {
            require_once __DIR__ . '/../Models/Product.php';
        }
        $this->productModel = new Product();
    }

    public function index() {
        $featuredProducts = $this->productModel->paginate(6, 0);
        require __DIR__ . '/../Views/home.php';
    }
}
