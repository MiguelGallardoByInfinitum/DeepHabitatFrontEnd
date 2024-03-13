<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
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
    Session::forget('username');
    return view('welcome');
});

Route::get('/historic', function () {
    return view('historic');
});

Route::get('/jobs', [JobController::class, 'mostrarJobs']);

Route::get('/new', function () {
    return view('new');
});

Route::post('/login', function (Request $request, UserController $userController) {
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
            Session::put('username', $username);
            info("Session");
            return redirect('/jobs');
        }
    }

    return redirect('/');
});

Route::post('/insertar', function (Request $request, JobController $jobController) {

    $name = $request->input('name');
    if($name == '') $name = 'Job';
    
    $url = $request->input('url');

    $jobController->insertarJob($name, $url);

    return redirect('/jobs');
});
