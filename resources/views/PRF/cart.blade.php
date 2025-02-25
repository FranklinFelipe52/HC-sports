<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
    <div class="container">
        <div class="card m-4" style="width: 18rem;">
            <div class="card-body">
              <h5 class="card-title">Subtotal (3 itens): R$ 220,00</h5>
              <h6 class="card-subtitle mb-2 text-body-secondary">Soma de todos os itens incluídos</h6>
              <button onclick="document.getElementById('TshirtsForm').submit()" class="card-link">Finalizar inscrição</button>
            </div>
          </div>
        <div class="row">
            <h3>Ajude a campanha beneficente</h3>
            <div class="col-12">
                <div class="card m-4" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">{{Session('cart')['category']->nome}} {{Session('cart')['package']->nome}} </h5>
                      <h6 class="card-subtitle mb-2 text-body-secondary">itens inclusos</h6>
                      {!! html_entity_decode(Session('cart')['package']->descricao) !!}
                      <p>R$ {{ number_format(Session('cart')['category']->price + Session('cart')['package']->price,2,",","."); }}</p>
                    </div>
                  </div>

            </div>
            <h3>Ajude a campanha beneficente</h3>
            <div class="col-12 border border-1">
                <div class="d-flex flex-column gap-2">
                    <form id="TshirtsForm" action="/inscricao/PRF/cart/store" method="post">
                    @csrf
                    @foreach ($tshirts as  $tshirt)
                    <div class="card m-4 flex-row p-3 " style="width: 25rem;">
                        <div class="form-check d-flex justify-content-center align-items-center">
                            <input class="form-check-input" type="checkbox" name="tshirts[]" value="{{$tshirt->id}}" id="flexCheckDefault">
                        </div>
                        <div class="card-body">
                          <h5 class="card-title">{{$tshirt->nome}}</h5>
                          <h6 class="card-subtitle mb-2 text-body-secondary">itens incluídos: {{$tshirt->descricao}}</h6>
                          <p>R$ {{ number_format($tshirt->price,2,",","."); }}</p>
                        </div>
                      </div>
                    @endforeach
                </form>
                </div>

            </div>
        </div>
       
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>