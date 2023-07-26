@extends('PRF.base')

@section('title', 'Dashboard')

@section('homeClass', 'active')

@section('content')

  <style>
    li {
      font-size: 14px;
    }
  </style>
  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral');
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="sm:pt-8 pb-6">
          <div class="bg-brand-prfA1 sm:hidden">
            <a href="/dashboard">
              <img src="/images/PRF/logo-prf.png" alt="">
            </a>
          </div>
          <div class="container mt-6 sm:mt-0">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Inscrições realizadas
            </h1>
          </div>
        </header>


        <div class="container">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach ($registrations as $registration)
              <div class="border border-gray-5 px-3.5 py-4 rounded-lg">
                <div class="flex flex-wrap justify-between border-b border-gray-5 mb-4">
                  <div class="mb-3.5 flex items-center flex-wrap gap-2">
                    <p class="font-semibold text-gray-1 text-base">
                      {{ $registration['title'] }}
                    </p>
                    <div class="@if ($registration['status_registration']->id == 1) bg-feedback-green-1 @elseif ($registration['status_registration']->id == 3) bg-brand-prfA1 @endif  py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                      <p class="text-white text-[0.5rem] font-bold text-center">
                        {{ $registration['status_registration']->status }}
                      </p>
                    </div>
                  </div>
                  <div class="">
                    <p class="@if ($registration['status_registration']->id == 1) text-feedback-green-1 @elseif ($registration['status_registration']->id == 3) text-brand-v1 @endif font-bold text-1.5xl w-full text-end">
                      <span class="text-sm">
                        R$
                      </span>
                      <?= number_format($registration['price'], 2, ',', '.') ?>
                    </p>
                  </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                  <div>
                    <p class="text-xs text-gray-1">
                      Equipe:
                    </p>
                    <p>
                      {{ $registration['equipe'] }}
                    </p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-1">
                      Camiseta:
                    </p>
                    <p>
                      {{ $registration['size_tshirt'] }}
                    </p>
                  </div>
                  <div>
                    <p class="text-xs text-gray-1 mb-2">
                      Itens inclusos:
                    </p>
                    <div class="list__options font-bold text-xs text-gray-1">
                      {!! html_entity_decode($registration['descricao']) !!}
                    </div>
                  </div>
                </div>
                <div class="flex justify-between flex-wrap gap-4">
                  {{-- <a href="/registration/{{ $registration['id'] }}" class="bg-white border border-gray-5 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-gray-5 text-sm font-poppins font-medium text-dark-1 flex items-center justify-center gap-2 py-2.5 px-3.5 w-fit">
                    Detalhes
                    <img src="/images/PRF/svg/chevron-left.svg" alt="">
                  </a> --}}
                  <span></span>
                  @if ($registration['status_registration']->id != 1)
                    <a href="/registration/{{ $registration['id'] }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center gap-2 py-2.5 px-3.5 w-full max-w-[220px]">
                      Realizar Pagamento
                      <img src="/images/PRF/svg/credit-card.svg" alt="">
                    </a>
                  @endif
                  </button>
                </div>
              </div>
            @endforeach
          </div>
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
