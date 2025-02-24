
@extends('User.base')

@section('title', 'Pagamento - pix')

@section('profileClass', 'active')

@section('content')


  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
    @include('components.header');
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('user')->nome_completo == null || Session('user')->nome_completo == 'Nome')
        @include('components.edit_notification')
      @endif
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <div class="container">
            <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2 mb-6">
              <div>
                <a href="/inscricao/src/pages/atleta/dashboard.html" class="text-xs text-gray-1 block hover:underline">
                  Dashboard
                </a>
              </div>
              <img src="/inscricao/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div>
                <a href="/inscricao/src/pages/atleta/pagamento.html" class="text-xs text-gray-1 block hover:underline">
                  Método de pagamento
                </a>
              </div>
              <img src="/inscricao/images/svg/chevron-left-breadcrumb.svg" alt="">
              <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                Código Pix
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Código Pix Gerado!
            </h1>
          </div>
        </header>
        
        <!-- conteúdo -->
        <div class="container w-full">
          <form class="">
            <div class="step w-full max-w-[600px]" id="step1">
              <div class="border border-gray-5 rounded-lg mb-6">
                <div class="flex flex-wrap">
                  <div class="grow p-4 border-b min-[262]:border-b-0 min-[262px]:border-r border-gray-5 text-center">
                    <p class="text-gray-1 font-normal text-sm mb-1">
                      Valor
                    </p>
                    <p class="text-gray-1 font-semibold text-sm">
                      R$ {{$valor}}
                    </p>
                  </div>
                  <div class="grow p-4 text-center border-b min-[262]:border-b-0">
                    <p class="text-gray-1 font-normal text-sm mb-1">
                      Vencimento
                    </p>
                    <p class="text-gray-1 font-semibold text-sm">
                    <?php  echo date("d/m", strtotime($pix['qr_codes'][0]['expiration_date']))?>, <?php  echo date("h:i", strtotime($pix['qr_codes'][0]['expiration_date']))?>
                    </p>
                  </div>
                </div>
                <div class="p-4 py-10">
                  <h2 class="text-gray-1 text-sm font-bold sm:text-center mb-1.5">
                    Pague com Pix
                  </h2>
                  <p class="text-gray-1 text-sm sm:text-center">
                    Use o app do seu banco ou carteira digital para escanear o código QR abaixo:
                  </p>

                  <div class="w-full flex justify-center py-8">
                    <img src="{{$pix['qr_codes'][0]['links'][0]['href']}}" class="w-full h-full max-w-[200px] max-h-[200px]" alt="">
                  </div>


                </div>
              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

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
        onClick: function() {} // Callback after click
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
        onClick: function() {} // Callback after click
      }).showToast();
    }
  </script>
  @endsection
