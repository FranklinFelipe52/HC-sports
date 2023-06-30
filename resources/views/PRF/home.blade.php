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
        <div class="row">
            @foreach ($categorys as $category)
            @foreach ($packages as $package )
            <div class="col-4">
                <div class="card m-4" style="width: 18rem;">
                    <div class="card-body">
                      <h5 class="card-title">{{$category->nome}} {{$package->nome}} </h5>
                      <h6 class="card-subtitle mb-2 text-body-secondary">itens inclusos</h6>
                      {!! html_entity_decode($package->descricao) !!}
                      <p>R$ {{ number_format($category->price + $package->price,2,",","."); }}</p>
                      <a href="/PRF/cart/{{$category->id}}/{{$package->id}}" class="card-link">Realizar Inscrição</a>
                    </div>
                  </div>
            </div>
            @endforeach
           
        @endforeach
        </div>
       
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>
</html>