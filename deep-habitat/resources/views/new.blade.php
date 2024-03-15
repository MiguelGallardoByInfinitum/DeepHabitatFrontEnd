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
<body class="overflow-hidden h-[100vh] flex items-center justify-center">
    <header class="p-7 absolute top-0 left-6">
        <a href="/" class="bg-primary p-2 rounded-md text-secondary group"><i class='bx bx-arrow-back group-hover:-translate-x-1 transition-all duration-300'></i> Go back</a>
        <h1 class="text-4xl mt-7 font-medium">NEW JOB</h1>
    </header>
    
    <div class="">
        <form action={{ url('insertar') }} method="post" enctype="multipart/form-data" class="new-job-form h-96 rounded-xl shadow-md shadow-dark">
            @csrf
            <input type="text" name="name" placeholder="Name (Default is 'Job')" class="w-80 h-9 text-md text-primary p-2 bg-secondary rounded-lg drop-shadow-md focus:outline-none">
            <!-- <input type="url" name="url" placeholder="URL" required> -->
            <div>
                <input type="file" name="file" accept=".csv, .xlsx" required>
                <label class="text-light text-xs">Enter your csv or xlsx here</label>
            </div>
            <div>
                <input type="file" name="category" accept="">
                <label class="text-light text-xs">Enter the category taxonomy for your file (optional)</label>
            </div>
            <div>
                <input type="file" name="attribute" accept="">
                <label class="text-light text-xs">Enter the attribute taxonomy for your file (optional)</label>
            </div>
            <input type="submit" name="insertar" value="Create Job" class="cursor-pointer bg-tertiary p-2 rounded-full border-light border-2 text-light hover:scale-110 hover:bg-light hover:border-tertiary hover:text-tertiary transition-all duration-200">
        </form>
    </div>
</body>
</html>