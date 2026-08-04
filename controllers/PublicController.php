<?php

namespace Controllers;

use Core\Mailer\Mailer;
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
            'email' => 'requiredIf:tipo_contacto,correo',
            'telefono' => 'requiredIf:tipo_contacto,telefono',
            'tipo_contacto' => 'required',
            'nombre' => 'required',
            'mensaje' => 'required',
            'opciones' => 'required',
            'cantidad' => 'required'
        ]);

        $resultErrors = $validator->validate();

        if($resultErrors->hasErrors()){
            view('public/contactUs', [
                "errors" => $resultErrors
            ], 'layout/MainLayout');
            exit;
        }

        $mailer = new Mailer();
        
        $mailer->subject("Propiedad request")->from()->to([
            "Yo" => "jjv20618@gmail.com"
        ])->useTemplate(
            'contact_us', 
            [
                'nombre' => $body['nombre'],
                'telefono' => $body['telefono'],
                'email' => $body['email'],
                'mensaje' => $body['mensaje'],
                'tipo_contacto' => $body['tipo_contacto'],
                'hora' => $body['hora_contacto'],
                'fecha' => $body['fecha_contacto'],
            ]
        );

        $mailer->send();

        redirectTo('contactUs');
    }
}