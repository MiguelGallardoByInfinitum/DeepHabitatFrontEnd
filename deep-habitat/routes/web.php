<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::get('/usuarios', [UserController::class, 'mostrarUsuarios']);

Route::post('/post', function (UserController $userController) {
    $usuarios = $userController->mostrarUsuarios();

    if($usuarios->username == $_POST['username'] && $usuarios->password == $_POST['password'])

    return redirect('/historic');
});