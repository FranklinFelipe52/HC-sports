<!DOCTYPE html>
<html lang="en">

<x-head titulo="Dashboard" />

<body>
  
    <section class="container">
        <div class="row">
            <h3>Modalidades</h3>
            @if (count($modalidades) !== 0)
            <div class="col">
                <div class="row">
                    @foreach ($modalidades as $modalidade)
                    <div class="col-4 p-2">
                        <div class="border rounded p-3">
                            <h5>{{$modalidade['modalidade']->nome}}</h5>
                            <div class="pb-3">
                                <p class="fs-5 fw-bold m-0">
                                    Tipo
                                </p>
                                <span class="badge  @if ($modalidade['modalidade']->modalities_type->id == 1) bg-info  @else bg-primary @endif text-light">{{$modalidade['modalidade']->modalities_type->type}}</span>
                            </div>
                            <div class="pb-3">
                                <p class="fs-5 fw-bold m-0">
                                    Ocupação geral
                                </p>
                                <p>{{Count($modalidade['users'])}} participantes</p>
                            </div>
                            <div class="pb-3">
                            <a target="_self" class="btn  btn-success" href="/admin/modalidade/{{$modalidade['modalidade']->id}}" role="button">Edit</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>
            @endif

        </div>
        <h2></h2>


    </section>

    <x-footer />
</body>

</html>