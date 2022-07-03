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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
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
            @if ($errors->any())
                <ul class="list-group mt-4 w-75 mx-auto">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form class="flex direction-column" action="{{ route('auth.user') }}" method="POST">
                @csrf
                <div class="input-box flex direction-column">
                    <label for="user_login">Usuário:</label>
                    <input type="text" id="user_login" name="user_login" placeholder="Digite seu nome de usuário"
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2" crossorigin="anonymous">
    </script>
</body>

</html>
