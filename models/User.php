<?php

namespace Models;

class User extends ActiveRecord{
    protected static $table = 'usuarios';
    protected static $idName = 'idUsuario';
    protected static $columns = ['email', 'password'];


    public ?int $idUsuario;
    public string $email;
    public string $password;

    public function __construct(array $args)
    {
        $this->idUsuario = $args['idUsuario'] ?? null;
        $this->idUsuario = $args['email'] ?? '';
        $this->idUsuario = $args['password'] ?? '';
    }
}