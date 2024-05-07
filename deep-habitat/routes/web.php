<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\MoodboardController;
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

Route::get('/moodboard', [MoodboardController::class, 'mostrarMoodboards']);

Route::get('/newMoodboard', function() {
    return view('newMoodboard');
});

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
        foreach ($request->file('knowledge') as $knowledgeFile) {
            $knowledgeExtension = $knowledgeFile->getClientOriginalExtension();
            if ($knowledgeExtension !== 'csv') return redirect('/new')->with('knowledge_error', 'Invalid knowledge extension');
            $knowledgeContents = file_get_contents($knowledgeFile);
            $knowledgeFilename = $knowledgeFile->getClientOriginalName();
            $httpRequest = $httpRequest->attach('knowledge_base', $knowledgeContents, $knowledgeFilename);
        }
    }

    // Realizar la solicitud POST
    $response = $httpRequest->post('http://54.77.9.243:8008/enhance_master_data');

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        // La solicitud fue exitosa, puedes trabajar con la respuesta
        $datosRespuesta = $response->json();
        $petitionId = $datosRespuesta['response']['petition_id'];
        // Haz algo con los datos de la respuesta
        $descriptionSelect = $request->input('howPost');
        if ($descriptionSelect === 'noDescription') {
            $jobController->insertarJob($name, $petitionId, false);
        } else {
            $jobController->insertarJob($name, $petitionId, true);
        }
    } else {
        // La solicitud no fue exitosa, maneja el error
        $mensajeError = $response->body();
        // Haz algo con el mensaje de error
        info('Error: ' . $mensajeError);

        return redirect('/new')->with('error_post', 'Petition Error');
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
        if (isset($datosRespuesta['response'])) {
            if(Session::has('in_progress')) {
                Session::forget('in_progress');
                Session::forget('petition_id');
                Session::forget('error');
                return redirect('/');
            } else {
                $enhancedDataUrls = $datosRespuesta['response']['enhanced_data_urls'][0];
                return redirect($enhancedDataUrls);
            }
        } else {
            $detail = $datosRespuesta['detail'];
            info($detail);
            if (isset($detail) && $detail !== 'Petition ' . $petitionId . ' is still processing.') {
                Session::put('error', 'Error');
                return redirect('/');
            }
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

Route::post('/downloadDescription', function (Request $request) {
    $petitionId = $request->input('petition_id');
    Session::put('petition_id_description', $petitionId);

    $url2 = "http://54.77.9.243:8008/enhance_data_with_descriptions?petition_id=$petitionId";

    $responsePost = Http::post($url2);

    if (isset($responsePost['detail'])) {
        Session::put('master_data_processing', 'Master Data is still processing');
        return redirect('/');
    } else {
        Session::forget('master_data_processing');

        $url = "http://54.77.9.243:8008/get_enhanced_data_with_descriptions?petition_id=$petitionId";

        $response = Http::get($url);

        // Verificar si la solicitud fue exitosa
        if ($response->successful()) {
            // La solicitud fue exitosa, puedes trabajar con la respuesta
            $datosRespuesta = $response->json();
            if (isset($datosRespuesta['response'])) {
                if(Session::has('in_progress_description')) {
                    Session::forget('in_progress_description');
                    Session::forget('petition_id_description');
                    Session::forget('error_description');
                    return redirect('/');
                } else {
                    $enhancedDataUrls = $datosRespuesta['response']['enhanced_data_urls'][0];
                    return redirect($enhancedDataUrls);
                }
            } else {
                $detail = $datosRespuesta['detail'];
                info($detail);
                if (isset($detail) && $detail !== 'Petition ' . $petitionId . ' is still processing.') {
                    Session::put('error_description', 'Error');
                    return redirect('/');
                }
            }
        } else {
            // La solicitud no fue exitosa, maneja el error
            $mensajeError = $response->body();
            // Haz algo con el mensaje de error
            info('Error: ' . $mensajeError);
        }

        Session::put('in_progress_description', 'In Progress');
    }

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

Route::post('/insertarMoodboards', function (Request $request, MoodboardController $moodboardController) {
    $moodboardTitle = $request->input('title');
    
    if(!isset($moodboardTitle)) {
        $moodboardTitle = 'Moodboard';
    }
    
    $canvasMode = $request->input('canvas');
    $paletteMode = $request->input('palette');
    $backgroundMode = $request->input('background');

    $file = $request->file('file');
    $fileContents = file_get_contents($file);
    $fileExtension = $file->getClientOriginalExtension();
    if ($fileExtension !== 'csv') return redirect('/newMoodboard')->with('file_error', 'Invalid file extension');

    $httpRequest = Http::attach('item_csv', $fileContents, $file->getClientOriginalName());

    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $imageExtension = $image->getClientOriginalExtension();
            info($imageExtension);
            if ($imageExtension !== 'jpg' && $imageExtension !== 'jpeg' && $imageExtension !== 'png') return redirect('/newMoodboard')->with('image_error', 'Invalid image extension');
            $imageContents = file_get_contents($image);
            $imageName = $image->getClientOriginalName();
            $httpRequest = $httpRequest->attach('item_images', $imageContents, $imageName);
        }
    } else {
        return redirect('/newMoodboard')->with('empty_image', 'You must insert images');
    }

    info($moodboardTitle);
    info($canvasMode);
    info($paletteMode);
    info($backgroundMode);
    $post = 'http://54.77.9.243:8008/generate_moodboard?moodboard_title='. $moodboardTitle .'&canvas_mode='. $canvasMode .'&palette_mode='. $paletteMode .'&background_mode='. $backgroundMode;
    $response = $httpRequest->post($post);

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        // La solicitud fue exitosa, puedes trabajar con la respuesta
        $datosRespuesta = $response->json();
        info($datosRespuesta);
        $moodboardId = $datosRespuesta['response']['moodboard_id'];
        // Haz algo con los datos de la respuesta
        $moodboardController->insertarMoodboard($moodboardTitle, $moodboardId);
    } else {
        // La solicitud no fue exitosa, maneja el error
        $mensajeError = $response->body();
        // Haz algo con el mensaje de error
        info('Error: ' . $mensajeError);

        return redirect('/newMoodboard')->with('error_post', 'Petition Error');
    }

    return redirect('/moodboard');
});

Route::post('/downloadMoodboard', function (Request $request) {
    $moodboardId = $request->input('moodboard_id');
    Session::put('moodboard_id', $moodboardId);

    $url = "http://54.77.9.243:8008/get_moodboard?moodboard_id=$moodboardId";

    $response = Http::get($url);

    info($response);

    // Verificar si la solicitud fue exitosa
    if ($response->successful()) {
        // La solicitud fue exitosa, puedes trabajar con la respuesta
        $datosRespuesta = $response->json();
        if (isset($datosRespuesta['response'])) {
            if(Session::has('in_progress')) {
                Session::forget('in_progress');
                Session::forget('moodboard_id');
                Session::forget('error');
                return redirect('/moodboard');
            } else {
                $moodboardUrl = $datosRespuesta['response']['moodboard_url'];
                return redirect($moodboardUrl);
            }
        } else {
            $detail = $datosRespuesta['detail'];
            if (isset($detail) && $detail === 'Petition ' . $moodboardId . ' failed. Please retry the petition.') {
                Session::put('error', 'Error');
                return redirect('/moodboard');
            }
        }
    } else {
        // La solicitud no fue exitosa, maneja el error
        $mensajeError = $response->body();
        // Haz algo con el mensaje de error
        info('Error: ' . $mensajeError);
    }

    Session::put('in_progress', 'In Progress');

    return redirect('/moodboard');
});
