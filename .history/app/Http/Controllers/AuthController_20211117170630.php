<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request) {

        $credenciais = $request->all(['email', 'password']);

        // autenticação (email e senha)
        $token = auth('api')->attempt($credenciais);

        dd($token);

        return 'Login';
    }

    public function logout() {
        return 'Logout';
    }

    public function refresh() {
        return 'Refresh';
    }

    public function me() {
        return 'Me';
    }
}
