<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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

Route::get('/addUsers', function () {
    return view('register');
});

Route::get('/amigo', function () {
    return view('amigo');
});

Route::post('/upload-files', function (Request $request) {
    info('Buenas1');

    // Procesamiento de archivos
    if ($request->hasFile('files')) {
        $uploadedFiles = [];

        foreach ($request->file('files') as $file) {
            // Guarda el archivo en la carpeta deseada (por ejemplo, storage/app/uploads)
            $path = $file->store('uploads');
            // Almacena el nombre original del archivo
            $uploadedFiles[] = $file->getClientOriginalName();
        }

        info('Archivos cargados:', $uploadedFiles);

        return redirect('amigo')->with(['uploadedFiles' => $uploadedFiles]);
    } else {
        info('No se ha seleccionado ningún archivo');
        return 'No se ha seleccionado ningún archivo';
    }
})->name('upload.files');

Route::post('/login', function (Request $request, UserController $userController) {
    $username = $request->input('username');
    $password = $request->input('password');
    $usuarios =  $userController->obtenerUsuarios();

    foreach ($usuarios['usuarios'] as $usuario) {
        $usernameDB = $usuario->username;
        $passwordDB = $usuario->password;

        $verify_password = password_verify($password, $passwordDB);
    
        if($usernameDB == $username && $verify_password){
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

    if ($request->hasFile('knowledge')) {
        $knowledgeContents = [];

        foreach ($request->file('knowledge') as $knowledgeFile) {
            $knowledgeContents[] = [
                'name' => 'knowledge_base[]',
                'contents' => file_get_contents($knowledgeFile),
                'filename' => $knowledgeFile->getClientOriginalName()
            ];
        }

        $httpRequest = $httpRequest->attach($knowledgeContents);
    }
    /*$category = $request->file('category');
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
    }*/

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

Route::post('/register', function (Request $request, UserController $userController) {
    $username = $request->input('username');
    $password = password_hash($request->input('password'), PASSWORD_DEFAULT);
    $passwordR = $request->input('passwordR');
    
    $verify = password_verify($passwordR, $password);

    info($password);
    info($passwordR);

    $usuarios = $userController->obtenerUsuarios();
    
    foreach($usuarios['usuarios'] as $usuario) {
        $usernameDB = $usuario->username;
    
        if($usernameDB == $username){
            return redirect('/addUsers')->with('notSamePwd', NULL)->with('userCreated', NULL)->with('userExists', 'User already exists');
        }
    } 

    if (!$verify) {
        return redirect('/addUsers')->with('notSamePwd', 'Password must be the same')->with('userCreated', NULL)->with('userExists', NULL);
    }

    $userController->añadirUsuarios($username, $password);

    return redirect('/addUsers')->with('userCreated', 'User created successfully')->with('notSamePwd', NULL)->with('userExists', NULL);
});
