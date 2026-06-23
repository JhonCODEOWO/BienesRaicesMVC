<?php

namespace Models;

class Propiedad extends ActiveRecord{
    protected static string $table = 'propiedades';
    protected static array $columns = ['idPropiedades', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento', 'creado', 'idVendedor'];
    protected static string $idName = 'idPropiedades';

    public int $idPropiedades;
    public string $titulo;
    public string | null $imagen;
    public float $precio;
    public string $descripcion;
    public int $habitaciones;
    public int $wc;
    public string $estacionamiento;
    public string $creado;
    public int | null $idVendedor;

    public function __construct($args = [])
    {
        $this->idPropiedades =(int) ($args['idPropiedades'] ?? -1);
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = (float) ($args['precio'] ?? 0);
        $this->descripcion = $args['descripcion'] ?? '';
        $this->imagen = $args['imagen'] ?? null;
        $this->habitaciones = (int) ($args['habitaciones'] ?? 0);
        $this->wc =(int) ($args['wc'] ?? 0);
        $this->estacionamiento = (int) ($args['estacionamiento'] ?? 0);
        $this->creado = date('Y/m/d');
        $this->idVendedor = (int) ($args['idVendedor'] ?? null);
    }

    public function validate(){
        if (strlen($this->titulo) === 0)            self::$errors[] = 'Debes añadir un Titulo';

        if(!$this->precio) self::$errors[] = "Añadir un precio es obligatorio";
        
        if(!$this->descripcion) self::$errors[] = "La propiedad requiere de una descripción";
        
        if(!$this->habitaciones) self::$errors[] = "Coloca la cantidad de habitaciones";
        
        if(!$this->wc) self::$errors[] = "Coloca la cantidad de wc disponibles";
        
        if(!$this->estacionamiento) self::$errors[] = "Coloca la cantidad de estacionamientos";
        
        if(!$this->idVendedor) self::$errors[] = "Selecciona el vendedor de esta propiedad";

        if(!$this->imagen) self::$errors[] = "No has seleccionado aún una imagen";

        return self::$errors;
    }

    public function setImagen(string $imageName) {
        if($this->idPropiedades != -1)          
            $this->deleteImage();

        $this->imagen=$imageName;
    }

    public function deleteImage() {
        $previousPath = CARPETA_IMAGENES . $this->imagen;

        if(file_exists($previousPath)) unlink($previousPath);
    }
}