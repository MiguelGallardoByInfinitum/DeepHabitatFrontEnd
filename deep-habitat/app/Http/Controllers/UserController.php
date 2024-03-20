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

    public function añadirUsuarios($username, $password) 
    {
        $usuario = new User();
        $usuario->username = $username;
        $usuario->password = $password;

        $usuario->save();

        return redirect('/addUsers');
    }
}

?>