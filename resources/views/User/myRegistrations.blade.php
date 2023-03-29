<!DOCTYPE html>
<html lang="en">

<head>
    <x-head titulo="Minhas incrições" />
    <style>
        .item-modalidade {
            transition-duration: 0.8s;
        }

        .item-modalidade:hover {
            transform: scale(1.005);
            transition-duration: 0.5s;
        }

        .hidden {
            overflow: hidden;
        }
    </style>
</head>

<body>
@include('components.header');
    <section class="container py-4">
        <div class="row justify-content-end py-4">
            <div class="col-4">
                <form>
                    <div class="input-group">
                        <input type="search" class="form-control rounded" name="s" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                        <button type="submit" class="btn btn-outline-primary" href="/?s">search</button>
                    </div>
                </form>
            </div>
        </div>

        @if (count($registrations) !== 0)
        <div class="row flex-column gap-3">
            @foreach ($registrations as $registration )
            <div class="col">
                <div class="rounded  border hidden shadow-sm ">
                    <button class="d-flex border-0 w-100 justify-content-between text-decoration-none item-modalidade text-black bg-light rounded-top py-3 px-5 " data-bs-toggle="collapse" href="#collapseExample-{{$registration->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Modalidade</h6>
                            <p class="m-0">{{$registration->modalities->nome}}</p>
                        </div>
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Status</h6>
                            <p class="m-0">{{$registration->status_regitration->status}}</p>
                        </div>
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Pagamento</h6>
                            <p class="m-0">{{$registration->payment->status_payment->status}}</p>
                        </div>
                        <div>
                                    @if ($registration->status_regitration->id == 1)
                                    <a class="btn btn-secondary" disable role="button">Pagar</a>
                                    @else
                                    <a class="btn btn-success" href="/checkout/{{$registration->id}}" role="button">Pagar</a>
                                    @endif
                                </div>
                    </button>
                    @if ($registration->modalities->mode_modalities->code != 1)
                    <div class="collapse px-4 " id="collapseExample-{{$registration->id}}">
                        <div class="card rounded-0 border-0 card-body">

                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="my-3">Categorias</h4>
                                </div>
                            </div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">Nome</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registration->modalities_categorys as $category)
                                    <tr>
                                        <td>{{$category->titulo}}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif
                    
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