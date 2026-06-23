<?php

function conectarDb(): mysqli
{
    //Programming Oriented Object connection way.
    try {
        $db = new mysqli($_ENV['DB_HOST'], $_ENV['DB_USERNAME'], $_ENV['DB_PASSWORD'], $_ENV['DB_DATABASE']);
        return $db;
    } catch (mysqli_sql_exception $ex) {
        $errorMessage = $ex->getMessage();
        include __DIR__.'../../../error.php';
        exit;
    }
}
