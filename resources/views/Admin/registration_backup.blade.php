<!DOCTYPE html>
<html lang="en">

<x-head titulo="Modalidades" />

<style>
    .item-modalidade {
        transition-duration: 0.8s;
        -webkit-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        -moz-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        box-shadow: -4px 3px 20px -4px rgba(184, 178, 184, 1);

    }

    .item-modalidade:hover {
        filter: grayscale(80%);
        transition-duration: 0.5s;
        -webkit-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        -moz-box-shadow: -4px 3px 20px -4px rgba(156, 154, 156, 1);
        box-shadow: -4px 3px 20px 0px rgba(184, 178, 184, 1);

    }

    .hidden {
        overflow: hidden;
    }
</style>

<body>
    @include('components.admin.header');
   

    <section class="container">
        <div class="row mb-4">
            <div class="col">
                <h3 class="d-inline-block me-5">{{$registration->user->nome_completo}} </h3>
                <span class="badge @if ($registration->status_regitration->id == 1) bg-success   @elseif ($registration->status_regitration->id == 3) bg-info   @endif">{{$registration->status_regitration->status}}</span>
            </div>
        </div>
        <div class="border p-3 mb-4">
            <div class="mb-3">
                <h6>CPF</h6>
                <p>{{$registration->user->cpf }}</p>
            </div>
            <div class="mb-3">
                <h6>E-mail</h6>
                <p>{{$registration->user->email}}</p>
            </div>
            <div class="mb-3">
                <h6>Modalidade</h6>
                <p>{{$registration->modalities->nome}}</p>
            </div>
            @if (!($registration->modalities->mode_modalities->id == 1))
            <div class="mb-3">
                <h6>Categoria</h6>
                <p>{{$registration->modalities_category->nome}}</p>
            </div>
            @endif
            <div class="mb-3">
                <h6>Pagamento via</h6>
                <p>{{$registration->type_payment->type}}</p>
            </div>
        </div>
        <div class="row">
        <div class="col d-flex justify-content-between">
            <a class="btn btn-danger" href="#" role="button">Excluir Inscrição</a>
            @if ($registration->status_regitration->id == 3)
            <a class="btn btn-primary" href="#" role="button">Relizar Pagamento</a>
            @endif
            </div>
        </div>

    </section>

    <x-footer />
</body>

</html>