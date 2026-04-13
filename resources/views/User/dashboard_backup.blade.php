<!DOCTYPE html>
<html lang="en">

<x-head titulo="Dashboard" />

<body>
    @include('components.header');
    <section class="container">
        <div class="row">
            <div class="col">
                <h3>Suas inscrições</h3>
            </div>
        </div>
        <div class="row">
            @if (count($registrations) !== 0)
            <div class="col">
                <div class="row">
                    @foreach ($registrations as $registration)
                    <div class="col-4 p-2">
                        <div class="border rounded p-3">
                            <div class="mb-3">
                                <div class="d-inline-block me-5">
                                <h5 class="m-0">{{$registration->modalities->nome}}</h5>
                                
                                @if (!($registration->modalities->mode_modalities->id == 2))
                                
                                    <p class="m-0">{{$registration->modalities_category->nome}}</p>
                                
                                @endif
                                </div>
                                
                                <span class="badge rounded-pill  @if ($registration->status_regitration->id == 1) bg-success  @else bg-info @endif text-light">{{$registration->status_regitration->status}}</span>
                            </div>
                            <p>Equipe {{$registration->user->addres->federativeUnit->name}}</p>
                            <div class="d-flex gap-3 pt-3">
                                <a class="btn  btn-outline-secondary" href="#" role="button">Detalhes</a>
                                @if ($registration->status_regitration->id == 1)
                                <a class="btn  btn-outline-secondary" href="/registration/proof/{{$registration->id}}" role="button">Ver comprovante</a>
                                @elseif ($registration->status_regitration->id == 3)
                                <a class="btn  btn-outline-secondary" href="/registration/proof/{{$registration->id}}" role="button">Efetuar pagamento</a>
                                @endif

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