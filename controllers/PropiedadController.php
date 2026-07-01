<?php

namespace Controllers;

use Core\Validator;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Models\Propiedad;
use Models\Vendedores;
use Routes\Request;

class PropiedadController {
    function index() {
        $message = query('mensaje');
        $propiedades = Propiedad::all();
        $vendedores = Vendedores::all();

        view('propiedades/admin',
        ['propiedades' => $propiedades, 'vendedores' => $vendedores, 'mensaje' => null], 'layout/MainLayout');
    }

    function create(){
        $propiedad = new Propiedad();
        $vendedores = Vendedores::all();

        view('propiedades/CreateView', [
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
        ], 'layout/MainLayout');
    }

    function save(Request $req) {
        $vendedores = Vendedores::all();
        $propiedad = new Propiedad($req->body());
        $validator = new Validator($req->body(), [
            "titulo" => "required|minLength:10",
            "precio" => "required|min:1000",
            "descripcion" => "required",
            "habitaciones" => "required",
            "wc" => "required",
            "estacionamiento" => "required",
            "idVendedor" => "required",
        ]);

        $result = $validator->validate();

        if($result->hasErrors()) {
            view('propiedades/CreateView', [
                'errores' => $result,
                'propiedad' => $propiedad,
                'vendedores' => $vendedores,
            ], 'layout/MainLayout');
            exit;
        }
        $uploadedFile = $_FILES['imagen']['tmp_name'];
        $imageName = '';
        $transformedImage = null;

        // Make operations to prepare the image to upload and set the name.
        if($uploadedFile){
            $format = explode('/', $_FILES['imagen']['type'])[1];
            $imageName = md5(uniqid(rand(), true)).".$format";

            $manager = new ImageManager(Driver::class);
            $transformedImage = $manager->read($_FILES['imagen']['tmp_name'])->cover(800, 600);
            $propiedad->setImagen($imageName);
        }

        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        $transformedImage->save(CARPETA_IMAGENES."$imageName");
        $propiedad->guardar();
        
        redirectTo('/admin');
    }

    function edit(Request $req){
        $propiedad = Propiedad::find($req->getUrlParamValue('id'));
        $vendedores = Vendedores::all();

        view('propiedades/UpdateView', [
            "propiedad" => $propiedad,
            "vendedores" => $vendedores,
        ], 'layout/MainLayout');
    }

    function update(Request $req) {
        //Get the id from url parameter.
        $id = filter_var($req->getUrlParamValue('id'), FILTER_VALIDATE_INT);

        if(!$id) redirectTo('/admin', [
            "mensaje" => 3
        ]);

        $vendedores = Vendedores::all();
        $propiedad = Propiedad::find($id);
        $validator = new Validator($req->body(), [
            "titulo" => "required|minLength:10",
            "precio" => "required|min:1000",
            "descripcion" => "required",
            "habitaciones" => "required",
            "wc" => "required",
            "estacionamiento" => "required",
            "idVendedor" => "required",
        ]);
        $errorBag = $validator->validate();

        if($errorBag->hasErrors()){
            view('propiedades/UpdateView', [
                "errores" => $errorBag,
                "propiedad" => $propiedad,
                "vendedores" => $vendedores,
            ], "layout/MainLayout");
            exit;
        }

        $propiedad->rehydrate($req->body());

        //Try to get uploaded files.
        $image = $_FILES['imagen'] ?? null;
        $imageName = '';
        $transformedImage = null;

        //Upload new image
        if(
            $image &&
            $image['error'] === UPLOAD_ERR_OK && is_uploaded_file($image['tmp_name'])
        ){
            //Delete previous image.
            $propiedad->deleteImage();
        }
    }
}