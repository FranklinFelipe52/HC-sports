<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head titulo="register" />

<body>
    <section class="container d-flex flex-column justify-content-center  login ">
        <div class="row justify-content-center align-items-center py-3">
            <div class="col-11 col-md-6 col-lg-4">
                <form method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Nome completo</label>
                        <input type="text" name="nome" class="form-control  @error('nome') is-invalid @enderror" value="{{ old('nome') }}" id="exampleFormControlInput4">
                        @error('nome')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control  @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" id="exampleFormControlInput1">
                        @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Data de nascimento</label>
                        <input type="date" name="data_nascimento" class="form-control  @error('data_nascimento') is-invalid @enderror" value="{{ old('data_nascimento') }}" id="exampleFormControlInput4">
                        @error('data_nascimento')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">cpf</label>
                        <input type="text" class="form-control  @error('cpf') is-invalid @enderror" value="{{ old('cpf') }}" name="cpf" id="exampleFormControlInput4">
                        @error('cpf')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Número da OAB</label>
                        <input type="text" class="form-control  @error('n_oab') is-invalid @enderror" value="{{ old('n_oab') }}" name="n_oab" id="exampleFormControlInput4">
                        @error('n_oab')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">sexo</label>
                        <select class="form-control  @error('sexo') is-invalid @enderror" value="{{ old('sexo') }}" name="sexo" id="exampleFormControlSelect1">
                            <option value="m">M</option>
                            <option value="f">F</option>
                        </select>
                        @error('sexo')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">UF</label>
                        <select class="form-select" name="federative_unit" aria-label="Default select example">
                            @foreach ($federative_units as $federative_unit )
                            <option value="{{$federative_unit->id}}">{{$federative_unit->initials}}</option>
                            @endforeach
                        </select>
                        @error('federative_unit')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Cidade</label>
                        <input type="text" class="form-control  @error('city') is-invalid @enderror" value="{{ old('city') }}" name="city" id="exampleFormControlInput4">
                        @error('city')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput2" class="form-label">Senha</label>
                        <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" id="exampleFormControlInput2">
                        @error('password')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input  @error('pcd') is-invalid @enderror" type="checkbox" value="{{ old('pcd') }}" name="pcd" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Pcd
                        </label>
                        @error('pcd')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class=" d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-5">Register</button>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <x-footer />
</body>


</html>