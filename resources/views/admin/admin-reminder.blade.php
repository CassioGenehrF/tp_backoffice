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

    <link rel="stylesheet" href="{{ asset('css/admin/properties.css') }}">
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
                        <a class="dropdown-item" href="{{ route('admin.reminder') }}">Criar Solicitação</a>
                        <a class="dropdown-item" href="{{ route('admin.contracts') }}">Contratos</a>
                        <a class="dropdown-item" href="{{ route('admin.clients') }}">Histórico de Clientes</a>
                        <a class="dropdown-item" href="{{ route('admin.indications') }}">Indicar um cliente</a>
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
        <a href="{{ route('admin.profile') }}" class="btn btn-light ml-4 mb-2">
            Voltar
        </a>
        <form action="{{ route('admin.store_reminder') }}" method="POST">
            <div class="row mt-2 ml-4">
                <div class="form-group col-md-6">
                    <label for="checkin">Check-in:</label>
                    @if ($reminder)
                        <input class="form-control" type="date" id="checkin" name="checkin"
                            value="{{ $reminder->checkin }}" required disabled>
                    @else
                        <input class="form-control" type="date" id="checkin" name="checkin" required>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="checkout">Check-out:</label>
                    @if ($reminder)
                        <input class="form-control" type="date" id="checkout" name="checkout"
                            value="{{ $reminder->checkout }}" required disabled>
                    @else
                        <input class="form-control" type="date" id="checkout" name="checkout" required>
                    @endif
                </div>
            </div>
            <div class="row mt-2 ml-4">
                <div class="form-group col-md-6">
                    <label for="client">Nome do Cliente:</label>
                    @if ($reminder)
                        <input class="form-control" type="text" id="client" name="client"
                            value="{{ $reminder->client }}"" required disabled>
                    @else
                        <input class="form-control" type="text" id="client" name="client" required>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="phone">Telefone:</label>
                    @if ($reminder)
                        <input class="form-control" type="tel" id="phone" name="phone" required
                            onkeypress="return onlyNumberKey(event)" value="{{ $reminder->phone }}" disabled>
                    @else
                        <input class="form-control" type="tel" id="phone" name="phone" required
                            onkeypress="return onlyNumberKey(event)">
                    @endif
                </div>
            </div>
            <div class="row mt-2 ml-4">
                <div class="form-group col-md-3">
                    <label for="price">Preço:</label>
                    @if ($reminder)
                        <input class="form-control" type="number" id="price" name="price"
                            value="{{ $reminder->price }}" required disabled>
                    @else
                        <input class="form-control" type="number" id="price" name="price" required>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="people_number">Quantidade de Pessoas:</label>
                    @if ($reminder)
                        <input class="form-control" type="number" id="people_number" name="people_number" required
                            onkeypress="return onlyNumberKey(event)" value="{{ $reminder->people_number }}" disabled>
                    @else
                        <input class="form-control" type="number" id="people_number" name="people_number" required
                            onkeypress="return onlyNumberKey(event)">
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="period">Período</label>
                    @if ($reminder)
                        <select class="form-control" name="period" id="period" disabled>
                            @switch($reminder->period)
                                @case('weekend')
                                    <option value="weekend">Final de Semana</option>
                                @break

                                @case('day_use')
                                    <option value="day_use">Day Use</option>
                                @break

                                @case('week')
                                    <option value="week">Dia de Semana</option>
                                @break

                                @case('holiday')
                                    <option value="holiday">Feriado Prolongado</option>
                                @break

                                @case('christmas')
                                    <option value="christmas">Natal</option>
                                @break

                                @case('new_year')
                                    <option value="new_year">Ano Novo</option>
                                @break

                                @case('carnival')
                                    <option value="carnival">Carnaval</option>
                                @break

                                @default
                            @endswitch
                        </select>
                    @else
                        <select class="form-control" name="period" id="period">
                            <option value="0" selected>Selecione uma opção</option>
                            <option value="weekend">Final de Semana</option>
                            <option value="day_use">Day Use</option>
                            <option value="week">Dia de Semana</option>
                            <option value="holiday">Feriado Prolongado</option>
                            <option value="christmas">Natal</option>
                            <option value="new_year">Ano Novo</option>
                            <option value="carnival">Carnaval</option>
                        </select>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="property_id">Imóvel:</label>
                    @if ($reminder)
                        <select class="form-control" name="property_id" id="property_id" disabled>
                            @foreach ($properties as $property)
                                <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                            @endforeach
                        </select>
                    @else
                        <select class="form-control" name="property_id" id="property_id">
                            <option value="0">Todas</option>
                            @foreach ($properties as $property)
                                <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                            @endforeach
                        </select>
                    @endif
                </div>
            </div>
            @if (!$reminder)
                <div class="row mt-2">
                    <div class="col-md-12 ml-4">
                        <button type="submit" class="save-button">SALVAR</button>
                    </div>
                </div>
            @endif
        </form>
        @if ($reminder)
            <form action="{{ route('admin.delete_reminder', ['id' => $reminder->id]) }}" method="post">
                @method('delete')
                <div class="row mt-2">
                    <div class="col-md-12 ml-4">
                        <button type="submit" class="delete-button">Excluir</button>
                    </div>
                </div>
            </form>
        @endif
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
        $('#checkin').on('change', function() {
            $('#checkout').val($('#checkin').val())
            $('#checkout').prop('min', $('#checkin').val())
        });

        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            return !(ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        }
    </script>
</body>

</html>
