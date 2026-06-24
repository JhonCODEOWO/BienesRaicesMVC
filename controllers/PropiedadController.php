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
        echo "crear propiedad";
    }

    function edit(){
        echo "crear editar";
    }
}