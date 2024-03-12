<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function mostrarUsuarios()
    {
        $usuarios = User::all();
        info($usuarios);
        return view('usuarios', ['usuarios' => $usuarios]);
    }
}

?>