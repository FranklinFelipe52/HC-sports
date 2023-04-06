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
                        <input  type="text" name="nome" class="form-control  @error('nome') is-invalid @enderror" id="exampleFormControlInput4">
                        @error('nome')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input disabled type="email" class="form-control" value="{{ $token->email }}" name="email" id="exampleFormControlInput1">
                       
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Data de nascimento</label>
                        <input disabled type="date" name="data_nascimento" class="form-control"value="{{ $token->date_nasc }}" id="exampleFormControlInput4">
                        
                    </div>


                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">cpf</label>
                        <input disabled type="text" class="form-control"  value="{{ $token->cpf }}" name="cpf" id="exampleFormControlInput4">
                       
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">sexo</label>
                        <input disabled type="text" class="form-control"  value="{{ $token->sexo }}" name="sexo" id="exampleFormControlInput4">
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">UF</label>
                        <input disabled type="text" class="form-control"  value="{{ $token->uf }}" name="uf" id="exampleFormControlInput4">
                       
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput4" class="form-label">Cidade</label>
                        <input type="text" class="form-control  @error('city') is-invalid @enderror" name="city" id="exampleFormControlInput4">
                        @error('city')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput2" class="form-label">Senha</label>
                        <input type="password" class="form-control" name="password" id="exampleFormControlInput2">
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input  @error('pcd') is-invalid @enderror" type="checkbox" name="pcd" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                            Pcd
                        </label>
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