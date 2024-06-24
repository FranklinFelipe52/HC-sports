<!DOCTYPE html>
<html lang="en">
<x-head titulo="login" />

<body>
    <section class="container d-flex flex-column justify-content-center  login ">
        <div class="row justify-content-center align-items-center py-3">
            @if (session('erro'))
            <div class="alert alert-danger">
                {{session('erro') }}
            </div>
            @endif
            <div class="col-11 col-md-6 col-lg-4">
                <form method="post">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="exampleFormControlInput1">
                        @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-2">
                        <label for="exampleFormControlInput1" class="form-label">Senha</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" id="exampleFormControlInput2">
                        @error('password')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="d-flex justify-content-end mb-4">
                        <a target="_self" class="text-decoration-none text-primary" href="{{route(forgot_password_get)}}">
                            esqueceu sua senha?
                        </a>
                    </div>
                    <div class=" d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-5">Login</button>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <x-footer />
</body>

</html>