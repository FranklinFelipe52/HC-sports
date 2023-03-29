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
                <h2>Criar administrador</h2>
            </div>
        </div>
        <div class="row flex-column gap-3">
            <div class="col-6">
                <form method="post" action="/admin/dashboard/administradores/store">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Nome completo</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="nome" aria-describedby="emailHelp">
                        
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cpf" aria-describedby="emailHelp">
                        
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" aria-describedby="emailHelp">
                    </div>
                    @if (Session('admin')->rule->id == 1)
                    <div class="mb-3">
                    <label class="mb-2" for="">filtrar por UF</label>
                    <select class="form-select" name="uf" aria-label="Default select example">
                        @foreach ($federative_units as $federative_unit )
                        <option value="{{$federative_unit->id}}">{{$federative_unit->initials}}</option>
                        @endforeach
                    </select>
                    </div>
                    @endif
                    <div class="mb-3">
                    <label class="mb-2" for="">Papel</label>
                    <select class="form-select" name="rule" aria-label="Default select example">
                        @foreach ($rules as $rule )
                        <option value="{{$rule->id}}">{{$rule->tipo}}</option>
                        @endforeach
                    </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Confirmar senha</label>
                        <input type="password" class="form-control" name="confirm_password" id="exampleInputPassword1">
                    </div>
                    <button type="submit" class="btn btn-primary">Criar</button>
                </form>
            </div>
        </div>


    </section>

    <x-footer />
</body>

</html>