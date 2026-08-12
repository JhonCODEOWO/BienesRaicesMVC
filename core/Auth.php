<?php

namespace Core;

use Error;

class Auth {
    public static function start(){
        if (session_status()  === PHP_SESSION_NONE) {
            session_start();
        }
    }
    
    /**
     *  Try to verify if a user can login or not.
     *
     * @param  mixed $email Email to be tested
     * @param  mixed $password Password to grant the access
     * @param  mixed $modelInfo Array with two values: [ClassName::Class, 'tableName'] to search a user in.
     * @return ?object `null` if fails, `$classInstance` of the className provided by args if login can be successful.
     */
    public static function attempt(string $email, string $password, array $modelInfo): ?object{
        $db = Database::getDb();
        [$class, $tableName] = $modelInfo;
        $userModelClassInstance = new $class();

        $preparedStatement = $db->prepare("SELECT * FROM $tableName WHERE email = ? LIMIT 1");

        $preparedStatement->bind_param('s', $email);

        $preparedStatement->execute();

        $result = $preparedStatement->get_result();

        if($result->num_rows === 0) return null;

        $userModelClassInstance->rehydrate($result->fetch_all(MYSQLI_ASSOC)[0]);

        if(!password_verify($password, $userModelClassInstance->password)) return null;

        return $userModelClassInstance;
    }
    
    /**
     *  login a user into $_SESSION variable.
     *
     * @param  mixed $userInstance A model instance with credentials (email & id) to login a user.
     * @return void
     */
    public static function login(mixed $userInstance){
        static::start();
        if(!property_exists($userInstance, 'email'))
            throw new Error('To login a user you need pass at least a email or unique string to identify it.');

        $_SESSION['__auth'] = [
            "user" => $userInstance,
        ];
    }

    public static function logout(){
        unset($_SESSION['__auth']);
        session_abort();
    }
}