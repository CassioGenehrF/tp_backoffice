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
    <!-- Boostrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/owner/properties.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
</head>

<body>
    <header class="menu-content">
        <a href="{{ route('owner.page') }}">
            <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
        </a>
        <nav class="cabecalho-menu">
            <ul class="list-itens">
                <div class="btn-group menu-item">
                    <button type="button" class="btn dropdown-toggle" id="dropdownMenu" type="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Opções
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <li><a class="dropdown-item" href="{{ route('owner.page') }}">Bloquear Agenda</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.unblock_page') }}">Desbloquear Agenda</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('owner.reservations') }}">Minhas Reservas</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.report') }}">Relatório Mensal</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.properties') }}">Minhas Propriedades</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('owner.demands') }}">Solicitações</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.properties_contracts') }}">Meus
                                Contratos</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('owner.clients') }}">Clientes</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.indications') }}">Indicações</a></li>
                    </ul>
                </div>
                <li class="menu-item username">
                    <p>{{ $name }}</p>
                </li>
                <li class="menu-item notification">
                    <button type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-bell"></i>
                        <span class="badge notification-count">0</span>
                    </button>
                    {{-- <div class="dropdown-menu">
                        <p>
                            Você possui valores disponíveis para saque, clique
                            <a class="notification-menu"
                                href="https://api.whatsapp.com/send/?phone=5511963626375&text=Olá%2C+sou+proprietário+e+quero+sacar+o+valor+regional&type=phone_number&app_absent=0"
                                target="_blank">
                                aqui</a>
                            e saiba mais.
                        </p>
                    </div> --}}
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
    <main class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Propriedade</th>
                    <th scope="col">Proprietário</th>
                    <th scope="col">Proprietário Assinatura</th>
                    <th scope="col">Cliente</th>
                    <th scope="col">Cliente Assinatura</th>
                    <th class="action" scope="col">Ações</th>
                </tr>
            </thead>
            <tbody id="report-content">
                @foreach ($contracts as $contract)
                    <tr>
                        <td>{{ $contract->property_id }}</td>
                        <td>{{ $contract->owner_name ?? $contract->owner_signature }}</td>
                        <td>
                            @if ($contract->owner_signature_at)
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $contract->owner_signature_at)->format('m/d/Y H:i:s') }}
                            @endif
                        </td>
                        <td>{{ $contract->client_name ?? $contract->client_signature }}</td>
                        <td>
                            @if ($contract->client_signature_at)
                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $contract->client_signature_at)->format('m/d/Y H:i:s') }}
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn dropdown-toggle" id="dropdownMenu" type="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Opções
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                                <li>
                                    <a href="{{ route('owner.download_property_contract', ['contractId' => $contract->id]) }}"
                                        class="dropdown-item">Baixar Contrato</a>
                                </li>
                                <li>
                                    <a href="{{ route('owner.property_contract', ['contractId' => $contract->id]) }}"
                                        class="dropdown-item">Assinar Contrato</a>
                                </li>
                                <li>
                                    <a href="{{ route('owner.property_contract_client', ['contractId' => $contract->id]) }}"
                                        class="dropdown-item">Contrato do Cliente</a>
                                </li>
                                <li>
                                    <form
                                        action="{{ route('owner.destroy_contract', ['contractId' => $contract->id]) }}"
                                        method="post">
                                        @method('delete')
                                        <button type="submit" class="text-white bg-danger dropdown-item">Excluir
                                            Contrato</button>
                                    </form>
                                </li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script type="text/javascript">
        $('#filtro-propriedade').on('change', function() {
            $.ajax({
                url: "/owner/getReport/" + this.value,
                success: function(result) {
                    value = $('#filtro-propriedade').val();

                    if (value == '0') {
                        $('#comission').show();
                    } else {
                        $('#comission').hide();
                    }

                    $("#report-content").html(result['data']);
                }
            });
        });
    </script>
</body>

</html>
