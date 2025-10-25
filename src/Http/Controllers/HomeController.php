<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\core\Database;

class HomeController extends Controller
{

    public function index(array $params)
    {
        $products = Database::getInstance()->getResultsByQuery("SELECT * FROM `products` LIMIT 8");
        $banners = Database::getInstance()->getResultsByQuery("SELECT * FROM `banners`");
        $categories = Database::getInstance()->getResultsByQuery("SELECT * FROM `categories` LIMIT 6;");

        echo $this->viewRenderer
            ->usesLayout("frontend/layout.php")
            ->render("frontend/index.php", compact('banners', 'categories', 'products'));
    }
}
