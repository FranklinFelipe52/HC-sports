    <!-- Modal -->
    <div class="modal fade" id="create-category" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">
            <form method="post" action="/inscricao/admin/categoria">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar categoria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" id="exampleFormControlInput1">
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
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </div>
                </form>
            </div>
        </div>
    </div>