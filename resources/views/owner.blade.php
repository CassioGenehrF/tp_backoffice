<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://temporadapaulista.com.br/wp-content/uploads/2022/06/FAVICON-36x36.png"
        sizes="32x32">

    <title>Proprietário - Temporada Paulista</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
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
                    <p>{{ $name }}</p>
                </li>
                <li class="menu-item">
                    <form action="{{ route('logout.user') }}" method="post">
                        @csrf
                        <button type="submit">Sair</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <main class="conteudo">
        <section class="p-4 mw-60">
            <div class="calendar">
                <div class="calendar-tools">
                    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                        <span class="calendar-heading">Julho 2022</span>
                    </div>
                </div>
                <table class="month">
                    <thead>
                        <tr>
                            <th>Domingo</th>
                            <th>Segunda</th>
                            <th>Terça</th>
                            <th>Quarta</th>
                            <th>Quinta</th>
                            <th>Sexta</th>
                            <th>Sábado</th>
                        </tr>
                    </thead>
                    <tbody>
                        {!! $calendar !!}
                    </tbody>
                </table>
            </div>
        </section>
        <form action="{{ route('owner.block') }}" method="POST">
            @if ($errors->any())
                <ul class="list-group mt-4 w-75 mx-auto">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @csrf
            <div class="input-box">
                <label for="checkin">Check-in:</label>
                <input type="date" id="checkin" name="checkin" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="checkout">Check-out:</label>
                <input type="date" id="checkout" name="checkout" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="propriedade">Propriedade:</label>
                <select name="propriedade" id="propriedade">
                    @foreach ($properties as $property)
                        <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="block-button">Bloquear</button>
        </form>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
    <script type="text/javascript"></script>
</body>

</html>
