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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.css" rel="stylesheet" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
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
                <li class="menu-item active">
                    <a href="#">Desbloquear Agenda</a>
                </li>
                <li class="menu-item">
                    <a href="{{ route('admin.reservation') }}">Efetuar Reserva</a>
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
        <section class="p-4 mw-60">
            <div class="calendar">
                <section class="filter">
                    <div class="input-box">
                        <label for="filtro-propriedade">Propriedade:</label>
                        <select name="filtro-propriedade" id="filtro-propriedade">
                            @foreach ($properties as $property)
                                <option value="{{ $property->ID }}">{{ $property->post_title }}</option>
                            @endforeach
                        </select>
                    </div>
                </section>
                <div class="calendar-tools">
                    <input type="hidden" name="month_id" id="month_id" value="{{ $monthId }}">
                    <input type="hidden" name="year_id" id="year_id" value="{{ $yearId }}">
                    <div class="d-flex flex-column flex-lg-row justify-content-center align-items-center">
                        <div class="my-2 me-2 my-lg-0 d-flex justify-content-center">
                            <button onclick="prevMonth()" data-mdb-ripple-color="dark" class="btn btn-link text-dark">
                                <i class="fas fa-chevron-left"></i>
                            </button>
                        </div>
                        <span class="calendar-heading">{{ $month }}</span>
                        <div class="my-2 me-2 my-lg-0 d-flex justify-content-center">
                            <button onclick="nextMonth()" data-mdb-ripple-color="dark" class="btn btn-link text-dark">
                                <i class="fas fa-chevron-right"></i>
                            </button>
                        </div>
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
        <form action="{{ route('admin.unblock') }}" method="POST">
            @if ($errors->any())
                <ul class="list-group mt-4 w-75 mx-auto">
                    @foreach ($errors->all() as $error)
                        <li class="list-group-item list-group-item-danger">{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            @csrf
            <input type="hidden" name="propriedade" id="propriedade" value="{{ $properties[0]->ID }}">
            <div class="input-box">
                <label for="checkin">Check-in:</label>
                <input type="date" id="checkin" name="checkin" placeholder="xx/xx/xxxx" required>
            </div>
            <div class="input-box">
                <label for="checkout">Check-out:</label>
                <input type="date" id="checkout" name="checkout" placeholder="xx/xx/xxxx" required>
            </div>
            <button type="submit" class="block-button">Desbloquear</button>
        </form>
    </main>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/4.2.0/mdb.min.js"></script>
    <script type="text/javascript">
        $('#filtro-propriedade').on('change', function() {
            $('#propriedade').val(this.value);

            $.ajax({
                url: "/admin/getCalendar/" + this.value + "/" + $('#month_id').val() + "/" + $('#year_id').val(),
                success: function(result) {
                    $("#calendar-content").html(result['data']);
                }
            });
        });

        function prevMonth() {
            let month = parseInt($('#month_id').val()) - 1
            let year = parseInt($('#year_id').val())
            let propriedade = $('#propriedade').val()

            if (month >= 1) {
                $('#month_id').val(month)
            } else {
                month = 12
                year = parseInt($('#year_id').val()) - 1
                $('#month_id').val(month)
                $('#year_id').val(year)
            }

            $.ajax({
                url: "/admin/getCalendar/" + propriedade + "/" + month + "/" + year,
                success: function(result) {
                    $(".calendar-heading").html(result['month']);
                    $("#calendar-content").html(result['data']);
                }
            });
        }

        function nextMonth() {
            let month = parseInt($('#month_id').val()) + 1
            let year = parseInt($('#year_id').val())
            let propriedade = $('#propriedade').val()

            if (month <= 12) {
                $('#month_id').val(month);
            } else {
                month = 1
                year = parseInt(year) + 1
                $('#month_id').val(month)
                $('#year_id').val(year)
            }

            $.ajax({
                url: "/admin/getCalendar/" + propriedade + "/" + month + "/" + year,
                success: function(result) {
                    $(".calendar-heading").html(result['month']);
                    $("#calendar-content").html(result['data']);
                }
            });
        }
    </script>
</body>

</html>
