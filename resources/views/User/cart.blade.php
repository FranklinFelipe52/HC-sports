<!DOCTYPE html>
<html lang="en">
<x-head titulo="Cart" />

<body>
<style>
        .item-modalidade {
            border: 0;
            width: 100%;
        }

        .hidden {
            overflow: hidden;
        }
        .h-100{
            min-height: 80vh;
        }
    </style>
@include('components.header');
<section class="container  py-5">
@if (Session::has('erro'))
        <div class="alert alert-danger" role="alert">
            {{Session('erro')}}
        </div>
        @endif
  @if (count(Session('cart')) !== 0)
        <div class="row gap-3">
            <div class="col d-flex flex-column gap-3">
            @foreach (Session('cart') as $key => $cart_registration)
            <div>
                <div class="rounded  border hidden shadow-sm ">
                    <div class="d-flex align-items-center bg-light py-3 px-5 ">
                    <button class="d-flex justify-content-between item-modalidade text-black bg-light  rounded-top " data-bs-toggle="collapse" data-bs-target="#collapseExample-{{$cart_registration['modalidade']->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                        <div>
                            <h6 class="fs-6 mb-1 fw-bold">Modalidade</h6>
                            <p class="m-0">{{$cart_registration['modalidade']->nome}}</p>
                        </div>
                        
                    </button>
                    <div>
                        <a type="button" href="/cart/delete/{{$key}}" class="btn btn-danger">Excluir</a>
                        </div>
                    </div>
                    @if ($cart_registration['modalidade']->mode_modalities->code != 1)
                    <div class="collapse px-4 " id="collapseExample-{{$cart_registration['modalidade']->id}}">
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
                                    @foreach ($cart_registration['categorys'] as $category)
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
            <div class="col-4">
                <p>Só é permitido a seleção de duas modalidades, podendo ser:</p>
                <ul>
                    <li>2 individuais</li>
                    <li>2 coletivas</li>
                    <li>1 individual e 1 coletiva</li>
                </ul>
            <a class="btn btn-primary" href="/registration" role="button">Inscrever</a>
            </div>
            


        </div>

        @else

        <div class="row h-100  justify-content-center align-items-center">
            <div class="col-4">
                <div class="d-flex flex-column gap-3">
                    <h4>Carrinho vazio? Clique abaixo para explorar modalidades</h4>
                    <a class="btn btn-primary" href="/" role="button">Continuar explorando</a>
                </div>
            </div>
        </div>
        @endif
</section>
<x-footer />
</body>
</html>