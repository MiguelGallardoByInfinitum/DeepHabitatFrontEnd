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
    <link rel="icon" href="{{ asset('media/DeepHABITAT logo blue.png') }}">
    <title>New Moodboard</title>
    @vite('resources/css/app.css')
</head>
<body class="overflow-hidden h-[100vh] flex items-center justify-center">
    <header class="sm:p-7 pt-7 absolute top-0 left-6 p-0">
        <a href="/moodboard" class="bg-primary p-2 rounded-md text-secondary group"><i class='bx bx-arrow-back group-hover:-translate-x-1 transition-all duration-300'></i> Go back</a>
        <h1 class="text-4xl mt-7 font-medium">NEW MOODBOARD</h1>
    </header>
    
    <div class="">
        <form action="{{ url('insertarMoodboards') }}" method="post" enctype="multipart/form-data" class="new-job-form h-96">
            @csrf
            @if (session('error_post'))
                <label class="text-error">The petition has returned an error</label>
            @endif
            <input type="text" name="title" placeholder="Moodboard title (Default is 'Moodboard')" class="w-80 h-10 text-md text-primary p-2 bg-secondary rounded-lg focus:outline-none border-[1px] border-primary2">
            <div class="flex flex-col items-start"> 
                <label for="canvas" class="text-dark text-xs opacity-60">Select your canvas mode desired</label>
                <select name="canvas" class="text-primary p-1 rounded-lg cursor-pointer focus:border-0 focus:outline-none active:border-0">
                    <option value="squared">Squared</option>
                    <option value="horizontal">Horizontal</option>
                    <option value="vertical">Vertical</option>
                </select>
            </div>
            <div class="flex flex-col items-start"> 
                <label for="palette" class="text-dark text-xs opacity-60">Select your palette mode desired</label>
                <select name="palette" class="text-primary p-1 rounded-lg cursor-pointer focus:border-0 focus:outline-none active:border-0">
                    <option value="rectangle">Rectangle</option>
                    <option value="circle">Circle</option>
                </select>
            </div>
            <div class="flex flex-col items-start"> 
                <label for="background" class="text-dark text-xs opacity-60">Select your background mode desired</label>
                <select name="background" class="text-primary p-1 rounded-lg cursor-pointer focus:border-0 focus:outline-none active:border-0">
                    <option value="plain">Plain</option>
                    <option value="textured">Textured</option>
                </select>
            </div>

            <div>
                <label class="text-dark text-xs opacity-60">Enter your csv here</label>
                <input type="file" name="file" accept=".csv" required class="text-primary2 file:text-primary file:bg-primaryShaded file:border-0 file: file:rounded-lg file:py-2 file:px-4 file:font-semibold file:text-sm transition-all duration-300 cursor-pointer file:hover:opacity-70 mt-2 file:cursor-pointer">
                @if (session('file_error'))
                    <label class="text-error">Invalid file extension</label>
                @endif
            </div>
            <div>
                <label class="text-dark text-xs opacity-60">Enter the item images (optional)</label>
                <input type="file" name="images[]" accept=".jpg, .jpeg, .png" multiple class="text-primary2 file:text-primary file:bg-primaryShaded file:border-0 file: file:rounded-lg file:py-2 file:px-4 file:font-semibold file:text-sm transition-all duration-300 cursor-pointer file:hover:opacity-70 mt-2 file:cursor-pointer">
                @if (session('image_error'))
                    <label class="text-error">Invalid item images</label>
                @endif
            </div>
            <input type="submit" name="insertar" value="Create Job" class="cursor-pointer bg-primary p-2 rounded-lg border-light border-2 text-light hover:-translate-y-1 hover:bg-light hover:border-primary hover:text-primary transition-all duration-300 mt-4">
        </form>
    </div>
</body>
</html>