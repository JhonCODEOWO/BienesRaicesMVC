<?php

namespace Controllers;

use Core\Validator;
use Models\Vendedores;
use Routes\Request;

class VendedoresController {
    public function create(Request $req) {
        return view('vendedores/Create', ["errors" => null], 'layout/MainLayout');
    }

    public function store(Request $req) {
        $body = $req->body();
        $validator = new Validator($body, [
            "vendedor.nombre" => "required",
            "vendedor.apellido" => "required",
            "vendedor.telefono" => "required|minLength:10",
        ]);

        $errors = $validator->validate();
        $vendedor = new Vendedores([
            "nombre" => $body['vendedor']['nombre'],
            "apellido" => $body['vendedor']['apellido'],
            "telefono" => $body['vendedor']['telefono'],
        ]);

        if($errors->hasErrors()) {
            view('vendedores/Create', [
                "vendedor" => $vendedor,
                "errors" => $errors
            ], 'layout/MainLayout');
            exit;
        }

        $vendedor->guardar();

        redirectTo('/admin');
    }

    public function edit(Request $req) {
        $id = filter_var($req->getUrlParamValue('id'), FILTER_VALIDATE_INT);
        $vendedor = Vendedores::find($id);

        view('vendedores/Edit', [
            "vendedor" => $vendedor,
            "errores" => null,
        ], 'layout/MainLayout');
    }

    public function update(Request $req) {
        $body = $req->body();
        $id = filter_var($req->getUrlParamValue('id'), FILTER_VALIDATE_INT);

        $vendedor = Vendedores::find($id);
        $vendedor->rehydrate([
            "nombre" => $body['vendedor']['nombre'],
            "apellido" => $body['vendedor']['apellido'],
            "telefono" => $body['vendedor']['telefono']
        ]);

        $validator = new Validator($body, [
            "vendedor.nombre" => "required",
            "vendedor.apellido" => "required",
            "vendedor.telefono" => "required|minLength:10",
        ]);

        $errors = $validator->validate();

        if($errors->hasErrors()) {
            view('vendedores/Create', [
                "vendedor" => $vendedor,
                "errors" => $errors
            ], 'layout/MainLayout');
            exit;
        }

        $vendedor->update();

        redirectTo('/admin');
    }

    function delete(Request $req) {
        $id = filter_var($req->getUrlParamValue('id'), FILTER_VALIDATE_INT);

        if(!$id) redirectTo('/admin');

        $vendedor = Vendedores::find($id);

        $vendedor->delete();

        redirectTo("/admin", ["mensaje" => 4]);
    }
}