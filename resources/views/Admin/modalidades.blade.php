<!DOCTYPE html>
<html lang="en">

<x-head titulo="Modalidades" />

<style>
    .item-modalidade {
        transition-duration: 0.8s;
    }

    .item-modalidade:hover {
        filter: grayscale(80%);
        transform: scale(1.005);
        transition-duration: 0.5s;
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
        <div class="row justify-content-end py-5">
            <div class="col-3 d-flex justify-content-end">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-modalities">
                    Criar modalidade
                </button>
                @include('Modals.create-modalities');
            </div>
        </div>
    </section>
    <section class="container">
        @if (count($modalidades) !== 0)
        <div class="row flex-column gap-3">
            @foreach ($modalidades as $modalidade )
            <div class="col">
                <div class="rounded  border hidden shadow-sm ">
                    <a class="d-flex justify-content-between text-decoration-none item-modalidade text-black bg-light rounded-top py-3 px-5 " data-bs-toggle="collapse" href="#collapseExample-{{$modalidade->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
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
                    <div class="collapse " id="collapseExample-{{$modalidade->id}}">
                        <div class="card rounded-0 border-0 card-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="my-3">Categorias</h4>
                                </div>
                                <div>
                                    @if ($modalidade->mode_modalities->code == 1 && count($modalidade->modalities_categorys) == 1)
                                    <td><button type="button" class="btn btn-primary" disabled data-bs-toggle="modal" data-bs-target="#create-category-{{$modalidade->id}}">
                                            Criar catagoria
                                        </button></td>
                                    @else
                                    <td><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#create-category-{{$modalidade->id}}">
                                            Criar catagoria
                                        </button></td>
                                    @endif
                                </div>

                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>
                                        <th scope="col">Limite feminino</th>
                                        <th scope="col">Limite masculino</th>
                                        <th scope="col">Limite de idade</th>
                                        <th scope="col">Grupo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($modalidade->modalities_categorys as $category)
                                    <tr>
                                        <td>{{$category->titulo}}</td>
                                        <td>{{$category->min_f}}</td>
                                        <td>{{$category->min_m}}</td>
                                        <td>{{$category->min_year}}</td>
                                        <td>{{$category->group_category->tipo}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @include('Modals.create-category', ['modalidade' => $modalidade])
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