<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex justify-center items-center flex-col gap-5 selection:bg-red-400 selection:text-white bg-secondary">
    <h1 class="text-3xl font-bold capitalize drop-shadow-md shadow-red-200 text-primary">
        Iniciar Session
    </h1>
    <p class='text-1xl text-tertiary'>DeepHabitat API</p>
    <hr class="w-44 text-primary">
    <form action={{ url('post') }} method="post" class="flex flex-col justify-center items-center gap-3">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username here..." class="w-80 h-9 text-lg text-black p-2" required>
        <input type="password" id="password" name="password" placeholder="Password here .." class="w-80 h-9 text-lg text-black p-2" required>
        <input type="submit" id="login" name="login" value="Iniciar Sessión" class="mt-2 p-2 w-32 rounded-full cursor-pointer duration-300 hover:-translate-y-1 transition-all bg-primary text-secondary border-2 border-primary hover:bg-secondary hover:text-primary">
    </form>
</body>
</html>