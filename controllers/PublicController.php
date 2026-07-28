<?php

namespace Controllers;

use Core\Validator;
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
        $id = filter_var($req->getUrlParamValue('id'), FILTER_VALIDATE_INT);

        if(!$id) redirectTo('/');

        $propiedad = Propiedad::find($id);

        view(
            'propiedades/propiedad',
            [
                "propiedad" => $propiedad
            ],
            'layout/MainLayout'
        );
    }

    public function contactUs(){
        view('public/contactUs', [], 'layout/MainLayout');
    }

    public function contactingUs(Request $req){
        $body = $req->getBody([
            "opciones" => null,
            "tipo_contacto" => null,
        ]);

        $validator = new Validator($body, [
            'nombre' => 'required',
            'email' => 'required',
            'telefono' => 'required',
            'mensaje' => 'required',
            'opciones' => 'required',
            'tipo_contacto' => 'required',
        ]);

        $resultErrors = $validator->validate();

        if($resultErrors->hasErrors()){
            view('public/contactUs', [
                "errors" => $resultErrors
            ], 'layout/MainLayout');
            exit;
        }
    }
}