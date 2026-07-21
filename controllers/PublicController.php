<?php

namespace Controllers;

use Models\Propiedad;

class PublicController {
    public function index() {
        $propiedades = Propiedad::limit(5);
        view('public/index', 
            ["propiedades" => $propiedades], 
            'layout/MainLayout'
        );
    }

    public function about() {
        view(
            "public/about", 
            [], 
            'layout/MainLayout'
        );
    }

    public function propiedades() {

    }

    public function propiedad() {

    }

    public function contactUs(){

    }
}