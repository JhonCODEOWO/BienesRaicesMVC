<?php

namespace Controllers;

use Core\Auth;
use Core\JustArray\JustArray;
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

        $ableToAuth = Auth::attempt(
            JustArray::find($body, 'email'), 
            JustArray::find($body, 'password'), 
            [User::class, 'usuarios']
        );

        if($ableToAuth === null) {
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

        Auth::login(["id" => $ableToAuth->idUsuario]);
        redirectTo('/');
    }

    public function logout(){
        Auth::logout();
        redirectTo('/');
    }

    public function createAccount(Request $req){
        $body = $req->body();
        $validator = new Validator($body, [
            "email" => "required",
            "password" => "required|minLength:8",
            "password_confirmation" => "required|minLength:8|confirmed:password",
        ]);

        $errors = $validator->validate();

        if($errors->hasErrors()){
            view(
                'Auth/register', 
                [
                    "errors" => $errors
                ], 
                'layout/MainLayout');
            exit;
        }

        $user = new User([
            "email" => JustArray::find($body, 'email'),
            "password" => password_hash(JustArray::find($body, 'password'), PASSWORD_BCRYPT)
        ]);

        $user->guardar();
        redirectTo('/');
    }

    public function register(){
        view('Auth/register', [], 'layout/MainLayout');
    }
}