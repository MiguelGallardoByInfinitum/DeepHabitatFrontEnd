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
    <link rel="icon" href="{{ asset('media/DeepHABITAT Logo white.png') }}">
    @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex justify-center items-center flex-col gap-5 selection:bg-red-400 selection:text-light selection:bg-primarySelection bg-secondary">
    <header class="sm:p-7 pt-7 absolute top-0 left-6 p-0">
        <a href="/" class="bg-primary p-2 rounded-md text-secondary group"><i class='bx bx-arrow-back group-hover:-translate-x-1 transition-all duration-300'></i> Go back</a>
    </header>
    <h1 class="text-3xl font-bold capitalize drop-shadow-md shadow-red-200 text-primary" data-aos="zoom-in-up" data-aos-delay="100">
    Register a new User
    </h1>
    @if (session('notSamePwd'))
    <p class="text-error" data-aos="zoom-in-up" data-aos-delay="200"><i class='bx bxs-error'></i> {{ session('notSamePwd') }} <i class='bx bxs-error'></i></p>
    @elseif (session('userCreated'))
    <p class="text-created" data-aos="zoom-in-up" data-aos-delay="200"><i class='bx bx-check-circle' ></i> {{ session('userCreated') }} <i class='bx bx-check-circle' ></i></p>
    @elseif (session('userExists'))
    <p class="text-error" data-aos="zoom-in-up" data-aos-delay="200"><i class='bx bxs-error'></i> {{ session('userExists') }} <i class='bx bxs-error'></i></p>
    @endif
    <hr class="w-44 text-primary" data-aos="zoom-in-up" data-aos-delay="300">
    <form action="{{ url('register') }}" method="post" class="flex flex-col justify-center items-center gap-3" data-aos="zoom-in-up" data-aos-delay="400">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username here..." class="w-80 h-9 text-md text-primary p-2 bg-secondary rounded-lg drop-shadow-md focus:outline-none" required>
        <input type="password" id="password" name="password" placeholder="Password here..." class="w-80 h-9 text-md text-primary p-2 bg-secondary rounded-lg drop-shadow-md focus:outline-none" required>
        <input type="password" id="passwordR" name="passwordR" placeholder="Repeat password here..." class="w-80 h-9 text-md text-primary p-2 bg-secondary rounded-lg drop-shadow-md focus:outline-none" required>
        <input type="submit" id="login" name="login" value="Register" class="mt-3 p-1 w-32 rounded-lg cursor-pointer duration-300 hover:-translate-y-1 transition-all bg-primary text-secondary border-2 border-primary hover:bg-secondary hover:text-primary drop-shadow-md select-none">
    </form>

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>
</html>