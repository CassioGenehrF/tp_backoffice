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

    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
</head>

<body>
    <header class="menu-content">
            <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
            <nav class="cabecalho-menu">
                <ul class="list-itens">
                    <li class="menu-item">
                        <a href="#">Bloquear Agenda</a>
                    </li>
                    <li class="menu-item">
                        <a href="#">Desbloquear Agenda</a>
                    </li>
                    <li class="menu-item">
                        <a href="#">Cassio Genehr</a>
                    </li>
                    <li class="menu-item">
                        <button type="submit">Sair</button>
                    </li>
                </ul>
            </nav>

    </header>

    <main class="conteudo">
        <div class="calendar">
        </div>
        <form action="">
            <div class="input-box">
                <label for="checkin">Check-in:</label>
                <input type="date" id="checkin" name="checkin" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="checkout">Check-out:</label>
                <input type="date" id="checkout" name="checkout" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="propiedade">Propiedade:</label>
                <input type="text" id="propiedade" name="propiedade" placeholder="Sitio xxxx" required>
            </div>
            <button type="submit" class="block-button">Bloquear</button>
        </form>
    </main>
</body>

</html>
