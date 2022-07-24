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
        <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
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
                        <a class="dropdown-item" href="{{ route('admin.properties') }}">Painel de Indicações</a>
                        <a class="dropdown-item" href="{{ route('admin.report_indication') }}">Relatório de
                            Indicações</a>
                        <a class="dropdown-item" href="{{ route('admin.report_regional') }}">Relatório Regional</a>
                        <a class="dropdown-item" href="{{ route('admin.receipts') }}">Enviar Comprovantes</a>
                    </div>
                </div>
                <li class="menu-item username">
                    <p>{{ Auth::user()->display_name }}</p>
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
    <main class="container">
        <form action="{{ route('admin.property_info') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label for="propriedade">Propriedade:</label>
                    <select class="form-control" name="propriedade" id="propriedade" required>
                        <option value="" disabeld selected hidden>Selecione uma opção</option>
                        @foreach ($properties as $property)
                            <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label for="indicacao">Indicado Por:</label>
                    <select class="form-control" name="indicacao" id="indicacao">
                        <option value="" disabled selected hidden>Selecione uma opção</option>
                        <option value="0">REMOVER INDICAÇÃO</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->ID }}">{{ $user->display_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row custom-file mt-2">
                <div class="form-group col-md-12 ml-4">
                    <label class="custom-file-label" for="contrato" id="labelContrato">Escolher arquivo</label>
                    <input type="file" class="custom-file-input" name="contrato" id="contrato">
                </div>
            </div>
            <div class="row mt-2">
                <a class="col-md-12 ml-4 btn btn-lg hidden" id="contract_download" target="_blank">
                    BAIXAR CONTRATO
                </a>
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
        $('#contrato').change(function() {
            var file = $('#contrato')[0].files[0].name;
            $(this).prev('label').text(file);
        });

        $('#propriedade').on('change', function() {
            $.ajax({
                url: "/admin/getProperty/" + this.value,
                success: function(result) {
                    if (result['user_indication_id']) {
                        $('#indicacao option[value="' + result['user_indication_id'] + '"]').prop(
                            'selected', 'selected');
                    } else {
                        $('#indicacao').prop(
                            'selectedIndex', 0);
                    }

                    if (result['contract']) {
                        id = $('#propriedade').val()
                        $('#contract_download').prop('href',
                            `${window.location.origin}/admin/property/${id}/contract`)
                        $('#contract_download').removeClass('hidden')
                        $('.custom-file-label').text(result['contract'])
                    } else {
                        $('#contract_download').addClass('hidden')
                        $('.custom-file-label').text('Escolher Arquivo')
                    }
                }
            });
        });
    </script>
</body>

</html>
