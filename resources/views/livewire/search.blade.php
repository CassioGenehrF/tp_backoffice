<div>
    <main>
        <div class="row col-md-12">
            <div class="form-group col-md-4">
                <label for="start">De</label>
                <input type="date" class="form-control" name="start" id="start" wire:model="start">
            </div>
            <div class="form-group col-md-4">
                <label for="end">Até</label>
                <input type="date" class="form-control" name="end" id="end" wire:model="end">
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
                                        {{ $property->notes }}
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
