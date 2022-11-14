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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/admin/receipt.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
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
                        Menu
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.page') }}">Bloquear Data</a>
                        <a class="dropdown-item" href="{{ route('admin.unblock_page') }}">Desbloquear Data</a>
                        <a class="dropdown-item" href="{{ route('admin.reservation') }}">Efetuar Reserva</a>
                        <a class="dropdown-item" href="{{ route('admin.reservations') }}">Minhas Reservas</a>
                        <a class="dropdown-item" href="{{ route('admin.report') }}">Relatório Financeiro</a>
                        <a class="dropdown-item" href="{{ route('admin.properties') }}">Imóveis</a>
                        <a class="dropdown-item" href="{{ route('admin.report_indication') }}">Relatório de
                            Indicações</a>
                        <a class="dropdown-item" href="{{ route('admin.report_regional') }}">Relatório Regional</a>
                        <a class="dropdown-item" href="{{ route('admin.receipts') }}">Enviar Comprovantes</a>
                        <a class="dropdown-item" href="{{ route('admin.search_properties') }}">Filtrar Imóvel</a>
                        <a class="dropdown-item" href="{{ route('admin.demand') }}">Criar Solicitação</a>
                        <a class="dropdown-item" href="{{ route('admin.contracts') }}">Contratos</a>
                        <a class="dropdown-item" href="{{ route('admin.clients') }}">Histórico de Clientes</a>
                        <a class="dropdown-item" href="{{ route('admin.indications') }}">Fazer uma Indicação</a>
                    </div>
                </div>
                <li class="menu-item username">
                    <a href="{{ route('admin.profile') }}">Demais Funções</a>
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

                        @if ($pendingClient)
                            <p>
                                Você possui {{ $pendingClient }} clientes(s) aguardando aprovação.
                                <a class="notification-menu" href="{{ route('admin.clients') }}">
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
    <main class="container">
        <form action="{{ route('admin.create_receipt') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label for="owner">Proprietário:</label>
                    <select class="form-control" name="owner" id="owner" required>
                        <option value="" disabled selected hidden>Selecione uma opção</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->ID }}">{{ $user->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label for="month">Mês:</label>
                    <input type="month" name="month" id="month" class="form-control" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label for="value">Valor:</label>
                    <input class="form-control" type="number" id="value" name="value" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label for="reason">Motivo:</label>
                    <textarea class="form-control" id="reason" name="reason" rows="3" required></textarea>
                </div>
            </div>
            <div class="row custom-file mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label class="custom-file-label" for="receipt" id="labelContrato">Escolher arquivo</label>
                    <input type="file" class="custom-file-input" name="receipt" id="receipt" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12 ml-4">
                    <button type="submit" class="save-button">SALVAR</button>
                </div>
            </div>
        </form>
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
        $('#receipt').change(function() {
            var file = $('#receipt')[0].files[0].name;
            $(this).prev('label').text(file);
        });
    </script>
</body>

</html>
