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
      @include('PRF.Components.menu_lateral', ['menuItemActive' => 1]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto pb-8">

        <!-- Cabeçalho -->
        <header class="sm:pt-8 pb-6">
          <div class="bg-brand-prfA1 sm:hidden">
            <a href="/dashboard">
              <img src="/images/PRF/Logo-Meia-PRF.png" class="h-[100px]" alt="">
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
                    @if ($registration['title'] == '5KM' || $registration['title'] == '10KM')
                      <div class="bg-red-500 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                        <p class="text-white text-xs font-bold text-center">
                          Esgotada
                        </p>
                      </div>
                    @else
                      @if ($registration['status_registration']->id == 1)
                        <div class="bg-feedback-green-1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                          <p class="text-white text-xs font-bold text-center">
                            {{ $registration['status_registration']->status }}
                          </p>
                        </div>
                      @elseif ($registration['status_registration']->id == 3)
                        <div class="bg-brand-prfA1 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                          <p class="text-white text-xs font-bold text-center">
                            {{ $registration['status_registration']->status }}
                          </p>
                        </div>
                      @elseif ($registration['status_registration']->id == 4)
                        <div class="bg-feedback-orange py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                          <p class="text-white text-xs font-bold text-center">
                            {{ $registration['status_registration']->status }}
                          </p>
                        </div>
                      @elseif ($registration['status_registration']->id == 5)
                        <div class="bg-red-500 py-0.5 px-2 rounded-full inline-block w-fit h-fit">
                          <p class="text-white text-xs font-bold text-center">
                            {{ $registration['status_registration']->status }}
                          </p>
                        </div>
                      @endif
                    @endif

                  </div>
                  @if ($registration['status_registration']->id != 4 && $registration['status_registration']->id != 5 && $registration['title'] != '5KM' && $registration['title'] != '10KM')
                    <div class="">
                      <p class="@if ($registration['status_registration']->id == 1) text-feedback-green-1 @elseif ($registration['status_registration']->id == 3) text-brand-v1 @endif font-bold text-1.5xl w-full text-end">
                        @if (!$registration['validated_by_admin'])
                          <span class="text-sm">
                            R$
                          </span>
                          <?= number_format($registration['price'], 2, ',', '.') ?>
                        @else
                          <span class="text-sm">
                            Inscrição liberada pelo administrador
                          </span>
                        @endif
                      </p>
                    </div>
                  @endif
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                  <div>
                    <p class="text-xs text-gray-1">
                      Equipe:
                    </p>
                    <p>
                      @if ($registration['equipe'])
                        {{ $registration['equipe'] }}
                      @else
                        -
                      @endif
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
                @if (Count($registration['tshirts']) > 0)
                  <div class="mb-4">
                    <p class="text-xs text-gray-1 mb-2">
                      Campanha beneficiente:
                    </p>
                    @foreach ($registration['tshirts'] as $tshirt)
                      <div class="flex flex-wrap border rounded-md p-4 border-gray-5">
                        <div class="mb-2">
                          <a href="/images/PRF/Camiseta-PRF-2023.png" target="_blank">
                            <img src="/images/PRF/Camiseta-PRF-2023.png" class="h-[100px] w-[100px]" alt="">
                          </a>
                        </div>
                        <div class="text-sm">
                          <p class="font-semibold">
                            {{ $tshirt->nome }}
                          </p>
                          <p class="max-w-[250px]">
                            {{ $tshirt->descricao }}
                          </p>
                        </div>
                      </div>
                    @endforeach
                  </div>
                @endif
                @if ($registration['status_registration']->id != 4 && $registration['status_registration']->id != 5)
                  <div class="mb-4">
                    @if ($registration['vaucher'])
                      <div>
                        <p>{{ $registration['vaucher']->isCupom ? 'Cupom' : 'Vaucher' }}: {{ $registration['vaucher']->code }}</p>
                        <p>Desconto: {{ $registration['vaucher']->desconto * 100 }}%</p>
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
                  @if ($registration['title'] == '5KM' || $registration['title'] == '10KM')
                    <div class="bg-feedback-fill-blue py-4 px-6 rounded-lg mb-4" role="alert">
                      <p class="text-brand-prfA1">
                        A categoria {{ $registration['title'] }} foi esgotada. Você pode editar a sua categoria e se inscrever nas provas de 10km ou 21km.
                      </p>
                    </div>
                    <div class="flex justify-end flex-wrap gap-4">
                      <a href="/registration/update/{{ $registration['id'] }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center gap-2 py-2.5 px-3.5 w-full max-w-[220px]">
                        Edite sua categoria
                      </a>
                    </div>
                  @endif
                  <div class="flex justify-end flex-wrap gap-4">
                    @if ($registration['status_registration']->id != 1 && $registration['title'] != '5KM' && $registration['title'] != '10KM')
                      <a href="/registration/{{ $registration['id'] }}" class="bg-brand-prfA1 hover:ring-opacity-50 rounded-md hover:ring-2 transition-all hover:ring-brand-prfA1 text-sm font-poppins font-medium text-white flex items-center justify-center gap-2 py-2.5 px-3.5 w-full max-w-[220px]">
                        Realizar Pagamento
                        <img src="/images/PRF/svg/credit-card.svg" alt="">
                      </a>
                    @endif
                  </div>
                  @if ($registration['price'] > 0 && $registration['status_registration']->id == 1 && !$registration['validated_by_admin'])
                    <div class="bg-feedback-fill-blue p-4 rounded-lg border border-blue-400 mb-4" role="alert">
                      A confirmação da sua inscrição é o comprovante enviado pelo Mercado Pago informando que o seu pagamento foi aprovado! Confira no seu e-mail.
                    </div>
                  @endif
                @else
                  <hr class="mb-4">
                  <p>
                    <strong>Atenção:</strong> Caso haja algum engano com o status atual de sua inscrição, entre em contato com a administração.
                  </p>
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
