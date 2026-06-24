<?php

namespace Controllers;

use Models\Propiedad;
use Models\Vendedores;

class PropiedadController {
    function index() {
        $propiedades = Propiedad::all();
        $vendedores = Vendedores::all();

        view('propiedades/admin',
        ['propiedades' => $propiedades, 'vendedores' => $vendedores, 'mensaje' => null], 'layout/MainLayout');
    }

    function create(){
        $errores = Propiedad::getErrors();
        $propiedad = new Propiedad();
        $vendedores = Vendedores::all();

        view('propiedades/CreateView', [
            'errores' => $errores,
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
        ], 'layout/MainLayout');
    }

    function edit(){
        echo "crear editar";
    }
}