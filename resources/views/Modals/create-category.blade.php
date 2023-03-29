    <!-- Modal -->
    <div class="modal fade" id="create-category-{{$modalidade->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">
            <form method="post" action="/admin/dashboard/categoria">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" value="{{$modalidade->id}}" name="modalidade_id">
                    <div class="mb-3">
                        @if ($modalidade->mode_modalities->code == 1)
                        <label for="exampleFormControlInput1" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" disabled name="nome" value="PADRÃO" id="exampleFormControlInput1">
                        @else
                        <label for="exampleFormControlInput1" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" id="exampleFormControlInput1">
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Limite feminino</label>
                        <input type="number" class="form-control @error('min_f') is-invalid @enderror" name="min_f" value="{{ old('min_f') }}" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Limite masculino</label>
                        <input type="number" class="form-control @error('min_m') is-invalid @enderror" name="min_m" value="{{ old('min_m') }}" id="exampleFormControlInput1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Limite de idade</label>
                        <input type="number" class="form-control @error('limit_year') is-invalid @enderror" name="limit_year" value="{{ old('limit_year') }}" id="exampleFormControlInput1">
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Grupo</label>
                        <select class="form-control  @error('group') is-invalid @enderror" value="{{ old('group') }}" name="group" id="exampleFormControlSelect1">
                            @foreach ($groups as $value)
                            <option value="{{$value->id}}">{{$value->tipo}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
                </form>
            </div>
        </div>
    </div>