@extends('PRF.base')

@section('title', 'Inscrição - SEMINÁRIO DE SAÚDE MENTAL E PREVENÇÃO DO SUICÍDIO')

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
      @include('PRF.Components.menu_lateral', ['menuItemActive' => 1]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="sm:pt-8 pb-6">
          <div class="sm:hidden border-b border-gray-5">
            <a href="/dashboard">
              <img src="/images/logo-hc.png" class="h-[100px]" alt="">
            </a>
          </div>
          <div class="container mt-6 sm:mt-0">
            <h1 class="text-lg text-gray-1 font-poppins font-semibold">
              Inscrição - SEMINÁRIO DE SAÚDE MENTAL E PREVENÇÃO DO SUICÍDIO
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
                    @if ($registration['status_registration']->id == 1)
                      <div class="bg-feedback-green-1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                        <p class="text-white text-[0.5rem] font-bold text-center">
                          {{ $registration['status_registration']->status }}
                        </p>
                      </div>
                    @elseif ($registration['status_registration']->id == 2)
                      <div class="bg-brand-prfA1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                        <p class="text-white text-[0.5rem] font-bold text-center">
                          {{ $registration['status_registration']->status }}
                        </p>
                      </div>
                    @elseif ($registration['status_registration']->id == 3)
                      <div class="bg-brand-prfA1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                        <p class="text-white text-[0.5rem] font-bold text-center">
                          {{ $registration['status_registration']->status }}
                        </p>
                      </div>
                    @endif
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
                <div class="flex gap-4 mb-4">
                  @if ($registration['prf_package_id'] == 1 && $registration['status_registration_id'] != 1)
                    <div class="bg-feedback-fill-blue p-4 rounded-lg border border-blue-400" role="alert">
                      <p class="text-sm mb-2">
                        <strong>Atenção:</strong> Até o dia <strong>15 de setembro</strong>, a inscrição do Profissional da Segurança Pública será confirmada mediante a entrega de 02 quilos de alimentos no Quartel do Comando Geral do Corpo de Bombeiros Militar do RN.
                      </p>

                      <p class="text-sm mb-2">
                        Caso prefira, pode fazer a inscrição com o pagamento de R$ 10,00 na modalidade de <strong>”NÃO Profissional da Segurança Pública”</strong>.
                      </p>

                      <p class="text-sm mb-1">
                        <strong>Local da entrega:</strong>
                      </p>

                      <p class="text-sm mb-2">
                        Quartel do Comando Geral do Corpo de Bombeiros - Av. Prudente de Morais, 2410, Barro Vermelho - Natal.
                      </p>

                      <p class="text-sm">
                        <strong>De segunda a sexta feira:</strong> Das 8h às 13h
                      </p>
                      <p class="text-sm">
                        <strong>Maiores informações: </strong> (84) 98129-3618
                      </p>
                    </div>
                  @elseif($registration['status_registration_id'] != 1)
                    <p class="text-gray-1 mb-2 font-bold text-sm">
                      Aguardando pagamento da inscrição
                    </p>
                  @else
                    <img src="/images/seminario-banner.jpg" alt="">
                  @endif
                </div>
                @if ($registration['prf_package_id'] != 1)
                  <div class="mb-4">
                    @if ($registration['vaucher'])
                      <div>
                        <p>{{ $registration['vaucher']->isCupom ? 'Cupom' : 'Vaucher' }}: {{ $registration['vaucher']->code }}</p>
                        <p>Desconto: {{ $registration['vaucher']->desconto * 100 }}%</p>
                        @if ($registration['vaucher']->descricao)
                          {{-- <p>Descricao: {{ $registration['vaucher']->descricao }}</p> --}}
                        @endif
                      </div>
                    @else
                      @if ($registration['status_registration']->id != 1)
                        <form action="/registration/{{ $registration['id'] }}/vouchers/store" method="post" class="flex w-full gap-2">
                          @csrf
                          <input required class="border" type="text" id="name_cupom_field" name="vaucher" placeholder="Adicione um cupom ou voucher" class="grow px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1">
                          <button type="submit" class=" border border-brand-prfA1 rounded-md py-1 px-1.5 text-brand-prfA1 text-sm font-medium">
                            Adicionar
                          </button>
                        </form>
                      @endif
                    @endif
                  </div>

                  <div class="flex justify-end flex-wrap gap-4">
                    @if ($registration['status_registration']->id != 1)
                      <a href="/registration/{{ $registration['id'] }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center gap-2 py-2.5 px-3.5 w-full max-w-[220px]">
                        Realizar Pagamento
                        <img src="/images/PRF/svg/credit-card.svg" alt="">
                      </a>
                    @endif
                    {{-- <div class="bg-feedback-fill-blue py-4 px-6 rounded-lg" role="alert">
                      <p class="text-brand-prfA1">
                        O sistema está passando por manutenção, em breve você poderá realizar o pagamento da inscrição.
                      </p>
                    </div> --}}
                  </div>
                @endif
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/cleave.js/1.6.0/cleave.min.js" integrity="sha512-KaIyHb30iXTXfGyI9cyKFUIRSSuekJt6/vqXtyQKhQP6ozZEGY8nOtRS6fExqE4+RbYHus2yGyYg1BrqxzV6YA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
  <script>
    const code = document.getElementById("name_cupom_field");
    new Cleave('#name_cupom_field', {
      uppercase: true,
      blocks: ['20'],
      onValueChanged: function(e) {
        code.value = e.target.value.replace(/\s/g, '');
      }
    });
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
