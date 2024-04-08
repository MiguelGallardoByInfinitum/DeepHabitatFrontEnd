<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('media/DeepHABITAT logo blue.png') }}">
  <title>Login</title>
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex justify-center items-center flex-col gap-5 selection:bg-red-400 selection:text-light selection:bg-primarySelection bg-secondary">    
<header class="top-5 left-5 flex items-center absolute gap-2">
  <img src="{{ asset('media/DeepHABITAT logo blue.png') }}" alt="DeepHABITAT Logo" class="w-10 md:w-16 cursor-pointer transition-all duration-500 hover:opacity-100">
  <p class="text-primary font-sans text-md md:text-2xl md:-translate-y-0.5">DeepHABITAT</p>
</header>
<h1 class="text-3xl font-bold capitalize drop-shadow-md shadow-red-200 text-primary" data-aos="zoom-in-up" data-aos-delay="100">
    Sign in to your account
    </h1>
    <p class='text-1xl text-dark' data-aos="zoom-in-up" data-aos-delay="200">DeepHabitat API</p>
    <hr class="w-44 text-primary" data-aos="zoom-in-up" data-aos-delay="300">
    @if (session('no_login'))
      <p class="text-error" data-aos="zoom-in-up" data-aos-delay="400">{{ session('no_login') }}</p>
    @endif
    <form action="{{ url('login') }}" method="post" class="flex flex-col justify-center items-center gap-3" data-aos="zoom-in-up" data-aos-delay="400">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username here..." class="w-80 h-9 text-md text-primary p-2 bg-secondary rounded-lg drop-shadow-md focus:outline-none" required>
        <input type="password" id="password" name="password" placeholder="Password here..." class="w-80 h-9 text-md text-primary p-2 bg-secondary rounded-lg drop-shadow-md focus:outline-none" required>
        <input type="submit" id="login" name="login" value="Log In" class="mt-3 p-1 w-32 rounded-lg cursor-pointer duration-300 hover:-translate-y-1 transition-all bg-primary text-secondary border-2 border-primary hover:bg-secondary hover:text-primary drop-shadow-md select-none">
      </form>
      

    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
      AOS.init();
    </script>
</body>
</html>