<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head titulo="forgot password" />

<body>
    <section class="container d-flex flex-column justify-content-center  login ">
        <div class="row justify-content-center align-items-center py-3">
            <div class="col-11 col-md-6 col-lg-4">
                <form method="post">
                    @csrf
                    <div class="alert alert-primary text-center" role="alert">
                       Por favor digite o seu email. <br/>
                       Enviaremos um email para redefinir sua senha.
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleFormControlInput1" name="email">
                        @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class=" d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary px-5">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

    </section>

    <x-footer />
</body>


</html>