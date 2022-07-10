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
    <!-- MDB -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" /> --}}
    <!-- Boostrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
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
                    <a href="{{ route('admin.page') }}">Bloquear Agenda</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.unblock_page') }}">Desbloquear Agenda</a>
                </li>
                <li class="menu-item active">
                    <a href="#">Efetuar Reserva</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.reservations') }}">Minhas Reservas</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.report') }}">Relatório Mensal</a>
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
    <main class="conteudo">
        <section class="p-4 mw-40">
            <div class="calendar">
                <section class="filter">
                    <div class="form-group">
                        <label for="filtro-propriedade">Propriedade:</label>
                        <select name="filtro-propriedade" id="filtro-propriedade" class="form-control">
                            @foreach ($properties as $property)
                                <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>
                <div class="calendar-tools">
                    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                        <span class="calendar-heading">Julho 2022</span>
                    </div>
                </div>
                <table class="month">
                    <thead>
                        <tr>
                            <th>Domingo</th>
                            <th>Segunda</th>
                            <th>Terça</th>
                            <th>Quarta</th>
                            <th>Quinta</th>
                            <th>Sexta</th>
                            <th>Sábado</th>
                        </tr>
                    </thead>
                    <tbody id="calendar-content">
                        {!! $calendar !!}
                    </tbody>
                </table>
            </div>
        </section>
        <form action="{{ route('admin.rent') }}" method="POST" enctype="multipart/form-data">
            @if ($errors->any())
                <ul class="list-group mt-4 w-75 mx-auto">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @csrf
            <input type="hidden" name="propriedade" id="propriedade" value="{{ $properties[0]->ID }}">
            <div class="row">
                <div class="form-group col-md-6">
                    <label for="checkin">Check-in:</label>
                    <input class="form-control" type="date" id="checkin" name="checkin" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="checkout">Check-out:</label>
                    <input class="form-control" type="date" id="checkout" name="checkout" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="hospede">Nome hóspede:</label>
                    <input class="form-control" type="text" id="hospede" name="hospede" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="telefone">Telefone:</label>
                    <input class="form-control" type="tel" id="telefone" name="telefone" required>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for="preco">Preço:</label>
                    <input class="form-control" type="text" id="preco" name="preco" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="adultos">Adultos:</label>
                    <select name="adultos" id="adultos" class="form-control" required>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="criancas">Crianças:</label>
                    <select name="criancas" id="criancas" class="form-control" required>
                        <option value="0">0</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                        <option value="13">13</option>
                        <option value="14">14</option>
                        <option value="15">15</option>
                        <option value="16">16</option>
                        <option value="17">17</option>
                        <option value="18">18</option>
                        <option value="19">19</option>
                        <option value="20">20</option>
                    </select>
                </div>
            </div>
            <div class="custom-file mt-2">
                <label class="custom-file-label" for="contrato" id="labelContrato">Escolher arquivo</label>
                <input type="file" class="custom-file-input" name="contrato" id="contrato">
            </div>
            <button type="submit" class="block-button">ALUGAR</button>
        </form>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
    <script type="text/javascript">
        $('#contrato').change(function() {
            var file = $('#contrato')[0].files[0].name;
            $(this).prev('label').text(file);
        });

        $('#filtro-propriedade').on('change', function() {
            $('#propriedade').val(this.value);

            $.ajax({
                url: "/admin/api/getCalendar/" + this.value,
                success: function(result) {
                    $("#calendar-content").html(result['data']);
                }
            });
        });
    </script>
</body>

</html>