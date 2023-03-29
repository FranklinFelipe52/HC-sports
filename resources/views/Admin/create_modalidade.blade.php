<!DOCTYPE html>
<html lang="en">

<x-head titulo="Modalidades" />

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
        <div class="row justify-content-center align-items-center py-3">
            <div class="col-11 col-md-6 col-lg-4">
                <form method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nome</label>
                        <input type="text" class="form-control @error('nome') is-invalid @enderror" name="nome" value="{{ old('nome') }}" id="exampleFormControlInput1">
                        @error('nome')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Tipo</label>
                        <select class="form-control  @error('sexo') is-invalid @enderror" value="{{ old('sexo') }}" name="type" id="exampleFormControlSelect1">
                            @foreach ($modality_types as $value)
                            <option value="{{$value->id}}">{{$value->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Modo</label>
                        <select class="form-control  @error('mode') is-invalid @enderror" value="{{ old('mode') }}" name="mode" id="exampleFormControlSelect1">
                            <option value="DEFAULT">Padrão</option>
                            <option value="MULTI_CATEGORY">Múltiplas categorias</option>
                            <option value="UNIQUE_CATEGORY">Unica categoria</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Data de referência</label>
                        <input type="date" name="limit_year_date" class="form-control  @error('data_nascimento') is-invalid @enderror" value="{{ old('data_nascimento') }}" id="exampleFormControlInput4">
                        @error('data_nascimento')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class=" d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary px-5">Cadastrar</button>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <x-footer />
</body>

</html>