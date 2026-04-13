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
        @if (Session::has('erro'))
        <div class="alert alert-danger my-2" role="alert">
            {{Session('erro')}}
        </div>
        @endif
        <div class="row pt-5">
            <div class="col">
                <h2>Criar inscrição - {{$modalidade->nome}}</h2>
            </div>
        </div>
        <div class="row flex-column gap-3">
            <div class="col-6">
                <form method="post" action="/admin/registration/create/{{$modalidade->id}}">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="cpf" value="{{ old('nome') }}" >
                        @error('cpf')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">E-mail</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" value="{{ old('nome') }}"  >
                        @error('email')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Sexo</label>
                        <select class="form-control  @error('sexo') is-invalid @enderror" name="sexo" id="exampleFormControlSelect1">
                            <option value="M">M</option>
                            <option value="F">F</option>
                        </select>
                    </div>
                    <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">Pagamento via</label>
                        <select class="form-control" name="payment" id="exampleFormControlSelect1">
                        @foreach ($type_payments as $value )
                            <option value="{{$value->id}}">{{$value->type}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Data de nascimento</label>
                        <input type="date" class="form-control" id="exampleInputEmail1" name="date_nasc" value="{{ old('nome') }}" >
                        @error('date_nasc')<p class="text-danger">{{ $message }}</p>@enderror
                    </div>
                        @if (!($modalidade->mode_modalities->id == 1))
                        <div class="border p-3 mb-3">
                        <h6>Categorias</h6>
                        <select class="form-select" name="category" aria-label="Default select example">
                            @foreach ($modalidade->modalities_categorys as $category )
                            <option value="{{$category->id}}">{{$category->nome}}</option>
                            @endforeach
                        </select>
                        </div>
                        @endif
                        @if (Count($modalidade->ranges) != 0)
                        <div class="form-group mb-3">
                        <label for="exampleFormControlSelect1">faixa</label>
                        <select class="form-control" name="range" id="exampleFormControlSelect1">
                        @foreach ($modalidade->ranges as $value )
                            <option value="{{$value->id}}">{{$value->range}}</option>
                            @endforeach
                        </select>
                    </div>
                        @endif
                    <button type="submit" class="btn btn-primary">Criar</button>
                </form>
            </div>
        </div>


    </section>

    <x-footer />
</body>

</html>