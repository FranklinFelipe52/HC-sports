@extends('Admin.base')

@section('title', 'Dashboard - SEMINÁRIO DE SAÚDE MENTAL E PREVENÇÃO DO SUICÍDIO')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 1]) --}}

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 1])
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('admin')->personification)
        @include('components.admin.personification_nav')
      @endif
      <div class="px-6 h-full w-full grid lg:gap-8 grid-cols-1 lg:grid-cols-6 xl:grid-cols-5 grid-rows-2">
        {{-- <div class="col-span-1 flex flex-col overflow-hidden">
          <header class="pt-8 pb-6">
            <h2 class="text-gray-1 text-lg font-bold font-poppins">
              Última atividade
            </h2>
          </header>
          <p class="text-gray-3 italic">
            Em breve...
          </p>
          <div class="grow overflow-hidden relative flex flex-col scroll-fade">
            <!-- lista de atualizações -->
            <ul class="grow overflow-auto pt-4 pb-8 space-y-6 w-full pr-4">

              <!-- atualização -->
              @foreach ($atualizacoes as $atualizacao)
                <li class="flex flex-wrap gap-4 sm:gap-2 xl:gap-4 items-start pb-6 border-b border-gray-200 hover:bg-fill-base transition w-full">
                  <div class="flex-shrink-0 w-[37px] h-[37px] my-auto overflow-hidden hidden min-[360px]:block">
                    <img src="/images/svg/user-circle.svg" class="w-full h-full object-cover" alt="">
                  </div>
                  <div class="grow space-y-1">
                    <a href="/admin/users/{{ $atualizacao->id }}" class="text-base text-gray-1 font-semibold">{{ $atualizacao->nome_completo }}</a>
                    <p class="text-xs text-gray-1 font-normal">{{ $atualizacao->status }}</p>
                  </div>
                  <div class="flex gap-2.5">
                    <p class="text-xs text-gray-600 font-normal"><?php echo date('d M', strtotime($atualizacao->created_at)); ?></p>
                  </div>
                </li>
              @endforeach
            </ul>
          </div>
        </div> --}}
        <div class="row-span-1 col-span-4 flex flex-col overflow-hidden">
          <header class="pt-8 pb-6">
            <h1 class="text-gray-1 text-lg font-bold font-poppins">
              Resumo
            </h1>
          </header>

          <div class="grid grid-cols-3 gap-4 w-full mb-8">
            <div class="col-span-1 bg-brand-prfA1 rounded-lg p-4 border border-brand-prfA1">
              <p class="text-white text-sm mb-2">Inscrições realizadas</p>
              <p class="text-white text-5xl font-semibold">{{ Count($registrations) }}</p>
            </div>
            <div class="col-span-1 bg-white rounded-lg p-4 border border-gray-5">
              <p class="text-sm mb-2">Pagamentos confirmados</p>
              <p class="text-5xl font-semibold text-feedback-green-1">{{ Count($pagamentos) }}</p>
            </div>
            <div class="col-span-1 bg-white rounded-lg p-4 border border-gray-5">
              <p class="text-sm mb-2">Descontos gerados</p>
              <div class="flex items-end justify-between">
                <p class="text-5xl font-semibold">{{ Count($descontos) }}</p>
                <div>
                  <p class="text-xs">
                    {{ Count($vouchers) }}

                    @if (Count($vouchers) > 1)
                      Vouchers
                    @else
                      Voucher
                    @endif
                  </p>

                  <p class="text-xs">
                    {{ Count($cupoms) }}

                    @if (Count($cupoms) > 1)
                      Cupoms
                    @else
                      Cupom
                    @endif
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- Conteúdo da página -->
    {{-- <div class="order-1 sm:order-2 overflow-hidden">
      <div class="container h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="pt-8 pb-6 space-y-6">
          <h1 class="text-lg text-gray-1 font-poppins font-semibold">
            Resumo
          </h1>
        </header>

        <div class="flex gap-4">
          <p class="text-gray-3 italic">
            {{ Count($registrations) }}
            inscricoes
          </p>

          <p class="text-gray-3 italic">
            {{ Count($pagamentos) }}
            pagamentos
          </p>

          <p class="text-gray-3 italic">
            {{ Count($descontos) }}
            descontos

            {{ Count($vouchers) }} vouchers
            {{ Count($cupoms) }} cupoms
          </p>
        </div>
      </div>
    </div> --}}
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
