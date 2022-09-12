<div>
    <main>
        <div class="container">
            <div class="row col-md-12 mt-2">
                <div class="form-group col-md-2">
                    <label for="propertyId">ID</label>
                    <input type="text" class="form-control" name="propertyId" id="propertyId" wire:model="propertyId">
                </div>
                <div class="form-group col-md-2">
                    <label for="start">De</label>
                    <input type="date" class="form-control" name="start" id="start" wire:model="start">
                </div>
                <div class="form-group col-md-2">
                    <label for="end">Até</label>
                    <input type="date" class="form-control" name="end" id="end" wire:model="end">
                </div>
                <div class="form-group col-md-3">
                    <label for="city">Cidade Origem</label>
                    <input type="text" class="form-control" name="city" id="city" wire:model="city">
                </div>
                <div class="form-group col-md-3">
                    <label for="standard">Padrão</label>
                    <select class="form-select" name="standard" id="standard" wire:model="standard">
                        <option value="0" selected>Selecione um padrão</option>
                        <option value="1">Simples</option>
                        <option value="2">Médio</option>
                        <option value="3">Alto</option>
                    </select>
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
                                            aria-labelledby="heading{{ Str::slug($title) }}" data-bs-parent="#filters">
                                            <div class="accordion-body">
                                                <div class="row col-md-12">
                                                    @foreach ($filter as $key => $input)
                                                        @if (is_array($input))
                                                            <div class="form-check col-md-3">
                                                                <input type="checkbox" class="form-check-input"
                                                                    id="{{ $input['slug'] }}"
                                                                    name="{{ $input['slug'] }}"
                                                                    value="{{ $input['term_id'] }}" wire:model="terms">
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
                        <th scope="col">Valores</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($properties as $property)
                        <tr>
                            <td>{{ $property->post_title }}</td>
                            <td>
                                <details>
                                    <summary>Detalhes</summary>
                                    <p>
                                        {!! nl2br($property->notes) !!}
                                    </p>
                                </details>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
