<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-head titulo="password reset" />

<body>
    <section class="container d-flex flex-column justify-content-center  login ">
        <div class="row justify-content-center align-items-center py-3">
            <div class="col-11 col-md-6 col-lg-4">
                <form method="post" action="/inscricao/password_reset">
                @csrf
                <input type="hidden" name="token_email" value="{{$token_email}}">
                <div class="mb-2">
                    <label for="exampleFormControlInput1" class="form-label">Senha</label>
                    <input type="password" class="form-control" id="exampleFormControlInput2" name="password">
                </div>
                <div class="mb-4">
                    <label for="exampleFormControlInput1" class="form-label">Confirmar senha</label>
                    <input type="password" class="form-control" id="exampleFormControlInput2" name="confirm_password">
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