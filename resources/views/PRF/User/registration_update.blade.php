@extends('PRF.base')

@section('title', 'Edição de inscrição - Caminhada da Mãe Potiguar')

@section('profileClass', 'active')

@section('content')

  <!-- grid principal -->
  <div class="grid grid-cols-1 sm:grid-cols-main-colapsed lg:grid-cols-main-expanded grid-rows-main-mobile sm:grid-rows-1 h-screen w-full">

    <!-- Menu lateral -->
    <div class="border-t sm:border-t-0 order-2 sm:order-1 relative border-r border-gray-5">
      @include('PRF.Components.menu_lateral', ['menuItemActive' => 1]);
    </div>

    <!-- corpo da página -->
    <div class="order-1 sm:order-2 overflow-hidden">
      <div class="h-full w-full flex flex-col overflow-auto">
        <div class="h-full w-full flex flex-col overflow-auto pb-8">

          <div class="container">
            <!-- Cabeçalho -->
            <header class="pt-8 pb-6 space-y-6">
              <nav aria-label="Breadcrumb" class="flex items-center flex-wrap gap-2">
                <div>
                  <a href="{{ URL::previous() }}" class="text-xs text-gray-1 block hover:underline">
                    Inscrição
                  </a>
                </div>
                <img src="/images/svg/chevron-left-breadcrumb.svg" alt="">
                <div aria-current="page" class="text-xs text-brand-prfA1 font-semibold">
                  Alterar inscrição
                </div>
              </nav>
              <div class="flex gap-4 items-center flex-wrap">
                <h1 class="text-lg text-gray-1 font-poppins font-semibold">
                  Alterar inscrição
                </h1>
              </div>
            </header>
            <!-- conteúdo -->
            <div class="max-w-[700px]">
              <form method="post">
                @csrf
                <div class="border border-gray-5 rounded-lg mb-6 p-4 sm:px-6 pb-6 space-y-6">
                  <div>
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="input_text_exemplo">
                      Equipe
                    </label>
                    <input class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 placeholder:text-gray-3 transition" type="text" id="input_text_exemplo" value="{{ $registration->equipe }}" name="equipe" placeholder="Digite o nome da sua equipe" />
                  </div>
                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_size_tshirt_field">
                      Camiseta
                    </label>
                    <div class="relative">
                      <select required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="size_tshirt" id="inscricao_size_tshirt_field">
                        @foreach ($shirts_sizes as $shirts_size)
                          <option @if ($shirts_size->id == $registration->prf_size_tshirts->id) @selected(true) @endif value="{{ $shirts_size->id }}">{{ $shirts_size->nome }}</option>
                        @endforeach

                      </select>
                      <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                      </div>
                    </div>
                  </div>
                  <div class="mb-6">
                    <label class="text-gray-1 font-semibold text-base inline-block mb-2" for="inscricao_category_field">
                      Distancia
                    </label>
                    <div class="relative">
                      <select data-item="select" required class="disabled:bg-gray-6 disabled:cursor-not-allowed w-full px-4 py-3 rounded-lg bg-white border border-gray-4 focus:border-brand-prfA1 focus:outline-brand-prfA1 text-gray-1 appearance-none transition" name="category" id="inscricao_category_field">
                        @foreach ($categorys as $category)
                            <option @if ($category->id == 1 || $category->id == 2) disabled @endif @if ($category->id == $registration->prf_categorys_id) @selected(true) @endif value={{ $category->id }} data-item-value="{{ $category->price }}">{{ $category->nome }} (R$ {{ number_format($category->price, 2, ',', '.') }})</option>
                        @endforeach
                      </select>
                      <div class="absolute inset-y-0 right-0 flex items-center px-2 pointer-events-none">
                        <img src="/images/PRF/svg/chevron-down.svg" alt="" />
                      </div>
                    </div>
                  </div>
                  <div class="">
                    <p class="text-gray-1 font-semibold text-base inline-block mb-2">
                      Ajude a campanha beneficente
                    </p>
                    <div class="space-y-4">
                      @foreach ($tshirts as $tshirt)
                        <div class="border rounded border-gray-5 px-4 py-2">
                          <div class="py-4 flex gap-4">
                            <div class="flex items-center">
                              <input @foreach ($registration->tshirts as $tshirt_registration)
                            @if ($tshirt_registration->id == $tshirt->id) @checked(true) @endif @endforeach class="prf-checkbox" type="checkbox" name="tshirts[]" value="{{ $tshirt->id }}" data-item="checkbox" data-item-value="{{ $tshirt->price }}" id="flexCheckDefault">
                            </div>
                            <div class="flex flex-col gap-4 md:flex-row">
                              <div>
                                <a href="/images/PRF/Camiseta-PRF-2023.png" target="_blank">
                                  <img src="/images/PRF/Camiseta-PRF-2023.png" class="h-[100px]" alt="">
                                </a>
                              </div>
                              <div class="">
                                <p class="text-gray-1 text-sm">
                                  {{ $tshirt->nome }}
                                </p>
                                <p class="text-dark-1 text-sm font-bold mb-2">
                                  R$ {{ number_format($tshirt->price, 2, ',', '.') }}
                                </p>
                                <p class="text-gray-1 text-xs">
                                  <span class="text-gray-8">Itens inclusos:</span> {{ $tshirt->descricao }}
                                </p>
                              </div>
                            </div>
                          </div>
                        </div>
                        {{-- <div class="card m-4 flex-row p-3 " style="width: 25rem;">
                          <div class="form-check d-flex justify-content-center align-items-center">

                            <input @foreach ($registration->tshirts as $tshirt_registration)
                            @if ($tshirt_registration->id == $tshirt->id) @checked(true) @endif @endforeach class="form-check-input" type="checkbox" name="tshirts[]" value="{{ $tshirt->id }}" id="flexCheckDefault">
                          </div>
                          <div class="card-body">
                            <h5 class="card-title">{{ $tshirt->nome }}</h5>
                            <h6 class="card-subtitle mb-2 text-body-secondary">itens incluídos: {{ $tshirt->descricao }}</h6>
                            <p>R$ {{ number_format($tshirt->price, 2, ',', '.') }}</p>
                          </div>
                        </div> --}}
                      @endforeach
                    </div>
                  </div>
                </div>
                <div class="flex justify-end gap-4 flex-wrap">

                  <div>
                    <p class="text-gray-1">
                      Valor total:
                      <span class="font-bold text-sm text-brand-v2">
                        R$
                        <span id="valorTotal" class="text-xl"></span>
                      </span>
                    </p>
                  </div>

                  <button type="submit" class="flex items-center justify-center gap-4 px-4 py-2.5 rounded border-[1.5px] border-brand-prfA1 hover:ring-2 hover:ring-brand-prfA1 hover:ring-opacity-50 bg-brand-prfA1 disabled:bg-gray-4 disabled:border-gray-4 disabled:hover:ring-0 disabled:cursor-not-allowed transition">
                    <p class="text-white text-sm font-bold font-poppins">
                      Salvar alterações
                    </p>
                  </button>
                </div>
              </form>
            </div>
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

    const valorTotalEl = document.querySelector('#valorTotal');
    let valorCategoria = 0;
    let valorItensAdicionais = 0;
    const valoresArray = Array.from(document.querySelectorAll('[data-item]'));

    valoresArray.forEach(i => {
      i.addEventListener('change', handleValorChange);
      if (i.dataset.item == 'select') {
        const indiceSelecionado = i.selectedIndex;
        const opcaoSelecionada = i.options[indiceSelecionado];
        valorCategoria += Number(opcaoSelecionada.dataset.itemValue);
      } else if (i.dataset.item == 'checkbox') {
        if (i.checked) {
          valorItensAdicionais += Number(i.dataset.itemValue);
        }
      }
    });

    function handleValorChange(event) {
      valorCategoria = 0;
      valorItensAdicionais = 0;
      valoresArray.forEach(i => {
        i.addEventListener('change', handleValorChange);
        if (i.dataset.item == 'select') {
          const indiceSelecionado = i.selectedIndex;
          const opcaoSelecionada = i.options[indiceSelecionado];
          valorCategoria += Number(opcaoSelecionada.dataset.itemValue);
        } else if (i.dataset.item == 'checkbox') {
          if (i.checked) {
            valorItensAdicionais += Number(i.dataset.itemValue);
          }
        }
      });
      updateTotalValue();
    }

    function updateTotalValue() {
      valorTotalDescontado = valorCategoria - (valorCategoria * {{ \App\Helpers\ValorTotal::DescontosTotais($user, $registration) }}) + valorItensAdicionais;

      valorTotalEl.innerText = valorTotalDescontado.toLocaleString('pt-BR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
      });
    }

    updateTotalValue();
  </script>
@endsection
