<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
</head>
<body>
    <h1>Lista de Usuarios</h1>
    @foreach($usuarios as $usuario)
        <p>Nombre de usuario: {{ $usuario->username }}, Contraseña: {{ $usuario->password }}</p>
    @endforeach
</body>
</html>
