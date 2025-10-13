<?php

use App\controllers\AdminController;
use App\controllers\CustomerController;
use App\controllers\ProductController;
use App\controllers\ProductCategoryController;
use App\controllers\PostController;
use App\controllers\PostCategoryController;
use App\controllers\SiteController;
use App\controllers\MarketingController;
use App\controllers\OrderController;
use App\controllers\TestController;
use App\core\Router;

$router = Router::getInstance();

if (isset($_SESSION["admin"]) && $_SESSION["admin"] == true) {
    $router->get("/admin/products", [ProductController::class, "index"]);
    $router->get("/admin/products/details", [ProductController::class, "singleProduct"]);
    $router->get("/admin/products/new", [ProductController::class, "newProduct"]);
    $router->post("/admin/products/create", [ProductController::class, "createProduct"]);
    $router->post("/admin/products/delete", [ProductController::class, "deleteProduct"]);
    $router->get("/admin/products/edit", [ProductController::class, "editProduct"]);
    $router->post("/admin/products/update", [ProductController::class, "updateProduct"]);
    $router->get("/admin/products/categories", [ProductCategoryController::class, "categories"]);
    $router->get("/admin/products/categories/details", [ProductCategoryController::class, "singleCategory"]);
    $router->get("/admin/products/categories/new", [ProductCategoryController::class, "newCategory"]);
    $router->get("/admin/products/categories/edit", [ProductCategoryController::class, "editCategory"]);
    $router->post("/admin/products/categories/update", [ProductCategoryController::class, "updateCategory"]);
    $router->post("/admin/products/categories/create", [ProductCategoryController::class, "createCategory"]);
    $router->post("/admin/products/categories/delete", [ProductCategoryController::class, "deleteCategory"]);
    $router->get("/admin/posts", [PostController::class, "index"]);
    $router->get("/admin/posts/new", [PostController::class, "newPost"]);
    $router->post("/admin/posts/create", [PostController::class, "createPost"]);
    $router->get("/admin/posts/details", [PostController::class, "singlePost"]);
    $router->post("/admin/posts/delete", [PostController::class, "deletePost"]);
    $router->get("/admin/posts/edit", [PostController::class, "editPost"]);
    $router->post("/admin/posts/update", [PostController::class, "updatePost"]);
    $router->get("/admin/posts/categories", [PostCategoryController::class, "index"]);
    $router->get("/admin/posts/categories/new", [PostCategoryController::class, "newCategory"]);
    $router->post("/admin/posts/categories/create", [PostCategoryController::class, "createCategory"]);
    $router->get("/admin/posts/categories/details", [PostCategoryController::class, "singleCategory"]);
    $router->post("/admin/posts/categories/delete", [PostCategoryController::class, "deleteCategory"]);
    $router->get("/admin/posts/categories/edit", [PostCategoryController::class, "editCategory"]);
    $router->post("/admin/posts/categories/update", [PostCategoryController::class, "updateCategory"]);
    $router->get("/admin/site_settings", [SiteController::class, "index"]);
    $router->get("/admin/orders", [OrderController::class, "index"]);
    $router->get("/admin/customers", [CustomerController::class, "index"]);
    $router->get("/admin/banners", [MarketingController::class, "banners"]);
    $router->get("/admin/banners/new", [MarketingController::class, "newBanner"]);
    $router->post("/admin/banners/create", [MarketingController::class, "createBanner"]);
    $router->get("/admin/banners/edit", [MarketingController::class, "editBanner"]);
    $router->get("/admin/banners/details", [MarketingController::class, "singleBanner"]);
    $router->get("/admin/banners/edit", [MarketingController::class, "editBanner"]);
    $router->post("/admin/banners/delete", [MarketingController::class, "deleteBanner"]);
    $router->post("/admin/banners/update", [MarketingController::class, "updateBanner"]);
    $router->get("/admin", [AdminController::class, "index"]);
    $router->get("/admin/logout", [AdminController::class, "logout"]);
    $router->post("/admin/search", [AdminController::class, "suggestions"]);
    $router->post("/admin/results", [AdminController::class, "results"]);
    $router->get("/test", [TestController::class, "categoryName"]);
} else {
    $router->get("/admin", [AdminController::class, "login"]);
    $router->post("/admin/signin", [AdminController::class, "signin"]);
}
