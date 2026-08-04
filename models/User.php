<?php

namespace Models;

class User extends ActiveRecord{
    protected static string $table = 'usuarios';
    protected static string $idName = 'idUsuario';
    protected static array $columns = ['email', 'password'];


    public ?int $idUsuario;
    public string $email;
    public string $password;

    public function __construct(?array $args = [])
    {
        $this->idUsuario = isset($args['idUsuario'])? 
            filter_var($args['idUsuario']): null;
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
    }

    public function canAuthenticate(): bool{
        $query = "SELECT * FROM " . static::$table . " WHERE email = '" . $this->email . "' LIMIT 1";

        $result = static::$db->query($query);

        if($result->num_rows === 0) return false;
        
        $user = static::createObject($result->fetch_all(MYSQLI_ASSOC)[0]);
        
        //Check if the given credentials match.
        return password_verify($this->password, $user->password);
    }
}