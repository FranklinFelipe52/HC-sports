
@extends('User.base')

@section('title', 'Pagamento')

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
                <a target="_self" href="/src/pages/atleta/dashboard.html" class="text-xs text-gray-1 block hover:underline">
                  Dashboard
                </a>
              </div>
              <img src="{{asset('/images/svg/chevron-left-breadcrumb.svg')}}" alt="">
              <div aria-current="page" class="text-xs text-brand-a1 font-semibold">
                Método de pagamento
              </div>
            </nav>
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Efetuar Pagamento de Inscrição
            </h1>
          </div>
        </header>

        <!-- conteúdo -->
        <div class="container w-full">
          <form class="">
            <div class="step w-full max-w-[600px]" id="step1">
              <div class="border border-gray-5 p-6 rounded-lg mb-6">
                <p class="text-gray-1 text-sm font-semibold mb-4">
                  Método de pagamento
                </p>
                <div class="pl-4">

                  <div class="flex items-center gap-2 mb-2">
                    <input type="radio" id="radio_input_1" name="example_radio_group" value="radio_input_1" checked>
                    <label for="radio_input_1" class="text-gray-2 flex items-center gap-2">
                      <img src="{{asset('/images/svg/credit-card.svg')}}" alt="">
                      Cartão de Crédito
                    </label>
                  </div>

                  <div class="flex items-center gap-2 mb-2">
                    <input type="radio" id="radio_input_2" name="example_radio_group" value="radio_input_2">
                    <label for="radio_input_2" class="text-gray-2 flex items-center gap-2">
                      <img src="{{asset('/images/svg/pix.svg')}}" alt="">
                      Pix
                    </label>
                  </div>
                </div>
              </div>
              <div class="flex flex-wrap-reverse gap-y-6 justify-between">
                <a target="_self" href="{{route('dashboard_user')}}" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit rounded-lg bg-white transition">
                  <p class="text-gray-1 underline text-sm font-normal font-poppins">
                    Cancelar
                  </p>
                </a>

                <a target="_self" href="/src/pages/atleta/pagamento-cartao.html" class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-brand-a1 hover:ring-2 hover:ring-brand-a1 hover:ring-opacity-50 bg-brand-a1 transition">
                  <p class="text-white text-sm font-bold font-poppins">
                    Avançar
                  </p>
                </a>
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
