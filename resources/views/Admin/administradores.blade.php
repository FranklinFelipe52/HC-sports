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
    <header>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container">
                <a class="navbar-brand" href="#">Navbar</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse d-lg-flex justify-content-lg-end" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard/registrations">Inscrições</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard/administradores">Administradores</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/dashboard/modalidade">Modalidades</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/admin/logout">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>
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
                    <a role="button" href="/admin/dashboard/administradores/create" class="btn btn-primary">Criar Administrador</a>
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