    <!-- Modal -->
    <div class="modal fade" id="create-category-{{$modalidade['modalidade']->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">
                <form method="post" action="/inscricao/cart/{{$modalidade['modalidade']->id}}">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Seleção</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @csrf
                        @if (count($modalidade['modalidade']->modalities_categorys) !== 0)

                        @switch($modalidade['modalidade']->mode_modalities->code)
                        @case(3)
                        <div class="border p-3 mb-3">
                        <h6>Categorias</h6>
                        <select class="form-select" name="category[]" aria-label="Default select example">
                            @foreach ($modalidade['categorias'] as $key => $category )
                            <option value="{{$category->id}}">{{$category->titulo}}</option>
                            @endforeach
                        </select>
                        </div>
                        
                        @if (Count($modalidade['faixas']) != 0)
                        <div class="border p-3 mb-3">
                        <h6>Faixas</h6>
                        <select class="form-select" name="category[]" aria-label="Default select example">
                            @foreach ($modalidade['faixas'] as $key => $range )
                            <option value="{{$range->id}}">{{$range->titulo}}</option>
                            @endforeach
                        </select>
                        </div>
                        @endif
                        
                        @break
                        @case(2)
                        <h6>Categorias</h6>
                        <div class="border rounded p-2">
                            @foreach ($modalidade['modalidade']->modalities_categorys as $category )
                            
                            <div class="form-check">
                                <input class="form-check-input" name="checkbox[]" type="checkbox" value="{{$category->id}}" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                    {{$category->titulo}}
                                </label>
                            </div>
                            @endforeach
                        </div>
                        
                        @break
                        @endswitch
                        @else
                        <div class="alert alert-warning">
                            <p>Não há categorias</p>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Adicionar ao carrinho</button>
                    </div>
                </form>
            </div>
        </div>
    </div>