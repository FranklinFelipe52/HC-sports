@php

            require base_path('vendor/autoload.php');
            MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

            $preference = new MercadoPago\Preference();

            // Cria um item na preferência
            $item = new MercadoPago\Item();
            $item->title = $registration->modalities->nome;
            $item->quantity = 1;
            $item->unit_price = $valor;
            $preference->items = array($item);
            $preference->back_urls = array(
                "success" => config('services.mercadopago.url_base')."/notification_payment",
                "failure" => config('services.mercadopago.url_base')."/notification_payment",
                "pending" => config('services.mercadopago.url_base')."/notification_payment"
            );
            $preference->auto_return = "approved";
            $preference->payment_methods = array(
                "excluded_payment_types" => array(
                  array("id" => "ticket")
                ),
                "installments" => 4
              );
            $preference->external_reference = $registration->id;
            $preference->save();
@endphp


<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Atleta - Pagamento</title>

  <!-- fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700;800&family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- css -->
  <link rel="stylesheet" href="{{asset('/frontend/dist/css/style.css')}}">
</head>

<body class="h-screen">



  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('components.header');
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('user')->nome_completo == null || Session('user')->nome_completo == 'Nome')
        @include('components.edit_notification')
      @endif
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a target="_self" href="{{route('dashboard_user')}}" class="text-xs text-gray-1 block hover:underline">
                Dashboard
              </a>
            </div>
            <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
            <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
              Pagamento
            </div>
          </nav>
          <div class="flex gap-4 items-center flex-wrap">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Você está realizando o pagamento da inscrição com o Mercado Pago
            </h1>
          </div>
        </header>

        <div class="w-full max-w-[700px]">
          <div class="border border-gray-5 rounded-lg mb-6">
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Nome
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->user->nome_completo }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  CPF
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration->user->cpf); ?>
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  E-mail
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->user->email }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Modalidade de interesse
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->modalities->nome }}
                </p>
              </div>
            </div>
            @if ($registration->modalities->mode_modalities->id == 3)
              <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-1 font-semibold">
                    Categoria
                  </p>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-2 font-normal">
                    {{ $registration->modalities_category->nome }}
                  </p>
                </div>
              </div>
              @elseif($registration->modalities->mode_modalities->id == 2)
              <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-1 font-semibold">
                    Categorias
                  </p>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  @foreach ($registration->modalities_categorys as $category)
                  <p class="text-sm text-gray-2 font-normal mb-2">
                    {{$category->nome}}
                  </p>
                  @endforeach

                </div>
              </div>



            @endif
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Pagamento via
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration->type_payment->type }}
                </p>
              </div>
            </div>
            @if ($registration->status_regitration_id != 2)
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Valor
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  R${{ number_format($valor,2,",","."); }}
                </p>
              </div>
            </div>
            @endif
          </div>
          <div class="flex flex-wrap justify-end">

            @if (($registration->status_regitration_id != 2) && ($registration->status_regitration_id != 1))
            @if (!((Session('user')->nome_completo == null) || (Session('user')->nome_completo == 'Nome')))
            <div id="wallet_container"></div>
            @endif
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
  </div>

  <!-- js -->
  <script src="https://sdk.mercadopago.com/js/v2"></script>
  <script>
    const mp = new MercadoPago("{{config('services.mercadopago.key')}}");

      mp.bricks().create("wallet", "wallet_container", {
    initialization: {
        preferenceId: "{{$preference->id}}",

    },
    customization: {
      texts: {
          action: 'pay',
          valueProp: 'security_details',
      },
 },
  });
  </script>
  <script type="module" src="{{asset('/frontend/dist/js/index.js')}}"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    if ('{{ session('erro') }}') {
      showErrorToastfy('{{ session('erro') }}');
    }

    if ('{{ session('success') }}') {
      showSuccessToastfy('{{ session('success') }}');
    }

    function showSuccessToastfy(text) {
      Toastify({
        text: text,
        duration: 3000,
        gravity: "top",
        close: true,
        position: "right",
        style: {
          background: "#EBFBEE",
          color: "#279424",
          boxShadow: "none",
        },
        onClick: function() {}
      }).showToast();
    }

    function showErrorToastfy(text) {
      Toastify({
        text: text,
        duration: 3000,
        gravity: "top",
        close: true,
        position: "right",
        style: {
          background: "#FBDBDB",
          color: "#8E1014",
          boxShadow: "none",
        },
        onClick: function() {}
      }).showToast();
    }
  </script>
</body>

</html>
