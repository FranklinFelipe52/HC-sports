@php
  require base_path('vendor/autoload.php');
  MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

  $preference = new MercadoPago\Preference();

  // Cria um item na preferência
  $item = new MercadoPago\Item();
  $item->title = $registration['title'];
  $item->quantity = 1;
  $item->unit_price = $registration['pricePackage'] + $registration['priceTshirts'];
  $preference->items = [$item];
  $preference->back_urls = [
      'success' => config('services.mercadopago.url_base') . '/PRF/notification_payment',
      'failure' => config('services.mercadopago.url_base') . '/PRF/notification_payment',
      'pending' => config('services.mercadopago.url_base') . '/PRF/notification_payment',
  ];
  $preference->auto_return = 'approved';
  $preference->payment_methods = [
      'excluded_payment_types' => [['id' => 'ticket']],
      'installments' => 4,
  ];
  $preference->external_reference = $registration['id'];
  $preference->save();
@endphp

@extends('PRF.base')

@section('title', 'Home')

@section('content')

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral');
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">

      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
            <div>
              <a href="/dashboard" class="text-xs text-gray-1 block hover:underline">
                Dashboard
              </a>
            </div>
            <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
            <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
              Pagamento
            </div>
          </nav>
          <div class="flex gap-4 items-center flex-wrap">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold italic">
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
                  {{ $registration['user']->nome_completo }}
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
                  <?php echo preg_replace('/^([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{3})([[:digit:]]{2})$/', '$1.$2.$3-$4', $registration['user']->cpf); ?>
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
                  {{ $registration['user']->email }}
                </p>
              </div>
            </div>
            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Pacote
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {!! html_entity_decode($registration['title']) !!}
                </p>
              </div>
            </div>

            <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-1 font-semibold">
                  Categoria
                </p>
              </div>
              <div class="col-span-2 sm:col-span-1">
                <p class="text-sm text-gray-2 font-normal">
                  {{ $registration['category'] }}
                </p>
              </div>
            </div>

            @if ($registration['status_registration']->id != 2)
              <div class="grid grid-cols-2 gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="col-span-2 sm:col-span-1">
                  <p class="text-sm text-gray-1 font-semibold">
                    Valor
                  </p>
                </div>
                <div class="col-span-2 sm:col-span-1">
                  <div class="bg-gray-6 w-fit py-2 px-4 rounded-md">
                    <p class="text-sm text-gray-1 font-bold">
                      R${{ number_format($registration['pricePackage'] + $registration['priceTshirts'], 2, ',', '.') }}
                    </p>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <div style="align-items: center" class="flex flex-wrap justify-between">
            <a href="/registration/update/{{$registration['id']}}"  class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center gap-2 py-4 px-3.5 w-full max-w-[220px]">
              Editar
            </a>
            @if ($registration['status_registration']->id != 2 && $registration['status_registration']->id != 1)
              <div id="wallet_container"></div>
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
    const mp = new MercadoPago("{{ config('services.mercadopago.key') }}");

    mp.bricks().create("wallet", "wallet_container", {
      initialization: {
        preferenceId: "{{ $preference->id }}",

      },
      customization: {
        texts: {
          action: 'pay',
          valueProp: 'security_details',
        },
      },
    });
  </script>
  <script type="module" src="/frontend/dist/js/index.js"></script>
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

    /* const walletContainer = document.querySelector('#wallet_container');
    const mpButton = walletContainer.querySelector('div');
    walletContainer.addEventListener('click', (e) => {
      showSuccessToastfy('Aguarde, estamos salvando seus dados');
      setTimeout(() => {
        mpButton.click();
        console.log(mpButton)
      }, 1500)
    }); */
  </script>

@endsection
