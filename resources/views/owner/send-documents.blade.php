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

    <link rel="stylesheet" href="{{ asset('css/calendar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/owner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
</head>

<body>
    <main class="container p-4 flex justify-content-center flex-column">
        <h1 class="text-center">Verificação de Cadastro</h1>
        <form action="{{ route('owner.send_documents') }}" method="post" enctype="multipart/form-data">
            <div class="row">
                <div class="form-group col-md-12">
                    <label for="document">Foto do Documento Frente e Verso</label>
                    <input type="file" name="document" id="document" class="form-control" required>
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
                    <input type="file" name="confirmation" id="confirmation" class="form-control" required>
                    <small class="form-text text-muted">Na selfie de confirmação você deve enviar uma
                        foto sua segurando o documento junto de um papel com o código informado acima.</small>
                </div>
            </div>
            <button type="submit" class="btn btn-primary bnt-lg">Enviar Documentação</button>
        </form>
    </main>
</body>

</html>
