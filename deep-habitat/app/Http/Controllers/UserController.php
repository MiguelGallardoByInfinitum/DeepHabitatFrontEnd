<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function obtenerUsuarios()
    {
        $usuarios = User::all();
        return ['usuarios' => $usuarios];
    }
}

?>