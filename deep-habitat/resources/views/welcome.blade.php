<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  @vite('resources/css/app.css')
</head>
<body class="min-h-screen flex justify-center items-center flex-col gap-5 bg-gradient-to-br from-slate-950 to-red-900 text-white selection:bg-red-400 selection:text-white">
    <h1 class="text-3xl font-bold capitalize bg-gradient-to-r bg-clip-text text-transparent from-red-600 to-orange-600 drop-shadow-md shadow-red-200">
        Soy un chico laravel
    </h1>
    <?php
        echo "<p class='text-1xl bg-gradient-to-r bg-clip-text text-transparent from-red-600 to-orange-600'>texto secundario</p>"
    ?>
    <hr class="w-44">
    <form action={{ url('post') }} method="post" class="flex flex-col justify-center items-center gap-3">
        @csrf
        <input type="text" id="username" name="username" placeholder="Username here..." class="w-80 h-9 text-lg text-black p-2" required>
        <input type="password" id="password" name="password" placeholder="Password here .." class="w-80 h-9 text-lg text-black p-2" required>
        <input type="submit" id="login" name="login" value="Iniciar Sessión" class="mt-2 bg-rose-700 p-2 w-32 rounded-full hover:bg-rose-900 cursor-pointer duration-300 hover:-translate-y-1 transition-all">
    </form>
</body>
</html>