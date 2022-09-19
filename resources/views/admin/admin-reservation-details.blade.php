<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="https://temporadapaulista.com.br/wp-content/uploads/2022/06/FAVICON-36x36.png"
        sizes="32x32">

    <title>Administrador - Temporada Paulista</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/broker/reservation-details.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<body>
    <header class="menu-content">
        <a href="{{ route('admin.page') }}">
            <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
        </a>
        <nav class="cabecalho-menu">
            <ul class="list-itens">
                <div class="btn-group menu-item">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        Opções
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.page') }}">Bloquear Agenda</a>
                        <a class="dropdown-item" href="{{ route('admin.unblock_page') }}">Desbloquear Agenda</a>
                        <a class="dropdown-item" href="{{ route('admin.reservation') }}">Efetuar Reserva</a>
                        <a class="dropdown-item" href="{{ route('admin.reservations') }}">Minhas Reservas</a>
                        <a class="dropdown-item" href="{{ route('admin.report') }}">Relatório Mensal</a>
                        <a class="dropdown-item" href="{{ route('admin.properties') }}">Propriedades</a>
                        <a class="dropdown-item" href="{{ route('admin.report_indication') }}">Relatório de
                            Indicações</a>
                        <a class="dropdown-item" href="{{ route('admin.report_regional') }}">Relatório Regional</a>
                        <a class="dropdown-item" href="{{ route('admin.receipts') }}">Enviar Comprovantes</a>
                        <a class="dropdown-item" href="{{ route('admin.search_properties') }}">Filtrar Imóvel</a>
                        <a class="dropdown-item" href="{{ route('admin.demand') }}">Criar Solicitação</a>
                        <a class="dropdown-item" href="{{ route('admin.contracts') }}">Contratos</a>
                    </div>
                </div>
                <li class="menu-item username">
                    <a href="{{ route('admin.profile') }}">{{ Auth::user()->display_name }}</a>
                </li>
                <li class="menu-item notification">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        @if ($unverified)
                            <span class="badge notification-count">{{ $unverified }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu">
                        @if ($unverified)
                            <p>
                                Você possui {{ $unverified }} proprietário(s) aguardando aprovação de documentos.
                                <a class="notification-menu" href="{{ route('admin.verify') }}">
                                    Verificar agora</a>
                            </p>
                        @endif
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
    <main>
        <article>
            <section class="details">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Número da Reserva</th>
                            <th scope="col">Propriedade</th>
                            <th scope="col">Checkin/Checkout</th>
                            <th scope="col">Cliente</th>
                            <th scope="col">Telefone</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">{{ $reservation->id }}</th>
                            <td> {{ $reservation->commitment->property->post_title }} </td>
                            <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->commitment->checkin)->format('d/m/Y') . ' - ' . \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->commitment->checkout)->format('d/m/Y') }}
                            <td> {{ $reservation->guest_name }} </td>
                            <td> {{ $reservation->guest_phone }} </td>
                        </tr>
                    </tbody>
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Adultos</th>
                            <th scope="col">Crianças</th>
                            <th scope="col">Diárias</th>
                            <th scope="col">Total</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td> {{ $reservation->adults }} </td>
                            <td> {{ $reservation->kids }} </td>
                            <td> {{ \Carbon\Carbon::createFromFormat('Y-m-d', $reservation->commitment->checkout)->diffInDays(\Carbon\Carbon::createFromFormat('Y-m-d', $reservation->commitment->checkin)) }}
                            <td> {{ "R$ " . str_replace('.', ',', $reservation->price) }} </td>
                        </tr>
                    </tbody>
                </table>
            </section>
            <section class="payment">
                <table class="table">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">Resumo</th>
                            <th scope="col"></th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td> Diárias </td>
                            <td> {{ "R$ " . number_format($reservation->price, 2, ',', '') }} </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> Tarifa do Site </td>
                            <td> {{ "R$ " . number_format($reservation->site_tax, 2, ',', '') }} </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> Corretor </td>
                            <td> {{ "R$ " . number_format($reservation->broker_tax, 2, ',', '') }} </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td> Publicador </td>
                            <td> {{ "R$ " . number_format($reservation->publisher_tax, 2, ',', '') }} </td>
                        </tr>
                        @if ($reservation->clean_tax > 0)
                            <tr>
                                <td></td>
                                <td> Taxa de Limpeza </td>
                                <td> {{ "R$ " . number_format($reservation->clean_tax, 2, ',', '') }} </td>
                            </tr>
                        @endif
                        @if ($reservation->bail_tax > 0)
                            <tr>
                                <td></td>
                                <td> Taxa de Caução </td>
                                <td> {{ "R$ " . number_format($reservation->bail_tax, 2, ',', '') }} </td>
                            </tr>
                        @endif
                        <tr>
                            <td></td>
                            <td><b> Total </b></td>
                            <td>
                                <b>
                                    {{ "R$ " . number_format($reservation->price + $reservation->clean_tax + $reservation->bail_tax, 2, ',', '') }}
                                </b>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </section>
        </article>
        <aside>
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">Comissão</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td> {{ $name }} </td>
                        <td>
                            {{ "R$ " . number_format($reservation->site_tax, 2, ',', '') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            @if ($reservation->contract)
                <a class="btn btn-lg" target="_blank"
                    href="{{ route('admin.download_contract', ['id' => $reservation->id]) }}">
                    Baixar Contrato
                </a>
            @endif
        </aside>
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
</body>

</html>
