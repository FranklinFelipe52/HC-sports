<!DOCTYPE html>
<html lang="en">


    <x-head titulo="Dashboard" />


<body>
    @include('components.header');
    <section class="container py-4">
        <div class="row justify-content-end py-4">
            <div class="col-4">
                <form>
                    <div class="input-group">
                        <input type="search" class="form-control rounded" name="s" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-outline-primary">search</button>
                    </div>
                </form>
            </div>
        </div>
        @if (Session::has('message'))
        <div class="alert alert-success" role="alert">
            {{session('message')}}
        </div>
        @endif
        @if (Session::has('erro'))
        <div class="alert alert-danger" role="alert">
            {{Session('erro')}}
        </div>
        @endif

        <div class="row">
            <div class="col">
                @if (count($modalidades) !== 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Modalidade</th>
                            <th scope="col">Tipo</th>
                            
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($modalidades as $value )
                        @if (count($value['categorias']) !== 0)
                        <tr>
                            <td>{{$value['modalidade']->nome}}</td>
                            <td>{{$value['modalidade']->modalities_type->type}}</td>
                            
                            <td>
                                @if ($value['modalidade']->mode_modalities->code == 1)
                                <form action="cart/{{$value['modalidade']->id}}" method="post">
                                    @csrf
                                    <button class="btn btn-primary" type="submit">Adicionar ao carrinho</button>
                                </form>
                                @else
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-category-{{$value['modalidade']->id}}">
                                    Escolher categoria
                                </button>
                                @endif
                            </td>
                        </tr>
                        @include('Modals.create-registration', ['modalidade' => $value])
                        @endif
                        @endforeach
                       
                    </tbody>
                </table>

                @else

                <div class="alert alert-warning">
                    <p>Não há reultados</p>
                </div>
                @endif
            </div>
        </div>
    </section>
    <x-footer />
</body>

</html>