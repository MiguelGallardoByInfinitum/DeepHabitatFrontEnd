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
    <link rel="icon" href="{{ asset('media/DeepHABITAT logo blue.png') }}">
    @vite('resources/css/app.css')
</head>
<body>
    <header class="flex justify-between items-center p-7">
        <div class="flex gap-4 items-center">
        <img src="{{ asset('media/DeepHABITAT logo blue.png') }}" alt="Logo" class="w-16 pointer-events-none select-none md:block hidden">
            <h1 class=" text-2xl md:text-4xl font-thin text-primary md:block hidden">{{ Session::get('username') }}</h1>
        </div>
        <nav class="flex justify-center items-center gap-5 flex-wrap">
            <a href="/moodboard" class="bg-tertiary text-light text-xs md:text-lg p-2 rounded-md drop-shadow-lg hover:-translate-y-1 transition-all duration-300 select-none"><i class='bx bx-image translate-y-0.5' ></i> Moodboards</a>
            <a href="/addUsers" class="bg-primary text-light text-xs md:text-lg p-2 rounded-md drop-shadow-lg hover:-translate-y-1 transition-all duration-300 select-none"><i class='bx bxs-user-plus translate-y-0.5'></i> Add Users</a>
            <a href="/new" class="bg-primary text-light text-xs md:text-lg p-2 rounded-md drop-shadow-lg hover:-translate-y-1 transition-all duration-300 select-none"><i class='bx bx-plus translate-y-0.5'></i> New Job</a>
            <a href="/login" class="hover:-translate-y-1 text-xs md:text-lg transition-transform duration-300">Log Out</a>
        </nav>
    </header>
    <div class="flex justify-center items-start flex-col mr-7 ml-7 sm:mr-14 sm:ml-14 md:mr-36 md:ml-36 mt-10">
        <h3 class="text-2xl">Jobs</h3>
        <div class="w-full jobs mt-6 mb-32">
            @foreach($jobs->reverse() as $job)
                <div class="job group" data-aos="fade-up">
                    <p class="job-text">{{ $job->id }}. {{ $job->name }}</p>
                    <div class="flex gap-2 md:gap-4 flex-wrap">
                        @if(Session::has('in_progress') && Session::get('petition_id') == $job->petition_id)
                            @if(Session::has('error'))
                                <p class="text-error text-xs md:text-lg translate-y-1"><i class='bx bx-error translate-y-0.5'></i> Error</p>
                            @else
                                <p class="text-primary2 text-xs md:text-lg translate-y-1"><i class='bx bx-loader-alt bx-spin'></i> In progress</p>
                            @endif
                        @elseif(Session::has('in_progress_description') && Session::get('petition_id_description') == $job->petition_id)
                            @if(Session::has('error_description'))
                                <p class="text-error text-xs md:text-lg translate-y-1"><i class='bx bx-error translate-y-0.5'></i> Error</p>
                            @elseif(Session::has('master_data_processing'))
                                <p class="text-primary2 text-xs md:text-lg translate-y-1"><i class='bx bx-loader-alt bx-spin'></i> Master data still in progress</p>
                            @else
                                <p class="text-primary2 text-xs md:text-lg translate-y-1"><i class='bx bx-loader-alt bx-spin'></i> In progress</p>
                            @endif
                        @endif
                        <form action="{{ url('download') }}" method="post">
                            @csrf
                            <input type="hidden" name="petition_id" value="{{ $job->petition_id }}">
                            @if(Session::has('in_progress') && Session::get('petition_id') == $job->petition_id)
                                <button class='job-btn' type='submit' name='download'><i class='bx bxs-show'></i> Check Status</button>
                            @elseif(!Session::has('in_progress') || Session::get('petition_id') != $job->petition_id)
                                <button class='job-btn' type='submit' name='download'><i class='bx bxs-cloud-download translate-y-0.5'></i> Download</button>
                            @endif
                        </form>
                        
                        @if($job->description)
                            <form action="{{ url('downloadDescription') }}" method="post">
                                @csrf
                                <input type="hidden" name="petition_id" value="{{ $job->petition_id }}">
                                @if(Session::has('in_progress_description') && Session::get('petition_id_description') == $job->petition_id)
                                    
                                    <button class='job-btn' type='submit' name='download'><i class='bx bxs-show'></i> Check Status</button>
                                @elseif(!Session::has('in_progress_description') || Session::get('petition_id_description') != $job->petition_id)
                                    <button class='job-btn' type='submit' name='downloadDescription'><i class='bx bxs-cloud-download translate-y-0.5'></i> Download Description</button>
                                @endif
                            </form>
                        @endif
                    </div>
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