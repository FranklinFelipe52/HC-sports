    <!-- Modal -->
    <div class="modal fade" id="create-modalities" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">
            <form method="post">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Criar modalidade</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" id="exampleFormControlInput1">
                        @error('nome')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Tipo</label>
                        <select class="form-control  @error('type') is-invalid @enderror" value="{{ old('type') }}" name="type" id="exampleFormControlSelect1">
                            @foreach ($modality_types as $value)
                            <option value="{{$value->id}}">{{$value->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Modo</label>
                        <select class="form-control  @error('mode') is-invalid @enderror" value="{{ old('mode') }}" name="mode" id="exampleFormControlSelect1">
                        @foreach ($mode as $value)
                            <option value="{{$value->code}}">{{$value->mode}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Data de referência</label>
                        <input type="date" name="limit_year_date" class="form-control  @error('limit_year_date') is-invalid @enderror" value="{{ old('limit_year_date') }}" id="exampleFormControlInput4">
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