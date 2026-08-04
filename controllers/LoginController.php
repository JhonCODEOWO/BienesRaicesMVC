<?php

namespace Controllers;

use Core\Validator;
use Models\User;
use Routes\Request;

class LoginController {
    public function login(){
        view('Auth/login', [], 'layout/MainLayout');
    }

    public function authenticate(Request $req){
        $body = $req->getBody();
        $user = new User($body);

        $validator = new Validator($body, [
            "email" => "required|email",
            "password" => "required|minLength:8"
        ]);

        $errors = $validator->validate();

        if($errors->hasErrors()) {
            view(
                'Auth/login',
                [
                    "errors" => $errors,
                ],
                'layout/MainLayout'
            );
            exit;
        }

        $ableToAuth = $user->canAuthenticate();

        if(!$ableToAuth) {
            $errors->add('No se puede autenticar', 'login');
            view(
                'Auth/login',
                [
                    "errors" => $errors
                ],
                'layout/MainLayout',
            );
            exit;
        }

        
        redirectTo('/');
    }

    public function register(){

    }

    public function createAccount(){

    }
}