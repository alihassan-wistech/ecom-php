<?php

namespace App\Http\Controllers;

use App\Core\Database;
use App\Http\Controllers\Controller;

class ClientController extends Controller
{
  public function login()
  {
    $pageInfo = ["title" => "Login"];
    $this->renderView($pageInfo, "client/auth/login", "main");
  }

  public function register()
  {
    $pageInfo = ["title" => "Register"];
    $this->renderView($pageInfo, "client/auth/register", "main");
  }


  public function results(array $params)
  {
    $query = $_POST["query"];
    if (empty($query)) {
      header("location:/admin");
      return;
    }
    $results = $this->searchResults($query);
    $params["results"] = $results;
    $pageInfo = ["title" => "Search Results for '$query'"];
    $this->renderView($pageInfo, "admin/search", "admin", $params);
  }

  private function searchResults(string $query)
  {
    $query = htmlentities($query);
    $query = strtolower($query);

    if ($query == "products") {
      $products = Database::getInstance()->getResultsByQuery("SELECT * FROM `products`");
      $results = ["products" => $products];
      return $results;
    }

    if ($query == "categories") {
      $categories = Database::getInstance()->getResultsByQuery("SELECT * FROM `categories`");
      $postCategories = Database::getInstance()->getResultsByQuery("SELECT * FROM `post_categories`");

      $results = ["categories" => $categories, "postCategories" => $postCategories];
      return $results;
    }

    if ($query == "posts") {
      $posts = Database::getInstance()->getResultsByQuery("SELECT * FROM `posts`");

      $results = ["posts" => $posts];

      return $results;
    }

    $products = Database::getInstance()->getResultsByQuery("SELECT * FROM `products` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");
    $categories = Database::getInstance()->getResultsByQuery("SELECT * FROM `categories` WHERE  (CONVERT(`name` USING utf8) LIKE '%$query%')");
    $postCategories = Database::getInstance()->getResultsByQuery("SELECT * FROM `post_categories` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");
    $posts = Database::getInstance()->getResultsByQuery("SELECT * FROM `posts` WHERE (CONVERT(`name` USING utf8) LIKE '%$query%')");

    $results = ["products" => $products, "categories" => $categories, "postCategories" => $postCategories, "posts" => $posts];
    return $results;
  }
}
