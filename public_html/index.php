<?php

define('BASE_DIR', realpath(__DIR__ . '/..'));
define('DEV_MODE', true);

try {
    require_once BASE_DIR . '/vendor/autoload.php';

    (new App\Core\Application())->run();
} catch (\Throwable $t) {
    http_response_code(500);
    if (DEV_MODE) {
        echo "<pre>";
        print_r($t);
        echo "</pre>";
    } else {
        echo "SOMETHING WENT WRONG";
    }
    exit;
}
