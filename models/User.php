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
}