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
        <a href="{{ route('owner.page') }}">
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
                        <a class="dropdown-item" href="{{ route('owner.page') }}">Bloquear Data</a>
                        <a class="dropdown-item" href="{{ route('owner.unblock_page') }}">Desbloquear Data</a>
                        <a class="dropdown-item" href="{{ route('owner.reservations') }}">Minhas Reservas</a>
                        <a class="dropdown-item" href="{{ route('owner.report') }}">Relatório Financeiro</a>
                        <a class="dropdown-item" href="{{ route('owner.properties') }}">Meus Imóveis</a>
                        <a class="dropdown-item" href="{{ route('owner.demands') }}">Ver Ofertas</a>
                        <a class="dropdown-item" href="{{ route('owner.properties_contracts') }}">Meus Contratos</a>
                        <a class="dropdown-item" href="{{ route('owner.clients') }}">Histórico de Clientes</a>
                        <a class="dropdown-item" href="{{ route('owner.indications') }}">Fazer uma Indicação</a>
                    </div>
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
    <main class="container">
        <form action="{{ route('owner.save_client') }}" method="POST">
            <h2 class="text-center mt-2">Dados do Cliente:</h2>
            <input type="hidden" name="client_id" id="client_id" value="{{ $client->id ?? null }}">
            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="name">Nome:</label>
                    @if ($client)
                        <input class="form-control" type="text" id="name" name="name"
                            value="{{ $client->name }}" required>
                    @else
                        <input type="text" class="form-control" id="name" name="name" required>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="cpf">CPF:</label>
                    @if ($client)
                        <input class="form-control" type="text" id="cpf" name="cpf"
                            value="{{ $client->cpf }}" required>
                    @else
                        <input type="text" class="form-control" id="cpf" name="cpf" required>
                    @endif
                </div>
                <div class="form-group col-md-3">
                    <label for="phone">Telefone:</label>
                    @if ($client)
                        <input type="text" class="form-control" id="phone" name="phone"
                            onkeypress="return onlyNumberKey(event)" required value="{{ $client->phone }}">
                    @else
                        <input type="text" class="form-control" id="phone" name="phone"
                            onkeypress="return onlyNumberKey(event)" required>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-12">
                    <label for="message">Mensagem:</label>
                    @if ($client)
                        <textarea rows="3" class="form-control" id="message" name="message" required>{{ $client->message }}</textarea>
                    @else
                        <textarea rows="3" class="form-control" id="message" name="message" required></textarea>
                    @endif
                </div>
                <input type="hidden" id="feedback_stars" name="feedback_stars"
                    value="{{ $client->feedback_stars ?? 1 }}">
            </div>
            <div class="row justify-content-center mt-2">
                <div class="feedback">
                    <a href="javascript:void(0)" onclick="Avaliar(1)">
                        <img src="{{ asset('images/star1.png') }}" id="s1" class="star"
                            onmouseover="hover(this);" onmouseout="unhover(this);">
                    </a>

                    <a href="javascript:void(0)" onclick="Avaliar(2)">
                        <img src="{{ asset('images/star0.png') }}" id="s2" class="star"
                            onmouseover="hover(this);" onmouseout="unhover(this);">
                    </a>

                    <a href="javascript:void(0)" onclick="Avaliar(3)">
                        <img src="{{ asset('images/star0.png') }}" id="s3" class="star"
                            onmouseover="hover(this);" onmouseout="unhover(this);">
                    </a>

                    <a href="javascript:void(0)" onclick="Avaliar(4)">
                        <img src="{{ asset('images/star0.png') }}" id="s4" class="star"
                            onmouseover="hover(this);" onmouseout="unhover(this);">
                    </a>

                    <a href="javascript:void(0)" onclick="Avaliar(5)">
                        <img src="{{ asset('images/star0.png') }}" id="s5" class="star"
                            onmouseover="hover(this);" onmouseout="unhover(this);">
                    </a>
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-6">
                    <label for="feedback_positive">Pontos Positivos:</label>
                    @if ($client)
                        <textarea rows="3" class="form-control" id="feedback_positive" name="feedback_positive" required>{{ $client->feedback_positive }}</textarea>
                    @else
                        <textarea rows="3" class="form-control" id="feedback_positive" name="feedback_positive" required></textarea>
                    @endif
                </div>
                <div class="form-group col-md-6">
                    <label for="feedback_negative">Pontos Negativos:</label>
                    @if ($client)
                        <textarea rows="3" class="form-control" id="feedback_negative" name="feedback_negative" required>{{ $client->feedback_negative }}</textarea>
                    @else
                        <textarea rows="3" class="form-control" id="feedback_negative" name="feedback_negative" required></textarea>
                    @endif
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    @if ($client)
                        <button type="submit" class="save-button">Salvar Cliente</button>
                    @else
                        <button type="submit" class="save-button">Criar Cliente</button>
                    @endif
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
    <script text="text/javascript">
        $(function() {
            let stars = {{ $client->feedback_stars ?? 1 }};
            changeStar(stars);
        });

        $('#checkin').on('change', function() {
            $('#checkout').val($('#checkin').val())
            $('#checkout').prop('min', $('#checkin').val())
        });

        function onlyNumberKey(evt) {
            var ASCIICode = (evt.which) ? evt.which : evt.keyCode
            return !(ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
        }

        function hover(element) {
            changeStar(element.id);
        }

        function unhover(element) {
            let feedback_stars = document.getElementById('feedback_stars');
            changeStar(feedback_stars.value);
        }

        function Avaliar(estrela) {
            changeStar(estrela)

            document.getElementById('feedback_stars').value = estrela;
        }

        function changeStar(selectedStar) {
            if (selectedStar == 5 || selectedStar == 's5') {
                document.getElementById("s1").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s2").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s3").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s4").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s5").src = "{{ asset('images/star1.png') }}";
            }

            //ESTRELA 4
            if (selectedStar == 4 || selectedStar == 's4') {
                document.getElementById("s1").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s2").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s3").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s4").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s5").src = "{{ asset('images/star0.png') }}";
            }

            //ESTRELA 3
            if (selectedStar == 3 || selectedStar == 's3') {
                document.getElementById("s1").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s2").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s3").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s4").src = "{{ asset('images/star0.png') }}";
                document.getElementById("s5").src = "{{ asset('images/star0.png') }}";
            }

            //ESTRELA 2
            if (selectedStar == 2 || selectedStar == 's2') {
                document.getElementById("s1").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s2").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s3").src = "{{ asset('images/star0.png') }}";
                document.getElementById("s4").src = "{{ asset('images/star0.png') }}";
                document.getElementById("s5").src = "{{ asset('images/star0.png') }}";
            }

            //ESTRELA 1
            if (selectedStar == 1 || selectedStar == 's1') {
                document.getElementById("s1").src = "{{ asset('images/star1.png') }}";
                document.getElementById("s2").src = "{{ asset('images/star0.png') }}";
                document.getElementById("s3").src = "{{ asset('images/star0.png') }}";
                document.getElementById("s4").src = "{{ asset('images/star0.png') }}";
                document.getElementById("s5").src = "{{ asset('images/star0.png') }}";
            }
        }
    </script>
</body>

</html>
