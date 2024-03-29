<div>
    <main>
        <div class="container">
            <div class="row col-md-12 mt-2">
                <div class="form-group col-md-2">
                    <label for="propertyId">ID</label>
                    <input type="text" class="form-control" name="propertyId" id="propertyId"
                        wire:model.debounce.1s="propertyId">
                </div>
                <div class="form-group col-md-2">
                    <label for="start">De</label>
                    <input type="date" class="form-control" name="start" id="start"
                        wire:model.debounce.1s="start">
                </div>
                <div class="form-group col-md-2">
                    <label for="end">Até</label>
                    <input type="date" class="form-control" name="end" id="end" wire:model="end">
                </div>
                <div class="form-group col-md-3">
                    <label for="city">Cidade Origem</label>
                    <input type="text" class="form-control" name="city" id="city"
                        wire:model.debounce.1s="city">
                </div>
                <div class="form-group col-md-3">
                    <label for="standard">Padrão</label>
                    <select class="form-select" name="standard" id="standard" wire:model.debounce.1s="standard">
                        <option value="" disabled selected hidden>Selecione uma opção</option>
                        <option value="0">Sem Classificação</option>
                        <option value="1">Simples</option>
                        <option value="2">Médio</option>
                        <option value="3">Alto</option>
                    </select>
                </div>
            </div>
            <div class="row col-md-12 mt-2">
                <div class="form-group col-md-3">
                    <label for="period">Período</label>
                    <select class="form-select" name="period" id="period" wire:model.debounce.1s="period">
                        <option value="0" selected>Selecione uma opção</option>
                        <option value="weekend">Final de Semana</option>
                        <option value="day_use">Day Use</option>
                        <option value="week">Dia de Semana</option>
                        <option value="holiday">Feriado Prolongado</option>
                        <option value="christmas">Natal</option>
                        <option value="new_year">Ano Novo</option>
                        <option value="carnival">Carnaval</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="minValue">Valor Mínimo</label>
                    <input type="number" class="form-control" name="minValue" id="minValue"
                        wire:model.debounce.1s="minValue">
                </div>
                <div class="form-group col-md-3">
                    <label for="maxValue">Valor Máximo</label>
                    <input type="number" class="form-control" name="maxValue" id="maxValue"
                        wire:model.debounce.1s="maxValue">
                </div>
                <div class="form-group col-md-2">
                    <label for="people">Número de Pessoas</label>
                    <input type="number" class="form-control" name="people" id="people"
                        wire:model.debounce.1s="people">
                </div>
                <div class="form-group col-md-2">
                    <label for="daily">Número de Diárias</label>
                    <input type="number" class="form-control" name="daily" id="daily"
                        wire:model.debounce.1s="daily">
                </div>
            </div>
            <div class="accordion mt-2" id="mainFilter" style="margin-right: 1.5rem">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingFilters">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#filters" aria-expanded="false" aria-controls="filters">
                            Filtros
                        </button>
                    </h2>
                    <div id="filters" class="accordion-collapse collapse" aria-labelledby="headingfilters"
                        data-bs-parent="#mainFilter">
                        <div class="accordion-body">
                            <div class="accordion mt-2" id="filters">
                                @foreach ($filters as $title => $filter)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ Str::slug($title) }}">
                                            <button class="accordion-button {{ $filter['status'] ? '' : 'collapsed' }}"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#{{ Str::slug($title) }}"
                                                aria-expanded="{{ $filter['status'] }}"
                                                aria-controls="{{ Str::slug($title) }}">
                                                {{ $title }}
                                            </button>
                                        </h2>
                                        <div id="{{ Str::slug($title) }}"
                                            class="accordion-collapse {{ $filter['status'] ? '' : 'collapse' }}"
                                            aria-labelledby="heading{{ Str::slug($title) }}"
                                            data-bs-parent="#filters">
                                            <div class="accordion-body">
                                                <div class="row col-md-12">
                                                    @foreach ($filter as $key => $input)
                                                        @if (is_array($input))
                                                            <div class="form-check col-md-3">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="{{ $input['slug'] }}"
                                                                    name="{{ $input['slug'] }}"
                                                                    value="{{ $input['term_id'] }}"
                                                                    wire:model="terms">
                                                                <label for="{{ $input['slug'] }}"
                                                                    class="form-check-label">{{ $input['name'] }}</label>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Imóvel</th>
                        <th scope="col">Cidade</th>
                        <th scope="col">Estado</th>
                        @if ($city)
                            <th scope="col">Distância (em KM)</th>
                        @endif
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($properties as $property)
                        <tr>
                            <td>{{ $property->post_title }}</td>
                            <td>{{ $property->city }}</td>
                            <td>{{ $property->state }}</td>
                            @if ($city)
                                <td>{{ $property->distance }}</td>
                            @endif
                            <td>
                                @if ($property->propertyValue)
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#propertyValue{{ $property->ID }}">
                                        Consultar Valores
                                    </button>
                                    <div class="modal fade" id="propertyValue{{ $property->ID }}" tabindex="-1"
                                        aria-labelledby="propertyValueLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h2 class="modal-title" id="propertyValueLabel">Valores
                                                        {{ $property->ID }}</h2>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    @if ($property->propertyValue->billing_type == 'people')
                                                        <div>
                                                            <h4>Final de Semana</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_weekend'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_weekend'] }}
                                                            </p>
                                                            <p>
                                                                Mínimo de diárias:
                                                                {{ $property->propertyValue->people()->first()['min_daily_weekend'] }}
                                                            </p>
                                                            <p>
                                                                Valor por pessoa:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_weekend'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_weekend'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_weekend'] }}
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <h4>Day Use</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_day_use'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_day_use'] }}
                                                            </p>
                                                            <p>
                                                                Valor por pessoa:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_day_use'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_day_use'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_day_use'] }}
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <h4>Dia de Semana</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_week'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_week'] }}
                                                            </p>
                                                            <p>
                                                                Mínimo de diárias:
                                                                {{ $property->propertyValue->people()->first()['min_daily_week'] }}
                                                            </p>
                                                            <p>
                                                                Valor por pessoa:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_week'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_week'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_week'] }}
                                                            </p>
                                                            <p><b>Dias Disponíveis:</b></p>
                                                            <p>
                                                                Segunda-feira:
                                                                {{ $property->propertyValue->people()->first()['monday'] == 1 ? 'Sim' : 'Não' }}
                                                            </p>
                                                            <p>
                                                                Terça-feira:
                                                                {{ $property->propertyValue->people()->first()['tuesday'] == 1 ? 'Sim' : 'Não' }}
                                                            </p>
                                                            <p>
                                                                Quarta-feira:
                                                                {{ $property->propertyValue->people()->first()['wednesday'] == 1 ? 'Sim' : 'Não' }}
                                                            </p>
                                                            <p>
                                                                Quinta-feira:
                                                                {{ $property->propertyValue->people()->first()['thursday'] == 1 ? 'Sim' : 'Não' }}
                                                            </p>
                                                            <p>
                                                                Sexta-feira:
                                                                {{ $property->propertyValue->people()->first()['friday'] == 1 ? 'Sim' : 'Não' }}
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <h4>Feriado Prolongado</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_holiday'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_holiday'] }}
                                                            </p>
                                                            <p>
                                                                Mínimo de diárias:
                                                                {{ $property->propertyValue->people()->first()['min_daily_holiday'] }}
                                                            </p>
                                                            <p>
                                                                Valor por pessoa:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_holiday'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_holiday'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_holiday'] }}
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <h4>Natal</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_christmas'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_christmas'] }}
                                                            </p>
                                                            <p>
                                                                Mínimo de diárias:
                                                                {{ $property->propertyValue->people()->first()['min_daily_christmas'] }}
                                                            </p>
                                                            <p>
                                                                Valor fixo:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_christmas'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_christmas'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_christmas'] }}
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <h4>Ano Novo</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_new_year'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_new_year'] }}
                                                            </p>
                                                            <p>
                                                                Mínimo de diárias:
                                                                {{ $property->propertyValue->people()->first()['min_daily_new_year'] }}
                                                            </p>
                                                            <p>
                                                                Valor fixo:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_new_year'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_new_year'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_new_year'] }}
                                                            </p>
                                                            <hr>
                                                        </div>
                                                        <div>
                                                            <h4>Carnaval</h4>
                                                            <p>
                                                                Mínimo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['min_people_carnival'] }}
                                                            </p>
                                                            <p>
                                                                Máximo de pessoas:
                                                                {{ $property->propertyValue->people()->first()['max_people_carnival'] }}
                                                            </p>
                                                            <p>
                                                                Mínimo de diárias:
                                                                {{ $property->propertyValue->people()->first()['min_daily_carnival'] }}
                                                            </p>
                                                            <p>
                                                                Valor fixo:
                                                                R$
                                                                {{ number_format($property->propertyValue->people()->first()['price_per_people_carnival'], 2, ',', '') }}
                                                            </p>
                                                            <p>
                                                                Hora checkin:
                                                                {{ $property->propertyValue->people()->first()['checkin_hour_carnival'] }}
                                                            </p>
                                                            <p>
                                                                Hora checkout:
                                                                {{ $property->propertyValue->people()->first()['checkout_hour_carnival'] }}
                                                            </p>
                                                        </div>
                                                    @else
                                                        <div>
                                                            <h3>Final de semana</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_weekend'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_weekend'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_weekend'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_weekend'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_weekend'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_weekend'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <h3>Day Use</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_day_use'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_day_use'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_day_use'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_day_use'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_day_use'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_day_use'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <h3>Dia de Semana</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_week'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_week'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_week'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_week'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_week'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_week'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_week'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_week'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_week'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_week'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_week'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_week'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_week'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_week'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <h3>Feriado Prolongado</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_holiday'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <h3>Natal</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_christmas'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_christmas'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_christmas'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_christmas'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_christmas'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <h3>Ano Novo</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_new_year'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_new_year'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_new_year'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_new_year'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_new_year'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <hr>
                                                        <div>
                                                            <h3>Carnaval</h3>
                                                            <div>
                                                                <h4>Pacote Inicial</h4>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_start_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_start_carnival'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 2</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_2_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_2_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_2_carnival'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 3</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_3_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_3_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_3_carnival'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 4</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_4_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_4_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_4_carnival'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                            <div>
                                                                <h4>Pacote 5</h4>
                                                                <p>
                                                                    Mínimo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['min_people_package_5_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Máximo de pessoas:
                                                                    {{ $property->propertyValue->package()->first()['max_people_package_5_carnival'] }}
                                                                </p>
                                                                <p>
                                                                    Valor Pacote:
                                                                    R$
                                                                    {{ number_format($property->propertyValue->package()->first()['price_package_5_holiday'], 2, ',', '') }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Voltar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
