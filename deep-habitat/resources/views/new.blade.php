<?php
use Illuminate\Support\Facades\Session;
if(!Session::has('username')) {
    header('Location: /login');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>New Job</title>
    @vite('resources/css/app.css')
</head>
<body class="overflow-hidden">
    <header class="p-7">
    <a href="/" class="bg-primary p-2 rounded-md text-secondary group"><i class='bx bx-arrow-back group-hover:-translate-x-1 transition-all duration-300'></i> Go back</a>
    <h1 class="text-4xl mt-7 font-medium">NEW JOB</h1>
    </header>
    
    <form action={{ url('insertar') }} method="post" class="new-job-form">
        @csrf
        <input type="text" name="name" placeholder="Name (Default is 'Job')">
        <!-- <input type="url" name="url" placeholder="URL" required> -->
        <input type="file" name="" id="" accept=".csv, .xlsx">
        <input type="submit" name="insertar" value="Create Job">
    </form>
</body>
</html>