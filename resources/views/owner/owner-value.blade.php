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
                        <li><a class="dropdown-item" href="{{ route('owner.indications') }}">Fazer uma Indicação</a></li>
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
        <form action="{{ route('owner.save_value') }}" method="POST">
            <input type="hidden" name="property_id" id="property_id" value={{ $property->ID }}>
            <h2 class="text-center mt-2">Valores:</h2>
            <div class="row mt-2">
                <div class="form-group col-md-4">
                    <label for="billing_type">Tipo de Cobrança:</label>
                    <select type="text" class="form-control" id="billing_type" name="billing_type" required>
                        <option value="" disabled hidden {{ isset($value->billing_type) ? '' : 'selected' }}>
                            Selecione
                            um Tipo de Cobrança</option>
                        <option value="people"
                            {{ isset($value->billing_type) && $value->billing_type == 'people' ? 'selected' : '' }}>Por
                            Pessoa
                        </option>
                        <option value="package"
                            {{ isset($value->billing_type) && $value->billing_type == 'package' ? 'selected' : '' }}>
                            Por Pacote
                        </option>
                    </select>
                </div>
            </div>
            <div id="people" style="display: none;">
                <div class="mt-2">
                    <h3>Final de Semana</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_weekend">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_weekend" name="min_people_weekend"
                                required value="{{ $value->min_people_weekend ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_weekend">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_weekend"
                                name="max_people_weekend" required value="{{ $value->max_people_weekend ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="min_daily_weekend">Mínimo de diarias</label>
                            <input type="number" class="form-control" id="min_daily_weekend"
                                name="min_daily_weekend" required value="{{ $value->min_daily_weekend ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_weekend">Valor por pessoa</label>
                            <input type="number" class="form-control" id="price_per_people_weekend"
                                name="price_per_people_weekend" required
                                value="{{ $value->price_per_people_weekend ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_weekend">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_weekend"
                                name="checkin_hour_weekend" required
                                value="{{ $value->checkin_hour_weekend ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_weekend">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_weekend"
                                name="checkout_hour_weekend" required
                                value="{{ $value->checkout_hour_weekend ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Day Use</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_day_use">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_day_use"
                                name="min_people_day_use" required value="{{ $value->min_people_day_use ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_day_use">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_day_use"
                                name="max_people_day_use" required value="{{ $value->max_people_day_use ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_day_use">Valor por pessoa</label>
                            <input type="number" class="form-control" id="price_per_people_day_use"
                                name="price_per_people_day_use" required
                                value="{{ $value->price_per_people_day_use ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_day_use">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_day_use"
                                name="checkin_hour_day_use" required
                                value="{{ $value->checkin_hour_day_use ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_day_use">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_day_use"
                                name="checkout_hour_day_use" required
                                value="{{ $value->checkout_hour_day_use ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Dia de Semana</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_week">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_week" name="min_people_week"
                                required value="{{ $value->min_people_week ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_week">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_week" name="max_people_week"
                                required value="{{ $value->max_people_week ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="min_daily_week">Mínimo de diarias</label>
                            <input type="number" class="form-control" id="min_daily_week" name="min_daily_week"
                                required value="{{ $value->min_daily_week ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_week">Valor por pessoa</label>
                            <input type="number" class="form-control" id="price_per_people_week"
                                name="price_per_people_week" required
                                value="{{ $value->price_per_people_week ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_week">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_week"
                                name="checkin_hour_week" required value="{{ $value->checkin_hour_week ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_week">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_week"
                                name="checkout_hour_week" required value="{{ $value->checkout_hour_week ?? '' }}">
                        </div>
                        <div class="form-group col-md-2 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $value->monday ?? '' }}"
                                    id="monday" name="monday"
                                    {{ isset($value->monday) && $value->monday == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="monday">
                                    Segunda-feira
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $value->tuesday ?? '' }}"
                                    id="tuesday" name="tuesday"
                                    {{ isset($value->tuesday) && $value->tuesday == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="tuesday">
                                    Terça-feira
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox"
                                    value="{{ $value->wednesday ?? '' }}" id="wednesday" name="wednesday"
                                    {{ isset($value->wednesday) && $value->wednesday == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="wednesday">
                                    Quarta-feira
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $value->thursday ?? '' }}"
                                    id="thursday" name="thursday"
                                    {{ isset($value->thursday) && $value->thursday == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="thursday">
                                    Quinta-feira
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="{{ $value->friday ?? '' }}"
                                    id="friday" name="friday"
                                    {{ isset($value->friday) && $value->friday == '1' ? 'checked' : '' }}>
                                <label class="form-check-label" for="friday">
                                    Sexta-feira
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Feriado Prolongado</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_holiday">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_holiday"
                                name="min_people_holiday" required value="{{ $value->min_people_holiday ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_holiday">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_holiday"
                                name="max_people_holiday" required value="{{ $value->max_people_holiday ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="min_daily_holiday">Mínimo de diarias</label>
                            <input type="number" class="form-control" id="min_daily_holiday"
                                name="min_daily_holiday" required value="{{ $value->min_daily_holiday ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_holiday">Valor por pessoa</label>
                            <input type="number" class="form-control" id="price_per_people_holiday"
                                name="price_per_people_holiday" required
                                value="{{ $value->price_per_people_holiday ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_holiday">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_holiday"
                                name="checkin_hour_holiday" required
                                value="{{ $value->checkin_hour_holiday ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_holiday">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_holiday"
                                name="checkout_hour_holiday" required
                                value="{{ $value->checkout_hour_holiday ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Natal</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_christmas">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_christmas"
                                name="min_people_christmas" required
                                value="{{ $value->min_people_christmas ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_christmas">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_christmas"
                                name="max_people_christmas" required
                                value="{{ $value->max_people_christmas ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="min_daily_christmas">Mínimo de diarias</label>
                            <input type="number" class="form-control" id="min_daily_christmas"
                                name="min_daily_christmas" required value="{{ $value->min_daily_christmas ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_christmas">Valor fixo</label>
                            <input type="number" class="form-control" id="price_per_people_christmas"
                                name="price_per_people_christmas" required
                                value="{{ $value->price_per_people_christmas ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_christmas">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_christmas"
                                name="checkin_hour_christmas" required
                                value="{{ $value->checkin_hour_christmas ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_christmas">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_christmas"
                                name="checkout_hour_christmas" required
                                value="{{ $value->checkout_hour_christmas ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Ano Novo</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_new_year">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_new_year"
                                name="min_people_new_year" required value="{{ $value->min_people_new_year ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_new_year">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_new_year"
                                name="max_people_new_year" required value="{{ $value->max_people_new_year ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="min_daily_new_year">Mínimo de diarias</label>
                            <input type="number" class="form-control" id="min_daily_new_year"
                                name="min_daily_new_year" required value="{{ $value->min_daily_new_year ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_new_year">Valor fixo</label>
                            <input type="number" class="form-control" id="price_per_people_new_year"
                                name="price_per_people_new_year" required
                                value="{{ $value->price_per_people_new_year ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_new_year">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_new_year"
                                name="checkin_hour_new_year" required
                                value="{{ $value->checkin_hour_new_year ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_new_year">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_new_year"
                                name="checkout_hour_new_year" required
                                value="{{ $value->checkout_hour_new_year ?? '' }}">
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Carnaval</h3>
                    <div class="row mt-2">
                        <div class="form-group col-md-2">
                            <label for="min_people_carnival">Mínimo de pessoas</label>
                            <input type="number" class="form-control" id="min_people_carnival"
                                name="min_people_carnival" required value="{{ $value->min_people_carnival ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="max_people_carnival">Máximo de pessoas</label>
                            <input type="number" class="form-control" id="max_people_carnival"
                                name="max_people_carnival" required value="{{ $value->max_people_carnival ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="min_daily_carnival">Mínimo de diarias</label>
                            <input type="number" class="form-control" id="min_daily_carnival"
                                name="min_daily_carnival" required value="{{ $value->min_daily_carnival ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="price_per_people_carnival">Valor fixo</label>
                            <input type="number" class="form-control" id="price_per_people_carnival"
                                name="price_per_people_carnival" required
                                value="{{ $value->price_per_people_carnival ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkin_hour_carnival">Hora Check-in:</label>
                            <input type="time" class="form-control" id="checkin_hour_carnival"
                                name="checkin_hour_carnival" required
                                value="{{ $value->checkin_hour_carnival ?? '' }}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="checkout_hour_carnival">Hora Checkout:</label>
                            <input type="time" class="form-control" id="checkout_hour_carnival"
                                name="checkout_hour_carnival" required
                                value="{{ $value->checkout_hour_carnival ?? '' }}">
                        </div>
                    </div>
                </div>
            </div>
            <div id="package" style="display: none;">
                <div class="mt-2">
                    <h3>Final de Semana</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_weekend">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_weekend"
                                    name="max_people_package_start_weekend" required
                                    value="{{ $value->max_people_package_start_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_weekend">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_weekend"
                                    name="price_package_start_weekend" required
                                    value="{{ $value->price_package_start_weekend ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_weekend">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_weekend"
                                    name="min_people_package_2_weekend"
                                    value="{{ $value->min_people_package_2_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_weekend">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_weekend"
                                    name="max_people_package_2_weekend"
                                    value="{{ $value->max_people_package_2_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_weekend">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_weekend"
                                    name="price_package_2_weekend" required
                                    value="{{ $value->price_package_2_weekend ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_weekend">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_weekend"
                                    name="min_people_package_3_weekend"
                                    value="{{ $value->min_people_package_3_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_weekend">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_weekend"
                                    name="max_people_package_3_weekend"
                                    value="{{ $value->max_people_package_3_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_weekend">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_weekend"
                                    name="price_package_3_weekend" required
                                    value="{{ $value->price_package_3_weekend ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_weekend">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_weekend"
                                    name="min_people_package_4_weekend"
                                    value="{{ $value->min_people_package_4_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_weekend">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_weekend"
                                    name="max_people_package_4_weekend"
                                    value="{{ $value->max_people_package_4_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_weekend">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_weekend"
                                    name="price_package_4_weekend" required
                                    value="{{ $value->price_package_4_weekend ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_weekend">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_weekend"
                                    name="min_people_package_5_weekend"
                                    value="{{ $value->min_people_package_5_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_weekend">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_weekend"
                                    name="max_people_package_5_weekend"
                                    value="{{ $value->max_people_package_5_weekend ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5_weekend">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_weekend"
                                    name="price_package_5_weekend" required
                                    value="{{ $value->price_package_5_weekend ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Day Use</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_day_use">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_day_use"
                                    name="max_people_package_start_day_use" required
                                    value="{{ $value->max_people_package_start_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_day_use">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_day_use"
                                    name="price_package_start_day_use" required
                                    value="{{ $value->price_package_start_day_use ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_day_use">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_day_use"
                                    name="min_people_package_2_day_use"
                                    value="{{ $value->min_people_package_2_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_day_use">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_day_use"
                                    name="max_people_package_2_day_use"
                                    value="{{ $value->max_people_package_2_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_day_use">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_day_use"
                                    name="price_package_2_day_use" required
                                    value="{{ $value->price_package_2_day_use ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_day_use">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_day_use"
                                    name="min_people_package_3_day_use"
                                    value="{{ $value->min_people_package_3_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_day_use">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_day_use"
                                    name="max_people_package_3_day_use"
                                    value="{{ $value->max_people_package_3_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_day_use">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_day_use"
                                    name="price_package_3_day_use" required
                                    value="{{ $value->price_package_3_day_use ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_day_use">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_day_use"
                                    name="min_people_package_4_day_use"
                                    value="{{ $value->min_people_package_4_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_day_use">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_day_use"
                                    name="max_people_package_4_day_use"
                                    value="{{ $value->max_people_package_4_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_day_use">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_day_use"
                                    name="price_package_4_day_use" required
                                    value="{{ $value->price_package_4_day_use ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_day_use">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_day_use"
                                    name="min_people_package_5_day_use"
                                    value="{{ $value->min_people_package_5_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_day_use">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_day_use"
                                    name="max_people_package_5_day_use"
                                    value="{{ $value->max_people_package_5_day_use ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5_day_use">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_day_use"
                                    name="price_package_5_day_use" required
                                    value="{{ $value->price_package_5_day_use ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Dia de Semana</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_week">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_week"
                                    name="max_people_package_start_week" required
                                    value="{{ $value->max_people_package_start_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_week">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_week"
                                    name="price_package_start_week" required
                                    value="{{ $value->price_package_start_week ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_week">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_week"
                                    name="min_people_package_2_week"
                                    value="{{ $value->min_people_package_2_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_week">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_week"
                                    name="max_people_package_2_week"
                                    value="{{ $value->max_people_package_2_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_week">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_week"
                                    name="price_package_2_week" required
                                    value="{{ $value->price_package_2_week ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_week">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_week"
                                    name="min_people_package_3_week"
                                    value="{{ $value->min_people_package_3_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_week">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_week"
                                    name="max_people_package_3_week"
                                    value="{{ $value->max_people_package_3_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_week">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_week"
                                    name="price_package_3_week" required
                                    value="{{ $value->price_package_3_week ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_week">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_week"
                                    name="min_people_package_4_week"
                                    value="{{ $value->min_people_package_4_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_week">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_week"
                                    name="max_people_package_4_week"
                                    value="{{ $value->max_people_package_4_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_week">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_week"
                                    name="price_package_4_week" required
                                    value="{{ $value->price_package_4_week ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_week">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_week"
                                    name="min_people_package_5_week"
                                    value="{{ $value->min_people_package_5_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_week">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_week"
                                    name="max_people_package_5_week"
                                    value="{{ $value->max_people_package_5_week ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5_week">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_week"
                                    name="price_package_5_week" required
                                    value="{{ $value->price_package_5_week ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Feriado Prolongado</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_holiday">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_holiday"
                                    name="max_people_package_start_holiday" required
                                    value="{{ $value->max_people_package_start_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_holiday">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_holiday"
                                    name="price_package_start_holiday" required
                                    value="{{ $value->price_package_start_holiday ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_holiday">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_holiday"
                                    name="min_people_package_2_holiday"
                                    value="{{ $value->min_people_package_2_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_holiday">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_holiday"
                                    name="max_people_package_2_holiday"
                                    value="{{ $value->max_people_package_2_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_holiday">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_holiday"
                                    name="price_package_2_holiday" required
                                    value="{{ $value->price_package_2_holiday ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_holiday">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_holiday"
                                    name="min_people_package_3_holiday"
                                    value="{{ $value->min_people_package_3_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_holiday">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_holiday"
                                    name="max_people_package_3_holiday"
                                    value="{{ $value->max_people_package_3_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_holiday">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_holiday"
                                    name="price_package_3_holiday" required
                                    value="{{ $value->price_package_3_holiday ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_holiday">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_holiday"
                                    name="min_people_package_4_holiday"
                                    value="{{ $value->min_people_package_4_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_holiday">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_holiday"
                                    name="max_people_package_4_holiday"
                                    value="{{ $value->max_people_package_4_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_holiday">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_holiday"
                                    name="price_package_4_holiday" required
                                    value="{{ $value->price_package_4_holiday ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_holiday">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_holiday"
                                    name="min_people_package_5_holiday"
                                    value="{{ $value->min_people_package_5_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_holiday">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_holiday"
                                    name="max_people_package_5_holiday"
                                    value="{{ $value->max_people_package_5_holiday ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5_holiday">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_holiday"
                                    name="price_package_5_holiday" required
                                    value="{{ $value->price_package_5_holiday ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Natal</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_christmas">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_christmas"
                                    name="max_people_package_start_christmas" required
                                    value="{{ $value->max_people_package_start_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_christmas">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_christmas"
                                    name="price_package_start_christmas" required
                                    value="{{ $value->price_package_start_christmas ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_christmas">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_christmas"
                                    name="min_people_package_2_christmas"
                                    value="{{ $value->min_people_package_2_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_christmas">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_christmas"
                                    name="max_people_package_2_christmas"
                                    value="{{ $value->max_people_package_2_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_christmas">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_christmas"
                                    name="price_package_2_christmas" required
                                    value="{{ $value->price_package_2_christmas ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_christmas">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_christmas"
                                    name="min_people_package_3_christmas"
                                    value="{{ $value->min_people_package_3_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_christmas">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_christmas"
                                    name="max_people_package_3_christmas"
                                    value="{{ $value->max_people_package_3_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_christmas">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_christmas"
                                    name="price_package_3_christmas" required
                                    value="{{ $value->price_package_3_christmas ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_christmas">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_christmas"
                                    name="min_people_package_4_christmas"
                                    value="{{ $value->min_people_package_4_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_christmas">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_christmas"
                                    name="max_people_package_4_christmas"
                                    value="{{ $value->max_people_package_4_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_christmas">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_christmas"
                                    name="price_package_4_christmas" required
                                    value="{{ $value->price_package_4_christmas ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_christmas">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_christmas"
                                    name="min_people_package_5_christmas"
                                    value="{{ $value->min_people_package_5_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_christmas">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_christmas"
                                    name="max_people_package_5_christmas"
                                    value="{{ $value->max_people_package_5_christmas ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_christmas"
                                    name="price_package_5_christmas" required
                                    value="{{ $value->price_package_5_christmas ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Ano Novo</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_new_year">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_new_year"
                                    name="max_people_package_start_new_year" required
                                    value="{{ $value->max_people_package_start_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_new_year">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_new_year"
                                    name="price_package_start_new_year" required
                                    value="{{ $value->price_package_start_new_year ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_new_year">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_new_year"
                                    name="min_people_package_2_new_year"
                                    value="{{ $value->min_people_package_2_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_new_year">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_new_year"
                                    name="max_people_package_2_new_year"
                                    value="{{ $value->max_people_package_2_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_new_year">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_new_year"
                                    name="price_package_2_new_year" required
                                    value="{{ $value->price_package_2_new_year ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_new_year">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_new_year"
                                    name="min_people_package_3_new_year"
                                    value="{{ $value->min_people_package_3_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_new_year">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_new_year"
                                    name="max_people_package_3_new_year"
                                    value="{{ $value->max_people_package_3_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_new_year">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_new_year"
                                    name="price_package_3_new_year" required
                                    value="{{ $value->price_package_3_new_year ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_new_year">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_new_year"
                                    name="min_people_package_4_new_year"
                                    value="{{ $value->min_people_package_4_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_new_year">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_new_year"
                                    name="max_people_package_4_new_year"
                                    value="{{ $value->max_people_package_4_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_new_year">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_new_year"
                                    name="price_package_4_new_year" required
                                    value="{{ $value->price_package_4_new_year ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_new_year">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_new_year"
                                    name="min_people_package_5_new_year"
                                    value="{{ $value->min_people_package_5_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_new_year">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_new_year"
                                    name="max_people_package_5_new_year"
                                    value="{{ $value->max_people_package_5_new_year ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5_new_year">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_new_year"
                                    name="price_package_5_new_year" required
                                    value="{{ $value->price_package_5_new_year ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <h3>Carnaval</h3>
                    <div class="row justify-content-center mt-2">
                        <div class="mt-2 col-md-2">
                            <h4>Pacote Inicial</h4>
                            <div class="form-group">
                                <label for="max_people_package_start_carnival">Número de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_start_carnival"
                                    name="max_people_package_start_carnival" required
                                    value="{{ $value->max_people_package_start_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_start_carnival">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_start_carnival"
                                    name="price_package_start_carnival" required
                                    value="{{ $value->price_package_start_carnival ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 2</h4>
                            <div class="form-group">
                                <label for="min_people_package_2_carnival">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_2_carnival"
                                    name="min_people_package_2_carnival"
                                    value="{{ $value->min_people_package_2_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_2_carnival">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_2_carnival"
                                    name="max_people_package_2_carnival"
                                    value="{{ $value->max_people_package_2_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_2_carnival">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_2_carnival"
                                    name="price_package_2_carnival" required
                                    value="{{ $value->price_package_2_carnival ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 3</h4>
                            <div class="form-group">
                                <label for="min_people_package_3_carnival">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_3_carnival"
                                    name="min_people_package_3_carnival"
                                    value="{{ $value->min_people_package_3_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_3_carnival">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_3_carnival"
                                    name="max_people_package_3_carnival"
                                    value="{{ $value->max_people_package_3_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_3_carnival">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_3_carnival"
                                    name="price_package_3_carnival" required
                                    value="{{ $value->price_package_3_carnival ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 4</h4>
                            <div class="form-group">
                                <label for="min_people_package_4_carnival">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_4_carnival"
                                    name="min_people_package_4_carnival"
                                    value="{{ $value->min_people_package_4_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_4_carnival">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_4_carnival"
                                    name="max_people_package_4_carnival"
                                    value="{{ $value->max_people_package_4_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_4_carnival">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_4_carnival"
                                    name="price_package_4_carnival" required
                                    value="{{ $value->price_package_4_carnival ?? '' }}">
                            </div>
                        </div>
                        <div class="mt-2 col-md-2">
                            <h4>Pacote 5</h4>
                            <div class="form-group">
                                <label for="min_people_package_5_carnival">Mínimo de pessoas</label>
                                <input type="number" class="form-control" id="min_people_package_5_carnival"
                                    name="min_people_package_5_carnival"
                                    value="{{ $value->min_people_package_5_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="max_people_package_5_carnival">Máximo de pessoas</label>
                                <input type="number" class="form-control" id="max_people_package_5_carnival"
                                    name="max_people_package_5_carnival"
                                    value="{{ $value->max_people_package_5_carnival ?? '' }}">
                            </div>
                            <div class="form-group">
                                <label for="price_package_5_carnival">Valor pacote</label>
                                <input type="number" class="form-control" id="price_package_5_carnival"
                                    name="price_package_5_carnival" required
                                    value="{{ $value->price_package_5_carnival ?? '' }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <button type="submit" class="save-button">Salvar</button>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script text="text/javascript">
        function changeBillingType() {
            if ($('#billing_type').val() == 'people') {
                $('#people').show();
                $('#people :input').prop('disabled', false);
                $('#package').hide();
                $('#package :input').prop('disabled', true);
            }

            if ($('#billing_type').val() == 'package') {
                $('#people').hide();
                $('#people :input').prop('disabled', true);
                $('#package').show();
                $('#package :input').prop('disabled', false);
            }
        }

        $(document).ready(function() {
            var $checkBox = $("[type='checkbox']");
            var checkBoxval = $checkBox.val();
            $checkBox.on("click", function() {
                $(this).val(Number($(this).prop("checked") == true))
            })

            $('#billing_type').on('change', function() {
                changeBillingType()
            });

            changeBillingType()
        });
    </script>
</body>

</html>
