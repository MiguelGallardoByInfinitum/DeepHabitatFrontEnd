<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AMIGO</title>
</head>
<body>
    <form action="{{ url('/upload-files') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="files[]" multiple>
        <button type="submit">Subir archivos</button>
    </form>
    <h1>Archivos Cargados:</h1>
    <ul>
        @if(session('uploadedFiles'))
            @foreach (session('uploadedFiles') as $file)
                <li>{{ $file }}</li>
            @endforeach
        @endif
    </ul>
</body>
</html>
