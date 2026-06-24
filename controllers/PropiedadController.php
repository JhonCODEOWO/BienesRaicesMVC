<?php

namespace Controllers;

class PropiedadController {
    function index() {
        view('propiedades/admin', ['title' => 'Prueba'], 'layout/MainLayout');
    }

    function create(){
        echo "crear propiedad";
    }

    function edit(){
        echo "crear editar";
    }
}