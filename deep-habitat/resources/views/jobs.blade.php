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
    <title>Jobs</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="selection:text-light selection:bg-primarySelection">
    <header class="flex justify-between items-center p-7">
        <h1 class="text-4xl font-bold text-primary">{{ Session::get('username') }}</h1>
        <nav class="flex justify-center items-center gap-5">
            <a href="/new" class="bg-primary text-light p-2 rounded-md drop-shadow-lg hover:-translate-y-1 transition-all duration-300 select-none"><i class='bx bx-plus translate-y-0.5'></i> New Job</a>
            <a href="/login" class="hover:-translate-y-1 transition-transform duration-300">Log Out</a>
        </nav>
    </header>
    <div class="flex justify-center items-start flex-col mr-7 ml-7 sm:mr-14 sm:ml-14 md:mr-36 md:ml-36 mt-10">
        <h3 class="text-2xl">Historic</h3>
        <div class="w-full jobs mt-6 mb-32">
            @foreach($jobs->reverse() as $job)
                <div class="job group" data-aos="fade-up">
                    <p class="job-text">{{ $job->id }}. {{ $job->name }}</p>
                    <form action={{ url('download') }} method="post">
                    @csrf
                        <input type="hidden" name="petition_id" value={{ $job->petition_id }}>
                        @if (session('in_progress') && session('petition_id') == $job->petition_id)
                            <button class="job-btn" type="submit" name="download"><i class='bx bx-loader-alt bx-spin' ></i> {{ session('in_progress') }}</button>
                        @endif
                        @if (!session('in_progress') || session('petition_id') != $job->petition_id)
                            <button class="job-btn" type="submit" name="download"><i class='bx bxs-cloud-download translate-y-0.5'></i> Download</button> 
                        @endif
                    </form>
                </div>
            @endforeach
        </div>
    </div>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>