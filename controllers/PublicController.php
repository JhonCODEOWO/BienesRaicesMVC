<?php

namespace Controllers;

use Models\Propiedad;
use Routes\Request;

class PublicController {
    public function index() {
        $propiedades = Propiedad::limit(5);
        view('public/index', 
            ["propiedades" => $propiedades, "onLimit" => true], 
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
        $propiedades = Propiedad::all();
        view('public/propiedades', [
            "propiedades" => $propiedades
        ], 'layout/MainLayout');
    }

    public function propiedad(Request $req) {
        debug($req->getUrlParamValue('id'));
    }

    public function contactUs(){

    }
}