<?php
// $hola = "Guillem";
// if($hola != "Guillem"){
//     header('Location: /');
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historic</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    @vite('resources/css/app.css')
</head>
<body class="selection:text-light selection:bg-primarySelection">
    <header class="flex justify-between items-center p-7">
        <h1 class="text-4xl font-bold text-primary">Por decidir</h1>
        <nav class="flex justify-center items-center gap-5">
            <a href="/new" class="bg-primary text-light p-2 rounded-md drop-shadow-lg hover:bg-primary2 hover:-translate-y-1 transition-all duration-300 select-none"><i class='bx bx-plus translate-y-0.5'></i> New Job</a>
            <a href="/" class="hover:-translate-y-1 transition-transform duration-300">Log Out</a>
        </nav>
    </header>
    <div class="flex justify-center items-start flex-col mr-36 ml-36 mt-10">
        <h3 class="text-2xl">HISTÓRICO</h3>
        <div class="w-full jobs mt-6">
            <div class="job">
                <p class="job-text">Job 1...</p>
                <button class="job-btn">Descargar CSV</button>
            </div>
            <div class="job">
                <p class="job-text">Job 2...</p>
                <button class="job-btn">Descargar CSV</button>
            </div>
            <div class="job">
                <p class="job-text">Job 3...</p>
                <button class="job-btn">Descargar CSV</button>
            </div>
            <div class="job">
                <p class="job-text">Job 4...</p>
                <button class="job-btn">Descargar CSV</button>
            </div>
            <div class="job">
                <p class="job-text">Job 5...</p>
                <button class="job-btn">Descargar CSV</button>
            </div>
        </div>
    </div>
</body>
</html>