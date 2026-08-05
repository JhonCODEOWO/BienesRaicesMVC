<?php

namespace Core;

use mysqli;

class Database {
    private static ?mysqli $db = null;

    public static function setDb(mysqli $db){
        static::$db = $db;
    }

    public static function getDb(): mysqli{
        return static::$db;
    }
}