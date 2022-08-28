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
        <img class="menu-logo" src="{{ asset('images/Logopaulista.png') }}" alt="">
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
    @if ($errors->any())
        <ul class="list-group mt-4 w-75 mx-auto">
            @foreach ($errors->all() as $error)
                <li class="list-group-item list-group-item-danger">{{ $error }}</li>
            @endforeach
        </ul>
    @endif
    <main class="container p-4">
        <form action="{{ route('owner.send_property_documents') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="property_id" id="property_id" value={{ $property->ID }}>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="document">Foto do Documento Frente e Verso</label>
                    <input type="file" name="document" id="document" class="form-control" accept="image/*" required>
                    <small class="form-text text-muted">CNH, RG ou Passaporte</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="code">Código de Confirmação</label>
                    <input type="text" class="form-control" name="code" id="code" readonly required
                        value="{{ $confirmation_code }}">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="confirmation">Selfie de Confirmação*</label>
                    <input type="file" name="confirmation" id="confirmation" accept="image/*" class="form-control"
                        required>
                    <small class="form-text text-muted">Na selfie de confirmação você deve enviar uma
                        foto sua segurando o documento junto de um papel com o código informado acima.</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="residence">Comprovante de Residência</label>
                    <input type="file" name="residence" id="residence" class="form-control" accept="image/*"
                        required>
                    <small class="form-text text-muted">Água, Luz, IPTU, Mátricula do imóvel</small>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="relation">Comprovação de Vínculo*</label>
                    <input type="file" name="relation" id="relation" class="form-control" accept="image/*">
                    <small class="form-text text-muted">*Caso o documento esteja em nome de terceiro, deve ser enviado
                        documento que explique qual o vínculo do anunciante com o títular do comprovante de
                        endereço. Como uma Certidão de Casamento, Certidão de Nascimento, Contrato de União Estável,
                        entre outros.</small>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="save-button">Enviar Documentos</button>
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
</body>

</html>
