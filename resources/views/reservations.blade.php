<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://temporadapaulista.com.br/wp-content/uploads/2022/06/FAVICON-36x36.png"
        sizes="32x32">

    <title>Corretor - Temporada Paulista</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" /> --}}
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/broker/reservation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<body>
    <header class="menu-content">
        <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
        <nav class="cabecalho-menu">
            <ul class="list-itens">
                <li class="menu-item">
                    <a href="{{ route('broker.page') }}">Efetuar Reserva</a>
                </li>
                <li class="menu-item active">
                    <a href="#">Minhas Reservas</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('broker.report') }}">Relatório Mensal</a>
                </li>
                <li class="menu-item username">
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
    <main>
        <table class="table">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Propriedade</th>
                    <th scope="col">Hóspede</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Checkin/Checkout</th>
                    <th class="action" scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reservations as $reservation)
                    <tr>
                        <td> {{ $reservation->post_title }} </td>
                        <td> {{ $reservation->guest_name }} </td>
                        <td> {{ "R$ " . str_replace('.', ',', $reservation->price) }} </td>
                        <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->checkin)->format('d/m/Y') . ' - ' . \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->checkout)->format('d/m/Y') }}
                        </td>
                        <td>
                            <form action="/broker/reservations/{{ $reservation->id }}" method="get">
                                @csrf
                                <button type="submit" class="btn btn-light">Visualizar</button>
                            </form>
                            <form action="{{ route('broker.reservation_destroy', ['id' => $reservation->id]) }}"
                                method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
</body>

</html>
