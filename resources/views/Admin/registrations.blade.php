<!DOCTYPE html>
<html lang="en">

<x-head titulo="Modalidades" />

<style>
    .item-modalidade {
        transition-duration: 0.8s;
        -webkit-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        -moz-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        box-shadow: -4px 3px 20px -4px rgba(184,178,184,1);

    }

    .item-modalidade:hover {
        filter: grayscale(80%);
        transition-duration: 0.5s;
        -webkit-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        -moz-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        box-shadow: -4px 3px 20px 0px rgba(184,178,184,1);

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
        <div class="row py-5">
            <div class="col">
                <h2>Inscrições</h2>
            </div>
        </div>
        @if (count($modalidades) !== 0)
        <div class="row flex-column gap-3">
            @foreach ($modalidades as $modalidade )
            <div class="col">
                <div class="rounded  border hidden item-modalidade ">
                    <a class="d-flex justify-content-between text-decoration-none  text-black bg-light rounded-top py-3 px-5" href="/admin/dashboard/registrations/{{$modalidade->id}}" role="button">
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Nome</h6>
                            <p class="m-0">{{$modalidade->nome}}</p>
                        </div>
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Modo</h6>
                            <p class="m-0">{{$modalidade->mode_modalities->mode}}</p>
                        </div>
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Tipo</h6>
                            <p class="m-0">{{$modalidade->modalities_type->type}}</p>
                        </div>
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Data de referência</h6>
                            <p class="m-0">{{$modalidade->limit_year_date}}</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach

        </div>

        @else

        <div class="alert alert-danger">
            <p>vazio</p>
        </div>

        @endif

    </section>

    <x-footer />
</body>

</html>