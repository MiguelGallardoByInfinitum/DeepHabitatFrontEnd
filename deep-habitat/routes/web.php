<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/historic', function () {
    return view('historic');
});

Route::get('/new', function () {
    return view('new');
});

Route::post('/post', function (Request $request, UserController $userController) {
    $username = $request->input('username');
    $password = $request->input('password');

    $usuarios =  $userController->mostrarUsuarios();

    foreach ($usuarios['usuarios'] as $usuario) {
        $usernameDB = $usuario->username;
        $passwordDB = $usuario->password;
    
        if($usernameDB == $username && $passwordDB == $password){
            info('Funciona');
            return redirect('/historic');
        }
    }
});
