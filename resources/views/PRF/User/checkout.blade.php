@php
  require base_path('vendor/autoload.php');
  MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));
  
  $preference = new MercadoPago\Preference();
  
  // Cria um item na preferência
  $item = new MercadoPago\Item();
  $item->title = $registration['title'];
  $item->quantity = 1;
  $item->unit_price = $registration['price'];
  $preference->items = [$item];
  $preference->back_urls = [
      'success' => config('services.mercadopago.url_base') . '/notification_payment',
      'failure' => config('services.mercadopago.url_base') . '/notification_payment',
      'pending' => config('services.mercadopago.url_base') . '/notification_payment',
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
          @if ($registration['user']->is_servidor_validated == 1)
            <div class="flex gap-4 items-center flex-wrap">
              <h1 class="text-lg text-gray-1 font-poppins font-semibold italic">
                Você está realizando o pagamento da inscrição com o Mercado Pago
              </h1>
            </div>
          @endif
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
                  Distância
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
                      R${{ number_format($registration['price'], 2, ',', '.') }}
                    </p>
                  </div>
                </div>
              </div>
            @endif
          </div>
          <div style="align-items: top" class="flex flex-wrap justify-between">
            <div class="mb-4">
              <a href="/registration/update/{{ $registration['id'] }}" class="text-brand-prfA1 font-bold border-b-2 border-b-brand-prfA1 max-w-[220px]">
                Editar inscrição
              </a>
            </div>
            @if ($registration['status_registration']->id != 2 && $registration['status_registration']->id != 1)

              @if ($registration['user']->is_servidor_validated == 1)
                <div id="wallet_container"></div>
              @else
                <button href="" disabled title="Estamos analisando sua inscrição como servidor da PRF" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0">
                  <p class="text-white text-sm font-bold font-poppins">
                    Inscrição em análise
                  </p>
                </button>
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
