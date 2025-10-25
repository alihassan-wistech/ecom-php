<?php

namespace App\Traits;

trait Singleton
{
    private static $instances = [];
    public static function getInstance()
    {
        $called_class = get_called_class();

        if (!isset(self::$instances[$called_class])) {
            self::$instances[$called_class] = new $called_class;
        }

        return self::$instances[$called_class];
    }
}
