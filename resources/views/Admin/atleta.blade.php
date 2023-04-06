<!DOCTYPE html>
<html lang="en">

<x-head titulo="Dashboard" />

<body>
    @include('components.admin.header_tempory');
    <section class="container">
        <div class="row">
            <div class="col">
                <h3>Dados do usuário</h3>
            </div>
        </div>
        <div class="border p-3">
            <div class="mb-3">
                <h6>Nome completo</h6>
                <p>{{$atleta->nome_completo ? $atleta->nome_completo : '-'}}</p>
            </div>
            <div class="mb-3">
                <h6>CPF</h6>
                <p>{{$atleta->cpf }}</p>
            </div>
            <div class="mb-3">
                <h6>Estado</h6>
                <p>{{$atleta->addres->federativeUnit->name}}</p>
            </div>
            <div class="mb-3">
                <h6>Cidade</h6>
                <p>{{$atleta->addres->cidade ? $atleta->addres->cidade : '-'}}</p>
            </div>
            <div class="mb-3">
                <h6>Data de nascimento</h6>
                <p>{{$atleta->data_nasc}}</p>
            </div>
            <div class="mb-3">
                <h6>E-mail</h6>
                <p>{{$atleta->email}}</p>
            </div>
            <div class="mb-3">
                <h6>Deficiencia</h6>
                <p>
                    @if ($atleta->is_pcd)
                    @if ($atleta->is_pcd == true)
                    <span class="badge bg-success">Sim</span>
                    @else
                    <span class="badge bg-info text-dark">Não</span>
                    @endif
                    @else
                   -    
                    @endif
                    
                    
                </p>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <h3>Inscrições</h3>
            </div>
        </div>
        <div class="row">
            @if (count($atleta->registrations) !== 0)
            <div class="col">
                <div class="row">
                    @foreach ($atleta->registrations as $registration)
                    <div class="col-4 p-2">
                        <div class="border rounded p-3">
                            <div class="d-flex justify-content-between">
                                <h5 class="m-0">{{$registration->modalities->nome}}</h5>
                                <span class="badge rounded-pill  @if ($registration->status_regitration->id == 1) bg-success   @elseif ($registration->status_regitration->id == 3) bg-info   @endif text-light">{{$registration->status_regitration->status}}</span>
                            </div>
                            <p>Equipe {{$registration->user->addres->federativeUnit->name}}</p>
                            <div class="d-flex gap-3 pt-3">
                                <a class="btn  btn-outline-secondary" href="#" role="button">Detalhes</a>
                                @if ($registration->status_regitration->id == 1)
                                <a class="btn  btn-outline-secondary" href="/admin/registration/proof/{{$registration->id}}" role="button">Ver comprovante</a>
                                @elseif ($registration->status_regitration->id == 3)
                                <a class="btn  btn-outline-secondary" href="/admin/registration/proof/{{$registration->id}}" role="button">Efetuar pagamento</a>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>


            </div>
            @else
            <div class="alert alert-info" role="alert">
                        Nenhuma inscrição cadastrada
            </div>
            @endif

        </div>
        <h2></h2>


    </section>

    <x-footer />
</body>

</html>