@extends('Admin.base')

@section('title', 'Dashboard - Meia Maratona PRF')

@section('content')

  {{-- @include('components.admin.menu_mobile', ['type' => 1]) --}}

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-full w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.Admin.menu_lateral', ['menuItemActive' => 1])
    </div>

    <!-- Conteúdo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      @if (Session('admin')->personification)
        @include('components.admin.personification_nav')
      @endif
      <div class="px-6 h-full w-full grid lg:gap-8 grid-cols-1 lg:grid-cols-6 xl:grid-cols-5 ">
       
        <div class="col-span-4 flex flex-col ">
          <div class="h-screen">
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
          <div class="pt-8 pb-6">
            <h1 class="text-gray-1 text-lg font-bold font-poppins">
              Distâncias
          </h1>
          </div>
          <div style="height: 420px; max-width: 450px" class="snap-y w-full snap-mandatory overflow-y-scroll">
            @foreach ($categorys as $category )
            <div class="snap-start w-full border border-gray-5 rounded-lg mb-6">
              <div class="flex flex-col gap-1 p-4 sm:px-6 border-b border-gray-5 last:border-b-0">
                <div class="flex justify-between">
                  <div class="">
                    <p class="text-sm text-gray-1 font-semibold">
                        {{$category->nome}}
                    </p>
                </div>
                <div class="">
                    <p class="font-normal break-all">
                      <div
                      class="{{$category->registrations_closed ? 'bg-red-500' : 'bg-feedback-green-1'}} py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                      <p class="text-white text-xs font-bold text-center">
                        {{$category->registrations_closed ? 'Encerrado' : 'Liberado'}}
                      </p>
                  </div>
                    </p>
                </div>
                </div>
                
                <div class="flex justify-center col-span-2 pt-4">
                  <a href="{{route('toogle_closed_admin_get', ['category_id' => $category->id])}}"
                    class="flex items-center justify-center sm:justify-start gap-4 w-full sm:w-fit px-4 py-2.5 rounded-lg border-[1.5px] border-blue-600 hover:ring-2 hover:ring-blue-600 hover:ring-opacity-50 bg-blue-600 transition disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0">
                    <p class="text-white text-sm font-bold font-poppins">
                      {{$category->registrations_closed ? 'Liberar Inscrições' : 'Encerrar Inscrições'}}
                    </p>
                  </a>
                </div>
            </div>
            </div>
            @endforeach
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
