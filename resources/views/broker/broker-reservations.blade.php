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
</head>

<body>
    <header class="menu-content">
        <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
        <nav class="cabecalho-menu">
            <ul class="list-itens">
                <div class="btn-group menu-item">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Opções
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('broker.page') }}">Efetuar Reserva</a>
                        <a class="dropdown-item" href="{{ route('broker.reservations') }}">Minhas Reservas</a>
                        <a class="dropdown-item" href="{{ route('broker.report') }}">Relatório Mensal</a>
                    </div>
                </div>
                <li class="menu-item username">
                    <p>{{ $name }}</p>
                </li>
                <li class="menu-item notification">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        <span class="badge notification-count">1</span>
                    </button>
                    <div class="dropdown-menu">
                        <p>
                            Você possui valores disponíveis para saque, clique
                            <a class="notification-menu"
                                href="https://api.whatsapp.com/send/?phone=5511963626375&text=Olá%2C+sou+proprietário+e+quero+sacar+o+valor+regional&type=phone_number&app_absent=0"
                                target="_blank">
                                aqui</a>
                            e saiba mais.
                        </p>
                    </div>
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
    <section class="flex mt-2">
        <div class="form-group col-md-4 ml-4">
            <label for="filtro-propriedade">Propriedade:</label>
            <select class="form-control" name="filtro-propriedade" id="filtro-propriedade">
                <option value="0">Todas</option>
                @foreach ($properties as $property)
                    <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group col-md-2 ml-4">
            <label for="month">Mês</label>
            <input type="month" name="month" id="month" class="form-control">
        </div>
    </section>
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
            <tbody id="reservations">
                @foreach ($reservations as $reservation)
                    @if (Auth::id() == $reservation->user_id)
                        <tr>
                        @else
                        <tr style="background-color: #ff9900;">
                    @endif
                    <td> {{ $reservation->post_title }} </td>
                    <td> {{ $reservation->guest_name }} </td>
                    <td> {{ "R$ " . str_replace('.', ',', $reservation->price) }} </td>
                    <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->checkin)->format('d/m/Y') . ' - ' . \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->checkout)->format('d/m/Y') }}
                    </td>
                    <td>
                        <a href="{{ route('broker.reservations_details', ['id' => $reservation->id]) }}""
                            class="btn
                            btn-light">
                            Visualizar</a>
                        <a href="{{ route('broker.page', ['id' => $reservation->id]) }}""
                            class="btn
                            btn-light">
                            Editar</a>
                        @if (Auth::id() == $reservation->user_id)
                            <form action="{{ route('broker.reservation_destroy', ['id' => $reservation->id]) }}"
                                method="post">
                                @method('delete')
                                @csrf
                                <button type="submit" class="btn btn-danger">Excluir</button>
                            </form>
                        @endif
                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        $('#filtro-propriedade').on('change', function() {
            propriedade = $('#filtro-propriedade').val() ?? 0;
            year = $('#month').val() ? $('#month').val().substring(0, 4) : 0;
            month = $('#month').val() ? parseInt($('#month').val().substring(5, 7)) : 0;

            $.ajax({
                url: "/broker/getReservations/" + propriedade + "/" + month + "/" + year,
                success: function(result) {
                    $("#reservations").html(result['data']);
                }
            });
        });

        $('#month').on('change', function() {
            propriedade = $('#filtro-propriedade').val() ?? 0;
            year = $('#month').val() ? $('#month').val().substring(0, 4) : 0;
            month = $('#month').val() ? parseInt($('#month').val().substring(5, 7)) : 0;

            $.ajax({
                url: "/broker/getReservations/" + propriedade + "/" + month + "/" + year,
                success: function(result) {
                    $("#reservations").html(result['data']);
                }
            });
        });
    </script>
</body>

</html>
