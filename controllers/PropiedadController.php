<?php

namespace Controllers;

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
        $errores = Propiedad::getErrors();
        $propiedad = new Propiedad();
        $vendedores = Vendedores::all();

        view('propiedades/CreateView', [
            'errores' => $errores,
            'propiedad' => $propiedad,
            'vendedores' => $vendedores,
        ], 'layout/MainLayout');
    }

    function save(Request $req) {
        $propiedad = new Propiedad($req->body());
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

        $errores = $propiedad->validate();
        $vendedores = Vendedores::all();

        if(!empty($errores)) {
            view('propiedades/CreateView', [
                'errores' => $errores,
                'propiedad' => $propiedad,
                'vendedores' => $vendedores,
            ], 'layout/MainLayout');
            exit;
        }

        if (!is_dir(CARPETA_IMAGENES)) {
            mkdir(CARPETA_IMAGENES);
        }

        $transformedImage->save(CARPETA_IMAGENES."$imageName");
        $propiedad->guardar();
        
        redirectTo('/admin');
    }

    function edit(Request $req){
        $errores = Propiedad::getErrors();
        $propiedad = Propiedad::find($req->getUrlParamValue('id'));

        view('propiedades/UpdateView', [
            "propiedad" => $propiedad,
            "errores" => $errores,
        ], 'layout/MainLayout');
    }

    function update(Request $req) {
        debug($req);
    }
}