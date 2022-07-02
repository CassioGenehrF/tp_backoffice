<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Login</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
</head>

<body>
    <div class="flex">
        <img class="image-predios" src="{{ asset('images/predios.jpg') }}" alt="">
        <div class="form-box text-center">
            <div class="form-logo text-center">
                <img src="{{ asset('images/Logopaulista.png') }}" alt="">
            </div>
            <div class="title">
                <h2>Login</h2>
            </div>
            <form class="flex direction-column" action="">
                <div class="input-box flex direction-column">
                    <label for="username">Usuário:</label>
                    <input type="text" id="username" name="username" placeholder="Digite seu nome de usuário"
                        required>
                </div>
                <div class="input-box flex direction-column">
                    <label for="password">Senha:</label>
                    <input type="password" id="password" name="password" placeholder="Digite sua senha" required>
                </div>
                <button type="submit" class="login-button">Entrar</button>
            </form>
        </div>
    </div>
</body>

</html>
