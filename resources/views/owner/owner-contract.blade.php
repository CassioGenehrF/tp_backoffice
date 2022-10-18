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
                        Opções
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('owner.page') }}">Bloquear Agenda</a>
                        <a class="dropdown-item" href="{{ route('owner.unblock_page') }}">Desbloquear Agenda</a>
                        <a class="dropdown-item" href="{{ route('owner.reservations') }}">Minhas Reservas</a>
                        <a class="dropdown-item" href="{{ route('owner.report') }}">Relatório Mensal</a>
                        <a class="dropdown-item" href="{{ route('owner.properties') }}">Minhas Propriedades</a>
                        <a class="dropdown-item" href="{{ route('owner.demands') }}">Solicitações</a>
                        <a class="dropdown-item" href="{{ route('owner.properties_contracts') }}">Meus Contratos</a>
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
        <form action="{{ route('owner.create_contract') }}" method="POST">
            @csrf
            <input type="hidden" name="property_id" id="property_id" value={{ $property->ID }}>
            <h2 class="text-center mt-2">Dados do Cliente:</h2>
            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for="client">Nome:</label>
                    <input type="text" class="form-control" id="client" name="client">
                </div>
                <div class="form-group col-md-2">
                    <label for="cpf">CPF:</label>
                    <input type="text" class="form-control" id="cpf" name="cpf">
                </div>
                <div class="form-group col-md-2">
                    <label for="cep">CEP:</label>
                    <input type="text" class="form-control" id="cep" name="cep">
                </div>
                <div class="form-group col-md-4">
                    <label for="street">Rua:</label>
                    <input type="text" class="form-control" id="street" name="street">
                </div>
            </div>
            <div class="row mt-2 ">
                <div class="form-group col-md-3">
                    <label class="form-control-label" for="state">Estado</label>
                    <select name="state" id="state" class="form-control">
                        @foreach ($states as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="city">Cidade:</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="form-group col-md-2">
                    <label for="phone">Telefone:</label>
                    <input type="text" class="form-control" id="phone" name="phone"
                        onkeypress="return onlyNumberKey(event)">
                </div>
                <div class="form-group col-md-2">
                    <label for="entry">Hora Limite Entrada:</label>
                    <input type="time" class="form-control" id="entry" name="entry">
                </div>
                <div class="form-group col-md-2">
                    <label for="rent">Valor Locação:</label>
                    <input type="number" class="form-control" id="rent" name="rent">
                </div>
            </div>
            <div class="row mt-2 ">
                <div class="form-group col-md-3">
                    <label for="guests">Número de Hospedes:</label>
                    <input type="number" class="form-control" id="guests" name="guests"
                        onkeypress="return onlyNumberKey(event)">
                </div>
                <div class="form-group col-md-3">
                    <label for="excess">Valor Pessoa Excedente:</label>
                    <input type="number" class="form-control" id="excess" name="excess">
                </div>
                <div class="form-group col-md-2">
                    <label for="sinal">Valor Sinal:</label>
                    <input type="number" class="form-control" id="sinal" name="sinal">
                </div>
                <div class="form-group col-md-2">
                    <label for="clean">Taxa de Limpeza:</label>
                    <input type="number" class="form-control" id="clean" name="clean">
                </div>
                <div class="form-group col-md-2">
                    <label for="bail">Taxa Caução:</label>
                    <input type="number" class="form-control" id="bail" name="bail">
                </div>
            </div>
            <div class="row mt-2 ">
                <div class="form-group col-md-2">
                    <label for="checkin">Check-in:</label>
                    <input class="form-control" type="date" id="checkin" name="checkin" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="checkin_hour">Hora Check-in:</label>
                    <input type="time" class="form-control" id="checkin_hour" name="checkin_hour">
                </div>
                <div class="form-group col-md-2">
                    <label for="checkout">Check-out:</label>
                    <input class="form-control" type="date" id="checkout" name="checkout" required>
                </div>
                <div class="form-group col-md-2">
                    <label for="checkout_hour">Hora Checkout:</label>
                    <input type="time" class="form-control" id="checkout_hour" name="checkout_hour">
                </div>
                <div class="form-group col-md-2">
                    <label for="pet">Permite Pet:</label>
                    <select type="text" class="form-control" id="pet" name="pet">
                        <option value="1">Sim</option>
                        <option value="0">Não</option>
                    </select>
                </div>
            </div>
            <h2 class="text-center mt-2">Dados para Depósito</h2>
            <div class="row mt-2 ">
                <div class="form-group col-md-4">
                    <label class="form-control-label" for="bank">Banco</label>
                    <select name="bank" id="bank" class="form-control">
                        @foreach ($banks as $key => $value)
                            <option value="{{ $key }}">{{ "$key - $value" }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="agency">Agência:</label>
                    <input type="text" class="form-control" id="agency" name="agency">
                </div>
                <div class="form-group col-md-3">
                    <label for="account">Conta:</label>
                    <input type="text" class="form-control" id="account" name="account">
                </div>
                <div class="form-group col-md-2">
                    <label for="cpf_bank">CPF:</label>
                    <input type="number" class="form-control" id="cpf_bank" name="cpf_bank"
                        onkeypress="return onlyNumberKey(event)">
                </div>
            </div>
            <div class="row mt-2">
                <div class="form-group col-md-3">
                    <label for="responsible">Responsável:</label>
                    <input type="text" class="form-control" id="responsible" name="responsible">
                </div>
                <div class="form-group col-md-3">
                    <label for="pix">PIX:</label>
                    <input type="text" class="form-control" id="pix" name="pix">
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="save-button">GERAR CONTRATO</button>
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
