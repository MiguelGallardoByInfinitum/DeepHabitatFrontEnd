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
            return redirect('/');
        }
    } 

    return redirect('/login')->with('no_login', 'Incorrect credentials. Try again.');
});

Route::post('/insertar', function (Request $request, JobController $jobController) {

    $name = $request->input('name');
    if ($name == '') $name = 'Job';

    $file = $request->file('file');
    $fileContents = file_get_contents($file);
    $fileExtension = $file->getClientOriginalExtension();
    if ($fileExtension !== 'csv' && $fileExtension !== 'xlsx') return redirect('/new')->with('file_error', 'Invalid file extension');

    // Adjuntar el archivo al objeto de solicitud HTTP
    $httpRequest = Http::attach('master_data', $fileContents, $file->getClientOriginalName());

    $category = $request->file('category');
    $attribute = $request->file('attribute');

    if ($category) {
        $categoryContents = file_get_contents($category);
        $categoryExtension = $category->getClientOriginalExtension();
        if ($categoryExtension !== 'csv' && $categoryExtension !== 'xlsx') return redirect('/new')->with('category_error', 'Invalid category extension');
        $httpRequest = $httpRequest->attach('category_taxonomy', $categoryContents, $category->getClientOriginalName());
    }

    if ($attribute) {
        $attributeContents = file_get_contents($attribute);
        $attributeExtension = $attribute->getClientOriginalExtension();
        if ($attributeExtension !== 'csv' && $attributeExtension !== 'xlsx') return redirect('/new')->with('attribute_error', 'Invalid attribute extension');
        $httpRequest = $httpRequest->attach('attribute_taxonomy', $attributeContents, $attribute->getClientOriginalName());
    }

    // Realizar la solicitud POST
    $response = $httpRequest->post('http://54.77.9.243:8008/upload_master_data');

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        // La solicitud fue exitosa, puedes trabajar con la respuesta
        $datosRespuesta = $response->json();
        $petitionId = $datosRespuesta['response']['petition_id'];
        // Haz algo con los datos de la respuesta
        $jobController->insertarJob($name, $petitionId);
    } else {
        // La solicitud no fue exitosa, maneja el error
        $mensajeError = $response->body();
        // Haz algo con el mensaje de error
        info('Error: ' . $mensajeError);
    }

    return redirect('/');
});

Route::post('/download', function (Request $request) {
    $petitionId = $request->input('petition_id');
    Session::put('petition_id', $petitionId);

    $url = "http://54.77.9.243:8008/get_enhanced_data?petition_id=$petitionId";

    $response = Http::get($url);

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        // La solicitud fue exitosa, puedes trabajar con la respuesta
        $datosRespuesta = $response->json();
        $status = $datosRespuesta['response']['status'];
        $status = 'ERROR';
        if ($status == 'DONE') {
            if(Session::has('in_progress')) {
                Session::forget('in_progress');
                Session::forget('petition_id');
                Session::forget('error');
                return redirect('/');
            } else {
                $enhancedDataUrls = $datosRespuesta['response']['enhanced_data_urls'][0];
                return redirect($enhancedDataUrls);
            }
        } else if ($status == 'ERROR') {
            Session::put('error', 'Error');
        }
    } else {
        // La solicitud no fue exitosa, maneja el error
        $mensajeError = $response->body();
        // Haz algo con el mensaje de error
        info('Error: ' . $mensajeError);
    }

    Session::put('in_progress', 'In Progress');

    return redirect('/');
});
