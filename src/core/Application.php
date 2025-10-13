<?php

namespace App\core;

use Dotenv\Dotenv;

class Application
{
    public function run()
    {
        try {
            $dotenv = Dotenv::createImmutable(BASE_DIR);
            $dotenv->load();
        } catch (\Exception $e) {
            echo ".env file not found in current directory.";
            exit();
        }
        session_start();

        $router =  Router::getInstance();

        require_once base_dir("routes/web.php");
        require_once base_dir("routes/admin.php");

        $router->run();
    }
}
