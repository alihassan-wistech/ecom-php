<?php

namespace App\Core;

use Dotenv\Dotenv;

class Application
{
    public function run()
    {
        try {
            $dotenv = Dotenv::createImmutable(BASE_DIR);
            $dotenv->load();
        } catch (\Throwable $t) {
            throw $t;
        }
        session_start();

        $router =  Router::getInstance();

        require_once base_dir("routes/web.php");
        require_once base_dir("routes/admin.php");

        $router->run();
    }
}
