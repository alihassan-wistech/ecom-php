<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Core\Database;

class CustomerController extends Controller
{
  public function index(array $params)
  {
    $users = Database::getInstance()->getResultsByQuery("SELECT * FROM `users`");
    //   $products = Database::getResultsByQuery("SELECT * FROM `products` ORDER BY `id` DESC");
    $params["users"] = $users;
    //   $params["products"] = $products;

    $pageInfo = ["title" => "Products", "description" => "Products Page Admin Panel"];
    $this->renderView($pageInfo, "admin/customers/index", "admin", $params);
  }
}
