<?php

use App\Core\Router;
use App\Utils\Functions;
use App\Http\Controllers\API\CountryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\UserController;

$router = Router::getInstance();

// Client Routes
$router->get("/", [HomeController::class, "index"]);
$router->get("/shop", [ShopController::class, "index"]);
$router->get("/shop/{slug}", [ShopController::class, "singleProduct"]);
$router->get("/shop/category", [ShopController::class, "singleCategory"]);

$router->get("/contact", [ContactController::class, "index"]);
$router->get("/cart", [ShopController::class, "cart"]);
$router->get("/checkout", [ShopController::class, "checkout"]);

$router->post("/order", [OrderController::class, "createOrder"]);

$router->post("/saveCart", [CartController::class, "saveCart"]);
$router->get("/countries", [CountryController::class, "getCountries"]);
$router->get("/states", [CountryController::class, "getStates"]);
$router->get("/cities", [CountryController::class, "getCities"]);

if (isset($_SESSION["client"]) && $_SESSION["client"] == true) {
    $router->get("/getCart", [CartController::class, "getCart"]);
    $router->get("/dashboard", [UserController::class, "dashboard"]);
    $router->get("/logout", [UserController::class, "logout"]);
} else {
    $router->get("/login", [ClientController::class, "login"]);
    $router->get("/register", [ClientController::class, "register"]);

    $router->post("/user/login", [UserController::class, "login"]);
    $router->post("/user/register", [UserController::class, "register"]);
}

// 404 Page
$router->addNotFoundCallback(function () {
    echo Functions::getTemplate("404");
});

// Implementing Path Params
$router->get("/url/{id:\d+}", [TestController::class, "pathParams"]);
$router->get("/profile/{id:\d+}/{username}", [TestController::class, "pathParams"]);
