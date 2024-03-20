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
        <div class="flex gap-4">
        <img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" alt="User-Icon" class="w-10 h-10 hue-rotate-90 grayscale-[20%] hidden md:block pointer-events-none select-none">
            <h1 class=" text-2xl md:text-4xl font-bold text-primary">{{ Session::get('username') }}</h1>
        </div>
        <nav class="flex justify-center items-center gap-5">
            <a href="/addUsers" class="hover:-translate-y-1 transition-transform duration-300">Add User</a>
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
                    <form action="{{ url('download') }}" method="post">
                        @csrf
                        <input type="hidden" name="petition_id" value="{{ $job->petition_id }}">
                        @if(Session::has('in_progress') && Session::get('petition_id') == $job->petition_id)
                            @if(Session::has('error'))
                            <p class="absolute text-error -translate-x-20 translate-y-1"><i class='bx bx-error translate-y-0.5'></i> Error</p>
                            @else
                            <p class="absolute text-primary2 -translate-x-28 translate-y-1"><i class='bx bx-loader-alt bx-spin'></i> In progress</p>
                            @endif
                            <button class='job-btn' type='submit' name='download'><i class='bx bxs-show'></i> Check Status</button>
                        @elseif(!Session::has('in_progress') || Session::get('petition_id') != $job->petition_id)
                            <button class='job-btn' type='submit' name='download'><i class='bx bxs-cloud-download translate-y-0.5'></i> Download</button>
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