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
    @vite('resources/css/app.css')
</head>
<body>
    <header class="flex justify-between items-center p-7">
        <h1 class="text-4xl font-bold">HISTORIC</h1>
        <nav class="flex justify-center items-center gap-5">
            <a href="/new" class="bg-primary text-light p-2 rounded-md drop-shadow-lg">New Job</a>
            <a href="/" class="">Log Out</a>
        </nav>
    </header>
    <div class="flex justify-center items-start flex-col ml-36 mt-10">
        <h3 class="text-2xl">Jobs</h3>
        <div class="jobs mt-6">
            <p>Job 1...</p>
            <p>Job 2...</p>
            <p>Job 3...</p>
            <p>Job 4...</p>
            <p>Job 5...</p>
        </div>
    </div>
</body>
</html>