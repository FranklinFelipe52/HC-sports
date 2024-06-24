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
@include('components.admin.header_tempory');
    <section class="container">
    @if (Session::has('erro'))
        <div class="alert alert-danger my-2" role="alert">
            {{Session('erro')}}
        </div>
        @endif
        <div class="row pt-5">
            <div class="col">
                <h2>Administradores</h2>
            </div>
        </div>
        <div class="row justify-content-between py-3">
        @if (Session('admin')->rule->id == 1)
            <div class="col-2">
                <form class="d-flex align-items-end gap-3">
                    <div>
                    <label class="mb-2" for="">filtrar por UF</label>
                    <select class="form-select" name="uf" aria-label="Default select example">
                    <option value disabled selected >UF</option>
                        @foreach ($federative_units as $federative_unit )
                        <option {{ ( Request::get('uf') && (Request::get('uf') == $federative_unit->id) ) ? 'selected' : '' }} value="{{$federative_unit->id}}">{{$federative_unit->initials}}</option>
                        @endforeach
                    </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Filtrar</button>
                </form>
            </div>

            @endif
            @if (!(Session('admin')->rule->id == 3))
            <div class="col-3 d-flex justify-content-end align-items-center">
                    <a target="_self" role="button" href="/admin/administradores/create" class="btn btn-primary">Criar Administrador</a>
            </div>
            @endif
        </div>
        
        @if (count($administradores) !== 0)
        <div class="row flex-column gap-3">
            <div class="col">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Nome</th>
                            <th scope="col">E-mail</th>
                            <th scope="col">UF</th>
                            <th scope="col">Papel</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($administradores as $administrador )
                        <tr>
                            <td>{{$administrador->nome_completo}}</td>
                            <td>{{$administrador->email}}</td>
                            <td>{{$administrador->federativeUnit->initials}}</td>
                            <td>{{$administrador->rule->tipo}}</td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
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