<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Core\Database;

class TestController extends Controller
{
    public function categoryName(array $params)
    {
        $categories = Database::getInstance()->getResultsByQuery("SELECT * FROM `categories`");
        $params["categories"] = $categories;

        $postCategories = Database::getInstance()->getResultsByQuery("SELECT * FROM `post_categories`");
        $params["postCategories"] = $postCategories;


        $products = Database::getInstance()->getResultsByQuery("SELECT * FROM `products`");
        $params["products"] = $products;


        $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
        $this->renderView($pageInfo, "test", "test", $params);
    }

  public function pathParams($params) {     
    echo "<pre>";
    print_r($params);
  }
}
