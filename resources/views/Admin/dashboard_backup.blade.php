<!DOCTYPE html>
<html lang="en">

<x-head titulo="Dashboard" />

<body>
    @include('components.admin.header');
    <section class="container">
        <div class="row">
            @if (count($modalidades) !== 0)
            <div class="col">
                <h3>Modalidades</h3>
                <div class="row">
                        @foreach ($modalidades as $modalidade )
                        <div class="col-6 p-2">
                        <div class="border rounded p-3">
                            <h5>{{$modalidade->nome}}</h5>
                            <div class="d-flex gap-3 pt-3">
                            <a class="btn  btn-outline-secondary" href="/admin/modalidade/{{$modalidade->id}}" role="button">Ver modalidade</a>
                            <a class="btn  btn-outline-secondary" href="/admin/registration/create/{{$modalidade->id}}" role="button">Adicionar atleta</a>
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