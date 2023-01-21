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
                        Menu
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu">
                        <li><a class="dropdown-item" href="{{ route('owner.page') }}">Bloquear Data</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.unblock_page') }}">Desbloquear Data</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('owner.reservations') }}">Minhas Reservas</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.report') }}">Relatório Financeiro</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.properties') }}">Meus Imóveis</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('owner.demands') }}">Ver Ofertas</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.properties_contracts') }}">Meus
                                Contratos</a>
                        </li>
                        <li><a class="dropdown-item" href="{{ route('owner.clients') }}">Histórico de Clientes</a></li>
                        <li><a class="dropdown-item" href="{{ route('owner.indications') }}">Indicar um cliente</a></li>
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
        <div class="accordion mt-2" id="demands">
            @foreach ($demands as $key => $demand)
                <div class="accordion-item" id="demand-{{ $key }}">
                    <h2 class="accordion-header" id="heading{{ Str::slug("$demand->client-$key") }}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#{{ Str::slug("$demand->client-$key") }}" aria-expanded="fallse"
                            aria-controls="{{ Str::slug("$demand->client-$key") }}">
                            {{ $demand->client }}
                            -
                            <span style="color: red">
                                &nbsp;Expira em:&nbsp;
                                <span id="expires_in{{ $key }}"></span>
                            </span>
                        </button>
                    </h2>
                    <div id="{{ Str::slug("$demand->client-$key") }}" class="accordion-collapse collapse"
                        aria-labelledby="heading{{ Str::slug("$demand->client-$key") }}" data-bs-parent="#demands">
                        <div class="accordion-body">
                            <div class="row col-md-12">
                                <p>Nome do Cliente: {{ $demand->client }}</p>
                                <p>Telefone: {{ $demand->phone }}</p>
                                <p>Quantidade de Pessoas: {{ $demand->people_number }}</p>
                                <p>Perfil: {{ $demand->type }}</p>
                                <p>Data: {{ $demand->checkin }} - {{ $demand->checkout }}</p>
                                <p>Valor Disponível: {{ $demand->price }}</p>
                                <button type="submit" class="save-button">Aceitar Solicitação</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
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

        var demands = [
            @foreach ($demands as $key => $demand)
                ["{{ $key }}", "{{ $demand->expired_at }}"],
            @endforeach
        ];

        demands.forEach(function(value, key) {
            let start = new Date(value[1]);

            function getdate() {
                var now = new Date;
                var h = Math.trunc((start - now) / 1000 / 60 / 60);
                var m = Math.trunc((start - now) / 1000 / 60 - (h * 60));
                var s = Math.trunc((start - now) / 1000 - ((m * 60) + (h * 60 * 60)));

                if ((start - now) <= 0) {
                    $("#demand-" + key).remove();
                }

                if (s < 10) {
                    s = "0" + s;
                }
                if (m < 10) {
                    m = "0" + m;
                }
                $("#expires_in" + key).text("" + h + "h " + m + "m " + s + "s ");
                setTimeout(function() {
                    getdate()
                }, 1000);
            }
            getdate();
        })
    </script>
</body>

</html>
