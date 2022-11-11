<div class="container">
    <main>
        <div class="row col-md-12 mt-2">
            <div class="form-group col-md-4">
                <label for="name">Nome:</label>
                <input type="text" class="form-control" name="name" id="name" wire:model="name">
            </div>
            <div class="form-group col-md-2">
                <label for="cpf">CPF:</label>
                <input type="text" class="form-control" name="cpf" id="cpf" wire:model="cpf">
            </div>
            <div class="form-group col-md-3">
                <label for="status">Status</label>
                <select class="form-select" name="status" id="status" wire:model="status">
                    <option value="" selected>Selecione uma opção</option>
                    <option value="Aguardando Atendimento">Aguardando Atendimento</option>
                    <option value="Atendido Não Reservado">Atendido</option>
                    <option value="Atendido Reservado">Reservado</option>
                </select>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Nome</th>
                        <th scope="col">CPF</th>
                        <th scope="col">E-mail</th>
                        <th scope="col">Telefone</th>
                        <th scope="col">Status</th>
                        <th class="action" scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody id="report-content">
                    @foreach ($indications as $indication)
                        <tr>
                            <td>{{ $indication->name }}</td>
                            <td>{{ $indication->cpf }}</td>
                            <td>{{ $indication->email }}</td>
                            <td>{{ $indication->phone }}</td>
                            <td>{{ $indication->status }}</td>
                            <td>
                                @if ($indication->status === 'Aguardando Atendimento')
                                    <form
                                        action="{{ route('admin.answered_indication', ['indicationId' => $indication->id]) }}"
                                        method="post">
                                        <button type="submit" class="btn btn-success">Atendido Não Reservado</button>
                                    </form>
                                    <a href="{{ route('admin.indication', ['indicationId' => $indication->id]) }}"
                                        class="btn btn-light">
                                        Atendido Reservado
                                    </a>
                                @endif
                                <form
                                    action="{{ route('admin.destroy_indication', ['indicationId' => $indication->id]) }}"
                                    method="post">
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</div>
