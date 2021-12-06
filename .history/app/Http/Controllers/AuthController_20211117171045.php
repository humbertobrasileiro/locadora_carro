<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request) {

        $credenciais = $request->all(['email', 'password']);

        // autenticação (email e senha)
        $token = auth('api')->attempt($credenciais);

        if ($token) {

            return response()->json(['token' => $token]);

        } else {

            return response()->json(['erro' => 'Usuário ou senha inválido!');

        }

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
