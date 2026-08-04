<?php

namespace Core;

class Auth {
    
    public static function start(){
        if (session_status()  === PHP_SESSION_NONE) {
            session_start();
        }
    }
}