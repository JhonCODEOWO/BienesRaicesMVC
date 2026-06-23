<?php

namespace Models;

use Override;

class Vendedores extends ActiveRecord {
    protected static string $table = 'vendedores';
    protected static array $columns = ['idVendedor', 'nombre', 'apellido', 'telefono'];
    protected static string $idName = 'idVendedor';

    public int $idVendedor;
    public string $nombre;
    public string $apellido;
    public string $telefono;

    public function __construct($args = [])
    {
        $this->idVendedor =(int) ($args['idVendedor'] ?? -1);
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = (float) ($args['apellido'] ?? 0);
        $this->apellido = $args['apellido'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
    }

    #[Override]
    public function validate()
    {
        if(!$this->nombre) self::$errors[] = 'El nombre es requerido';
        if(!$this->apellido) self::$errors[] = 'El apellido es requerido';
        if(!$this->telefono) self::$errors[] = 'El telefono es requerido';
        if(!preg_match('/[0-9]{10} /',$this->telefono)) self::$errors[] = 'Asegúrate de escribir un número de teléfono válido.';
        return self::$errors;
    }
}