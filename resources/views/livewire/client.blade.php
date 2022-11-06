<div class="container">
    <main>
        <div class="row col-md-12 mt-2">
            <div class="form-group col-md-4">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" name="name" id="name" wire:model="name">
            </div>
            <div class="form-group col-md-3">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" wire:model="cpf">
            </div>
            <div class="form-group col-md-3">
                <label for="status">Status</label>
                <select class="form-select" name="status" id="status" wire:model="status">
                    <option value="" selected>Selecione uma opção</option>
                    <option value="Ativo">Ativo</option>
                    <option value="Pendente">Pendente</option>
                    <option value="Deletando">Deletando</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Status</th>
                        <th class="action" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody id="report-content">
                    @foreach ($clients as $client)
                        <tr>
                            <td>{{ $client->name }}</td>
                            <td>{{ $client->cpf }}</td>
                            <td>{{ $client->phone }}</td>
                            <td>{{ $client->status }}</td>
                            <td>
                                <a href="{{ route('admin.client', ['clientId' => $client->id]) }}"
                                    class="btn btn-light">
                                    Editar
                                </a>
                                <form action="{{ route('admin.destroy_client', ['clientId' => $client->id]) }}"
                                    method="post">
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                                @if ($client->status === 'Pendente')
                                    <form action="{{ route('admin.approve_client', ['clientId' => $client->id]) }}"
                                        method="post">
                                        <button type="submit" class="btn btn-success">Aprovar</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
