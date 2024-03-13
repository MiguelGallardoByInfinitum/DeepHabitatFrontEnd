<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
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

Route::get('/jobs', [JobController::class, 'mostrarJobs']);

Route::get('/new', function () {
    return view('new');
});

Route::post('/post', function (Request $request, UserController $userController) {
    $username = $request->input('username');
    $password = $request->input('password');
    info($username);
    info($password);

    $usuarios =  $userController->obtenerUsuarios();
    info($usuarios);

    foreach ($usuarios['usuarios'] as $usuario) {
        $usernameDB = $usuario->username;
        $passwordDB = $usuario->password;
        info($usernameDB);
        info($passwordDB);
    
        if($usernameDB == $username && $passwordDB == $password){
            return redirect('/historic');
        }
    }

    return redirect('/');
});
