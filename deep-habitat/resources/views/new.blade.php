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
    <link rel="icon" href="{{ asset('media/DeepHABITAT Logo white.png') }}">
    <title>New Job</title>
    @vite('resources/css/app.css')
</head>
<body class="overflow-hidden h-[100vh] flex items-center justify-center">
    <header class="sm:p-7 pt-7 absolute top-0 left-6 p-0">
        <a href="/" class="bg-primary p-2 rounded-md text-secondary group"><i class='bx bx-arrow-back group-hover:-translate-x-1 transition-all duration-300'></i> Go back</a>
        <h1 class="text-4xl mt-7 font-medium">NEW JOB</h1>
    </header>
    
    <div class="">
        <form action="{{ url('insertar') }}" method="post" enctype="multipart/form-data" class="new-job-form h-96">
            @csrf
            <input type="text" name="name" placeholder="Job Name (Default is 'Job')" class="w-80 h-10 text-md text-primary p-2 bg-secondary rounded-lg focus:outline-none border-[1px] border-primary2">
            <div>
                <label class="text-dark text-xs opacity-60">Enter your csv or xlsx here</label>
                <input type="file" name="file" accept=".csv, .xlsx" required class="text-primary2 file:text-primary file:bg-primaryShaded file:border-0 file: file:rounded-lg file:py-2 file:px-4 file:font-semibold file:text-sm transition-all duration-300 cursor-pointer file:hover:opacity-70 mt-2 file:cursor-pointer">
                @if (session('file_error'))
                    <label class="text-error">Invalid file extension</label>
                @endif
            </div>
            <div>
                <label class="text-dark text-xs opacity-60">Enter the knowledge files (optional)</label>
                <input type="file" name="knowledge[]" accept=".csv" multiple class="text-primary2 file:text-primary file:bg-primaryShaded file:border-0 file: file:rounded-lg file:py-2 file:px-4 file:font-semibold file:text-sm transition-all duration-300 cursor-pointer file:hover:opacity-70 mt-2 file:cursor-pointer">
                @if (session('knowledge_error'))
                    <label class="text-error">Invalid knowledge file extension</label>
                @endif
            </div>
            <input type="submit" name="insertar" value="Create Job" class="cursor-pointer bg-primary p-2 rounded-lg border-light border-2 text-light hover:-translate-y-1 hover:bg-light hover:border-primary hover:text-primary transition-all duration-300 mt-4">
        </form>
    </div>
</body>
</html>