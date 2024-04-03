<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends Controller
{
    public function upload(Request $request)
    {
        // Validación de los archivos
        $validator = Validator::make($request->all(), [
            'files.*' => 'required|mimes:csv,xlsx'
        ]);

        // Comprueba si la validación ha fallado
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Procesamiento de archivos si la validación es exitosa
        if ($request->hasFile('files')) {
            $uploadedFiles = [];

            foreach ($request->file('files') as $file) {
                // Guarda el archivo en la carpeta deseada (por ejemplo, storage/app/uploads)
                $path = $file->store('uploads');
                // Almacena el nombre original del archivo
                $uploadedFiles[] = $file->getClientOriginalName();
            }

            // Almacenar los archivos cargados en la sesión
            Session::put('uploadedFiles', $uploadedFiles);
            
            // Información sobre los archivos cargados
            info('Archivos cargados:', $uploadedFiles);
            info('Archivos en la sesión:', Session::get('uploadedFiles'));
        }

        // Redirigir a la vista amigo.blade.php
        return view('amigo');
    }
}
