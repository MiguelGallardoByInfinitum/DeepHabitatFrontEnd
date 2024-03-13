<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>New Job</title>
    @vite('resources/css/app.css')
</head>
<body class="overflow-hidden">
    <h1>NEW JOB</h1>
    <a href="/historic" class="bg-primary p-2 rounded-md text-secondary"><i class='bx bx-arrow-back'></i> Go back</a>
    <!-- <h1 class="text-primary text-[50em] absolute -top-[20%] left-[40%] p-0 m-0">6</h1> -->
    <form action={{ url('insertar') }} method="post">
        @csrf
        <input type="text" name="name" placeholder="Name (Default is 'Job')">
        <input type="url" name="url" placeholder="URL" required>
        <input type="submit" name="insertar" value="Create Job">
    </form>
</body>
</html>