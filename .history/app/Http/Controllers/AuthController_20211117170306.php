<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function login(Request $request) {

        // autenticação (email e senha)
        dd($request->all(['email', 'password']));

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
