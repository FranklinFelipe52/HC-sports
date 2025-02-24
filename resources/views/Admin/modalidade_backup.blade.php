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
    
    <section class="container">
        <h1 class="fw-bolder mb-5">{{$modalidade->nome}}</h1>
        <div class="row">
            <div class="col-2">

                <div class="border rounded p-3 mb-4">
                    <div class="border-bottom d-flex justify-content-center pb-3 mb-3">
                        <div style="width: 150px; height: 150px;" class="d-flex justify-content-center align-items-center bg-secondary rounded-circle">
                            <span class="fs-1 text-white">
                                M
                            </span>
                        </div>
                    </div>
                    <div class="pb-3">
                        <p class="fs-5 fw-bold m-0">
                            Tipo
                        </p>
                        <span class="badge  @if ($modalidade->modalities_type->id == 1) bg-info  @else bg-primary @endif text-light">{{$modalidade->modalities_type->type}}</span>
                    </div>
                    <div class="pb-3">
                        <p class="fs-5 fw-bold m-0">
                            Ocupação geral
                        </p>
                        <p>{{Count($users)}} atletas</p>
                    </div>

                </div>
                <div class="d-flex gap-3">
                    <a class="btn  btn-primary w-100 py-3  fw-bold" href="/inscricao/admin/registration/create/{{$modalidade->id}}" role="button">Adicionar atleta</a>
                </div>

            </div>
            <div class="col-10">
                <div class="border rounded p-3 pb-0 mb-4">
                    <h3>Atletas Participantes</h3>
                    @if (Count($users) != 0)
                    @foreach ($users as $user)
                    <div class=" d-flex justify-content-between border-bottom py-3">
                        <div class="content d-flex gap-3">
                            <div class="avatar">
                                <div style="width: 50px; height: 50px;" class="d-flex justify-content-center align-items-center bg-info rounded-circle">
                                    <span class="fs-1 text-white">
                                        T
                                    </span>
                                </div>
                            </div>
                            <div class="text">
                                <h4 class="m-0">
                                @if ($user->nome_completo)
                                {{$user->nome_completo}}
                                @else
                                {{$user->email}}
                                @endif
                                </h4>
                                <p class="m-0">Categorias:
                                    @foreach ( $user->registrations()->where('modalities_id', $modalidade->id)->get() as $registration_category )
                                    {{$registration_category->modalities_category->nome}};
                                    @endforeach
                                </p>
                            </div>
                        </div>
                        <div class="time">
                            <span>1h</span>
                        </div>

                    </div>
                    @endforeach
                    @else
                    <div class="alert alert-info" role="alert">
                        Nenhum usuario inscrito
                    </div>
                    @endif

                </div>
            </div>

        </div>
        <h2></h2>


    </section>

    <x-footer />
</body>

</html>