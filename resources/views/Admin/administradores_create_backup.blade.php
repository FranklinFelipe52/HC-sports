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
                <h2>Criar administrador</h2>
            </div>
        </div>
        <div class="row flex-column gap-3">
            <div class="col-6">
                <form method="post" action="/inscricao/admin/administradores/store">
                    @csrf
                    <div class="mb-3">
                        <label  class="form-label">Nome completo</label>
                        <input type="text" class="form-control" value="{{ old('nome') }}"  name="nome" aria-describedby="emailHelp">
                        @error('nome')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">CPF</label>
                        <input type="text" class="form-control" value="{{ old('cpf') }}"  name="cpf" aria-describedby="emailHelp">
                        @error('cpf')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label  class="form-label">E-mail</label>
                        <input type="email" class="form-control" value="{{ old('email') }}"  name="email" aria-describedby="emailHelp">
                        @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                   
                    <div class="mb-3">
                    <label class="mb-2" for="">filtrar por UF</label>
                    <select class="form-select" name="uf" aria-label="Default select example">
                        @foreach ($federative_units as $federative_unit )
                        <option value="{{$federative_unit->id}}">{{$federative_unit->initials}}</option>
                        @endforeach
                    </select>
                    @error('uf')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                   
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                        @error('password')<p class="text-danger">{{ $message }}</p>@enderror
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