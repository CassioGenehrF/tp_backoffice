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
    <link rel="stylesheet" href="{{ asset('css/broker/reservation.css') }}">
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
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Propriedade</th>
                        <th class="action" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($properties as $property)
                        <tr>
                            <td>
                                <a href="https://temporadapaulista.com.br/propriedade/{{ $property->ID }}"
                                    target="_blank">
                                    {{ $property->post_title }}
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.property_indication', ['propertyId' => $property->ID]) }}"
                                    class="btn btn-light">
                                    Indicação
                                </a>
                                @php
                                    $standard = $property->propertyInfo->standard ?? 0;
                                @endphp
                                <form name="standardForm" action="{{ route('admin.property_info') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="propriedade" id="propriedade"
                                        value="{{ $property->ID }}">
                                    <div class="form-group col-md-6 pl-0 mt-2">
                                        <select class="form-control" name="standard" id="standard">
                                            <option value="" disabled {{ $standard == 0 ? 'selected' : '' }}
                                                hidden>Padrão</option>
                                            <option value="1" {{ $standard == 1 ? 'selected' : '' }}>Simples
                                            </option>
                                            <option value="2" {{ $standard == 2 ? 'selected' : '' }}>Médio
                                            </option>
                                            <option value="3" {{ $standard == 3 ? 'selected' : '' }}>Alto
                                            </option>
                                        </select>
                                    </div>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
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
        $('select[name="standard"]').on('change', function() {
            $(this).parent().parent()[0].submit();
        });
    </script>
</body>

</html>
