<?php

use App\core\Router;
use App\controllers\api\CountryController;
use App\controllers\CartController;
use App\controllers\HomeController;
use App\controllers\OrderController;
use App\controllers\ShopController;
use App\controllers\TestController;
use App\controllers\ContactController;
use App\controllers\ClientController;
use App\controllers\UserController;
use App\utils\Functions;

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
