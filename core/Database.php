<?php

namespace Core;

use mysqli;

class Database {
    private static ?mysqli $db = null;

    public static function setDb(mysqli $db){
        static::$db = $db;
    }

    public function getDb(): mysqli{
        return static::$db;
    }
}