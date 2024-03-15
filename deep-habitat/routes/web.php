<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

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

Route::get('/login', function () {
    Session::forget('username');
    return view('welcome');
});

Route::get('/', [JobController::class, 'mostrarJobs']);

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
            return redirect('/');
        }
    }

    return redirect('/login');
});

Route::post('/insertar', function (Request $request, JobController $jobController) {

    $name = $request->input('name');
    if($name == '') $name = 'Job';
    
    $file = $request->file('file');
    $fileContents = file_get_contents($file);

    // // Construir los encabezados
    // $headers = [
    //     'Content-Type' => 'multipart/form-data',
    //     'Content-Length' => strlen($fileContents),
    // ];

    // // Realizar la solicitud HTTP con Http::withHeaders() para enviar los encabezados personalizados
    // $httpRequest = Http::withHeaders($headers);

    // // Adjuntar el archivo al objeto de solicitud HTTP
    $httpRequest = Http::attach('master_data', $fileContents, $file->getClientOriginalName());

    // // Realizar la solicitud POST
    $response = $httpRequest->post('http://54.77.9.243:8008/upload_master_data');

    //$url = 'http://54.77.9.243:8008/health';

    //$response = Http::get($url);

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        // La solicitud fue exitosa, puedes trabajar con la respuesta
        $datosRespuesta = $response->json();
        $petitionId = $datosRespuesta['response']['petition_id'];
        // Haz algo con los datos de la respuesta
        info('Datos: ' . $petitionId);
        $jobController->insertarJob($name, $petitionId);
    } else {
        // La solicitud no fue exitosa, maneja el error
        $mensajeError = $response->body();
        // Haz algo con el mensaje de error
        info('Error: ' . $mensajeError);
    }

    return redirect('/');
});
