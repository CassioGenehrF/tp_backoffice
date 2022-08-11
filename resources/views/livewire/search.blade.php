<div>
    <main>
        <div class="container">
            <div class="row col-md-12">
                <div class="form-group col-md-3">
                    <label for="start">De</label>
                    <input type="date" class="form-control" name="start" id="start" wire:model="start">
                </div>
                <div class="form-group col-md-3">
                    <label for="end">Até</label>
                    <input type="date" class="form-control" name="end" id="end" wire:model="end">
                </div>
            </div>
            @foreach ($filters as $title => $filter)
                <div class="row col-md-12 mt-2">
                    <h2 class="col-md-12">{{ $title }}</h2>
                    @foreach ($filter as $input)
                        <div class="form-check col-md-3">
                            <input type="checkbox" class="form-check-input" id="{{ $input['slug'] }}"
                                name="{{ $input['slug'] }}" value="{{ $input['term_id'] }}" wire:model="terms">
                            <label for="{{ $input['slug'] }}" class="form-check-label">{{ $input['name'] }}</label>
                        </div>
                    @endforeach
                </div>
            @endforeach
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
