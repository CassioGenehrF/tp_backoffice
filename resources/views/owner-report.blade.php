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
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/broker/style.css') }}">
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
                    <a href="{{ route('owner.page') }}">Bloquear Agenda</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('owner.unblock_page') }}">Desbloquear Agenda</a>
                </li>
                <li class="menu-item active">
                    <a href="#">Relatório Mensal</a>
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
        <section class="row mt-2">
            <div class="form-group col-md-4 ml-4">
                <label for="filtro-propriedade">Propriedade:</label>
                <select class="form-control" name="filtro-propriedade" id="filtro-propriedade">
                    <option value="0">Todas</option>
                    @foreach ($properties as $property)
                        <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                    @endforeach
                </select>
            </div>
        </section>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Data</th>
                    <th scope="col">Reservas</th>
                    <th scope="col">Diárias</th>
                    <th scope="col">Total</th>
                    <th scope="col">Taxa de Anfitrião</th>
                    <th id="comission" scope="col">Comissão</th>
                </tr>
            </thead>
            <tbody id="report-content">
                {!! $report !!}
            </tbody>
        </table>
    </main>
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
