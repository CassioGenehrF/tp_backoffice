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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/broker/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    @livewireStyles
</head>

<body>
    <header class="menu-content">
        <a href="{{ route('admin.page') }}">
            <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
        </a>
        <nav class="cabecalho-menu">
            <ul class="list-itens">
                <div class="btn-group menu-item dropdown">
                    <button type="button" class="btn dropdown-toggle" id="dropdownMenu" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Opções
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <li><a class="dropdown-item" href="{{ route('admin.page') }}">Bloquear Agenda</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.unblock_page') }}">Desbloquear Agenda</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.reservation') }}">Efetuar Reserva</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.reservations') }}">Minhas Reservas</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.report') }}">Relatório Mensal</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.properties') }}">Imóveis</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.report_indication') }}">Relatório de
                                Indicações</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.report_regional') }}">Relatório Regional</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.receipts') }}">Enviar Comprovantes</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.search_properties') }}">Filtrar Imóvel</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('admin.demand') }}">Criar Solicitação</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.contracts') }}">Contratos</a></li>
                    </ul>
                </div>
                <li class="menu-item username">
                    <a href="{{ route('admin.profile') }}">{{ Auth::user()->display_name }}</a>
                </li>
                <li class="menu-item notification">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        @if ($notifications)
                            <span class="badge notification-count">{{ $notifications }}</span>
                        @endif
                    </button>
                    <div class="dropdown-menu">
                        @if ($unverified)
                            <p>
                                Você possui {{ $unverified }} proprietário(s) aguardando aprovação de documentos.
                                <a class="notification-menu" href="{{ route('admin.verify') }}">
                                    Verificar agora</a>
                            </p>
                            <hr>
                        @endif

                        @if ($reminders)
                            @foreach ($reminders as $reminderNotification)
                                <p>
                                    <b>Lembrete:</b> entre em contato com o cliente:
                                    {{ $reminderNotification['client'] }}.<br>
                                    <a class="notification-menu"
                                        href="{{ route('admin.show_reminder', ['id' => $reminderNotification['id']]) }}">
                                        Verificar agora</a>
                                </p>
                                <hr>
                            @endforeach
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
    <livewire:search />
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="text/javascript">
        $(function() {
            $('#end').prop('min', $('#start').val())
        });

        $('#start').on('change', function() {
            $('#end').prop('min', $('#start').val())
        });
    </script>
    @livewireScripts
</body>

</html>
