<!DOCTYPE html>
<html lang="en">

<x-head titulo="Modalidades" />

<style>
    .item-modalidade {
        transition-duration: 0.8s;
        -webkit-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        -moz-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        box-shadow: -4px 3px 20px -4px rgba(184, 178, 184, 1);

    }

    .item-modalidade:hover {
        filter: grayscale(80%);
        transition-duration: 0.5s;
        -webkit-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        -moz-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        box-shadow: -4px 3px 20px 0px rgba(184, 178, 184, 1);

    }

    .hidden {
        overflow: hidden;
    }
</style>

<body>
    @include('components.admin.header');
    <section class="container">
        @if (Session::has('erro'))
        <div class="alert alert-danger my-2" role="alert">
            {{Session('erro')}}
        </div>
        @endif
        <div class="row pt-5">
            <div class="col">
                <h2>Atletas</h2>
            </div>
        </div>
        <div class="row justify-content-between py-3">
            <div class="col">
                <form class="d-flex align-items-end gap-3">
                    <div class="input-group">
                        <input type="search" class="form-control rounded" name="s" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-outline-primary">search</button>
                    </div>
                </form>
            </div>
            @if (Session('admin')->rule->id == 1)
            <div class="col-2">
                <form class="d-flex align-items-end gap-3">
                    <div>
                        <label class="mb-2" for="">filtrar por UF</label>
                        <select class="form-select" name="uf" aria-label="Default select example">
                            <option value disabled selected>UF</option>
                            @foreach ($federative_units as $federative_unit )
                            <option {{ ( Request::get('uf') && (Request::get('uf') == $federative_unit->id) ) ? 'selected' : '' }} value="{{$federative_unit->id}}">{{$federative_unit->initials}}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>
            @endif
        </div>

        @if (count($atletas) !== 0)
        <div class="row flex-column gap-3">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">CPF</th>
                            <th scope="col">Nome</th>
                            <th scope="col">UF</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($atletas as $atleta )
                        <tr>
                            <td><?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $atleta->cpf);?></td>
                            <td> @if ($atleta->nome_completo == null)
                                -
                            @else
                               {{$atleta->nome_completo}} 
                            @endif</td>
                            <td>{{$atleta->federative_unit_name}}</td>
                            <td><a class="btn btn-primary" href="/inscricao/admin/users/{{$atleta->id}}" role="button">Abrir</a></td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                
                
            </div>
        </div>
        <div class="py-3">
                {{$atletas->appends([
                    's' => request()->get('s', ''),
                    'uf' => request()->get('uf', '')
                    ])->links()}}
        </div>

        @else

        <div class="alert alert-danger my-3">
            <p>vazio</p>
        </div>

        @endif

    </section>

    <x-footer />
</body>

</html>